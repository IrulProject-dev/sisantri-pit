<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SiSantri - Auth')</title>
    <!-- Favicon -->
    <link rel="icon" href="/favicon.ico" sizes="any" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <!-- Preline UI -->
    <link href="https://cdn.jsdelivr.net/npm/preline@2.0.2/dist/preline.min.css" rel="stylesheet">
    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Custom Styles --}}
    @yield('styles')
</head>

<body class="bg-background text-foreground">
    <div class="flex min-h-screen">
        <!-- Left column with image -->
        <div class="hidden md:flex md:w-1/2 bg-secondary items-center justify-center">
            <img src="https://sib.pondokit.com/wp-content/uploads/2022/12/sib-lp1.jpg" alt="Login"
                class="object-cover h-full w-full object-left">
        </div>

        <!-- Right column with form -->
        @yield('content')
    </div>

    <!-- Preline JS -->
    <script src="https://cdn.jsdelivr.net/npm/preline@2.0.2/dist/preline.js"></script>
    @yield('scripts')
</body>

</html>
