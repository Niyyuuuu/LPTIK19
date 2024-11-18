@extends('layouts.piket-app')

@section('header', 'Edit Ticket' )

@section('content')
<div class="container">
    <form action="{{ route('update-tickets', $ticket->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label class="text-white mb-2" for="prioritas">Pilih Prioritas :</label>
            <select class="form-control" name="prioritas" id="prioritas" required>
                <option value="">-- Pilih Prioritas --</option>
                @foreach($prioritas as $item)
                    <option value="{{ $item }}" {{ $ticket->prioritas === $item ? 'selected' : '' }}>
                        {{ $item }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Proses Tiket</button>
        <button type="button" class="btn btn-secondary mt-3" onclick="window.history.back()">Back</button>
    </form>    
</div>
@endsection
