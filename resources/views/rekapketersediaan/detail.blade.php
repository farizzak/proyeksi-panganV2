@extends('layouts.master')

@section('content')
<style>
    :root {
   --primary-red: #E63946;
   --secondary-red: #A31621;
   --light-red: #FF8B8B;
   --dark-red: #6A040F;
   --light-color: #F5F5F5;
 }

.card {
    height: 100%; /* Pastikan semua card memiliki tinggi sama */
}
.card-img-top {
    width: 100%;
    height: 150px; /* Atur tinggi sesuai kebutuhan */
    object-fit: cover; /* Memastikan gambar dipotong proporsional */
    border-radius: 5px; /* Opsional: membuat sudut lebih halus */
}
.card-body {
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* Agar isi card rapi */
}
</style>
<div class="container-fluid">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Detail Komoditas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#" class="text-danger">Home</a></li>
                        <li class="breadcrumb-item active">Rekap Komoditas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" style="background: linear-gradient(135deg, var(--primary-red), var(--secondary-red))">
            <h3 class="card-title text-white">
               
            </h3>
            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 250px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search...">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-light">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
            <div class="card-body">
                <h1 class="mb-4">Rekap Ketersediaan: {{ $komoditas->name }}</h1>

                    <form method="GET" action="{{ route('admin.rekapketersediaan.detail', ['id' => $komoditas->id]) }}" class="form-inline mb-4">
                        <div class="form-group mr-2">
                            <label for="year" class="mr-2">Tahun:</label>
                            <select id="year" name="year" class="form-control">
                                @for($y = now()->year; $y >= now()->year - 10; $y--)
                                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Tampilkan</button>
                    </form>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Bulan</th>
                                <th>Stok Awal</th>
                                <th>Stok Produksi</th>
                                <th>Stok Distibutor</th>
                                <th>Stok Bulog</th>
                                <th>Jumlah Stok Total</th>
                                <th>Kebutuhan RT</th>
                                <th>Kebutuhan NonRT</th>
                                <th>Total Kebutuhan</th>
                                <th>Neraca</th>
                                <th>Angka Kecukupan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($details as $item)
                                <tr>
                                    <td>{{ DateTime::createFromFormat('!m', $item->bulan)->format('F') }}</td>
                                    <td>{{ number_format($item->stok_awal) }}</td>
                                    <td>{{ number_format($item->stok_produksi) }}</td>
                                    <td>{{ number_format($item->stok_distributor) }}</td>
                                    <td>{{ number_format($item->stok_bulog) }}</td>
                                    <td>{{ number_format($item->jumlah_stok_total) }}</td>
                                    <td>{{ number_format($item->kebutuhan_rt) }}</td>
                                    <td>{{ number_format($item->kebutuhan_nonrt) }}</td>
                                    <td>{{ number_format($item->total_kebutuhan) }}</td>
                                    <td>{{ number_format($item->neraca) }}</td>
                                    <td>{{ number_format($item->angka_kecukupan) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center">Tidak ada data tersedia</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
    
</div>
@endsection
