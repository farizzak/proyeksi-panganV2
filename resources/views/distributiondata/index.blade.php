@extends('layouts.tailadmin')

@section('title', 'Distributions Data')
@push('styles')
    <style>

        html.dark #cariBtn {
            background-color: rgb(249 115 22) !important; /* orange-500 */
            border-color: transparent !important;
            color: #fff !important;
        }

        html.dark #cariBtn:hover {
            background-color: rgb(234 88 12) !important; /* orange-600 */
        }

        html.dark #thDistribution {
            background-color: rgb(249 115 22) !important; /* orange-500 */
            border-color: transparent !important;
            color: #fff !important;
        }

        html.dark #thDistribution:hover {
            background-color: rgb(234 88 12) !important; /* orange-600 */
        }
    </style>
    
@endpush

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-800 mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Distributions Data</h2>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="rounded-t-2xl bg-gradient-to-r from-orange-600 via-orange-600 to-orange-700 px-6 py-4">
                <h2 class="text-lg font-semibold text-white">Data Distributions</h2>
            </div>
            <div class="px-6 py-5">
                <form method="GET" action="{{ route('distribution_data.index') }}" class="grid grid-cols-1 gap-4 md:grid-cols-4">
                    <div class="space-y-2">
                        <label for="kecamatan" class="text-sm font-medium text-gray-700">Kecamatan</label>
                        <select id="kecamatan" name="kecamatan" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200">
                            <option value="">-- Pilih Kecamatan --</option>
                            @foreach($kecamatan as $name => $label)
                                <option value="{{ $name }}" {{ $request->kecamatan == $name ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label for="month" class="text-sm font-medium text-gray-700">Bulan</label>
                        <select id="month" name="month" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200">
                            <option value="">Pilih Bulan</option>
                            @foreach($months as $m)
                                <option value="{{ $m }}" {{ $request->month == $m ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', (int) $m)->format('F') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label for="year" class="text-sm font-medium text-gray-700">Tahun</label>
                        <select id="years" name="year" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200">
                            <option value="">Pilih Tahun</option>
                            @foreach($years as $y)
                                <option value="{{ $y }}" {{ $request->year == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" id="cariBtn" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-orange-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-200">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m1.85-5.4a7.25 7.25 0 1 1-14.5 0 7.25 7.25 0 0 1 14.5 0Z" />
                            </svg>
                            Cari
                        </button>
                        <a href="{{ route('distribution_data.index') }}" class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-orange-200">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wider text-gray-500" id="thDistribution">
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">Kecamatan</th>
                            <th class="px-4 py-3">Komoditas</th>
                            <th class="px-4 py-3">Pasokan</th>
                            <th class="px-4 py-3">Satuan</th>
                            <th class="px-4 py-3">Penjualan</th>
                            <th class="px-4 py-3">Stock</th>
                            <th class="px-4 py-3">Harga</th>
                            <th class="px-4 py-3">Distributor</th>
                            <th class="px-4 py-3">Pedagang</th>
                            <th class="px-4 py-3">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        @forelse($data as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $item->id }}</td>
                                <td class="px-4 py-3">{{ $item->kecamatan }}</td>
                                <td class="px-4 py-3">{{ $item->komoditas }}</td>
                                <td class="px-4 py-3">{{ $item->pasokan }}</td>
                                <td class="px-4 py-3">{{ $item->satuan_pasokan }}</td>
                                <td class="px-4 py-3">{{ $item->penjualan }}</td>
                                <td class="px-4 py-3">{{ $item->stock }}</td>
                                <td class="px-4 py-3">{{ $item->harga }}</td>
                                <td class="px-4 py-3">{{ $item->distributor }}</td>
                                <td class="px-4 py-3">{{ $item->pedagang }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $item->created_at->format('d-m-Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="px-4 py-8 text-center text-gray-500">Data tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-gray-100 px-6 py-4">
                {{ $data->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
