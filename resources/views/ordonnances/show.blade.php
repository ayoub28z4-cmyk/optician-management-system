<x-layouts.app title="Ordonnance — OptiGest">

    <div style="max-width:80%; margin:0 auto;">

        {{-- Header --}}
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:32px;">
            <div style="display:flex; align-items:center; gap:16px;">
                <a href="{{ route('clients.ordonnances.index', $client) }}"
                   style="width:44px; height:44px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f0f7ff; display:flex; align-items:center; justify-content:center; flex-shrink:0; text-decoration:none;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="2.5">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0;">
                        Ordonnance du {{ $ordonnance->date_ordonnance->format('d/m/Y') }}
                    </h1>
                    <p style="font-size:16px; color:#94a3b8; margin:6px 0 0;">
                        {{ $client->nom_complet }}
                        @if($ordonnance->medecin) — Dr. {{ $ordonnance->medecin }} @endif
                    </p>
                </div>
            </div>
            <div style="display:flex; gap:10px;">
                <a href="{{ route('clients.ordonnances.edit', [$client, $ordonnance]) }}"
                   style="display:flex; align-items:center; gap:8px; padding:12px 22px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f0f7ff; color:#1d4ed8; font-size:15px; font-weight:700; text-decoration:none;">
                    Modifier
                </a>
                <form method="POST" action="{{ route('clients.ordonnances.destroy', [$client, $ordonnance]) }}"
                      onsubmit="return confirm('Supprimer cette ordonnance ?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            style="display:flex; align-items:center; gap:8px; padding:12px 22px; border-radius:12px; border:1.5px solid #fecaca; background:#fff5f5; color:#ef4444; font-size:15px; font-weight:700; cursor:pointer; font-family:'Plus Jakarta Sans',sans-serif;">
                        Supprimer
                    </button>
                </form>
            </div>
        </div>

        {{-- Badge éligibilité --}}
        @php $jours = $ordonnance->jours_restants; @endphp
        <div style="margin-bottom:24px; padding:16px 20px; border-radius:14px; display:flex; align-items:center; justify-content:space-between;
                    {{ $jours <= 0 ? 'background:#dcfce7; border:1.5px solid #bbf7d0;' : ($jours <= 60 ? 'background:#fee2e2; border:1.5px solid #fecaca;' : ($jours <= 180 ? 'background:#fef9c3; border:1.5px solid #fde68a;' : 'background:#f1f5f9; border:1.5px solid #e2e8f0;')) }}">
            <div style="display:flex; align-items:center; gap:10px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                     stroke="{{ $jours <= 0 ? '#16a34a' : ($jours <= 60 ? '#ef4444' : ($jours <= 180 ? '#ca8a04' : '#64748b')) }}"
                     stroke-width="2.2">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
                <div>
                    <p style="font-size:16px; font-weight:700; margin:0; color:{{ $jours <= 0 ? '#16a34a' : ($jours <= 60 ? '#ef4444' : ($jours <= 180 ? '#ca8a04' : '#64748b')) }};">
                        @if($jours <= 0) Client éligible au remboursement mutuelle
                        @else Éligibilité mutuelle dans {{ $jours }} jours
                        @endif
                    </p>
                    <p style="font-size:14px; color:#94a3b8; margin:4px 0 0;">
                        Date d'éligibilité : {{ $ordonnance->date_eligibilite->format('d/m/Y') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Données optiques --}}
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-bottom:24px;">

            {{-- OD --}}
            <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:28px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px; padding-bottom:16px; border-bottom:1.5px solid #f0f7ff;">
                    <div style="width:40px; height:40px; border-radius:10px; background:#dbeafe; display:flex; align-items:center; justify-content:center;">
                        <span style="font-size:16px; font-weight:800; color:#1d4ed8;">OD</span>
                    </div>
                    <h2 style="font-size:18px; font-weight:700; color:#0f172a; margin:0;">Oeil droit</h2>
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px;">
                    <div style="text-align:center; padding:16px; border-radius:12px; background:#f8fbff; border:1px solid #dbeafe;">
                        <p style="font-size:13px; color:#94a3b8; font-weight:600; margin:0 0 8px;">Sphère</p>
                        <p style="font-size:22px; font-weight:800; color:#1d4ed8; margin:0;">{{ $ordonnance->od_sphere ?? '—' }}</p>
                    </div>
                    <div style="text-align:center; padding:16px; border-radius:12px; background:#f8fbff; border:1px solid #dbeafe;">
                        <p style="font-size:13px; color:#94a3b8; font-weight:600; margin:0 0 8px;">Cylindre</p>
                        <p style="font-size:22px; font-weight:800; color:#1d4ed8; margin:0;">{{ $ordonnance->od_cylindre ?? '—' }}</p>
                    </div>
                    <div style="text-align:center; padding:16px; border-radius:12px; background:#f8fbff; border:1px solid #dbeafe;">
                        <p style="font-size:13px; color:#94a3b8; font-weight:600; margin:0 0 8px;">Axe</p>
                        <p style="font-size:22px; font-weight:800; color:#1d4ed8; margin:0;">{{ $ordonnance->od_axe ?? '—' }}</p>
                    </div>
                </div>
            </div>

            {{-- OG --}}
            <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:28px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px; padding-bottom:16px; border-bottom:1.5px solid #f0f7ff;">
                    <div style="width:40px; height:40px; border-radius:10px; background:#dcfce7; display:flex; align-items:center; justify-content:center;">
                        <span style="font-size:16px; font-weight:800; color:#16a34a;">OG</span>
                    </div>
                    <h2 style="font-size:18px; font-weight:700; color:#0f172a; margin:0;">Oeil gauche</h2>
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px;">
                    <div style="text-align:center; padding:16px; border-radius:12px; background:#f8fbff; border:1px solid #dbeafe;">
                        <p style="font-size:13px; color:#94a3b8; font-weight:600; margin:0 0 8px;">Sphère</p>
                        <p style="font-size:22px; font-weight:800; color:#16a34a; margin:0;">{{ $ordonnance->og_sphere ?? '—' }}</p>
                    </div>
                    <div style="text-align:center; padding:16px; border-radius:12px; background:#f8fbff; border:1px solid #dbeafe;">
                        <p style="font-size:13px; color:#94a3b8; font-weight:600; margin:0 0 8px;">Cylindre</p>
                        <p style="font-size:22px; font-weight:800; color:#16a34a; margin:0;">{{ $ordonnance->og_cylindre ?? '—' }}</p>
                    </div>
                    <div style="text-align:center; padding:16px; border-radius:12px; background:#f8fbff; border:1px solid #dbeafe;">
                        <p style="font-size:13px; color:#94a3b8; font-weight:600; margin:0 0 8px;">Axe</p>
                        <p style="font-size:22px; font-weight:800; color:#16a34a; margin:0;">{{ $ordonnance->og_axe ?? '—' }}</p>
                    </div>
                </div>
            </div>

        </div>

        {{-- Addition + EP + Remarques --}}
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">
            <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:28px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                <h2 style="font-size:18px; font-weight:700; color:#0f172a; margin:0 0 20px; padding-bottom:14px; border-bottom:1.5px solid #f0f7ff;">Général</h2>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                    <div style="text-align:center; padding:16px; border-radius:12px; background:#f5f3ff; border:1px solid #c4b5fd;">
                        <p style="font-size:13px; color:#94a3b8; font-weight:600; margin:0 0 8px;">Addition</p>
                        <p style="font-size:22px; font-weight:800; color:#7c3aed; margin:0;">{{ $ordonnance->addition ?? '—' }}</p>
                    </div>
                    <div style="text-align:center; padding:16px; border-radius:12px; background:#fefce8; border:1px solid #fde68a;">
                        <p style="font-size:13px; color:#94a3b8; font-weight:600; margin:0 0 8px;">Écart pupillaire</p>
                        <p style="font-size:22px; font-weight:800; color:#ca8a04; margin:0;">{{ $ordonnance->ecart_pupillaire ?? '—' }}</p>
                    </div>
                </div>
            </div>
            @if($ordonnance->remarques)
            <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:28px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                <h2 style="font-size:18px; font-weight:700; color:#0f172a; margin:0 0 20px; padding-bottom:14px; border-bottom:1.5px solid #f0f7ff;">Remarques</h2>
                <p style="font-size:16px; color:#334155; line-height:1.8; margin:0;">{{ $ordonnance->remarques }}</p>
            </div>
            @endif
        </div>

    </div>

</x-layouts.app>
