@extends('layouts.admin-app')

@section('title', 'List Permasalahan')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style-admin.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Kategori Permasalahan List</h1>

    <div>
        <a href="{{ route('create-permasalahan') }}" class="btn btn-success mb-4">Add New Kategori Permasalahan</a>
    </div>

    <div class="card">
        <div class="card-header bg-primary bx bxs-spreadsheet"></div>
        <div class="card-body">
            <table id="admin-table" class="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permasalahan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->deskripsi }}</td>
                        <td class="text-end">
                            <a href="{{ route('edit-permasalahan', $item->id) }}" class="btn btn-primary">Edit</a>  
                            <form action="{{ route('delete-permasalahan', $item->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus Permasalahan ini?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

