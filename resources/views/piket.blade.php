<!-- piket.blade.php -->
@extends('layouts.piket-app')

@section('title', 'Piket Dashboard')

@section('header', 'Dashboard Piket' )

@section('content')
@if(session('success'))
<div class="message-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="message-error">{{ session('error') }}</div>
@endif

<h2>Selamat Datang di Dashboard Piket</h2>

    
    
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
@endsection