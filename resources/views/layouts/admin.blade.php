<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'InvestWise') }}</title>

    <!-- Fonts - Menggunakan Inter dari Google Fonts untuk tampilan modern -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN (untuk pengembangan cepat) -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <style>
        /* Gaya dasar untuk body, konsisten dengan front-end */
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to bottom right, #e0ffe0, #d1fae5, #ffffff);
            min-height: 100vh;
            display: flex; /* Mengaktifkan flexbox untuk layout utama */
            flex-direction: column; /* Kolom utama untuk sticky footer */
        }

        /* Layout Utama - untuk menangani sidebar dan main content */
        .admin-layout-wrapper {
            display: flex;
            flex-grow: 1; /* Agar wrapper mengisi sisa ruang vertikal */
        }

        /* Sidebar Styling */
        .admin-sidebar {
            width: 16rem; /* 256px - Lebar default sidebar */
            flex-shrink: 0; /* Mencegah sidebar menyusut */
            background-color: #ffffff; /* Latar belakang putih */
            color: #374151; /* Warna teks abu-abu gelap */
            padding: 1.5rem; /* p-6 */
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); /* Bayangan yang lebih lembut */
            border-right: 1px solid #e5e7eb; /* Border kanan tipis */
            position: fixed; /* Membuat sidebar tetap */
            height: 100vh; /* Tinggi penuh viewport */
            overflow-y: auto; /* Memungkinkan scroll jika konten sidebar panjang */
            transition: transform 0.3s ease-in-out; /* Transisi untuk mobile toggle */
            transform: translateX(0); /* Default terlihat di desktop */
            z-index: 50; /* Di atas konten lain di mobile */
        }

        /* Responsif: Sembunyikan sidebar di mobile secara default */
        @media (max-width: 767px) { /* md breakpoint */
            .admin-sidebar {
                transform: translateX(-100%); /* Sembunyikan di luar layar */
            }
            .admin-sidebar.show {
                transform: translateX(0); /* Tampilkan saat toggle */
            }
            .main-content {
                margin-left: 0; /* Hapus margin kiri di mobile */
            }
        }

        /* Main Content Styling */
        .main-content {
            flex-grow: 1; /* Agar konten utama mengisi sisa ruang horizontal */
            margin-left: 16rem; /* Margin kiri selebar sidebar */
            padding: 2rem; /* p-8 */
            transition: margin-left 0.3s ease-in-out; /* Transisi untuk responsif */
        }

        /* Navbar Toggle untuk Mobile */
        .mobile-menu-button {
            display: none; /* Sembunyikan di desktop */
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 60; /* Di atas sidebar mobile */
            background-color: #ffffff;
            padding: 0.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        @media (max-width: 767px) {
            .mobile-menu-button {
                display: block; /* Tampilkan di mobile */
            }
        }


        /* Navigasi Sidebar */
        .sidebar-nav ul {
            list-style: none; /* Hapus bullet default */
            padding: 0;
        }
        .sidebar-nav a {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem; /* py-3 px-4 */
            border-radius: 0.5rem; /* rounded-lg */
            color: #4b5563; /* Warna teks default */
            transition: all 0.2s ease-in-out; /* Transisi untuk hover */
            font-weight: 500; /* Medium font-weight */
        }
        .sidebar-nav a:hover {
            background-color: #d1fae5; /* green-100 saat hover */
            color: #10b981; /* green-500 saat hover */
        }
        .sidebar-nav a.active {
            background-color: #10b981; /* green-500 saat aktif */
            color: white;
            font-weight: 600; /* Semibold saat aktif */
        }
        .sidebar-nav a.active:hover {
            background-color: #059669; /* green-600 saat aktif dan hover */
        }

        /* Submenu Styling */
        .submenu {
            display: none; /* Sembunyikan secara default */
            padding-left: 1rem; /* Indentasi submenu */
            font-size: 0.9rem; /* Teks lebih kecil */
        }
        .submenu.show {
            display: block;
        }
        .submenu li a {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        /* Icon Styling */
        .sidebar-nav .icon {
            margin-right: 0.75rem; /* mr-3 */
            width: 1.25rem; /* w-5 */
            height: 1.25rem; /* h-5 */
        }
    </style>
</head>
<body class="font-sans antialiased">
    <!-- Tombol untuk membuka/menutup sidebar di mobile -->
    <button id="mobileMenuButton" class="mobile-menu-button">
        <i class="fas fa-bars text-xl text-gray-700"></i>
    </button>

    <div class="admin-layout-wrapper">
        <!-- ========== SIDEBAR ========== -->
        <aside id="adminSidebar" class="admin-sidebar md:translate-x-0">
            <div class="mb-10 text-3xl font-extrabold text-gray-800 text-center">
                InvestWise <span class="text-green-600">Admin</span>
            </div>
            <nav class="sidebar-nav">
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" 
                           class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                           <i class="fas fa-tachometer-alt icon"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="#" id="masterDataToggle" 
                           class="justify-between {{ request()->routeIs('admin.criterias.*') || request()->routeIs('admin.investment-instruments.*') || request()->routeIs('admin.calculation-histories.*') ? 'active' : '' }}">
                            <span><i class="fas fa-database icon"></i>Master Data</span>
                            <span class="ml-auto transform transition-transform duration-200" id="masterDataArrow"><i class="fas fa-chevron-right text-xs"></i></span>
                        </a>
                        <ul class="submenu space-y-2" id="masterDataSubmenu">
                            <li>
                                <a href="{{ route('admin.investment-instruments.index') }}" 
                                   class="{{ request()->routeIs('admin.investment-instruments.*') ? 'active' : '' }}">
                                   <i class="fas fa-briefcase icon"></i> Manage Instruments
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.criterias.index') }}" 
                                   class="{{ request()->routeIs('admin.criterias.*') ? 'active' : '' }}">
                                   <i class="fas fa-sliders-h icon"></i> Manage Criterias
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.calculation-histories.index') }}" 
                                   class="{{ request()->routeIs('admin.calculation-histories.*') ? 'active' : '' }}">
                                   <i class="fas fa-history icon"></i> Calculation Histories
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="{{ route('admin.articles.index') }}" 
                           class="{{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                           <i class="fas fa-newspaper icon"></i> Articles
                        </a>
                    </li>
                                        <li>
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            {{-- Ubah class tombol logout di sini --}}
                            @csrf
                            <button type="submit" class="w-full flex items-center p-2 rounded-lg text-left bg-red-600 hover:bg-red-700 text-white font-semibold transition-all duration-200">
                                <i class="fas fa-sign-out-alt icon"></i> Log Out
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- ========== MAIN CONTENT ========== -->
        <main id="mainContent" class="main-content">
            @yield('content')
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const masterDataToggle = document.getElementById('masterDataToggle');
            const masterDataSubmenu = document.getElementById('masterDataSubmenu');
            const masterDataArrow = document.getElementById('masterDataArrow');
            const mobileMenuButton = document.getElementById('mobileMenuButton');
            const adminSidebar = document.getElementById('adminSidebar');
            const mainContent = document.getElementById('mainContent');

            // Toggle submenu Master Data
            if (masterDataToggle) {
                masterDataToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    masterDataSubmenu.classList.toggle('show');
                    masterDataArrow.classList.toggle('rotate-90'); // Rotasi panah
                });
                // Buka submenu jika ada item aktif di dalamnya saat dimuat
                if (masterDataSubmenu.querySelector('a.active')) {
                    masterDataSubmenu.classList.add('show');
                    masterDataArrow.classList.add('rotate-90');
                }
            }

            // Toggle sidebar di mobile
            if (mobileMenuButton) {
                mobileMenuButton.addEventListener('click', function() {
                    adminSidebar.classList.toggle('show');
                    // Tambahkan overlay saat sidebar terbuka di mobile (opsional)
                    if (adminSidebar.classList.contains('show')) {
                        const overlay = document.createElement('div');
                        overlay.id = 'sidebar-overlay';
                        overlay.classList.add('fixed', 'inset-0', 'bg-black', 'bg-opacity-50', 'z-40');
                        overlay.onclick = function() {
                            adminSidebar.classList.remove('show');
                            this.remove();
                        };
                        document.body.appendChild(overlay);
                    } else {
                        document.getElementById('sidebar-overlay')?.remove();
                    }
                });
            }

            // Atur margin-left untuk main-content sesuai lebar sidebar
            function setMainContentMargin() {
                if (window.innerWidth >= 768) { // md breakpoint
                    mainContent.style.marginLeft = adminSidebar.offsetWidth + 'px';
                } else {
                    mainContent.style.marginLeft = '0';
                }
            }

            // Panggil saat load dan resize
            setMainContentMargin();
            window.addEventListener('resize', setMainContentMargin);
        });
    </script>
</body>
</html>