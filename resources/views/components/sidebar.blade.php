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
        <li class="sidebar-item">
            <a href="dashboard-pengaduan" class="sidebar-link collapsed has-dropdown"
                data-bs-target="#multi" aria-expanded="false" aria-controls="multi">
                <i class="bx bxs-dashboard"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                data-bs-target="#user" aria-expanded="false" aria-controls="user">
                <i class="bx bx-user"></i>
                <span>Profil</span>
            </a>
            <ul id="user" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                <li class="sidebar-item">
                    <a href="{{ route('profil-saya') }}" class="sidebar-link">Profil Saya</a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('edit-profil') }}" class="sidebar-link">Edit Profil</a>
                </li>
            </ul>
        </li>
        <li class="sidebar-item">
            <a href="daftar-pengaduan" class="sidebar-link collapsed has-dropdown"
                data-bs-target="#multi" aria-expanded="false" aria-controls="multi">
                <i class="bx bx-comment"></i>
                <span>Daftar Pengaduan</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="history-pengaduan" class="sidebar-link collapsed has-dropdown"
                data-bs-target="#multi" aria-expanded="false" aria-controls="multi">
                <i class="bx bx-history"></i>
                <span>Riwayat Pengaduan</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('home') }}" class="sidebar-link collapsed has-dropdown"
                data-bs-target="#multi" aria-expanded="false" aria-controls="multi">
                <i class="bx bx-home"></i>
                <span>Home</span>
            </a>
        </li>
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