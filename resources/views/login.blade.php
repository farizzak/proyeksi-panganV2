<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIKETAN - Login</title>

    <link rel="icon" href="{{ asset('tailadmin/images/logo/logo_pemkot.svg') }}" type="image/svg+xml">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            height: 100vh;
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
        }

        /* LEFT SECTION */
        .left-section {
            /* background: linear-gradient(135deg, #FFAE70, #FF7E00); */
            background: linear-gradient(135deg, #3C50E0, #80A6FF);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 70px;
            position: relative;
        }

        .left-section h1 {
            font-size: 40px;
            font-weight: 700;
        }

        .left-section h5 {
            font-weight: 500;
            margin-top: 8px;
        }

        .left-section p {
            max-width: 380px;
            opacity: 0.95;
            margin-top: 15px;
        }

        /* Circle Decoration (Cream / Peach) */
        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 245, 235, 0.22);
        }

        .c1 { width: 260px; height: 260px; bottom: -70px; left: -50px; }
        .c2 { width: 180px; height: 180px; top: 40px; right: -40px; }
        .c3 { width: 140px; height: 140px; bottom: 80px; right: 20px; }


        /* RIGHT SECTION */
        .right-section {
            background: #FFF6EE;
            padding: 60px 80px;
            display: flex;
            align-items: center;
        }

        .form-control {
            border-radius: 10px;
            height: 48px;
        }

        .input-group-text {
            background: white;
            border-radius: 10px 0 0 10px;
        }

        .btn-login {
            height: 48px;
            border-radius: 10px;
            /* background: #FF8C2A; */
            background: #3C50E0;
            color: white;
            font-weight: 600;
        }

        .btn-login:hover {
            /* background: #E97818; */
            background: #273AC7;
        }

        .link-custom {
            text-decoration: none;
            font-size: 0.9rem;
            color: #5A3E2B;
        }

        .divider {
            text-align: center;
            margin: 20px 0;
            font-size: 14px;
            color: #666;
        }

        .divider:before,
        .divider:after {
            content: "";
            width: 40%;
            height: 1px;
            background: #ccc;
            display: inline-block;
            vertical-align: middle;
            margin: 0 10px;
        }

        @media(max-width: 992px) {
            .left-section { display: none; }
            body { background: #FFF6EE; }
            .right-section { justify-content: center; width: 100%; padding: 40px; }
        }

        @media (min-width: 1400px) {
            .right-section form {
                max-width: 460px !important; 
            }
        }

        @media (min-width: 1700px) {
            .right-section form {
                max-width: 520px !important; 
            }
        }
        
        @media (max-width: 1280px) {
            .right-section {
                padding: 40px 50px !important;
            }

            .right-section form {
                max-width: 340px !important;
            }
        }
    </style>
</head>

<body>

<div class="row g-0 h-100">

    <!-- LEFT ORANGE SECTION -->
    <div class="col-lg-6 left-section">
        <div class="circle c1"></div>
        <div class="circle c2"></div>
        <div class="circle c3"></div>

        <img src="{{ asset('tailadmin/images/logo/logo_kotaSemarang.png') }}"
             alt="Logo Pemkot"
             style="width: 250px; margin-bottom: 5px; margin-left: -62px;">

        <h5>Sistem Informasi Ketersediaan Pangan (SIKETAN)</h5>
        <p>
            Silakan login untuk mengakses dashboard ketersediaan pangan Kota Semarang.
        </p>
    </div>

    <!-- RIGHT FORM SECTION -->
    <div class="col-lg-6 right-section">

        <form method="post" action="{{ route('login.process') }}" class="w-100" style="max-width: 380px;">
            @csrf

            <h3 class="mb-3 fw-bold" style="color:#5A3E2B">Sign In</h3>
            <p class="text-muted mb-4">Masukkan email & password Anda</p>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- Username -->
            <label class="mb-1 fw-semibold">Email</label>
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                <input type="text" name="email" class="form-control" placeholder="Email" required>
            </div>

            <!-- Password -->
            <label class="mb-1 fw-semibold">Password</label>
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            {{-- <div class="d-flex justify-content-between mb-3">
                <div>
                    <input type="checkbox"> <small>Remember me</small>
                </div>
                <a href="#" class="link-custom">Forgot Password?</a>
            </div> --}}

            <button class="btn btn-login w-100 mb-3">Sign In</button>
        </form>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
