@extends('layouts.admin-app')

@section('content')
<div class="container">
    <h2>Proses Tiket: {{ $ticket->title }}</h2>

    <form action="{{ route('ticket.assign-technician', $ticket->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="technician_id">Pilih Teknisi:</label>
            <select class="form-control" name="technician_id" id="technician_id" required>
                <option value="">-- Pilih Teknisi --</option>
                @foreach($technicians as $technician)
                    <option value="{{ $technician->id }}">{{ $technician->name }}</option>
                @endforeach
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Proses Tiket</button>
    </form>
</div>
@endsection
