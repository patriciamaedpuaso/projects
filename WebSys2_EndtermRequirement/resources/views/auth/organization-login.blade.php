<!-- Organization Login Form Using Email -->
<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organization Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        orgBlue: '#1E3A8A',
                        orgYellow: '#FACC15',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold text-center text-orgBlue mb-6">Organization Login</h2>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm font-semibold">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('org.login') }}" class="space-y-5">
            @csrf

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    placeholder="Enter your email" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orgBlue"
                />
                @error('email')
                    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    placeholder="Enter your password" 
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orgBlue"
                />
                @error('password')
                    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="w-full bg-orgBlue text-white py-2 rounded-lg hover:bg-blue-800 transition duration-200 font-semibold">
                Login
            </button>
        </form>

        <p class="mt-4 text-sm text-center text-gray-600">
            Don't have an account? 
            <a href="{{ route('org.register') }}" class="text-orgYellow hover:underline font-medium">Register here</a>
        </p>
    </div>

</body>
</html>
