<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Dashboard - SIKETAN</title>
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

        /* NAVBAR SAME */
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

        /* HERO DASHBOARD */
        .hero {
            min-height: 300px;
            background-image: url('/images/gambarkota.png');
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
            background: rgba(0,0,0,0.35);
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

        /* CONTENT EMPTY */
        .dashboard-content {
            padding: 100px 40px;
            max-width: 1100px;
            margin: 0 auto;
            text-align: center;
        }
        .dashboard-content h2 {
            font-weight: 600;
            color: #1a1a1a;
        }
        .dashboard-content p {
            font-size: 15px;
            color: #6b7280;
        }

        /* FOOTER SAME */
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

    <!-- NAV -->
    <header class="nav">
        <div class="brand">
            <div class="logo"><img src="/images/logopemkot.png"></div>
            <div>SIKETAN</div>
        </div>
        <nav class="menu">
            <a href="index.html">Beranda</a>
            <a href="dashboard.html">Dashboard</a>
            <a href="komoditas.html">Komoditas</a>
            <a href="pantauan-harga.html">Pantauan Harga</a>
            <a href="peta.html">Peta</a>
            <a class="btn-login" href="#">Login</a>
        </nav>
    </header>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-inner">
            <h1>Data Komoditas Pangan</h1>
            <p>Informasi Ketersediaan dan Distribusi Pangan Kota Semarang</p>
        </div>
    </section>

    <!-- CONTENT EMPTY -->
    <div class="dashboard-content">
        <h2>Konten Data Komoditas Masih Kosong</h2>
        <p>Silakan tambahkan grafik, tabel, statistik, atau modul lainnya di sini.</p>
    </div>

    <!-- FOOTER -->
    <footer>
        <div class="footer-container">

            <div class="footer-col">
                <div class="footer-logo">
                    <img src="/images/logopemkot.png" width="28">
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
