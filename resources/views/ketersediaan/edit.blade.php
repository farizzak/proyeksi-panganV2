@extends('layouts.tailadmin')

@section('title', 'Edit Ketersediaan')
@push('styles')
    <style>
        html.dark #submitRoleBtn {
        background-color: rgb(249 115 22) !important; /* orange-500 */
        border-color: transparent !important;
        color: #fff !important;
        }

        html.dark #submitRoleBtn:hover {
        background-color: rgb(234 88 12) !important; /* orange-600 */
        }
    </style>
@endpush

@section('content')
<div class="grid grid-cols-1 gap-6">
    <div class="space-y-6">

        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

            {{-- Header --}}
            <div class="px-5 py-4 sm:px-6 sm:py-5">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                    Edit Ketersediaan Pangan
                </h3>
            </div>

            {{-- FORM --}}
            <form action="{{ route('ketersediaan.update', $ketersediaan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">

                    {{-- Input tanggal --}}
                    <div class="mb-4">
                        <label class="block font-medium mb-1 text-gray-700">Pilih Tanggal:</label>
                        <input type="date" name="tanggal"
                               value="{{ $ketersediaan->tanggal }}"
                               class="w-52 px-3 py-2 border rounded-lg" required>
                    </div>

                    {{-- Table --}}
                    <div class="overflow-auto">
                        <table class="min-w-full border border-gray-300 text-sm">
                            <thead class="text-white" style="background-color: #6366F1;">
                                <tr>
                                    <th class="px-3 py-2 border">Komoditas</th>
                                    <th class="px-3 py-2 border">Harga Siharpa (Rp)</th>
                                    <th class="px-3 py-2 border">HAP/HET (Rp)</th>
                                    <th class="px-3 py-2 border">Stok Akhir (Ton)</th>
                                    <th class="px-3 py-2 border">Pertanian (Ton)</th>
                                    <th class="px-3 py-2 border">Distributor</th>
                                    <th class="px-3 py-2 border">Pasar</th>
                                    <th class="px-3 py-2 border">Bulog</th>
                                    <th class="px-3 py-2 border">Kebutuhan RT</th>
                                    <th class="px-3 py-2 border">Kebutuhan Non RT</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($komoditas as $row)
                                @php
                                    // Ambil detail dari array detail berdasarkan komoditas_id
                                    $d = $detail[$row->id] ?? null;
                                @endphp

                                <tr class="border-b">

                                    {{-- Komoditas --}}
                                    <td class="px-3 py-2 border font-medium text-gray-800">
                                        {{ $row->name }}
                                        <input type="hidden" name="komoditas_id[]" value="{{ $row->id }}">
                                    </td>

                                    {{-- Harga Siharga --}}
                                    <td class="px-2 py-1 border">
                                        <input type="number" step="0.01" name="harga_h_1[]"
                                            value="{{ $d->harga_sebelumnya ?? 0 }}"
                                            class="w-full px-2 py-1 border rounded">
                                    </td>

                                    {{-- HAP/HET --}}
                                    <td class="px-2 py-1 border">
                                        <input type="number" step="0.01" name="harga_hari_ini[]"
                                            value="{{ $d->harga_hari_ini ?? 0 }}"
                                            class="w-full px-2 py-1 border rounded">
                                    </td>

                                    {{-- Stok Akhir --}}
                                    <td class="px-2 py-1 border">
                                        <input type="number" step="0.01" name="stok_h_1[]"
                                            value="{{ $d->stok_awal ?? 0 }}"
                                            class="w-full px-2 py-1 border rounded">
                                    </td>

                                    {{-- Pertanian --}}
                                    <td class="px-2 py-1 border">
                                        <input type="number" step="0.01" name="stok_pertanian[]"
                                            value="{{ $d->stok_produksi ?? 0 }}"
                                            class="w-full px-2 py-1 border rounded">
                                    </td>

                                    {{-- Distributor --}}
                                    <td class="px-2 py-1 border">
                                        <input type="number" step="0.01" name="stok_distributor[]"
                                            value="{{ $d->stok_distributor ?? 0 }}"
                                            class="w-full px-2 py-1 border rounded">
                                    </td>

                                    {{-- Pasar --}}
                                    <td class="px-2 py-1 border">
                                        <input type="number" step="0.01" name="stok_pasar[]"
                                            value="{{ $d->stok_pasar ?? 0 }}"
                                            class="w-full px-2 py-1 border rounded">
                                    </td>

                                    {{-- Bulog --}}
                                    <td class="px-2 py-1 border">
                                        <input type="number" step="0.01" name="stok_bulog[]"
                                            value="{{ $d->stok_bulog ?? 0 }}"
                                            class="w-full px-2 py-1 border rounded">
                                    </td>

                                    {{-- Kebutuhan RT --}}
                                    <td class="px-2 py-1 border">
                                        <input type="number" step="0.01" name="stokrt[]"
                                            value="{{ $d->kebutuhan_rt ?? 0 }}"
                                            class="w-full px-2 py-1 border rounded">
                                    </td>

                                    {{-- Kebutuhan Non RT --}}
                                    <td class="px-2 py-1 border">
                                        <input type="number" step="0.01" name="stoknonrt[]"
                                            value="{{ $d->kebutuhan_nonrt ?? 0 }}"
                                            class="w-full px-2 py-1 border rounded">
                                    </td>
                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

                {{-- Buttons --}}
                <div class="flex justify-end gap-3 px-6 py-4 border-t border-gray-100 dark:border-gray-800">
                    <a href="{{ route('ketersediaan.index') }}"
                       class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700
                              text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                        Kembali
                    </a>

                    <button id="submitRoleBtn" type="submit" class="btn-brand-stable bg-orange-600 hover:bg-orange-700 dark:bg-orange-600 dark:hover:bg-orange-700 px-4 py-2 text-sm font-medium text-white rounded-lg flex items-center gap-1">
                        Simpan
                    </button>
                </div>

            </form>

        </div>

    </div>
</div>
@endsection
