<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Komoditas - SIKETAN</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" href="{{ asset('tailadmin/images/logo/logo_pemkot.svg') }}" type="image/svg+xml">

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
            <div class="logo"><img src="{{ asset('tailadmin/images/landingpages/logopemkot.png') }}"></div>
            <div>SIKETAN</div>
        </div>
        <nav class="menu">
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('landing.dashboard')}}">Dashboard</a>
            <a href="{{ route('landing.komoditas')}}">Komoditas</a>
            <a href="{{ route('landing.pantauan-harga')}}">Pantauan Harga</a>
            <a href="{{ route('landing.peta')}}">Peta</a>
            <a class="btn-login" href="{{ route('login') }}">Login</a>
        </nav>
    </header>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-inner">
            <h1>Data Komoditas Pangan</h1>
            <p>Informasi Ketersediaan dan Distribusi Pangan Kota Semarang</p>
        </div>
    </section>

    <!-- CONTENT -->
    <div class="dashboard-content bg-slate-50">
        <main class="max-w-6xl mx-auto px-4 md:px-6 py-16 space-y-8">

            <!-- FILTER SECTION -->
            <div class="rounded-2xl bg-white shadow-md border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Pilih periode data</h3>
                    </div>
                    <a href="{{ route('landing.komoditas') }}" class="text-sm text-orange-500 hover:text-orange-600">Reset</a>
                </div>

                <form action="{{ route('landing.komoditas') }}" method="GET"
                    class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <!-- BULAN -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2 text-sm">Bulan</label>
                        <select id="bulan" name="bulan"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3 py-2.5 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            @foreach(range(1, 12) as $month)
                                <option value="{{ $month }}"
                                    {{ $month == request('bulan', date('n')) ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- TAHUN -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2 text-sm">Tahun</label>
                        <select id="tahun" name="tahun"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3 py-2.5 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            @foreach(range(date('Y') - 5, date('Y')) as $year)
                                <option value="{{ $year }}"
                                    {{ $year == request('tahun', date('Y')) ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- BUTTON -->
                    <div class="flex items-end">
                        <button type="submit"
                            class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 rounded-xl shadow-sm transition">
                            Tampilkan Data
                        </button>
                    </div>

                </form>
            </div>

            <!-- CHART GRID -->
            <div id="chart-container"
                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <!-- AJAX akan render chart card di sini -->
            </div>

        </main>
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
        document.addEventListener('DOMContentLoaded', async () => {
            const tahun = @json(request('tahun', date('Y')));
            const bulan = @json(request('bulan', date('n')));
            const container = document.getElementById('chart-container');
            const url = "{{ route('getLandingKomoditas') }}";

            try {
                const params = new URLSearchParams({ tahun, bulan });
                const res = await fetch(`${url}?${params.toString()}`);
                if (!res.ok) throw new Error('Gagal memuat data');
                const response = await res.json();

                container.innerHTML = '';

                response.forEach((item, i) => {
                    const chartId = `chart-${i}`;

                    const card = document.createElement('div');
                    card.className = 'bg-white shadow-md border border-gray-100 rounded-2xl p-5 flex flex-col gap-3';
                    card.innerHTML = `
                        <div class="flex items-center justify-between">
                            <h5 class="font-semibold text-gray-900">${item.komoditas}</h5>
                            <span class="text-xs px-3 py-1 rounded-full bg-orange-50 text-orange-600 font-semibold">${tahun}</span>
                        </div>
                        <div class="h-36">
                            <canvas id="${chartId}" class="w-full h-full"></canvas>
                        </div>
                        <div class="text-sm space-y-1.5 text-gray-700">
                            <p class="flex justify-between"><span class="text-gray-500">Bulan</span><span class="font-semibold text-gray-900">${item.summary.bulan}</span></p>
                            <p class="flex justify-between"><span class="text-gray-500">Total Stok</span><span class="font-semibold">${new Intl.NumberFormat('id-ID').format(item.summary.jumlah_stok_total)}</span></p>
                            <p class="flex justify-between"><span class="text-gray-500">Total Kebutuhan</span><span class="font-semibold">${new Intl.NumberFormat('id-ID').format(item.summary.total_kebutuhan)}</span></p>
                            <p class="flex justify-between"><span class="text-gray-500">Neraca</span>
                                <span class="font-semibold ${item.summary.neraca >= 0 ? 'text-emerald-600' : 'text-red-600'}">
                                    ${item.summary.neraca >= 0 ? '+' : ''}${new Intl.NumberFormat('id-ID').format(item.summary.neraca)}
                                </span>
                            </p>
                        </div>
                    `;

                    container.appendChild(card);

                    const ctx = document.getElementById(chartId).getContext('2d');
                    const gradient = ctx.createLinearGradient(0, 0, 0, 150);
                    gradient.addColorStop(0, 'rgba(249, 115, 22, 0.35)');
                    gradient.addColorStop(1, 'rgba(249, 115, 22, 0.05)');

                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: item.labels,
                            datasets: [{
                                label: 'Neraca',
                                data: item.data,
                                borderColor: 'rgb(249, 115, 22)',
                                backgroundColor: gradient,
                                tension: 0.35,
                                fill: true,
                                borderWidth: 3,
                                pointRadius: 3,
                                pointBackgroundColor: '#fff',
                                pointBorderColor: 'rgb(249, 115, 22)',
                                pointBorderWidth: 2,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    backgroundColor: '#0f172a',
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
                });
            } catch (err) {
                container.innerHTML = `<div class="col-span-full text-center text-red-600 text-sm">${err.message}</div>`;
            }
        });
    </script>


</body>

</html>
