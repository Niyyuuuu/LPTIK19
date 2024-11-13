@extends('layouts.piket-app')

@section('header', 'Update Ticket' )

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap');
    
        body {
            background-color: #161616;
            color: #fff;
            font-family: 'Poppins', sans-serif;
        }
        
        .card {
            background-color: #1e1e1e;
            color: #fff;
            border: none;
            min-height: 150px;
            border-radius: 10px;
        }
        
        .card-header {
            background-color: #2c2c2c;
            border-bottom: none;
        }
        
        .card-body {
            background-color: #1e1e1e;
        }
    </style>
@endpush

@section('content')

@if(session('success'))
    <div class="message-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="message-error">{{ session('error') }}</div>
@endif

