@extends('layouts.auth')

@section('title', 'Register - SiSantri')

@section('content')
    <div class="w-full md:w-1/2 flex items-center justify-center p-8">
        <div class="w-full max-w-md">
            <div class="mb-4 text-center">
                <img src="assets/images/SiSantri-logo2.png" alt="SiSantri-logo" class="w-auto h-[100px] mb-4 mx-auto">
                <h1 class="text-2xl font-bold text-primary mb-1">Buat Akun Baru</h1>
                <p class="text-muted-foreground">
                    Selamat bergabung dalam pembangunan peradaban
                </p>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-sm text-red-600 rounded-md p-4 mb-5">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-foreground mb-2">Nama</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                        class="py-2 px-4 block w-full border rounded-md text-sm focus:border-primary focus:ring-primary focus:ring-opacity-10 focus:outline-none focus:shadow-md">
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-foreground mb-2">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="py-2 px-4 block w-full border rounded-md text-sm focus:border-primary focus:ring-primary focus:ring-opacity-10 focus:outline-none focus:shadow-md">
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-foreground mb-2">Password</label>
                    <input type="password" id="password" name="password" required
                        class="py-2 px-4 block w-full border rounded-md text-sm focus:border-primary focus:ring-primary focus:ring-opacity-10 focus:outline-none focus:shadow-md">
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-foreground mb-2">Confirm
                        Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="py-2 px-4 block w-full border rounded-md text-sm focus:border-primary focus:ring-primary focus:ring-opacity-10 focus:outline-none focus:shadow-md">
                </div>

                <div class="mb-6">
                    <button type="submit"
                        class="w-full py-2 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-primary text-primary-foreground hover:bg-primary/80 disabled:opacity-50 disabled:pointer-events-none">
                        Register
                    </button>
                </div>
            </form>

            <p class="text-center text-sm text-muted-foreground">
                Already have an account? <a href="{{ route('login') }}" class="text-primary hover:underline">Login</a>
            </p>
        </div>
    </div>
@endsection
