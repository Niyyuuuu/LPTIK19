@extends('layouts.admin-app')

@section('title', 'Tambah Permasalahan')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1 class="fw-bold text-white">Tambah Kategori Permasalahan</h1>
                        <form action="{{ route('store-permasalahan') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="text-white" for="deskripsi">Nama Kategori Permasalahan</label>
                                <input type="text" name="deskripsi" id="deskripsi" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Add</button>
                            <button type="button" class="btn btn-secondary mt-3" onclick="window.history.back()">Back</button>
                        </form>
                    </div>
                </div>
            </div>
@endsection
