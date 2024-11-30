<!-- resources/views/faq.blade.php -->
<x-navbar></x-navbar>

<section id="faq">
    <div class="container mx-auto relative z-10 mb-20">
        <h1 id="faq-h1" class="fw-bold text-gray-100" data-aos="fade-right">FAQs</h1>
    </div>
    <div class="row" id="card">
        @foreach($categories as $category)
            <div class="col-sm-6 mb-4 mb-sm-4">
                <div class="card" data-aos="fade-{{ $loop->index % 2 == 0 ? 'right' : 'left' }}"> 
                    <div class="card-body">
                        <h5 class="card-title fw-bold">{{ $category->name }}</h5>
                        <p class="card-text">
                            @switch($category->slug)
                                @case('akun')
                                    Dapatkan bantuan terkait daftar, login, dan pengaturan akun.
                                    @break
                                @case('aplikasi')
                                    Pelajari cara menggunakan fitur aplikasi umum dan memecahkan masalah.
                                    @break
                                @case('pengaduan')
                                    Temukan jawaban untuk pertanyaan umum tentang pengaduan.
                                    @break
                            @endswitch
                        </p>
                        <a href="{{ route('faq.category', $category->slug) }}" class="btn btn-dark" id="btn-2">Lihat</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<footer class="bg-dark text-gray-100 py-4 mt-20">
    <div class="container mx-auto text-center">
        <p class="text-sm">© 2024 Layanan Pengaduan TIK Kemhan. All rights reserved.</p>
        <p class="text-sm">Hubungi kami di <a href="https://kemhan.go.id" class="text-gray-300">kemhan.go.id</a></p>
    </div>
</footer>

<style>
    /* CSS Anda tetap sama */
    #faq {  
        padding-top: 120px;
        position: relative;
        overflow: hidden;
    }
    #faq-h1 {
        margin-top: 2rem;
    }
    #card {
        display: flex;
        justify-content: center;
        margin: auto;
        width: 90%;
    }
    .card {
        color: #343434;
        border-radius: 1rem;
        background-color: #eaeaea;
    }
    footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        background-color: #2d3748;
    }
    @media (max-width: 768px) {
        #faq-h1 {
            margin-top: 4rem;
        }
        #card {
            display: flex;
            justify-content: center;
            margin: auto;
            width: 100%;
        }
        footer {
            position: relative;
            z-index: 1;
            margin-top: 20px;
        }
    }
</style>
