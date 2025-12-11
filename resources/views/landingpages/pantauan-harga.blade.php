<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Pantauan Harga - SIKETAN</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --orange: #ff8a00;
            --deep: #0f2b3d;
        }

        * { box-sizing: border-box; }
        body {
            font-family: Poppins, sans-serif;
            margin: 0;
            line-height: 1.4;
            color: #0f1720;
        }

        /* NAV */
        .nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 40px;
            background: #fff;
            position: sticky;
            top: 0;
            z-index: 40;
            border-bottom: 1px solid rgba(15, 23, 36, 0.05)
        }

        .nav .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            color: var(--deep)
        }

        .brand .logo {
            width: 36px;
            height: 36px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 800
        }

        .nav .menu {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .nav .menu a {
            color: var(--deep);
            text-decoration: none;
            font-weight: 500;
        }

        .btn-login {
            background: var(--orange);
            color: #fff;
            padding: 10px 16px;
            border-radius: 22px;
            text-decoration: none;
            font-weight: 600;
        }

        /* HERO */
        .hero {
            min-height: 300px;
            background-image: url('{{ asset('tailadmin/images/landingpages/gambarkota.png') }}');
            background-size: cover;
            background-position: center;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.4);
        }
        .hero-inner {
            position: relative;
            z-index: 2;
            text-align: center;
            color: #fff;
        }
        .hero-inner h1 {
            font-size: 48px;
            margin: 0;
        }
        .hero-inner p {
            font-size: 16px;
            opacity: .9;
        }

        /* CONTENT */
        .content {
            max-width: 1100px;
            margin: 60px auto;
            padding: 0 20px;
            text-align: center;
        }

        .table-title {
            font-weight: 600;
            font-size: 22px;
            margin-bottom: 20px;
        }

        /* Box Placeholder */
        .empty-box {
            width: 100%;
            height: 300px;
            border: 2px dashed rgba(0,0,0,0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(0,0,0,0.4);
            font-size: 18px;
            font-weight: 500;
        }

        /* FOOTER */
        footer {
            background: #062b52;
            padding: 60px 20px;
            color: #fff;
            margin-top: 80px;
        }
        .footer-container {
            max-width: 1150px; margin: 0 auto;
            display: flex; flex-wrap: wrap;
            gap: 50px;
        }
        .footer-col { flex:1; min-width:260px; }
        .footer-logo {
            display:flex; align-items:center;
            gap:12px; font-size:18px; font-weight:700;
        }
        .footer-desc { margin-top:12px; font-size:14px; line-height:1.6; }
        .footer-col h3 { margin-bottom:16px; font-size:16px; font-weight:600; }
        .footer-links a {
            display:block; font-size:14px;
            margin-bottom:8px; color:#fff;
            text-decoration:none;
        }
        .footer-links a:hover { text-decoration:underline; }

        .footer-bottom {
            border-top:1px solid rgba(255,255,255,.25);
            margin-top:40px; padding-top:20px;
            display:flex; justify-content:space-between;
            font-size:13px; flex-wrap:wrap;
        }
        .footer-bottom a { color:#fff; text-decoration:none; }
        .footer-bottom a:hover { text-decoration:underline; }
    </style>
</head>

<body>

<header class="nav">
    <div class="brand">
        <div class="logo"><img src="{{ asset('tailadmin/images/landingpages/logopemkot.png') }}"></div>
        <div>SIKETAN</div>
    </div>
    <nav class="menu">
        <a href="index.blade.php">Beranda</a>
            <a href="dashboard.blade.php">Dashboard</a>
            <a href="komoditas.blade.php">Komoditas</a>
            <a href="pantauan-harga.blade.php">Pantauan Harga</a>
            <a href="peta.blade.php">Peta</a>
            <a class="btn-login" href="#">Login</a>
    </nav>
</header>

<section class="hero">
    <div class="hero-inner">
        <h1>Pantauan Harga Pangan</h1>
        <p>Data Pergerakan Harga Komoditas Utama di Kota Semarang</p>
    </div>
</section>

<div class="content">
    <div class="table-title">Daftar Harga Komoditas</div>

    <div class="empty-box">
        Konten akan ditampilkan di sini
    </div>
</div>

<footer>
    <div class="footer-container">
        <div class="footer-col">
            <div class="footer-logo">
                <img src="{{ asset('tailadmin/images/landingpages/logopemkot.png') }}" width="28">
                <span>SIKETAN</span>
            </div>
            <div class="footer-desc">
                Sistem Informasi Ketersediaan Pangan<br>
                Semarang
            </div>
        </div>

        <div class="footer-col">
            <h3>Kontak</h3>
            <div class="footer-desc">
                Jl. Ki Mangunsarkoro No.21,<br>
                Semarang Tengah<br><br>
                (024) 76745957<br>
                ketahananpangan.semarangkota<br>@gmail.com
            </div>
        </div>

        <div class="footer-col">
            <h3>Link Terkait</h3>
            <div class="footer-links">
                <a href="#">Kota Semarang</a>
                <a href="#">Portal Data Indonesia</a>
                <a href="#">Badan Pangan Nasional</a>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div>© 2024 SIKETAN. Hak Cipta Dilindungi.</div>
        <div>
            <a href="#">Kebijakan Privasi</a> |
            <a href="#">Syarat & Ketentuan</a>
        </div>
    </div>
</footer>

</body>
</html>
