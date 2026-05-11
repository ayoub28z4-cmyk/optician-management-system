<x-layouts.app title="Sociétés / Marques — OptiGest">

<div style="max-width:90%; margin:0 auto;">

    {{-- Header --}}
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:28px;">
        <div style="display:flex; align-items:center; gap:16px;">
            <a href="{{ route('articles.index') }}"
               style="width:44px; height:44px; border-radius:12px; border:1.5px solid #bfdbfe;
                      background:#f0f7ff; display:flex; align-items:center; justify-content:center; text-decoration:none;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="2.5">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0;">Sociétés / Marques</h1>
                <p style="font-size:15px; color:#94a3b8; margin:6px 0 0;">Fournisseurs et marques associés aux articles</p>
            </div>
        </div>
    </div>

    {{-- Flash --}}
    @if(session('success'))
        <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:12px; padding:14px 18px;
                    color:#16a34a; font-weight:600; font-size:15px; margin-bottom:20px;">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div style="background:#fff5f5; border:1px solid #fca5a5; border-radius:12px; padding:14px 18px;
                    color:#dc2626; font-weight:600; font-size:15px; margin-bottom:20px;">
            {{ $errors->first() }}
        </div>
    @endif

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px; align-items:start;">

        {{-- Formulaire ajout --}}
        <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe;
                    padding:28px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
            <h2 style="font-size:18px; font-weight:700; color:#0f172a; margin:0 0 20px;">Ajouter une société</h2>
            <form method="POST" action="{{ route('societes.store') }}">
                @csrf
                <div style="margin-bottom:16px;">
                    <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:8px;">
                        Nom de la société <span style="color:#ef4444;">*</span>
                    </label>
                    <input type="text" name="nom" value="{{ old('nom') }}" required maxlength="255"
                           placeholder="Ex: Essilor, Ray-Ban, Silmo…"
                           style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe;
                                  background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none;
                                  font-family:'Plus Jakarta Sans',sans-serif;">
                </div>
                <button type="submit"
                        style="width:100%; padding:12px; border-radius:12px; background:#1d4ed8; color:#fff;
                               border:none; font-size:16px; font-weight:700; cursor:pointer;
                               font-family:'Plus Jakarta Sans',sans-serif; box-shadow:0 4px 12px rgba(29,78,216,0.3);">
                    Ajouter
                </button>
            </form>
        </div>

        {{-- Liste --}}
        <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe;
                    padding:24px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
            <h2 style="font-size:18px; font-weight:700; color:#0f172a; margin:0 0 16px;">
                Liste ({{ $societes->total() }})
            </h2>
            @forelse($societes as $societe)
            <div style="display:flex; align-items:center; justify-content:space-between;
                        padding:12px 0; border-bottom:1px solid #f0f7ff;">
                <div>
                    <p style="font-size:15px; font-weight:700; color:#0f172a; margin:0;">{{ $societe->nom }}</p>
                    <p style="font-size:13px; color:#94a3b8; margin:2px 0 0;">
                        {{ $societe->produits_count }} article(s)
                    </p>
                </div>
                @if($societe->produits_count === 0)
                <form method="POST" action="{{ route('societes.destroy', $societe) }}"
                      onsubmit="return confirm('Supprimer {{ $societe->nom }} ?')" style="margin:0;">
                    @csrf @method('DELETE')
                    <button type="submit"
                            style="width:34px; height:34px; display:flex; align-items:center; justify-content:center;
                                   border-radius:9px; background:#fff0f0; border:1px solid #fca5a5; cursor:pointer;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2.5">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a1 1 0 011-1h4a1 1 0 011 1v2"/>
                        </svg>
                    </button>
                </form>
                @else
                <span style="font-size:12px; color:#94a3b8; font-style:italic;">lié à des articles</span>
                @endif
            </div>
            @empty
            <p style="color:#94a3b8; font-size:15px; text-align:center; padding:20px 0;">Aucune société enregistrée</p>
            @endforelse

            @if($societes->hasPages())
            <div style="margin-top:16px;">{{ $societes->links() }}</div>
            @endif
        </div>

    </div>

</div>

</x-layouts.app>
