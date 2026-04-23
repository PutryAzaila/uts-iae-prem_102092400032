<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Azaila Premstore')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        body {
            background: #f8f7ff;
            min-height: 100vh;
        }

        .navbar-wrapper {
            position: sticky;
            top: 16px;
            z-index: 50;
            padding: 0 24px;
        }
        .navbar {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(139,92,246,0.15);
            border-radius: 999px;
            max-width: 1100px;
            margin: 0 auto;
            padding: 12px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 24px rgba(139,92,246,0.08);
        }
        .navbar-logo {
            font-size: 1.2rem;
            font-weight: 800;
            background: linear-gradient(135deg, #6d28d9, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
            letter-spacing: -0.5px;
        }
        .navbar-links {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .navbar-link {
            color: #6b7280;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 999px;
            transition: all 0.2s;
        }
        .navbar-link:hover {
            color: #6d28d9;
            background: rgba(109,40,217,0.06);
        }
        .navbar-btn {
            background: linear-gradient(135deg, #6d28d9, #ec4899);
            color: white !important;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            padding: 8px 20px;
            border-radius: 999px;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(109,40,217,0.3);
        }
        .navbar-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(109,40,217,0.4);
        }

        .gradient-text {
            background: linear-gradient(135deg, #6d28d9, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .btn-primary {
            background: linear-gradient(135deg, #6d28d9, #ec4899);
            color: white;
            font-weight: 600;
            padding: 12px 28px;
            border-radius: 999px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s;
            box-shadow: 0 4px 16px rgba(109,40,217,0.3);
            font-size: 0.925rem;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(109,40,217,0.4);
            color: white;
        }
        .btn-primary:disabled, .btn-primary.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        .btn-outline {
            background: white;
            color: #6d28d9;
            font-weight: 600;
            padding: 11px 28px;
            border-radius: 999px;
            border: 2px solid rgba(109,40,217,0.3);
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s;
            font-size: 0.925rem;
        }
        .btn-outline:hover {
            border-color: #6d28d9;
            background: rgba(109,40,217,0.04);
            transform: translateY(-2px);
            color: #6d28d9;
        }

        .card {
            background: white;
            border-radius: 24px;
            border: 1px solid rgba(139,92,246,0.1);
            box-shadow: 0 2px 16px rgba(109,40,217,0.04);
            transition: all 0.25s;
        }
        .card:hover {
            box-shadow: 0 8px 32px rgba(109,40,217,0.1);
            transform: translateY(-2px);
            border-color: rgba(139,92,246,0.25);
        }

        .badge-green {
            background: #ecfdf5;
            color: #059669;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 999px;
        }
        .badge-red {
            background: #fef2f2;
            color: #dc2626;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 999px;
        }
        .badge-yellow {
            background: #fffbeb;
            color: #d97706;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 999px;
        }

        .form-input {
            width: 100%;
            border: 1.5px solid #e5e7eb;
            border-radius: 14px;
            padding: 12px 16px;
            font-size: 0.925rem;
            color: #111827;
            outline: none;
            transition: all 0.2s;
            background: #fafafa;
            box-sizing: border-box;
        }
        .form-input:focus {
            border-color: #8b5cf6;
            background: white;
            box-shadow: 0 0 0 4px rgba(139,92,246,0.1);
        }
        .form-input.error {
            border-color: #f43f5e;
            box-shadow: 0 0 0 4px rgba(244,63,94,0.08);
        }
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            padding: 14px 18px;
            border-radius: 14px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #15803d;
            padding: 14px 18px;
            border-radius: 14px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* Decorative blobs */
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.15;
            pointer-events: none;
        }
        .blob-purple { background: #7c3aed; }
        .blob-pink   { background: #ec4899; }
        .blob-blue   { background: #3b82f6; }
    </style>
</head>
<body>

    <div class="navbar-wrapper" style="padding-top: 16px;">
        <nav class="navbar">
            <a href="{{ route('home') }}" class="navbar-logo"><i class="fa-solid fa-crown"></i> AzailaiestStore</a>
            <div class="navbar-links">
                <a href="{{ route('home') }}" class="navbar-link">Pilihan Kamu</a>
                <a href="#cara-beli" class="navbar-link">Gimana Belinya?</a>
                <a href="#faq" class="navbar-link">QnA</a>
                <a href="{{ route('home') }}" class="navbar-btn">Gas Checkout</a>
            </div>
        </nav>
    </div>

    @if(session('error'))
    <div class="container" style="max-width:1100px; margin:16px auto; padding:0 24px;">
        <div class="alert-error"><i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}</div>
    </div>
    @endif
    @if(session('success'))
    <div class="container" style="max-width:1100px; margin:16px auto; padding:0 24px;">
        <div class="alert-success"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
    </div>
    @endif

    @yield('content')

    <footer style="margin-top: 80px; padding: 40px 24px; text-align: center; border-top: 1px solid rgba(139,92,246,0.1);">
        <p class="gradient-text" style="font-weight: 800; font-size: 1.1rem; margin-bottom: 8px;"><i class="fa-solid fa-crown"></i> AzailaiestStore</p>
        <p style="color: #9ca3af; font-size: 0.875rem;">© {{ date('Y') }} AzailaiestStore. Akun premium aman, no tipu-tipu.</p>
    </footer>

</body>
</html>