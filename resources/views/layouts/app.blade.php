<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Turcar Concessionária — Encontre o Carro Perfeito')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-surface text-black-bean antialiased selection:bg-fire-red selection:text-white">
    <!-- Top Information Bar (Black Bean #280B0B) -->
    <x-topbar />

    <!-- Main Sticky Navigation Bar -->
    <x-navbar />

    <!-- Session & Validation Alerts -->
    <x-alert />

    <!-- Main Page Content -->
    <main class="flex-1">
        @yield('conteudo')
    </main>

    <!-- Footer (Black Bean #280B0B) -->
    <x-footer />
</body>
</html>
