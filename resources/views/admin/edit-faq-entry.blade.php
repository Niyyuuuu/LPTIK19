<!-- resources/views/admin/edit-faq-entry.blade.php -->
@extends('layouts.admin-app')

@section('title', 'Edit FAQ Entry')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style-admin.css') }}">
@endpush

@section('content')
    <div class="container mt-5">
        <h1 class="text-white fw-bold">Edit FAQ Entry</h1>

        <div class="card mt-4">
            <div class="card-header bg-primary">
                <h5 class="text-white mb-0">Editing FAQ for Category: {{ $category->name }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('faq.entry.update', [$category->id, $faq->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="question" class="form-label">Question</label>
                        <input type="text" class="form-control @error('question') is-invalid @enderror" 
                               id="question" name="question" value="{{ old('question', $faq->question) }}" required>
                        @error('question')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="answer" class="form-label">Answer</label>
                        <textarea class="form-control @error('answer') is-invalid @enderror" 
                                  id="answer" name="answer" rows="5" required>{{ old('answer', $faq->answer) }}</textarea>
                        @error('answer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">Update FAQ</button>
                    <a href="{{ route('faq.category.detail', $category->id) }}" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>
@endsection
