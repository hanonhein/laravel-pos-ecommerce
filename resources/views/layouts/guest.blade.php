{{-- resources/views/layouts/guest.blade.php --}}
<!DOCTYPE html>
{{-- This tells Bootstrap to use its dark theme variables for the entire page --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/scss/app.scss', 'resources/js/app.js'])

        {{-- Custom styles for the dark theme and improved form inputs --}}
        <style>
            body {
                background-color: #212529; /* Bootstrap's dark background color */
            }
            /* This is the new rule to make the input text brighter */
            .form-control {
                color: #f8f9fa !important; /* A bright white color */
            }
        </style>




    </head>
    {{-- We ensure the body has the base dark background color --}}
    <body class="bg-dark">
        <div class="container">
            <div class="row justify-content-center align-items-center min-vh-100">
                <div class="col-md-6 col-lg-4">
                    {{-- The content from login.blade.php will be injected here --}}
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
