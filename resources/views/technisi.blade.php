<!-- technisi.blade.php -->
@extends('layouts.tech-app')

@section('title', 'Technician Dashboard')

@section('header', 'Dashboard Teknisi' )

@section('content')
@if(session('success'))
<div class="message-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="message-error">{{ session('error') }}</div>
@endif
<h2>Selamat Datang di Dashboard, {{ Auth::user()->name }}</h2>
    <p>Gunakan menu di sidebar untuk navigasi.</p>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
@endsection
