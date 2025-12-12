<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Sistem Informasi Ketersediaan Pangan Semarang - SIKETAN</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --orange: #ff8a00;
            --deep: #0f2b3d;
        }

        * {
            box-sizing: border-box
        }

        body {
            font-family: Poppins, sans-serif;
            margin: 0;
            line-height: 1.4;
            color: #0f1720
        }

        /* ============================
               NAVBAR
        ============================= */
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
            align-items: center
        }

        .nav .menu a {
            color: var(--deep);
            text-decoration: none;
            font-weight: 500
        }

        .btn-login {
            background: var(--orange);
            color: #fff !important;
            padding: 10px 16px;
            border-radius: 22px;
            text-decoration: none;
            font-weight: 600
        }

        /* ============================
               HERO SECTION
        ============================= */
        .hero {
            position: relative;
            min-height: 520px;
            background-image: url("{{ asset('tailadmin/images/landingpages/gambarkota.png') }}");
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(5, 20, 30, 0.35), rgba(250, 245, 240, 0.15));
        }

        .hero-inner {
            position: relative;
            z-index: 2;
            max-width: 980px;
            text-align: center;
            padding: 60px 24px
        }

        .eyebrow {
            color: var(--orange);
            font-weight: 700;
            margin-bottom: 8px
        }

        .hero h1 {
            font-size: 48px;
            color: #fff;
            line-height: 1.03;
            margin: 6px 0
        }

        .hero h1 .accent {
            color: var(--orange)
        }

        .hero p {
            color: rgba(255, 255, 255, 0.95);
            margin-top: 14px;
            font-size: 15px
        }

        .hero .cta {
            margin-top: 22px;
            display: flex;
            gap: 16px;
            justify-content: center
        }

        html {
            scroll-behavior: smooth;
        }

        .cta a {
            padding: 12px 22px;
            border-radius: 26px;
            text-decoration: none;
            font-weight: 600
        }

        .cta .primary {
            background: var(--orange);
            color: #fff
        }

        .cta .ghost {
            background: transparent;
            border: 2px solid rgba(255, 255, 255, 0.9);
            color: #fff
        }

        /* ============================
               STATS
        ============================= */
        .stats {
            position: relative;
            z-index: 3;
            transform: translateY(-70px);
            display: flex;
            gap: 18px;
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 20px
        }

        .stat {
            flex: 1;
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(15, 23, 36, 0.08);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            text-align: center
        }

        .stat .icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px auto;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .stat .icon img {
            width: 85px;
            height: 85px;
            object-fit: contain;
        }

        .stat h4 {
            margin: 0;
            font-size: 18px
        }

        .stat p {
            margin: 0;
            color: #6b7280;
            font-size: 13px
        }

        /* ======================================================
               LAYANAN KAMI
        ===================================================== */
        .section {
            padding: 90px 0;
            background: #F4F6FA;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .section-title {
            text-align: center;
            margin-bottom: 65px;
        }

        .section-title h2 {
            font-size: 42px;
            font-weight: 700;
            color: #1A1A1A;
        }

        .section-title .orange {
            color: #FF8A02;
        }

        .services {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 36px;
        }

        .service {
            background: #FFFFFF;
            border-radius: 22px;
            padding: 48px 32px;
            text-align: center;
            box-shadow: 0 12px 28px rgba(15, 23, 36, 0.06);
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: .22s ease;
            cursor: pointer;
            border: 1px solid rgba(0, 0, 0, 0.03);
        }

        .service:hover {
            transform: translateY(-7px);
            box-shadow: 0 18px 40px rgba(15, 23, 36, 0.10);
        }

        /* .s-icon {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 26px;
        } */

        .s-icon img {
            width: 110px;
            height: 110px;
            object-fit: contain;
        }

        .s-body h3 {
            margin: 0 0 12px;
            font-size: 21px;
            font-weight: 700;
            color: #1A1A1A;
        }

        .s-body p {
            margin: 0;
            font-size: 15px;
            line-height: 1.6;
            color: #6b7280;
            max-width: 260px;
        }

        /* .s-1 .s-icon { background: #D8F3E4; }
        .s-2 .s-icon { background: #EAF6FF; }
        .s-3 .s-icon { background: #FAF0FF; } */

        @media(max-width:1024px) {
            .services {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width:700px) {
            .services {
                grid-template-columns: 1fr;
            }
        }

        /* ============================
               FOOTER
        ============================= */
        footer {
            background: #062b52;
            padding: 60px 20px;
            color: #fff;
            margin-top: 80px;
        }

        .footer-container {
            max-width: 1150px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            gap: 50px;
        }

        .footer-col {
            flex: 1;
            min-width: 260px;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 18px;
            font-weight: 700;
        }

        .footer-desc {
            margin-top: 12px;
            font-size: 14px;
            line-height: 1.6;
        }

        .footer-col h3 {
            margin-bottom: 16px;
            font-size: 16px;
            font-weight: 600;
        }

        .footer-links a {
            display: block;
            font-size: 14px;
            margin-bottom: 8px;
            color: #fff;
            text-decoration: none;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.25);
            margin-top: 40px;
            padding-top: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            font-size: 13px;
        }

        .footer-bottom a {
            color: #fff;
            text-decoration: none;
        }

        .footer-bottom a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <!-- NAV -->
    <header class="nav">
        <div class="brand">
            <div class="logo"><img src="{{ asset('tailadmin/images/landingpages/logopemkot.png') }}"></div>
            <div>SIKETAN</div>
        </div>
        <nav class="menu">
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('landing.dashboard')}}">Dashboard</a>
            <a href="{{ route('landing.komoditas')}}">Komoditas</a>
            <a href="pantauan-harga.blade.php">Pantauan Harga</a>
            <a href="peta.blade.php">Peta</a>
            <a class="btn-login" href="{{ route('login') }}">Login</a>
        </nav>
    </header>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-inner">
            <h1><span class="eyebrow">Sistem</span> Informasi<br />Ketersediaan <span
                    class="accent">Pangan</span><br /><span class="accent">Kota </span>Semarang</h1>
            <p>Mewujudkan Semarang yang Mandiri dan Berdaulat dalam Ketahanan Pangan</p>

            <div class="cta">
                <a class="primary" href="dashboard.html">Dashboard</a>
                <a href="#layanan" class="primary">Pelajari Lebih Lanjut</a>
            </div>
        </div>
    </section>

    <!-- STATS -->
    <div class="stats">
        <div class="stat">
            <div class="icon"><img src="{{ asset('tailadmin/images/landingpages/komoditas.png') }}"></div>
            <h4>50+</h4>
            <p>Komoditas Pangan</p>
        </div>
        <div class="stat">
            <div class="icon"><img src="{{ asset('tailadmin/images/landingpages/kecamatan.png') }}"></div>
            <h4>16</h4>
            <p>Kecamatan</p>
        </div>
        <div class="stat">
            <div class="icon"><img src="{{ asset('tailadmin/images/landingpages/kelurahan.png') }}"></div>
            <h4>177</h4>
            <p>Kelurahan</p>
        </div>
        <div class="stat">
            <div class="icon"><img src="{{ asset('tailadmin/images/landingpages/monitoring.png') }}"></div>
            <h4>24/7</h4>
            <p>Monitoring</p>
        </div>
    </div>

    <!-- LAYANAN -->
    <section id="layanan" class="section">
        <div class="container">
            <div class="section-title">
                <h2><span class="orange">Layanan</span> Kami</h2>
            </div>

            <div class="services">

                <div class="service s-1">
                    <div class="s-icon"><img src="{{ asset('tailadmin/images/landingpages/monitoringharga.png') }}"></div>
                    <div class="s-body">
                        <h3>Monitoring Harga</h3>
                        <p>Pantau pergerakan harga pangan secara real-time dengan data terupdate.</p>
                    </div>
                </div>

                <div class="service s-2">
                    <div class="s-icon"><img src="{{ asset('tailadmin/images/landingpages/stokpangan.png') }}"></div>
                    <div class="s-body">
                        <h3>Stok Pangan</h3>
                        <p>Informasi ketersediaan stok pangan Kota Semarang yang akurat dan terpercaya.</p>
                    </div>
                </div>

                <div class="service s-3">
                    <div class="s-icon"><img src="{{ asset('tailadmin/images/landingpages/petadistribusi.png') }}"></div>
                    <div class="s-body">
                        <h3>Peta Distribusi</h3>
                        <p>Visualisasi distribusi pangan secara geografis di Semarang.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- ============================
          FOOTER
    ============================= -->
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
                    Karangkidul, Kec. Semarang Tengah,<br>
                    Kota Semarang, Jawa Tengah 50136<br><br>
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
                <a href="#">Kebijakan Privasi</a> &nbsp; | &nbsp;
                <a href="#">Syarat & Ketentuan</a>
            </div>
        </div>
    </footer>

</body>

</html>