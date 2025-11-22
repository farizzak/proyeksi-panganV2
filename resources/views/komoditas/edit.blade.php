@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6">

    <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6">
        <h2 class="text-xl font-semibold mb-4">Edit Komoditas</h2>

        <form action="{{ route('komoditas.update', $komoditas->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Kategori --}}
            <div>
                <label class="block font-medium mb-1">Kategori</label>
                <select name="kategori_id" class="form-input w-full">
                    @foreach($kategori as $item)
                        <option value="{{ $item->id }}" {{ $komoditas->kategori_id == $item->id ? 'selected' : '' }}>
                            {{ $item->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Name --}}
            <div>
                <label class="block font-medium mb-1">Nama Komoditas</label>
                <input type="text" name="name" value="{{ $komoditas->name }}" class="form-input w-full">
            </div>

            {{-- Satuan --}}
            <div>
                <label class="block font-medium mb-1">Satuan</label>
                <input type="text" name="satuan" value="{{ $komoditas->satuan }}" class="form-input w-full">
            </div>

            {{-- Tipe Acuan --}}
            <div>
                <label class="block font-medium mb-1">Tipe Acuan</label>
                <select name="tipe_acuan" class="form-input w-full">
                    <option value="HAP" {{ $komoditas->tipe_acuan == 'HAP' ? 'selected' : '' }}>HAP</option>
                    <option value="HET" {{ $komoditas->tipe_acuan == 'HET' ? 'selected' : '' }}>HET</option>
                </select>
            </div>

            {{-- Batas --}}
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block mb-1 font-medium">Batas Aman</label>
                    <input type="number" name="batas_aman" value="{{ $komoditas->batas_aman }}" class="form-input w-full">
                </div>
                <div>
                    <label class="block mb-1 font-medium">Batas Waspada</label>
                    <input type="number" name="batas_waspada" value="{{ $komoditas->batas_waspada }}" class="form-input w-full">
                </div>
                <div>
                    <label class="block mb-1 font-medium">Batas Intervensi</label>
                    <input type="number" name="batas_intervensi" value="{{ $komoditas->batas_intervensi }}" class="form-input w-full">
                </div>
            </div>

            {{-- Gambar --}}
            <div>
                <label class="block mb-1 font-medium">Gambar (opsional)</label>
                <input type="file" name="url_gambar" class="form-input w-full">

                @if($komoditas->url_gambar)
                    <img src="{{ asset($komoditas->url_gambar) }}" class="w-32 mt-3 rounded shadow">
                @endif
            </div>

            <div class="pt-4 flex justify-end">
                <a href="{{ route('komoditas.index') }}" class="btn-secondary mr-3">Batal</a>
                <button class="btn-primary">Update</button>
            </div>
        </form>
    </div>

</div>
@endsection
