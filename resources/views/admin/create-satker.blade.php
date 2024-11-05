@extends('layouts.admin-app')

@section('title', 'Tambah Satker')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Satker</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('store-satker') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="nama_satker">Nama Satker</label>
                                <input type="text" name="nama_satker" id="nama_satker" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-success mt-3">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
