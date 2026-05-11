<x-layouts.app title="Rappels mutuelle — OptiGest">

    <div style="max-width:90%; margin:0 auto;">

        {{-- Header --}}
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:32px;">
            <div>
                <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0;">Rappels mutuelle</h1>
                <p style="font-size:16px; color:#94a3b8; margin:6px 0 0;">Suivi des clients à contacter pour renouvellement</p>
            </div>
            <div style="display:flex; gap:10px;">
                <div style="background:#fee2e2; border:1px solid #fecaca; border-radius:12px; padding:10px 18px; text-align:center;">
                    <div style="font-size:22px; font-weight:800; color:#ef4444;">{{ $rappels->where('urgence', 'urgent')->count() }}</div>
                    <div style="font-size:13px; color:#ef4444; font-weight:600;">Urgents</div>
                </div>
                <div style="background:#fef9c3; border:1px solid #fde68a; border-radius:12px; padding:10px 18px; text-align:center;">
                    <div style="font-size:22px; font-weight:800; color:#ca8a04;">{{ $rappels->where('urgence', 'proche')->count() }}</div>
                    <div style="font-size:13px; color:#ca8a04; font-weight:600;">Proches</div>
                </div>
                <div style="background:#dcfce7; border:1px solid #bbf7d0; border-radius:12px; padding:10px 18px; text-align:center;">
                    <div style="font-size:22px; font-weight:800; color:#16a34a;">{{ $rappels->where('statut', 'traite')->count() }}</div>
                    <div style="font-size:13px; color:#16a34a; font-weight:600;">Traités</div>
                </div>
            </div>
        </div>

        {{-- Filtres --}}
        <form method="GET" action="{{ route('rappels.index') }}"
              style="display:flex; align-items:center; gap:12px; margin-bottom:24px; padding:16px 20px;
                     border-radius:14px; border:1px solid #bfdbfe; background:#f0f7ff;">

            <select name="statut"
                    style="height:48px; padding:0 16px; border-radius:12px; border:1.5px solid #bfdbfe;
                           background:#fff; font-size:15px; color:#334155; outline:none;
                           font-family:'Plus Jakarta Sans',sans-serif; min-width:180px;">
                <option value="">Tous les statuts</option>
                <option value="a_contacter" {{ request('statut')=='a_contacter'?'selected':'' }}>À contacter</option>
                <option value="contacte" {{ request('statut')=='contacte'?'selected':'' }}>Contacté</option>
                <option value="relance" {{ request('statut')=='relance'?'selected':'' }}>Relancé</option>
                <option value="traite" {{ request('statut')=='traite'?'selected':'' }}>Traité</option>
            </select>

            <select name="urgence"
                    style="height:48px; padding:0 16px; border-radius:12px; border:1.5px solid #bfdbfe;
                           background:#fff; font-size:15px; color:#334155; outline:none;
                           font-family:'Plus Jakarta Sans',sans-serif; min-width:180px;">
                <option value="">Toutes les urgences</option>
                <option value="urgent" {{ request('urgence')=='urgent'?'selected':'' }}>Urgents (dépassés)</option>
                <option value="proche" {{ request('urgence')=='proche'?'selected':'' }}>Proches (30 jours)</option>
                <option value="normal" {{ request('urgence')=='normal'?'selected':'' }}>Normal (90 jours)</option>
            </select>

            <button type="submit"
                    style="height:48px; padding:0 24px; border-radius:12px; border:none;
                           background:#1d4ed8; color:#fff; font-size:15px; font-weight:700; cursor:pointer;
                           font-family:'Plus Jakarta Sans',sans-serif;">
                Filtrer
            </button>

            @if(request('statut') || request('urgence'))
            <a href="{{ route('rappels.index') }}"
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

        {{-- Liste rappels --}}
        <div style="display:flex; flex-direction:column; gap:14px;">

            @forelse($rappels as $rappel)
            @php
                $urgenceColors = [
                    'urgent'   => ['border'=>'#fecaca','bg'=>'#fff5f5','badge_bg'=>'#fee2e2','badge_color'=>'#ef4444','label'=>'Urgent'],
                    'proche'   => ['border'=>'#fde68a','bg'=>'#fffef0','badge_bg'=>'#fef9c3','badge_color'=>'#ca8a04','label'=>'Proche'],
                    'normal'   => ['border'=>'#bfdbfe','bg'=>'#f0f7ff','badge_bg'=>'#dbeafe','badge_color'=>'#1d4ed8','label'=>'Normal'],
                    'lointain' => ['border'=>'#e2e8f0','bg'=>'#f8fafc','badge_bg'=>'#f1f5f9','badge_color'=>'#64748b','label'=>'Lointain'],
                ];
                $statutColors = [
                    'a_contacter' => ['bg'=>'#fee2e2','color'=>'#ef4444','label'=>'À contacter'],
                    'contacte'    => ['bg'=>'#dbeafe','color'=>'#1d4ed8','label'=>'Contacté'],
                    'relance'     => ['bg'=>'#fef9c3','color'=>'#ca8a04','label'=>'Relancé'],
                    'traite'      => ['bg'=>'#dcfce7','color'=>'#16a34a','label'=>'Traité'],
                ];
                $uc = $urgenceColors[$rappel->urgence] ?? $urgenceColors['lointain'];
                $sc = $statutColors[$rappel->statut] ?? $statutColors['a_contacter'];
            @endphp

            <div style="background:{{ $uc['bg'] }}; border-radius:18px; border:1.5px solid {{ $uc['border'] }};
                        padding:20px 24px; box-shadow:0 2px 8px rgba(0,0,0,0.05);">
                <div style="display:grid; grid-template-columns:1fr auto; gap:20px; align-items:start;">

                    {{-- Info client --}}
                    <div style="display:flex; align-items:center; gap:16px;">
                        <div style="width:48px; height:48px; border-radius:50%; background:#dbeafe;
                                    display:flex; align-items:center; justify-content:center;
                                    font-size:16px; font-weight:800; color:#1d4ed8; flex-shrink:0;">
                            {{ $rappel->client->initiales }}
                        </div>
                        <div style="flex:1;">
                            <div style="display:flex; align-items:center; gap:10px; margin-bottom:4px;">
                                <span style="font-size:17px; font-weight:800; color:#0f172a;">{{ $rappel->client->nom_complet }}</span>
                                <span style="font-size:12px; font-weight:700; padding:3px 10px; border-radius:99px; background:{{ $uc['badge_bg'] }}; color:{{ $uc['badge_color'] }};">
                                    {{ $uc['label'] }}
                                </span>
                                <span style="font-size:12px; font-weight:700; padding:3px 10px; border-radius:99px; background:{{ $sc['bg'] }}; color:{{ $sc['color'] }};">
                                    {{ $sc['label'] }}
                                </span>
                            </div>
                            <div style="display:flex; align-items:center; gap:16px; flex-wrap:wrap;">
                                <span style="font-size:14px; color:#64748b;">
                                    📞 {{ $rappel->client->telephone }}
                                </span>
                                <span style="font-size:13px; font-weight:700; padding:3px 10px; border-radius:99px;
                                    background:{{ $rappel->client->mutuelle_color['bg'] }}; color:{{ $rappel->client->mutuelle_color['color'] }};">
                                    {{ $rappel->client->mutuelle_label }}
                                </span>
                                <span style="font-size:14px; color:#64748b;">
                                    Ordonnance du {{ $rappel->date_reference->format('d/m/Y') }}
                                </span>
                                <span style="display:flex; align-items:center; gap:6px;">
                                    <div style="width:28px; height:28px; border-radius:50%; background:#f1f5f9;
                                                display:flex; align-items:center; justify-content:center;
                                                font-size:11px; font-weight:800; color:#64748b; flex-shrink:0;">
                                        {{ strtoupper(substr($rappel->user->name ?? '?', 0, 2)) }}
                                    </div>
                                    <span style="font-size:14px; color:#64748b; font-weight:600;">{{ $rappel->user->name ?? '—' }}</span>
                                </span>
                                <span style="font-size:14px; font-weight:700; color:{{ $uc['badge_color'] }};">
                                    Éligible le {{ $rappel->date_eligibilite->format('d/m/Y') }}
                                    ({{ $rappel->jours_avant_rappel <= 0 ? 'dépassé de '.abs($rappel->jours_avant_rappel).'j' : 'dans '.$rappel->jours_avant_rappel.'j' }})
                                </span>
                            </div>
                            @if($rappel->note_contact)
                            <div style="margin-top:8px; padding:8px 12px; background:rgba(255,255,255,0.7); border-radius:8px; font-size:14px; color:#334155;">
                                <strong>Note :</strong> {{ $rappel->note_contact }}
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Formulaire mise à jour statut --}}
                    @if($rappel->statut !== 'traite')
                    <form method="POST" action="{{ route('rappels.update', $rappel) }}"
                          style="display:flex; flex-direction:column; gap:8px; min-width:280px;">
                        @csrf @method('PUT')
                        <select name="statut"
                                style="height:44px; padding:0 14px; border-radius:10px; border:1.5px solid #bfdbfe; background:#fff; font-size:15px; color:#0f172a; outline:none; font-family:'Plus Jakarta Sans',sans-serif;">
                            <option value="a_contacter" {{ $rappel->statut=='a_contacter'?'selected':'' }}>À contacter</option>
                            <option value="contacte" {{ $rappel->statut=='contacte'?'selected':'' }}>Contacté</option>
                            <option value="relance" {{ $rappel->statut=='relance'?'selected':'' }}>Relancé</option>
                            <option value="traite" {{ $rappel->statut=='traite'?'selected':'' }}>Traité</option>
                        </select>
                        <textarea name="note_contact" rows="2"
                                  placeholder="Note sur le contact (optionnel)..."
                                  style="border-radius:10px; border:1.5px solid #bfdbfe; background:#fff; padding:10px 14px; font-size:14px; color:#0f172a; outline:none; resize:none; font-family:'Plus Jakarta Sans',sans-serif;">{{ $rappel->note_contact }}</textarea>
                        <button type="submit"
                                style="height:42px; border-radius:10px; background:#1d4ed8; border:none; color:#fff; font-size:14px; font-weight:700; cursor:pointer; font-family:'Plus Jakarta Sans',sans-serif; box-shadow:0 3px 10px rgba(29,78,216,0.3);">
                            Mettre à jour
                        </button>
                    </form>
                    @else
                    <div style="text-align:right; min-width:200px;">
                        <span style="font-size:13px; color:#16a34a; font-weight:600;">
                            Traité le {{ $rappel->traite_at?->format('d/m/Y') }}
                        </span>
                        @if($rappel->traitePar)
                        <div style="font-size:13px; color:#94a3b8; margin-top:3px;">par {{ $rappel->traitePar->name }}</div>
                        @endif
                    </div>
                    @endif

                </div>
            </div>

            @empty
            <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:60px 20px; text-align:center; box-shadow:0 4px 14px rgba(29,78,216,0.07);">
                <p style="font-size:18px; color:#94a3b8; margin:0;">Aucun rappel trouvé</p>
                <p style="font-size:15px; color:#94a3b8; margin:8px 0 0;">Les rappels sont générés automatiquement lors de l'enregistrement des ordonnances</p>
            </div>
            @endforelse

        </div>

        {{-- Pagination --}}
        @if($rappels->hasPages())
        <div style="margin-top:20px;">
            {{ $rappels->appends(request()->query())->links() }}
        </div>
        @endif

    </div>

</x-layouts.app>
