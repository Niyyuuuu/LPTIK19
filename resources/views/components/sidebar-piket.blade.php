<!-- components/sidebar-tech.blade.php -->
@php
    // Array menu untuk mengurangi repetisi
    $menuItems = [
        ['icon' => 'bx-home', 'label' => 'Dashboard', 'route' => '/piket'],
        ['icon' => 'bx-list-ul', 'label' => 'Ticket List', 'route' => '/piket/tickets'],
        ['icon' => 'bx-file', 'label' => 'Feedback Report', 'route' => '/piket/feedback'],
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

