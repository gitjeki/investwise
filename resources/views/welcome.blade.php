<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>InvestWise - Your Smart Investment Partner</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        /* Gaya dasar body - konsisten dengan user.app/admin.app */
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to bottom right, #e0ffe0, #d1fae5, #ffffff); /* Gradasi hijau halus */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: #374151; /* Warna teks default */
        }

        /* Navbar */
        .main-navbar {
            background-color: rgba(255, 255, 255, 0.9); /* Putih semi-transparan */
            backdrop-filter: blur(5px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .navbar-brand-text {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            color: #10b981; /* Hijau Tailwind */
        }
        .nav-link-btn {
            font-weight: 600; /* Semibold */
            transition: all 0.2s ease-in-out;
        }

        /* Hero Section */
        .hero-section {
            padding: 5rem 0; /* py-20 */
            text-align: center;
            background: url('{{ asset('images/investment_background.png') }}') no-repeat center center; /* Ganti dengan gambar investasi Anda */
            background-size: cover;
            color: #fff;
            position: relative;
            overflow: hidden;
        }
        .hero-overlay {
            background-color: rgba(0, 0, 0, 0.5);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        .hero-content {
            position: relative;
            z-index: 2;
        }
        .hero-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
        }

        /* Feature Item */
        .feature-item {
            text-align: center;
            padding: 2rem; /* p-8 */
            border-radius: 0.75rem; /* rounded-lg */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background-color: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06); /* shadow-md */
            border: 1px solid #e5e7eb; /* border-gray-200 */
        }
        .feature-item:hover {
            transform: translateY(-0.5rem); /* -translate-y-2 */
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); /* shadow-lg */
        }
        .feature-item i {
            font-size: 3rem;
            color: #10b981; /* green-500 */
            margin-bottom: 1.25rem; /* mb-5 */
        }

        /* Footer */
        .main-footer {
            background-color: #1f2937; /* gray-800 */
            color: #ffffff;
            padding: 2rem 0; /* py-8 */
            text-align: center;
            margin-top: auto;
        }

        /* Animations */
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-down { animation: fadeInDown 1s ease-out forwards; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up { 
            animation: fadeInUp 1s ease-out forwards; 
            animation-delay: 0.5s; 
            opacity: 0; 
        }

        @keyframes zoomIn {
            from { opacity: 0; transform: scale(0.8); }
            to { opacity: 1; transform: scale(1); }
        }
        .animate-zoom-in { 
            animation: zoomIn 0.8s ease-out forwards; 
            animation-delay: 0.8s; 
            opacity: 0; 
        }

        .animated-icon {
            animation: bounce 2s infinite ease-in-out;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
    </style>
</head>
<body>

    {{-- Navbar --}}
    <nav class="main-navbar p-4 fixed w-full top-0 z-10">
        <div class="container mx-auto flex justify-between items-center">
            <a class="text-2xl font-bold navbar-brand-text" href="/">
                {{-- Logo InvestWise --}}
                <img src="{{ asset('images/logo.png') }}" alt="InvestWise Logo" class="inline-block h-8 w-auto mr-2 align-middle">
                InvestWise
            </a>
            <div class="flex items-center space-x-4">
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
                            <form action="{{ route('logout') }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="nav-link-btn bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-full shadow-md">Logout</button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class="flex-grow pt-20"> {{-- pt-20 untuk jarak dari fixed navbar --}}
        <section class="hero-section">
            <div class="hero-overlay"></div>
            <div class="container mx-auto hero-content">
                <h1 class="text-4xl md:text-5xl lg:text-6xl hero-title mb-4 animate-fade-in-down">Temukan Investasi Ideal Anda dengan Mudah!</h1>
                <p class="text-lg md:text-xl mt-4 max-w-3xl mx-auto animate-fade-in-up">Sistem Pendukung Keputusan kami akan membantu Anda memilih instrumen investasi yang paling sesuai dengan profil, tujuan, dan toleransi risiko Anda.</p>
                <div class="mt-8 animate-zoom-in">
                    <a href="{{ route('register') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-full shadow-lg transition duration-300 ease-in-out transform hover:scale-105 mr-3">Mulai Sekarang</a>
                    <a href="#about" class="inline-block border border-white text-white font-bold py-3 px-8 rounded-full hover:bg-white hover:text-gray-800 transition-colors duration-300">Pelajari Lebih Lanjut</a>
                </div>
            </div>
        </section>

        <section id="about" class="bg-gray-50 py-16">
            <div class="container mx-auto text-center px-4">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-8 animate-fade-in-down">Tentang InvestWise</h2>
                <p class="text-lg text-gray-600 max-w-4xl mx-auto animate-fade-in-up">
                    Di era digital ini, banyaknya pilihan instrumen investasi seringkali membuat investor pemula bingung.
                    Website ini hadir sebagai Sistem Pendukung Keputusan (SPK) yang menggunakan metode Simple Multi Attribute Rating Technique (SMART) 
                    untuk memberikan rekomendasi instrumen investasi terbaik berdasarkan kriteria pribadi Anda.
                </p>
            </div>
        </section>

        <section class="bg-white py-16">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-12 text-center animate-fade-in-down">Fitur Utama Kami</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="feature-item animate-fade-in-up">
                        <i class="fas fa-chart-line animated-icon"></i>
                        <h4 class="text-xl font-bold text-gray-800 mb-3">Rekomendasi Cerdas</h4>
                        <p class="text-gray-600 text-base">Dapatkan rekomendasi instrumen investasi (Deposito, Emas, Obligasi, Reksadana, Saham, Kripto, Forex) yang dipersonalisasi sesuai profil Anda.</p>
                    </div>
                    <div class="feature-item animate-fade-in-up" style="animation-delay: 0.6s;">
                        <i class="fas fa-sliders-h animated-icon"></i>
                        <h4 class="text-xl font-bold text-gray-800 mb-3">Kriteria Fleksibel</h4>
                        <p class="text-gray-600 text-base">Evaluasi berdasarkan Modal Awal, Jangka Waktu, Profil Individu, Imbal Hasil, Risiko, Tingkat Pengalaman, dan Fluktuasi Pasar.</p>
                    </div>
                    <div class="feature-item animate-fade-in-up" style="animation-delay: 0.8s;">
                        <i class="fas fa-handshake animated-icon"></i>
                        <h4 class="text-xl font-bold text-gray-800 mb-3">Keputusan Lebih Baik</h4>
                        <p class="text-gray-600 text-base">Bantu Anda mengambil keputusan investasi yang lebih informatif dan percaya diri sebagai investor pemula.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-gray-100 py-16">
            <div class="container mx-auto text-center px-4">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-8 animate-fade-in-down">Siap Memulai Perjalanan Investasi Anda?</h2>
                <p class="text-lg text-gray-600 max-w-4xl mx-auto mb-8 animate-fade-in-up">Daftar sekarang dan biarkan InvestWise memandu Anda menuju pilihan investasi yang tepat.</p>
                <a href="{{ route('register') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-full shadow-lg transition duration-300 ease-in-out transform hover:scale-105 animate-zoom-in">Daftar Gratis</a>
            </div>
        </section>
    </div> {{-- End flex-grow div --}}

    <footer class="main-footer">
        <div class="container mx-auto">
            <p>&copy; {{ date('Y') }} InvestWise. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> {{-- Bootstrap JS tetap ada jika masih digunakan untuk beberapa komponen --}}
</body>
</html>