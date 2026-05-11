<x-layouts.app title="Retrait guidé — OptiGest">

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
            <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0;">Retrait guidé</h1>
            <p style="font-size:15px; color:#94a3b8; margin:6px 0 0;">Sélectionnez le type d'article puis la désignation</p>
        </div>
    </div>

    {{-- Étape 1 : Choisir type d'article --}}
    <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe;
                padding:28px; box-shadow:0 4px 14px rgba(29,78,216,0.07); margin-bottom:20px;">

        <div style="display:flex; align-items:center; gap:10px; margin-bottom:20px;">
            <span style="width:28px; height:28px; border-radius:50%; background:#1d4ed8; color:#fff;
                         font-weight:800; font-size:14px; display:flex; align-items:center; justify-content:center;">1</span>
            <h2 style="font-size:18px; font-weight:700; color:#0f172a; margin:0;">Choisir le type d'article</h2>
        </div>

        <form method="GET" action="{{ route('articles.retrait.selection.form') }}">
            <div style="display:grid; grid-template-columns:1fr auto; gap:12px; align-items:end;">
                <div>
                    <select name="type_article_id" required
                            style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe;
                                   background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none;
                                   font-family:'Plus Jakarta Sans',sans-serif;">
                        <option value="">— Sélectionner un type —</option>
                        @foreach($typesArticles as $t)
                            <option value="{{ $t->id }}" {{ request('type_article_id') == $t->id ? 'selected' : '' }}>
                                {{ $t->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit"
                        style="padding:0 24px; height:50px; border-radius:12px; background:#1d4ed8; color:#fff;
                               border:none; font-size:15px; font-weight:700; cursor:pointer;
                               font-family:'Plus Jakarta Sans',sans-serif; white-space:nowrap;
                               box-shadow:0 4px 12px rgba(29,78,216,0.3);">
                    Filtrer
                </button>
            </div>
        </form>
    </div>

    {{-- Étape 2 : Choisir l'article --}}
    @if($typeArticle)
    <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe;
                padding:28px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">

        <div style="display:flex; align-items:center; gap:10px; margin-bottom:20px;">
            <span style="width:28px; height:28px; border-radius:50%; background:#1d4ed8; color:#fff;
                         font-weight:800; font-size:14px; display:flex; align-items:center; justify-content:center;">2</span>
            <h2 style="font-size:18px; font-weight:700; color:#0f172a; margin:0;">
                Sélectionner l'article — <span style="color:#1d4ed8;">{{ $typeArticle->nom }}</span>
            </h2>
        </div>

        @if($articles->isEmpty())
            <p style="color:#94a3b8; font-size:15px; text-align:center; padding:20px 0;">
                Aucun article disponible dans cette catégorie.
            </p>
        @else
        <form method="POST" action="{{ route('articles.retrait.selection') }}">
            @csrf
            <div style="display:flex; flex-direction:column; gap:10px; margin-bottom:20px;">
                @foreach($articles as $art)
                @php $bas = $art->quantite_stock <= 5; @endphp
                <label style="cursor:pointer; display:flex; align-items:center; gap:14px; padding:14px 18px;
                              border-radius:12px; border:1.5px solid {{ $bas ? '#fca5a5' : '#bfdbfe' }};
                              background:{{ $bas ? '#fff5f5' : '#f8fbff' }};"
                       onmouseover="this.style.borderColor='#1d4ed8'; this.style.background='#eff6ff'"
                       onmouseout="this.style.borderColor='{{ $bas ? '#fca5a5' : '#bfdbfe' }}'; this.style.background='{{ $bas ? '#fff5f5' : '#f8fbff' }}'">
                    <input type="radio" name="article_id" value="{{ $art->id }}" required
                           style="width:18px; height:18px; accent-color:#1d4ed8;">
                    <div style="flex:1;">
                        <p style="font-size:16px; font-weight:700; color:#0f172a; margin:0;">{{ $art->designation->nom }}</p>
                        <p style="font-size:13px; color:#64748b; margin:2px 0 0;">{{ $art->societe->nom }}</p>
                    </div>
                    <span style="background:{{ $bas ? '#fee2e2' : '#dcfce7' }}; color:{{ $bas ? '#dc2626' : '#16a34a' }};
                                 border:1px solid {{ $bas ? '#fca5a5' : '#bbf7d0' }};
                                 font-size:14px; font-weight:800; padding:5px 14px; border-radius:99px;">
                        {{ $art->quantite_stock }} en stock @if($bas)⚠@endif
                    </span>
                </label>
                @endforeach
            </div>

            <div style="display:flex; justify-content:flex-end;">
                <button type="submit"
                        style="padding:12px 28px; border-radius:12px; background:#ea580c; color:#fff;
                               border:none; font-size:16px; font-weight:700; cursor:pointer;
                               font-family:'Plus Jakarta Sans',sans-serif; box-shadow:0 4px 12px rgba(234,88,12,0.3);">
                    Aller au retrait →
                </button>
            </div>
        </form>
        @endif

    </div>
    @endif

</div>

</x-layouts.app>
