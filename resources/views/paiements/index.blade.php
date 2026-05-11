<x-layouts.app title="Paiements — OptiGest">

    <div style="max-width:90%; margin:0 auto;">

        {{-- Header --}}
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:32px;">
            <div>
                <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0;">Paiements</h1>
                <p style="font-size:16px; color:#94a3b8; margin:6px 0 0;">Historique de tous les paiements enregistrés</p>
            </div>
            <div style="display:flex; gap:12px;">
                <div style="background:#dcfce7; border:1px solid #bbf7d0; border-radius:12px; padding:10px 18px; text-align:center;">
                    <div style="font-size:20px; font-weight:800; color:#16a34a;">
                        {{ number_format(\App\Models\Paiement::sum('montant'), 0) }} MAD
                    </div>
                    <div style="font-size:13px; color:#16a34a; font-weight:600;">Total encaissé</div>
                </div>
                <div style="background:#fee2e2; border:1px solid #fecaca; border-radius:12px; padding:10px 18px; text-align:center;">
                    <div style="font-size:20px; font-weight:800; color:#ef4444;">
                        {{ number_format(\App\Models\Vente::where('statut_paiement','!=','solde')->sum(\Illuminate\Support\Facades\DB::raw('total_ttc - (SELECT COALESCE(SUM(montant),0) FROM paiements WHERE paiements.vente_id = ventes.id)')), 0) }} MAD
                    </div>
                    <div style="font-size:13px; color:#ef4444; font-weight:600;">Reste à encaisser</div>
                </div>
            </div>
        </div>

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
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Date</th>
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Client</th>
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Facture</th>
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Mode</th>
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Référence</th>
                        <th style="text-align:right; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Montant</th>
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Statut vente</th>
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($paiements as $paiement)
                    @php
                        $modeColors = [
                            'especes'  => ['bg'=>'#dcfce7','color'=>'#16a34a','label'=>'Espèces'],
                            'cheque'   => ['bg'=>'#dbeafe','color'=>'#1d4ed8','label'=>'Chèque'],
                            'virement' => ['bg'=>'#f5f3ff','color'=>'#7c3aed','label'=>'Virement'],
                            'carte'    => ['bg'=>'#fef9c3','color'=>'#ca8a04','label'=>'Carte'],
                        ];
                        $mc = $modeColors[$paiement->mode_paiement] ?? ['bg'=>'#f1f5f9','color'=>'#64748b','label'=>'—'];

                        $statutColors = [
                            'non_paye' => ['bg'=>'#fee2e2','color'=>'#ef4444','label'=>'Non payé'],
                            'partiel'  => ['bg'=>'#fef9c3','color'=>'#ca8a04','label'=>'Partiel'],
                            'solde'    => ['bg'=>'#dcfce7','color'=>'#16a34a','label'=>'Soldé'],
                        ];
                        $sc = $statutColors[$paiement->vente->statut_paiement] ?? ['bg'=>'#f1f5f9','color'=>'#64748b','label'=>'—'];
                    @endphp
                    <tr style="border-bottom:1px solid #f1f5f9;"
                        onmouseover="this.style.background='#f8faff'" onmouseout="this.style.background='#fff'">

                        <td style="padding:16px 20px; font-size:15px; font-weight:600; color:#334155;">
                            {{ $paiement->date_paiement->format('d/m/Y') }}
                        </td>

                        <td style="padding:16px 20px;">
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div style="width:36px; height:36px; border-radius:50%; background:#dbeafe;
                                            display:flex; align-items:center; justify-content:center;
                                            font-size:12px; font-weight:800; color:#1d4ed8; flex-shrink:0;">
                                    {{ $paiement->vente->client->initiales }}
                                </div>
                                <div>
                                    <div style="font-size:15px; font-weight:700; color:#0f172a;">{{ $paiement->vente->client->nom_complet }}</div>
                                    <div style="font-size:13px; color:#94a3b8;">{{ $paiement->vente->client->telephone }}</div>
                                </div>
                            </div>
                        </td>

                        <td style="padding:16px 20px;">
                            <a href="{{ route('ventes.show', $paiement->vente) }}"
                               style="font-family:monospace; font-size:14px; font-weight:700; color:#1d4ed8;
                                      background:#dbeafe; padding:4px 10px; border-radius:6px; text-decoration:none;">
                                {{ $paiement->vente->numero_facture }}
                            </a>
                        </td>

                        <td style="padding:16px 20px;">
                            <span style="font-size:13px; font-weight:700; padding:4px 12px; border-radius:99px;
                                         background:{{ $mc['bg'] }}; color:{{ $mc['color'] }};">
                                {{ $mc['label'] }}
                            </span>
                        </td>

                        <td style="padding:16px 20px; font-size:14px; color:#64748b; font-family:monospace;">
                            {{ $paiement->reference ?? '—' }}
                        </td>

                        <td style="padding:16px 20px; text-align:right; font-size:17px; font-weight:800; color:#16a34a;">
                            +{{ number_format($paiement->montant, 2) }} MAD
                        </td>

                        <td style="padding:16px 20px;">
                            <span style="font-size:13px; font-weight:700; padding:4px 12px; border-radius:99px;
                                         background:{{ $sc['bg'] }}; color:{{ $sc['color'] }};">
                                {{ $sc['label'] }}
                            </span>
                        </td>

                        <td style="padding:16px 20px;">
                            <a href="{{ route('ventes.show', $paiement->vente) }}"
                               style="padding:7px 16px; border-radius:8px; border:1.5px solid #bfdbfe;
                                      color:#1d4ed8; font-size:14px; font-weight:600; text-decoration:none;
                                      background:#f0f7ff;">
                                Voir facture
                            </a>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="padding:60px 20px; text-align:center; font-size:16px; color:#94a3b8;">
                            Aucun paiement enregistré
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            @if($paiements->hasPages())
            <div style="padding:16px 20px; border-top:1px solid #f0f7ff;">
                {{ $paiements->appends(request()->query())->links() }}
            </div>
            @endif
        </div>

    </div>

</x-layouts.app>
