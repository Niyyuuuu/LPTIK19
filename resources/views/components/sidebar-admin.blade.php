<!-- resources/views/partials/sidebar.blade.php -->
<nav class="sidebar">
    <div class="sidebar-header">
        <h3 class="fw-bold">Admin Panel</h3>
        <h6 class="fw-light fs-6">Layanan Pengaduan TIK Kemhan</h6>
    </div>
    <ul class="components">
        @php
            $menuItems = [
                ['route' => 'admin', 'icon' => 'bx-grid', 'label' => 'Dashboard'],
                ['route' => 'ticket-list', 'icon' => 'bx-list-ul', 'label' => 'Ticket List'],
                ['route' => 'users-list', 'icon' => 'bx-user', 'label' => 'Users List'],
                ['route' => 'home-settings', 'icon' => 'bx-cog', 'label' => 'Home Settings'],
                ['route' => 'satker-list', 'icon' => 'bx-spreadsheet', 'label' => 'Satker Settings'],
                ['route' => 'home', 'icon' => 'bx-home-alt', 'label' => 'Home'],

            ];
        @endphp

        @foreach ($menuItems as $item)
            <li class="{{ Request::is($item['route']) ? 'active' : '' }}">
                <a href="{{ route($item['route']) }}">
                    <i class='bx {{ $item['icon'] }}'></i>
                    <span>{{ $item['label'] }}</span>
                </a>
            </li>
        @endforeach
    </ul>

    <div class="sidebar-footer">
        <form id="logout-form" action="{{ route('logout') }}" style="display: none;">
            @csrf
        </form>
        <a href="#" class="sidebar-link" onclick="event.preventDefault(); 
            if (confirm('Yakin ingin Logout?')) {
                document.getElementById('logout-form').submit();
            }">
            <i class="bx bx-log-out"></i>
            <span> | Logout</span>
        </a>
    </div>
</nav>

<style>
    .sidebar {
        display: flex;
        flex-direction: column;
        height: 100vh;
    }

    .sidebar-header {
        padding: 20px; /* Padding untuk header */
        background-color: #34495e; /* Warna latar belakang header */
        color: #ecf0f1; /* Warna teks header */
    }

    .components {
        flex-grow: 1; /* Memastikan daftar menu mengambil ruang yang tersedia */
        padding: 0;
        margin: 0;
        list-style-type: none; /* Menghapus bullet points */
    }

    .components li {
        border-bottom: 1px solid #455a64; /* Garis pemisah antara item */
    }

    .components a {
        padding: 15px 20px; /* Padding untuk link */
        display: flex;
        align-items: center; /* Vertically center items */
        color: #ecf0f1; /* Warna teks */
        text-decoration: none; /* Menghapus garis bawah */
    }

    .components a:hover {
        background-color: #2980b9; /* Ganti latar belakang saat hover */
        color: #ffffff; /* Ganti warna teks saat hover */
    }

    .sidebar-footer {
        padding: 15px 20px; /* Padding untuk footer */
        background-color: #34495e; /* Warna latar belakang footer */
    }

    .sidebar-footer .sidebar-link {
        display: flex;
        align-items: center;
        color: #ecf0f1; /* Warna teks footer */
        text-decoration: none; /* Menghapus garis bawah pada link logout */
    }

    .sidebar-footer .sidebar-link:hover {
        color: #e74c3c; /* Ganti warna saat hover di footer */
    }
</style>
