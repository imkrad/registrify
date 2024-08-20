<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title inertia>Registrify | Ateneo de Zamboanga University</title>
        <meta name="description" content="Registrify: A Document Requesting, Tracking and Management System for College of Registrat of Ateneo de Zamboanga University.">
        <meta name="keywords" content="ADZU, Registrify">
        <meta name="author" content="Krad">
        <meta property="og:title" content="Registrify | AdZU">
        <meta property="og:description" content="Documnet Requesting, Tracking and Management System">
        <meta property="og:image" content="URL to the template's logo or featured image">
        <meta property="og:url" content="URL to the template's webpage">
        <meta name="twitter:card" content="summary_large_image">
        <link rel="shortcut icon" href="{{ URL::asset('images/favicon.ico') }}">
        @vite(['resources/js/app.js'])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>