<!-- resources/views/layouts/admin-app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"/>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
    <link rel="icon" href="{{ asset('img/logo-kemhan.png') }}" type="image/icon type">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
        body {
            background-color: #161616;
            font-family: 'Poppins', sans-serif;
        }
        #wrapper {
            display: flex;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }
        /* Sidebar styling */
        .sidebar {
            min-width: 250px;
            max-width: 250px;
            background: #343a40;
            color: #fff;
            transition: all 0.3s;
        }
        .sidebar .sidebar-header {
            padding: 20px;
            background: #343a40;
            text-align: center;
        }
        .sidebar ul.components {
            padding: 20px 0;
            border-bottom: 1px solid #47748b;
        }
        .sidebar ul p {
            color: #fff;
            padding: 10px;
        }
        .sidebar ul li a {
            padding: 10px;
            font-size: 1.1em;
            display: block;
            color: #adb5bd;
        }
        .sidebar ul li a:hover {
            color: #ffffff;
            background: #495057;
            text-decoration: none;
        }
        .sidebar ul li.active > a {
            color: #fff;
            background: #0d6efd;
        }
        /* Page content styling */
        #page-content-wrapper {
            width: 100%;
            padding: 20px;
            overflow-y: auto;
        }
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar {
                min-width: 100px;
                max-width: 100px;
            }
            .sidebar ul li a {
                text-align: center;
                padding: 10px 5px;
                font-size: 0.9em;
            }
            .sidebar ul li a span {
                display: none;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <div id="wrapper">
        <!-- Sidebar -->
        @include('components.sidebar-admin')

        <!-- Page Content -->
        <div id="page-content-wrapper">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $('#admin-table').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                responsive: true,
                language: {
                    lengthMenu: "Tampilkan _MENU_ entri per halaman",
                    zeroRecords: "Tidak ada data yang ditemukan",
                    info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                    infoEmpty: "Tidak ada entri yang tersedia",
                    infoFiltered: "(disaring dari _MAX_ total entri)",
                    search: "Cari:",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                }
            });
        });
    </script>
        <script>
            $(document).ready(function() {
                $('#admin1-table').DataTable({
                    paging: true,
                    searching: true,
                    ordering: true,
                    info: true,
                    responsive: true,
                    language: {
                        lengthMenu: "Tampilkan _MENU_ entri per halaman",
                        zeroRecords: "Tidak ada data yang ditemukan",
                        info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                        infoEmpty: "Tidak ada entri yang tersedia",
                        infoFiltered: "(disaring dari _MAX_ total entri)",
                        search: "Cari:",
                        paginate: {
                            first: "Pertama",
                            last: "Terakhir",
                            next: "Selanjutnya",
                            previous: "Sebelumnya"
                        }
                    }
                });
            });
        </script>
        <script>
            CKEDITOR.replace('answer', {
                toolbar: [
                    { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline'] },
                    { name: 'paragraph', items: ['NumberedList', 'BulletedList'] },
                    { name: 'tools', items: ['Maximize', 'Preview'] }
                ],
                height: 300
            });
        </script>
    @stack('scripts')
</body>
</html>