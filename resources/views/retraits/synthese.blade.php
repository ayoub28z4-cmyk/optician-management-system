<x-layouts.app title="Tableau de bord Stock — OptiGest">

<div style="max-width:100%;">

    {{-- ══ HEADER ══════════════════════════════════════════════════════════ --}}
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:28px; flex-wrap:wrap; gap:12px;">
        <div style="display:flex; align-items:center; gap:16px;">
            <a href="{{ route('articles.index') }}"
               style="width:44px; height:44px; border-radius:12px; border:1.5px solid #bfdbfe;
                      background:#f0f7ff; display:flex; align-items:center; justify-content:center; text-decoration:none; flex-shrink:0;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="2.5">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0;">Tableau de bord Stock</h1>
                <p style="font-size:15px; color:#94a3b8; margin:6px 0 0;">
                    Flux du {{ \Carbon\Carbon::parse($dateDebut)->format('d/m/Y') }}
                    au {{ \Carbon\Carbon::parse($dateFin)->format('d/m/Y') }}
                    &nbsp;·&nbsp; État actuel en temps réel
                </p>
            </div>
        </div>

        {{-- Filtre date --}}
        <form method="GET" action="{{ route('retraits.synthese') }}"
              style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
            <input type="date" name="date_debut" value="{{ $dateDebut }}"
                   style="height:44px; border-radius:11px; border:1.5px solid #bfdbfe; background:#f8fbff;
                          padding:0 14px; font-size:14px; color:#0f172a; outline:none; font-family:'Plus Jakarta Sans',sans-serif;">
            <span style="color:#94a3b8; font-size:14px;">→</span>
            <input type="date" name="date_fin" value="{{ $dateFin }}"
                   style="height:44px; border-radius:11px; border:1.5px solid #bfdbfe; background:#f8fbff;
                          padding:0 14px; font-size:14px; color:#0f172a; outline:none; font-family:'Plus Jakarta Sans',sans-serif;">
            <button type="submit"
                    style="padding:0 20px; height:44px; border-radius:11px; background:#1d4ed8; color:#fff;
                           border:none; font-size:14px; font-weight:700; cursor:pointer; font-family:'Plus Jakarta Sans',sans-serif;">
                Filtrer
            </button>
        </form>
    </div>

    {{-- ══ A. ÉTAT ACTUEL DU STOCK ═════════════════════════════════════════ --}}
    <p style="font-size:12px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.8px; margin:0 0 12px;">
        État actuel du stock
    </p>
    <div style="display:grid; grid-template-columns:repeat(5,1fr); gap:14px; margin-bottom:28px;">

        {{-- Valeur totale --}}
        <div style="background:#fff; border-radius:16px; border:1px solid #bfdbfe; padding:20px;
                    box-shadow:0 4px 12px rgba(29,78,216,0.07); text-align:center;">
            <p style="font-size:12px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 10px;">Valeur du stock</p>
            <p style="font-size:22px; font-weight:900; color:#1d4ed8; margin:0;">{{ number_format($valeurStock, 0, ',', ' ') }}</p>
            <p style="font-size:13px; color:#94a3b8; margin:4px 0 0;">MAD</p>
        </div>

        {{-- Total SKUs --}}
        <div style="background:#fff; border-radius:16px; border:1px solid #bfdbfe; padding:20px;
                    box-shadow:0 4px 12px rgba(29,78,216,0.07); text-align:center;">
            <p style="font-size:12px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 10px;">Références</p>
            <p style="font-size:36px; font-weight:900; color:#0f172a; margin:0;">{{ $totalSKUs }}</p>
            <p style="font-size:13px; color:#94a3b8; margin:4px 0 0;">articles distincts</p>
        </div>

        {{-- Bien stocké --}}
        <div style="background:#f0fdf4; border-radius:16px; border:1px solid #bbf7d0; padding:20px; text-align:center;">
            <p style="font-size:12px; font-weight:700; color:#15803d; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 10px;">Bien stockés</p>
            <p style="font-size:36px; font-weight:900; color:#16a34a; margin:0;">{{ $bienStocke }}</p>
            <p style="font-size:13px; color:#16a34a; margin:4px 0 0; opacity:0.7;">au-dessus du seuil</p>
        </div>

        {{-- Alerte --}}
        <div style="background:#fefce8; border-radius:16px; border:1px solid #fde68a; padding:20px; text-align:center;">
            <p style="font-size:12px; font-weight:700; color:#92400e; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 10px;">En alerte</p>
            <p style="font-size:36px; font-weight:900; color:#ca8a04; margin:0;">{{ $enAlerte }}</p>
            <p style="font-size:13px; color:#ca8a04; margin:4px 0 0; opacity:0.8;">stock ≤ seuil</p>
        </div>

        {{-- Rupture --}}
        <div style="background:#fff5f5; border-radius:16px; border:1px solid #fca5a5; padding:20px; text-align:center;">
            <p style="font-size:12px; font-weight:700; color:#991b1b; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 10px;">En rupture</p>
            <p style="font-size:36px; font-weight:900; color:#dc2626; margin:0;">{{ $enRupture }}</p>
            <p style="font-size:13px; color:#dc2626; margin:4px 0 0; opacity:0.8;">stock = 0</p>
        </div>

    </div>

    {{-- ══ B. FLUX DE LA PÉRIODE ════════════════════════════════════════════ --}}
    <p style="font-size:12px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.8px; margin:0 0 12px;">
        Flux de la période
    </p>
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:28px;">

        {{-- Entrées --}}
        <div style="background:#fff; border-radius:16px; border:1.5px solid #bbf7d0; padding:22px;
                    box-shadow:0 4px 12px rgba(22,163,74,0.07);">
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:16px;">
                <div style="width:36px; height:36px; border-radius:10px; background:#dcfce7;
                            display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.5">
                        <line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/>
                    </svg>
                </div>
                <h3 style="font-size:16px; font-weight:800; color:#15803d; margin:0;">Entrées (Achats)</h3>
            </div>
            <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:12px; text-align:center;">
                <div style="background:#f0fdf4; border-radius:10px; padding:14px;">
                    <p style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; margin:0 0 6px;">Mouvements</p>
                    <p style="font-size:28px; font-weight:900; color:#16a34a; margin:0;">{{ $nbEntrees }}</p>
                </div>
                <div style="background:#f0fdf4; border-radius:10px; padding:14px;">
                    <p style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; margin:0 0 6px;">Unités</p>
                    <p style="font-size:28px; font-weight:900; color:#16a34a; margin:0;">{{ $qteEntrees }}</p>
                </div>
                <div style="background:#f0fdf4; border-radius:10px; padding:14px;">
                    <p style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; margin:0 0 6px;">Valeur</p>
                    <p style="font-size:18px; font-weight:900; color:#16a34a; margin:0;">{{ number_format($valeurEntrees, 0, ',', ' ') }}</p>
                    <p style="font-size:11px; color:#94a3b8; margin:2px 0 0;">MAD</p>
                </div>
            </div>
        </div>

        {{-- Sorties --}}
        <div style="background:#fff; border-radius:16px; border:1.5px solid #fca5a5; padding:22px;
                    box-shadow:0 4px 12px rgba(220,38,38,0.07);">
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:16px;">
                <div style="width:36px; height:36px; border-radius:10px; background:#fee2e2;
                            display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2.5">
                        <line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/>
                    </svg>
                </div>
                <h3 style="font-size:16px; font-weight:800; color:#dc2626; margin:0;">Sorties</h3>
            </div>
            <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:12px; text-align:center; margin-bottom:14px;">
                <div style="background:#fff5f5; border-radius:10px; padding:14px;">
                    <p style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; margin:0 0 6px;">Mouvements</p>
                    <p style="font-size:28px; font-weight:900; color:#dc2626; margin:0;">{{ $nbSorties }}</p>
                </div>
                <div style="background:#fff5f5; border-radius:10px; padding:14px;">
                    <p style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; margin:0 0 6px;">Unités</p>
                    <p style="font-size:28px; font-weight:900; color:#dc2626; margin:0;">{{ $qteSorties }}</p>
                </div>
                <div style="background:#fff5f5; border-radius:10px; padding:14px;">
                    <p style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; margin:0 0 6px;">Coût sortie</p>
                    <p style="font-size:18px; font-weight:900; color:#dc2626; margin:0;">{{ number_format($valeurSorties, 0, ',', ' ') }}</p>
                    <p style="font-size:11px; color:#94a3b8; margin:2px 0 0;">MAD</p>
                </div>
            </div>
            {{-- Détail par motif --}}
            @php
                $motifsConfig = [
                    'vente'  => ['Ventes',  '#16a34a', '#dcfce7', '#bbf7d0'],
                    'casse'  => ['Casses',  '#dc2626', '#fee2e2', '#fca5a5'],
                    'retour' => ['Retours', '#7c3aed', '#f5f3ff', '#c4b5fd'],
                ];
            @endphp
            <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:8px;">
                @foreach($motifsConfig as $key => [$label, $color, $bg, $border])
                <div style="background:{{ $bg }}; border:1px solid {{ $border }}; border-radius:10px;
                            padding:10px; text-align:center;">
                    <p style="font-size:11px; font-weight:700; color:{{ $color }}; margin:0 0 4px;">{{ $label }}</p>
                    <p style="font-size:20px; font-weight:900; color:{{ $color }}; margin:0;">{{ $parMotif[$key]->qte ?? 0 }}</p>
                    <p style="font-size:11px; color:{{ $color }}; opacity:0.7; margin:2px 0 0;">{{ $parMotif[$key]->nb ?? 0 }} mvt</p>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    {{-- ══ C. ALERTES ══════════════════════════════════════════════════════ --}}
    @if($articlesRupture->isNotEmpty() || $articlesSousSeuil->isNotEmpty())
    <p style="font-size:12px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.8px; margin:0 0 12px;">
        Alertes stock
    </p>
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:28px;">

        {{-- Ruptures --}}
        @if($articlesRupture->isNotEmpty())
        <div style="background:#fff; border-radius:16px; border:1.5px solid #fca5a5; padding:22px;
                    box-shadow:0 4px 12px rgba(220,38,38,0.07);">
            <div style="display:flex; align-items:center; gap:8px; margin-bottom:16px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2.5">
                    <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
                <h3 style="font-size:15px; font-weight:800; color:#dc2626; margin:0;">
                    Ruptures ({{ $articlesRupture->count() }})
                </h3>
            </div>
            @foreach($articlesRupture as $art)
            <div style="display:flex; align-items:center; justify-content:space-between;
                        padding:10px 0; border-bottom:1px solid #fff5f5;">
                <div>
                    <p style="font-size:14px; font-weight:700; color:#0f172a; margin:0;">{{ $art->designation->nom }}</p>
                    <p style="font-size:12px; color:#94a3b8; margin:2px 0 0;">{{ $art->societe->nom }} · {{ $art->typeArticle->nom }}</p>
                </div>
                <a href="{{ route('articles.create') }}"
                   style="font-size:12px; font-weight:700; color:#dc2626; text-decoration:none;
                          background:#fff5f5; border:1px solid #fca5a5; padding:4px 10px; border-radius:8px; white-space:nowrap;">
                    Réappro →
                </a>
            </div>
            @endforeach
        </div>
        @endif

        {{-- Sous seuil --}}
        @if($articlesSousSeuil->isNotEmpty())
        <div style="background:#fff; border-radius:16px; border:1.5px solid #fde68a; padding:22px;
                    box-shadow:0 4px 12px rgba(202,138,4,0.07);">
            <div style="display:flex; align-items:center; gap:8px; margin-bottom:16px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ca8a04" stroke-width="2.5">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <h3 style="font-size:15px; font-weight:800; color:#ca8a04; margin:0;">
                    Sous seuil ({{ $articlesSousSeuil->count() }})
                </h3>
            </div>
            @foreach($articlesSousSeuil as $art)
            <div style="display:flex; align-items:center; justify-content:space-between;
                        padding:10px 0; border-bottom:1px solid #fefce8;">
                <div>
                    <p style="font-size:14px; font-weight:700; color:#0f172a; margin:0;">{{ $art->designation->nom }}</p>
                    <p style="font-size:12px; color:#94a3b8; margin:2px 0 0;">{{ $art->societe->nom }} · {{ $art->typeArticle->nom }}</p>
                </div>
                <span style="font-size:14px; font-weight:900; color:#ca8a04;
                             background:#fefce8; border:1px solid #fde68a;
                             padding:4px 12px; border-radius:99px; white-space:nowrap;">
                    {{ $art->quantite_stock }} / {{ $art->seuil_alerte }}
                </span>
            </div>
            @endforeach
        </div>
        @endif

    </div>
    @endif

    {{-- ══ D. TOP SORTANTS + DORMANTS ══════════════════════════════════════ --}}
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:28px;">

        {{-- Top 5 articles sortants --}}
        <div style="background:#fff; border-radius:16px; border:1px solid #bfdbfe; padding:22px;
                    box-shadow:0 4px 12px rgba(29,78,216,0.07);">
            <h3 style="font-size:15px; font-weight:800; color:#0f172a; margin:0 0 16px;">
                Top 5 articles sortants
                <span style="font-size:12px; font-weight:500; color:#94a3b8;">(période)</span>
            </h3>
            @forelse($topArticles as $i => $row)
            <div style="display:flex; align-items:center; gap:12px; padding:10px 0; border-bottom:1px solid #f0f7ff;">
                <span style="width:24px; height:24px; border-radius:50%; background:#eff6ff; color:#1d4ed8;
                             font-size:12px; font-weight:800; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    {{ $i + 1 }}
                </span>
                <div style="flex:1; min-width:0;">
                    <p style="font-size:14px; font-weight:700; color:#0f172a; margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        {{ $row->produit->designation->nom }}
                    </p>
                    <p style="font-size:12px; color:#94a3b8; margin:2px 0 0;">
                        {{ $row->produit->societe->nom }} · {{ $row->produit->typeArticle->nom }}
                    </p>
                </div>
                <div style="text-align:right; flex-shrink:0;">
                    <p style="font-size:16px; font-weight:900; color:#1d4ed8; margin:0;">{{ $row->total_sortie }} u.</p>
                    <p style="font-size:11px; color:#94a3b8; margin:2px 0 0;">{{ $row->nb_mvt }} mvt</p>
                </div>
            </div>
            @empty
            <p style="color:#94a3b8; font-size:14px; padding:20px 0; text-align:center;">Aucune sortie sur cette période</p>
            @endforelse
        </div>

        {{-- Articles dormants --}}
        <div style="background:#fff; border-radius:16px; border:1px solid #bfdbfe; padding:22px;
                    box-shadow:0 4px 12px rgba(29,78,216,0.07);">
            <h3 style="font-size:15px; font-weight:800; color:#0f172a; margin:0 0 16px;">
                Articles dormants
                <span style="font-size:12px; font-weight:500; color:#94a3b8;">(aucun mvt depuis 30j)</span>
            </h3>
            @forelse($dormants as $art)
            <div style="display:flex; align-items:center; justify-content:space-between; padding:10px 0; border-bottom:1px solid #f0f7ff;">
                <div style="min-width:0; flex:1;">
                    <p style="font-size:14px; font-weight:700; color:#0f172a; margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        {{ $art->designation->nom }}
                    </p>
                    <p style="font-size:12px; color:#94a3b8; margin:2px 0 0;">{{ $art->societe->nom }} · {{ $art->typeArticle->nom }}</p>
                </div>
                <span style="font-size:14px; font-weight:800; color:#64748b;
                             background:#f1f5f9; border:1px solid #e2e8f0;
                             padding:4px 12px; border-radius:99px; flex-shrink:0; margin-left:10px;">
                    {{ $art->quantite_stock }} en stock
                </span>
            </div>
            @empty
            <p style="color:#94a3b8; font-size:14px; padding:20px 0; text-align:center;">Tous les articles ont eu un mouvement récent</p>
            @endforelse
        </div>

    </div>

    {{-- ══ E. RÉPARTITIONS ═════════════════════════════════════════════════ --}}
    @if($nbSorties > 0)
    <p style="font-size:12px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.8px; margin:0 0 12px;">
        Répartition des sorties
    </p>
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:28px;">

        {{-- Par société --}}
        <div style="background:#fff; border-radius:16px; border:1px solid #bfdbfe; padding:22px;
                    box-shadow:0 4px 12px rgba(29,78,216,0.07);">
            <h3 style="font-size:15px; font-weight:800; color:#0f172a; margin:0 0 16px;">Par société</h3>
            @php $maxQteSociete = $parSociete->max('qte') ?: 1; @endphp
            @forelse($parSociete as $row)
            <div style="padding:10px 0; border-bottom:1px solid #f0f7ff;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                    <span style="font-size:14px; font-weight:700; color:#334155;">{{ $row->societe }}</span>
                    <span style="font-size:13px; font-weight:700; color:#1d4ed8;">{{ $row->qte }} u. · {{ $row->nb }} mvt</span>
                </div>
                <div style="background:#eff6ff; border-radius:99px; height:6px; overflow:hidden;">
                    <div style="height:100%; border-radius:99px; background:#1d4ed8;
                                width:{{ round(($row->qte / $maxQteSociete) * 100) }}%;"></div>
                </div>
            </div>
            @empty
            <p style="color:#94a3b8; font-size:14px;">Aucune donnée</p>
            @endforelse
        </div>

        {{-- Par type d'article --}}
        <div style="background:#fff; border-radius:16px; border:1px solid #bfdbfe; padding:22px;
                    box-shadow:0 4px 12px rgba(29,78,216,0.07);">
            <h3 style="font-size:15px; font-weight:800; color:#0f172a; margin:0 0 16px;">Par type d'article</h3>
            @php $maxQteType = $parTypeArticle->max('qte') ?: 1; @endphp
            @forelse($parTypeArticle as $row)
            <div style="padding:10px 0; border-bottom:1px solid #f0f7ff;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                    <span style="background:#eff6ff; color:#2563eb; border:1px solid #bfdbfe;
                                 font-size:12px; font-weight:600; padding:3px 10px; border-radius:99px;">
                        {{ $row->type_article }}
                    </span>
                    <span style="font-size:13px; font-weight:700; color:#1d4ed8;">{{ $row->qte }} u. · {{ $row->nb }} mvt</span>
                </div>
                <div style="background:#eff6ff; border-radius:99px; height:6px; overflow:hidden;">
                    <div style="height:100%; border-radius:99px; background:#7c3aed;
                                width:{{ round(($row->qte / $maxQteType) * 100) }}%;"></div>
                </div>
            </div>
            @empty
            <p style="color:#94a3b8; font-size:14px;">Aucune donnée</p>
            @endforelse
        </div>

    </div>
    @endif

    {{-- ══ F. JOURNAL DES MOUVEMENTS ════════════════════════════════════════ --}}
    <p style="font-size:12px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.8px; margin:0 0 12px;">
        Journal des mouvements ({{ $journal->count() }} derniers)
    </p>
    <div style="background:#fff; border-radius:16px; border:1px solid #bfdbfe; overflow:hidden;
                box-shadow:0 4px 12px rgba(29,78,216,0.07);">
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#f0f7ff;">
                    <th style="padding:12px 16px; text-align:left; font-size:13px; font-weight:700; color:#1d4ed8; white-space:nowrap;">Date</th>
                    <th style="padding:12px 16px; text-align:center; font-size:13px; font-weight:700; color:#1d4ed8;">Type</th>
                    <th style="padding:12px 16px; text-align:left; font-size:13px; font-weight:700; color:#1d4ed8;">Société</th>
                    <th style="padding:12px 16px; text-align:left; font-size:13px; font-weight:700; color:#1d4ed8;">Catégorie</th>
                    <th style="padding:12px 16px; text-align:left; font-size:13px; font-weight:700; color:#1d4ed8;">Désignation</th>
                    <th style="padding:12px 16px; text-align:center; font-size:13px; font-weight:700; color:#1d4ed8;">Qté</th>
                    <th style="padding:12px 16px; text-align:right; font-size:13px; font-weight:700; color:#1d4ed8;">Prix/u.</th>
                    <th style="padding:12px 16px; text-align:right; font-size:13px; font-weight:700; color:#1d4ed8;">Valeur</th>
                </tr>
            </thead>
            <tbody>
                @forelse($journal as $m)
                @php
                    $typeConfig = [
                        'achat'  => ['Achat',  '#16a34a', '#dcfce7', '#bbf7d0', '+'],
                        'vente'  => ['Vente',  '#2563eb', '#eff6ff', '#bfdbfe', '-'],
                        'casse'  => ['Casse',  '#dc2626', '#fee2e2', '#fca5a5', '-'],
                        'retour' => ['Retour', '#7c3aed', '#f5f3ff', '#c4b5fd', '↩'],
                    ];
                    [$tLabel, $tColor, $tBg, $tBorder, $tSign] = $typeConfig[$m->type_mouvement] ?? ['?', '#64748b', '#f1f5f9', '#e2e8f0', ''];
                    $valeur = $m->prix_unitaire ? $m->quantite * $m->prix_unitaire : null;
                @endphp
                <tr style="border-bottom:1px solid #f0f7ff;"
                    onmouseover="this.style.background='#f8fbff'" onmouseout="this.style.background='transparent'">
                    <td style="padding:11px 16px; font-size:13px; color:#334155; white-space:nowrap;">
                        {{ $m->date_mouvement->format('d/m/Y') }}
                    </td>
                    <td style="padding:11px 16px; text-align:center;">
                        <span style="background:{{ $tBg }}; color:{{ $tColor }}; border:1px solid {{ $tBorder }};
                                     font-size:12px; font-weight:700; padding:3px 10px; border-radius:99px; white-space:nowrap;">
                            {{ $tSign }} {{ $tLabel }}
                        </span>
                    </td>
                    <td style="padding:11px 16px; font-size:13px; font-weight:700; color:#0f172a;">
                        {{ $m->produit->societe->nom }}
                    </td>
                    <td style="padding:11px 16px;">
                        <span style="background:#eff6ff; color:#2563eb; border:1px solid #bfdbfe;
                                     font-size:11px; font-weight:600; padding:2px 8px; border-radius:99px;">
                            {{ $m->produit->typeArticle->nom }}
                        </span>
                    </td>
                    <td style="padding:11px 16px; font-size:13px; color:#334155;">
                        {{ $m->produit->designation->nom }}
                    </td>
                    <td style="padding:11px 16px; text-align:center; font-size:15px; font-weight:800; color:{{ $tColor }};">
                        {{ $tSign }}{{ $m->quantite }}
                    </td>
                    <td style="padding:11px 16px; text-align:right; font-size:13px; color:#64748b;">
                        @if($m->prix_unitaire)
                            {{ number_format($m->prix_unitaire, 2) }}
                        @else
                            <span style="color:#cbd5e1;">—</span>
                        @endif
                    </td>
                    <td style="padding:11px 16px; text-align:right; font-size:13px; font-weight:700; color:#0f172a;">
                        @if($valeur)
                            {{ number_format($valeur, 2) }}
                        @else
                            <span style="color:#cbd5e1;">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="padding:40px; text-align:center; color:#94a3b8; font-size:15px;">
                        Aucun mouvement sur cette période
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

</x-layouts.app>
