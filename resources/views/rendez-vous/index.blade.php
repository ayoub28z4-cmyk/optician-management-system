<x-layouts.app title="Rendez-vous — OptiGest">

    <div style="max-width:90%; margin:0 auto;">

        {{-- Header --}}
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:32px;">
            <div>
                <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0;">Rendez-vous</h1>
                <p style="font-size:16px; color:#94a3b8; margin:6px 0 0;">Planning et suivi des rendez-vous</p>
            </div>
            <a href="{{ route('rendez-vous.create') }}"
               style="display:flex; align-items:center; gap:8px; padding:12px 22px; border-radius:12px;
                      background:#1d4ed8; color:#fff; font-size:15px; font-weight:700; text-decoration:none;
                      box-shadow:0 4px 14px rgba(29,78,216,0.35);">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Nouveau RDV
            </a>
        </div>

        {{-- RDV du jour --}}
        @if($aujourdhui->count() > 0)
        <div style="background:linear-gradient(135deg,#eff6ff,#dbeeff); border-radius:18px; border:2px solid #93c5fd; padding:24px; margin-bottom:24px; box-shadow:0 4px 20px rgba(29,78,216,0.10);">
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:16px;">
                <div style="width:36px; height:36px; border-radius:10px; background:#1d4ed8; display:flex; align-items:center; justify-content:center; box-shadow:0 3px 10px rgba(29,78,216,0.35);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.2">
                        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <h2 style="font-size:18px; font-weight:700; color:#0f172a; margin:0;">
                    Aujourd'hui — {{ now()->locale('fr')->isoFormat('dddd D MMMM') }}
                </h2>
                <span style="background:#1d4ed8; color:#fff; font-size:13px; font-weight:700; padding:3px 10px; border-radius:99px;">
                    {{ $aujourdhui->count() }} RDV
                </span>
            </div>
            <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px, 1fr)); gap:12px;">
                @foreach($aujourdhui as $rdv)
                @php
                    $statutColors = [
                        'planifie'  => ['bg'=>'#dbeafe','color'=>'#1d4ed8'],
                        'confirme'  => ['bg'=>'#dcfce7','color'=>'#16a34a'],
                        'annule'    => ['bg'=>'#fee2e2','color'=>'#ef4444'],
                        'termine'   => ['bg'=>'#f1f5f9','color'=>'#64748b'],
                    ];
                    $sc = $statutColors[$rdv->statut] ?? ['bg'=>'#f1f5f9','color'=>'#64748b'];
                @endphp
                <div style="background:#fff; border-radius:12px; border:1.5px solid #bfdbfe; padding:16px; box-shadow:0 2px 8px rgba(29,78,216,0.07);">
                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">
                        <span style="font-size:20px; font-weight:800; color:#1d4ed8;">{{ $rdv->heure }}</span>
                        <span style="font-size:12px; font-weight:700; padding:3px 10px; border-radius:99px; background:{{ $sc['bg'] }}; color:{{ $sc['color'] }};">
                            {{ ucfirst($rdv->statut) }}
                        </span>
                    </div>
                    <p style="font-size:15px; font-weight:700; color:#0f172a; margin:0 0 4px;">{{ $rdv->client->nom_complet }}</p>
                    <p style="font-size:14px; color:#64748b; margin:0;">{{ $rdv->motif }}</p>
                    <div style="display:flex; gap:8px; margin-top:10px;">
                        <a href="{{ route('rendez-vous.edit', $rdv) }}"
                           style="font-size:13px; font-weight:600; color:#1d4ed8; text-decoration:none; padding:5px 12px; border-radius:8px; background:#eff6ff; border:1px solid #bfdbfe;">
                            Modifier
                        </a>
                        <form method="POST" action="{{ route('rendez-vous.destroy', $rdv) }}" onsubmit="return confirm('Supprimer ?')">
                            @csrf @method('DELETE')
                            <button type="submit" style="font-size:13px; font-weight:600; color:#ef4444; padding:5px 12px; border-radius:8px; background:#fff5f5; border:1px solid #fecaca; cursor:pointer; font-family:'Plus Jakarta Sans',sans-serif;">
                                Annuler
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Filtres --}}
        <form method="GET" action="{{ route('rendez-vous.index') }}"
              style="display:flex; align-items:center; gap:12px; margin-bottom:24px; padding:16px 20px;
                     border-radius:14px; border:1px solid #bfdbfe; background:#f0f7ff;">

            <div style="display:flex; align-items:center; gap:10px; height:48px; padding:0 16px;
                        border-radius:12px; border:1.5px solid #bfdbfe; background:#fff;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#93c5fd" stroke-width="2.5" style="flex-shrink:0;">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                <input type="date" name="date" value="{{ request('date') }}"
                       style="background:transparent; border:none; outline:none; font-size:15px; color:#334155; font-family:'Plus Jakarta Sans',sans-serif;">
            </div>

            <select name="statut"
                    style="height:48px; padding:0 16px; border-radius:12px; border:1.5px solid #bfdbfe;
                           background:#fff; font-size:15px; color:#334155; outline:none;
                           font-family:'Plus Jakarta Sans',sans-serif; min-width:180px;">
                <option value="">Tous les statuts</option>
                <option value="planifie" {{ request('statut')=='planifie'?'selected':'' }}>Planifié</option>
                <option value="confirme" {{ request('statut')=='confirme'?'selected':'' }}>Confirmé</option>
                <option value="annule" {{ request('statut')=='annule'?'selected':'' }}>Annulé</option>
                <option value="termine" {{ request('statut')=='termine'?'selected':'' }}>Terminé</option>
            </select>

            <button type="submit"
                    style="height:48px; padding:0 24px; border-radius:12px; border:none;
                           background:#1d4ed8; color:#fff; font-size:15px; font-weight:700; cursor:pointer;
                           font-family:'Plus Jakarta Sans',sans-serif;">
                Filtrer
            </button>

            @if(request('date') || request('statut'))
            <a href="{{ route('rendez-vous.index') }}"
               style="height:48px; padding:0 18px; border-radius:12px; border:1.5px solid #e2e8f0;
                      background:#fff; color:#64748b; font-size:15px; font-weight:600;
                      text-decoration:none; display:flex; align-items:center;">
                Réinitialiser
            </a>
            @endif
        </form>

        {{-- Message succès --}}
        @if(session('success'))
        <div style="margin-bottom:20px; padding:14px 18px; border-radius:12px;
                    background:#dcfce7; color:#16a34a; border:1px solid #bbf7d0;
                    font-size:15px; font-weight:600;">
            {{ session('success') }}
        </div>
        @endif

        {{-- Liste RDV --}}
        <div style="border-radius:16px; border:1px solid #bfdbfe; overflow:hidden;
                    background:#fff; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="background:#f0f7ff; border-bottom:1.5px solid #dbeafe;">
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Date & Heure</th>
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Client</th>
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Motif</th>
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Statut</th>
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Créé par</th>
                        <th style="text-align:left; padding:14px 20px; font-size:14px; font-weight:700; color:#64748b;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rendezVous as $rdv)
                    @php
                        $statutColors = [
                            'planifie'  => ['bg'=>'#dbeafe','color'=>'#1d4ed8','label'=>'Planifié'],
                            'confirme'  => ['bg'=>'#dcfce7','color'=>'#16a34a','label'=>'Confirmé'],
                            'annule'    => ['bg'=>'#fee2e2','color'=>'#ef4444','label'=>'Annulé'],
                            'termine'   => ['bg'=>'#f1f5f9','color'=>'#64748b','label'=>'Terminé'],
                        ];
                        $sc = $statutColors[$rdv->statut] ?? ['bg'=>'#f1f5f9','color'=>'#64748b','label'=>'—'];
                    @endphp
                    <tr style="border-bottom:1px solid #f1f5f9;"
                        onmouseover="this.style.background='#f8faff'" onmouseout="this.style.background='#fff'">

                        <td style="padding:16px 20px;">
                            <div style="font-size:16px; font-weight:800; color:#1d4ed8;">{{ $rdv->heure }}</div>
                            <div style="font-size:14px; color:#94a3b8; margin-top:2px;">{{ $rdv->date }}</div>
                        </td>

                        <td style="padding:16px 20px;">
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div style="width:36px; height:36px; border-radius:50%; background:#dbeafe;
                                            display:flex; align-items:center; justify-content:center;
                                            font-size:13px; font-weight:800; color:#1d4ed8; flex-shrink:0;">
                                    {{ $rdv->client->initiales }}
                                </div>
                                <div>
                                    <div style="font-size:15px; font-weight:700; color:#0f172a;">{{ $rdv->client->nom_complet }}</div>
                                    <div style="font-size:13px; color:#94a3b8;">{{ $rdv->client->telephone }}</div>
                                </div>
                            </div>
                        </td>

                        <td style="padding:16px 20px; font-size:15px; color:#334155; font-weight:600;">
                            {{ $rdv->motif }}
                            @if($rdv->commentaire)
                            <div style="font-size:13px; color:#94a3b8; margin-top:2px;">{{ Str::limit($rdv->commentaire, 50) }}</div>
                            @endif
                        </td>

                        <td style="padding:16px 20px;">
                            <span style="font-size:13px; font-weight:700; padding:5px 14px; border-radius:99px;
                                         background:{{ $sc['bg'] }}; color:{{ $sc['color'] }};">
                                {{ $sc['label'] }}
                            </span>
                        </td>

                        <td style="padding:16px 20px;">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <div style="width:28px; height:28px; border-radius:50%; background:#f1f5f9;
                                            display:flex; align-items:center; justify-content:center;
                                            font-size:11px; font-weight:800; color:#64748b; flex-shrink:0;">
                                    {{ strtoupper(substr($rdv->user->name ?? '?', 0, 2)) }}
                                </div>
                                <span style="font-size:14px; color:#64748b; font-weight:600;">{{ $rdv->user->name ?? '—' }}</span>
                            </div>
                        </td>

                        <td style="padding:16px 20px;">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <a href="{{ route('rendez-vous.edit', $rdv) }}"
                                   style="padding:7px 16px; border-radius:8px; border:1.5px solid #bfdbfe;
                                          color:#1d4ed8; font-size:14px; font-weight:600; text-decoration:none;
                                          background:#f0f7ff;">
                                    Modifier
                                </a>
                                <form method="POST" action="{{ route('rendez-vous.destroy', $rdv) }}"
                                      onsubmit="return confirm('Supprimer ce rendez-vous ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            style="padding:7px 16px; border-radius:8px; border:1.5px solid #fecaca;
                                                   color:#ef4444; font-size:14px; font-weight:600; background:#fff5f5;
                                                   cursor:pointer; font-family:'Plus Jakarta Sans',sans-serif;">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding:60px 20px; text-align:center; font-size:16px; color:#94a3b8;">
                            Aucun rendez-vous trouvé
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            @if($rendezVous->hasPages())
            <div style="padding:16px 20px; border-top:1px solid #f0f7ff;">
                {{ $rendezVous->appends(request()->query())->links() }}
            </div>
            @endif
        </div>

    </div>

</x-layouts.app>
