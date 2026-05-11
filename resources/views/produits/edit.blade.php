<x-layouts.app title="Modifier produit — OptiGest">

    <div style="max-width:80%; margin:0 auto;">

        {{-- Header --}}
        <div style="display:flex; align-items:center; gap:16px; margin-bottom:32px;">
            <a href="{{ route('produits.show', $produit) }}"
               style="width:44px; height:44px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f0f7ff; display:flex; align-items:center; justify-content:center; flex-shrink:0; text-decoration:none;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="2.5">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0;">Modifier — {{ $produit->designation }}</h1>
                <p style="font-size:16px; color:#94a3b8; margin:6px 0 0;">Réf. {{ $produit->reference }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('produits.update', $produit) }}">
            @csrf
            @method('PUT')

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">

                <div style="display:flex; flex-direction:column; gap:24px;">

                    <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:28px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                        <h2 style="font-size:18px; font-weight:700; color:#0f172a; margin:0 0 24px; padding-bottom:16px; border-bottom:1.5px solid #f0f7ff;">Informations produit</h2>
                        <div style="display:flex; flex-direction:column; gap:18px;">

                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                                <div>
                                    <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Référence <span style="color:#ef4444;">*</span></label>
                                    <input type="text" name="reference" value="{{ old('reference', $produit->reference) }}"
                                           style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:monospace;">
                                    @error('reference')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Catégorie <span style="color:#ef4444;">*</span></label>
                                    <select name="categorie"
                                            style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                                        <option value="monture" {{ old('categorie',$produit->categorie)=='monture'?'selected':'' }}>Monture</option>
                                        <option value="verre" {{ old('categorie',$produit->categorie)=='verre'?'selected':'' }}>Verre</option>
                                        <option value="accessoire" {{ old('categorie',$produit->categorie)=='accessoire'?'selected':'' }}>Accessoire</option>
                                        <option value="prestation" {{ old('categorie',$produit->categorie)=='prestation'?'selected':'' }}>Prestation</option>
                                    </select>
                                    @error('categorie')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div>
                                <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Désignation <span style="color:#ef4444;">*</span></label>
                                <input type="text" name="designation" value="{{ old('designation', $produit->designation) }}"
                                       style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                                @error('designation')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                            </div>

                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                                <div>
                                    <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Marque</label>
                                    <input type="text" name="marque" value="{{ old('marque', $produit->marque) }}"
                                           style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                                </div>
                                <div>
                                    <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Modèle</label>
                                    <input type="text" name="modele" value="{{ old('modele', $produit->modele) }}"
                                           style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                                </div>
                            </div>

                            <div>
                                <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Description</label>
                                <textarea name="description" rows="3"
                                          style="width:100%; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:14px 16px; font-size:16px; color:#0f172a; outline:none; resize:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">{{ old('description', $produit->description) }}</textarea>
                            </div>

                        </div>
                    </div>

                </div>

                <div style="display:flex; flex-direction:column; gap:24px;">

                    <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:28px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                        <h2 style="font-size:18px; font-weight:700; color:#0f172a; margin:0 0 24px; padding-bottom:16px; border-bottom:1.5px solid #f0f7ff;">Prix</h2>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                            <div>
                                <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Prix d'achat (MAD)</label>
                                <input type="number" step="0.01" name="prix_achat" value="{{ old('prix_achat', $produit->prix_achat) }}"
                                       style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                            </div>
                            <div>
                                <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Prix de vente (MAD)</label>
                                <input type="number" step="0.01" name="prix_vente" value="{{ old('prix_vente', $produit->prix_vente) }}"
                                       style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                            </div>
                        </div>
                    </div>

                    <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:28px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                        <h2 style="font-size:18px; font-weight:700; color:#0f172a; margin:0 0 24px; padding-bottom:16px; border-bottom:1.5px solid #f0f7ff;">Stock</h2>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                            <div>
                                <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Quantité en stock</label>
                                <input type="number" min="0" name="quantite_stock" value="{{ old('quantite_stock', $produit->quantite_stock) }}"
                                       style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                            </div>
                            <div>
                                <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Seuil d'alerte</label>
                                <input type="number" min="0" name="seuil_alerte" value="{{ old('seuil_alerte', $produit->seuil_alerte) }}"
                                       style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                            </div>
                        </div>
                    </div>

                    <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:22px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                        <button type="submit"
                                style="width:100%; height:52px; border-radius:12px; background:#1d4ed8; border:none; color:#fff; font-size:16px; font-weight:700; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:10px; margin-bottom:12px; box-shadow:0 4px 14px rgba(29,78,216,0.35); font-family:'Plus Jakarta Sans',sans-serif;">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                                <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                                <polyline points="17 21 17 13 7 13 7 21"/>
                                <polyline points="7 3 7 8 15 8"/>
                            </svg>
                            Enregistrer les modifications
                        </button>
                        <a href="{{ route('produits.show', $produit) }}"
                           style="display:block; height:48px; border-radius:12px; border:1.5px solid #e2e8f0; color:#64748b; font-size:16px; font-weight:600; text-align:center; line-height:48px; text-decoration:none; background:#f8fafc;">
                            Annuler
                        </a>
                    </div>

                </div>
            </div>
        </form>
    </div>

</x-layouts.app>
