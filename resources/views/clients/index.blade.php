<x-layouts.app title="Clients — OptiGest">

    {{-- Header --}}
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
        <div>
            <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0;">Gestion des clients</h1>
            <p style="font-size:15px; color:#94a3b8; margin:6px 0 0;">{{ $clients->total() }} client(s) enregistré(s)</p>
        </div>
        <a href="{{ route('clients.create') }}"
           style="display:flex; align-items:center; gap:8px; padding:12px 22px; border-radius:12px;
                  background:#1d4ed8; color:#fff; font-size:15px; font-weight:700; text-decoration:none;
                  box-shadow:0 4px 14px rgba(29,78,216,0.35);">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Nouveau client
        </a>
    </div>

    {{-- Filtres --}}
    <form method="GET" action="{{ route('clients.index') }}"
          style="display:flex; align-items:center; gap:12px; margin-bottom:24px; padding:16px 20px;
                 border-radius:14px; border:1px solid #bfdbfe; background:#f0f7ff;">

        <div style="display:flex; align-items:center; gap:10px; flex:1; height:48px;
                    padding:0 16px; border-radius:12px; border:1.5px solid #bfdbfe; background:#fff;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#93c5fd" stroke-width="2.5" style="flex-shrink:0;">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Rechercher par nom, CIN, téléphone, n° registre..."
                   style="background:transparent; border:none; outline:none; width:100%;
                          font-size:15px; color:#334155; font-family:'Plus Jakarta Sans',sans-serif;">
        </div>

        <select name="type"
                style="height:48px; padding:0 16px; border-radius:12px; border:1.5px solid #bfdbfe;
                       background:#fff; font-size:15px; color:#334155; outline:none;
                       font-family:'Plus Jakarta Sans',sans-serif; min-width:160px;">
            <option value="">Tous les types</option>
            <option value="nouveau" {{ request('type') == 'nouveau' ? 'selected' : '' }}>Nouveau</option>
            <option value="ancien" {{ request('type') == 'ancien' ? 'selected' : '' }}>Ancien</option>
        </select>

        <button type="submit"
                style="height:48px; padding:0 24px; border-radius:12px; border:none;
                       background:#1d4ed8; color:#fff; font-size:15px; font-weight:700; cursor:pointer;
                       font-family:'Plus Jakarta Sans',sans-serif;
                       box-shadow:0 3px 10px rgba(29,78,216,0.3);">
            Rechercher
        </button>

        @if(request('search') || request('type'))
        <a href="{{ route('clients.index') }}"
           style="height:48px; padding:0 18px; border-radius:12px; border:1.5px solid #e2e8f0;
                  background:#fff; color:#64748b; font-size:15px; font-weight:600;
                  text-decoration:none; display:flex; align-items:center;">
            Réinitialiser
        </a>
        @endif
    </form>

    {{-- Message succès --}}
    @if(session('success'))
    <div style="margin-bottom:20px; padding:14px 18px; border-radius:12px;
                background:#dcfce7; color:#16a34a; border:1px solid #bbf7d0;
                font-size:15px; font-weight:600;">
        {{ session('success') }}
    </div>
    @endif

    {{-- Tableau --}}
    <div style="border-radius:16px; border:1px solid #bfdbfe; overflow:hidden;
                background:#fff; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#f0f7ff; border-bottom:1.5px solid #dbeafe;">
                    <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">N° Registre</th>
                    <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Client</th>
                    <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">CIN</th>
                    <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Téléphone</th>
                    <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Type</th>
                    <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Mutuelle</th>
                    <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Créé par</th>
                    <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clients as $client)
                <tr style="border-bottom:1px solid #f1f5f9; transition:background 0.15s;"
                    onmouseover="this.style.background='#f8faff'" onmouseout="this.style.background='#fff'">

                    <td style="padding:16px 20px;">
                        <span style="background:#dbeafe; color:#1d4ed8; font-size:14px; font-weight:800;
                                     padding:5px 12px; border-radius:8px; font-family:monospace;">
                            {{ $client->classement_registre ?? '—' }}
                        </span>
                    </td>

                    <td style="padding:16px 20px;">
                        <div style="display:flex; align-items:center; gap:12px;">
                            <div style="width:40px; height:40px; border-radius:50%; background:#dbeafe;
                                        display:flex; align-items:center; justify-content:center;
                                        font-size:14px; font-weight:800; color:#1d4ed8; flex-shrink:0;">
                                {{ $client->initiales }}
                            </div>
                            <div>
                                <div style="font-size:15px; font-weight:700; color:#0f172a;">{{ $client->nom_complet }}</div>
                                <div style="font-size:13px; color:#94a3b8; margin-top:2px;">{{ $client->email ?? '—' }}</div>
                            </div>
                        </div>
                    </td>

                    <td style="padding:16px 20px; font-size:15px; color:#334155; font-family:monospace; font-weight:600; letter-spacing:1px;">
                        {{ $client->cin }}
                    </td>

                    <td style="padding:16px 20px; font-size:15px; color:#334155; font-weight:600;">
                        {{ $client->telephone }}
                    </td>

                    <td style="padding:16px 20px;">
                        <span style="font-size:13px; font-weight:700; padding:5px 14px; border-radius:99px;
                                     {{ $client->type === 'nouveau'
                                        ? 'background:#dcfce7; color:#16a34a;'
                                        : 'background:#f1f5f9; color:#64748b;' }}">
                            {{ ucfirst($client->type) }}
                        </span>
                    </td>
                    <td style="padding:16px 20px;">
                        <span style="font-size:13px; font-weight:700; padding:5px 14px; border-radius:99px;
                                    background:{{ $client->mutuelle_color['bg'] }}; color:{{ $client->mutuelle_color['color'] }};">
                            {{ $client->mutuelle_label }}
                        </span>
                    </td>

                    <td style="padding:16px 20px;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <div style="width:28px; height:28px; border-radius:50%; background:#f1f5f9;
                                        display:flex; align-items:center; justify-content:center;
                                        font-size:11px; font-weight:800; color:#64748b; flex-shrink:0;">
                                {{ strtoupper(substr($client->user->name ?? '?', 0, 2)) }}
                            </div>
                            <span style="font-size:14px; color:#64748b; font-weight:600;">{{ $client->user->name ?? '—' }}</span>
                        </div>
                    </td>

                    <td style="padding:16px 20px;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <a href="{{ route('clients.show', $client) }}"
                               style="padding:7px 16px; border-radius:8px; border:1.5px solid #bfdbfe;
                                      color:#1d4ed8; font-size:14px; font-weight:600; text-decoration:none;
                                      background:#f0f7ff;">
                                Voir
                            </a>
                            <a href="{{ route('clients.edit', $client) }}"
                               style="padding:7px 16px; border-radius:8px; border:1.5px solid #e2e8f0;
                                      color:#475569; font-size:14px; font-weight:600; text-decoration:none;
                                      background:#f8fafc;">
                                Modifier
                            </a>
                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="8" style="padding:60px 20px; text-align:center; font-size:16px; color:#94a3b8;">
                        Aucun client trouvé
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if($clients->hasPages())
        <div style="padding:16px 20px; border-top:1px solid #f0f7ff;">
            {{ $clients->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

</x-layouts.app>
