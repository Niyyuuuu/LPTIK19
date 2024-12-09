<!-- resources/views/admin/users-list.blade.php -->
@extends('layouts.admin-app')

@section('title', 'Users List')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style-admin.css') }}">
@endpush

@section('content')
    <div class="container-fluid">
        @if (session('success'))
    <div id="success-alert" class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
        <h1 class="mb-4 text-white fw-bold">Users List</h1>

        <!-- Table Users List -->
        <a href="{{ route('create-user') }}" class="btn btn-success mb-3">
    Tambah Pengguna
</a>

        <div class="card mb-4">
            <div class="card-header bg-primary bx bxs-user"></div>
            <div class="card-body">
                <table id="admin-table" class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>NRP/NIP</th>
                            <th>Satker</th>
                            <th>Kontak</th>
                            <th>Tanggal Daftar</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->nip }}</td>
                                <td>{{ $user->satkerData ? $user->satkerData->nama_satker : 'Tidak ada satker' }}</td>
                                <td>{{ $user->contact }}</td>
                                <td>{{ $user->created_at->format('d F Y') }}</td>
                                <td class="gap-2-xl justify-content-end text-end">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">Delete</button>
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