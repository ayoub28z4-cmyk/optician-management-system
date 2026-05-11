<x-layouts.app title="Nouveau RDV — OptiGest">

    <div style="max-width:60%; margin:0 auto;">

        <div style="display:flex; align-items:center; gap:16px; margin-bottom:32px;">
            <a href="{{ route('rendez-vous.index') }}"
               style="width:44px; height:44px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f0f7ff; display:flex; align-items:center; justify-content:center; flex-shrink:0; text-decoration:none;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="2.5">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0;">Nouveau rendez-vous</h1>
                <p style="font-size:16px; color:#94a3b8; margin:6px 0 0;">Planifiez un rendez-vous client</p>
            </div>
        </div>

        <form method="POST" action="{{ route('rendez-vous.store') }}">
            @csrf

            <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:28px; box-shadow:0 4px 14px rgba(29,78,216,0.07); margin-bottom:24px;">
                <h2 style="font-size:18px; font-weight:700; color:#0f172a; margin:0 0 24px; padding-bottom:16px; border-bottom:1.5px solid #f0f7ff;">Informations du rendez-vous</h2>

                <div style="display:flex; flex-direction:column; gap:20px;">

                    <div>
                        <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Client <span style="color:#ef4444;">*</span></label>
                        <select name="client_id"
                                style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                            <option value="">-- Sélectionner un client --</option>
                            @foreach($clients as $c)
                            <option value="{{ $c->id }}" {{ (old('client_id') == $c->id || ($client && $client->id == $c->id)) ? 'selected' : '' }}>
                                {{ $c->nom_complet }} — {{ $c->classement_registre ?? 'N/A' }}
                            </option>
                            @endforeach
                        </select>
                        @error('client_id')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                        <div>
                            <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Date et heure <span style="color:#ef4444;">*</span></label>
                            <input type="datetime-local" name="date_heure" value="{{ old('date_heure') }}"
                                   style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                            @error('date_heure')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Statut</label>
                            <select name="statut"
                                    style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                                <option value="planifie">Planifié</option>
                                <option value="confirme">Confirmé</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Motif <span style="color:#ef4444;">*</span></label>
                        <input type="text" name="motif" value="{{ old('motif') }}" placeholder="Ex: Contrôle de vue, Livraison lunettes..."
                               style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                        @error('motif')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Commentaire</label>
                        <textarea name="commentaire" rows="3" placeholder="Notes supplémentaires..."
                                  style="width:100%; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:14px 16px; font-size:16px; color:#0f172a; outline:none; resize:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">{{ old('commentaire') }}</textarea>
                    </div>

                </div>
            </div>

            <div style="display:flex; gap:12px; justify-content:flex-end;">
                <a href="{{ route('rendez-vous.index') }}"
                   style="height:52px; padding:0 28px; border-radius:12px; border:1.5px solid #e2e8f0; color:#64748b; font-size:16px; font-weight:600; text-decoration:none; display:flex; align-items:center; background:#f8fafc;">
                    Annuler
                </a>
                <button type="submit"
                        style="height:52px; padding:0 32px; border-radius:12px; background:#1d4ed8; border:none; color:#fff; font-size:16px; font-weight:700; cursor:pointer; box-shadow:0 4px 14px rgba(29,78,216,0.35); font-family:'Plus Jakarta Sans',sans-serif;">
                    Enregistrer le RDV
                </button>
            </div>

        </form>
    </div>

</x-layouts.app>
