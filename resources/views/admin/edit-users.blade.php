<!-- resources/views/admin/edit.blade.php -->
@extends('layouts.admin-app')

@section('title', 'Edit Pengguna')

@section('content')
    @if (session('success'))
    <div id="success-alert" class="alert alert-success position-absolute z-3">
        {{ session('success') }}
    </div>
    @endif
    <div class="container">
        <style>
            .container {
                color: white;
            }
        </style>
        <h1 class="mb-4 text-white fw-bold">User Edit</h1>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" class="form-select" required>
                    <option value="User" {{ $user->role === 'User' ? 'selected' : '' }}>User</option>
                    <option value="Technician" {{ $user->role === 'Technician' ? 'selected' : '' }}>Technician</option>
                    <option value="Admin" {{ $user->role === 'Admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <div class="form-group">
                <label for="satker">Satker</label>
                <select name="satker" class="form-select" required>
                    @foreach($satkers as $satker)
                        <option value="{{ $satker->id }}" {{ $user->satker == $satker->id ? 'selected' : '' }}>
                            {{ $satker->nama_satker }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update</button>
            <button type="button" class="btn btn-secondary mt-3" onclick="window.history.back()">Back</button>
        </form>
    </div>
@endsection
