<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Pantauan Harga - SIKETAN</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="{{ asset('tailadmin/images/logo/logo_pemkot.svg') }}" type="image/svg+xml">
    <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer" />


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
            align-items: center
        }

        .nav .menu a {
            position: relative;
            color: #000;
            text-decoration: none;
            transition: 
                color .25s ease,
                transform .25s ease;
        }

        .nav .menu a::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -6px;
            width: 0;
            height: 2px;
            background: var(--orange);
            transition: width .3s ease;
        }

        .nav .menu a:hover {
            color: var(--orange);
            transform: translateY(-2px);
        }

        /* Underline muncul */
        .nav .menu a:hover::after {
            width: 100%;
        }

        /* Login TIDAK ikut underline */
        .nav .menu .btn-login::after {
            display: none;
        }

        .nav .menu .btn-login:hover {
            transform: translateY(-2px);
        }

        .nav .menu a.active {
            color: var(--orange);
        }

        .nav .menu a.active::after {
            width: 100%;
        }

        /* hover tetap berlaku untuk menu lain */
        .nav .menu a:not(.active):hover {
            color: var(--orange);
            transform: translateY(-2px);
        }


        .btn-login {
            background: var(--orange);
            color: #fff !important;
            padding: 10px 16px;
            border-radius: 22px;
            text-decoration: none;
            font-weight: 600
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
        .footer-social {
            margin-top: 16px;
            display: flex;
            gap: 14px;
        }

        .footer-social a {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255,255,255,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 16px;

            /* ⛔ hilangkan underline */
            text-decoration: none !important;

            transition: all .25s ease;
        }

        .footer-social a:hover {
            background: var(--orange);
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.25);

            /* tetap tanpa underline saat hover */
            text-decoration: none !important;
        }
    </style>
</head>

<body>

<header class="nav">
    <div class="brand">
        <div class="logo"><img src="{{ asset('tailadmin/images/landingpages/logopemkot.png') }}"></div>
        <div>SIKETAN</div>
    </div>
    <nav class="menu">
        <a href="{{ route('home') }}"
        class="{{ request()->routeIs('home') ? 'active' : '' }}">
            Beranda
        </a>

        <a href="{{ route('landing.dashboard') }}"
        class="{{ request()->routeIs('landing.dashboard') ? 'active' : '' }}">
            Dashboard
        </a>

        <a href="{{ route('landing.komoditas') }}"
        class="{{ request()->routeIs('landing.komoditas') ? 'active' : '' }}">
            Komoditas
        </a>

        <a href="{{ route('landing.pantauan-harga') }}"
        class="{{ request()->routeIs('landing.pantauan-harga') ? 'active' : '' }}">
            Pantauan Harga
        </a>

        <a href="{{ route('landing.peta') }}"
        class="{{ request()->routeIs('landing.peta') ? 'active' : '' }}">
            Peta
        </a>

        <a class="btn-login" href="{{ route('login') }}">Login</a>
    </nav>

</header>

<section class="hero">
    <div class="hero-inner">
        <h1>Pantauan Harga Pangan</h1>
        <p>Data Pergerakan Harga Komoditas Utama di Kota Semarang</p>
    </div>
</section>

<div>
    <main class="max-w-6xl mx-auto px-6 py-16 space-y-10">

        <h1 class="text-3xl font-semibold text-gray-800">
            Pantauan Harga
        </h1>

        {{-- <section class="bg-white shadow-md rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-medium text-gray-700">
                    Dashboard Harga Pasar
                </h2>
            </div>

            <div class="w-full h-[70vh]">
                <iframe
                    src="https://siharpa.semarangkota.go.id/dashboard-harga-pasar"
                    class="w-full h-full"
                    frameborder="0"
                    allowfullscreen
                ></iframe>
            </div>
        </section> --}}

        <section class="bg-white shadow-md rounded-xl p-6">
            <h3 class="text-lg font-medium text-gray-700 mb-4">
                Komoditas – Terakhir Ambil Data Tanggal
                <span class="font-semibold">
                    {{ $tanggalFormatted }}
                </span>
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full border border-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr class="text-left text-sm text-gray-600">
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">Komoditas</th>
                            <th class="px-4 py-3">Harga Awal</th>
                            <th class="px-4 py-3">Harga Akhir</th>
                            <th class="px-4 py-3">Persentase</th>
                            <th class="px-4 py-3">Keterangan</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 text-sm">
                        @forelse ($komoditas as $key => $item)
                            @php
                                $bahan = optional($item->bahanPokokTerbaru);
                                $status = $bahan->keterangan;
                            @endphp

                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3">{{ $key + 1 }}</td>
                                <td class="px-4 py-3 font-medium text-gray-800">
                                    {{ $bahan->bahan_pokok ?? '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ number_format($bahan->harga_tanggal_1 ?? 0, 2, ',', '.') }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ number_format($bahan->harga_tanggal_2 ?? 0, 2, ',', '.') }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ number_format($bahan->persentase ?? 0, 2, ',', '.') }} %
                                </td>
                                <td class="px-4 py-3 font-medium">
                                    @if ($status === 'Naik')
                                        <span class="text-red-600">▲ Naik</span>
                                    @elseif ($status === 'Turun')
                                        <span class="text-green-600">▼ Turun</span>
                                    @elseif ($status === 'Tetap')
                                        <span class="text-gray-500">▬ Tetap</span>
                                    @else
                                        <span class="text-gray-400 italic">Belum ada data</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-500 italic">
                                    Data belum tersedia
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
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

                <div class="footer-social">
                    <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
                    <a href="#" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
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
