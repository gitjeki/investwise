<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - InvestWise</title> {{-- Ubah Judul Halaman --}}
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
            background: linear-gradient(to right, #e0ffe0, #ffffe0); /* Konsisten dengan login */
        }
        .container-fluid {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .left-panel, .right-panel {
            flex: 1;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .card {
            width: 90%;
            max-width: 400px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.9);
        }
        .logo-container {
            text-align: center;
        }
        .logo {
            width: 200px;
            height: auto;
        }

        /* Gaya Font Kustom - Sama dengan halaman Login */
        .app-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            color: #198754; /* Warna hijau Bootstrap */
        }
        .app-slogan {
            font-family: 'Inter', sans-serif;
            font-weight: 400;
            color: #6c757d; /* Warna text-muted Bootstrap */
        }
        /* Penyesuaian ukuran dan margin untuk tampilan yang lebih menarik - Sama dengan halaman Login */
        .logo-container h2 {
            font-size: 2.5rem;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
        }
        .logo-container p {
            font-size: 1.1rem;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="left-panel">
            <div class="logo-container">
                <img src="{{ asset('images/logo.png') }}" alt="InvestWise Logo" class="logo"> {{-- Sesuaikan alt text --}}
                <h2 class="app-title">InvestWise</h2> {{-- Gunakan class kustom --}}
                <p class="app-slogan">Your Smart Partner for Confident Investment Decisions</p> {{-- Gunakan class kustom --}}
            </div>
        </div>
        <div class="right-panel">
            <div class="card p-4">
                <h3 class="card-title text-center mb-4">Register</h3>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" class="btn btn-success">Register</button>
                    </div>
                    <p class="text-center">Already have an account? <a href="{{ route('login') }}">Login here</a></p>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>