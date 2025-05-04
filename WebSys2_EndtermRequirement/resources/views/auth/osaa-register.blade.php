<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OSAA Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        osaaDeepBlue: '#1E3A8A',  /* Deep Blue */
                        osaaBlueGray: '#334155',  /* Blue-Gray */
                        osaaLightGray: '#F3F4F6', /* Light Gray */
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-osaaLightGray flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
        <h2 class="text-3xl font-semibold text-center text-osaaDeepBlue mb-8">OSAA Registration</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm font-semibold">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('osaa.register') }}" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-osaaDeepBlue">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-osaaDeepBlue">
            </div>

            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select name="role" id="role" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-osaaDeepBlue">
                    <option value="">Select a role</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                </select>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" id="password" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-osaaDeepBlue">
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-osaaDeepBlue">
            </div>

            <button type="submit" class="w-full bg-osaaDeepBlue text-white py-2 rounded-lg hover:bg-osaaBlueGray transition duration-200 font-semibold">
                Register
            </button>
        </form>

        <p class="mt-4 text-sm text-center text-gray-600">
            Already have an account? 
            <a href="{{ route('osaa.login') }}" class="text-osaaBlueGray hover:underline font-medium">Log in</a>
        </p>
    </div>

</body>
</html>
