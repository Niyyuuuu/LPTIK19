@extends('layouts.admin-app')

@section('title', 'Edit Satker')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Satker</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('update-satker', $satker->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="nama_satker">Nama Satker</label>
                                <input type="text" name="nama_satker" id="nama_satker" class="form-control" value="{{ $satker->nama_satker }}" required>
                            </div>
                            <button type="submit" class="btn btn-success mt-3">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
