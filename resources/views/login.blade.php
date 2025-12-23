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
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
        }

        .login-bg {
            min-height: 100vh;
            background: #F8FAFC; /* putih soft, tidak silau */
            display: flex;
            align-items: center;
            justify-content: center;
        }


        .login-wrapper {
            width: 100%;
            max-width: 1100px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 45px rgba(0,0,0,0.12);
        }



        /* LEFT SECTION */
        .left-section {
            /* background: linear-gradient(135deg, #FFAE70, #FF7E00); */
            background: linear-gradient(#C93636, #FF8A02, #FFB302);
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
            background: #FFEECC;
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
            background: #FF8A02;
            color: white;
            font-weight: 600;
        }

        .btn-login:hover {
            /* background: #E97818; */
            background: #ee8002;
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
        .swal2-container {
            z-index: 999999 !important;
        }

        .swal2-popup {
            z-index: 999999 !important;
        }

        /* Prevent SweetAlert from shrinking the page height when the modal opens */
        .swal2-shown {
            overflow: hidden !important;
        }
        .swal2-height-auto {
            height: 100% !important;
        }



        @media(max-width: 992px) {
            .left-section { display: none; }
            body { background: #FFF6EE; }
            .right-section { justify-content: center; width: 100%; padding: 40px; }
            .login-wrapper {
                margin: 20px;
            }
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

<body class="login-bg">

<div class="login-wrapper">
    <div class="row g-0">


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

            <h3 class="mb-3 fw-bold" style="color:#FF8A02">Sign In</h3>
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
            
            <div class="d-flex align-items-center mb-3" style="gap:10px;">

                <canvas id="captcha-canvas"
                    width="140" height="50"
                    class="rounded"
                    style="background:#F5F7FD; border:1px solid #E5E7EB;">
                </canvas>

                <button type="button" id="reload-captcha"
                    class="btn"
                    style="background:#FF8A02; color:white; padding:10px 14px; border-radius:8px;">
                    <i class="fa fa-rotate-right"></i>
                </button>

            </div>

            <input type="text" id="captcha-input" name="captcha" class="form-control mb-3" placeholder="Masukkan kode captcha" style="border-radius:8px;" required>

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
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let captchaCode = "";

    function generateCaptcha() {
        const canvas = document.getElementById("captcha-canvas");
        const ctx = canvas.getContext("2d");

        ctx.clearRect(0, 0, canvas.width, canvas.height);

        const chars = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789";
        captchaCode = "";
        for (let i = 0; i < 5; i++) {
            captchaCode += chars.charAt(Math.floor(Math.random() * chars.length));
        }

        ctx.fillStyle = "#f3f3f3";
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        for (let i = 0; i < 5; i++) {
            ctx.strokeStyle = "rgba(0,0,0,0.15)";
            ctx.beginPath();
            ctx.moveTo(Math.random() * 140, Math.random() * 50);
            ctx.lineTo(Math.random() * 140, Math.random() * 50);
            ctx.stroke();
        }

        ctx.font = "bold 26px Poppins";

        for (let i = 0; i < captchaCode.length; i++) {
            const x = 20 + i * 22 + Math.random() * 4;
            const y = 30 + Math.random() * 4;
            const angle = (Math.random() - 0.5) * 0.6;

            ctx.save();
            ctx.translate(x, y);
            ctx.rotate(angle);

            ctx.fillStyle = `rgb(${100 + Math.random()*100}, ${100 + Math.random()*100}, ${100 + Math.random()*100})`;

            ctx.fillText(captchaCode[i], 0, 0);
            ctx.restore();
        }

        for (let i = 0; i < 40; i++) {
            ctx.fillStyle = "rgba(0,0,0,0.15)";
            ctx.beginPath();
            ctx.arc(Math.random() * 140, Math.random() * 50, 1, 0, Math.PI * 2);
            ctx.fill();
        }

        return captchaCode;
    }

    document.getElementById("reload-captcha").onclick = generateCaptcha;
    generateCaptcha();

    document.querySelector("form").onsubmit = function(e) {
        const input = document.getElementById("captcha-input").value.trim();

        if (input !== captchaCode) {
            e.preventDefault();

            Swal.fire({
                icon: 'error',
                title: 'Captcha Salah',
                text: 'Silakan coba lagi.',
                confirmButtonColor: '#FF8A02',
                background: '#fff',
                heightAuto: false,
                backdrop: `
                    rgba(0,0,0,0.45)
                    center top
                    no-repeat
                `,
            });

            generateCaptcha();
        }
    };


</script>



</body>
</html>
