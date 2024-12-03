<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('img/logo-kemhan.png') }}" type="image/png">
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
    body {
        font-family: 'Poppins', sans-serif;
    }
    #success-alert {
        color: green; text-align: center; width: 35%; margin: auto;
    }
    #fails-alert {
        color: rgb(128, 0, 0); text-align: center; width: 35%; margin: auto;
    }
    @media (max-width: 768px) {
        #success-alert, #fails-alert {
            text-align: center;
            width: 65%;
            margin: auto;
        }
    }
</style>
<body class="bg-dark">
    <nav class="navbar bg-body-dark">
        <form class="container-fluid justify-content-left mt-4 ms-2 mb-4">
          <button onclick="window.location.href='/home'" class="btn btn-outline-danger me-2" type="button">Back</button>
        </form>
      </nav>
      @if (session('success'))
    <div id="success-alert" class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('fails'))
    <div id="fails-alert" class="alert alert-danger">
        {{ session('fails') }}
    </div>
@endif
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h3 class="text-center text-light fw-bold" style="margin-top: 4rem;">Login</h3>
                <form method="POST" action="{{ route('login-proses') }}">
                    @csrf
                    <!-- Input Nama -->
                    <div class="mb-3">
                        <label for="username" class="form-label text-light">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" placeholder="Enter your username">
                        @error('username')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                
                    <!-- Input Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label text-light">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    

                    <!-- CAPTCHA -->
                    <div class="mb-3">
                        <label for="captcha" class="form-label text-light">
                            Berapa hasil dari {{ session('captcha_a') }} + {{ session('captcha_b') }}?
                        </label>
                        <input type="text" class="form-control" id="captcha" name="captcha" placeholder="Enter CAPTCHA">
                        @error('captcha')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                
                    <!-- Tombol Login -->
                    <button type="submit" class="btn btn-primary w-100 mt-3">Login</button>
                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('password.request') }}" class="text-decoration-none text-light">Forgot Password?</a>
                        <a href="{{ route('register') }}" class="text-decoration-none text-light">Don't have an account?</a>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>