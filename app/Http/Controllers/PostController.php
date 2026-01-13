<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display posts on home page.
     */
    public function home()
    {
        $posts = Post::with('category', 'user')->latest()->get();
        return view('home', compact('posts'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $posts = Post::where('user_id', $user_id)->paginate(3);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3|unique:posts,title',
            'content' => 'required|string',
            'category' => 'required|exists:categories,id',
            'user_id' => 'required',
            'featured_image' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg'
        ]);

        // handle Image Upload
        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $imageName = time() . '_' . 'myapp' . '_' . $image->getClientOriginalName();
            $imagePath = 'uploads/' . $imageName;
            $image->move(public_path('uploads'), $imageName);
        }

        // Create Post
        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category,
            'user_id' => $request->user_id,
            'featured_image' => $imagePath
        ]);
        return redirect()->route('posts.index')->with('success', 'Post created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post  = Post::findOrFail($id);
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);
        // Validate
        $request->validate([
            'title' => 'required|min:3|unique:posts,title,'  . $post->id,
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'user_id'  => 'required',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg'
        ]);

        // File Upload Handling
        if ($request->hasFile('featured_image')) {
            // Delete Previous Image
            if ($post->featured_image && file_exists(public_path($post->featured_image))) {
                unlink(public_path($post->featured_image));
            }

            // Handel Newly Uploaded Image
            $image = $request->file('featured_image');
            $imageName  = time() . '_' . 'myapp' . '_' . $image->getClientOriginalName();
            $imagePath = 'uploads/' . $imageName;
            $image->move(public_path('uploads'), $imageName);
        }

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'user_id' => $request->user_id,
            'featured_image' => $imagePath
        ]);

        return redirect()->route('posts.index')->with('success', 'post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        // If Post has image delete it
        // Delete Previous Image
        if ($post->featured_image && file_exists(public_path($post->featured_image))) {
            unlink(public_path($post->featured_image));
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully');
    }
}
