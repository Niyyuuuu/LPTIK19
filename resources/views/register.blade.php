<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('img/logo-kemhan.png') }}" type="image/png">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-dark">
    <nav class="navbar bg-body-dark">
        <form class="container-fluid justify-content-left mt-4 ms-2">
          <button onclick="window.location.href='login'" class="btn btn-outline-danger me-2" type="button">Back</button>
        </form>
        @if ($errors->has('password') && old('password') !== null)
    <div class="alert alert-danger" style="color: rgb(128, 0, 0); text-align: center; width: 35%; margin: auto;">
        {{ $errors->first('password') }}
    </div>
@endif
@if ($errors->has('email')) 
    <div class="alert alert-danger" style="color: rgb(128, 0, 0); text-align: center; width: 35%; margin: auto;">
        {{ $errors->first('email') }} 
    </div>
@endif
    </nav>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h3 class="text-center text-light fw-bold" style="margin-top: 4rem;">Register</h3>
                <form action="{{ route('register-proses') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label text-light">Name</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter your name" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label text-light">Username</label>
                        <input type="text" name="username" class="form-control" id="username" placeholder="Enter your username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label text-light">Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label text-light">Password</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label text-light">Password Confirmation</label>
                        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-3">Register</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
