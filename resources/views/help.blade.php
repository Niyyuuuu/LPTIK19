<!-- resources/views/help.blade.php -->
<x-navbar></x-navbar>

<section id="help">
    <div class="container mx-auto relative z-10 mb-20">
        <h1 id="help-h1" class="font-bold text-gray-100">Help</h1>
    </div>
    <div class="row" id="card">
      @foreach($helpTopics as $category)
          <div class="col-sm-6 mb-4 mb-sm-4">
              <div class="card" 
                  data-aos="fade-{{ $loop->index % 2 == 0 ? 'right' : 'left' }}" 
                  @if($loop->remaining <= 1) 
                      data-aos-delay="200" 
                  @endif> 
                  <div class="card-body">
                      <h5 class="card-title fw-bold">{{ $category->name }}</h5>
                      <p class="card-text">
                          @switch($category->slug)
                              @case('tiket')
                                  Dapatkan bantuan terkait manajemen tiket dan pelaporan masalah.
                                  @break
                              @case('jaringan')
                                  Solusi untuk masalah terkait jaringan dan konektivitas.
                                  @break
                              @case('hardware')
                                  Panduan troubleshooting untuk perangkat keras.
                                  @break
                              @case('software')
                                  Temukan bantuan terkait perangkat lunak dan aplikasi.
                                  @break
                          @endswitch
                      </p>
                      <a href="{{ route('help.showCategoryHelp', $category->slug) }}" class="btn btn-dark" id="btn-2">Lihat</a>
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
    #help {  
        padding-top: 120px;
        position: relative;
        overflow: hidden;
    }
    #help-h1 {
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
        position: relative;
        bottom: 0;
        width: 100%;
        background-color: #2d3748;
    }
    @media (max-width: 768px) {
        #help-h1 {
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
