<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tidak Ditemukan</title>
    <link rel="icon" href="{{ asset('tailadmin/images/logo/logo_pemkot.svg') }}" type="image/svg+xml">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f6f7fb;
            font-family: 'Poppins', sans-serif;
            color: #1f2937;
        }
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08);
        }
        .btn-primary {
            background: #3C50E0;
            border: none;
        }
        .btn-primary:hover {
            background: #273AC7;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card text-center p-4 p-md-5">
                <img src="{{ asset('tailadmin/images/error/404-dark.svg') }}" alt="404 Not Found" class="img-fluid mb-4">
                <h2 class="fw-bold mb-2">Halaman tidak ditemukan</h2>
                <p class="text-muted mb-4">
                    Maaf, halaman yang Anda cari tidak tersedia atau sudah dipindahkan.
                </p>
                <a href="{{ url('/') }}" class="btn btn-primary px-4">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
