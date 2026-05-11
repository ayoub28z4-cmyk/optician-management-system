<x-layouts.app title="Modifier article — OptiGest">

<div style="max-width:90%; margin:0 auto;">

    {{-- Header --}}
    <div style="display:flex; align-items:center; gap:16px; margin-bottom:32px;">
        <a href="{{ route('articles.index') }}"
           style="width:44px; height:44px; border-radius:12px; border:1.5px solid #bfdbfe;
                  background:#f0f7ff; display:flex; align-items:center; justify-content:center; text-decoration:none;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="2.5">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0;">Modifier l'article</h1>
            <p style="font-size:15px; color:#94a3b8; margin:6px 0 0;">
                {{ $article->societe->nom }} — {{ $article->typeArticle->nom }} — {{ $article->champ_reserve }}
            </p>
        </div>
    </div>

    <form method="POST" action="{{ route('articles.update', $article) }}">
        @csrf @method('PUT')

        <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe;
                    padding:32px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">

            {{-- Société --}}
            <div style="margin-bottom:24px;">
                <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:8px;">
                    Société / Marque <span style="color:#ef4444;">*</span>
                </label>
                <select name="societe_id" required
                        style="width:100%; height:50px; border-radius:12px; border:1.5px solid {{ $errors->has('societe_id') ? '#ef4444' : '#bfdbfe' }};
                               background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none;
                               font-family:'Plus Jakarta Sans',sans-serif;">
                    @foreach($societes as $s)
                        <option value="{{ $s->id }}" {{ old('societe_id', $article->societe_id) == $s->id ? 'selected' : '' }}>
                            {{ $s->nom }}
                        </option>
                    @endforeach
                </select>
                @error('societe_id')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
            </div>

            {{-- Type d'article --}}
            <div style="margin-bottom:24px;">
                <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:8px;">
                    Type d'article <span style="color:#ef4444;">*</span>
                </label>
                <select name="type_article_id" required
                        style="width:100%; height:50px; border-radius:12px; border:1.5px solid {{ $errors->has('type_article_id') ? '#ef4444' : '#bfdbfe' }};
                               background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none;
                               font-family:'Plus Jakarta Sans',sans-serif;">
                    @foreach($typesArticles as $t)
                        <option value="{{ $t->id }}" {{ old('type_article_id', $article->type_article_id) == $t->id ? 'selected' : '' }}>
                            {{ $t->nom }}
                        </option>
                    @endforeach
                </select>
                @error('type_article_id')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
            </div>

            {{-- Désignation --}}
            <div style="margin-bottom:24px;">
                <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:8px;">
                    Désignation <span style="color:#ef4444;">*</span>
                </label>
                <select name="designation_id" required
                        style="width:100%; height:50px; border-radius:12px; border:1.5px solid {{ $errors->has('designation_id') ? '#ef4444' : '#bfdbfe' }};
                               background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none;
                               font-family:'Plus Jakarta Sans',sans-serif;">
                    <option value="">— Sélectionner —</option>
                    @foreach($designations as $d)
                        <option value="{{ $d->id }}" {{ old('designation_id', $article->designation_id) == $d->id ? 'selected' : '' }}>
                            {{ $d->nom }}
                        </option>
                    @endforeach
                </select>
                @error('designation_id')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                <p style="font-size:13px; color:#94a3b8; margin:6px 0 0;">
                    Désignation absente ? <a href="{{ route('designations.index') }}" style="color:#1d4ed8; font-weight:600;">Gérer les désignations →</a>
                </p>
            </div>

            {{-- Prix achat actuel + Seuil alerte --}}
            <div style="display:grid; grid-template-columns:2fr 1fr; gap:20px; margin-bottom:24px;">
                <div>
                    <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:8px;">
                        Prix d'achat actuel (MAD) <span style="color:#ef4444;">*</span>
                    </label>
                    <input type="number" name="prix_achat_actuel"
                           value="{{ old('prix_achat_actuel', $article->prix_achat_actuel) }}"
                           min="0" step="0.01" required
                           style="width:100%; height:50px; border-radius:12px; border:1.5px solid {{ $errors->has('prix_achat_actuel') ? '#ef4444' : '#bfdbfe' }};
                                  background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none;
                                  font-family:'Plus Jakarta Sans',sans-serif;">
                    @error('prix_achat_actuel')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:8px;">
                        Seuil d'alerte <span style="color:#ef4444;">*</span>
                    </label>
                    <input type="number" name="seuil_alerte"
                           value="{{ old('seuil_alerte', $article->seuil_alerte) }}"
                           min="0" max="9999" required
                           style="width:100%; height:50px; border-radius:12px; border:1.5px solid {{ $errors->has('seuil_alerte') ? '#ef4444' : '#fde68a' }};
                                  background:#fefce8; padding:0 16px; font-size:16px; color:#92400e; outline:none;
                                  font-family:'Plus Jakarta Sans',sans-serif; text-align:center; font-weight:700;">
                    @error('seuil_alerte')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                </div>
            </div>
            <p style="font-size:13px; color:#94a3b8; margin:-16px 0 24px;">
                Stock actuel : <strong style="color:#0f172a;">{{ $article->quantite_stock }} unité(s)</strong>
                — Pour modifier le stock, utilisez un achat ou un retrait.
                · Le seuil déclenche une alerte dans le tableau de bord stock.
            </p>

            {{-- Actions --}}
            <div style="display:flex; gap:12px; justify-content:flex-end;">
                <a href="{{ route('articles.index') }}"
                   style="padding:12px 24px; border-radius:12px; border:1.5px solid #bfdbfe; color:#334155;
                          font-size:16px; font-weight:600; text-decoration:none; background:#f8fbff;">
                    Annuler
                </a>
                <button type="submit"
                        style="padding:12px 28px; border-radius:12px; background:#1d4ed8; color:#fff;
                               border:none; font-size:16px; font-weight:700; cursor:pointer;
                               font-family:'Plus Jakarta Sans',sans-serif; box-shadow:0 4px 12px rgba(29,78,216,0.3);">
                    Enregistrer les modifications
                </button>
            </div>

        </div>
    </form>

</div>

</x-layouts.app>
