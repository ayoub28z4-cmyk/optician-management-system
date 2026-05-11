<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'OptiGest' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; }
        html, body { height: 100%; overflow: hidden; margin: 0; padding: 0; }
    </style>
</head>
<body style="background:linear-gradient(135deg,#dbeeff 0%,#e8f4ff 40%,#f0f8ff 100%);
             height:100vh; overflow:hidden;
             font-family:'Plus Jakarta Sans',system-ui,sans-serif;">

<div style="display:flex; flex-direction:column; height:100vh; padding:8px; gap:8px;">

    {{-- Navbar --}}
    @include('layouts.partials.navbar')

    {{-- Zone principale --}}
    <div style="display:flex; gap:8px; flex:1; overflow:hidden; min-height:0;">

        {{-- Sidebar --}}
        @include('layouts.partials.sidebar')

        {{-- Contenu principal --}}
        <main style="flex:1; min-height:0; border-radius:16px; border:1px solid #bfdbfe; padding:24px;
                     background:rgba(255,255,255,0.82); overflow-y:auto;
                     box-shadow:0 6px 24px rgba(37,99,235,0.09), 0 1.5px 6px rgba(37,99,235,0.06);">
            {{ $slot }}
        </main>

    </div>
</div>

</body>
</html>
