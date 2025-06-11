<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InvestWise</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
    <nav class="bg-white shadow-md p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-2">
                {{-- Ini adalah placeholder untuk logo InvestWise --}}
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

    <main class="container mx-auto py-8 px-4">
        @yield('content')
    </main>

    <div id="smartMethodPopup" class="smart-method-popup">
        <div class="smart-method-content">
            <span class="smart-method-close" onclick="closeSmartMethodPopup()">&times;</span>
            <h2 class="text-2xl font-bold mb-4">Mengenai Metode SMART</h2>
            <p class="text-gray-700 text-left">
                Metode SMART adalah akronim untuk kriteria penetapan tujuan:
                <br><br>
                <strong>S - Specific (Spesifik):</strong> Tujuan harus jelas dan spesifik, tidak umum. Apa yang ingin Anda capai? Siapa yang terlibat? Kapan ini akan terjadi? Di mana ini akan terjadi? Mengapa tujuan ini penting?
                <br><br>
                <strong>M - Measurable (Terukur):</strong> Tujuan harus dapat diukur sehingga Anda dapat melacak kemajuan dan tahu kapan Anda telah mencapai tujuan tersebut. Bagaimana Anda akan tahu jika Anda telah mencapai tujuan?
                <br><br>
                <strong>A - Achievable (Dapat Dicapai):</strong> Tujuan harus realistis dan dapat dicapai. Apakah tujuan ini realistis mengingat sumber daya dan kendala Anda?
                <br><br>
                <strong>R - Relevant (Relevan):</strong> Tujuan harus relevan dengan tujuan dan nilai-nilai Anda secara keseluruhan. Mengapa tujuan ini penting bagi Anda?
                <br><br>
                <strong>T - Time-bound (Berbatas Waktu):</strong> Tujuan harus memiliki batas waktu yang jelas, termasuk tanggal mulai dan tanggal akhir. Kapan Anda akan mencapai tujuan ini?
            </p>
        </div>
    </div>

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