@extends('layouts.admin-app')

@section('title', 'Manage Home Settings')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style-admin.css') }}">
@endpush

@section('content')
    <h1 class="mb-4 text-white fw-bold">Manage Home Settings</h1>

    {{-- Section for managing FAQ categories --}}
    <h2 class="text-white">FAQ Categories</h2>
    <div class="card mb-4">
        <div class="card-header bg-primary">
            <i class="bx bx-category"></i> FAQ Categories
        </div>
        <div class="card-body">
            <table id="admin-table" class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($faqCategories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->slug }}</td>
                        <td class="gap-2-xl justify-content-end text-end">
                            <a href="{{ route('faq.category.detail', $category->id) }}" class="btn btn-sm btn-primary">Detail</a>
                            <form action="{{ route('faq.category.delete', $category->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Section for managing Help categories --}}
    <h2 class="text-white">Help Categories</h2>
    <div class="card mb-4">
        <div class="card-header bg-primary">
            <i class="bx bx-help-circle"></i> Help Categories
        </div>
        <div class="card-body">
            <table id="admin1-table" class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($helpCategories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->slug }}</td>
                        <td class="gap-2-xl justify-content-end text-end">
                            <a href="{{ route('help.category.detail', $category->id) }}" class="btn btn-sm btn-primary">Detail</a>
                            <form action="{{ route('help.category.delete', $category->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
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