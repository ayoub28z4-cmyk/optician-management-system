<aside style="height:100%; border-radius:16px; border:1px solid #c7d9f5;
              background:rgba(255,255,255,0.90);
              box-shadow: 0 4px 16px rgba(30,58,138,0.07);
              padding:24px 14px;
              display:flex; flex-direction:column; justify-content:space-between; overflow-y:auto;">

    {{-- Partie haute --}}
    <div style="display:flex; flex-direction:column; gap:4px;">

        <p style="font-size:12px; font-weight:700; color:#94a3b8; text-transform:uppercase;
                  letter-spacing:0.8px; padding:0 10px; margin-bottom:8px;">Principal</p>

        {{-- Dashboard --}}
        @php
            $dashRoute = match(auth()->user()->role) {
                'admin'    => 'admin.dashboard',
                'opticien' => 'opticien.dashboard',
                'employe'  => 'employe.dashboard',
                default    => 'opticien.dashboard',
            };
            $isDash = request()->routeIs($dashRoute);

            // Paiements = ventes.index avec statut non_paye
            $isPaiements = request()->routeIs('ventes.index') && request('statut') == 'non_paye';

            // Ventes = ventes.* SAUF paiements
            $isVentes = request()->routeIs('ventes.*') && !$isPaiements;
        @endphp

        <a href="{{ route($dashRoute) }}"
           style="display:flex; align-items:center; gap:12px; padding:12px 14px; border-radius:10px; text-decoration:none;
                  {{ $isDash ? 'background:#1d4ed8; color:#fff; box-shadow:0 4px 12px rgba(29,78,216,0.3);' : 'color:#334155;' }}">
            <div style="width:26px; height:26px; border-radius:7px; display:flex; align-items:center; justify-content:center; flex-shrink:0;
                        {{ $isDash ? 'background:rgba(255,255,255,0.2);' : 'background:#eff6ff;' }}">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                     stroke="{{ $isDash ? '#fff' : '#2563eb' }}" stroke-width="2.2">
                    <rect x="3" y="3" width="7" height="7" rx="1"/>
                    <rect x="14" y="3" width="7" height="7" rx="1"/>
                    <rect x="3" y="14" width="7" height="7" rx="1"/>
                    <rect x="14" y="14" width="7" height="7" rx="1"/>
                </svg>
            </div>
            <span style="font-size:16px; font-weight:600;">Dashboard</span>
        </a>

        {{-- Clients --}}
        @php $isClients = request()->routeIs('clients.*') && !request()->routeIs('clients.ordonnances.*'); @endphp
        <a href="{{ route('clients.index') }}"
           style="display:flex; align-items:center; gap:12px; padding:12px 14px; border-radius:10px; text-decoration:none;
                  {{ $isClients ? 'background:#1d4ed8; color:#fff; box-shadow:0 4px 12px rgba(29,78,216,0.3);' : 'color:#334155;' }}">
            <div style="width:26px; height:26px; border-radius:7px; display:flex; align-items:center; justify-content:center; flex-shrink:0;
                        {{ $isClients ? 'background:rgba(255,255,255,0.2);' : 'background:#eff6ff;' }}">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                     stroke="{{ $isClients ? '#fff' : '#2563eb' }}" stroke-width="2.2">
                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>
                </svg>
            </div>
            <span style="font-size:16px; font-weight:600;">Clients</span>
        </a>

        {{-- Ordonnances --}}
        @php $isOrdonnances = request()->routeIs('ordonnances.*') || request()->routeIs('clients.ordonnances.*'); @endphp
        <a href="{{ route('ordonnances.index') }}"
           style="display:flex; align-items:center; gap:12px; padding:12px 14px; border-radius:10px; text-decoration:none;
                  {{ $isOrdonnances ? 'background:#1d4ed8; color:#fff; box-shadow:0 4px 12px rgba(29,78,216,0.3);' : 'color:#334155;' }}">
            <div style="width:26px; height:26px; border-radius:7px; display:flex; align-items:center; justify-content:center; flex-shrink:0;
                        {{ $isOrdonnances ? 'background:rgba(255,255,255,0.2);' : 'background:#f5f3ff;' }}">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                     stroke="{{ $isOrdonnances ? '#fff' : '#7c3aed' }}" stroke-width="2.2">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                </svg>
            </div>
            <span style="font-size:16px; font-weight:600;">Ordonnances</span>
        </a>

        <p style="font-size:12px; font-weight:700; color:#94a3b8; text-transform:uppercase;
                  letter-spacing:0.8px; padding:0 10px; margin:18px 0 8px;">Commercial</p>

        {{-- Ventes --}}
        <a href="{{ route('ventes.index') }}"
           style="display:flex; align-items:center; gap:12px; padding:12px 14px; border-radius:10px; text-decoration:none;
                  {{ $isVentes ? 'background:#1d4ed8; color:#fff; box-shadow:0 4px 12px rgba(29,78,216,0.3);' : 'color:#334155;' }}">
            <div style="width:26px; height:26px; border-radius:7px; display:flex; align-items:center; justify-content:center; flex-shrink:0;
                        {{ $isVentes ? 'background:rgba(255,255,255,0.2);' : 'background:#fff7ed;' }}">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                     stroke="{{ $isVentes ? '#fff' : '#ea580c' }}" stroke-width="2.2">
                    <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                    <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
                </svg>
            </div>
            <span style="font-size:16px; font-weight:600;">Ventes</span>
        </a>

        @php $isPaiements = request()->routeIs('paiements.*'); @endphp
        <a href="{{ route('paiements.index') }}"
        style="display:flex; align-items:center; gap:12px; padding:12px 14px; border-radius:10px; text-decoration:none;
                {{ $isPaiements ? 'background:#1d4ed8; color:#fff; box-shadow:0 4px 12px rgba(29,78,216,0.3);' : 'color:#334155;' }}">
            <div style="width:26px; height:26px; border-radius:7px; display:flex; align-items:center; justify-content:center; flex-shrink:0;
                        {{ $isPaiements ? 'background:rgba(255,255,255,0.2);' : 'background:#f0fdf4;' }}">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                    stroke="{{ $isPaiements ? '#fff' : '#16a34a' }}" stroke-width="2.2">
                    <line x1="12" y1="1" x2="12" y2="23"/>
                    <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
                </svg>
            </div>
            <span style="font-size:16px; font-weight:600;">Paiements</span>
        </a>

        {{-- Stock / Articles --}}
        @php
            $isStock    = request()->routeIs('articles.*') || request()->routeIs('societes.*') || request()->routeIs('retraits.*');
            $stockAlerte = \App\Models\Produit::where('quantite_stock', '>', 0)->whereColumn('quantite_stock', '<=', 'seuil_alerte')->count()
                         + \App\Models\Produit::where('quantite_stock', 0)->count();
        @endphp
        <a href="{{ route('articles.index') }}"
           style="display:flex; align-items:center; gap:12px; padding:12px 14px; border-radius:10px; text-decoration:none;
                  {{ $isStock ? 'background:#1d4ed8; color:#fff; box-shadow:0 4px 12px rgba(29,78,216,0.3);' : 'color:#334155;' }}">
            <div style="width:26px; height:26px; border-radius:7px; display:flex; align-items:center; justify-content:center; flex-shrink:0;
                        {{ $isStock ? 'background:rgba(255,255,255,0.2);' : 'background:#fefce8;' }}">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                     stroke="{{ $isStock ? '#fff' : '#ca8a04' }}" stroke-width="2.2">
                    <path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/>
                </svg>
            </div>
            <span style="font-size:16px; font-weight:600; flex:1;">Stock</span>
            @if($stockAlerte > 0)
            <span style="background:{{ $isStock ? 'rgba(255,255,255,0.25)' : '#fef9c3' }}; color:{{ $isStock ? '#fff' : '#92400e' }};
                         font-size:11px; font-weight:800; padding:2px 7px; border-radius:99px; line-height:1.4;">
                {{ $stockAlerte }}
            </span>
            @endif
        </a>

        <p style="font-size:12px; font-weight:700; color:#94a3b8; text-transform:uppercase;
                  letter-spacing:0.8px; padding:0 10px; margin:18px 0 8px;">Suivi</p>

        {{-- Rappels --}}
        @php $isRappels = request()->routeIs('rappels.*'); @endphp
        <a href="{{ route('rappels.index') }}"
           style="display:flex; align-items:center; gap:12px; padding:12px 14px; border-radius:10px; text-decoration:none;
                  {{ $isRappels ? 'background:#1d4ed8; color:#fff; box-shadow:0 4px 12px rgba(29,78,216,0.3);' : 'color:#334155;' }}">
            <div style="width:26px; height:26px; border-radius:7px; display:flex; align-items:center; justify-content:center; flex-shrink:0;
                        {{ $isRappels ? 'background:rgba(255,255,255,0.2);' : 'background:#fdf2f8;' }}">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                     stroke="{{ $isRappels ? '#fff' : '#db2777' }}" stroke-width="2.2">
                    <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 13.1 19.79 19.79 0 01.18 4.5 2 2 0 012.18 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L6.91 9.5a16 16 0 006.59 6.59l1.06-1.06a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/>
                </svg>
            </div>
            <span style="font-size:16px; font-weight:600;">Rappels</span>
        </a>

        {{-- Rendez-vous --}}
        @php $isRdv = request()->routeIs('rendez-vous.*'); @endphp
        <a href="{{ route('rendez-vous.index') }}"
           style="display:flex; align-items:center; gap:12px; padding:12px 14px; border-radius:10px; text-decoration:none;
                  {{ $isRdv ? 'background:#1d4ed8; color:#fff; box-shadow:0 4px 12px rgba(29,78,216,0.3);' : 'color:#334155;' }}">
            <div style="width:26px; height:26px; border-radius:7px; display:flex; align-items:center; justify-content:center; flex-shrink:0;
                        {{ $isRdv ? 'background:rgba(255,255,255,0.2);' : 'background:#ecfeff;' }}">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                     stroke="{{ $isRdv ? '#fff' : '#0891b2' }}" stroke-width="2.2">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
            </div>
            <span style="font-size:16px; font-weight:600;">Rendez-vous</span>
        </a>

        @if(auth()->user()->role === 'admin')
    @php $isUsers = request()->routeIs('admin.users.*'); @endphp
    <a href="{{ route('admin.users.index') }}"
    style="display:flex; align-items:center; gap:12px; padding:12px 14px; border-radius:10px; text-decoration:none;
            {{ $isUsers ? 'background:#1d4ed8; color:#fff; box-shadow:0 4px 12px rgba(29,78,216,0.3);' : 'color:#334155;' }}">
        <div style="width:26px; height:26px; border-radius:7px; display:flex; align-items:center; justify-content:center; flex-shrink:0;
                    {{ $isUsers ? 'background:rgba(255,255,255,0.2);' : 'background:#f5f3ff;' }}">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                stroke="{{ $isUsers ? '#fff' : '#7c3aed' }}" stroke-width="2.2">
                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 00-3-3.87"/>
                <path d="M16 3.13a4 4 0 010 7.75"/>
            </svg>
        </div>
        <span style="font-size:16px; font-weight:600;">Utilisateurs</span>
    </a>
    @endif
    </div>

    