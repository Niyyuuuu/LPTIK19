@extends('layouts.admin-app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-white fw-bold">Process Ticket: {{ $ticket->title }}</h2>

    <form action="{{ route('ticket.assign-technician', $ticket->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="text-white mb-2" for="technician_id">Choose Technician/Piket:</label>
            <select class="form-control" name="technician_id" id="technician_id" required>
                <option value="">-- Choose Technician/Piket --</option>
                @foreach($technicians as $technician)
                    <option value="{{ $technician->id }}">{{ $technician->name }} ({{ $technician->role }})</option>
                @endforeach
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary mt-3">Process Ticket</button>
        <button type="button" class="btn btn-secondary mt-3" onclick="window.history.back()">Back</button></button>
    </form>
</div>
@endsection
