<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - Your Info</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
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
        .profile-details h1 {
            margin: 0;
            font-size: 1.5rem;
        }
        .profile-details p {
            margin: 0;
            color: #6c757d;
        }
        .form-container {
            max-width: 700px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .form-container .btn {
            min-width: 150px;
        }
        .btn-success:hover {
            background-color: #218838;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        @media (max-width: 768px) {
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
                <button onclick="history.back()" class="btn btn-outline-light d-flex align-items-center">
                    <i class='bx bx-arrow-back me-2'></i> Back
                </button>
            </div>
        </nav>
    </header>

    <main class="container mt-5">
        {{-- Error Messages --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Assign Auth::user() to a variable for efficiency --}}
        @php
            $user = Auth::user();
        @endphp

        {{-- Profile Header --}}
        <div class="profile-header w-50 mx-auto">
            <i class='bx bx-user-circle profile-icon'></i>
            <div class="profile-details">
                <h1>Edit Profil</h1>
                <p class="text-muted">{{ $user->role ?? 'User' }}</p>
            </div>
        </div>

        {{-- Edit Profile Form --}}
        <div class="form-container w-50 mx-auto">
            <form action="{{ route('profil-saya') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nip" class="form-label">NRP/NIP</label>
                        <input type="number" class="form-control" id="nip" name="nip" value="{{ $user->nip }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="satker" class="form-label">Satker</label>
                        <select class="form-select" name="satker" id="satker" required>
                            @foreach($satkers as $satker)
                                <option value="{{ $satker->id }}" {{ $user->satker == $satker->id ? 'selected' : '' }}>
                                    {{ $satker->nama_satker }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="contact" class="form-label">Kontak</label>
                        <input type="number" class="form-control" id="contact" name="contact" value="{{ $user->contact }}" required>
                    </div>
                </div>
                <div class="d-flex gap-3 justify-content-center mt-4">
                    <button type="submit" class="btn btn-primary shadow">Simpan</button>
                    <a href="{{ route('profil-saya') }}" class="btn btn-danger shadow">Batal</a>
                </div>
            </form>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
