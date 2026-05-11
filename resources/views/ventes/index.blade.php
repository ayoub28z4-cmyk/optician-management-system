<x-layouts.app title="Ventes — OptiGest">

    <div style="max-width:90%; margin:0 auto;">

        {{-- Header --}}
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:32px;">
            <div>
                <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0;">Ventes & Factures</h1>
                <p style="font-size:16px; color:#94a3b8; margin:6px 0 0;">{{ $ventes->total() }} vente(s) enregistrée(s)</p>
            </div>
            <a href="{{ route('ventes.create') }}"
               style="display:flex; align-items:center; gap:8px; padding:12px 22px; border-radius:12px;
                      background:#1d4ed8; color:#fff; font-size:15px; font-weight:700; text-decoration:none;
                      box-shadow:0 4px 14px rgba(29,78,216,0.35);">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Nouvelle vente
            </a>
        </div>

        {{-- Filtres --}}
        <form method="GET" action="{{ route('ventes.index') }}"
              style="display:flex; align-items:center; gap:12px; margin-bottom:24px; padding:16px 20px;
                     border-radius:14px; border:1px solid #bfdbfe; background:#f0f7ff;">

            <div style="display:flex; align-items:center; gap:10px; flex:1; height:48px;
                        padding:0 16px; border-radius:12px; border:1.5px solid #bfdbfe; background:#fff;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#93c5fd" stroke-width="2.5" style="flex-shrink:0;">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Rechercher par n° facture ou client..."
                       style="background:transparent; border:none; outline:none; width:100%;
                              font-size:15px; color:#334155; font-family:'Plus Jakarta Sans',sans-serif;">
            </div>

            <select name="statut"
                    style="height:48px; padding:0 16px; border-radius:12px; border:1.5px solid #bfdbfe;
                           background:#fff; font-size:15px; color:#334155; outline:none;
                           font-family:'Plus Jakarta Sans',sans-serif; min-width:180px;">
                <option value="">Tous les statuts</option>
                <option value="non_paye" {{ request('statut')=='non_paye'?'selected':'' }}>Non payé</option>
                <option value="partiel" {{ request('statut')=='partiel'?'selected':'' }}>Partiel</option>
                <option value="solde" {{ request('statut')=='solde'?'selected':'' }}>Soldé</option>
            </select>

            <button type="submit"
                    style="height:48px; padding:0 24px; border-radius:12px; border:none;
                           background:#1d4ed8; color:#fff; font-size:15px; font-weight:700; cursor:pointer;
                           font-family:'Plus Jakarta Sans',sans-serif;">
                Filtrer
            </button>

            @if(request('search') || request('statut'))
            <a href="{{ route('ventes.index') }}"
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
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">N° Facture</th>
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Client</th>
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Date</th>
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Total</th>
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Statut</th>
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Créé par</th>
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ventes as $vente)
                    <tr style="border-bottom:1px solid #f1f5f9;"
                        onmouseover="this.style.background='#f8faff'" onmouseout="this.style.background='#fff'">

                        <td style="padding:16px 20px;">
                            <span style="font-family:monospace; font-size:14px; font-weight:700; color:#1d4ed8;
                                         background:#dbeafe; padding:4px 10px; border-radius:6px;">
                                {{ $vente->numero_facture }}
                            </span>
                        </td>

                        <td style="padding:16px 20px;">
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div style="width:36px; height:36px; border-radius:50%; background:#dbeafe;
                                            display:flex; align-items:center; justify-content:center;
                                            font-size:13px; font-weight:800; color:#1d4ed8; flex-shrink:0;">
                                    {{ $vente->client->initiales }}
                                </div>
                                <div>
                                    <div style="font-size:15px; font-weight:700; color:#0f172a;">{{ $vente->client->nom_complet }}</div>
                                    <div style="font-size:13px; color:#94a3b8;">{{ $vente->client->telephone }}</div>
                                </div>
                            </div>
                        </td>

                        <td style="padding:16px 20px; font-size:15px; color:#334155; font-weight:600;">
                            {{ $vente->date_vente->format('d/m/Y') }}
                        </td>

                        <td style="padding:16px 20px; font-size:16px; font-weight:800; color:#0f172a;">
                            {{ number_format($vente->total_ttc, 2) }} MAD
                        </td>

                        <td style="padding:16px 20px;">
                            @php
                                $statutColors = [
                                    'non_paye' => ['bg'=>'#fee2e2','color'=>'#ef4444','label'=>'Non payé'],
                                    'partiel'  => ['bg'=>'#fef9c3','color'=>'#ca8a04','label'=>'Partiel'],
                                    'solde'    => ['bg'=>'#dcfce7','color'=>'#16a34a','label'=>'Soldé'],
                                ];
                                $s = $statutColors[$vente->statut_paiement] ?? ['bg'=>'#f1f5f9','color'=>'#64748b','label'=>'—'];
                            @endphp
                            <span style="font-size:13px; font-weight:700; padding:5px 14px; border-radius:99px;
                                         background:{{ $s['bg'] }}; color:{{ $s['color'] }};">
                                {{ $s['label'] }}
                            </span>
                        </td>

                        <td style="padding:16px 20px;">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <div style="width:28px; height:28px; border-radius:50%; background:#f1f5f9;
                                            display:flex; align-items:center; justify-content:center;
                                            font-size:11px; font-weight:800; color:#64748b; flex-shrink:0;">
                                    {{ strtoupper(substr($vente->user->name ?? '?', 0, 2)) }}
                                </div>
                                <span style="font-size:14px; color:#64748b; font-weight:600;">{{ $vente->user->name ?? '—' }}</span>
                            </div>
                        </td>

                        <td style="padding:16px 20px;">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <a href="{{ route('ventes.show', $vente) }}"
                                   style="padding:7px 16px; border-radius:8px; border:1.5px solid #bfdbfe;
                                          color:#1d4ed8; font-size:14px; font-weight:600; text-decoration:none;
                                          background:#f0f7ff;">
                                    Voir
                                </a>
                                <a href="{{ route('ventes.print', $vente) }}" target="_blank"
                                   style="padding:7px 16px; border-radius:8px; border:1.5px solid #bbf7d0;
                                          color:#16a34a; font-size:14px; font-weight:600; text-decoration:none;
                                          background:#f0fdf4;">
                                    Imprimer
                                </a>
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="padding:60px 20px; text-align:center; font-size:16px; color:#94a3b8;">
                            Aucune vente trouvée
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            @if($ventes->hasPages())
            <div style="padding:16px 20px; border-top:1px solid #f0f7ff;">
                {{ $ventes->appends(request()->query())->links() }}
            </div>
            @endif
        </div>

    </div>

</x-layouts.app>
