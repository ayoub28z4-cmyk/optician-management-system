<x-layouts.app title="Nouveau produit — OptiGest">

    <div style="max-width:80%; margin:0 auto;">

        {{-- Header --}}
        <div style="display:flex; align-items:center; gap:16px; margin-bottom:32px;">
            <a href="{{ route('produits.index') }}"
               style="width:44px; height:44px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f0f7ff; display:flex; align-items:center; justify-content:center; flex-shrink:0; text-decoration:none;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="2.5">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0;">Nouveau produit</h1>
                <p style="font-size:16px; color:#94a3b8; margin:6px 0 0;">Ajoutez un produit au catalogue</p>
            </div>
        </div>

        <form method="POST" action="{{ route('produits.store') }}">
            @csrf

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">

                {{-- Informations produit --}}
                <div style="display:flex; flex-direction:column; gap:24px;">

                    <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:28px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                        <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px; padding-bottom:16px; border-bottom:1.5px solid #f0f7ff;">
                            <div style="width:34px; height:34px; border-radius:10px; background:#dbeafe; display:flex; align-items:center; justify-content:center;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="2.2">
                                    <path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/>
                                </svg>
                            </div>
                            <h2 style="font-size:18px; font-weight:700; color:#0f172a; margin:0;">Informations produit</h2>
                        </div>

                        <div style="display:flex; flex-direction:column; gap:18px;">

                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                                <div>
                                    <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Référence <span style="color:#ef4444;">*</span></label>
                                    <input type="text" name="reference" value="{{ old('reference') }}" placeholder="Ex: MON-001"
                                           style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:monospace;">
                                    @error('reference')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Catégorie <span style="color:#ef4444;">*</span></label>
                                    <select name="categorie"
                                            style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                                        <option value="">-- Sélectionner --</option>
                                        <option value="monture" {{ old('categorie')=='monture'?'selected':'' }}>Monture</option>
                                        <option value="verre" {{ old('categorie')=='verre'?'selected':'' }}>Verre</option>
                                        <option value="accessoire" {{ old('categorie')=='accessoire'?'selected':'' }}>Accessoire</option>
                                        <option value="prestation" {{ old('categorie')=='prestation'?'selected':'' }}>Prestation</option>
                                    </select>
                                    @error('categorie')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div>
                                <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Désignation <span style="color:#ef4444;">*</span></label>
                                <input type="text" name="designation" value="{{ old('designation') }}" placeholder="Ex: Monture Ray-Ban RB3025"
                                       style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                                @error('designation')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                            </div>

                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                                <div>
                                    <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Marque</label>
                                    <input type="text" name="marque" value="{{ old('marque') }}" placeholder="Ex: Ray-Ban"
                                           style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                                </div>
                                <div>
                                    <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Modèle</label>
                                    <input type="text" name="modele" value="{{ old('modele') }}" placeholder="Ex: RB3025"
                                           style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                                </div>
                            </div>

                            <div>
                                <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Description</label>
                                <textarea name="description" rows="3" placeholder="Description du produit..."
                                          style="width:100%; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:14px 16px; font-size:16px; color:#0f172a; outline:none; resize:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">{{ old('description') }}</textarea>
                            </div>

                        </div>
                    </div>

                </div>

                {{-- Prix + Stock --}}
                <div style="display:flex; flex-direction:column; gap:24px;">

                    {{-- Prix --}}
                    <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:28px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                        <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px; padding-bottom:16px; border-bottom:1.5px solid #f0f7ff;">
                            <div style="width:34px; height:34px; border-radius:10px; background:#dcfce7; display:flex; align-items:center; justify-content:center;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.2">
                                    <line x1="12" y1="1" x2="12" y2="23"/>
                                    <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
                                </svg>
                            </div>
                            <h2 style="font-size:18px; font-weight:700; color:#0f172a; margin:0;">Prix</h2>
                        </div>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                            <div>
                                <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Prix d'achat (MAD) <span style="color:#ef4444;">*</span></label>
                                <input type="number" step="0.01" name="prix_achat" value="{{ old('prix_achat', 0) }}"
                                       style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                                @error('prix_achat')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Prix de vente (MAD) <span style="color:#ef4444;">*</span></label>
                                <input type="number" step="0.01" name="prix_vente" value="{{ old('prix_vente', 0) }}"
                                       style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                                @error('prix_vente')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- Stock --}}
                    <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:28px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                        <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px; padding-bottom:16px; border-bottom:1.5px solid #f0f7ff;">
                            <div style="width:34px; height:34px; border-radius:10px; background:#fefce8; display:flex; align-items:center; justify-content:center;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ca8a04" stroke-width="2.2">
                                    <path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/>
                                </svg>
                            </div>
                            <h2 style="font-size:18px; font-weight:700; color:#0f172a; margin:0;">Stock initial</h2>
                        </div>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                            <div>
                                <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Quantité initiale <span style="color:#ef4444;">*</span></label>
                                <input type="number" min="0" name="quantite_stock" value="{{ old('quantite_stock', 0) }}"
                                       style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                                @error('quantite_stock')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Seuil d'alerte <span style="color:#ef4444;">*</span></label>
                                <input type="number" min="0" name="seuil_alerte" value="{{ old('seuil_alerte', 2) }}"
                                       style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                                @error('seuil_alerte')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
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
                            Enregistrer le produit
                        </button>
                        <a href="{{ route('produits.index') }}"
                           style="display:block; height:48px; border-radius:12px; border:1.5px solid #e2e8f0; color:#64748b; font-size:16px; font-weight:600; text-align:center; line-height:48px; text-decoration:none; background:#f8fafc;">
                            Annuler
                        </a>
                    </div>

                </div>
            </div>
        </form>
    </div>

</x-layouts.app>
