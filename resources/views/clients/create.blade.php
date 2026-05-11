<x-layouts.app title="Nouveau client — OptiGest">

    <div style="max-width:80%; margin:0 auto;">

        {{-- Header --}}
        <div style="display:flex; align-items:center; gap:16px; margin-bottom:32px;">
            <a href="{{ route('clients.index') }}"
               style="width:44px; height:44px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f0f7ff; display:flex; align-items:center; justify-content:center; flex-shrink:0; text-decoration:none;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="2.5">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0;">Nouveau client</h1>
                <p style="font-size:16px; color:#94a3b8; margin:6px 0 0;">Remplissez les informations du client</p>
            </div>
        </div>

        <form method="POST" action="{{ route('clients.store') }}">
            @csrf

            <div style="display:grid; grid-template-columns:1fr 340px; gap:24px; align-items:start;">

                {{-- Colonne principale --}}
                <div style="display:flex; flex-direction:column; gap:24px;">

                    {{-- Identité --}}
                    <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:28px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                        <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px; padding-bottom:16px; border-bottom:1.5px solid #f0f7ff;">
                            <div style="width:34px; height:34px; border-radius:10px; background:#dbeafe; display:flex; align-items:center; justify-content:center;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="2.2">
                                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>
                                </svg>
                            </div>
                            <h2 style="font-size:18px; font-weight:700; color:#0f172a; margin:0;">Identité</h2>
                        </div>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">

                            <div>
                                <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Prénom <span style="color:#ef4444;">*</span></label>
                                <input type="text" name="prenom" value="{{ old('prenom') }}" placeholder="Ex: Fatima"
                                       style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                                @error('prenom')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Nom <span style="color:#ef4444;">*</span></label>
                                <input type="text" name="nom" value="{{ old('nom') }}" placeholder="Ex: Benali"
                                       style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                                @error('nom')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">CIN <span style="color:#ef4444;">*</span></label>
                                <input type="text" name="cin" value="{{ old('cin') }}" placeholder="Ex: BE123456"
                                       style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; font-family:monospace; letter-spacing:2px; box-sizing:border-box;">
                                @error('cin')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Genre</label>
                                <select name="genre"
                                        style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                                    <option value="">-- Sélectionner --</option>
                                    <option value="homme" {{ old('genre')=='homme'?'selected':'' }}>Homme</option>
                                    <option value="femme" {{ old('genre')=='femme'?'selected':'' }}>Femme</option>
                                </select>
                            </div>

                            <div>
                                <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Date de naissance</label>
                                <input type="date" name="date_naissance" value="{{ old('date_naissance') }}"
                                       style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                            </div>

                            <div>
                                <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Type <span style="color:#ef4444;">*</span></label>
                                <select name="type"
                                        style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                                    <option value="nouveau" {{ old('type','nouveau')=='nouveau'?'selected':'' }}>Nouveau client</option>
                                    <option value="ancien" {{ old('type')=='ancien'?'selected':'' }}>Ancien client</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    {{-- Contact --}}
                    <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:28px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                        <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px; padding-bottom:16px; border-bottom:1.5px solid #f0f7ff;">
                            <div style="width:34px; height:34px; border-radius:10px; background:#dcfce7; display:flex; align-items:center; justify-content:center;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.2">
                                    <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 13.1 19.79 19.79 0 01.18 4.5 2 2 0 012.18 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L6.91 9.5a16 16 0 006.59 6.59l1.06-1.06a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/>
                                </svg>
                            </div>
                            <h2 style="font-size:18px; font-weight:700; color:#0f172a; margin:0;">Contact</h2>
                        </div>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">

                            <div>
                                <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Téléphone <span style="color:#ef4444;">*</span></label>
                                <input type="text" name="telephone" value="{{ old('telephone') }}" placeholder="Ex: 0661234567"
                                       style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                                @error('telephone')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="Ex: client@email.com"
                                       style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                                @error('email')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                            </div>

                            <div style="grid-column:1/-1;">
                                <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Adresse</label>
                                <input type="text" name="adresse" value="{{ old('adresse') }}" placeholder="Ex: 12 rue Hassan II, Rabat"
                                       style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                            </div>

                        </div>
                    </div>
                    {{-- Mutuelle --}}
                    <div>
                        <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">
                            Mutuelle <span style="color:#ef4444;">*</span>
                        </label>
                        <select name="mutuelle_type" id="mutuelle_type" onchange="toggleMutuelleAutre()"
                                style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                            <option value="aucune" {{ old('mutuelle_type','aucune')=='aucune'?'selected':'' }}>Aucune</option>
                            <option value="cnops"  {{ old('mutuelle_type')=='cnops'?'selected':'' }}>CNOPS</option>
                            <option value="cnss"   {{ old('mutuelle_type')=='cnss'?'selected':'' }}>CNSS</option>
                            <option value="autre"  {{ old('mutuelle_type')=='autre'?'selected':'' }}>Autre</option>
                        </select>
                        @error('mutuelle_type')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                    </div>

                    <div id="mutuelle_autre_div" style="display:{{ old('mutuelle_type')=='autre' ? 'block' : 'none' }};">
                        <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">
                            Préciser la mutuelle <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="text" name="mutuelle_autre" value="{{ old('mutuelle_autre') }}"
                            placeholder="Ex: MGPAP, FAR, Police..."
                            style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                        @error('mutuelle_autre')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                    </div>

                    {{-- Observations --}}
                    <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:28px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                        <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px; padding-bottom:16px; border-bottom:1.5px solid #f0f7ff;">
                            <div style="width:34px; height:34px; border-radius:10px; background:#fefce8; display:flex; align-items:center; justify-content:center;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ca8a04" stroke-width="2.2">
                                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                    <line x1="16" y1="13" x2="8" y2="13"/>
                                    <line x1="16" y1="17" x2="8" y2="17"/>
                                </svg>
                            </div>
                            <h2 style="font-size:18px; font-weight:700; color:#0f172a; margin:0;">Observations</h2>
                        </div>
                        <textarea name="observations" rows="4" placeholder="Notes, remarques sur le client..."
                                  style="width:100%; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:14px 16px; font-size:16px; color:#0f172a; outline:none; resize:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">{{ old('observations') }}</textarea>
                    </div>

                </div>

                {{-- Colonne droite --}}
                <div style="display:flex; flex-direction:column; gap:20px; position:sticky; top:16px;">

                    {{-- N° Classement --}}
                    <div style="border-radius:18px; border:2px solid #93c5fd; padding:24px; background:linear-gradient(135deg,#eff6ff,#dbeeff); box-shadow:0 4px 20px rgba(29,78,216,0.12);">
                        <div style="display:flex; align-items:center; gap:14px; margin-bottom:14px;">
                            <div style="width:42px; height:42px; border-radius:12px; background:#1d4ed8; display:flex; align-items:center; justify-content:center; flex-shrink:0; box-shadow:0 3px 10px rgba(29,78,216,0.35);">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                </svg>
                            </div>
                            <div>
                                <p style="font-size:17px; font-weight:700; color:#0f172a; margin:0;">N° Classement</p>
                                <p style="font-size:14px; color:#60a5fa; margin:3px 0 0;">Lien avec le registre papier</p>
                            </div>
                        </div>
                        <p style="font-size:14px; color:#64748b; margin-bottom:16px; line-height:1.7;">
                            Numéro correspondant à la page ou ligne dans votre registre papier.
                        </p>
                        <input type="text" name="classement_registre" value="{{ old('classement_registre') }}" placeholder="0042"
                               style="width:100%; height:58px; border-radius:12px; border:2px solid #93c5fd; background:#fff; font-size:24px; font-weight:800; color:#1d4ed8; text-align:center; font-family:monospace; letter-spacing:6px; outline:none; box-sizing:border-box; box-shadow:0 2px 8px rgba(29,78,216,0.1);">
                        @error('classement_registre')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                    </div>

                    {{-- Boutons --}}
                    <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:22px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                        <button type="submit"
                                style="width:100%; height:52px; border-radius:12px; background:#1d4ed8; border:none; color:#fff; font-size:16px; font-weight:700; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:10px; margin-bottom:12px; box-shadow:0 4px 14px rgba(29,78,216,0.35); font-family:'Plus Jakarta Sans',sans-serif;">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                                <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                                <polyline points="17 21 17 13 7 13 7 21"/>
                                <polyline points="7 3 7 8 15 8"/>
                            </svg>
                            Enregistrer le client
                        </button>
                        <a href="{{ route('clients.index') }}"
                           style="display:block; height:48px; border-radius:12px; border:1.5px solid #e2e8f0; color:#64748b; font-size:16px; font-weight:600; text-align:center; line-height:48px; text-decoration:none; background:#f8fafc;">
                            Annuler
                        </a>
                    </div>

                    {{-- Info --}}
                    <div style="border-radius:12px; border:1px solid #bfdbfe; padding:14px 16px; background:#f0f7ff; display:flex; align-items:center; gap:10px;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#93c5fd" stroke-width="2.2" style="flex-shrink:0;">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="12"/>
                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        <p style="font-size:14px; color:#60a5fa; margin:0;">Les champs <span style="color:#ef4444; font-weight:700;">*</span> sont obligatoires.</p>
                    </div>

                </div>

            </div>
        </form>
    </div>
    <script>
        function toggleMutuelleAutre() {
            const select = document.getElementById('mutuelle_type');
            const div    = document.getElementById('mutuelle_autre_div');
            div.style.display = select.value === 'autre' ? 'block' : 'none';
        }
    </script>

</x-layouts.app>
