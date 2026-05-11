<x-layouts.app title="Utilisateurs — OptiGest">

    <div style="max-width:90%; margin:0 auto;">

        {{-- Header --}}
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:32px;">
            <div>
                <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0;">Gestion des utilisateurs</h1>
                <p style="font-size:16px; color:#94a3b8; margin:6px 0 0;">{{ $users->total() }} utilisateur(s) enregistré(s)</p>
            </div>
            <a href="{{ route('admin.users.create') }}"
               style="display:flex; align-items:center; gap:8px; padding:12px 22px; border-radius:12px;
                      background:#1d4ed8; color:#fff; font-size:15px; font-weight:700; text-decoration:none;
                      box-shadow:0 4px 14px rgba(29,78,216,0.35);">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Nouvel utilisateur
            </a>
        </div>

        {{-- Messages --}}
        @if(session('success'))
        <div style="margin-bottom:20px; padding:14px 18px; border-radius:12px;
                    background:#dcfce7; color:#16a34a; border:1px solid #bbf7d0;
                    font-size:15px; font-weight:600;">
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div style="margin-bottom:20px; padding:14px 18px; border-radius:12px;
                    background:#fee2e2; color:#ef4444; border:1px solid #fecaca;
                    font-size:15px; font-weight:600;">
            {{ session('error') }}
        </div>
        @endif

        {{-- Tableau --}}
        <div style="border-radius:16px; border:1px solid #bfdbfe; overflow:hidden;
                    background:#fff; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="background:#f0f7ff; border-bottom:1.5px solid #dbeafe;">
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Utilisateur</th>
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Email</th>
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Rôle</th>
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Statut</th>
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Créé le</th>
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    @php
                        $roleColors = [
                            'admin'    => ['bg'=>'#f5f3ff','color'=>'#7c3aed','label'=>'Admin'],
                            'opticien' => ['bg'=>'#dbeafe','color'=>'#1d4ed8','label'=>'Opticien'],
                            'employe'  => ['bg'=>'#dcfce7','color'=>'#16a34a','label'=>'Employé'],
                        ];
                        $rc = $roleColors[$user->role] ?? ['bg'=>'#f1f5f9','color'=>'#64748b','label'=>'—'];
                    @endphp
                    <tr style="border-bottom:1px solid #f1f5f9;"
                        onmouseover="this.style.background='#f8faff'" onmouseout="this.style.background='#fff'">

                        <td style="padding:16px 20px;">
                            <div style="display:flex; align-items:center; gap:12px;">
                                <div style="width:40px; height:40px; border-radius:50%; background:#1d4ed8;
                                            display:flex; align-items:center; justify-content:center;
                                            font-size:14px; font-weight:800; color:#fff; flex-shrink:0;
                                            box-shadow:0 2px 8px rgba(29,78,216,0.3);">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div style="font-size:15px; font-weight:700; color:#0f172a;">{{ $user->name }}</div>
                                    @if($user->id === auth()->id())
                                    <div style="font-size:12px; color:#1d4ed8; font-weight:600;">Vous</div>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <td style="padding:16px 20px; font-size:15px; color:#334155;">
                            {{ $user->email }}
                        </td>

                        <td style="padding:16px 20px;">
                            <span style="font-size:13px; font-weight:700; padding:5px 14px; border-radius:99px;
                                         background:{{ $rc['bg'] }}; color:{{ $rc['color'] }};">
                                {{ $rc['label'] }}
                            </span>
                        </td>

                        <td style="padding:16px 20px;">
                            <span style="font-size:13px; font-weight:700; padding:5px 14px; border-radius:99px;
                                         {{ $user->is_active ? 'background:#dcfce7; color:#16a34a;' : 'background:#fee2e2; color:#ef4444;' }}">
                                {{ $user->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>

                        <td style="padding:16px 20px; font-size:15px; color:#64748b;">
                            {{ $user->created_at->format('d/m/Y') }}
                        </td>

                        <td style="padding:16px 20px;">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   style="padding:7px 16px; border-radius:8px; border:1.5px solid #bfdbfe;
                                          color:#1d4ed8; font-size:14px; font-weight:600; text-decoration:none;
                                          background:#f0f7ff;">
                                    Modifier
                                </a>
                                @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                      onsubmit="return confirm('{{ $user->is_active ? 'Désactiver' : 'Activer' }} cet utilisateur ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            style="padding:7px 16px; border-radius:8px; font-size:14px; font-weight:600; cursor:pointer;
                                                   font-family:'Plus Jakarta Sans',sans-serif;
                                                   {{ $user->is_active ? 'border:1.5px solid #fecaca; color:#ef4444; background:#fff5f5;' : 'border:1.5px solid #bbf7d0; color:#16a34a; background:#f0fdf4;' }}">
                                        {{ $user->is_active ? 'Désactiver' : 'Activer' }}
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding:60px 20px; text-align:center; font-size:16px; color:#94a3b8;">
                            Aucun utilisateur trouvé
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            @if($users->hasPages())
            <div style="padding:16px 20px; border-top:1px solid #f0f7ff;">
                {{ $users->links() }}
            </div>
            @endif
        </div>

    </div>

</x-layouts.app>
