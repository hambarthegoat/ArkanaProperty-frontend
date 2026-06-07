<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Design Arkanaproperty Web App')</title>
    <meta name="description" content="Streamline real estate management with a professional platform for developers, staff, and homeowners, featuring a public landing page and dedicated portals." />
    <meta name="robots" content="noindex, nofollow" />
    <style>html, body { height: 100%; margin: 0; } #root { height: 100%; }</style>

    @vite(['resources/css/app.css'])
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</head>
<body>
    <div id="root">
        @yield('content')
    </div>

    <script>
        if (window.lucide) { lucide.createIcons(); }
    </script>
    @stack('scripts')
</body>
</html>
