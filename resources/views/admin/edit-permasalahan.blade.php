@extends('layouts.admin-app')

@section('title', 'Edit Permasalahan')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1 class="fw-bold text-white">Edit Permasalahan</h1>
                        <form action="{{ route('update-permasalahan', $permasalahan->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="text-white" for="deskripsi">Nama Permasalahan</label>
                                <input type="text" name="deskripsi" id="deskripsi" class="form-control" value="{{ $permasalahan->deskripsi }}" required>
                            </div>
                            <button type="submit" class="btn btn-success mt-3">Update</button>
                            <button type="button" class="btn btn-secondary mt-3" onclick="window.history.back()">Back</button>
                        </form>
                    </div>
                </div>
            </div>
@endsection
