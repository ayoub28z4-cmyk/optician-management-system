<x-layouts.app title="Dashboard Admin — OptiGest">

    {{-- Header --}}
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:28px;">
        <div>
            <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0;">Administration</h1>
            <p style="font-size:16px; color:#94a3b8; margin:6px 0 0;">Vue globale de l'activité</p>
        </div>
        <div style="font-size:15px; font-weight:600; color:#7c3aed; background:#f5f3ff; padding:10px 18px; border-radius:12px; border:1px solid #c4b5fd;">
            Admin — {{ auth()->user()->name }} 👑
        </div>
    </div>

    {{-- KPIs --}}
    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:24px;">

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
            <div style="width:36px; height:36px; border-radius:10px; background:#dcfce7; display:flex; align-items:center; justify-content:center; margin-bottom:12px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.2">
                    <line x1="12" y1="1" x2="12" y2="23"/>
                    <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
                </svg>
            </div>
            <div style="font-size:28px; font-weight:800; color:#0f172a; line-height:1;">{{ number_format($caMois, 0) }}</div>
            <div style="font-size:14px; color:#94a3b8; margin-top:6px;">CA ce mois (MAD)</div>
        </div>

        <div style="background:#fff; border-radius:16px; border:1px solid #bfdbfe; padding:20px; box-shadow:0 4px 14px rgba(29,78,216,0.08);">
            <div style="width:36px; height:36px; border-radius:10px; background:#fefce8; display:flex; align-items:center; justify-content:center; margin-bottom:12px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ca8a04" stroke-width="2.2">
                    <path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/>
                </svg>
            </div>
            <div style="font-size:28px; font-weight:800; color:{{ $stockFaible > 0 ? '#ef4444' : '#0f172a' }}; line-height:1;">{{ $stockFaible }}</div>
            <div style="font-size:14px; color:#94a3b8; margin-top:6px;">Produits stock faible</div>
        </div>

        <div style="background:#fff; border-radius:16px; border:1px solid #bfdbfe; padding:20px; box-shadow:0 4px 14px rgba(29,78,216,0.08);">
            <div style="width:36px; height:36px; border-radius:10px; background:#fee2e2; display:flex; align-items:center; justify-content:center; margin-bottom:12px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.2">
                    <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                    <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
                </svg>
            </div>
            <div style="font-size:28px; font-weight:800; color:{{ $ventesNonPayees > 0 ? '#ef4444' : '#0f172a' }}; line-height:1;">{{ $ventesNonPayees }}</div>
            <div style="font-size:14px; color:#94a3b8; margin-top:6px;">Ventes non payées</div>
        </div>

    </div>

    {{-- Stats + Dernières ventes --}}
    <div style="display:grid; grid-template-columns:300px 1fr; gap:16px; margin-bottom:16px;">

        {{-- Stats globales --}}
        <div style="display:flex; flex-direction:column; gap:16px;">

            <div style="background:linear-gradient(135deg,#1e3a8a 0%,#1d4ed8 100%); border-radius:16px; padding:22px; color:#fff; box-shadow:0 8px 24px rgba(29,78,216,0.4);">
                <div style="display:flex; align-items:center; gap:10px; margin-bottom:14px;">
                    <div style="width:32px; height:32px; border-radius:8px; background:rgba(255,255,255,0.15); display:flex; align-items:center; justify-content:center;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.2">
                            <line x1="12" y1="1" x2="12" y2="23"/>
                            <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
                        </svg>
                    </div>
                    <p style="font-size:14px; font-weight:600; color:rgba(255,255,255,0.85); margin:0;">CA Total</p>
                </div>
                <p style="font-size:32px; font-weight:800; margin:0; line-height:1; color:#fff;">{{ number_format($caTotal, 0) }}</p>
                <p style="font-size:13px; color:rgba(255,255,255,0.65); margin:8px 0 0; font-weight:500;">MAD depuis le début</p>
            </div>

            <div style="background:#fff; border-radius:16px; border:1px solid #bfdbfe; padding:20px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                <h3 style="font-size:15px; font-weight:700; color:#0f172a; margin:0 0 14px;">Accès rapides</h3>
                <div style="display:flex; flex-direction:column; gap:8px;">
                    <a href="{{ route('clients.index') }}"
                       style="padding:10px 14px; border-radius:10px; background:#f0f7ff; border:1px solid #bfdbfe; color:#1d4ed8; font-size:14px; font-weight:600; text-decoration:none; display:flex; align-items:center; justify-content:space-between;">
                        Clients <span>{{ $totalClients }} →</span>
                    </a>
                    <a href="{{ route('ventes.index') }}"
                       style="padding:10px 14px; border-radius:10px; background:#f0fdf4; border:1px solid #bbf7d0; color:#16a34a; font-size:14px; font-weight:600; text-decoration:none; display:flex; align-items:center; justify-content:space-between;">
                        Ventes <span>→</span>
                    </a>
                    <a href="{{ route('articles.index') }}"
                       style="padding:10px 14px; border-radius:10px; background:#fefce8; border:1px solid #fde68a; color:#ca8a04; font-size:14px; font-weight:600; text-decoration:none; display:flex; align-items:center; justify-content:space-between;">
                        Stock <span>{{ $stockFaible }} alertes →</span>
                    </a>
                    <a href="{{ route('rappels.index') }}"
                       style="padding:10px 14px; border-radius:10px; background:#fdf2f8; border:1px solid #fbcfe8; color:#db2777; font-size:14px; font-weight:600; text-decoration:none; display:flex; align-items:center; justify-content:space-between;">
                        Rappels <span>{{ $rappelsUrgents }} urgents →</span>
                    </a>
                    <a href="{{ route('admin.users.index') }}"
                       style="padding:10px 14px; border-radius:10px; background:#f5f3ff; border:1px solid #c4b5fd; color:#7c3aed; font-size:14px; font-weight:600; text-decoration:none; display:flex; align-items:center; justify-content:space-between;">
                        Utilisateurs <span>{{ $totalUsers }} →</span>
                    </a>
                </div>
            </div>

        </div>

        {{-- Dernières ventes --}}
        <div style="background:#fff; border-radius:16px; border:1px solid #bfdbfe; overflow:hidden; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
            <div style="padding:18px 22px; border-bottom:1px solid #f0f7ff; display:flex; align-items:center; justify-content:space-between;">
                <span style="font-size:16px; font-weight:700; color:#0f172a;">Dernières ventes</span>
                <a href="{{ route('ventes.index') }}" style="font-size:13px; color:#1d4ed8; font-weight:600; text-decoration:none;">Voir tout →</a>
            </div>
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="background:#f8fbff;">
                        <th style="text-align:left; padding:10px 20px; font-size:13px; font-weight:700; color:#64748b;">Facture</th>
                        <th style="text-align:left; padding:10px 20px; font-size:13px; font-weight:700; color:#64748b;">Client</th>
                        <th style="text-align:left; padding:10px 20px; font-size:13px; font-weight:700; color:#64748b;">Date</th>
                        <th style="text-align:right; padding:10px 20px; font-size:13px; font-weight:700; color:#64748b;">Total</th>
                        <th style="text-align:left; padding:10px 20px; font-size:13px; font-weight:700; color:#64748b;">Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dernieresVentes as $vente)
                    @php
                        $sc = [
                            'non_paye' => ['bg'=>'#fee2e2','color'=>'#ef4444','label'=>'Impayé'],
                            'partiel'  => ['bg'=>'#fef9c3','color'=>'#ca8a04','label'=>'Partiel'],
                            'solde'    => ['bg'=>'#dcfce7','color'=>'#16a34a','label'=>'Soldé'],
                        ][$vente->statut_paiement] ?? ['bg'=>'#f1f5f9','color'=>'#64748b','label'=>'—'];
                    @endphp
                    <tr style="border-bottom:1px solid #f1f5f9;"
                        onmouseover="this.style.background='#f8faff'" onmouseout="this.style.background='#fff'">
                        <td style="padding:12px 20px; font-size:14px; font-weight:700; color:#1d4ed8; font-family:monospace;">
                            <a href="{{ route('ventes.show', $vente) }}" style="color:#1d4ed8; text-decoration:none;">
                                {{ $vente->numero_facture }}
                            </a>
                        </td>
                        <td style="padding:12px 20px; font-size:14px; font-weight:600; color:#0f172a;">{{ $vente->client->nom_complet }}</td>
                        <td style="padding:12px 20px; font-size:14px; color:#64748b;">{{ $vente->date_vente->format('d/m/Y') }}</td>
                        <td style="padding:12px 20px; font-size:14px; font-weight:800; color:#0f172a; text-align:right;">{{ number_format($vente->total_ttc, 0) }} MAD</td>
                        <td style="padding:12px 20px;">
                            <span style="font-size:12px; font-weight:700; padding:3px 10px; border-radius:99px; background:{{ $sc['bg'] }}; color:{{ $sc['color'] }};">{{ $sc['label'] }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="padding:40px; text-align:center; color:#94a3b8;">Aucune vente</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    {{-- Graphique répartition mutuelle — pleine largeur --}}
    <div style="background:#fff; border-radius:16px; border:1px solid #bfdbfe; padding:28px;
                box-shadow:0 4px 14px rgba(29,78,216,0.07);">

        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; padding-bottom:14px; border-bottom:1px solid #f0f7ff;">
            <div>
                <h3 style="font-size:18px; font-weight:700; color:#0f172a; margin:0;">Répartition par mutuelle</h3>
                <p style="font-size:14px; color:#94a3b8; margin:4px 0 0;">Distribution des {{ $totalClients }} clients actifs</p>
            </div>
            <a href="{{ route('clients.index') }}"
               style="font-size:13px; color:#1d4ed8; font-weight:600; text-decoration:none;">
                Voir clients →
            </a>
        </div>

        @php
            $mutuelles = [
                'cnops'  => ['label'=>'CNOPS', 'bg'=>'#dbeafe', 'color'=>'#1d4ed8', 'bar'=>'#1d4ed8'],
                'cnss'   => ['label'=>'CNSS',  'bg'=>'#dcfce7', 'color'=>'#16a34a', 'bar'=>'#16a34a'],
                'autre'  => ['label'=>'Autre', 'bg'=>'#fef9c3', 'color'=>'#ca8a04', 'bar'=>'#ca8a04'],
                'aucune' => ['label'=>'Aucune','bg'=>'#f1f5f9', 'color'=>'#64748b', 'bar'=>'#94a3b8'],
            ];
            $total = $repartitionMutuelle->sum();
            $circumference = 2 * M_PI * 45;
            $pCnops  = $total > 0 ? ($repartitionMutuelle['cnops']  ?? 0) / $total * $circumference : 0;
            $pCnss   = $total > 0 ? ($repartitionMutuelle['cnss']   ?? 0) / $total * $circumference : 0;
            $pAutre  = $total > 0 ? ($repartitionMutuelle['autre']  ?? 0) / $total * $circumference : 0;
            $pAucune = $total > 0 ? ($repartitionMutuelle['aucune'] ?? 0) / $total * $circumference : 0;
            $offsetCnops  = 0;
            $offsetCnss   = $pCnops;
            $offsetAutre  = $pCnops + $pCnss;
            $offsetAucune = $pCnops + $pCnss + $pAutre;
        @endphp

        <div style="display:grid; grid-template-columns:1fr 300px; gap:48px; align-items:center;">

            {{-- Barres --}}
            <div style="display:flex; flex-direction:column; gap:20px;">
                @foreach($mutuelles as $key => $m)
                @php
                    $count   = $repartitionMutuelle[$key] ?? 0;
                    $percent = $total > 0 ? round($count / $total * 100) : 0;
                @endphp
                <div>
                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
                        <div style="display:flex; align-items:center; gap:10px;">
                            <span style="font-size:14px; font-weight:700; padding:4px 14px; border-radius:99px;
                                         background:{{ $m['bg'] }}; color:{{ $m['color'] }};">
                                {{ $m['label'] }}
                            </span>
                            <span style="font-size:15px; font-weight:600; color:#0f172a;">{{ $count }} client(s)</span>
                        </div>
                        <span style="font-size:16px; font-weight:800; color:{{ $m['color'] }};">{{ $percent }}%</span>
                    </div>
                    <div style="height:14px; background:#f1f5f9; border-radius:99px; overflow:hidden;">
                        <div style="height:100%; border-radius:99px; width:{{ max($percent, $count > 0 ? 2 : 0) }}%;
                                    background:{{ $m['bar'] }};"></div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Donut SVG --}}
            <div style="display:flex; flex-direction:column; align-items:center; gap:20px;">
                <svg width="240" height="240" viewBox="0 0 120 120">
                    @if($total > 0)
                        @if($pCnops > 0)
                        <circle cx="60" cy="60" r="45" fill="none" stroke="#1d4ed8" stroke-width="16"
                                stroke-dasharray="{{ $pCnops }} {{ $circumference - $pCnops }}"
                                stroke-dashoffset="{{ -$offsetCnops }}"
                                transform="rotate(-90 60 60)"/>
                        @endif
                        @if($pCnss > 0)
                        <circle cx="60" cy="60" r="45" fill="none" stroke="#16a34a" stroke-width="16"
                                stroke-dasharray="{{ $pCnss }} {{ $circumference - $pCnss }}"
                                stroke-dashoffset="{{ -$offsetCnss }}"
                                transform="rotate(-90 60 60)"/>
                        @endif
                        @if($pAutre > 0)
                        <circle cx="60" cy="60" r="45" fill="none" stroke="#ca8a04" stroke-width="16"
                                stroke-dasharray="{{ $pAutre }} {{ $circumference - $pAutre }}"
                                stroke-dashoffset="{{ -$offsetAutre }}"
                                transform="rotate(-90 60 60)"/>
                        @endif
                        @if($pAucune > 0)
                        <circle cx="60" cy="60" r="45" fill="none" stroke="#94a3b8" stroke-width="16"
                                stroke-dasharray="{{ $pAucune }} {{ $circumference - $pAucune }}"
                                stroke-dashoffset="{{ -$offsetAucune }}"
                                transform="rotate(-90 60 60)"/>
                        @endif
                    @else
                        <circle cx="60" cy="60" r="45" fill="none" stroke="#e2e8f0" stroke-width="16"/>
                    @endif
                    <circle cx="60" cy="60" r="34" fill="white"/>
                    <text x="60" y="56" text-anchor="middle"
                          style="font-size:16px; font-weight:800; fill:#0f172a; font-family:'Plus Jakarta Sans',sans-serif;">
                        {{ $total }}
                    </text>
                    <text x="60" y="70" text-anchor="middle"
                          style="font-size:9px; fill:#94a3b8; font-family:'Plus Jakarta Sans',sans-serif;">
                        clients
                    </text>
                </svg>

                {{-- Légende --}}
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; width:100%;">
                    @foreach($mutuelles as $key => $m)
                    @php $count = $repartitionMutuelle[$key] ?? 0; @endphp
                    <div style="display:flex; align-items:center; gap:8px;">
                        <div style="width:12px; height:12px; border-radius:50%; background:{{ $m['bar'] }}; flex-shrink:0;"></div>
                        <span style="font-size:13px; color:#64748b; font-weight:600;">{{ $m['label'] }} ({{ $count }})</span>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

</x-layouts.app>
