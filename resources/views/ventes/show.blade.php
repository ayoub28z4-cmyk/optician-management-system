<x-layouts.app title="Facture — OptiGest">

    <div style="max-width:90%; margin:0 auto;">

        {{-- Header --}}
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:32px;">
            <div style="display:flex; align-items:center; gap:16px;">
                <a href="{{ route('ventes.index') }}"
                   style="width:44px; height:44px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f0f7ff; display:flex; align-items:center; justify-content:center; flex-shrink:0; text-decoration:none;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="2.5">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0;">
                        Facture {{ $vente->numero_facture }}
                    </h1>
                    <p style="font-size:16px; color:#94a3b8; margin:6px 0 0;">
                        {{ $vente->date_vente->format('d/m/Y') }} — {{ $vente->client->nom_complet }}
                    </p>
                </div>
            </div>
            <div style="display:flex; gap:10px;">
                <a href="{{ route('ventes.print', $vente) }}" target="_blank"
                   style="display:flex; align-items:center; gap:8px; padding:12px 22px; border-radius:12px; border:1.5px solid #bbf7d0; background:#f0fdf4; color:#16a34a; font-size:15px; font-weight:700; text-decoration:none;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.5">
                        <polyline points="6 9 6 2 18 2 18 9"/>
                        <path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/>
                        <rect x="6" y="14" width="12" height="8"/>
                    </svg>
                    Imprimer
                </a>
                <a href="{{ route('ventes.edit', $vente) }}"
                   style="display:flex; align-items:center; gap:8px; padding:12px 22px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f0f7ff; color:#1d4ed8; font-size:15px; font-weight:700; text-decoration:none;">
                    Modifier
                </a>
            </div>
        </div>

        {{-- Message succès --}}
        @if(session('success'))
        <div style="margin-bottom:24px; padding:14px 18px; border-radius:12px;
                    background:#dcfce7; color:#16a34a; border:1px solid #bbf7d0;
                    font-size:15px; font-weight:600;">
            {{ session('success') }}
        </div>
        @endif

        <div style="display:grid; grid-template-columns:1fr 340px; gap:24px; align-items:start;">

            {{-- Colonne principale --}}
            <div style="display:flex; flex-direction:column; gap:24px;">

                {{-- Infos client --}}
                <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:24px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                    <div style="display:flex; align-items:center; gap:14px;">
                        <div style="width:50px; height:50px; border-radius:50%; background:#dbeafe;
                                    display:flex; align-items:center; justify-content:center;
                                    font-size:18px; font-weight:800; color:#1d4ed8; flex-shrink:0;">
                            {{ $vente->client->initiales }}
                        </div>
                        <div style="flex:1;">
                            <p style="font-size:18px; font-weight:800; color:#0f172a; margin:0;">{{ $vente->client->nom_complet }}</p>
                            <p style="font-size:15px; color:#94a3b8; margin:4px 0 0;">
                                {{ $vente->client->telephone }}
                                @if($vente->client->email) — {{ $vente->client->email }} @endif
                            </p>
                        </div>
                        <div style="display:flex; align-items:center; gap:8px; margin-top:6px;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2.2">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                            </svg>
                            <span style="font-size:14px; color:#64748b; font-weight:600;">Mutuelle :</span>
                            <span style="font-size:13px; font-weight:700; padding:3px 10px; border-radius:99px;
                                        background:{{ $vente->client->mutuelle_color['bg'] }}; color:{{ $vente->client->mutuelle_color['color'] }};">
                                {{ $vente->client->mutuelle_label }}
                            </span>
                        </div>
                        <div style="text-align:right;">
                            <p style="font-size:13px; color:#94a3b8; margin:0;">N° Registre</p>
                            <p style="font-size:20px; font-weight:800; color:#1d4ed8; font-family:monospace; margin:4px 0 0;">
                                {{ $vente->client->classement_registre ?? '—' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Lignes produits --}}
                <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; overflow:hidden; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                    <div style="padding:20px 24px; border-bottom:1.5px solid #f0f7ff;">
                        <h2 style="font-size:18px; font-weight:700; color:#0f172a; margin:0;">Détail de la vente</h2>
                    </div>
                    <table style="width:100%; border-collapse:collapse;">
                        <thead>
                            <tr style="background:#f0f7ff;">
                                <th style="text-align:left; padding:12px 20px; font-size:14px; font-weight:700; color:#64748b;">Désignation</th>
                                <th style="text-align:center; padding:12px 20px; font-size:14px; font-weight:700; color:#64748b;">Qté</th>
                                <th style="text-align:right; padding:12px 20px; font-size:14px; font-weight:700; color:#64748b;">Prix unit.</th>
                                <th style="text-align:right; padding:12px 20px; font-size:14px; font-weight:700; color:#64748b;">Remise</th>
                                <th style="text-align:right; padding:12px 20px; font-size:14px; font-weight:700; color:#64748b;">Sous-total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vente->lignes as $ligne)
                            <tr style="border-bottom:1px solid #f1f5f9;">
                                <td style="padding:14px 20px; font-size:15px; font-weight:600; color:#0f172a;">{{ $ligne->designation }}</td>
                                <td style="padding:14px 20px; font-size:15px; color:#334155; text-align:center;">{{ $ligne->quantite }}</td>
                                <td style="padding:14px 20px; font-size:15px; color:#334155; text-align:right;">{{ number_format($ligne->prix_unitaire, 2) }} MAD</td>
                                <td style="padding:14px 20px; font-size:15px; color:#334155; text-align:right;">
                                    {{ $ligne->remise_ligne > 0 ? $ligne->remise_ligne . '%' : '—' }}
                                </td>
                                <td style="padding:14px 20px; font-size:16px; font-weight:700; color:#0f172a; text-align:right;">{{ number_format($ligne->sous_total, 2) }} MAD</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr style="background:#f8fbff; border-top:1.5px solid #dbeafe;">
                                <td colspan="4" style="padding:14px 20px; font-size:16px; font-weight:700; color:#0f172a; text-align:right;">
                                    @if($vente->remise > 0) Remise globale {{ $vente->remise }}% — @endif
                                    Total TTC
                                </td>
                                <td style="padding:14px 20px; font-size:20px; font-weight:800; color:#1d4ed8; text-align:right;">
                                    {{ number_format($vente->total_ttc, 2) }} MAD
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if($vente->remarque)
                <div style="background:#fefce8; border-radius:14px; border:1px solid #fde68a; padding:16px 20px;">
                    <p style="font-size:15px; color:#92400e; margin:0;"><strong>Remarque :</strong> {{ $vente->remarque }}</p>
                </div>
                @endif

            </div>

            {{-- Colonne droite --}}
            <div style="display:flex; flex-direction:column; gap:20px; position:sticky; top:16px;">

                {{-- Statut paiement --}}
                @php
                    $statutColors = [
                        'non_paye' => ['bg'=>'#fee2e2','color'=>'#ef4444','label'=>'Non payé'],
                        'partiel'  => ['bg'=>'#fef9c3','color'=>'#ca8a04','label'=>'Partiel'],
                        'solde'    => ['bg'=>'#dcfce7','color'=>'#16a34a','label'=>'Soldé'],
                    ];
                    $s = $statutColors[$vente->statut_paiement] ?? ['bg'=>'#f1f5f9','color'=>'#64748b','label'=>'—'];
                @endphp
                <div style="border-radius:18px; padding:22px; text-align:center; background:{{ $s['bg'] }}; border:2px solid {{ $s['color'] }}20;">
                    <p style="font-size:14px; color:#94a3b8; margin:0 0 8px;">Statut paiement</p>
                    <p style="font-size:22px; font-weight:800; color:{{ $s['color'] }}; margin:0;">{{ $s['label'] }}</p>
                    <p style="font-size:28px; font-weight:800; color:#0f172a; margin:12px 0 0;">{{ number_format($vente->total_ttc, 2) }} MAD</p>
                </div>

                {{-- Infos vente --}}
                <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:22px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                    <h3 style="font-size:16px; font-weight:700; color:#0f172a; margin:0 0 16px; padding-bottom:12px; border-bottom:1px solid #f0f7ff;">Informations</h3>
                    <div style="display:flex; flex-direction:column; gap:12px;">
                        <div style="display:flex; justify-content:space-between;">
                            <span style="font-size:15px; color:#64748b;">N° Facture</span>
                            <span style="font-size:15px; font-weight:700; color:#1d4ed8; font-family:monospace;">{{ $vente->numero_facture }}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between;">
                            <span style="font-size:15px; color:#64748b;">Date</span>
                            <span style="font-size:15px; font-weight:700; color:#0f172a;">{{ $vente->date_vente->format('d/m/Y') }}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between;">
                            <span style="font-size:15px; color:#64748b;">Créée par</span>
                            <span style="font-size:15px; font-weight:700; color:#0f172a;">{{ $vente->user->name }}</span>
                        </div>
                        @if($vente->remise > 0)
                        <div style="display:flex; justify-content:space-between;">
                            <span style="font-size:15px; color:#64748b;">Remise globale</span>
                            <span style="font-size:15px; font-weight:700; color:#ca8a04;">{{ $vente->remise }}%</span>
                        </div>
                        @endif
                    </div>
                </div>
                        {{-- Enregistrer un paiement --}}
        @if($vente->statut_paiement !== 'solde')
        <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:22px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
            <h3 style="font-size:16px; font-weight:700; color:#0f172a; margin:0 0 16px; padding-bottom:12px; border-bottom:1px solid #f0f7ff;">
                Enregistrer un paiement
            </h3>
            <form method="POST" action="{{ route('ventes.paiements.store', $vente) }}">
                @csrf
                <div style="display:flex; flex-direction:column; gap:12px;">
                    <div>
                        <label style="display:block; font-size:14px; font-weight:600; color:#334155; margin-bottom:8px;">
                            Montant (MAD) <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="number" name="montant" step="0.01" min="0.01"
                            value="{{ $vente->reste_a_payer }}"
                            style="width:100%; height:48px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; font-weight:700; color:#1d4ed8; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                    </div>
                    <div>
                        <label style="display:block; font-size:14px; font-weight:600; color:#334155; margin-bottom:8px;">Mode de paiement</label>
                        <select id="modePaiementSelect" name="mode_paiement" onchange="toggleReference()"
                                style="width:100%; height:48px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:15px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                            <option value="especes">Espèces</option>
                            <option value="cheque">Chèque</option>
                            <option value="virement">Virement</option>
                            <option value="carte">Carte</option>
                        </select>
                    </div>
                    <div>
                        <label style="display:block; font-size:14px; font-weight:600; color:#334155; margin-bottom:8px;">Date</label>
                        <input type="date" name="date_paiement" value="{{ date('Y-m-d') }}"
                            style="width:100%; height:48px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:15px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                    </div>
                    <div id="referenceWrapper" style="display:none;">
                        <label id="referenceLabel" style="display:block; font-size:14px; font-weight:600; color:#334155; margin-bottom:8px;">
                            Référence <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="text" name="reference" id="referenceInput" placeholder="N° chèque, référence virement..."
                            style="width:100%; height:48px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:15px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                    </div>
                    <script>
                    function toggleReference() {
                        var mode = document.getElementById('modePaiementSelect').value;
                        var wrapper = document.getElementById('referenceWrapper');
                        var input = document.getElementById('referenceInput');
                        var needsRef = (mode === 'cheque' || mode === 'virement');
                        wrapper.style.display = needsRef ? 'block' : 'none';
                        input.required = needsRef;
                    }
                    </script>
                    <button type="submit"
                            style="width:100%; height:48px; border-radius:12px; background:#1d4ed8; border:none; color:#fff; font-size:15px; font-weight:700; cursor:pointer; font-family:'Plus Jakarta Sans',sans-serif; box-shadow:0 4px 14px rgba(29,78,216,0.35);">
                        Enregistrer le paiement
                    </button>
                </div>
            </form>
        </div>
        @endif

        {{-- Historique paiements --}}
        @if($vente->paiements->count() > 0)
        <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:22px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
            <h3 style="font-size:16px; font-weight:700; color:#0f172a; margin:0 0 16px; padding-bottom:12px; border-bottom:1px solid #f0f7ff;">
                Historique paiements
            </h3>
            <div style="display:flex; flex-direction:column; gap:10px;">
                @foreach($vente->paiements as $paiement)
                <div style="display:flex; align-items:center; justify-content:space-between; padding:10px 12px; border-radius:10px; background:#f8fbff; border:1px solid #dbeafe;">
                    <div>
                        <p style="font-size:15px; font-weight:700; color:#1d4ed8; margin:0;">{{ number_format($paiement->montant, 2) }} MAD</p>
                        <p style="font-size:13px; color:#94a3b8; margin:3px 0 0;">
                            {{ ucfirst($paiement->mode_paiement) }} — {{ $paiement->date_paiement->format('d/m/Y') }}
                            @if($paiement->reference) — {{ $paiement->reference }} @endif
                        </p>
                    </div>
                    <form method="POST" action="{{ route('ventes.paiements.destroy', [$vente, $paiement]) }}"
                        onsubmit="return confirm('Supprimer ce paiement ?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                style="width:32px; height:32px; border-radius:8px; border:1.5px solid #fecaca; background:#fff5f5; cursor:pointer; display:flex; align-items:center; justify-content:center;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.5">
                                <polyline points="3 6 5 6 21 6"/>
                                <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                            </svg>
                        </button>
                    </form>
                </div>
                @endforeach

                {{-- Résumé --}}
                <div style="padding:10px 12px; border-radius:10px; background:#f0f7ff; border:1.5px solid #bfdbfe; display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:15px; font-weight:600; color:#64748b;">Reste à payer</span>
                    <span style="font-size:18px; font-weight:800; color:{{ $vente->reste_a_payer > 0 ? '#ef4444' : '#16a34a' }};">
                        {{ number_format($vente->reste_a_payer, 2) }} MAD
                    </span>
                </div>
            </div>
        </div>
        @endif

                {{-- Lien ordonnance --}}
                @if($vente->ordonnance)
                <div style="background:#f0f7ff; border-radius:14px; border:1px solid #bfdbfe; padding:16px 18px;">
                    <p style="font-size:14px; color:#64748b; margin:0 0 6px;">Ordonnance liée</p>
                    <a href="{{ route('clients.ordonnances.show', [$vente->client, $vente->ordonnance]) }}"
                       style="font-size:15px; font-weight:700; color:#1d4ed8; text-decoration:none;">
                        Du {{ $vente->ordonnance->date_ordonnance->format('d/m/Y') }}
                        @if($vente->ordonnance->medecin) — Dr. {{ $vente->ordonnance->medecin }} @endif
                    </a>
                </div>
                @endif

            </div>
        </div>
    </div>

</x-layouts.app>
