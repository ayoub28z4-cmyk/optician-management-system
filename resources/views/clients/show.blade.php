<x-layouts.app title="Fiche client — OptiGest">

    <div style="max-width:80%; margin:0 auto;">

        {{-- Header --}}
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:32px;">
            <div style="display:flex; align-items:center; gap:16px;">
                <a href="{{ route('clients.index') }}"
                   style="width:44px; height:44px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f0f7ff; display:flex; align-items:center; justify-content:center; flex-shrink:0; text-decoration:none;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="2.5">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0;">{{ $client->nom_complet }}</h1>
                    <p style="font-size:16px; color:#94a3b8; margin:6px 0 0;">Fiche client</p>
                </div>
            </div>
            <div style="display:flex; align-items:center; gap:10px;">
                <a href="{{ route('clients.edit', $client) }}"
                   style="display:flex; align-items:center; gap:8px; padding:12px 22px; border-radius:12px;
                          border:1.5px solid #bfdbfe; background:#f0f7ff; color:#1d4ed8;
                          font-size:15px; font-weight:700; text-decoration:none;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="2.5">
                        <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    Modifier
                </a>
                <form method="POST" action="{{ route('clients.destroy', $client) }}"
                      onsubmit="return confirm('Désactiver ce client ?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            style="display:flex; align-items:center; gap:8px; padding:12px 22px; border-radius:12px;
                                   border:1.5px solid #fecaca; background:#fff5f5; color:#ef4444;
                                   font-size:15px; font-weight:700; cursor:pointer; font-family:'Plus Jakarta Sans',sans-serif;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.5">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                            <path d="M10 11v6M14 11v6"/>
                        </svg>
                        Désactiver
                    </button>
                </form>
            </div>
        </div>

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
                            <p style="font-size:14px; color:#94a3b8; font-weight:600; margin:0 0 6px;">Prénom</p>
                            <p style="font-size:17px; font-weight:700; color:#0f172a; margin:0;">{{ $client->prenom }}</p>
                        </div>
                        <div>
                            <p style="font-size:14px; color:#94a3b8; font-weight:600; margin:0 0 6px;">Nom</p>
                            <p style="font-size:17px; font-weight:700; color:#0f172a; margin:0;">{{ $client->nom }}</p>
                        </div>
                        <div>
                            <p style="font-size:14px; color:#94a3b8; font-weight:600; margin:0 0 6px;">CIN</p>
                            <p style="font-size:17px; font-weight:700; color:#0f172a; margin:0; font-family:monospace; letter-spacing:2px;">{{ $client->cin }}</p>
                        </div>
                        <div>
                            <p style="font-size:14px; color:#94a3b8; font-weight:600; margin:0 0 6px;">Genre</p>
                            <p style="font-size:17px; font-weight:700; color:#0f172a; margin:0;">{{ ucfirst($client->genre ?? '—') }}</p>
                        </div>
                        <div>
                            <p style="font-size:14px; color:#94a3b8; font-weight:600; margin:0 0 6px;">Date de naissance</p>
                            <p style="font-size:17px; font-weight:700; color:#0f172a; margin:0;">
                                {{ $client->date_naissance ? $client->date_naissance->format('d/m/Y') : '—' }}
                            </p>
                        </div>
                        <div>
                            <p style="font-size:14px; color:#94a3b8; font-weight:600; margin:0 0 6px;">Mutuelle</p>
                            <span style="font-size:14px; font-weight:700; padding:5px 14px; border-radius:99px;
                                        background:{{ $client->mutuelle_color['bg'] }}; color:{{ $client->mutuelle_color['color'] }};">
                                {{ $client->mutuelle_label }}
                            </span>
                        </div>
                        <div>
                            <p style="font-size:14px; color:#94a3b8; font-weight:600; margin:0 0 6px;">Type</p>
                            <span style="font-size:14px; font-weight:700; padding:5px 14px; border-radius:99px;
                                         {{ $client->type === 'nouveau' ? 'background:#dcfce7; color:#16a34a;' : 'background:#f1f5f9; color:#64748b;' }}">
                                {{ ucfirst($client->type) }}
                            </span>
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
                            <p style="font-size:14px; color:#94a3b8; font-weight:600; margin:0 0 6px;">Téléphone</p>
                            <p style="font-size:17px; font-weight:700; color:#0f172a; margin:0;">{{ $client->telephone }}</p>
                        </div>
                        <div>
                            <p style="font-size:14px; color:#94a3b8; font-weight:600; margin:0 0 6px;">Email</p>
                            <p style="font-size:17px; font-weight:700; color:#0f172a; margin:0;">{{ $client->email ?? '—' }}</p>
                        </div>
                        <div style="grid-column:1/-1;">
                            <p style="font-size:14px; color:#94a3b8; font-weight:600; margin:0 0 6px;">Adresse</p>
                            <p style="font-size:17px; font-weight:700; color:#0f172a; margin:0;">{{ $client->adresse ?? '—' }}</p>
                        </div>

                    </div>
                </div>

                {{-- Observations --}}
                @if($client->observations)
                <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:28px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                    <div style="display:flex; align-items:center; gap:12px; margin-bottom:20px; padding-bottom:16px; border-bottom:1.5px solid #f0f7ff;">
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
                    <p style="font-size:16px; color:#334155; line-height:1.8; margin:0;">{{ $client->observations }}</p>
                </div>
                @endif

            </div>

            {{-- Colonne droite --}}
            <div style="display:flex; flex-direction:column; gap:20px; position:sticky; top:16px;">

                {{-- N° Classement --}}
                <div style="border-radius:18px; border:2px solid #93c5fd; padding:24px; background:linear-gradient(135deg,#eff6ff,#dbeeff); box-shadow:0 4px 20px rgba(29,78,216,0.12);">
                    <div style="display:flex; align-items:center; gap:14px; margin-bottom:16px;">
                        <div style="width:42px; height:42px; border-radius:12px; background:#1d4ed8; display:flex; align-items:center; justify-content:center; flex-shrink:0; box-shadow:0 3px 10px rgba(29,78,216,0.35);">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                            </svg>
                        </div>
                        <div>
                            <p style="font-size:17px; font-weight:700; color:#0f172a; margin:0;">N° Classement</p>
                            <p style="font-size:14px; color:#60a5fa; margin:3px 0 0;">Registre papier</p>
                        </div>
                    </div>
                    <div style="background:#fff; border-radius:12px; border:2px solid #93c5fd; height:64px; display:flex; align-items:center; justify-content:center; box-shadow:0 2px 8px rgba(29,78,216,0.1);">
                        <span style="font-size:28px; font-weight:800; color:#1d4ed8; font-family:monospace; letter-spacing:6px;">
                            {{ $client->classement_registre ?? '—' }}
                        </span>
                    </div>
                </div>

                {{-- Infos rapides --}}
                <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:22px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                    <h3 style="font-size:16px; font-weight:700; color:#0f172a; margin:0 0 16px; padding-bottom:12px; border-bottom:1px solid #f0f7ff;">Informations</h3>

                    <div style="display:flex; flex-direction:column; gap:14px;">
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <span style="font-size:15px; color:#64748b; font-weight:500;">Créé le</span>
                            <span style="font-size:15px; font-weight:700; color:#0f172a;">{{ $client->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <span style="font-size:15px; color:#64748b; font-weight:500;">Statut</span>
                            <span style="font-size:14px; font-weight:700; padding:4px 12px; border-radius:99px;
                                         {{ $client->is_active ? 'background:#dcfce7; color:#16a34a;' : 'background:#fee2e2; color:#ef4444;' }}">
                                {{ $client->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </div>
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <span style="font-size:15px; color:#64748b; font-weight:500;">Type</span>
                            <span style="font-size:14px; font-weight:700; padding:4px 12px; border-radius:99px;
                                         {{ $client->type === 'nouveau' ? 'background:#dcfce7; color:#16a34a;' : 'background:#f1f5f9; color:#64748b;' }}">
                                {{ ucfirst($client->type) }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Actions rapides --}}
                <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:22px; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                <h3 style="font-size:16px; font-weight:700; color:#0f172a; margin:0 0 16px; padding-bottom:12px; border-bottom:1px solid #f0f7ff;">Actions rapides</h3>
                <div style="display:flex; flex-direction:column; gap:10px;">

                    <a href="{{ route('clients.ordonnances.create', $client) }}"
                    style="display:flex; align-items:center; gap:10px; padding:12px 16px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f0f7ff; text-decoration:none; color:#1d4ed8; font-size:15px; font-weight:600;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="2.2">
                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                        Nouvelle ordonnance
                    </a>

                    <a href="{{ route('ventes.create', ['client_id' => $client->id]) }}"
                    style="display:flex; align-items:center; gap:10px; padding:12px 16px; border-radius:12px; border:1.5px solid #bbf7d0; background:#f0fdf4; text-decoration:none; color:#16a34a; font-size:15px; font-weight:600;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.2">
                            <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                            <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
                        </svg>
                        Nouvelle vente
                    </a>

                    <a href="{{ route('clients.ordonnances.index', $client) }}"
                    style="display:flex; align-items:center; gap:10px; padding:12px 16px; border-radius:12px; border:1.5px solid #c7d2fe; background:#f5f3ff; text-decoration:none; color:#7c3aed; font-size:15px; font-weight:600;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#7c3aed" stroke-width="2.2">
                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/>
                            <line x1="16" y1="17" x2="8" y2="17"/>
                        </svg>
                        Voir les ordonnances
                    </a>

                </div>
            </div>

            </div>
        </div>
    </div>

</x-layouts.app>
