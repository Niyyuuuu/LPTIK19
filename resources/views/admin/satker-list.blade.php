@extends('layouts.admin-app')

@section('title', 'List Satker')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style-admin.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Satker List</h1>

    <div>
        <a href="{{ route('create-satker') }}" class="btn btn-success mb-4">Add New Satker</a>
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
                    @foreach ($satkers as $satker)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $satker->nama_satker }}</td>
                        <td class="text-end">
                            <a href="{{ route('edit-satker', $satker->id) }}" class="btn btn-primary">Edit</a>  
                            <form action="{{ route('delete-satker', $satker->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus Satker ini?')">Delete</button>
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

