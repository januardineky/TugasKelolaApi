<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1a202c; /* Dark background */
        }
    </style>
</head>
<body>
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-md p-8 space-y-8 bg-gray-800 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-center text-white">Login</h2>
            <form method="POST" action="">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                    <input id="email" name="email" type="email" required autofocus class="block w-full mt-1 p-2 border border-gray-600 rounded-md bg-gray-700 text-white placeholder-gray-400 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
                    <input id="password" name="password" type="password" required class="block w-full mt-1 p-2 border border-gray-600 rounded-md bg-gray-700 text-white placeholder-gray-400 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                </div>
                <div>
                    <input type="submit" class="w-full py-2 mt-4 font-semibold text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"></input>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
