<!-- resources/views/faq/category.blade.php -->
<x-navbar></x-navbar>

<section id="faq">
    <div class="container mx-auto relative z-10 mb-20">
        <h1 id="faq-h1" class="font-bold text-gray-400">
            <a href="{{ route('faq') }}" class="text-gray-400">FAQs</a>
            <span class="text-gray-100">/ {{ $category->name }}</span>
        </h1>
    </div>
    <div class="accordion accordion-flush accordion-custom" id="accordionFlushExample">
        @foreach($faqs as $faq)
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-heading{{ $faq->id }}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{ $faq->id }}" aria-expanded="false" aria-controls="flush-collapse{{ $faq->id }}">
                        {{ $faq->question }}
                    </button>
                </h2>
                <div id="flush-collapse{{ $faq->id }}" class="accordion-collapse collapse" aria-labelledby="flush-heading{{ $faq->id }}" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        {!! nl2br(e($faq->answer)) !!}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<footer class="bg-gray-900 text-gray-100 py-4 mt-20">
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
        background-color: #2d3748;
    }
    @media (max-width: 768px) {
        #faq-h1 {
            margin-top: 4rem;
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
