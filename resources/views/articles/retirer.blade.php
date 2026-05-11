<x-layouts.app title="Retrait de stock — OptiGest">

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
            <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0;">Retrait de stock</h1>
            <p style="font-size:15px; color:#94a3b8; margin:6px 0 0;">Vente, casse ou retour fournisseur</p>
        </div>
    </div>

    {{-- Infos article --}}
    <div style="background:#f0f7ff; border:1.5px solid #bfdbfe; border-radius:14px; padding:20px; margin-bottom:24px;">
        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px; text-align:center;">
            <div>
                <p style="font-size:12px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 4px;">Société</p>
                <p style="font-size:16px; font-weight:800; color:#0f172a; margin:0;">{{ $article->societe->nom }}</p>
            </div>
            <div>
                <p style="font-size:12px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 4px;">Type</p>
                <p style="font-size:16px; font-weight:800; color:#0f172a; margin:0;">{{ $article->typeArticle->nom }}</p>
            </div>
            <div>
                <p style="font-size:12px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 4px;">Stock actuel</p>
                @php $bas = $article->quantite_stock <= 5; @endphp
                <p style="font-size:22px; font-weight:900; margin:0; color:{{ $bas ? '#dc2626' : '#16a34a' }};">
                    {{ $article->quantite_stock }}
                    @if($bas) <span style="font-size:14px;">⚠</span>@endif
                </p>
            </div>
        </div>
        <div style="margin-top:14px; padding-top:14px; border-top:1px solid #dbeafe; text-align:center;">
            <p style="font-size:15px; font-weight:600; color:#334155; margin:0;">
                {{ $article->designation->nom }}
            </p>
        </div>
    </div>

    {{-- Erreurs --}}
    @if($errors->any())
        <div style="background:#fff5f5; border:1px solid #fca5a5; border-radius:12px; padding:14px 18px;
                    color:#dc2626; font-weight:600; font-size:15px; margin-bottom:20px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('articles.retirer', $article) }}">
        @csrf

        <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe;
                    padding:28px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">

            {{-- Motif --}}
            <div style="margin-bottom:24px;">
                <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:12px;">
                    Motif du retrait <span style="color:#ef4444;">*</span>
                </label>
                <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px;">

                    @php
                        $motifDefault = old('motif', 'vente');
                        $motifOptions = [
                            'vente'  => ['label' => 'Vente',  'color' => '#16a34a', 'bg' => '#dcfce7', 'border' => '#16a34a', 'ring' => '#bbf7d0'],
                            'casse'  => ['label' => 'Casse',  'color' => '#dc2626', 'bg' => '#fee2e2', 'border' => '#dc2626', 'ring' => '#fca5a5'],
                            'retour' => ['label' => 'Retour', 'color' => '#7c3aed', 'bg' => '#f5f3ff', 'border' => '#7c3aed', 'ring' => '#c4b5fd'],
                        ];
                    @endphp

                    @foreach($motifOptions as $val => $opt)
                    <label onclick="selectMotif('{{ $val }}')" style="cursor:pointer; display:block;">
                        <input type="radio" name="motif" value="{{ $val }}"
                               id="motif_{{ $val }}"
                               {{ $motifDefault === $val ? 'checked' : '' }}
                               style="position:absolute; opacity:0; width:0; height:0;">

                        <div id="card_{{ $val }}"
                             style="position:relative; padding:18px 12px 14px; border-radius:14px;
                                    border:2.5px solid {{ $motifDefault === $val ? $opt['border'] : $opt['ring'] }};
                                    background:{{ $opt['bg'] }}; text-align:center;
                                    box-shadow:{{ $motifDefault === $val ? '0 0 0 3px '.$opt['ring'] : 'none' }};
                                    transition:box-shadow 0.15s, border-color 0.15s;">

                            {{-- Coche --}}
                            <div id="check_{{ $val }}"
                                 style="position:absolute; top:8px; right:8px; width:20px; height:20px;
                                        border-radius:50%; background:{{ $opt['border'] }}; color:#fff;
                                        display:{{ $motifDefault === $val ? 'flex' : 'none' }};
                                        align-items:center; justify-content:center;">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3.5">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                            </div>

                            <p style="font-size:17px; font-weight:800; color:{{ $opt['color'] }}; margin:0;">
                                {{ $opt['label'] }}
                            </p>
                        </div>
                    </label>
                    @endforeach

                </div>
                @error('motif')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
            </div>

            <script>
            const motifConfig = {
                vente:  { border: '#16a34a', ring: '#bbf7d0' },
                casse:  { border: '#dc2626', ring: '#fca5a5' },
                retour: { border: '#7c3aed', ring: '#c4b5fd' },
            };

            function selectMotif(val) {
                document.getElementById('motif_' + val).checked = true;

                Object.keys(motifConfig).forEach(function(key) {
                    const card  = document.getElementById('card_'  + key);
                    const check = document.getElementById('check_' + key);
                    const cfg   = motifConfig[key];

                    if (key === val) {
                        card.style.borderColor = cfg.border;
                        card.style.boxShadow   = '0 0 0 3px ' + cfg.ring;
                        check.style.display    = 'flex';
                    } else {
                        card.style.borderColor = cfg.ring;
                        card.style.boxShadow   = 'none';
                        check.style.display    = 'none';
                    }
                });
            }
            </script>

            {{-- Quantité --}}
            <div style="margin-bottom:32px;">
                <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:8px;">
                    Quantité à retirer <span style="color:#ef4444;">*</span>
                </label>
                <input type="number" name="quantite" value="{{ old('quantite', 1) }}"
                       min="1" max="{{ $article->quantite_stock }}" required
                       style="width:100%; height:56px; border-radius:12px; border:1.5px solid {{ $errors->has('quantite') ? '#ef4444' : '#bfdbfe' }};
                              background:#f8fbff; padding:0 16px; font-size:20px; font-weight:700; color:#0f172a;
                              outline:none; font-family:'Plus Jakarta Sans',sans-serif; text-align:center;">
                <p style="font-size:13px; color:#94a3b8; margin:6px 0 0; text-align:center;">
                    Maximum disponible : {{ $article->quantite_stock }} unité(s)
                </p>
                @error('quantite')<p style="font-size:14px; color:#ef4444; margin:8px 0 0; text-align:center;">{{ $message }}</p>@enderror
            </div>

            {{-- Actions --}}
            <div style="display:flex; gap:12px; justify-content:flex-end;">
                <a href="{{ route('articles.index') }}"
                   style="padding:12px 24px; border-radius:12px; border:1.5px solid #bfdbfe; color:#334155;
                          font-size:16px; font-weight:600; text-decoration:none; background:#f8fbff;">
                    Annuler
                </a>
                <button type="submit"
                        style="padding:12px 28px; border-radius:12px; background:#ea580c; color:#fff;
                               border:none; font-size:16px; font-weight:700; cursor:pointer;
                               font-family:'Plus Jakarta Sans',sans-serif; box-shadow:0 4px 12px rgba(234,88,12,0.3);">
                    Confirmer le retrait
                </button>
            </div>

        </div>
    </form>

</div>

</x-layouts.app>
