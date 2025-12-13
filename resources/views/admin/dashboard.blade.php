@extends('layouts.tailadmin')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>

        <style>
            .db-card{ transition: transform .18s ease, box-shadow .18s ease; border-radius: .75rem; color: #0f172a; }
            .db-card:hover{ transform: translateY(-6px); box-shadow: 0 18px 40px rgba(2,6,23,0.12); }
            /* db-icon removed temporarily - icons hidden */
            .db-value{ font-weight:800; font-size:1.6rem; color: rgba(2,6,23,0.9); }
            @media (max-width: 767px){ .db-grid{ grid-template-columns: repeat(1, minmax(0,1fr)); } }
            @media (min-width: 768px) and (max-width: 1023px){ .db-grid{ grid-template-columns: repeat(3, minmax(0,1fr)); } }
            @media (min-width: 1024px){ .db-grid{ grid-template-columns: repeat(4, minmax(0,1fr)); } }
        </style>

        <div class="db-grid grid gap-6">

            {{-- Card: Total Komoditas --}}
            <div class="db-card p-6" style="background: linear-gradient(to bottom right, #b7e9f6 0%, #f5fcff 100%); box-shadow: 0 6px 18px rgba(2,6,23,0.06);">
                <div style="display:flex; justify-content:flex-end; align-items:flex-start;">
                            <div style="color: #0ea5b7; font-weight:600;">&nbsp;</div>
                        </div>
                <div style="margin-top:10px;">
                    <div class="db-value">{{ $komoditasCount ?? 0 }}</div>
                    <div style="font-size:0.85rem; margin-top:6px;">Total Komoditas</div>
                    <a href="{{ route('komoditas.index') }}" class="inline-block mt-4 px-3 py-1 text-sm bg-white/30 rounded-full" style="background: rgba(255,255,255,0.9); color:#04576b; text-decoration:none;">Lihat Detail</a>
                </div>
            </div>

            {{-- Card: Total Aman (Minggu Ini) --}}
            <div class="db-card p-6" style="background: linear-gradient(to bottom right, #c9f7df 0%, #f5fcff 100%); box-shadow: 0 6px 18px rgba(2,6,23,0.06);">
                <div style="display:flex; justify-content:flex-end; align-items:flex-start;">
                            <div style="color:#064e3b; font-weight:600;">{{ ($status['aman'] ?? 0) . '%' }}</div>
                        </div>
                <div style="margin-top:10px;">
                    <div class="db-value">{{ ($status['aman'] ?? 0) . '%' }}</div>
                    <div style="font-size:0.85rem; margin-top:6px;">Total Aman (Minggu Ini)</div>
                    <a href="{{ route('ketersediaan.index') }}" class="inline-block mt-4 px-3 py-1 text-sm" style="background: rgba(255,255,255,0.9); color:#044d3a; text-decoration:none; border-radius:999px;">Lihat Detail</a>
                </div>
            </div>

            {{-- Card: Total Waspada --}}
            <div class="db-card p-6" style="background: linear-gradient(to bottom right, #fde9b2 0%, #f5fcff 100%); box-shadow: 0 6px 18px rgba(2,6,23,0.06);">
                <div style="display:flex; justify-content:flex-end; align-items:flex-start;">
                            <div style="color:#92400e; font-weight:600;">{{ ($status['waspada'] ?? 0) . '%' }}</div>
                        </div>
                <div style="margin-top:10px;">
                    <div class="db-value">{{ ($status['waspada'] ?? 0) . '%' }}</div>
                    <div style="font-size:0.85rem; margin-top:6px;">Total Waspada (Minggu Ini)</div>
                    <a href="{{ route('ketersediaan.index') }}" class="inline-block mt-4 px-3 py-1 text-sm" style="background: rgba(255,255,255,0.9); color:#92400e; text-decoration:none; border-radius:999px;">Lihat Detail</a>
                </div>
            </div>

            {{-- Card: Segera Intervensi --}}
            <div class="db-card p-6" style="background: linear-gradient(to bottom right, #f7c4c4 0%, #f5fcff 100%); box-shadow: 0 6px 18px rgba(2,6,23,0.06);">
                <div style="display:flex; justify-content:flex-end; align-items:flex-start;">
                            <div style="color:#7f1d1d; font-weight:600;">{{ ($status['segera'] ?? 0) . '%' }}</div>
                        </div>
                <div style="margin-top:10px;">
                    <div class="db-value">{{ ($status['segera'] ?? 0) . '%' }}</div>
                    <div style="font-size:0.85rem; margin-top:6px;">Segera Intervensi (Minggu Ini)</div>
                    <a href="{{ route('ketersediaan.index') }}" class="inline-block mt-4 px-3 py-1 text-sm" style="background: rgba(255,255,255,0.9); color:#7f1d1d; text-decoration:none; border-radius:999px;">Lihat Detail</a>
                </div>
            </div>

            {{-- Card: Total Users --}}
            <div class="db-card p-6" style="background: linear-gradient(to bottom right, #b7e9f6 0%, #f5fcff 100%); box-shadow: 0 6px 18px rgba(2,6,23,0.06);">
                <div style="display:flex; justify-content:flex-end; align-items:flex-start;">
                            <div style="color:#055e67; font-weight:600;">+{{ $userCount ? 5 : 0 }}</div>
                        </div>
                <div style="margin-top:10px;">
                    <div class="db-value">{{ $userCount ?? 0 }}</div>
                    <div style="font-size:0.85rem; margin-top:6px;">Total Users</div>
                    <a href="{{ route('users.index') }}" class="inline-block mt-4 px-3 py-1 text-sm" style="background: rgba(255,255,255,0.9); color:#04576b; text-decoration:none; border-radius:999px;">Lihat Detail</a>
                </div>
            </div>

            {{-- Card: Total Kategori --}}
            <div class="db-card p-6" style="background: linear-gradient(to bottom right, #ffd1c7 0%, #f5fcff 100%); box-shadow: 0 6px 18px rgba(2,6,23,0.06);">
                <div style="display:flex; justify-content:flex-end; align-items:flex-start;">
                            <div style="color:#7c2d12; font-weight:600;">&nbsp;</div>
                        </div>
                <div style="margin-top:10px;">
                    <div class="db-value">{{ $kategoriCount ?? 0 }}</div>
                    <div style="font-size:0.85rem; margin-top:6px;">Total Kategori</div>
                    <a href="{{ route('kategori.index') }}" class="inline-block mt-4 px-3 py-1 text-sm" style="background: rgba(255,255,255,0.9); color:#7c2d12; text-decoration:none; border-radius:999px;">Lihat Detail</a>
                </div>
            </div>

            {{-- Card: Surplus / Defisit --}}
            <div class="db-card p-6" style="background: linear-gradient(to bottom right, #b7e9f6 0%, #f5fcff 100%); box-shadow: 0 6px 18px rgba(2,6,23,0.06);">
                <div style="display:flex; justify-content:flex-end; align-items:flex-start;">
                            <div style="color:#04576b; font-weight:600;">&nbsp;</div>
                        </div>
                <div style="margin-top:10px;">
                    <div class="db-value">S: {{ number_format($surplusDefisit['surplus'] ?? 0,0,',','.') }} / D: {{ number_format($surplusDefisit['defisit'] ?? 0,0,',','.') }}</div>
                    <div style="font-size:0.85rem; margin-top:6px;">Surplus / Defisit (Bulan ini)</div>
                    <a href="{{ route('ketersediaan.index') }}" class="inline-block mt-4 px-3 py-1 text-sm" style="background: rgba(255,255,255,0.9); color:#04576b; text-decoration:none; border-radius:999px;">Lihat Detail</a>
                </div>
            </div>

        </div>

</div>
@endsection
