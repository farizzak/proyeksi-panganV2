@extends('layouts.tailadmin')
@section('title', 'Edit Komoditas')

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

            <!-- Header -->
            <div class="px-5 py-4 sm:px-6 sm:py-5">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                    Edit Komoditas
                </h3>
            </div>

            <!-- Form -->
            <form action="{{ route('komoditas.update', $komoditas->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">


                    <!-- Kategori -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Kategori
                        </label>

                        <div x-data="{ selected: '{{ $komoditas->kategori_id }}' !== '' }" class="relative z-20 bg-transparent">
                            <select
                                name="kategori_id"
                                class="dark:bg-dark-900 shadow-theme-xs h-11 w-full appearance-none
                                       rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11
                                       text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300
                                       focus:ring-brand-500/10 focus:ring-3 outline-hidden
                                       dark:border-gray-700 dark:bg-gray-900 dark:text-white/90
                                       dark:placeholder:text-white/30"
                                @change="selected = true"
                            >
                                <option value="">Pilih Kategori</option>

                                @foreach($kategories as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $komoditas->kategori_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>

                            <span class="pointer-events-none absolute top-1/2 right-4 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20">
                                    <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </div>
                    </div>

                    <!-- Nama Komoditas -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Nama Komoditas
                        </label>
                        <input
                            type="text"
                            name="name"
                            value="{{ $komoditas->name }}"
                            class="dark:bg-dark-900 shadow-theme-xs h-11 w-full rounded-lg border border-gray-300
                                   bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400
                                   focus:border-brand-300 focus:ring-brand-500/10 focus:ring-3 outline-hidden
                                   dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                        />
                    </div>

                    <!-- Satuan -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Satuan
                        </label>
                        <input
                            type="text"
                            name="satuan"
                            value="{{ $komoditas->satuan }}"
                            class="dark:bg-dark-900 shadow-theme-xs h-11 w-full rounded-lg border border-gray-300
                                   bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400
                                   focus:border-brand-300 focus:ring-brand-500/10 focus:ring-3 outline-hidden
                                   dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                        />
                    </div>

                    <!-- Tipe Acuan -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Tipe Acuan
                        </label>

                        <div x-data="{ selected: '{{ $komoditas->tipe_acuan }}' !== '' }" class="relative z-20 bg-transparent">
                            <select
                                name="tipe_acuan"
                                class="dark:bg-dark-900 shadow-theme-xs h-11 w-full appearance-none
                                       rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11
                                       text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300
                                       focus:ring-brand-500/10 focus:ring-3 outline-hidden
                                       dark:border-gray-700 dark:bg-gray-900 dark:text-white/90
                                       dark:placeholder:text-white/30"
                                @change="selected = true"
                            >
                                <option value="">Pilih Tipe Acuan</option>
                                <option value="HAP" {{ $komoditas->tipe_acuan == 'HAP' ? 'selected' : '' }}>HAP</option>
                                <option value="HET" {{ $komoditas->tipe_acuan == 'HET' ? 'selected' : '' }}>HET</option>
                            </select>

                            <span class="pointer-events-none absolute top-1/2 right-4 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20">
                                    <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </div>
                    </div>

                    <!-- Batas -->
                    <div>
                        <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-400">Batas Aman (%)</label>
                        <input type="number" step="0.01" name="batas_aman" value="{{ $komoditas->batas_aman }}"
                            class="dark:bg-dark-900 shadow-theme-xs h-11 w-full rounded-lg border border-gray-300 bg-transparent
                                   px-4 py-2.5 text-sm text-gray-800 focus:border-brand-300 focus:ring-brand-500/10 focus:ring-3
                                   outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"/>
                    </div>

                    <div>
                        <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-400">Batas Waspada (%)</label>
                        <input type="number" step="0.01" name="batas_waspada" value="{{ $komoditas->batas_waspada }}"
                            class="dark:bg-dark-900 shadow-theme-xs h-11 w-full rounded-lg border border-gray-300 bg-transparent
                                   px-4 py-2.5 text-sm text-gray-800 focus:border-brand-300 focus:ring-brand-500/10 focus:ring-3
                                   outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"/>
                    </div>

                    <div>
                        <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-400">Batas Intervensi (%)</label>
                        <input type="number" step="0.01" name="batas_intervensi" value="{{ $komoditas->batas_intervensi }}"
                            class="dark:bg-dark-900 shadow-theme-xs h-11 w-full rounded-lg border border-gray-300 bg-transparent
                                   px-4 py-2.5 text-sm text-gray-800 focus:border-brand-300 focus:ring-brand-500/10 focus:ring-3
                                   outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"/>
                    </div>

                    <!-- Gambar -->
                    <div>
                        <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-400">Upload Gambar Baru</label>
                        <input
                            type="file"
                            name="url_gambar"
                            class="dark:bg-dark-900 shadow-theme-xs h-11 w-full rounded-lg border border-gray-300
                                   bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:border-brand-300
                                   focus:ring-brand-500/10 focus:ring-3 outline-hidden
                                   dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                        />

                        @if($komoditas->url_gambar)
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Gambar saat ini:</p>
                            <img src="{{ asset($komoditas->url_gambar) }}" class="mt-2 h-20 rounded-lg border dark:border-gray-700" />
                        @endif
                    </div>

                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-end gap-3 px-5 pb-5">
                    <a href="{{ route('komoditas.index') }}" class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 text-sm">Kembali</a>
                    <button id="submitRoleBtn" class="px-5 py-2 rounded-lg bg-brand-600 text-white text-sm hover:bg-brand-700">
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
