<x-layouts.app title="Modifier utilisateur — OptiGest">

    <div style="max-width:60%; margin:0 auto;">

        <div style="display:flex; align-items:center; gap:16px; margin-bottom:32px;">
            <a href="{{ route('admin.users.index') }}"
               style="width:44px; height:44px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f0f7ff; display:flex; align-items:center; justify-content:center; flex-shrink:0; text-decoration:none;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="2.5">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0;">Modifier — {{ $user->name }}</h1>
                <p style="font-size:16px; color:#94a3b8; margin:6px 0 0;">{{ $user->email }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')

            {{-- Infos générales --}}
            <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:28px; box-shadow:0 4px 14px rgba(29,78,216,0.07); margin-bottom:24px;">
                <h2 style="font-size:18px; font-weight:700; color:#0f172a; margin:0 0 24px; padding-bottom:16px; border-bottom:1.5px solid #f0f7ff;">Informations</h2>

                <div style="display:flex; flex-direction:column; gap:20px;">

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                        <div>
                            <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Nom complet <span style="color:#ef4444;">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                   style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                            @error('name')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Rôle <span style="color:#ef4444;">*</span></label>
                            <select name="role"
                                    style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                                <option value="admin" {{ old('role',$user->role)=='admin'?'selected':'' }}>Admin</option>
                                <option value="opticien" {{ old('role',$user->role)=='opticien'?'selected':'' }}>Opticien</option>
                                <option value="employe" {{ old('role',$user->role)=='employe'?'selected':'' }}>Employé</option>
                            </select>
                            @error('role')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Adresse email <span style="color:#ef4444;">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                               style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                        @error('email')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                    </div>

                    {{-- Statut --}}
                    @if($user->id !== auth()->id())
                    <div style="display:flex; align-items:center; gap:12px; padding:16px; border-radius:12px; background:#f8fbff; border:1.5px solid #bfdbfe;">
                        <input type="checkbox" name="is_active" id="is_active" value="1"
                               {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                               style="width:20px; height:20px; accent-color:#1d4ed8; cursor:pointer;">
                        <label for="is_active" style="font-size:15px; font-weight:600; color:#334155; cursor:pointer;">
                            Compte actif
                        </label>
                        <span style="font-size:14px; color:#94a3b8;">— Décochez pour désactiver l'accès</span>
                    </div>
                    @endif

                </div>
            </div>

            {{-- Changer mot de passe --}}
            <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:28px; box-shadow:0 4px 14px rgba(29,78,216,0.07); margin-bottom:24px;">
                <h2 style="font-size:18px; font-weight:700; color:#0f172a; margin:0 0 8px;">Changer le mot de passe</h2>
                <p style="font-size:14px; color:#94a3b8; margin:0 0 20px;">Laissez vide pour conserver le mot de passe actuel</p>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                    <div>
                        <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Nouveau mot de passe</label>
                        <input type="password" name="password" placeholder="Minimum 8 caractères"
                               style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                        @error('password')<p style="font-size:14px; color:#ef4444; margin:8px 0 0;">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" placeholder="Répéter le mot de passe"
                               style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                    </div>
                </div>
            </div>

            <div style="display:flex; gap:12px; justify-content:flex-end;">
                <a href="{{ route('admin.users.index') }}"
                   style="height:52px; padding:0 28px; border-radius:12px; border:1.5px solid #e2e8f0; color:#64748b; font-size:16px; font-weight:600; text-decoration:none; display:flex; align-items:center; background:#f8fafc;">
                    Annuler
                </a>
                <button type="submit"
                        style="height:52px; padding:0 32px; border-radius:12px; background:#1d4ed8; border:none; color:#fff; font-size:16px; font-weight:700; cursor:pointer; box-shadow:0 4px 14px rgba(29,78,216,0.35); font-family:'Plus Jakarta Sans',sans-serif;">
                    Enregistrer les modifications
                </button>
            </div>

        </form>
    </div>

</x-layouts.app>
