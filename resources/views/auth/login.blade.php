<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login – Resto App</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0a1628;
            position: relative;
            overflow: hidden;
        }

        /* Animated background */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url('/images/Bg-Register.jpg');
            background-size: cover;
            background-position: center;
            filter: brightness(0.35) saturate(1.2);
            z-index: 0;
        }

        /* Gradient overlay */
        body::after {
            content: '';
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg,
                rgba(15, 47, 102, 0.75) 0%,
                rgba(10, 22, 40, 0.60) 100%);
            z-index: 1;
        }

        /* Floating blobs */
        .blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.18;
            animation: float 8s ease-in-out infinite;
            z-index: 1;
        }
        .blob-1 { width: 400px; height: 400px; background: #2f7fff; top: -100px; left: -100px; animation-delay: 0s; }
        .blob-2 { width: 300px; height: 300px; background: #00b88a; bottom: -80px; right: -80px; animation-delay: -4s; }

        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-20px) scale(1.05); }
        }

        .wrapper {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        /* Logo area */
        .logo-area {
            text-align: center;
            margin-bottom: 28px;
        }

        .logo-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 72px;
            height: 72px;
            border-radius: 22px;
            background: linear-gradient(135deg, #1d5bc0, #2f7fff);
            font-size: 36px;
            margin-bottom: 14px;
            box-shadow: 0 12px 30px rgba(47, 127, 255, 0.4);
        }

        .logo-title {
            font-size: 28px;
            font-weight: 800;
            color: white;
            letter-spacing: -0.5px;
        }

        .logo-sub {
            font-size: 14px;
            color: rgba(255,255,255,0.6);
            margin-top: 4px;
        }

        /* Glass card */
        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 24px;
            padding: 36px 32px;
            box-shadow:
                0 25px 60px rgba(0,0,0,0.3),
                inset 0 1px 0 rgba(255,255,255,0.15);
        }

        .card-heading {
            font-size: 22px;
            font-weight: 700;
            color: white;
            margin-bottom: 6px;
        }

        .card-subheading {
            font-size: 14px;
            color: rgba(255,255,255,0.55);
            margin-bottom: 28px;
        }

        /* Form elements */
        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: rgba(255,255,255,0.8);
            margin-bottom: 8px;
            letter-spacing: 0.3px;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            padding: 13px 16px;
            background: rgba(255,255,255,0.10);
            border: 1.5px solid rgba(255,255,255,0.18);
            border-radius: 14px;
            color: white;
            font-size: 15px;
            font-family: 'Inter', sans-serif;
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
            outline: none;
        }

        input::placeholder { color: rgba(255,255,255,0.35); }

        input:focus {
            border-color: rgba(47,127,255,0.8);
            background: rgba(255,255,255,0.14);
            box-shadow: 0 0 0 3px rgba(47,127,255,0.20);
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #1d5bc0 0%, #2f7fff 100%);
            border: none;
            border-radius: 14px;
            color: white;
            font-size: 15px;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            margin-top: 8px;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 8px 24px rgba(47,127,255,0.4);
            letter-spacing: 0.3px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 32px rgba(47,127,255,0.5);
        }

        .btn-submit:active { transform: translateY(0); }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 22px 0;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,0.15);
        }

        .divider span {
            font-size: 13px;
            color: rgba(255,255,255,0.4);
        }

        .link-register {
            display: block;
            text-align: center;
            font-size: 14px;
            color: rgba(255,255,255,0.65);
        }

        .link-register a {
            color: #5bb4ff;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }

        .link-register a:hover { color: #82cbff; text-decoration: underline; }

        /* Alerts */
        .alert-error {
            background: rgba(220, 38, 38, 0.18);
            border: 1px solid rgba(220, 38, 38, 0.35);
            border-radius: 12px;
            padding: 12px 16px;
            color: #fca5a5;
            font-size: 14px;
            margin-bottom: 18px;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.18);
            border: 1px solid rgba(16, 185, 129, 0.35);
            border-radius: 12px;
            padding: 12px 16px;
            color: #6ee7b7;
            font-size: 14px;
            margin-bottom: 18px;
        }
    </style>
</head>
<body>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="wrapper">
        <div class="logo-area">
            <div class="logo-icon">🍽️</div>
            <div class="logo-title">Resto App</div>
            <div class="logo-sub">Sistem Manajemen Restoran</div>
        </div>

        <div class="glass-card">
            <div class="card-heading">Selamat Datang Kembali</div>
            <div class="card-subheading">Masuk ke dashboard restoran Anda</div>

            @if(session('status'))
                <div class="alert-success">{{ session('status') }}</div>
            @endif

            @if($errors->any())
                <div class="alert-error">
                    @foreach($errors->all() as $error)
                        <div>⚠ {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">📧 Alamat Email</label>
                    <input type="email" id="email" name="email"
                           placeholder="nama@email.com"
                           value="{{ old('email') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password">🔒 Password</label>
                    <input type="password" id="password" name="password"
                           placeholder="Masukkan password Anda" required>
                </div>

                <button type="submit" class="btn-submit">🔑 Login Sekarang</button>
            </form>

            <div class="divider"><span>atau</span></div>

            <div class="link-register">
                Belum punya akun? <a href="{{ route('register') }}">Daftar Gratis →</a>
            </div>
        </div>
    </div>
</body>
</html>