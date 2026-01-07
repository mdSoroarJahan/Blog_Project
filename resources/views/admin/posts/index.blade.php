@extends('admin.layouts.master')
@section('content')
    {{-- Posts --}}
    <section id="posts">
        <div class="flex justify-between">
            <h2 class="text-2xl font-semibold mb-4">Posts</h2>
            <a class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" href="{{ route('posts.create') }}">Create
                Post</a>
        </div>

        {{-- Post Listing Table --}}
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-xl font-semibold mb-4">Post List</h3>
            <table class="min-w-full border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">#</th>
                        <th class="px-4 py-2 border">Title</th>
                        <th class="px-4 py-2 border">Author</th>
                        <th class="px-4 py-2 border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr class="text-gray-700">
                            <td class="px-4 py-2 border">1</td>
                            <td class="px-4 py-2 border">{{ $post->title }}</td>
                            <td class="px-4 py-2 border">Soroar Jahan</td>
                            <td class="px-4 py-2 border space-x-2">
                                <a href="{{ route('posts.edit', $post->id) }}"
                                    class="text-blue-500 hover:underline">Edit</a>
                                <form class="inline-block" action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this post?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
