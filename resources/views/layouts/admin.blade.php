<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'InvestWise') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts and CSS via Vite (INI ADALAH PERBAIKANNYA) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Kita masih butuh ini untuk style spesifik sidebar */
        .sidebar-nav a.active {
            background-color: #4CAF50; /* Warna hijau tua saat aktif */
            color: white;
        }
        .submenu { display: none; }
        .submenu.show { display: block; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="flex">
        <!-- ========== SIDEBAR ========== -->
        <aside class="w-64 min-h-screen bg-green-100 text-gray-800 p-4 fixed">
            <div class="mb-8 text-2xl font-bold">InvestWise Admin</div>
            <nav class="sidebar-nav">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 rounded-lg hover:bg-green-200 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
                    </li>
                    <li>
                        <a href="#" id="masterDataToggle" class="flex items-center justify-between w-full p-2 rounded-lg hover:bg-green-200 {{ request()->routeIs('admin.criterias.*') || request()->routeIs('admin.sub-criterias.*') || request()->routeIs('admin.investment-instruments.*') ? 'active' : '' }}">
                            <span>Master Data</span>
                            <span>></span>
                        </a>
                        <ul class="submenu pl-4 mt-2 space-y-2" id="masterDataSubmenu">
                            <li><a href="{{ route('admin.investment-instruments.index') }}" class="block p-2 rounded-lg hover:bg-green-200 {{ request()->routeIs('admin.investment-instruments.*') ? 'active' : '' }}">Data Instrument</a></li>
                            <li><a href="{{ route('admin.criterias.index') }}" class="block p-2 rounded-lg hover:bg-green-200 {{ request()->routeIs('admin.criterias.*') ? 'active' : '' }}">Data Kriteria</a></li>
                            <li><a href="{{ route('admin.sub-criterias.index') }}" class="block p-2 rounded-lg hover:bg-green-200 {{ request()->routeIs('admin.sub-criterias.*') ? 'active' : '' }}">Data Sub Kriteria</a></li>
                            <li><a href="{{ route('admin.scores.index') }}" class="flex items-center p-2 rounded-lg hover:bg-green-200 {{ request()->routeIs('admin.scores.*') ? 'active' : '' }}">Data Perhitungan</a></li>
                        </ul>
                    </li>
                    <li><a href="#" class="flex items-center p-2 rounded-lg hover:bg-green-200">Data Pengguna</a></li>
                    <li><a href="{{ route('admin.articles.index') }}" class="flex items-center p-2 rounded-lg hover:bg-green-200 {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">Article</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center p-2 rounded-lg text-left text-gray-800 hover:bg-green-200">
                    Log Out
                </button>
            </form>
        </li>
                </ul>
            </nav>
        </aside>

        <!-- ========== MAIN CONTENT ========== -->
        <main class="ml-64 p-8 w-full">
            @yield('content')
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('masterDataToggle');
            const submenu = document.getElementById('masterDataSubmenu');
            if (toggle) {
                toggle.addEventListener('click', e => { e.preventDefault(); submenu.classList.toggle('show'); });
                if (document.querySelector('.submenu a.active')) { submenu.classList.add('show'); }
            }
        });
    </script>
</body>
</html>
