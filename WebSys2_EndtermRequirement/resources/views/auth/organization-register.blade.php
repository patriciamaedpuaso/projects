<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Organization Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <h2 class="text-2xl font-bold text-center text-orgBlue mb-6">Register Organization</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm font-semibold">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/org/register') }}" class="space-y-5">
            @csrf

            <!-- Organization Name -->
            <div>
                <label for="organization_name" class="block text-sm font-medium text-gray-700 mb-1">Organization Name</label>
                <input 
                    type="text" 
                    name="organization_name" 
                    id="organization_name" 
                    placeholder="Enter organization name" 
                    required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orgBlue"
                />
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    placeholder="Enter email" 
                    required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orgBlue"
                />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    placeholder="Enter password" 
                    required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orgBlue"
                />
            </div>

            <!-- Contact Number -->
            <div>
                <label for="contact_number" class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                <input 
                    type="text" 
                    name="contact_number" 
                    id="contact_number" 
                    placeholder="Enter contact number (optional)" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orgBlue"
                />
            </div>

            <button type="submit" class="w-full bg-orgBlue text-white py-2 rounded-lg hover:bg-blue-800 transition duration-200 font-semibold">
                Register
            </button>
        </form>

        <p class="mt-4 text-sm text-center text-gray-600">
            Already have an account? 
            <a href="{{ route('org.login') }}" class="text-orgYellow hover:underline font-medium">Login here</a>
        </p>
    </div>

</body>
</html>
