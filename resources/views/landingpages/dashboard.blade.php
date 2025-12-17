<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Dashboard - SIKETAN</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        * {
            box-sizing: border-box;
        }

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

        /* HERO DASHBOARD */
        .hero {
            min-height: 300px;
            background-image: url("{{ asset('tailadmin/images/landingpages/gambarkota.png') }}");
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
            background: rgba(0, 0, 0, 0.35);
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
            border-top: 1px solid rgba(255, 255, 255, .25);
            margin-top: 40px;
            padding-top: 20px;
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            flex-wrap: wrap;
        }

        .footer-bottom a {
            color: #fff;
            text-decoration: none;
        }

        .footer-bottom a:hover {
            text-decoration: underline;
        }

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

    <!-- NAV -->
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

    <!-- HERO -->
    <section class="hero">
        <div class="hero-inner">
            <h1>Dashboard Ketersediaan Pangan Semarang</h1>
            <p>Pusat Informasi dan Analisis Ketersediaan Pangan</p>
        </div>
    </section>

    <!-- CONTENT -->
    @php
        $totalKetersediaan = $selectedData->sum('jumlah_stok_total');
        $totalKebutuhan = $selectedData->sum('total_kebutuhan');
        $totalNeracaValue = $selectedData->sum('neraca');
    @endphp
    <div class="dashboard-content py-20 px-4 md:px-6 max-w-6xl mx-auto space-y-10">

        <!-- RINGKASAN -->
        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-2xl bg-white shadow-md border border-gray-100 p-4">
                <p class="text-sm text-gray-500">Total Ketersediaan</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totalKetersediaan, 2, ',', '.') }}</p>
                <p class="text-xs text-gray-400 mt-1">Periode {{ $namaBulan }} {{ $tahun }}</p>
            </div>
            <div class="rounded-2xl bg-white shadow-md border border-gray-100 p-4">
                <p class="text-sm text-gray-500">Total Kebutuhan</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totalKebutuhan, 2, ',', '.') }}</p>
                <p class="text-xs text-gray-400 mt-1">RT + Non RT</p>
            </div>
            <div class="rounded-2xl bg-white shadow-md border border-gray-100 p-4">
                <p class="text-sm text-gray-500">Neraca</p>
                <p class="text-2xl font-bold {{ $totalNeracaValue >= 0 ? 'text-emerald-600' : 'text-red-600' }} mt-1">
                    {{ $totalNeracaValue >= 0 ? '+' : '' }}{{ number_format($totalNeracaValue, 2, ',', '.') }}
                </p>
                <p class="text-xs text-gray-400 mt-1">Selisih ketersediaan vs kebutuhan</p>
            </div>
        </div>

        <!-- FILTER SECTION -->
        <div class="rounded-2xl bg-white shadow-md border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Pilih Komoditas & Periode</h3>
                </div>
                <a href="{{ route('landing.dashboard') }}" class="text-sm text-orange-500 hover:text-orange-600">Reset</a>
            </div>

            <form action="{{ route('landing.dashboard') }}" method="GET"
                class="grid grid-cols-1 md:grid-cols-4 gap-6">

                <!-- Komoditas -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Pilih Komoditas</label>
                    <select id="komoditas_id" name="komoditas_id"
                        class="w-full border border-gray-200 rounded-xl px-3 py-2.5 focus:ring-orange-400 focus:border-orange-400 bg-gray-50">
                        @foreach ($Mkomoditas as $komoditas)
                            <option value="{{ $komoditas->id }}"
                                {{ $komoditas->id == request('komoditas_id') ? 'selected' : '' }}>
                                {{ $komoditas->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Bulan -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Bulan</label>
                    <select id="bulan" name="bulan"
                        class="w-full border border-gray-200 rounded-xl px-3 py-2.5 focus:ring-orange-400 focus:border-orange-400 bg-gray-50">
                        @foreach(range(1, 12) as $month)
                            <option value="{{ $month }}"
                                {{ $month == request('bulan', date('n')) ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tahun -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Tahun</label>
                    <select id="tahun" name="tahun"
                        class="w-full border border-gray-200 rounded-xl px-3 py-2.5 focus:ring-orange-400 focus:border-orange-400 bg-gray-50">
                        @foreach(range(date('Y') - 5, date('Y')) as $year)
                            <option value="{{ $year }}"
                                {{ $year == request('tahun', date('Y')) ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Button -->
                <div class="flex items-end">
                    <button type="submit"
                        class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 rounded-xl shadow-sm transition">
                        Tampilkan
                    </button>
                </div>
            </form>
        </div>

        <!-- CHART -->
        <div class="rounded-2xl bg-white shadow-md border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Trend Ketahanan Pangan - {{ $namakomoditas->name }}</h3>
                </div>
                <span class="text-xs text-gray-500">Periode {{ $tahun }}</span>
            </div>
            <div class="relative">
                <canvas id="priceTrendChart" height="100"></canvas>
            </div>
        </div>

        <!-- DATA TABLE -->
        <div class="rounded-2xl bg-white shadow-md border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Data Ketersediaan Pangan - {{ $namaBulan }} {{ $tahun }}</h3>
                </div>
                <span class="text-xs text-gray-500">{{ $selectedData->count() }} data</span>
            </div>

            <div class="overflow-x-auto rounded-xl border border-gray-100">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">Komoditas</th>
                            <th class="px-4 py-3">Stok Awal</th>
                            <th class="px-4 py-3">Produksi</th>
                            <th class="px-4 py-3">Impor Distributor</th>
                            <th class="px-4 py-3">Impor Pasar</th>
                            <th class="px-4 py-3">Impor Bulog</th>
                            <th class="px-4 py-3">Total Ketersediaan</th>
                            <th class="px-4 py-3">Kebutuhan RT</th>
                            <th class="px-4 py-3">Kebutuhan Non RT</th>
                            <th class="px-4 py-3">Total Kebutuhan</th>
                            <th class="px-4 py-3">Neraca</th>
                            <th class="px-4 py-3">Angka Kecukupan</th>
                            <th class="px-4 py-3">Kecukupan Harian</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 [&>tr:nth-child(even)]:bg-gray-50 [&>tr:hover]:bg-gray-100">
                        @foreach ($selectedData as $key => $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 font-semibold text-gray-900">{{ $key + 1 }}</td>
                                <td class="px-4 py-3">{{ $item->nama_komoditas }}</td>
                                <td class="px-4 py-3">{{ number_format($item->stok_awal, 2, ',', '.') }}</td>
                                <td class="px-4 py-3">{{ number_format($item->produksi, 2, ',', '.') }}</td>
                                <td class="px-4 py-3">{{ number_format($item->stok_distributor, 2, ',', '.') }}</td>
                                <td class="px-4 py-3">{{ number_format($item->stok_pasar, 2, ',', '.') }}</td>
                                <td class="px-4 py-3">{{ number_format($item->stok_bulog, 2, ',', '.') }}</td>
                                <td class="px-4 py-3 font-semibold text-gray-900">{{ number_format($item->jumlah_stok_total, 2, ',', '.') }}</td>
                                <td class="px-4 py-3">{{ number_format($item->kebutuhan_rt, 2, ',', '.') }}</td>
                                <td class="px-4 py-3">{{ number_format($item->kebutuhan_nonrt, 2, ',', '.') }}</td>
                                <td class="px-4 py-3 font-semibold">{{ number_format($item->total_kebutuhan, 2, ',', '.') }}</td>
                                <td class="px-4 py-3 {{ $item->neraca >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                                    {{ $item->neraca >= 0 ? '+' : '' }}{{ number_format($item->neraca, 2, ',', '.') }}
                                </td>
                                <td class="px-4 py-3">{{ number_format($item->angka_kecukupan, 2, ',', '.') }}</td>
                                <td class="px-4 py-3">{{ $item->kecukupan_harian }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
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

    <script>
        const stokBulan = @json($stokBulan);
        const totalNeraca = @json($totalNeraca);

        const ctx = document.getElementById('priceTrendChart').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 250);
        gradient.addColorStop(0, 'rgba(249, 115, 22, 0.35)');
        gradient.addColorStop(1, 'rgba(249, 115, 22, 0.05)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: stokBulan,
                datasets: [{
                    label: 'Jumlah Neraca',
                    data: totalNeraca,
                    borderColor: 'rgb(249, 115, 22)',
                    backgroundColor: gradient,
                    tension: 0.35,
                    fill: true,
                    borderWidth: 3,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: 'rgb(249, 115, 22)',
                    pointBorderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: {
                        display: true,
                        text: 'Trend Neraca Pangan',
                        color: '#0f172a',
                        font: { weight: 'bold', size: 16 }
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        borderColor: 'rgba(255,255,255,0.08)',
                        borderWidth: 1,
                        titleColor: '#fff',
                        bodyColor: '#e2e8f0',
                        callbacks: {
                            label: (context) => {
                                const value = context.parsed.y ?? 0;
                                return ` ${value.toLocaleString('id-ID', { minimumFractionDigits: 2 })}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(148,163,184,0.2)' },
                        ticks: { color: '#475569', callback: (v) => v.toLocaleString('id-ID') }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#475569' }
                    }
                }
            }
        });
    </script>

</body>

</html>
