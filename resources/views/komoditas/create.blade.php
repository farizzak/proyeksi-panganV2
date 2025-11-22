@extends('layouts.tailadmin')

@section('content')
<div class="grid grid-cols-1 gap-6">
    <div class="space-y-6">

        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

            {{-- Header --}}
            <div class="px-5 py-4 sm:px-6 sm:py-5">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                    Tambah Komoditas
                </h3>
            </div>

            {{-- FORM --}}
            <form action="{{ route('komoditas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">

                    {{-- Kategori --}}
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Kategori
                        </label>

                        <div x-data="{ selected: false }" class="relative bg-transparent">
                            <select name="kategori_id"
                                class="dark:bg-dark-900 shadow-theme-xs
                                       focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800
                                       h-11 w-full appearance-none rounded-lg border border-gray-300
                                       bg-transparent bg-none px-4 py-2.5 pr-11 text-sm
                                       text-gray-800 dark:bg-gray-900 dark:text-white/90
                                       dark:border-gray-700 dark:placeholder:text-white/30"
                                :class="selected && 'text-gray-800 dark:text-white/90'"
                                @change="selected = true">

                                <option value="" class="text-gray-400 dark:bg-gray-900 dark:text-gray-400">
                                    -- Pilih Kategori --
                                </option>

                                @foreach($kategories as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name }}
                                    </option>
                                @endforeach

                            </select>

                            <span class="pointer-events-none absolute top-1/2 right-4 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M4.8 7.4L10 12.6L15.2 7.4"
                                          stroke-width="1.5"
                                          stroke-linecap="round"
                                          stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </div>
                    </div>

                    {{-- Nama Komoditas --}}
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Nama Komoditas
                        </label>
                        <input type="text" name="name"
                               class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10
                                      dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300
                                      bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400
                                      dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                    </div>

                    {{-- Satuan --}}
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Satuan
                        </label>
                        <input type="text" name="satuan"
                               class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10
                                      dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300
                                      bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400
                                      dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                    </div>

                    {{-- Tipe Acuan --}}
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Tipe Acuan
                        </label>

                        <div x-data="{ selected: false }" class="relative bg-transparent">
                            <select name="tipe_acuan"
                                class="dark:bg-dark-900 shadow-theme-xs
                                       focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800
                                       h-11 w-full appearance-none rounded-lg border border-gray-300
                                       bg-transparent bg-none px-4 py-2.5 pr-11 text-sm
                                       text-gray-800 dark:bg-gray-900 dark:text-white/90
                                       dark:border-gray-700 dark:placeholder:text-white/30"
                                :class="selected && 'text-gray-800 dark:text-white/90'"
                                @change="selected = true">

                                <option value="" class="text-gray-400 dark:text-gray-400">
                                    -- Pilih Tipe Acuan --
                                </option>

                                <option value="HAP">HAP</option>
                                <option value="HET">HET</option>

                            </select>

                            <span class="pointer-events-none absolute top-1/2 right-4 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M4.8 7.4L10 12.6L15.2 7.4"
                                          stroke-width="1.5"
                                          stroke-linecap="round"
                                          stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </div>
                    </div>

                    {{-- Batas Aman --}}
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Batas Aman (%)
                        </label>
                        <input type="number" name="batas_aman"
                               class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10
                                      dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300
                                      bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700
                                      dark:bg-gray-900 dark:text-white/90">
                    </div>

                    {{-- Batas Waspada --}}
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Batas Waspada (%)
                        </label>
                        <input type="number" name="batas_waspada"
                               class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10
                                      dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300
                                      bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700
                                      dark:bg-gray-900 dark:text-white/90">
                    </div>

                    {{-- Batas Intervensi --}}
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Batas Intervensi (%)
                        </label>
                        <input type="number" name="batas_intervensi"
                               class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10
                                      dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300
                                      bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700
                                      dark:bg-gray-900 dark:text-white/90">
                    </div>

                    {{-- Gambar --}}
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Upload Gambar
                        </label>
                        <input type="file" name="url_gambar"
                               class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10
                                      dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300
                                      bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700
                                      dark:bg-gray-900 dark:text-white/90">
                    </div>

                </div>

                {{-- Button --}}
                <div class="flex justify-end gap-3 px-6 py-4 border-t border-gray-100 dark:border-gray-800">
                    <a href="{{ route('komoditas.index') }}"
                       class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                        Kembali
                    </a>

                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">
                        Simpan
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>
@endsection
