<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Investment DSS - Your Smart Investment Partner</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            font-family: sans-serif;
            background: linear-gradient(to right, #e0ffe0, #ffffe0); /* Gradient background inspired by image */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar {
            background-color: rgba(255, 255, 255, 0.8); /* Slightly transparent navbar */
            backdrop-filter: blur(5px); /* Frosted glass effect */
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .hero-section {
            padding: 80px 0;
            text-align: center;
            background: url('https://via.placeholder.com/1500x500/f0f0f0/cccccc?text=Investment+Background') no-repeat center center; /* Ganti dengan gambar investasi */
            background-size: cover;
            color: #fff;
            position: relative;
            overflow: hidden; /* For animations */
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
        .feature-section {
            padding: 60px 0;
            background-color: #f8f9fa;
        }
        .feature-item {
            text-align: center;
            padding: 30px;
            border-radius: 10px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }
        .feature-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }
        .feature-item i {
            font-size: 3rem;
            color: #28a745; /* Green color */
            margin-bottom: 20px;
        }
        .cta-section {
            padding: 60px 0;
            text-align: center;
            background-color: #e9ecef;
        }
        .footer {
            background-color: #343a40;
            color: #ffffff;
            padding: 30px 0;
            text-align: center;
            margin-top: auto; /* Push footer to the bottom */
        }

        /* Animations */
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-down {
            animation: fadeInDown 1s ease-out forwards;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 1s ease-out forwards;
            animation-delay: 0.5s; /* Delay for staggered effect */
            opacity: 0; /* Start invisible */
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
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="/">
                {{-- Replace with your actual logo --}}
                <img src="{{ asset('images/logo.png') }}" alt="DSS Logo" height="30" class="d-inline-block align-text-top">
                InvestWise
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="btn btn-outline-success me-2" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-success" href="{{ route('register') }}">Register</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="btn btn-outline-primary me-2" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger">Logout</button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <h1 class="display-3 fw-bold animate-fade-in-down">Temukan Investasi Ideal Anda dengan Mudah!</h1>
            <p class="lead mt-4 animate-fade-in-up">Sistem Pendukung Keputusan kami akan membantu Anda memilih instrumen investasi yang paling sesuai dengan profil, tujuan, dan toleransi risiko Anda.</p>
            <div class="mt-5 animate-zoom-in">
                <a href="{{ route('register') }}" class="btn btn-success btn-lg me-3">Mulai Sekarang</a>
                <a href="#about" class="btn btn-outline-light btn-lg">Pelajari Lebih Lanjut</a>
            </div>
        </div>
    </section>

    <section id="about" class="container py-5 text-center">
        <h2 class="mb-4 animate-fade-in-down" style="animation-delay: 0.2s;">Tentang InvestWise</h2>
        <p class="lead animate-fade-in-up" style="animation-delay: 0.4s;">
            Di era digital ini, banyaknya pilihan instrumen investasi seringkali membuat investor pemula bingung.
            Website ini hadir sebagai Sistem Pendukung Keputusan (SPK) yang menggunakan metode Simple Multi Attribute Rating Technique (SMART)
            untuk memberikan rekomendasi instrumen investasi terbaik berdasarkan kriteria pribadi Anda.
        </p>
    </section>

    <section class="feature-section">
        <div class="container">
            <h2 class="text-center mb-5 animate-fade-in-down" style="animation-delay: 0.6s;">Fitur Utama Kami</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-item animate-fade-in-up" style="animation-delay: 0.8s;">
                        <i class="fas fa-chart-line animated-icon"></i>
                        <h4>Rekomendasi Cerdas</h4>
                        <p>Dapatkan rekomendasi instrumen investasi (Deposito, Emas, Obligasi, Reksadana, Saham, Kripto, Forex) yang dipersonalisasi sesuai profil Anda.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-item animate-fade-in-up" style="animation-delay: 1s;">
                        <i class="fas fa-sliders-h animated-icon"></i>
                        <h4>Kriteria Fleksibel</h4>
                        <p>Evaluasi berdasarkan Modal Awal, Jangka Waktu, Profil Individu, Imbal Hasil, Risiko, Tingkat Pengalaman, dan Fluktuasi Pasar.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-item animate-fade-in-up" style="animation-delay: 1.2s;">
                        <i class="fas fa-handshake animated-icon"></i>
                        <h4>Keputusan Lebih Baik</h4>
                        <p>Bantu Anda mengambil keputusan investasi yang lebih informatif dan percaya diri sebagai investor pemula.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="container">
            <h2 class="mb-4 animate-fade-in-down" style="animation-delay: 1.4s;">Siap Memulai Perjalanan Investasi Anda?</h2>
            <p class="lead animate-fade-in-up" style="animation-delay: 1.6s;">Daftar sekarang dan biarkan Investment DSS memandu Anda menuju pilihan investasi yang tepat.</p>
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg mt-3 animate-zoom-in" style="animation-delay: 1.8s;">Daftar Gratis</a>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} Investment DSS. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>