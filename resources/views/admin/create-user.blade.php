@extends('layouts.admin-app')

@section('title', 'Tambah Pengguna')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1 class="fw-bold text-white">Add New User</h1>
                <form action="{{ route('store-user') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="text-white" for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="text-white" for="username">Username</label>
                        <input type="text" name="username" id="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="text-white" for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="text-white" for="role">Role</label>
                        <select name="role" id="role" class="form-control" required>
                            <option value="User">User</option>
                            <option value="Technician">Technician</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="text-white" for="password">Password</label>    
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="text-white" for="password_confirmation">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-3">Add User</button>
                </form>
            </div>
        </div>
    </div>
@endsection