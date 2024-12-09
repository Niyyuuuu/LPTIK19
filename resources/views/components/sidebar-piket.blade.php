<!-- components/sidebar-tech.blade.php -->
@php
    $menuItems = [
        ['icon' => 'bx-home', 'label' => 'Dashboard', 'route' => url('/piket')],
        ['icon' => 'bx-list-ul', 'label' => 'Ticket List', 'route' => url('/piket/tickets')],
        ['icon' => 'bx-file', 'label' => 'Feedback Report', 'route' => url('/piket/feedback')],
    ];
@endphp


<div class="sidebar">
    <h2>Help Desk</h2>
    <ul>
        @foreach ($menuItems as $item)
        <li>
                <a href="{{ $item['route'] }}">
                    <i class='bx {{ $item['icon'] }}'></i> {{ $item['label'] }}
                </a>
            </li>
        @endforeach
        <li>
            <a href="{{ asset('storage/files/JUKOP-LAYANAN-PENGADUAN.pdf') }}" class="sidebar-link" download="JUKOP-LAYANAN-PENGADUAN.pdf">
                <i class="bx bx-help-circle"></i>
                <span>Jukop</span>
                </a>
        </li>
        <li>
            <form id="logout-form" action="{{ route('logout') }}" style="display: none;">
                @csrf
            </form>
            <a href="#" onclick="event.preventDefault(); 
                if (confirm('Yakin ingin Logout?')) {
                    document.getElementById('logout-form').submit();
                }">
                <i class='bx bx-log-out'></i>
                <span> | Logout</span>
            </a>
            <a href="{{ route('profil-saya') }}" class="sidebar-link mt-3">
                <i class="bx bx-user"></i>
                <span>{{ Auth::user()->name }}</span>
            </a>
        </li>
    </ul>
</div>

