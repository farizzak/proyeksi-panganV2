@extends('layouts.tailadmin')

@section('title', 'Rekap Ketersediaan')

@push('styles')
@endpush

@section('content')
<div class="container mx-auto px-4 py-6">

    <!-- Header -->
    <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-800 mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Rekap Ketersediaan</h2>
    </div>

    <!-- Grid Layout -->
    <div class="grid grid-cols-1 gap-6">

        <!-- FILTER SECTION -->
        <form method="GET" action="{{ route('rekap.index') }}" class="mb-4 flex flex-wrap items-end gap-3">
            <!-- Pilih Tahun -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tahun</label>
                <select id="filterYear" name="year"
                        class="px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
                    <option value="">-- Pilih Tahun --</option>
                    @foreach(range(date('Y')-5, date('Y')+1) as $y)
                        <option value="{{ $y }}" {{ (string)$year === (string)$y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Pilih Bulan -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bulan</label>
                <select id="filterMonth" name="month"
                        class="px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
                    <option value="">-- Pilih Bulan --</option>
                    @foreach(range(1,12) as $m)
                        <option value="{{ $m }}" {{ (string)$month === (string)$m ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" id="btnFilter" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                Filter
            </button>

            <button type="button" id="btnReset" class="px-4 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-lg">
                Reset
            </button>
        </form>

        <!-- DATA SECTION -->
        <div id="dataContainer" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
            @forelse($m_komoditas as $item)
                @php
                    $image = !empty($item->url_gambar) ? asset($item->url_gambar) : asset('noimage.png');
                    $monthName = DateTime::createFromFormat('!m', $item->bulan)->format('F');
                @endphp
                <div class="p-5 rounded-xl shadow border bg-white dark:bg-gray-800">
                    <h3 class="text-lg font-semibold text-blue-600 mb-2">{{ $item->nama_komoditas }}</h3>

                    <div class="w-full h-32 flex items-center justify-center overflow-hidden bg-gray-100 rounded mb-3">
                      <img src="{{ $image }}" alt="Preview {{ $item->nama_komoditas }}" class="object-cover h-full w-full">
                    </div>

                    <div class="text-sm text-gray-700 dark:text-gray-300">
                        Periode: {{ $monthName }} {{ $item->tahun }}
                    </div>

                    <div class="mt-3 text-sm text-gray-700 dark:text-gray-100">

                    <div>
                        <span class="font-semibold">Jumlah Total:</span>
                        {{ number_format($item->jumlah_stok_total) }} {{ $item->satuan }}
                    </div>

                    <div class="mt-1 flex items-center gap-2">
                        <span class="font-semibold">Ketahanan:</span>

                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                            @if($item->jumlah_stok_total < 10)
                                bg-red-500 text-white
                            @elseif($item->jumlah_stok_total < 50)
                                bg-yellow-400 text-gray-900
                            @else
                                bg-green-500 text-white
                            @endif
                        ">
                            @if($item->jumlah_stok_total < 10)
                                Rentan
                            @elseif($item->jumlah_stok_total < 50)
                                Waspada
                            @else
                                Tahan
                            @endif
                        </span>
                    </div>

                </div>

                </div>
            @empty
                <div class="col-span-full text-center text-gray-600 dark:text-gray-300 py-10">
                    Tidak ada data.
                </div>
            @endforelse
        </div>

    </div>

</div>
@endsection


@push('scripts')
<script>
    document.getElementById('btnReset')?.addEventListener('click', function () {
        window.location = "{{ route('rekap.index') }}";
    });
</script>
@endpush
