@extends('layouts.admin-app')

@section('title', 'Detail Category')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style-admin.css') }}">
@endpush

@section('content')

    @if (session('success'))
        <div id="success-alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h1 class="mb-4 text-white fw-bold">Category Details</h1>

    <div class="card mb-4">
        <div class="card-header bg-primary">
            <i class="bx bx-category"></i> {{ $category->name }} ({{ $category->slug }})
        </div>
        <div class="card-body">
            <h3 class="text-white">Entries</h3>

            @php
                // Deklarasi $routePrefix sebelum loop
                $routePrefix = in_array($category->name, ['Akun', 'Aplikasi', 'Pengaduan']) ? 'faq' : 'help';
            @endphp

            <table id="entryTable" class="table">
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($entries as $entry)
                    <tr>
                        <td>{{ $entry->question }}</td>
                        <td>{{ $entry->answer }}</td>
                        <td class="gap-2-xl justify-content-end">
                            <a href="{{ route($routePrefix . '.entry.edit', $entry->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route($routePrefix . '.entry.delete', $entry->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this entry?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <a href="{{ route($routePrefix . '.entry.create', $category->id) }}" class="btn btn-success mt-3">
                Add New Entry
            </a>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#entryTable').DataTable({
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
@endpush
