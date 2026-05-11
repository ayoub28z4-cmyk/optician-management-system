<x-layouts.app title="Dashboard Employé — OptiGest">

    {{-- Header --}}
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:28px;">
        <div>
            <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0;">Tableau de bord</h1>
            <p style="font-size:16px; color:#94a3b8; margin:6px 0 0;">
                {{ now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }}
            </p>
        </div>
        <div style="font-size:15px; font-weight:600; color:#16a34a; background:#f0fdf4; padding:10px 18px; border-radius:12px; border:1px solid #bbf7d0;">
            Bonjour, {{ auth()->user()->name }} 👋
        </div>
    </div>

    {{-- KPIs --}}
    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:24px;">

        <div style="background:#fff; border-radius:16px; border:1px solid #bfdbfe; padding:20px; box-shadow:0 4px 14px rgba(29,78,216,0.08);">
            <div style="width:36px; height:36px; border-radius:10px; background:#eff6ff; display:flex; align-items:center; justify-content:center; margin-bottom:12px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="2.2">
                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>
                </svg>
            </div>
            <div style="font-size:28px; font-weight:800; color:#0f172a; line-height:1;">{{ $totalClients }}</div>
            <div style="font-size:14px; color:#94a3b8; margin-top:6px;">Clients actifs</div>
        </div>

        <div style="background:#fff; border-radius:16px; border:1px solid #bfdbfe; padding:20px; box-shadow:0 4px 14px rgba(29,78,216,0.08);">
            <div style="width:36px; height:36px; border-radius:10px; background:#fff7ed; display:flex; align-items:center; justify-content:center; margin-bottom:12px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ea580c" stroke-width="2.2">
                    <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                    <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
                </svg>
            </div>
            <div style="font-size:28px; font-weight:800; color:#0f172a; line-height:1;">{{ number_format($caAujourdhui, 0) }}</div>
            <div style="font-size:14px; color:#94a3b8; margin-top:6px;">CA aujourd'hui (MAD)</div>
        </div>

        <div style="background:#fff; border-radius:16px; border:1px solid #bfdbfe; padding:20px; box-shadow:0 4px 14px rgba(29,78,216,0.08);">
            <div style="width:36px; height:36px; border-radius:10px; background:#ecfeff; display:flex; align-items:center; justify-content:center; margin-bottom:12px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0891b2" stroke-width="2.2">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
            </div>
            <div style="font-size:28px; font-weight:800; color:#0f172a; line-height:1;">{{ $rdvAujourdhui->count() }}</div>
            <div style="font-size:14px; color:#94a3b8; margin-top:6px;">RDV aujourd'hui</div>
        </div>

    </div>

    {{-- Cards --}}
    <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px;">

        {{-- RDV du jour --}}
        <div style="background:#fff; border-radius:16px; border:1px solid #bfdbfe; padding:20px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; padding-bottom:12px; border-bottom:1px solid #f0f7ff;">
                <span style="font-size:15px; font-weight:700; color:#0f172a;">RDV du jour</span>
                <a href="{{ route('rendez-vous.index') }}" style="font-size:13px; color:#1d4ed8; font-weight:600; text-decoration:none;">Voir tout →</a>
            </div>
            @forelse($rdvAujourdhui as $rdv)
            <div style="display:flex; align-items:center; gap:10px; padding:8px 0; border-bottom:1px solid #f8faff;">
                <span style="font-size:15px; font-weight:800; color:#1d4ed8; min-width:45px;">{{ $rdv->heure }}</span>
                <div style="flex:1;">
                    <div style="font-size:14px; font-weight:700; color:#0f172a;">{{ $rdv->client->nom_complet }}</div>
                    <div style="font-size:12px; color:#94a3b8;">{{ $rdv->motif }}</div>
                </div>
            </div>
            @empty
            <div style="text-align:center; padding:24px 0; font-size:14px; color:#94a3b8;">Aucun RDV aujourd'hui</div>
            @endforelse
            <a href="{{ route('rendez-vous.create') }}"
               style="display:block; margin-top:12px; text-align:center; padding:8px; border-radius:10px; border:1.5px dashed #bfdbfe; color:#1d4ed8; font-size:14px; font-weight:600; text-decoration:none;">
                + Nouveau RDV
            </a>
        </div>

        {{-- Rappels urgents --}}
        <div style="background:#fff; border-radius:16px; border:1px solid #bfdbfe; padding:20px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; padding-bottom:12px; border-bottom:1px solid #f0f7ff;">
                <span style="font-size:15px; font-weight:700; color:#0f172a;">Rappels urgents</span>
                <a href="{{ route('rappels.index') }}" style="font-size:13px; color:#1d4ed8; font-weight:600; text-decoration:none;">Voir tout →</a>
            </div>
            @forelse($rappelsUrgents as $rappel)
            @php $jours = $rappel->jours_avant_rappel; @endphp
            <div style="padding:8px 0; border-bottom:1px solid #f8faff;">
                <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
                    <span style="font-size:14px; font-weight:700; color:#0f172a;">{{ $rappel->client->nom_complet }}</span>
                    <span style="font-size:12px; font-weight:800; color:{{ $jours <= 0 ? '#ef4444' : ($jours <= 30 ? '#ca8a04' : '#1d4ed8') }};">
                        {{ $jours <= 0 ? 'Dépassé' : 'J-'.$jours }}
                    </span>
                </div>
                <div style="height:4px; background:#e0eeff; border-radius:99px; overflow:hidden;">
                    <div style="height:100%; border-radius:99px; width:{{ min(100, max(10, (60-$jours)/60*100)) }}%;
                                background:{{ $jours <= 0 ? '#ef4444' : ($jours <= 30 ? '#ca8a04' : '#1d4ed8') }};"></div>
                </div>
            </div>
            @empty
            <div style="text-align:center; padding:24px 0; font-size:14px; color:#94a3b8;">Aucun rappel urgent</div>
            @endforelse
        </div>

        {{-- Dernières ventes --}}
        <div style="background:#fff; border-radius:16px; border:1px solid #bfdbfe; padding:20px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; padding-bottom:12px; border-bottom:1px solid #f0f7ff;">
                <span style="font-size:15px; font-weight:700; color:#0f172a;">Dernières ventes</span>
                <a href="{{ route('ventes.index') }}" style="font-size:13px; color:#1d4ed8; font-weight:600; text-decoration:none;">Voir tout →</a>
            </div>
            @forelse($dernieresVentes as $vente)
            @php
                $sc = ['non_paye'=>['bg'=>'#fee2e2','color'=>'#ef4444','label'=>'Impayé'],'partiel'=>['bg'=>'#fef9c3','color'=>'#ca8a04','label'=>'Partiel'],'solde'=>['bg'=>'#dcfce7','color'=>'#16a34a','label'=>'Soldé']][$vente->statut_paiement] ?? ['bg'=>'#f1f5f9','color'=>'#64748b','label'=>'—'];
            @endphp
            <div style="display:flex; align-items:center; gap:10px; padding:8px 0; border-bottom:1px solid #f8faff;">
                <div style="width:34px; height:34px; border-radius:50%; background:#dbeafe; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:800; color:#1d4ed8; flex-shrink:0;">
                    {{ $vente->client->initiales }}
                </div>
                <div style="flex:1;">
                    <div style="font-size:14px; font-weight:700; color:#0f172a;">{{ $vente->client->nom_complet }}</div>
                    <div style="font-size:12px; color:#94a3b8;">{{ $vente->numero_facture }}</div>
                </div>
                <div style="text-align:right;">
                    <div style="font-size:14px; font-weight:800; color:#0f172a;">{{ number_format($vente->total_ttc, 0) }} MAD</div>
                    <span style="font-size:11px; font-weight:700; padding:2px 7px; border-radius:99px; background:{{ $sc['bg'] }}; color:{{ $sc['color'] }};">{{ $sc['label'] }}</span>
                </div>
            </div>
            @empty
            <div style="text-align:center; padding:24px 0; font-size:14px; color:#94a3b8;">Aucune vente</div>
            @endforelse
            <a href="{{ route('ventes.create') }}"
               style="display:block; margin-top:12px; text-align:center; padding:8px; border-radius:10px; border:1.5px dashed #bfdbfe; color:#1d4ed8; font-size:14px; font-weight:600; text-decoration:none;">
                + Nouvelle vente
            </a>
        </div>

    </div>

</x-layouts.app>
