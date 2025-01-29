<x-navbar></x-navbar>

<section id="home">
    @if (session('success'))
    <div id="success-alert" class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if (session('error'))
    <div id="error-alert" class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var logoutLink = document.getElementById('logout-link');
    
            if (logoutLink) {
                logoutLink.addEventListener('click', function(event) {
                    event.preventDefault();
                    if (confirm('Apakah Anda yakin ingin logout?')) {
                        document.getElementById('logout-form').submit();
                    }
                });
            }
        });
    </script>
        <div class="container mx-auto p-6 relative z-10" >
            <h1 class="text-4xl font-bold text-gray-100 mb-20 fw-bold" id="home-h1" data-aos="fade-right">Halo, Selamat Datang!</h1>
            <p class="text-lg text-gray-100 fw-medium" data-aos="fade-right" data-aos-duration="1000">Layanan pengaduan yang memberikan jawaban atau solusi 
                secara cepat dan tepat serta terpusat karena dilengkapi dengan sistem yang 
                saling terintegrasi sehingga memudahkan pelapor melakukan tracking tiket laporan 
                sehingga kendala dapat segera teratasi.</p>
                <div class="mt-20 mb-40">
                    @guest
                        <a href="{{ route('login') }}" 
                           class="btn btn-info py-2" data-aos="fade-right" data-aos-duration="1500">
                            Pengaduan
                        </a>
                    @endguest
                
                    @auth
                        @if (Auth::user()->role === 'Admin')
                            <a href="{{ route('admin') }}" 
                               class="btn btn-secondary py-2" data-aos="fade-right" data-aos-duration="1500">
                                Admin Dashboard
                            </a>
                        @elseif (Auth::user()->role === 'Technician')
                            <a href="{{ route('technician') }}" 
                               class="btn btn-secondary py-2" data-aos="fade-right" data-aos-duration="1500">
                                Technician Dashboard
                            </a>
                        @elseif (Auth::user()->role === 'Piket')
                            <a href="{{ route('piket') }}" 
                               class="btn btn-secondary py-2" data-aos="fade-right" data-aos-duration="1500">
                                Piket Dashboard
                            </a>
                        @else
                            <a href="{{ route('buat-pengaduan') }}" 
                               class="btn btn-secondary py-2" data-aos="fade-right" data-aos-duration="1500">
                                Pengaduan
                            </a>
                        @endif
                    @endauth
                </div>                
        </div> 
        <div class="container mx-auto relative z-10">
            <h1 class="text-4xl font-bold text-gray-100 mb-5 fw-bold" id="layanan-h1" data-aos="fade-right">Layanan</h1>
        </div>
        
        <div class="card-container" >
            <div class="card" data-aos="fade-right" style="background-color: rgb(235, 235, 235);">
                <img src="img/TIKET-IC.png" class="card-img-top" alt="">    
                <div class="card-body">
                    <p class="card-text fw-bold text-gray-900">PENGADUAN LAYANAN</p>
                    <p class="card-text fw-meduim">Sampaikan pertanyaan atau keluhan seputar layanan</p>
                </div>
            </div>
            <div class="card" data-aos="fade-left" style="background-color: rgb(235, 235, 235);">
                <img src="img/TELE-IC.png" class="card-img-top" alt="">
                <div class="card-body">
                    <p class="card-text fw-bold">KANAL TELEGRAM</p>
                    <p class="card-text fw-meduim">Solusi menyelesaikan masalah anda melalui kanal Telegram</p>
                </div>
            </div>
            <div class="card" data-aos="fade-right" style="background-color: rgb(235, 235, 235);">
                <img src="img/WA-IC.png" class="card-img-top" alt="">
                <div class="card-body">
                    <p class="card-text fw-bold">KANAL WHATSAPP</p>
                    <p class="card-text fw-meduim">Solusi menyelesaikan masalah anda melalui kanal WhatsApp</p>
                </div>
            </div>
            <div class="card" data-aos="fade-left" style="background-color: rgb(235, 235, 235);">
                <img src="img/CALL-IC.png" class="card-img-top" alt="">
                <div class="card-body">
                    <p class="card-text fw-bold">KANAL TELEPON</p>
                    <p class="card-text fw-meduim">Solusi menyelesaikan masalah anda melalui kanal Telepon</p>
                </div>
            </div>
        </div>

        <div class="container mx-auto relative z-10">
            <h1 class="text-4xl font-bold text-gray-100 mb-5 fw-bold" id="faq-h1" data-aos="fade-right">Pertanyaan Yang Sering Diajukan</h1>
        </div>

        <div class="accordion accordion-flush accordion-custom" id="accordionFlushExample" data-aos="fade-right">
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                  Bagaimana cara membuat akun?
                </button>
              </h2>
              <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                    Daftar melalui situs Layanan Pengaduan TIK Kemhan
                    <br>
                    <br>1. Buka situs Layanan Pengaduan TIK Kemhan
                    <br>2. Pilih Menu "Login"
                    <br>3. Pilih "Belum Punya Akun"
                    <br>4. Masukkan Name, Username, Email dan Password
                    <br>5. Pilih "Register"
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                  Bagaimana cara membuat pengaduan?
                </button>
              </h2>
              <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                    Membuat pengaduan melalui situs Layanan Pengaduan TIK Kemhan
                    <br>
                    <br>1. Buka situs Layanan Pengaduan TIK Kemhan
                    <br>2. Pilih "Pengaduan" di halaman Home
                    <br>3. Masukkan Email dan Password
                    <br>4. Pilih "Login"
                    <br>5. Pilih Menu "Buat Tiket Baru"
                    <br>6. Lengkapi form pengaduan
                    <br>7. Pilih "Kirim"
                </div>
              </div>
            </div>
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseTwo">
                    Lupa sandi?
                  </button>
                </h2>
                <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                  <div class="accordion-body">
                    Anda bisa mencoba mengatur ulang kata sandi melalui opsi "Lupa Kata Sandi" di halaman login atau menghubungi dukungan pelanggan untuk bantuan lebih lanjut. Pastikan untuk menyediakan informasi yang diperlukan untuk verifikasi identitas Anda.
                  </div>
                </div>
            </div>
        </div>
</section>

<footer class="bg-gray-900 text-gray-100 py-4 mt-20">
    <div class="container mx-auto text-center">
        <p class="text-sm">© 2024 Layanan Pengaduan TIK Kemhan. All rights reserved.</p>
        <p class="text-sm">Hubungi kami di <a href="kemhan.go.id" class="text-info">kemhan.go.id</a></p>
    </div>
</footer>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
        #home {
            font-family: 'Poppins', sans-serif;
            padding-top: 120px;
            position: relative;
            overflow: hidden;
        }

        #home-h1 {
            margin-top: 10rem;
        }

        #layanan-h1 {
            margin-top: 20rem;
        }

        #faq-h1 {
            margin-top: 16rem;
        }
        
        .card-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
            justify-content: center;
            margin-left: 7rem;
            margin-right: 7rem;
            text-align: center;
        }
        
        .card {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center; 
            width: 100%;
            border-radius: 2rem;
        }
        
        .card-img-top {
            margin-top: 1rem;
            width: 15%;
            object-fit: cover;
        }

        .accordion-custom {
            display: block;
            width: 85%;
            margin: auto;
            margin-bottom: 4rem;
            border-radius: 1rem;
            overflow: hidden;   
        }

        footer {
        position: relative;
        bottom: 0;
        width: 100%;
        background-color: #1b1b1b;
        }

        #success-alert,
        #error-alert {
            margin: auto;
            text-align: center;
            width: 35%;
            top: 2rem;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* If you want to use different colors for success and error */
        #success-alert {
            color: green; /* Modify only the color if needed */
        }

        #error-alert {
            color: rgb(128, 0, 0); /* This can be removed if color is the same */
        }


        @media (max-width: 768px) {
            .card-container {
                grid-template-columns: 1fr 1fr;
                margin: 1rem;
            }
    
            #success-alert,
            #error-alert {
                text-align: center;
                width: 90%;
                margin: 2rem auto 0 auto;
            }

            #success-alert {
                color: green;
            }

            #error-alert {
                color: rgb(128, 0, 0);
            }

            .card {
                margin-bottom: 1rem;
                font-size: 10px;
            }
            .card-img-top {
                width: 30%;
                text-size-adjust: 
            }
            .col-md-6.d-flex {
                justify-content: center;
                text-align: center;
            }
            .accordion-custom {
                width: 90%;
                margin: auto;
            }
            .accordion-button {
                border-radius: 1rem;
            }
            footer {
            position: relative;
            z-index: 1;
            margin-top: 20px;
            }
        }
    </style>