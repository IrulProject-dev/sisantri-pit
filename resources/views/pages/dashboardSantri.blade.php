@extends('layouts.app')

@section('title', 'Dashboard - SiSantri')

@section('content')
    <div class="container mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
            <p class="text-gray-600">Selamat datang, {{ Auth::user()->name }}!</p>
        </div>
    </div>
@endsection
