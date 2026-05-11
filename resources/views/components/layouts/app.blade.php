<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'OptiGest' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            box-sizing: border-box;
        }
        body {
            font-size: 16px;
            font-weight: 500;
            color: #1e293b;
            margin: 0;
            background: linear-gradient(135deg, #e8f0fe 0%, #eef4ff 50%, #f4f7ff 100%);
            min-height: 100vh;
        }
        h1 { font-size: 26px; font-weight: 800; color: #0f172a; margin: 0; }
        h2 { font-size: 20px; font-weight: 700; color: #1e293b; margin: 0; }
        h3 { font-size: 17px; font-weight: 700; color: #1e293b; margin: 0; }
        p  { font-size: 15px; color: #475569; margin: 0; }
        label { font-size: 15px; font-weight: 600; color: #334155; }
        input, select, textarea {
            font-size: 15px !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            color: #1e293b !important;
        }
        button { font-family: 'Plus Jakarta Sans', sans-serif !important; }
        th { font-size: 14px; font-weight: 700; color: #64748b; }
        td { font-size: 15px; color: #1e293b; }
        a  { font-size: 15px; }
        span { font-size: 15px; }
        table { width: 100%; border-collapse: collapse; }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<div style="display:flex; flex-direction:column; min-height:100vh; padding:8px; gap:8px;">

    {{-- Navbar 15vh --}}
    <div style="height:7vh; flex-shrink:0;">
        @include('layouts.partials.navbar')
    </div>

    <div style="display:flex; gap:8px; flex:1; min-height:0;">

        {{-- Sidebar 18% --}}
        <div style="width:15%; flex-shrink:0;">
            @include('layouts.partials.sidebar')
        </div>

        {{-- Contenu principal --}}
        <main style="flex:1; min-width:0; border-radius:16px; border:1px solid #c7d9f5; padding:28px;
                     background:rgba(255,255,255,0.90);
                     box-shadow: 0 4px 20px rgba(30,58,138,0.07);">
            {{ $slot }}
        </main>

    </div>
</div>

</body>
</html>
