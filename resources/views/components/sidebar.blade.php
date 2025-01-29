<!-- resources/views/components/sidebar.blade.php -->
<aside id="sidebar" class="expand">
    <div class="d-flex">
        <button class="toggle-btn" type="button">
            <img class="logo-kemhan" src="{{ asset('img/logo-kemhan.png') }}" alt="Logo Kemhan">
        </button>
        <div class="sidebar-logo">
            <a href="#">Layanan Pengaduan</a>
        </div>
    </div>
    <ul class="sidebar-nav">
        @php
            $menuItems = [
                ['href' => 'dashboard-pengaduan', 'icon' => 'bxs-dashboard', 'label' => 'Dashboard'],
                ['href' => 'buat-pengaduan', 'icon' => 'bx-add-to-queue', 'label' => 'Buat Pengaduan'],
                ['href' => 'daftar-pengaduan', 'icon' => 'bx-comment', 'label' => 'Daftar Pengaduan'],
                ['href' => 'history-pengaduan', 'icon' => 'bx-history', 'label' => 'Riwayat Pengaduan'],
                ['href' => route('home'), 'icon' => 'bx-home', 'label' => 'Home'],
                ['href' => '#', 'icon' => 'bx-help-circle', 'label' => 'Petunjuk Operasi', 'download' => true, 'onclick' => 'downloadJukop()'],
                ['href' => '#', 'icon' => 'bx-user', 'label' => 'Profil', 'dropdown' => [
                    ['href' => route('profil-saya'), 'label' => 'Profil Saya'],
                    ['href' => route('edit-profil'), 'label' => 'Edit Profil'],
                ]],
            ];
        @endphp

        @foreach ($menuItems as $item)
            <li class="sidebar-item">
                <a href="{{ $item['href'] }}" class="sidebar-link collapsed @isset($item['dropdown']) has-dropdown @endisset"
                    data-bs-toggle="{{ isset($item['dropdown']) ? 'collapse' : '' }}"
                    data-bs-target="{{ isset($item['dropdown']) ? '#' . strtolower(str_replace(' ', '-', $item['label'])) : '' }}"
                    aria-expanded="false"
                    aria-controls="{{ isset($item['dropdown']) ? strtolower(str_replace(' ', '-', $item['label'])) : '' }}"
                    @isset($item['download']) download="{{ basename($item['href']) }}" @endisset
                    @isset($item['onclick']) onclick="event.preventDefault(); {{ $item['onclick'] }}" @endisset>
                    <i class="bx {{ $item['icon'] }}"></i>
                    <span>{{ $item['label'] }}</span>
                </a>
                @isset($item['dropdown'])
                    <ul id="{{ strtolower(str_replace(' ', '-', $item['label'])) }}" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        @foreach ($item['dropdown'] as $subItem)
                            <li class="sidebar-item">
                                <a href="{{ $subItem['href'] }}" class="sidebar-link">{{ $subItem['label'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                @endisset
            </li>
        @endforeach
    </ul>
    <div class="sidebar-footer">
        <a href="{{ route('profil-saya') }}" class="sidebar-link">
            <i class="bx bx-user"></i>
            <span>{{ Auth::user()->name }}</span>
        </a>
    </div>
    <div class="sidebar-footer mb-4">
        <form id="logout-form" action="{{ route('logout') }}" style="display: none;">
            @csrf
        </form>
        <div class="sidebar-footer">
            <a href="#" class="sidebar-link" onclick="event.preventDefault(); 
                if (confirm('Yakin ingin Logout?')) {
                    document.getElementById('logout-form').submit();
                }">
                <i class="bx bx-log-out"></i>
                <span>Logout</span>
            </a>
        </div>
    </div>
</aside>

<script>
    function downloadJukop() {
        if (confirm('Apakah Anda yakin ingin mendownload File Petunjuk Operasi?')) {
            window.location.href = "{{ asset('storage/files/JUKOP-USER.pdf') }}";
        }
    }
</script>
