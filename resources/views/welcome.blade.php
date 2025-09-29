<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Welcome</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite('resources/css/app.css') <
</head>
<body class="bg-gray-100 text-gray-900">
    <nav class="bg-blue-600 p-4 text-white shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ url('/') }}" class="font-bold text-lg">My Blog</a>
            <ul class="flex space-x-6">
                <li><a href="{{ url('/') }}" class="hover:underline">Home</a></li>
                <li><a href="{{ url('/about') }}" class="hover:underline">About</a></li>
                <li><a href="{{ url('/contact') }}" class="hover:underline">Contact</a></li>
                @auth
                    <li><a href="{{ url('/dashboard') }}" class="hover:underline">Dashboard</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="hover:underline">Logout</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}" class="hover:underline">Login</a></li>
                    <li><a href="{{ route('register') }}" class="hover:underline">Register</a></li>
                @endauth
            </ul>
        </div>
    </nav>
    <div class="container mx-auto mt-12 text-center">
        <h1 class="text-4xl font-bold mb-4">Welcome to My Blog</h1>
        <p class="text-lg text-gray-700 mb-6">
            This is your Laravel blog project. You can customize this page in
            <code>resources/views/welcome.blade.php</code>.
        </p>

        @auth
            <a href="{{ url('/app') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                Go to Dashboard
            </a>
        @else
            <a href="{{ route('navbar') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Login
            </a>
            <a href="{{ route('register') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 ml-2">
                Register
            </a>
        @endauth
    </div>
</body>
</html>
