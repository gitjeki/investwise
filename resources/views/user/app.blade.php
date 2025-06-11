<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>InvestWise</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    {{-- Tailwind CSS CDN (untuk pengembangan cepat) --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <style>
        /* Gaya dasar body - konsisten dengan admin.app */
        body {
            font-family: 'Inter', sans-serif; /* Menggunakan Inter dari Google Fonts */
            background: linear-gradient(to bottom right, #e0ffe0, #d1fae5, #ffffff); /* Gradasi hijau halus */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: #374151; /* Warna teks default */
        }

        /* Navbar - Dibuat FIXED / STICKY */
        .main-navbar {
            background-color: rgba(255, 255, 255, 0.9); /* Putih semi-transparan */
            backdrop-filter: blur(5px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            /* position: fixed; Membuat navbar tetap di posisi saat scroll */
            top: 0;
            left: 0;
            width: 100%;
            z-index: 50; /* Pastikan navbar di atas konten lain */
        }
        .navbar-brand-text {
            font-family: 'Poppins', sans-serif; /* Menggunakan Poppins untuk judul brand */
            font-weight: 700;
            color: #10b981; /* Hijau Tailwind */
        }
        .nav-link-btn {
            font-weight: 600; /* Semibold */
            transition: all 0.2s ease-in-out;
        }

        /* Padding untuk main content agar tidak tertutup navbar fixed */
        main {
            padding-top: 5rem; /* Sesuaikan dengan tinggi navbar, misal 64px = 4rem */
            flex-grow: 1; /* Agar main content mengisi sisa ruang */
        }

        /* Popup Anda (Tidak diubah) */
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

        /* Gaya untuk dropdown yang dikelola JS */
        .dropdown-menu {
            display: none;
        }
        .dropdown-menu.show {
            display: block;
        }
    </style>
</head>
<body class="font-sans">
    <nav class="main-navbar p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <img src="{{ asset('images/logo.png') }}" alt="InvestWise Logo" class="inline-block h-8 w-auto mr-2 align-middle">
                <a href="{{ route('home') }}" class="text-2xl font-bold navbar-brand-text">InvestWise</a>
            </div>
            <div class="flex items-center space-x-6">
                <ul class="flex items-center space-x-4">
                    @guest
                        <li>
                            <a class="nav-link-btn bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-full shadow-md" href="{{ route('login') }}">Login</a>
                        </li>
                        <li>
                            <a class="nav-link-btn border border-green-500 text-green-600 hover:bg-green-500 hover:text-white py-2 px-4 rounded-full transition-colors duration-200" href="{{ route('register') }}">Register</a>
                        </li>
                    @else
                        <li>
                            <a class="nav-link-btn text-gray-700 hover:text-green-600" href="{{ route('home') }}">Home</a>
                        </li>
                        <li>
                            <a class="nav-link-btn text-gray-700 hover:text-green-600" href="{{ route('user.recommendation.intro') }}">Recommendations</a>
                        </li>
                        <li>
                            <a class="nav-link-btn text-gray-700 hover:text-green-600" href="{{ route('articles') }}">Articles</a>
                        </li>
                        <li>
                            {{-- Dropdown untuk Profile --}}
                            {{-- Tambahkan id untuk toggle dan hapus kelas 'group'/'group-hover' jika ingin kontrol JS --}}
                            <div class="relative"> 
                                <a href="#" id="profileDropdownToggle" class="nav-link-btn text-gray-700 hover:text-green-600 flex items-center">
                                    <i class="fas fa-user-circle text-2xl mr-1"></i> {{ Auth::user()->name }} <i class="fas fa-caret-down ml-1 text-xs"></i>
                                </a>
                                {{-- Ganti kelas 'group-hover:opacity-100 group-hover:visible transition-opacity duration-200 invisible' --}}
                                <div id="profileDropdownMenu" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg py-1 z-10 dropdown-menu">
                                    <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                    <a href="{{ route('profile.history') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Calculation History</a>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Logout</button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mx-auto py-8 px-4"> {{-- py-8 / px-4 tetap di main --}}
        @yield('content')
    </main>

    <div id="smartMethodPopup" class="smart-method-popup">
        <div class="smart-method-content">
            <span class="smart-method-close" onclick="closeSmartMethodPopup()">&times;</span>
            <h2 class="text-2xl font-bold mb-4">SMART Method DSS</h2>
            <p class="text-gray-700 text-left">
                SMART (Simple Multi-Attribute Rating Technique) is a decision support system that helps evaluate and rank alternatives based on multiple criteria. It's used to solve multi-criteria decision-making problems, where each alternative is evaluated based on its performance against several attributes, each with a defined weight. The method calculates an overall score for each alternative by summing up the weighted performance scores, allowing for a structured comparison and selection of the best option.
            </p>
        </div>
    </div>

    <script>
        // Scripts untuk Smart Method popup
        function openSmartMethodPopup() {
            document.getElementById('smartMethodPopup').style.display = 'flex';
        }

        function closeSmartMethodPopup() {
            document.getElementById('smartMethodPopup').style.display = 'none';
        }

        // Scripts untuk Dropdown Profil
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('profileDropdownToggle');
            const menu = document.getElementById('profileDropdownMenu');

            if (toggle && menu) {
                // Toggle menu saat tombol diklik
                toggle.addEventListener('click', function(e) {
                    e.preventDefault(); // Mencegah link default
                    menu.classList.toggle('show');
                });

                // Tutup menu saat klik di luar
                document.addEventListener('click', function(e) {
                    if (!toggle.contains(e.target) && !menu.contains(e.target)) {
                        menu.classList.remove('show');
                    }
                });
            }
        });
    </script>
</body>
</html>