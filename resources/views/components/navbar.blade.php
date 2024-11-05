<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Pengaduan TIK Kemhan</title>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="icon" href="img/logo-kemhan.png" type="image/icon type">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
        }
        #navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 999;
        }
        .custom-link {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: white;
            padding: 10px;
            border-radius: 5px;
        }
        .custom-link img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }
        .custom-link .main-text {
            font-size: 1.25rem;
            font-weight: bold;
        }
        .custom-link .sub-text {
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.7);
        }
        .active-link {
            background-color: #4a5568;
            border-radius: 5px;
            color: #f7fafc;
        }
        .background-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: .2;
            background-image: url('img/gedung-kemhan.jpeg');
            background-size: cover;
            background-position: center;
            mask-image: linear-gradient(to left, rgb(0, 0, 0, 1), rgba(0, 0, 0, 0));
        }
        .footer {
            background-color: #2d3748;
            color: #e2e8f0;
            text-align: center;
            padding: 1rem;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body class="bg-gray-200 relative" style="background-color:rgb(22, 22, 22);">
    <div class="background-image"></div>
    <nav class="bg-gray-900 p-4 fixed-top z-10" id="navbar">
        <div class="container mx-auto flex justify-between items-center">
            <a href="#" class="custom-link">
                <img src="{{ asset('img/logo-kemhan.png') }}" alt="Logo">
                <div class="flex flex-col">
                    <span class="main-text">Layanan Pengaduan TIK Kemhan</span>
                    <span class="sub-text">Kementerian Pertahanan Republik Indonesia</span>
                </div>
            </a>
            <!-- Desktop Menu -->
            <div id="desktop-menu" class="hidden md:flex space-x-4">
                <a href="{{ route('home') }}" class="text-white hover:bg-gray-700 px-3 py-2 rounded nav-link" >Home</a>
                <a href="{{ route('faq')  }}" class="text-white hover:bg-gray-700 px-3 py-2 rounded nav-link" >FAQ</a>
                <a href="https://ppid.kemhan.go.id/" class="text-white hover:bg-gray-700 px-3 py-2 rounded nav-link">PPID</a>
                @auth
                    <a href="{{ route('logout') }}" class="text-white hover:bg-gray-700 px-3 py-2 rounded nav-link logout-link">Logout</a>
                @endauth
                @guest
                <a href="{{ route('login')  }}" class="text-white hover:bg-gray-700 px-3 py-2 rounded nav-link" >Login</a>
                @endguest 
                <a href="{{ route('help') }}" class="text-white hover:bg-gray-700 px-3 py-2 rounded nav-link" >Help</a>
            </div>
            <!-- Mobile Menu Button -->
            <button id="mobile-menu-button" class="md:hidden text-yellow-400 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden bg-gray-900 py-1 mt-2">
            <a href="{{ route('home') }}" class="text-white hover:bg-gray-700 px-2 py-1 rounded nav-link" >Home</a>
            <a href="{{ route('faq') }}" class="text-white hover:bg-gray-700 px-2 py-1 rounded nav-link" >FAQ</a>
            <a href="https://ppid.kemhan.go.id/" class="text-white hover:bg-gray-700 px-2 py-1 rounded nav-link" >PPID</a>
                @auth
                    <a href="{{ route('logout') }}" class="text-white hover:bg-gray-700 px-2 py-1 rounded nav-link logout-link">Logout</a>
                @endauth

                @guest
                    <a href="{{ route('login')  }}" class="text-white hover:bg-gray-700 px-2 py-1 rounded nav-link">Login</a>
                @endguest
            <a href="{{ route('help') }}" class="text-white hover:bg-gray-700 px-2 py-1 rounded nav-link" >Help</a>
        </div>
    </nav>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.nav-link');
            function setActiveLink() {
                navLinks.forEach(link => {
                    const linkHref = link.getAttribute('href');
                    if (window.location.href.includes(linkHref)) {
                        link.classList.add('active-link');
                    } else {
                        link.classList.remove('active-link');
                    }
                });
            }
            setActiveLink();
            document.getElementById('mobile-menu-button').addEventListener('click', function() {
                const menu = document.getElementById('mobile-menu');
                menu.classList.toggle('hidden');
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    var logoutLinks = document.querySelectorAll('.logout-link'); // Memilih semua elemen dengan class 'logout-link'

    logoutLinks.forEach(function(logoutLink) {
        logoutLink.addEventListener('click', function(event) {
            event.preventDefault(); // Mencegah link logout langsung dieksekusi
            if (confirm('Apakah Anda yakin ingin logout?')) {
                // Mengirim form logout jika dikonfirmasi
                document.getElementById('logout-form').submit();
            }
        });
    });
});
    </script>
    
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <form id="logout-form" action="{{ route('logout') }}" style="display: none;">
        @csrf
    </form>
    
</body>
</html>