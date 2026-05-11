<x-layouts.app title="Stock — OptiGest">

<div style="max-width:100%; margin:0 auto;">

    {{-- Header --}}
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:28px; flex-wrap:wrap; gap:12px;">
        <div>
            <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0;">Gestion du Stock</h1>
            <p style="font-size:15px; color:#94a3b8; margin:6px 0 0;">Catalogue des articles en stock</p>
        </div>
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <a href="{{ route('articles.retrait.selection.form') }}"
               style="display:flex; align-items:center; gap:7px; padding:10px 18px; border-radius:12px;
                      background:#fff7ed; border:1.5px solid #fed7aa; color:#ea580c;
                      font-size:14px; font-weight:700; text-decoration:none;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#ea580c" stroke-width="2.5">
                    <polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 014-4h14"/>
                    <polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 01-4 4H3"/>
                </svg>
                Retrait guidé
            </a>
            @if(auth()->user()->role === 'admin')
            <a href="{{ route('retraits.synthese') }}"
               style="display:flex; align-items:center; gap:7px; padding:10px 18px; border-radius:12px;
                      background:#f0fdf4; border:1.5px solid #bbf7d0; color:#16a34a;
                      font-size:14px; font-weight:700; text-decoration:none;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.5">
                    <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/>
                    <line x1="6" y1="20" x2="6" y2="14"/>
                </svg>
                Tableau de bord stock
            </a>
            @endif
            <a href="{{ route('designations.index') }}"
               style="display:flex; align-items:center; gap:7px; padding:10px 18px; border-radius:12px;
                      background:#f5f3ff; border:1.5px solid #c4b5fd; color:#7c3aed;
                      font-size:14px; font-weight:700; text-decoration:none;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#7c3aed" stroke-width="2.5">
                    <line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/>
                    <line x1="8" y1="18" x2="21" y2="18"/>
                    <line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/>
                    <line x1="3" y1="18" x2="3.01" y2="18"/>
                </svg>
                Désignations
            </a>
            <a href="{{ route('types-articles.index') }}"
               style="display:flex; align-items:center; gap:7px; padding:10px 18px; border-radius:12px;
                      background:#ecfeff; border:1.5px solid #a5f3fc; color:#0891b2;
                      font-size:14px; font-weight:700; text-decoration:none;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#0891b2" stroke-width="2.5">
                    <rect x="2" y="3" width="20" height="5" rx="1"/><rect x="2" y="10" width="20" height="5" rx="1"/>
                    <rect x="2" y="17" width="20" height="5" rx="1"/>
                </svg>
                Types
            </a>
            <a href="{{ route('societes.index') }}"
               style="display:flex; align-items:center; gap:7px; padding:10px 18px; border-radius:12px;
                      background:#fff7ed; border:1.5px solid #fed7aa; color:#ea580c;
                      font-size:14px; font-weight:700; text-decoration:none;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#ea580c" stroke-width="2.5">
                    <rect x="2" y="7" width="20" height="14" rx="2"/>
                    <path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/>
                </svg>
                Sociétés
            </a>
            <a href="{{ route('articles.create') }}"
               style="display:flex; align-items:center; gap:7px; padding:10px 18px; border-radius:12px;
                      background:#1d4ed8; color:#fff; font-size:14px; font-weight:700; text-decoration:none;
                      box-shadow:0 4px 12px rgba(29,78,216,0.3);">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Enregistrer achat
            </a>
        </div>
    </div>

    {{-- Filtres rapides stock --}}
    @php
        $filtre       = request('filtre', 'tous');
        $baseParams   = request()->except(['filtre','page']);
    @endphp
    <div style="display:flex; gap:8px; margin-bottom:20px; flex-wrap:wrap;">
        <a href="{{ route('articles.index', array_merge($baseParams, ['filtre'=>'tous'])) }}"
           style="display:flex; align-items:center; gap:6px; padding:9px 18px; border-radius:10px; font-size:14px; font-weight:700; text-decoration:none;
                  {{ $filtre === 'tous' ? 'background:#1d4ed8; color:#fff; box-shadow:0 4px 10px rgba(29,78,216,0.25);' : 'background:#f0f7ff; color:#1d4ed8; border:1.5px solid #bfdbfe;' }}">
            Tous les articles
        </a>
        <a href="{{ route('articles.index', array_merge($baseParams, ['filtre'=>'alerte'])) }}"
           style="display:flex; align-items:center; gap:6px; padding:9px 18px; border-radius:10px; font-size:14px; font-weight:700; text-decoration:none;
                  {{ $filtre === 'alerte' ? 'background:#ca8a04; color:#fff; box-shadow:0 4px 10px rgba(202,138,4,0.25);' : 'background:#fefce8; color:#ca8a04; border:1.5px solid #fde68a;' }}">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            Stock faible
            @if($nbAlerte > 0)
            <span style="background:{{ $filtre === 'alerte' ? 'rgba(255,255,255,0.3)' : '#fde68a' }}; color:{{ $filtre === 'alerte' ? '#fff' : '#92400e' }};
                         font-size:12px; font-weight:800; padding:1px 8px; border-radius:99px; min-width:20px; text-align:center;">
                {{ $nbAlerte }}
            </span>
            @endif
        </a>
        <a href="{{ route('articles.index', array_merge($baseParams, ['filtre'=>'rupture'])) }}"
           style="display:flex; align-items:center; gap:6px; padding:9px 18px; border-radius:10px; font-size:14px; font-weight:700; text-decoration:none;
                  {{ $filtre === 'rupture' ? 'background:#dc2626; color:#fff; box-shadow:0 4px 10px rgba(220,38,38,0.25);' : 'background:#fff5f5; color:#dc2626; border:1.5px solid #fca5a5;' }}">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
            Rupture de stock
            @if($nbRupture > 0)
            <span style="background:{{ $filtre === 'rupture' ? 'rgba(255,255,255,0.3)' : '#fca5a5' }}; color:{{ $filtre === 'rupture' ? '#fff' : '#991b1b' }};
                         font-size:12px; font-weight:800; padding:1px 8px; border-radius:99px; min-width:20px; text-align:center;">
                {{ $nbRupture }}
            </span>
            @endif
        </a>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:12px; padding:14px 18px;
                    color:#16a34a; font-weight:600; font-size:15px; margin-bottom:20px; display:flex; align-items:center; gap:10px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.5">
                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Import / Export --}}
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:24px;">
        {{-- Import --}}
        <div style="background:#fff; border-radius:14px; border:1px solid #bfdbfe; padding:18px;">
            <p style="font-size:14px; font-weight:700; color:#334155; margin:0 0 12px;">Import Excel</p>
            <form method="POST" action="{{ route('articles.importer') }}" enctype="multipart/form-data"
                  style="display:flex; align-items:center; gap:10px;">
                @csrf
                <input type="file" name="fichier" accept=".xlsx,.xls,.csv" required
                       style="flex:1; font-size:14px; color:#334155; border:1.5px solid #bfdbfe;
                              border-radius:9px; padding:8px 12px; background:#f8fbff;">
                <button type="submit"
                        style="padding:9px 16px; border-radius:9px; background:#1d4ed8; color:#fff;
                               border:none; font-size:14px; font-weight:700; cursor:pointer;
                               font-family:'Plus Jakarta Sans',sans-serif; white-space:nowrap;">
                    Importer
                </button>
            </form>
            <p style="font-size:12px; color:#94a3b8; margin:8px 0 0;">Colonnes : date | societe | article | champ_reserve | stock | prix_dachat</p>
        </div>

        {{-- Export --}}
        <div style="background:#fff; border-radius:14px; border:1px solid #bfdbfe; padding:18px;">
            <p style="font-size:14px; font-weight:700; color:#334155; margin:0 0 12px;">Export achats (Excel)</p>
            <form method="POST" action="{{ route('articles.exporter') }}"
                  style="display:flex; align-items:center; gap:10px;">
                @csrf
                <input type="date" name="date_debut" value="{{ now()->startOfMonth()->toDateString() }}" required
                       style="flex:1; height:40px; border:1.5px solid #bfdbfe; border-radius:9px;
                              padding:0 12px; font-size:14px; color:#334155; background:#f8fbff; font-family:'Plus Jakarta Sans',sans-serif;">
                <span style="font-size:14px; color:#94a3b8;">→</span>
                <input type="date" name="date_fin" value="{{ now()->toDateString() }}" required
                       style="flex:1; height:40px; border:1.5px solid #bfdbfe; border-radius:9px;
                              padding:0 12px; font-size:14px; color:#334155; background:#f8fbff; font-family:'Plus Jakarta Sans',sans-serif;">
                <button type="submit"
                        style="padding:9px 16px; border-radius:9px; background:#16a34a; color:#fff;
                               border:none; font-size:14px; font-weight:700; cursor:pointer;
                               font-family:'Plus Jakarta Sans',sans-serif; white-space:nowrap;">
                    Exporter
                </button>
            </form>
        </div>
    </div>

    {{-- Recherche --}}
    <form method="GET" action="{{ route('articles.index') }}"
          style="display:flex; gap:10px; margin-bottom:20px;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher par désignation, société, type d'article…"
               style="flex:1; height:44px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff;
                      padding:0 16px; font-size:15px; color:#0f172a; outline:none; font-family:'Plus Jakarta Sans',sans-serif;">
        <button type="submit"
                style="padding:0 20px; height:44px; border-radius:12px; background:#1d4ed8; color:#fff;
                       border:none; font-size:14px; font-weight:700; cursor:pointer; font-family:'Plus Jakarta Sans',sans-serif;">
            Rechercher
        </button>
        @if(request('search'))
            <a href="{{ route('articles.index') }}"
               style="padding:0 16px; height:44px; display:flex; align-items:center; border-radius:12px;
                      border:1.5px solid #bfdbfe; color:#334155; font-size:14px; font-weight:600; text-decoration:none;">
                Effacer
            </a>
        @endif
    </form>

    {{-- Tableau --}}
    <div style="background:#fff; border-radius:16px; border:1px solid #bfdbfe; overflow:hidden;">
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#f0f7ff;">
                    <th style="padding:14px 18px; text-align:left; font-size:13px; font-weight:700; color:#1d4ed8; border-bottom:1.5px solid #bfdbfe;">Société / Marque</th>
                    <th style="padding:14px 18px; text-align:left; font-size:13px; font-weight:700; color:#1d4ed8; border-bottom:1.5px solid #bfdbfe;">Type d'article</th>
                    <th style="padding:14px 18px; text-align:left; font-size:13px; font-weight:700; color:#1d4ed8; border-bottom:1.5px solid #bfdbfe;">Désignation</th>
                    <th style="padding:14px 18px; text-align:center; font-size:13px; font-weight:700; color:#1d4ed8; border-bottom:1.5px solid #bfdbfe;">Stock</th>
                    <th style="padding:14px 18px; text-align:right; font-size:13px; font-weight:700; color:#1d4ed8; border-bottom:1.5px solid #bfdbfe;">Prix achat</th>
                    <th style="padding:14px 18px; text-align:center; font-size:13px; font-weight:700; color:#1d4ed8; border-bottom:1.5px solid #bfdbfe;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $article)
                @php
                    $enRupture = $article->quantite_stock === 0;
                    $enAlerte  = !$enRupture && $article->quantite_stock <= $article->seuil_alerte;
                    $stockBas  = $enRupture || $enAlerte;
                    $rowBg     = $enRupture ? 'background:#fff5f5;' : ($enAlerte ? 'background:#fefce8;' : '');
                    $hoverBg   = $enRupture ? '#ffe4e6' : ($enAlerte ? '#fef9c3' : '#f8fbff');
                    $unhoverBg = $enRupture ? '#fff5f5' : ($enAlerte ? '#fefce8' : 'transparent');
                @endphp
                <tr style="border-bottom:1px solid #f0f7ff; {{ $rowBg }} transition:background 0.15s;"
                    onmouseover="this.style.background='{{ $hoverBg }}'"
                    onmouseout="this.style.background='{{ $unhoverBg }}'">

                    <td style="padding:14px 18px;">
                        <span style="font-size:15px; font-weight:700; color:#0f172a;">
                            {{ $article->societe->nom }}
                        </span>
                    </td>
                    <td style="padding:14px 18px;">
                        <span style="background:#eff6ff; color:#2563eb; border:1px solid #bfdbfe;
                                     font-size:13px; font-weight:600; padding:4px 10px; border-radius:99px;">
                            {{ $article->typeArticle->nom }}
                        </span>
                    </td>
                    <td style="padding:14px 18px; font-size:15px; color:#334155;">
                        {{ $article->designation->nom }}
                    </td>
                    <td style="padding:14px 18px; text-align:center;">
                        @if($enRupture)
                            <span style="background:#fee2e2; color:#dc2626; border:1px solid #fca5a5;
                                         font-size:13px; font-weight:800; padding:5px 12px; border-radius:99px;
                                         display:inline-flex; align-items:center; gap:4px;">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                    <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                                </svg>
                                Rupture
                            </span>
                        @elseif($enAlerte)
                            <span style="background:#fef9c3; color:#92400e; border:1px solid #fde68a;
                                         font-size:14px; font-weight:800; padding:5px 12px; border-radius:99px;
                                         display:inline-flex; align-items:center; gap:5px;">
                                ⚠ {{ $article->quantite_stock }}/{{ $article->seuil_alerte }}
                            </span>
                        @else
                            <span style="background:#dcfce7; color:#16a34a; border:1px solid #bbf7d0;
                                         font-size:14px; font-weight:700; padding:5px 12px; border-radius:99px;">
                                {{ $article->quantite_stock }}
                            </span>
                        @endif
                    </td>
                    <td style="padding:14px 18px; text-align:right; font-size:15px; font-weight:700; color:#0f172a;">
                        {{ number_format($article->prix_achat_actuel, 2) }} MAD
                    </td>
                    <td style="padding:14px 18px; text-align:center;">
                        <div style="display:flex; align-items:center; justify-content:center; gap:8px;">
                            <a href="{{ route('articles.retirer.form', $article) }}"
                               title="Retirer du stock"
                               style="width:34px; height:34px; display:flex; align-items:center; justify-content:center;
                                      border-radius:9px; background:#fff7ed; border:1px solid #fed7aa; text-decoration:none;">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#ea580c" stroke-width="2.5">
                                    <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                                </svg>
                            </a>
                            <a href="{{ route('articles.edit', $article) }}"
                               title="Modifier"
                               style="width:34px; height:34px; display:flex; align-items:center; justify-content:center;
                                      border-radius:9px; background:#f0f7ff; border:1px solid #bfdbfe; text-decoration:none;">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="2.5">
                                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('articles.destroy', $article) }}"
                                  onsubmit="return confirm('Supprimer cet article ?')" style="margin:0;">
                                @csrf @method('DELETE')
                                <button type="submit" title="Supprimer"
                                        style="width:34px; height:34px; display:flex; align-items:center; justify-content:center;
                                               border-radius:9px; background:#fff0f0; border:1px solid #fca5a5;
                                               cursor:pointer;">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2.5">
                                        <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a1 1 0 011-1h4a1 1 0 011 1v2"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding:40px; text-align:center; color:#94a3b8; font-size:15px;">
                        Aucun article en stock
                        @if(request('search')) — modifiez votre recherche @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Légende --}}
    <div style="display:flex; align-items:center; gap:16px; margin-top:14px; flex-wrap:wrap;">
        <div style="display:flex; align-items:center; gap:6px;">
            <span style="display:inline-block; width:14px; height:14px; background:#fefce8; border:1px solid #fde68a; border-radius:3px;"></span>
            <span style="font-size:13px; color:#94a3b8;">Stock ≤ seuil d'alerte de l'article</span>
        </div>
        <div style="display:flex; align-items:center; gap:6px;">
            <span style="display:inline-block; width:14px; height:14px; background:#fff5f5; border:1px solid #fca5a5; border-radius:3px;"></span>
            <span style="font-size:13px; color:#94a3b8;">Rupture totale (stock = 0)</span>
        </div>
        <span style="font-size:13px; color:#94a3b8;">· Le badge affiche stock / seuil</span>
    </div>

    {{-- Pagination --}}
    @if($articles->hasPages())
        <div style="margin-top:20px;">
            {{ $articles->links() }}
        </div>
    @endif

</div>

</x-layouts.app>
