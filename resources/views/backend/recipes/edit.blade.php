<!DOCTYPE html>
<html lang="fr" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ $recipe->title }} - Faire plus, acheter moins.</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=jost:400" rel="stylesheet" />

    {{ $head ?? '' }}

    @vite(['resources/css/app.css', 'resources/js/app.ts'])
</head>

<body>
</body>

</html>
