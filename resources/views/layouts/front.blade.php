<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            <a href="/">
                <img src="{{ asset('dist/images/logo-horizontal.png') }}" alt="logo" class="h-20 fill-current">
            </a>
        </div>

        <div>
            {{ $slot }}
        </div>
    </div>

    <!-- BEGIN: Notification Content -->
    <div id="success-notification" class="toastify-content hidden flex"> <i class="text-success"
            data-lucide="check-circle-2"></i>
        <div class="ml-4 mr-4">
            <div class="font-medium" id="success-notification-title"></div>
            <div class="text-slate-500 mt-1" id="success-notification-message"></div>
        </div>
    </div> <!-- END: Notification Content -->

    @stack('custom-scripts')
</body>

</html>
