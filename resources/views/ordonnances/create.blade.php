<x-layouts.app title="Nouvelle ordonnance — OptiGest">

    <div style="max-width:80%; margin:0 auto;">

        {{-- Header --}}
        <div style="display:flex; align-items:center; gap:16px; margin-bottom:32px;">
            <a href="{{ route('clients.ordonnances.index', $client) }}"
               style="width:44px; height:44px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f0f7ff; display:flex; align-items:center; justify-content:center; flex-shrink:0; text-decoration:none;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="2.5">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0;">Nouvelle ordonnance</h1>
                <p style="font-size:16px; color:#94a3b8; margin:6px 0 0;">
                    Client : <span style="color:#1d4ed8; font-weight:700;">{{ $client->nom_complet }}</span>
                </p>
            </div>
        </div>

        <form method="POST" action="{{ route('clients.ordonnances.store', $client) }}">
            @csrf
            <input type="hidden" name="client_id" value="{{ $client->id }}">

            <div style="display:flex; flex-direction:column; gap:24px;">

                {{-- Informations générales --}}
                <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:28px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                    <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px; padding-bottom:16px; border-bottom:1.5px solid #f0f7ff;">
                        <div style="width:34px; height:34px; border-radius:10px; background:#dbeafe; display:flex; align-items:center; justify-content:center;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="2.2">
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                            </svg>
                        </div>
                        <h2 style="font-size:18px; font-weight:700; color:#0f172a; margin:0;">Informations générales</h2>
                    </div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                        <div>
                            <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Date de l'ordonnance <span style="color:#ef4444;">*</span></label>
                            <input type="date" name="date_ordonnance" value="{{ old('date_ordonnance', date('Y-m-d')) }}"
                                   style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                            @error('date_ordonnance')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Médecin prescripteur</label>
                            <input type="text" name="medecin" value="{{ old('medecin') }}" placeholder="Ex: Dr. Hassan Alami"
                                   style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                        </div>
                    </div>
                </div>

                {{-- Oeil droit --}}
                <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:28px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                    <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px; padding-bottom:16px; border-bottom:1.5px solid #f0f7ff;">
                        <div style="width:34px; height:34px; border-radius:10px; background:#dbeafe; display:flex; align-items:center; justify-content:center;">
                            <span style="font-size:16px; font-weight:800; color:#1d4ed8;">OD</span>
                        </div>
                        <h2 style="font-size:18px; font-weight:700; color:#0f172a; margin:0;">Oeil droit (OD)</h2>
                    </div>
                    <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:20px;">
                        <div>
                            <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Sphère</label>
                            <input type="number" step="0.25" name="od_sphere" value="{{ old('od_sphere') }}" placeholder="Ex: -2.50"
                                   style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                            @error('od_sphere')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Cylindre</label>
                            <input type="number" step="0.25" name="od_cylindre" value="{{ old('od_cylindre') }}" placeholder="Ex: -0.75"
                                   style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                            @error('od_cylindre')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Axe</label>
                            <input type="number" step="1" name="od_axe" value="{{ old('od_axe') }}" placeholder="Ex: 90"
                                   style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                            @error('od_axe')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                {{-- Oeil gauche --}}
                <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:28px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                    <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px; padding-bottom:16px; border-bottom:1.5px solid #f0f7ff;">
                        <div style="width:34px; height:34px; border-radius:10px; background:#dcfce7; display:flex; align-items:center; justify-content:center;">
                            <span style="font-size:16px; font-weight:800; color:#16a34a;">OG</span>
                        </div>
                        <h2 style="font-size:18px; font-weight:700; color:#0f172a; margin:0;">Oeil gauche (OG)</h2>
                    </div>
                    <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:20px;">
                        <div>
                            <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Sphère</label>
                            <input type="number" step="0.25" name="og_sphere" value="{{ old('og_sphere') }}" placeholder="Ex: -1.75"
                                   style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                            @error('og_sphere')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Cylindre</label>
                            <input type="number" step="0.25" name="og_cylindre" value="{{ old('og_cylindre') }}" placeholder="Ex: -0.50"
                                   style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                            @error('og_cylindre')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Axe</label>
                            <input type="number" step="1" name="og_axe" value="{{ old('og_axe') }}" placeholder="Ex: 85"
                                   style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                            @error('og_axe')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                {{-- Général + Remarques --}}
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">

                    <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:28px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                        <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px; padding-bottom:16px; border-bottom:1.5px solid #f0f7ff;">
                            <div style="width:34px; height:34px; border-radius:10px; background:#f5f3ff; display:flex; align-items:center; justify-content:center;">
                                <span style="font-size:14px; font-weight:800; color:#7c3aed;">EP</span>
                            </div>
                            <h2 style="font-size:18px; font-weight:700; color:#0f172a; margin:0;">Général</h2>
                        </div>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                            <div>
                                <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Addition</label>
                                <input type="number" step="0.25" name="addition" value="{{ old('addition') }}" placeholder="Ex: +1.50"
                                       style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                            </div>
                            <div>
                                <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Écart pupillaire</label>
                                <input type="number" step="0.5" name="ecart_pupillaire" value="{{ old('ecart_pupillaire') }}" placeholder="Ex: 64"
                                       style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                            </div>
                        </div>
                    </div>

                    <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:28px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                        <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px; padding-bottom:16px; border-bottom:1.5px solid #f0f7ff;">
                            <div style="width:34px; height:34px; border-radius:10px; background:#fefce8; display:flex; align-items:center; justify-content:center;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ca8a04" stroke-width="2.2">
                                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                    <line x1="16" y1="13" x2="8" y2="13"/>
                                </svg>
                            </div>
                            <h2 style="font-size:18px; font-weight:700; color:#0f172a; margin:0;">Remarques</h2>
                        </div>
                        <textarea name="remarques" rows="3" placeholder="Remarques techniques, notes..."
                                  style="width:100%; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:14px 16px; font-size:16px; color:#0f172a; outline:none; resize:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">{{ old('remarques') }}</textarea>
                    </div>

                </div>

                {{-- Boutons --}}
                <div style="display:flex; gap:12px; justify-content:flex-end;">
                    <a href="{{ route('clients.ordonnances.index', $client) }}"
                       style="height:52px; padding:0 28px; border-radius:12px; border:1.5px solid #e2e8f0; color:#64748b; font-size:16px; font-weight:600; text-decoration:none; display:flex; align-items:center; background:#f8fafc;">
                        Annuler
                    </a>
                    <button type="submit"
                            style="height:52px; padding:0 32px; border-radius:12px; background:#1d4ed8; border:none; color:#fff; font-size:16px; font-weight:700; cursor:pointer; display:flex; align-items:center; gap:10px; box-shadow:0 4px 14px rgba(29,78,216,0.35); font-family:'Plus Jakarta Sans',sans-serif;">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                            <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/>
                            <polyline points="7 3 7 8 15 8"/>
                        </svg>
                        Enregistrer l'ordonnance
                    </button>
                </div>

            </div>
        </form>
    </div>

</x-layouts.app>
