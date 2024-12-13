@extends('layouts.piket-app')

@section('header', 'Process Ticket' )

@section('content')
<div class="container">
    <form action="{{ route('piket.assign-technician', $ticket->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="text-dark mb-2" for="technician_id">Pilih Teknisi/Piket:</label>
            <select class="form-control" name="technician_id" id="technician_id" required>
                <option value="">-- Pilih Teknisi/Piket --</option>
                @foreach($technicians as $technician)
                    <option value="{{ $technician->id }}">{{ $technician->name }} ({{ $technician->role }})</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Proses Tiket</button>
        <button type="button" class="btn btn-secondary mt-3" onclick="window.history.back()">Back</button>
    </form>
</div>
@endsection
