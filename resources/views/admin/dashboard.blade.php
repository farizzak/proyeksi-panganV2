@extends('layouts.tailadmin')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>
    <div class="dashboard-grid">
        @include('admin.partials._metric-card', [
            'title' => 'Total Komoditas',
            'value' => $komoditasCount ?? 0,
            'icon' => 'fa-solid fa-box',
            'route' => route('komoditas.index'),
            'gradientClass' => 'card-gradient-cyan',
            'gradient' => 'linear-gradient(135deg,#06b6d4 0%,#7dd3fc 100%)',
            'iconBgClass' => 'bg-white/30'
        ])

        @include('admin.partials._metric-card', [
            'title' => 'Total Aman (Minggu Ini)',
            'value' => ($status['aman'] ?? 0) . '%',
            'icon' => 'fa-solid fa-shield-check',
            'route' => route('ketersediaan.index'),
            'gradientClass' => 'card-gradient-green',
            'gradient' => 'linear-gradient(135deg,#10b981 0%,#34d399 100%)',
            'iconBgClass' => 'bg-white/30',
            'trend' => '+8.2%',
            'trendClass' => 'text-green-700'
        ])

        @include('admin.partials._metric-card', [
            'title' => 'Total Waspada (Minggu Ini)',
            'value' => ($status['waspada'] ?? 0) . '%',
            'icon' => 'fa-solid fa-triangle-exclamation',
            'route' => route('ketersediaan.index'),
            'gradientClass' => 'card-gradient-yellow',
            'gradient' => 'linear-gradient(135deg,#f59e0b 0%,#fbbf24 100%)',
            'iconBgClass' => 'bg-white/30',
            'trend' => '+0%',
            'trendClass' => 'text-yellow-700'
        ])

        @include('admin.partials._metric-card', [
            'title' => 'Segera Intervensi (Minggu Ini)',
            'value' => ($status['segera'] ?? 0) . '%',
            'icon' => 'fa-solid fa-triangle-exclamation',
            'route' => route('ketersediaan.index'),
            'gradientClass' => 'card-gradient-red',
            'gradient' => 'linear-gradient(135deg,#ef4444 0%,#f87171 100%)',
            'iconBgClass' => 'bg-white/30',
            'trend' => '+0%',
            'trendClass' => 'text-red-700'
        ])

        @include('admin.partials._metric-card', [
            'title' => 'Total Users',
            'value' => $userCount ?? 0,
            'icon' => 'fa-solid fa-users',
            'route' => route('users.index'),
            'gradientClass' => 'card-gradient-cyan',
            'gradient' => 'linear-gradient(135deg,#06b6d4 0%,#7dd3fc 100%)',
            'iconBgClass' => 'bg-white/30',
            'trend' => '+5',
            'trendClass' => 'text-sky-700'
        ])

        @include('admin.partials._metric-card', [
            'title' => 'Total Kategori',
            'value' => $kategoriCount ?? 0,
            'icon' => 'fa-solid fa-layer-group',
            'route' => route('kategori.index'),
            'gradientClass' => 'card-gradient-rose',
            'gradient' => 'linear-gradient(135deg,#fb7185 0%,#f97316 100%)',
            'iconBgClass' => 'bg-white/30'
        ])

        @include('admin.partials._metric-card', [
            'title' => 'Total Komoditas Minggu Ini',
            'value' => $komoditasThisWeek ?? 0,
            'icon' => 'fa-solid fa-calendar-week',
            'route' => route('ketersediaan.index'),
            'gradientClass' => 'card-gradient-cyan',
            'gradient' => 'linear-gradient(135deg,#06b6d4 0%,#34d399 100%)',
            'iconBgClass' => 'bg-white/30'
        ])

        @include('admin.partials._metric-card', [
            'title' => 'Surplus / Defisit (Bulan ini)',
            'value' => 'S: '.number_format($surplusDefisit['surplus'] ?? 0,0,',','.')." / D: ".number_format($surplusDefisit['defisit'] ?? 0,0,',','.'),
            'icon' => 'fa-solid fa-chart-pie',
            'route' => route('ketersediaan.index'),
            'gradientClass' => 'card-gradient-cyan',
            'gradient' => 'linear-gradient(135deg,#06b6d4 0%,#7dd3fc 100%)',
            'iconBgClass' => 'bg-white/30'
        ])
    </div>

    <!-- Filter form -->
    <div class="mt-6 bg-white dark:bg-gray-800 rounded-lg p-4">
        <form method="GET" action="{{ route('dashboard') }}" class="flex items-center gap-4">
            <label class="font-medium text-gray-700 dark:text-gray-200">Bulan:</label>
            <select name="month" class="border rounded px-2 py-1">
                @foreach(range(1,12) as $m)
                    <option value="{{ $m }}" {{ (int)($selectedMonth ?? now()->month) === $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                @endforeach
            </select>

            <label class="font-medium text-gray-700 dark:text-gray-200">Tahun:</label>
            <select name="year" class="border rounded px-2 py-1">
                @foreach(range(now()->year, now()->year - 5) as $y)
                    <option value="{{ $y }}" {{ (int)($selectedYear ?? now()->year) === $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Submit</button>
        </form>
    </div>
</div>
@endsection
