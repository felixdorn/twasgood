<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Jost:400&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @routes

    @vite(['resources/css/app.css', 'resources/js/Console/app.ts', "resources/js/Console/Pages/{$page['component']}.vue"])

    @vite(['resources/js/app.ts'])
    @inertiaHead
</head>

<body class="font-sans antialiased h-full">
    @inertia
</body>

</html>
