<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Pengaduan TIK Kemhan</title>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="img/logo-kemhan.png" type="image/png">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #000000;
            color: #f7fafc;
            min-height: 100vh;
            margin: 0;
        }

        #logo-text {
            font-size: 1rem;
        }
        #logo-subtext {
            font-size: .8rem;
        }
        .background-image {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            z-index: -1;
            opacity: 0.1;
            background-image: url('img/gedung-kemhan.jpeg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .navbar-brand {
            color: #f7fafc !important;
        }

        .navbar-brand img {
            margin-right: 10px;
            border-radius: 50%;
        }

        .nav-link {
            transition: color 0.3s, background-color 0.3s;
        }

        .nav-link:hover {
            color: #ffffff !important;
            background-color: #424242;
            border-radius: 5px;
        }

        .active-link {
            color: #ffffff !important;
            background-color: #515151;
            border-radius: 5px;
        }

        /* Custom toggle button positioning for mobile view */
        @media (max-width: 991.98px)
        {
            #logo-text {
                font-size: .8rem;
            }
            #logo-subtext {
                font-size: .6rem;
            }
            .navbar-toggler {
                position: absolute;
                top: 10px;
                right: 1rem;
                z-index: 1050;
            }
        }
    </style>
</head>
<body>
    <div class="background-image"></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container position-relative">
            <a class="navbar-brand d-flex align-items-center mt-2 mb-2" href="#">
                <img src="{{ asset('img/logo-kemhan.png') }}" alt="Logo" width="42" height="42">
                <div>
                    <div id="logo-text" class="fw-bold">Layanan Pengaduan TIK Kemhan</div>
                    <div id="logo-subtext" class="fw-light">Kementerian Pertahanan Republik Indonesia</div>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto gap-2">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('faq') }}">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="https://ppid.kemhan.go.id/">PPID</a>
                    </li>
                    @auth
                    <li class="nav-item">
                        <a class="nav-link text-white logout-link" href="{{ route('logout') }}">Logout</a>
                    </li>
                    @endauth
                    @guest
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('login') }}">Login</a>
                    </li>
                    @endguest
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('help') }}">Help</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.nav-link');
            const currentUrl = window.location.href;

            navLinks.forEach(link => {
                if (currentUrl.includes(link.getAttribute('href'))) {
                    link.classList.add('active-link');
                }
            });

            const logoutLinks = document.querySelectorAll('.logout-link');
            logoutLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    if (confirm('Apakah Anda yakin ingin logout?')) {
                        document.getElementById('logout-form').submit();
                    }
                });
            });
        });
    </script>

    <form id="logout-form" action="{{ route('logout') }}" style="display: none;">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>
