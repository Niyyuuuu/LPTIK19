<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Your Info</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="img/logo-kemhan.png" type="image/icon type">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f3f2f1;
            padding-top: 80px;
        }
        #navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 999;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .profile-header {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .profile-header .profile-icon {
            font-size: 60px;
            color: #0d6efd;
        }
        .profile-details {
            flex-grow: 1;
        }
        .profile-details h1 {
            margin: 0;
            font-size: 1.5rem;
        }
        .profile-details p {
            margin: 0;
            color: #6c757d;
        }
        .profile-info {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .profile-info h2 {
            margin-bottom: 20px;
            font-size: 1.5rem;
            border-bottom: 2px solid #e1e1e1;
            padding-bottom: 10px;
        }
        .form-label {
            font-weight: 600;
        }
        .btn-back {
            display: flex;
            align-items: center;
            color: #ffffff;
            background-color: #dc3545;
            border: none;
        }
        .btn-back:hover {
            background-color: #c82333;
        }
        .alert {
            max-width: 700px;
            margin: 20px auto;
            text-align: center;
        }
        @media (max-width: 768px) {
            .profile-header, .profile-info {
                padding: 20px;
            }
            .alert {
                max-width: 90%;
            }
            .profile-header .profile-icon {
                font-size: 40px;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-dark bg-dark fixed-top" id="navbar">
            <div class="container-fluid">
                <button onclick="window.location.href='/dashboard-pengaduan'" class="btn btn-outline-light d-flex align-items-center">
                    <i class='bx bx-arrow-back me-2'></i> Back
                </button>
            </div>
        </nav>
    </header>

    <section class="container">
        @if (session('success'))
            <div class="alert alert-success" id="success-alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger" id="error-alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="profile-header">
            <i class='bx bx-user-circle profile-icon'></i>
            <div class="profile-details">
                <h1>{{ Auth::user()->name }}</h1>
                <p class="text-muted">{{ Auth::user()->role ?? 'User' }}</p>
            </div>
        </div>

        <div class="profile-info">
            <h2>Informasi Akun</h2>
            <form>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="Username" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="Username" value="{{ Auth::user()->name }}" disabled>
                    </div>
                    <div class="col-md-6">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" value="{{ Auth::user()->username }}" disabled>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nip" class="form-label">NRP/NIP</label>
                        <input type="text" class="form-control" id="nip" value="{{ Auth::user()->nip }}" disabled>
                    </div>
                    <div class="col-md-6">
                        <label for="Email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="Email" value="{{ Auth::user()->email }}" disabled>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="satker" class="form-label">Satker</label>
                        <input type="text" class="form-control" id="satker" value="{{ Auth::user()->satkerData ? Auth::user()->satkerData->nama_satker : 'Tidak ada satker' }}" disabled>
                    </div>
                    <div class="col-md-6">
                        <label for="kontak" class="form-label">Kontak</label>
                        <input type="text" class="form-control" id="kontak" value="{{ Auth::user()->contact }}" disabled>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="created_at" class="form-label">Tanggal Daftar</label>
                        <input type="text" class="form-control" id="created_at" value="{{ Auth::user()->created_at->format('d F Y') }}" disabled>
                    </div>
                </div>
                <div>
                    <a href="{{ route('edit-profil') }}" class="btn btn-primary">Edit Profil</a>
                </div>
            </form>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>