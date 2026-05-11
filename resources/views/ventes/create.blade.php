<x-layouts.app title="Nouvelle vente — OptiGest">

    <div style="max-width:90%; margin:0 auto;">

        {{-- Header --}}
        <div style="display:flex; align-items:center; gap:16px; margin-bottom:32px;">
            <a href="{{ route('ventes.index') }}"
               style="width:44px; height:44px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f0f7ff; display:flex; align-items:center; justify-content:center; flex-shrink:0; text-decoration:none;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="2.5">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0;">Nouvelle vente</h1>
                <p style="font-size:16px; color:#94a3b8; margin:6px 0 0;">Créez une vente et générez la facture</p>
            </div>
        </div>

        <form method="POST" action="{{ route('ventes.store') }}" id="form-vente">
            @csrf

            <div style="display:grid; grid-template-columns:1fr 360px; gap:24px; align-items:start;">

                {{-- Colonne principale --}}
                <div style="display:flex; flex-direction:column; gap:24px;">

                    {{-- Client + Ordonnance --}}
                    <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:28px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                        <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px; padding-bottom:16px; border-bottom:1.5px solid #f0f7ff;">
                            <div style="width:34px; height:34px; border-radius:10px; background:#dbeafe; display:flex; align-items:center; justify-content:center;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="2.2">
                                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>
                                </svg>
                            </div>
                            <h2 style="font-size:18px; font-weight:700; color:#0f172a; margin:0;">Client</h2>
                        </div>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                            <div>
                                <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Client <span style="color:#ef4444;">*</span></label>
                                <select name="client_id" id="client-select" onchange="chargerOrdonnances(this.value)"
                                        style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                                    <option value="">-- Sélectionner un client --</option>
                                    @foreach($clients as $c)
                                    <option value="{{ $c->id }}" {{ (old('client_id') == $c->id || ($client && $client->id == $c->id)) ? 'selected' : '' }}>
                                        {{ $c->nom_complet }} — {{ $c->classement_registre ?? 'N/A' }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('client_id')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Ordonnance liée</label>
                                <select name="ordonnance_id" id="ordonnance-select"
                                        style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                                    <option value="">-- Aucune ordonnance --</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Lignes produits --}}
                    <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:28px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; padding-bottom:16px; border-bottom:1.5px solid #f0f7ff;">
                            <div style="display:flex; align-items:center; gap:12px;">
                                <div style="width:34px; height:34px; border-radius:10px; background:#dcfce7; display:flex; align-items:center; justify-content:center;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.2">
                                        <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                                        <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
                                    </svg>
                                </div>
                                <h2 style="font-size:18px; font-weight:700; color:#0f172a; margin:0;">Lignes de produits</h2>
                            </div>
                            <button type="button" onclick="ajouterLigne()"
                                    style="display:flex; align-items:center; gap:6px; padding:8px 16px; border-radius:10px;
                                           background:#f0f7ff; border:1.5px solid #bfdbfe; color:#1d4ed8;
                                           font-size:14px; font-weight:700; cursor:pointer; font-family:'Plus Jakarta Sans',sans-serif;">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="2.5">
                                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                                </svg>
                                Ajouter ligne
                            </button>
                        </div>

                        {{-- En-tête tableau --}}
                        <div style="display:grid; grid-template-columns:2fr 1fr 1fr 1fr 40px; gap:10px; margin-bottom:10px; padding:0 4px;">
                            <span style="font-size:13px; font-weight:700; color:#64748b;">Désignation</span>
                            <span style="font-size:13px; font-weight:700; color:#64748b;">Qté</span>
                            <span style="font-size:13px; font-weight:700; color:#64748b;">Prix unitaire</span>
                            <span style="font-size:13px; font-weight:700; color:#64748b;">Remise %</span>
                            <span></span>
                        </div>

                        <div id="lignes-container">
                            {{-- Ligne initiale --}}
                            <div class="ligne-vente" style="display:grid; grid-template-columns:2fr 1fr 1fr 1fr 40px; gap:10px; margin-bottom:10px;">
                                <div>
                                    <select name="lignes[0][produit_id]" onchange="remplirProduit(this, 0)"
                                            style="width:100%; height:46px; border-radius:10px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 12px; font-size:15px; color:#0f172a; outline:none; font-family:'Plus Jakarta Sans',sans-serif; margin-bottom:6px;">
                                        <option value="">-- Produit libre --</option>
                                        @foreach($produits as $p)
                                        <option value="{{ $p->id }}" data-prix="{{ $p->prix_achat_actuel }}" data-designation="{{ $p->societe->nom }} — {{ $p->typeArticle->nom }} — {{ $p->designation->nom }}">
                                            {{ $p->societe->nom }} / {{ $p->typeArticle->nom }} — {{ $p->designation->nom }} (stock: {{ $p->quantite_stock }})
                                        </option>
                                        @endforeach
                                    </select>
                                    <input type="text" name="lignes[0][designation]" placeholder="Désignation..."
                                           style="width:100%; height:46px; border-radius:10px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 12px; font-size:15px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                                </div>
                                <input type="number" name="lignes[0][quantite]" value="1" min="1" onchange="calculerTotal()"
                                       style="height:46px; border-radius:10px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 12px; font-size:15px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                                <input type="number" name="lignes[0][prix_unitaire]" value="0" step="0.01" onchange="calculerTotal()"
                                       style="height:46px; border-radius:10px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 12px; font-size:15px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                                <input type="number" name="lignes[0][remise_ligne]" value="0" min="0" max="100" onchange="calculerTotal()"
                                       style="height:46px; border-radius:10px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 12px; font-size:15px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                                <button type="button" onclick="supprimerLigne(this)"
                                        style="height:46px; width:40px; border-radius:10px; border:1.5px solid #fecaca; background:#fff5f5; color:#ef4444; cursor:pointer; display:flex; align-items:center; justify-content:center;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.5">
                                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        @error('lignes')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror

                    </div>

                    {{-- Remarque --}}
                    <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:28px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                        <h2 style="font-size:18px; font-weight:700; color:#0f172a; margin:0 0 16px;">Remarque</h2>
                        <textarea name="remarque" rows="3" placeholder="Remarque commerciale..."
                                  style="width:100%; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:14px 16px; font-size:16px; color:#0f172a; outline:none; resize:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">{{ old('remarque') }}</textarea>
                    </div>

                </div>

                {{-- Colonne droite — Récapitulatif --}}
                <div style="display:flex; flex-direction:column; gap:20px; position:sticky; top:16px;">

                    {{-- Date --}}
                    <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:22px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                        <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Date de vente <span style="color:#ef4444;">*</span></label>
                        <input type="date" name="date_vente" value="{{ old('date_vente', date('Y-m-d')) }}"
                               style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                    </div>

                    {{-- Totaux --}}
                    <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:22px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                        <h3 style="font-size:16px; font-weight:700; color:#0f172a; margin:0 0 16px; padding-bottom:12px; border-bottom:1px solid #f0f7ff;">Récapitulatif</h3>

                        <div style="display:flex; flex-direction:column; gap:12px; margin-bottom:16px;">
                            <div style="display:flex; justify-content:space-between;">
                                <span style="font-size:15px; color:#64748b;">Sous-total HT</span>
                                <span id="sous-total" style="font-size:15px; font-weight:700; color:#0f172a;">0.00 MAD</span>
                            </div>
                            <div style="display:flex; align-items:center; justify-content:space-between; gap:10px;">
                                <span style="font-size:15px; color:#64748b;">Remise globale %</span>
                                <input type="number" name="remise" id="remise-global" value="{{ old('remise', 0) }}"
                                       min="0" max="100" step="0.01" onchange="calculerTotal()"
                                       style="width:80px; height:36px; border-radius:8px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 10px; font-size:15px; color:#0f172a; outline:none; text-align:center; font-family:'Plus Jakarta Sans',sans-serif;">
                            </div>
                            <div style="border-top:1.5px solid #f0f7ff; padding-top:12px; display:flex; justify-content:space-between;">
                                <span style="font-size:17px; font-weight:700; color:#0f172a;">Total TTC</span>
                                <span id="total-ttc" style="font-size:20px; font-weight:800; color:#1d4ed8;">0.00 MAD</span>
                            </div>
                        </div>
                    </div>

                    {{-- Boutons --}}
                    <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:22px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                        <button type="submit"
                                style="width:100%; height:52px; border-radius:12px; background:#1d4ed8; border:none; color:#fff; font-size:16px; font-weight:700; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:10px; margin-bottom:12px; box-shadow:0 4px 14px rgba(29,78,216,0.35); font-family:'Plus Jakarta Sans',sans-serif;">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                                <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                                <polyline points="17 21 17 13 7 13 7 21"/>
                                <polyline points="7 3 7 8 15 8"/>
                            </svg>
                            Enregistrer la vente
                        </button>
                        <a href="{{ route('ventes.index') }}"
                           style="display:block; height:48px; border-radius:12px; border:1.5px solid #e2e8f0; color:#64748b; font-size:16px; font-weight:600; text-align:center; line-height:48px; text-decoration:none; background:#f8fafc;">
                            Annuler
                        </a>
                    </div>

                </div>
            </div>
        </form>
    </div>

    <script>
    let ligneIndex = 1;
    @php
        $produitsJs = $produits->map(fn($p) => [
            'id'          => $p->id,
            'designation' => $p->societe->nom . ' — ' . $p->typeArticle->nom . ' — ' . $p->designation->nom,
            'prix'        => $p->prix_achat_actuel,
            'stock'       => $p->quantite_stock,
        ]);
    @endphp
    const produits = @json($produitsJs);

    function ajouterLigne() {
        const i = ligneIndex++;
        const container = document.getElementById('lignes-container');
        const div = document.createElement('div');
        div.className = 'ligne-vente';
        div.style.cssText = 'display:grid; grid-template-columns:2fr 1fr 1fr 1fr 40px; gap:10px; margin-bottom:10px;';
        div.innerHTML = `
            <div>
                <select name="lignes[${i}][produit_id]" onchange="remplirProduit(this, ${i})"
                        style="width:100%; height:46px; border-radius:10px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 12px; font-size:15px; color:#0f172a; outline:none; font-family:'Plus Jakarta Sans',sans-serif; margin-bottom:6px;">
                    <option value="">-- Produit libre --</option>
                    ${produits.map(p => `<option value="${p.id}" data-prix="${p.prix}" data-designation="${p.designation}">${p.designation} (stock: ${p.stock})</option>`).join('')}
                </select>
                <input type="text" name="lignes[${i}][designation]" placeholder="Désignation..."
                       style="width:100%; height:46px; border-radius:10px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 12px; font-size:15px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
            </div>
            <input type="number" name="lignes[${i}][quantite]" value="1" min="1" onchange="calculerTotal()"
                   style="height:46px; border-radius:10px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 12px; font-size:15px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
            <input type="number" name="lignes[${i}][prix_unitaire]" value="0" step="0.01" onchange="calculerTotal()"
                   style="height:46px; border-radius:10px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 12px; font-size:15px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
            <input type="number" name="lignes[${i}][remise_ligne]" value="0" min="0" max="100" onchange="calculerTotal()"
                   style="height:46px; border-radius:10px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 12px; font-size:15px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
            <button type="button" onclick="supprimerLigne(this)"
                    style="height:46px; width:40px; border-radius:10px; border:1.5px solid #fecaca; background:#fff5f5; color:#ef4444; cursor:pointer; display:flex; align-items:center; justify-content:center;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.5">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        `;
        container.appendChild(div);
    }

    function supprimerLigne(btn) {
        const lignes = document.querySelectorAll('.ligne-vente');
        if (lignes.length > 1) {
            btn.closest('.ligne-vente').remove();
            calculerTotal();
        }
    }

    function remplirProduit(select, index) {
        const option = select.options[select.selectedIndex];
        const ligne = select.closest('.ligne-vente');
        if (option.value) {
            ligne.querySelector('input[name$="[designation]"]').value = option.dataset.designation;
            ligne.querySelector('input[name$="[prix_unitaire]"]').value = parseFloat(option.dataset.prix).toFixed(2);
        }
        calculerTotal();
    }

    function calculerTotal() {
        let totalHt = 0;
        document.querySelectorAll('.ligne-vente').forEach(ligne => {
            const qte   = parseFloat(ligne.querySelector('input[name$="[quantite]"]')?.value) || 0;
            const prix  = parseFloat(ligne.querySelector('input[name$="[prix_unitaire]"]')?.value) || 0;
            const remise = parseFloat(ligne.querySelector('input[name$="[remise_ligne]"]')?.value) || 0;
            const sous  = qte * prix * (1 - remise / 100);
            totalHt += sous;
        });
        const remiseGlobal = parseFloat(document.getElementById('remise-global')?.value) || 0;
        const totalTtc = totalHt * (1 - remiseGlobal / 100);
        document.getElementById('sous-total').textContent = totalHt.toFixed(2) + ' MAD';
        document.getElementById('total-ttc').textContent  = totalTtc.toFixed(2) + ' MAD';
    }

    function chargerOrdonnances(clientId) {
        const select = document.getElementById('ordonnance-select');
        select.innerHTML = '<option value="">-- Aucune ordonnance --</option>';
        if (!clientId) return;
        fetch(`/api/clients/${clientId}/ordonnances`)
            .then(r => r.json())
            .then(data => {
                data.forEach(o => {
                    const opt = document.createElement('option');
                    opt.value = o.id;
                    opt.textContent = `Ordo du ${o.date_ordonnance}${o.medecin ? ' — Dr. ' + o.medecin : ''}`;
                    select.appendChild(opt);
                });
            }).catch(() => {});
    }

    calculerTotal();
    </script>

</x-layouts.app>
