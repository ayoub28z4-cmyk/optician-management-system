<x-layouts.app title="Produits — OptiGest">

    <div style="max-width:90%; margin:0 auto;">

        {{-- Header --}}
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:32px;">
            <div>
                <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0;">Produits & Stock</h1>
                <p style="font-size:16px; color:#94a3b8; margin:6px 0 0;">{{ $produits->total() }} produit(s) actif(s)</p>
            </div>
            <a href="{{ route('produits.create') }}"
               style="display:flex; align-items:center; gap:8px; padding:12px 22px; border-radius:12px;
                      background:#1d4ed8; color:#fff; font-size:15px; font-weight:700; text-decoration:none;
                      box-shadow:0 4px 14px rgba(29,78,216,0.35);">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Nouveau produit
            </a>
        </div>

        {{-- Filtres --}}
        <form method="GET" action="{{ route('produits.index') }}"
              style="display:flex; align-items:center; gap:12px; margin-bottom:24px; padding:16px 20px;
                     border-radius:14px; border:1px solid #bfdbfe; background:#f0f7ff;">

            <div style="display:flex; align-items:center; gap:10px; flex:1; height:48px;
                        padding:0 16px; border-radius:12px; border:1.5px solid #bfdbfe; background:#fff;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#93c5fd" stroke-width="2.5" style="flex-shrink:0;">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Rechercher par désignation, référence, marque..."
                       style="background:transparent; border:none; outline:none; width:100%;
                              font-size:15px; color:#334155; font-family:'Plus Jakarta Sans',sans-serif;">
            </div>

            <select name="categorie"
                    style="height:48px; padding:0 16px; border-radius:12px; border:1.5px solid #bfdbfe;
                           background:#fff; font-size:15px; color:#334155; outline:none;
                           font-family:'Plus Jakarta Sans',sans-serif; min-width:180px;">
                <option value="">Toutes catégories</option>
                <option value="monture" {{ request('categorie')=='monture'?'selected':'' }}>Montures</option>
                <option value="verre" {{ request('categorie')=='verre'?'selected':'' }}>Verres</option>
                <option value="accessoire" {{ request('categorie')=='accessoire'?'selected':'' }}>Accessoires</option>
                <option value="prestation" {{ request('categorie')=='prestation'?'selected':'' }}>Prestations</option>
            </select>

            <label style="display:flex; align-items:center; gap:8px; height:48px; padding:0 16px;
                          border-radius:12px; border:1.5px solid #fecaca; background:#fff5f5; cursor:pointer;">
                <input type="checkbox" name="stock_faible" value="1" {{ request('stock_faible')?'checked':'' }}
                       style="width:16px; height:16px; cursor:pointer;">
                <span style="font-size:15px; color:#ef4444; font-weight:600;">Stock faible</span>
            </label>

            <button type="submit"
                    style="height:48px; padding:0 24px; border-radius:12px; border:none;
                           background:#1d4ed8; color:#fff; font-size:15px; font-weight:700; cursor:pointer;
                           font-family:'Plus Jakarta Sans',sans-serif; box-shadow:0 3px 10px rgba(29,78,216,0.3);">
                Filtrer
            </button>

            @if(request('search') || request('categorie') || request('stock_faible'))
            <a href="{{ route('produits.index') }}"
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
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Référence</th>
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Désignation</th>
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Catégorie</th>
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Prix vente</th>
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Stock</th>
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Créé par</th>
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produits as $produit)
                    <tr style="border-bottom:1px solid #f1f5f9;"
                        onmouseover="this.style.background='#f8faff'" onmouseout="this.style.background='#fff'">

                        <td style="padding:16px 20px;">
                            <span style="font-family:monospace; font-size:14px; font-weight:700; color:#1d4ed8;
                                         background:#dbeafe; padding:4px 10px; border-radius:6px;">
                                {{ $produit->reference }}
                            </span>
                        </td>

                        <td style="padding:16px 20px;">
                            <div style="font-size:15px; font-weight:700; color:#0f172a;">{{ $produit->designation }}</div>
                            @if($produit->marque)
                            <div style="font-size:13px; color:#94a3b8; margin-top:2px;">{{ $produit->marque }} {{ $produit->modele }}</div>
                            @endif
                        </td>

                        <td style="padding:16px 20px;">
                            @php
                                $catColors = [
                                    'monture'    => ['bg'=>'#dbeafe','color'=>'#1d4ed8'],
                                    'verre'      => ['bg'=>'#dcfce7','color'=>'#16a34a'],
                                    'accessoire' => ['bg'=>'#fef9c3','color'=>'#ca8a04'],
                                    'prestation' => ['bg'=>'#f5f3ff','color'=>'#7c3aed'],
                                ];
                                $cat = $catColors[$produit->categorie] ?? ['bg'=>'#f1f5f9','color'=>'#64748b'];
                            @endphp
                            <span style="font-size:13px; font-weight:700; padding:4px 12px; border-radius:99px;
                                         background:{{ $cat['bg'] }}; color:{{ $cat['color'] }};">
                                {{ $produit->categorie_label }}
                            </span>
                        </td>

                        <td style="padding:16px 20px; font-size:16px; font-weight:700; color:#0f172a;">
                            {{ number_format($produit->prix_vente, 2) }} MAD
                        </td>

                        <td style="padding:16px 20px;">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <span style="font-size:18px; font-weight:800;
                                             color:{{ $produit->stock_faible ? '#ef4444' : '#16a34a' }};">
                                    {{ $produit->quantite_stock }}
                                </span>
                                @if($produit->stock_faible)
                                <span style="font-size:11px; font-weight:700; padding:3px 8px; border-radius:99px;
                                             background:#fee2e2; color:#ef4444;">
                                    Faible
                                </span>
                                @endif
                            </div>
                        </td>

                        <td style="padding:16px 20px;">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <div style="width:28px; height:28px; border-radius:50%; background:#f1f5f9;
                                            display:flex; align-items:center; justify-content:center;
                                            font-size:11px; font-weight:800; color:#64748b; flex-shrink:0;">
                                    {{ strtoupper(substr($produit->user->name ?? '?', 0, 2)) }}
                                </div>
                                <span style="font-size:14px; color:#64748b; font-weight:600;">{{ $produit->user->name ?? '—' }}</span>
                            </div>
                        </td>

                        <td style="padding:16px 20px;">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <a href="{{ route('produits.show', $produit) }}"
                                   style="padding:7px 16px; border-radius:8px; border:1.5px solid #bfdbfe;
                                          color:#1d4ed8; font-size:14px; font-weight:600; text-decoration:none;
                                          background:#f0f7ff;">
                                    Voir
                                </a>
                                <a href="{{ route('produits.edit', $produit) }}"
                                   style="padding:7px 16px; border-radius:8px; border:1.5px solid #e2e8f0;
                                          color:#475569; font-size:14px; font-weight:600; text-decoration:none;
                                          background:#f8fafc;">
                                    Modifier
                                </a>
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="padding:60px 20px; text-align:center; font-size:16px; color:#94a3b8;">
                            Aucun produit trouvé
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            @if($produits->hasPages())
            <div style="padding:16px 20px; border-top:1px solid #f0f7ff;">
                {{ $produits->appends(request()->query())->links() }}
            </div>
            @endif
        </div>

    </div>

</x-layouts.app>
