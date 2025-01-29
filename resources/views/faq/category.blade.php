<body class="d-flex flex-column min-vh-100">
    <!-- Navbar Component -->
    <x-navbar></x-navbar>

    <!-- Main Content Section -->
    <section id="faq" class="flex-grow-1">
        <div class="container mx-auto relative z-10 mb-20">
            <h1 id="faq-h1" class="font-bold text-gray-400">
                <a href="{{ route('faq') }}" class="text-info fw-bold">FAQs</a>
                <span class="text-gray-100 fw-bold">/ {{ $category->name }}</span>
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
                            {!!($faq->answer)!!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-gray-100 py-4">
        <div class="container mx-auto text-center">
            <p class="text-sm">© 2024 Layanan Pengaduan TIK Kemhan. All rights reserved.</p>
            <p class="text-sm">Hubungi kami di <a href="https://kemhan.go.id" class="text-info">kemhan.go.id</a></p>
        </div>
    </footer>
</body>


<style>
    html, body {
        height: 100%;             /* Ensure the full height is utilized */
        margin: 0;                /* Remove default margin */
    }

    body {
        display: flex;
        flex-direction: column;   /* Flex layout with a column direction */
        min-height: 100vh;        /* Minimum height for full viewport */
    }

    #faq {
        flex-grow: 1;             /* Allow main content to grow and push the footer */
        padding-top: 120px;
    }

    footer {
        background-color: #2d3748;
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
