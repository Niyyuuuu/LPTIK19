@extends('layouts.admin-app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-white fw-bold">Proses Tiket: {{ $ticket->title }}</h2>

    <form action="{{ route('ticket.assign-technician', $ticket->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="text-white mb-2" for="technician_id">Pilih Teknisi:</label>
            <select class="form-control" name="technician_id" id="technician_id" required>
                <option value="">-- Pilih Teknisi --</option>
                @foreach($technicians as $technician)
                    <option value="{{ $technician->id }}">{{ $technician->name }}</option>
                @endforeach
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary mt-3">Proses Tiket</button>
        <button type="button" class="btn btn-secondary mt-3" onclick="window.history.back()">Back</button></button>
    </form>
</div>
@endsection
