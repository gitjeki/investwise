<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'InvestWise') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
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
                        </ul>
                    </li>
                    <li><a href="{{ route('admin.scores.index') }}" class="flex items-center p-2 rounded-lg hover:bg-green-200 {{ request()->routeIs('admin.scores.*') ? 'active' : '' }}">Data Perhitungan</a></li>
                    <li><a href="#" class="flex items-center p-2 rounded-lg hover:bg-green-200">Data Pengguna</a></li>
                    <li><a href="#" class="flex items-center p-2 rounded-lg hover:bg-green-200">Article</a></li>
                    <li><a href="#" class="flex items-center p-2 rounded-lg hover:bg-green-200">Settings</a></li>
                </ul>
            </nav>
        </aside>

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