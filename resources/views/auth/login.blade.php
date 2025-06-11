<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - InvestWise</title> {{-- Ubah Judul Halaman --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            /* Gradient background inspired by the image */
            background: linear-gradient(to right, #e0ffe0, #ffffe0); /* Light green to light yellow */
        }
        .container-fluid {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .left-panel, .right-panel {
            flex: 1; /* Both share equal space */
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .card {
            width: 90%; /* Adjust as needed */
            max-width: 400px; /* Max width for the card */
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent white card */
        }
        .logo-container {
            text-align: center;
        }
        .logo {
            width: 200px; /* Adjust logo size */
            height: auto;
        }

        /* Gaya Font Kustom */
        .app-title {
            font-family: 'Poppins', sans-serif; /* Font menarik untuk judul aplikasi */
            font-weight: 700; /* Bold */
            color: #198754; /* Warna hijau Bootstrap */
        }
        .app-slogan {
            font-family: 'Inter', sans-serif; /* Font lebih rapi untuk slogan */
            font-weight: 400; /* Regular */
            color: #6c757d; /* Warna text-muted Bootstrap */
        }
        /* Penyesuaian ukuran dan margin untuk tampilan yang lebih menarik */
        .logo-container h2 {
            font-size: 2.5rem; /* Ukuran lebih besar */
            margin-top: 1rem; /* Jarak lebih besar dari logo */
            margin-bottom: 0.5rem;
        }
        .logo-container p {
            font-size: 1.1rem; /* Ukuran sedikit lebih besar */
            line-height: 1.5; /* Line height lebih nyaman */
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="left-panel">
            <div class="logo-container">
                {{-- Replace with your actual logo --}}
                <img src="{{ asset('images/logo.png') }}" alt="InvestWise Logo" class="logo"> {{-- Ubah alt text --}}
                <h2 class="app-title">InvestWise</h2> {{-- Ubah teks dan tambahkan class --}}
                <p class="app-slogan">Your Smart Partner for Confident Investment Decisions</p> {{-- Ubah teks dan tambahkan class --}}
            </div>
        </div>
        <div class="right-panel">
            <div class="card p-4">
                <h3 class="card-title text-center mb-4">Login</h3>
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" class="btn btn-success">Login</button>
                    </div>
                    <p class="text-center">Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>