@extends('layouts.auth')

@section('title', 'Login - SiSantri')

@section('content')
    <div class="w-full md:w-1/2 flex items-center justify-center p-8">
        <div class="w-full max-w-md">
            <div class="mb-4 text-center">
                <img src="{{ asset('assets/images/SiSantri-logo2.png') }}" alt="SiSantri-logo"
                    class="w-auto h-[100px] mb-4 mx-auto">
                <h1 class="text-2xl font-bold text-primary mb-1">Sistem Informasi Santri Pondok IT</h1>
                <p class="text-muted-foreground">Masuk ke akun <span class="text-[#0a84b7]">SiSantri</span> anda
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

            <!-- Database connection status indicator -->
            @if (session('db_status') === 'offline')
                <div class="bg-yellow-50 border border-yellow-200 text-sm text-yellow-800 rounded-md p-4 mb-5">
                    <p>System is currently experiencing database connectivity issues. Some features may be limited.</p>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-foreground mb-2">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                        placeholder="user@email.com"
                        class="py-2 px-4 block w-full border border-border rounded-md text-sm focus:border-primary focus:ring-primary focus:ring-opacity-10 focus:outline-none focus:shadow-md">
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-foreground mb-2">Password</label>
                    <input type="password" id="password" name="password" required autocomplete="off"
                        autocomplete="new-password" aria-autocomplete="none" placeholder="··········"
                        class="py-2 px-4 block w-full border border-border rounded-md text-sm focus:border-primary focus:ring-primary focus:ring-opacity-10 focus:outline-none focus:shadow-md">
                </div>

                <div class="mb-6">
                    <button type="submit"
                        class="w-full py-2 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-primary text-primary-foreground hover:bg-primary/80 disabled:opacity-50  hover:cursor-pointer disabled:pointer-events-none">
                        Login
                    </button>
                </div>
            </form>

            {{-- <p class="text-center text-sm text-muted-foreground">
                    Don't have an account? <a href="{{ route('register') }}"
                        class="text-primary hover:underline">Register</a>
                </p> --}}

            {{-- Footer right column --}}
            <div class="mt-5">
                <p class="text-center text-sm text-muted-foreground">Presented by Programmer Division Pondok
                    IT Indonesia.</p>
            </div>
        </div>
    </div>
@endsection
