<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>InvestWise</title>

    <!-- Fonts (Standard Laravel way) -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts and CSS via Vite (INI ADALAH PERBAIKANNYA) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom styles for your popup (Tetap di sini) -->
    <style>
        .smart-method-popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .smart-method-content {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 600px;
            text-align: center;
            position: relative;
        }
        .smart-method-close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            cursor: pointer;
        }
    </style>
</head>
<body class="font-sans bg-gray-50">
    <!-- Navbar Anda (Tidak diubah) -->
    <nav class="bg-white shadow-md p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.657 0 3 1.343 3 3v2a3 3 0 01-3 3 3 3 0 01-3-3v-2c0-1.657 1.343-3 3-3z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18c-3.866 0-7-3.134-7-7V9a7 7 0 0114 0v2c0 3.866-3.134 7-7 7z" />
                </svg>
                <a href="{{ route('home') }}" class="text-2xl font-bold text-gray-800">InvestWise</a>
            </div>
            <div class="flex items-center space-x-6">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-green-600 transition duration-300">Home</a>
                <a href="{{ route('user.recommendation.intro') }}" class="text-gray-600 hover:text-green-600 transition duration-300">Recommendations</a>
                <a href="{{ route('articles') }}" class="text-gray-600 hover:text-green-600 transition duration-300">Articles</a>
                <a href="{{ route('profile') }}" class="text-gray-600 hover:text-green-600 transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </a>
            </div>
        </div>
    </nav>

    <!-- Main content area -->
    <main class="container mx-auto py-8 px-4">
        @yield('content')
    </main>

    <!-- Popup Anda (Tidak diubah) -->
    <div id="smartMethodPopup" class="smart-method-popup">
        <div class="smart-method-content">
            <span class="smart-method-close" onclick="closeSmartMethodPopup()">&times;</span>
            <h2 class="text-2xl font-bold mb-4">SMART Method DSS</h2>
            <p class="text-gray-700 text-left">
               SMART (Simple Multi-Attribute Rating Technique) is a decision support system that helps evaluate and rank alternatives based on multiple criteria. It's used to solve multi-criteria decision-making problems, where each alternative is evaluated based on its performance against several attributes, each with a defined weight. The method calculates an overall score for each alternative by summing up the weighted performance scores, allowing for a structured comparison and selection of the best option. 
            </p>
        </div>
    </div>

    <!-- Script Anda (Tidak diubah) -->
    <script>
        function openSmartMethodPopup() {
            document.getElementById('smartMethodPopup').style.display = 'flex';
        }

        function closeSmartMethodPopup() {
            document.getElementById('smartMethodPopup').style.display = 'none';
        }
    </script>
</body>
</html>
