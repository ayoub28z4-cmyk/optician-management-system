<x-layouts.app title="Ordonnances — OptiGest">

    {{-- Header --}}
    <div style="max-width:90%; margin:0 auto;">

        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:32px;">
            <div>
                <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0;">Ordonnances</h1>
                <p style="font-size:16px; color:#94a3b8; margin:6px 0 0;">{{ $clients->total() }} client(s) avec ordonnance(s)</p>
            </div>
        </div>
       

        <div style="border-radius:16px; border:1px solid #bfdbfe; overflow:hidden;
                    background:#fff; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="background:#f0f7ff; border-bottom:1.5px solid #dbeafe;">
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Client</th>
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Dernière ordonnance</th>
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Médecin</th>
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Éligibilité mutuelle</th>
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Créé par</th>
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $client)
                    @php
                        $ordo  = $client->derniereOrdonnance;
                        $jours = $ordo ? $ordo->jours_restants : null;
                    @endphp
                    <tr style="border-bottom:1px solid #f1f5f9;"
                        onmouseover="this.style.background='#f8faff'" onmouseout="this.style.background='#fff'">

                        <td style="padding:16px 20px;">
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div style="width:40px; height:40px; border-radius:50%; background:#dbeafe;
                                            display:flex; align-items:center; justify-content:center;
                                            font-size:14px; font-weight:800; color:#1d4ed8; flex-shrink:0;">
                                    {{ $client->initiales }}
                                </div>
                                <div>
                                    <div style="font-size:15px; font-weight:700; color:#0f172a;">{{ $client->nom_complet }}</div>
                                    <div style="font-size:13px; color:#94a3b8;">
                                        N° <span style="font-family:monospace; font-weight:700; color:#1d4ed8;">{{ $client->classement_registre ?? '—' }}</span>
                                        — {{ $client->telephone }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td style="padding:16px 20px; font-size:15px; font-weight:600; color:#334155;">
                            {{ $ordo ? $ordo->date_ordonnance->format('d/m/Y') : '—' }}
                        </td>

                        <td style="padding:16px 20px; font-size:15px; color:#334155;">
                            {{ $ordo && $ordo->medecin ? 'Dr. '.$ordo->medecin : '—' }}
                        </td>

                        <td style="padding:16px 20px;">
                            @if($jours === null)
                                <span style="background:#f1f5f9; color:#64748b; font-size:13px; font-weight:700; padding:5px 12px; border-radius:99px;">—</span>
                            @elseif($jours <= 0)
                                <span style="background:#dcfce7; color:#16a34a; font-size:13px; font-weight:700; padding:5px 12px; border-radius:99px;">Éligible</span>
                            @elseif($jours <= 60)
                                <span style="background:#fee2e2; color:#ef4444; font-size:13px; font-weight:700; padding:5px 12px; border-radius:99px;">J-{{ $jours }}</span>
                            @elseif($jours <= 180)
                                <span style="background:#fef9c3; color:#ca8a04; font-size:13px; font-weight:700; padding:5px 12px; border-radius:99px;">J-{{ $jours }}</span>
                            @else
                                <span style="background:#f1f5f9; color:#64748b; font-size:13px; font-weight:700; padding:5px 12px; border-radius:99px;">J-{{ $jours }}</span>
                            @endif
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
                                @if($ordo)
                                <a href="{{ route('clients.ordonnances.show', [$client, $ordo]) }}"
                                   style="padding:7px 16px; border-radius:8px; border:1.5px solid #bfdbfe;
                                          color:#1d4ed8; font-size:14px; font-weight:600; text-decoration:none;
                                          background:#f0f7ff;">
                                    Dernière
                                </a>
                                @endif
                                <a href="{{ route('clients.ordonnances.index', $client) }}"
                                   style="padding:7px 16px; border-radius:8px; border:1.5px solid #c7d2fe;
                                          color:#7c3aed; font-size:14px; font-weight:600; text-decoration:none;
                                          background:#f5f3ff;">
                                    Historique
                                </a>
                                <a href="{{ route('clients.ordonnances.create', $client) }}"
                                   style="padding:7px 16px; border-radius:8px; border:1.5px solid #bbf7d0;
                                          color:#16a34a; font-size:14px; font-weight:600; text-decoration:none;
                                          background:#f0fdf4;">
                                    + Nouvelle
                                </a>
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding:60px 20px; text-align:center; font-size:16px; color:#94a3b8;">
                            Aucun client avec ordonnance
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            @if($clients->hasPages())
            <div style="padding:16px 20px; border-top:1px solid #f0f7ff;">
                {{ $clients->links() }}
            </div>
            @endif
        </div>

    </div>

</x-layouts.app>
