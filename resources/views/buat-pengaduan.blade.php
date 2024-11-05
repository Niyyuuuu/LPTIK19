<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pengaduan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('img/logo-kemhan.png') }}" type="image/png">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
        #navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 999;
        }
        #pengaduan {  
            padding-top: 120px;
            position: relative;
            overflow: hidden;
        }
        .mb-3 {
            width: 85%;
            margin: auto;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .form-group {
            flex: 1 1 45%;
            min-width: 200px;
        }
        .subjek {
            width: 85%;
            margin: auto;
        }
        .pesan {
            width: 85%;
            margin-bottom: 1rem;
            margin-left: auto;
            margin-right: auto;
        }
        .file {
            width: 85%;
            margin-bottom: 2rem;
            margin-left: auto;
            margin-right: auto;
        }
        .form-group {
            flex: 1;
        }
        #buat-tiket-h1 {
            font-size: 2rem;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
        .button-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 4rem;
        }
        #success-alert {
            color: green;
            text-align: center;
            width: 35%;
            margin: auto;
        }
        span {
            color: red;
        }
        @media (max-width: 768px) {
            #buat-tiket-h1 {
                font-size: 2rem;
                margin-top: 2rem;
            }
            .form-group {
                flex: 1 1 100%; 
            }
            #success-alert {
            color: green;
            text-align: center;
            width: 65%;
            margin: auto;
        }
        }
    </style>
</head>
<body class="relative">
    <section id="pengaduan" class="bg-gray-400">
    <nav class="bg-dark p-4 fixed-top z-10" id="navbar">
        <form class="container-fluid justify-content-left mt-1 ms-2">
          <button onclick="window.location.href='/dashboard-pengaduan'" class="btn btn-outline-danger mb-2" type="button">Dashboard Pengaduan</button>
        </form>
    </nav>
    @if (session('success'))
    <div id="success-alert" class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<form action="{{ route('buat-pengaduan') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="container mx-auto relative z-10 mb-20">
        <h1 id="buat-tiket-h1" class="fw-bold text-center">Buat Tiket Baru</h1>
    </div>
    <div class="mb-3 form-container">
        <div class="form-group">
            <label for="Username" class="form-label ms-2">Nama</label>
            <input type="type" class="form-control" id="Username" value="{{ Auth::user()->name }}" disabled>
        </div>
        <div class="form-group">
            <label for="Email" class="form-label ms-2">Email</label>
            <input type="email" class="form-control" id="Email" value="{{ Auth::user()->email }}" disabled>
        </div>
    </div>
    <div class="subjek" style="margin-bottom: 1rem;">
        <label for="subjek" class="form-label">Subjek <span>*</span></label>
        <textarea class="form-control" name="subjek" id="subjek" placeholder="Contoh : Koneksi internet lambat" rows="2"></textarea>
        @error('subjek')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3 form-container">
        <div class="form-group">
            <label for="permasalahan" class="form-label">Permasalahan <span>*</span></label>
            <select class="form-select" name="permasalahan" id="permasalahan" aria-label="permasalahan">
                <option value="Jaringan">Jaringan</option>
                <option value="Software">Software</option>
                <option value="Hardware">Hardware</option>
            </select>
        </div>
        <div class="form-group">
            <label for="satker" class="form-label">Satker <span>*</span></label>
            <select class="form-select" name="satker" id="satker" aria-label="satker">
                @foreach($satkers as $satker)
                    <option value="{{ $satker->id }}">{{ $satker->nama_satker }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="prioritas" class="form-label">Prioritas <span>*</span></label>
            <select class="form-select" name="prioritas" id="prioritas" aria-label="prioritas">
                <option value="Tinggi">Tinggi</option>
                <option value="Sedang">Sedang</option>
                <option value="Rendah">Rendah</option>
            </select>
        </div>
        <div class="form-group">
            <label for="area" class="form-label">Area Laporan <span>*</span></label>
            <select class="form-select" name="area" id="area" aria-label="area">
                <option value="Kemhan">Kemhan</option>
                <option value="Luar Kemhan">Luar Kemhan</option>
            </select>
        </div>
    </div>
    <div class="pesan" style="margin-bottom: 1rem;">
        <label for="pesan" class="form-label">Pesan <span>*</span></label>
        <textarea class="form-control" id="pesan" name="pesan" placeholder="Contoh : Mohon bantuan untuk memperbaiki koneksi internet di Lantai 2, Terima kasih." rows="6"></textarea>
        @error('pesan')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="file">
        <label for="formFile" class="form-label">Lampiran</label>
        <input class="form-control" type="file" name="lampiran" id="lampiran">
        <small class="text-danger" id="file-error" style="display: none;">Ukuran file melebihi 5MB!</small>
    </div>
    <div class="button-container">
        <button type="submit" class="btn btn-primary">Kirim</button>
        <button onclick="window.location.href='/daftar-pengaduan'" type="button" class="btn btn-outline-danger">Batal</button>
    </div>
</form>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('lampiran').addEventListener('change', function() {
        const fileInput = document.getElementById('lampiran');
        const errorMsg = document.getElementById('file-error');
        const maxSize = 5 * 1024 * 1024; // Maksimal ukuran file 5MB

        // Ambil file yang diunggah
        const file = fileInput.files[0];

        if (file && file.size > maxSize) {
            // Tampilkan pesan error jika ukuran file melebihi 5MB
            errorMsg.style.display = 'block';
            fileInput.value = ''; // Reset input file
        } else {
            // Sembunyikan pesan error jika ukuran file valid
            errorMsg.style.display = 'none';
        }
    });
    </script>
</section>
</body>
</html>