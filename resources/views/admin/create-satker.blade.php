@extends('layouts.admin-app')

@section('title', 'Tambah Satker')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1 class="fw-bold text-white">Tambah Satker</h1>
                        <form action="{{ route('store-satker') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="text-white" for="nama_satker">Nama Satker</label>
                                <input type="text" name="nama_satker" id="nama_satker" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-success mt-3">Save</button>
                            <button type="button" class="btn btn-secondary mt-3" onclick="window.history.back()">Back</button>
                        </form>
                    </div>
                </div>
            </div>
@endsection
