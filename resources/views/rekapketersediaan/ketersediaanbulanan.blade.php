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
                    <h1 class="m-0 text-dark">Proyeksi Data Stok Ketersediaan Bahan Pangan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Laporan Ketersediaan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" style="background: linear-gradient(135deg, var(--primary-red), var(--secondary-red))">
            <div class="text-center mb-3">
                <h5><strong style="color: white;">PROYEKSI DATA STOK KETERSEDIAAN BAHAN PANGAN UTAMA / STRATEGIS</strong></h5>
                <p style="color: white;">Bulan : {{ \Carbon\Carbon::create()->month($month)->year($year)->translatedFormat('F Y') }}</p>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered" style="width: 100%; font-size: 14px;">
                <thead style="background-color: #d6e4f0; text-align: center;">
                    <tr>
                        <th style="border: 1px solid black;">No</th>
                        <th style="border: 1px solid black;">Komoditas</th>
                        <th style="border: 1px solid black;">Satuan</th>
                        <th style="border: 1px solid black;">Ketersediaan</th>
                        <th style="border: 1px solid black;">Asal Pasokan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($komoditas as $index => $item)
                    <tr>
                        <td style="border: 1px solid black; text-align: center;">{{ $index + 1 }}</td>
                        <td style="border: 1px solid black;">{{ $item->nama_komoditas }}</td>
                        <td style="border: 1px solid black;">{{ $item->satuan }}</td>
                        <td style="border: 1px solid black;">{{ number_format($item->jumlah_stok_total, 2) }}</td>
                        <td style="border: 1px solid black;">{{ $item->asal_pasokan }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-right mt-5">
                <p>Semarang, {{ \Carbon\Carbon::create()->month($month)->year($year)->translatedFormat('F Y') }}</p>
                
                <p><strong>Kepala Bidang Ketersediaan dan<br>Kewaspadaan Pangan</strong></p>
                <br><br>
                <p><strong>Sri Rahayuningsih, S.Sos., MM</strong></p>
            </div>
        </div>
    </div>
</div>
@endsection
