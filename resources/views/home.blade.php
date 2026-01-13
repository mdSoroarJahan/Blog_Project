<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    {{-- Navigation --}}
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-gray-800">My Blog</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600">Home</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600">Dashboard</a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-blue-600">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Login</a>
                        <a href="{{ route('register') }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <div class="bg-blue-600 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold mb-4">Welcome to My Blog</h2>
            <p class="text-xl">Discover amazing stories and insights</p>
        </div>
    </div>

    {{-- Posts Section --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h3 class="text-3xl font-bold text-gray-800 mb-8">Latest Posts</h3>

        @if ($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($posts as $post)
                    <div
                        class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        {{-- Featured Image --}}
                        <div class="relative overflow-hidden bg-gray-200 h-56">
                            @if ($post->featured_image)
                                <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}"
                                    class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-300">
                            @else
                                <div
                                    class="w-full h-full bg-gradient-to-br from-gray-300 to-gray-400 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        {{-- Card Content --}}
                        <div class="p-6">
                            {{-- Category Badge --}}
                            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mb-3">
                                {{ $post->category->name }}
                            </span>

                            {{-- Title --}}
                            <h4 class="text-xl font-bold text-gray-800 mb-2 hover:text-blue-600 cursor-pointer">
                                {{ $post->title }}
                            </h4>

                            {{-- Content Preview --}}
                            <p class="text-gray-600 mb-4">
                                {{ Str::limit($post->content, 100) }}
                            </p>

                            {{-- Author & Date --}}
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span>By {{ $post->user->name }}</span>
                                <span>{{ $post->created_at->format('M d, Y') }}</span>
                            </div>

                            {{-- Read More Button --}}
                            <a href="#" class="mt-4 inline-block text-blue-600 hover:text-blue-800 font-semibold">
                                Read More →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-500 text-xl">No posts available yet.</p>
            </div>
        @endif
    </div>

    {{-- Footer --}}
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; {{ date('Y') }} My Blog. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
