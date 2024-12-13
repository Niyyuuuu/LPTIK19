@php
    $menuItems = [
        ['icon' => 'bx-home', 'label' => 'Dashboard', 'route' => url('/piket')],
        ['icon' => 'bx-list-ul', 'label' => 'Ticket List', 'route' => url('/piket/tickets')],
        ['icon' => 'bx-file', 'label' => 'Feedback Report', 'route' => url('/piket/feedback')],
    ];
@endphp

<style>
    .sidebar {
        background: linear-gradient(to bottom, #003988, #101010);
        color: white;
        width: 250px;
        height: 100vh;
        position: fixed;
        padding: 20px;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .sidebar h2, .user-info, .sidebar ul, .logout-section {
        text-align: center;
        margin-bottom: 20px;
    }

    .sidebar h2 {
        font-size: 24px;
        font-weight: bold;
    }

    .user-info, .sidebar ul li a, .logout-section a {
        font-size: 16px;
        font-weight: bold;
    }

    .sidebar ul {
        list-style: none;
        padding: 0;
        flex-grow: 1;
        margin-bottom: 0;
    }

    .sidebar ul li {
        margin-bottom: 5px;
    }

    .sidebar ul li a {
        text-decoration: none;
        color: #ffffff;
        display: flex;
        align-items: center;
        padding: 10px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .sidebar ul li a i {
        margin-right: 10px;
        font-size: 18px;
    }

    .sidebar ul li a:hover {
        background-color: #ebebeb;
        color: #2c344b;
    }

    .sidebar ul li a.sidebar-link span {
        font-weight: bold;
    }

    .logout-section {
        background-color: #a80000;
        padding: 10px;
        border-radius: 5px;
    }

    .logout-section a {
        text-decoration: none;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .logout-section a i {
        margin-right: 10px;
        font-size: 18px;
    }
</style>

<div class="sidebar">
    <div>
        <h2>Help Desk</h2>
        <div class="user-info">
            <i class="bx bx-user"></i> {{ Auth::user()->name }}
        </div>
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
        </ul>
    </div>
    <div class="logout-section">
        <form id="logout-form" action="{{ route('logout') }}" style="display: none;">
            @csrf
        </form>
        <a href="#" onclick="event.preventDefault(); 
            if (confirm('Yakin ingin Logout?')) {
                document.getElementById('logout-form').submit();
            }">
            <i class='bx bx-log-out'></i>
            <span>Logout</span>
        </a>
    </div>
</div>
    <script>
        // JavaScript to mark active menu item
        document.addEventListener('DOMContentLoaded', (event) => {
            const menuItems = document.querySelectorAll('.sidebar ul li a');
            menuItems.forEach(item => {
                if (item.href === window.location.href) {
                    item.classList.add('active');
                }
            });
        });

        // CSS for active class
        const style = document.createElement('style');
        style.innerHTML = `
            .sidebar ul li a.active {
                background-color: #ebebeb;
                color: #2c344b;
            }
        `;
        document.head.appendChild(style);
    </script>
