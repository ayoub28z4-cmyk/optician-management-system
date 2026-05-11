<x-layouts.app title="Produit — OptiGest">

    <div style="max-width:90%; margin:0 auto;">

        {{-- Header --}}
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:32px;">
            <div style="display:flex; align-items:center; gap:16px;">
                <a href="{{ route('produits.index') }}"
                   style="width:44px; height:44px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f0f7ff; display:flex; align-items:center; justify-content:center; flex-shrink:0; text-decoration:none;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="2.5">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0;">{{ $produit->designation }}</h1>
                    <p style="font-size:16px; color:#94a3b8; margin:6px 0 0;">
                        Réf. <span style="font-family:monospace; font-weight:700; color:#1d4ed8;">{{ $produit->reference }}</span>
                    </p>
                </div>
            </div>
            <div style="display:flex; gap:10px;">
                <a href="{{ route('produits.edit', $produit) }}"
                   style="display:flex; align-items:center; gap:8px; padding:12px 22px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f0f7ff; color:#1d4ed8; font-size:15px; font-weight:700; text-decoration:none;">
                    Modifier
                </a>
                <form method="POST" action="{{ route('produits.destroy', $produit) }}"
                      onsubmit="return confirm('Désactiver ce produit ?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            style="padding:12px 22px; border-radius:12px; border:1.5px solid #fecaca; background:#fff5f5; color:#ef4444; font-size:15px; font-weight:700; cursor:pointer; font-family:'Plus Jakarta Sans',sans-serif;">
                        Désactiver
                    </button>
                </form>
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 360px; gap:24px; align-items:start;">

            {{-- Colonne principale --}}
            <div style="display:flex; flex-direction:column; gap:24px;">

                {{-- Infos produit --}}
                <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:28px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                    <h2 style="font-size:18px; font-weight:700; color:#0f172a; margin:0 0 20px; padding-bottom:14px; border-bottom:1.5px solid #f0f7ff;">Informations produit</h2>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                        <div>
                            <p style="font-size:14px; color:#94a3b8; font-weight:600; margin:0 0 6px;">Catégorie</p>
                            @php
                                $catColors = ['monture'=>['bg'=>'#dbeafe','color'=>'#1d4ed8'],'verre'=>['bg'=>'#dcfce7','color'=>'#16a34a'],'accessoire'=>['bg'=>'#fef9c3','color'=>'#ca8a04'],'prestation'=>['bg'=>'#f5f3ff','color'=>'#7c3aed']];
                                $cat = $catColors[$produit->categorie] ?? ['bg'=>'#f1f5f9','color'=>'#64748b'];
                            @endphp
                            <span style="font-size:14px; font-weight:700; padding:5px 14px; border-radius:99px; background:{{ $cat['bg'] }}; color:{{ $cat['color'] }};">
                                {{ $produit->categorie_label }}
                            </span>
                        </div>
                        <div>
                            <p style="font-size:14px; color:#94a3b8; font-weight:600; margin:0 0 6px;">Marque / Modèle</p>
                            <p style="font-size:17px; font-weight:700; color:#0f172a; margin:0;">{{ $produit->marque ?? '—' }} {{ $produit->modele }}</p>
                        </div>
                        <div>
                            <p style="font-size:14px; color:#94a3b8; font-weight:600; margin:0 0 6px;">Prix d'achat</p>
                            <p style="font-size:17px; font-weight:700; color:#0f172a; margin:0;">{{ number_format($produit->prix_achat, 2) }} MAD</p>
                        </div>
                        <div>
                            <p style="font-size:14px; color:#94a3b8; font-weight:600; margin:0 0 6px;">Prix de vente</p>
                            <p style="font-size:17px; font-weight:700; color:#16a34a; margin:0;">{{ number_format($produit->prix_vente, 2) }} MAD</p>
                        </div>
                        @if($produit->description)
                        <div style="grid-column:1/-1;">
                            <p style="font-size:14px; color:#94a3b8; font-weight:600; margin:0 0 6px;">Description</p>
                            <p style="font-size:16px; color:#334155; margin:0; line-height:1.7;">{{ $produit->description }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Mouvement de stock --}}
                <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:28px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                    <h2 style="font-size:18px; font-weight:700; color:#0f172a; margin:0 0 20px; padding-bottom:14px; border-bottom:1.5px solid #f0f7ff;">Mouvement de stock</h2>
                    <form method="POST" action="{{ route('produits.mouvement', $produit) }}"
                          style="display:grid; grid-template-columns:1fr 1fr 1fr auto; gap:12px; align-items:end;">
                        @csrf
                        <div>
                            <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Type</label>
                            <select name="type"
                                    style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; font-family:'Plus Jakarta Sans',sans-serif;">
                                <option value="entree">Entrée</option>
                                <option value="sortie">Sortie</option>
                            </select>
                        </div>
                        <div>
                            <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Quantité</label>
                            <input type="number" name="quantite" min="1" value="1"
                                   style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                        </div>
                        <div>
                            <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Motif</label>
                            <input type="text" name="motif" placeholder="Ex: Livraison fournisseur"
                                   style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                        </div>
                        <button type="submit"
                                style="height:50px; padding:0 20px; border-radius:12px; background:#1d4ed8; border:none; color:#fff; font-size:15px; font-weight:700; cursor:pointer; white-space:nowrap; font-family:'Plus Jakarta Sans',sans-serif; box-shadow:0 3px 10px rgba(29,78,216,0.3);">
                            Enregistrer
                        </button>
                    </form>
                </div>

                {{-- Historique mouvements --}}
                <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:28px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                    <h2 style="font-size:18px; font-weight:700; color:#0f172a; margin:0 0 20px; padding-bottom:14px; border-bottom:1.5px solid #f0f7ff;">Historique des mouvements</h2>
                    @forelse($mouvements as $mouvement)
                    <div style="display:flex; align-items:center; gap:14px; padding:12px 0; border-bottom:1px solid #f1f5f9;">
                        <div style="width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;
                                    {{ $mouvement->type === 'entree' ? 'background:#dcfce7;' : ($mouvement->type === 'sortie' ? 'background:#fee2e2;' : 'background:#fef9c3;') }}">
                            @if($mouvement->type === 'entree')
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>
                            @elseif($mouvement->type === 'sortie')
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.5"><line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/></svg>
                            @else
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#ca8a04" stroke-width="2.5"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            @endif
                        </div>
                        <div style="flex:1;">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <span style="font-size:15px; font-weight:700; color:{{ $mouvement->type === 'entree' ? '#16a34a' : ($mouvement->type === 'sortie' ? '#ef4444' : '#ca8a04') }};">
                                    {{ $mouvement->type === 'entree' ? '+' : ($mouvement->type === 'sortie' ? '-' : '~') }}{{ $mouvement->quantite }}
                                </span>
                                <span style="font-size:14px; color:#334155; font-weight:600;">{{ ucfirst($mouvement->type) }}</span>
                                @if($mouvement->motif)
                                <span style="font-size:13px; color:#94a3b8;">— {{ $mouvement->motif }}</span>
                                @endif
                            </div>
                            <div style="font-size:13px; color:#94a3b8; margin-top:2px;">
                                {{ $mouvement->stock_avant }} → {{ $mouvement->stock_apres }} — par {{ $mouvement->user->name }} — {{ $mouvement->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    </div>
                    @empty
                    <p style="font-size:15px; color:#94a3b8; text-align:center; padding:20px 0;">Aucun mouvement enregistré</p>
                    @endforelse

                    @if($mouvements->hasPages())
                    <div style="margin-top:16px;">{{ $mouvements->links() }}</div>
                    @endif
                </div>

            </div>

            {{-- Colonne droite --}}
            <div style="display:flex; flex-direction:column; gap:20px; position:sticky; top:16px;">

                {{-- Stock actuel --}}
                <div style="border-radius:18px; padding:24px; text-align:center;
                             {{ $produit->stock_faible ? 'background:linear-gradient(135deg,#fff5f5,#fee2e2); border:2px solid #fecaca;' : 'background:linear-gradient(135deg,#f0fdf4,#dcfce7); border:2px solid #bbf7d0;' }}
                             box-shadow:0 4px 20px rgba(0,0,0,0.07);">
                    <p style="font-size:14px; font-weight:600; color:#94a3b8; margin:0 0 10px;">Stock actuel</p>
                    <p style="font-size:52px; font-weight:800; margin:0; line-height:1;
                               color:{{ $produit->stock_faible ? '#ef4444' : '#16a34a' }};">
                        {{ $produit->quantite_stock }}
                    </p>
                    <p style="font-size:14px; color:#94a3b8; margin:10px 0 0;">
                        Seuil d'alerte : {{ $produit->seuil_alerte }}
                    </p>
                    @if($produit->stock_faible)
                    <span style="display:inline-block; margin-top:12px; background:#fee2e2; color:#ef4444; font-size:13px; font-weight:700; padding:5px 16px; border-radius:99px;">
                        Stock faible
                    </span>
                    @endif
                </div>

                {{-- Marge --}}
                <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:22px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                    <h3 style="font-size:16px; font-weight:700; color:#0f172a; margin:0 0 16px; padding-bottom:12px; border-bottom:1px solid #f0f7ff;">Analyse prix</h3>
                    <div style="display:flex; flex-direction:column; gap:12px;">
                        <div style="display:flex; justify-content:space-between;">
                            <span style="font-size:15px; color:#64748b;">Prix achat</span>
                            <span style="font-size:15px; font-weight:700; color:#0f172a;">{{ number_format($produit->prix_achat, 2) }} MAD</span>
                        </div>
                        <div style="display:flex; justify-content:space-between;">
                            <span style="font-size:15px; color:#64748b;">Prix vente</span>
                            <span style="font-size:15px; font-weight:700; color:#16a34a;">{{ number_format($produit->prix_vente, 2) }} MAD</span>
                        </div>
                        <div style="border-top:1px solid #f0f7ff; padding-top:12px; display:flex; justify-content:space-between;">
                            <span style="font-size:15px; font-weight:700; color:#64748b;">Marge</span>
                            <span style="font-size:16px; font-weight:800; color:#1d4ed8;">
                                {{ number_format($produit->prix_vente - $produit->prix_achat, 2) }} MAD
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</x-layouts.app>
