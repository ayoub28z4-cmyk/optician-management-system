<nav style="height:100%; border-radius:16px; border:1px solid #c7d9f5;
            background:rgba(255,255,255,0.92);
            box-shadow: 0 4px 16px rgba(30,58,138,0.08);
            padding:0 32px;
            display:flex; align-items:center; justify-content:space-between;">

    {{-- 1. Logo — cliquable vers dashboard --}}
    <a href="{{ match(auth()->user()->role) {
        'admin'    => route('admin.dashboard'),
        'opticien' => route('opticien.dashboard'),
        'employe'  => route('employe.dashboard'),
        default    => route('login'),
    } }}" style="display:flex; align-items:center; gap:14px; text-decoration:none;">
        <div style="width:48px; height:48px; border-radius:14px; background:#1d4ed8;
                    display:flex; align-items:center; justify-content:center;
                    color:#fff; font-weight:800; font-size:22px;
                    box-shadow:0 4px 14px rgba(29,78,216,0.4);">
            O
        </div>
        <div>
            <div style="font-size:20px; font-weight:800; color:#0f172a; line-height:1.2;">OptiGest</div>
            <div style="font-size:13px; font-weight:500; color:#94a3b8;">Gestion Optique</div>
        </div>
    </a>

    {{-- 2. Recherche globale --}}
    <form method="GET" action="{{ route('clients.index') }}"
          style="display:flex; align-items:center; gap:10px; width:400px; height:48px;
                 padding:0 16px; border-radius:14px;
                 border:1.5px solid #bfdbfe; background:#f0f7ff;">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#93c5fd" stroke-width="2.5" style="flex-shrink:0;">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input type="text" name="search"
               value="{{ request()->routeIs('clients.*') ? request('search') : '' }}"
               placeholder="Rechercher client, n° registre, CIN..."
               style="background:transparent; border:none; outline:none; width:100%;
                      font-size:15px; color:#334155; font-family:'Plus Jakarta Sans',sans-serif;">
        <button type="submit"
                style="background:none; border:none; cursor:pointer; flex-shrink:0;">
            <span style="background:#dbeafe; color:#93c5fd; border:1px solid #bfdbfe;
                         font-size:11px; font-family:monospace; padding:2px 6px; border-radius:5px;">
                ⌘K
            </span>
        </button>
    </form>

    {{-- 3. Utilisateur --}}
    <div style="display:flex; align-items:center; gap:12px;">

        {{-- Badge rôle --}}
        @php
            $roleColors = [
                'admin'    => ['bg'=>'#f5f3ff','color'=>'#7c3aed','border'=>'#c4b5fd'],
                'opticien' => ['bg'=>'#dbeafe','color'=>'#1d4ed8','border'=>'#bfdbfe'],
                'employe'  => ['bg'=>'#dcfce7','color'=>'#16a34a','border'=>'#bbf7d0'],
            ];
            $rc = $roleColors[auth()->user()->role] ?? $roleColors['opticien'];
        @endphp
        <span style="background:{{ $rc['bg'] }}; color:{{ $rc['color'] }}; border:1px solid {{ $rc['border'] }};
                     font-size:13px; font-weight:700; padding:5px 14px; border-radius:99px;">
            {{ ucfirst(auth()->user()->role) }}
        </span>

        {{-- Avatar + dropdown --}}
        <div style="position:relative;" x-data="{ open: false }">
            <div onclick="toggleDropdown()"
                 style="display:flex; align-items:center; gap:10px; padding:8px 14px;
                        border-radius:14px; border:1px solid #bfdbfe; background:#f0f7ff; cursor:pointer;">
                <div style="width:38px; height:38px; border-radius:50%; background:#1d4ed8;
                            display:flex; align-items:center; justify-content:center;
                            color:#fff; font-weight:800; font-size:14px; flex-shrink:0;
                            box-shadow:0 3px 8px rgba(29,78,216,0.3);">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div style="line-height:1.4;">
                    <div style="font-size:15px; font-weight:700; color:#0f172a;">{{ auth()->user()->name }}</div>
                    <div style="font-size:12px; font-weight:500; color:#16a34a;">● En ligne</div>
                </div>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2.5" style="margin-left:4px;">
                    <path d="M6 9l6 6 6-6"/>
                </svg>
            </div>

            {{-- Dropdown menu --}}
            <div id="user-dropdown"
                 style="display:none; position:absolute; top:calc(100% + 10px); right:0;
                        background:#fff; border-radius:14px; border:1px solid #bfdbfe;
                        box-shadow:0 8px 24px rgba(29,78,216,0.12); min-width:220px; z-index:100;
                        padding:8px;">

                {{-- Info utilisateur --}}
                <div style="padding:12px 14px; border-bottom:1px solid #f0f7ff; margin-bottom:6px;">
                    <div style="font-size:15px; font-weight:700; color:#0f172a;">{{ auth()->user()->name }}</div>
                    <div style="font-size:13px; color:#94a3b8; margin-top:2px;">{{ auth()->user()->email }}</div>
                </div>

                {{-- Dashboard --}}
                <a href="{{ match(auth()->user()->role) {
                    'admin'    => route('admin.dashboard'),
                    'opticien' => route('opticien.dashboard'),
                    'employe'  => route('employe.dashboard'),
                    default    => route('login'),
                } }}"
                   style="display:flex; align-items:center; gap:10px; padding:10px 14px;
                          border-radius:10px; text-decoration:none; color:#334155;
                          font-size:14px; font-weight:600;"
                   onmouseover="this.style.background='#f0f7ff'" onmouseout="this.style.background='transparent'">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="2.2">
                        <rect x="3" y="3" width="7" height="7" rx="1"/>
                        <rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/>
                        <rect x="14" y="14" width="7" height="7" rx="1"/>
                    </svg>
                    Mon dashboard
                </a>

                {{-- Déconnexion --}}
                <form method="POST" action="{{ route('logout') }}" style="margin-top:4px;">
                    @csrf
                    <button type="submit"
                            style="width:100%; display:flex; align-items:center; gap:10px; padding:10px 14px;
                                   border-radius:10px; border:none; background:none; cursor:pointer;
                                   color:#ef4444; font-size:14px; font-weight:600; text-align:left;
                                   font-family:'Plus Jakarta Sans',sans-serif;"
                            onmouseover="this.style.background='#fff5f5'" onmouseout="this.style.background='transparent'">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.2">
                            <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/>
                            <polyline points="16 17 21 12 16 7"/>
                            <line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>
                        Déconnexion
                    </button>
                </form>

            </div>
        </div>

    </div>
</nav>

<script>
function toggleDropdown() {
    const dropdown = document.getElementById('user-dropdown');
    dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
}

// Fermer si clic en dehors
document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('user-dropdown');
    if (!e.target.closest('[onclick="toggleDropdown()"]') && !e.target.closest('#user-dropdown')) {
        dropdown.style.display = 'none';
    }
});
</script>
