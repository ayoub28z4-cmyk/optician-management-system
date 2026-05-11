<x-layouts.app title="Ordonnances — OptiGest">

    <div style="max-width:80%; margin:0 auto;">

        {{-- Header --}}
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:32px;">
            <div style="display:flex; align-items:center; gap:16px;">
                <a href="{{ route('clients.show', $client) }}"
                   style="width:44px; height:44px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f0f7ff; display:flex; align-items:center; justify-content:center; flex-shrink:0; text-decoration:none;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="2.5">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0;">Ordonnances</h1>
                    <p style="font-size:16px; color:#94a3b8; margin:6px 0 0;">
                        Client : <span style="color:#1d4ed8; font-weight:700;">{{ $client->nom_complet }}</span>
                        — N° <span style="font-family:monospace; font-weight:800; color:#1d4ed8;">{{ $client->classement_registre ?? '—' }}</span>
                    </p>
                </div>
            </div>
            <a href="{{ route('clients.ordonnances.create', $client) }}"
               style="display:flex; align-items:center; gap:8px; padding:12px 22px; border-radius:12px;
                      background:#1d4ed8; color:#fff; font-size:15px; font-weight:700; text-decoration:none;
                      box-shadow:0 4px 14px rgba(29,78,216,0.35);">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Nouvelle ordonnance
            </a>
        </div>

        {{-- Message succès --}}
        @if(session('success'))
        <div style="margin-bottom:20px; padding:14px 18px; border-radius:12px;
                    background:#dcfce7; color:#16a34a; border:1px solid #bbf7d0;
                    font-size:15px; font-weight:600;">
            {{ session('success') }}
        </div>
        @endif

        {{-- Liste ordonnances --}}
        @forelse($ordonnances as $ordonnance)
        <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:24px;
                    margin-bottom:16px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">

            {{-- Header card --}}
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; padding-bottom:16px; border-bottom:1.5px solid #f0f7ff;">
                <div style="display:flex; align-items:center; gap:14px;">
                    <div style="width:44px; height:44px; border-radius:12px; background:#dbeafe; display:flex; align-items:center; justify-content:center;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="2.2">
                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                    </div>
                    <div>
                        <p style="font-size:17px; font-weight:800; color:#0f172a; margin:0;">
                            Ordonnance du {{ $ordonnance->date_ordonnance->format('d/m/Y') }}
                        </p>
                        <p style="font-size:14px; color:#94a3b8; margin:4px 0 0;">
                            {{ $ordonnance->medecin ? 'Dr. ' . $ordonnance->medecin : 'Médecin non renseigné' }}
                            — Saisie par {{ $ordonnance->user->name }}
                        </p>
                    </div>
                </div>
                <div style="display:flex; align-items:center; gap:10px;">
                    {{-- Badge éligibilité --}}
                    @php $jours = $ordonnance->jours_restants; @endphp
                    @if($jours <= 0)
                        <span style="background:#dcfce7; color:#16a34a; font-size:13px; font-weight:700; padding:5px 12px; border-radius:99px;">Éligible maintenant</span>
                    @elseif($jours <= 60)
                        <span style="background:#fee2e2; color:#ef4444; font-size:13px; font-weight:700; padding:5px 12px; border-radius:99px;">Éligible dans {{ $jours }}j</span>
                    @elseif($jours <= 180)
                        <span style="background:#fef9c3; color:#ca8a04; font-size:13px; font-weight:700; padding:5px 12px; border-radius:99px;">Éligible dans {{ $jours }}j</span>
                    @else
                        <span style="background:#f1f5f9; color:#64748b; font-size:13px; font-weight:700; padding:5px 12px; border-radius:99px;">{{ $jours }}j restants</span>
                    @endif
                    <a href="{{ route('clients.ordonnances.show', [$client, $ordonnance]) }}"
                       style="padding:8px 16px; border-radius:10px; border:1.5px solid #bfdbfe; background:#f0f7ff; color:#1d4ed8; font-size:14px; font-weight:700; text-decoration:none;">
                        Voir
                    </a>
                    <a href="{{ route('clients.ordonnances.edit', [$client, $ordonnance]) }}"
                       style="padding:8px 16px; border-radius:10px; border:1.5px solid #e2e8f0; background:#f8fafc; color:#475569; font-size:14px; font-weight:700; text-decoration:none;">
                        Modifier
                    </a>
                </div>
            </div>

            {{-- Données optiques --}}
            <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px;">

                {{-- OD --}}
                <div style="border-radius:12px; border:1.5px solid #dbeafe; padding:16px; background:#f8fbff;">
                    <p style="font-size:13px; font-weight:700; color:#1d4ed8; margin:0 0 12px; text-transform:uppercase; letter-spacing:0.5px;">Oeil droit (OD)</p>
                    <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:8px;">
                        <div style="text-align:center;">
                            <p style="font-size:12px; color:#94a3b8; font-weight:600; margin:0 0 4px;">Sphère</p>
                            <p style="font-size:17px; font-weight:800; color:#0f172a; margin:0;">{{ $ordonnance->od_sphere ?? '—' }}</p>
                        </div>
                        <div style="text-align:center;">
                            <p style="font-size:12px; color:#94a3b8; font-weight:600; margin:0 0 4px;">Cylindre</p>
                            <p style="font-size:17px; font-weight:800; color:#0f172a; margin:0;">{{ $ordonnance->od_cylindre ?? '—' }}</p>
                        </div>
                        <div style="text-align:center;">
                            <p style="font-size:12px; color:#94a3b8; font-weight:600; margin:0 0 4px;">Axe</p>
                            <p style="font-size:17px; font-weight:800; color:#0f172a; margin:0;">{{ $ordonnance->od_axe ?? '—' }}</p>
                        </div>
                    </div>
                </div>

                {{-- OG --}}
                <div style="border-radius:12px; border:1.5px solid #dbeafe; padding:16px; background:#f8fbff;">
                    <p style="font-size:13px; font-weight:700; color:#1d4ed8; margin:0 0 12px; text-transform:uppercase; letter-spacing:0.5px;">Oeil gauche (OG)</p>
                    <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:8px;">
                        <div style="text-align:center;">
                            <p style="font-size:12px; color:#94a3b8; font-weight:600; margin:0 0 4px;">Sphère</p>
                            <p style="font-size:17px; font-weight:800; color:#0f172a; margin:0;">{{ $ordonnance->og_sphere ?? '—' }}</p>
                        </div>
                        <div style="text-align:center;">
                            <p style="font-size:12px; color:#94a3b8; font-weight:600; margin:0 0 4px;">Cylindre</p>
                            <p style="font-size:17px; font-weight:800; color:#0f172a; margin:0;">{{ $ordonnance->og_cylindre ?? '—' }}</p>
                        </div>
                        <div style="text-align:center;">
                            <p style="font-size:12px; color:#94a3b8; font-weight:600; margin:0 0 4px;">Axe</p>
                            <p style="font-size:17px; font-weight:800; color:#0f172a; margin:0;">{{ $ordonnance->og_axe ?? '—' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Commun --}}
                <div style="border-radius:12px; border:1.5px solid #dbeafe; padding:16px; background:#f8fbff;">
                    <p style="font-size:13px; font-weight:700; color:#1d4ed8; margin:0 0 12px; text-transform:uppercase; letter-spacing:0.5px;">Général</p>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px;">
                        <div style="text-align:center;">
                            <p style="font-size:12px; color:#94a3b8; font-weight:600; margin:0 0 4px;">Addition</p>
                            <p style="font-size:17px; font-weight:800; color:#0f172a; margin:0;">{{ $ordonnance->addition ?? '—' }}</p>
                        </div>
                        <div style="text-align:center;">
                            <p style="font-size:12px; color:#94a3b8; font-weight:600; margin:0 0 4px;">EP</p>
                            <p style="font-size:17px; font-weight:800; color:#0f172a; margin:0;">{{ $ordonnance->ecart_pupillaire ?? '—' }}</p>
                        </div>
                    </div>
                </div>

            </div>

            @if($ordonnance->remarques)
            <div style="margin-top:14px; padding:12px 16px; border-radius:10px; background:#fefce8; border:1px solid #fde68a;">
                <p style="font-size:14px; color:#92400e; margin:0;"><strong>Remarques :</strong> {{ $ordonnance->remarques }}</p>
            </div>
            @endif

        </div>
        @empty
        <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:60px 20px; text-align:center; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
            <p style="font-size:18px; color:#94a3b8; margin:0;">Aucune ordonnance enregistrée pour ce client</p>
            <a href="{{ route('clients.ordonnances.create', $client) }}"
               style="display:inline-flex; align-items:center; gap:8px; margin-top:16px; padding:12px 24px; border-radius:12px;
                      background:#1d4ed8; color:#fff; font-size:15px; font-weight:700; text-decoration:none;">
                Ajouter une ordonnance
            </a>
        </div>
        @endforelse

        {{-- Pagination --}}
        @if($ordonnances->hasPages())
        <div style="margin-top:16px;">
            {{ $ordonnances->links() }}
        </div>
        @endif

    </div>

</x-layouts.app>
