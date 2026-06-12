@push('styles')
    <style>
        .sidebar {
            background: #3498db;
            min-height: 100vh;
            padding: 1.5rem 1rem;
        }

        .sidebar-user {
            padding: 1rem;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 1rem;
            margin-bottom: 1.5rem;
        }

        .sidebar-user-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--sage), var(--teal));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 1.25rem;
        }

        .sidebar-user-name {
            color: #fff;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .sidebar-role-switch {
            margin-bottom: 1.5rem;
        }

        .sidebar-role-label {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }

        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .sidebar-menu-item, .sidebar-dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: 0.75rem;
            transition: 0.2s ease;
            cursor: pointer;
            background: transparent;
            border: 0;
            width: 100%;
            text-align: left;
        }

        .sidebar-menu-item:hover, .sidebar-dropdown-toggle:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .sidebar-menu-item.active {
            background: linear-gradient(135deg, rgba(120, 160, 131, 0.3), rgba(80, 114, 123, 0.3));
            color: #fff;
            font-weight: 600;
        }

        .sidebar-menu-item i, .sidebar-dropdown-toggle i {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        /* --- Styling Tambahan Untuk Dropdown --- */
        .sidebar-dropdown-menu {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            padding-left: 1.5rem;
            margin-top: 0.25rem;
            margin-bottom: 0.25rem;
        }

        .sidebar-dropdown-toggle .arrow-icon {
            margin-left: auto;
            transition: transform 0.2s ease;
            font-size: 0.8rem;
        }

        .sidebar-dropdown-toggle[aria-expanded="true"] .arrow-icon {
            transform: rotate(90deg);
        }

        .sidebar-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.15);
            margin: 1rem 0;
        }

        .sidebar-logout {
            margin-top: auto;
        }

        .sidebar-logout-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: 0.75rem;
            transition: 0.2s ease;
            background: rgba(220, 76, 100, 0.2);
            border: 0;
            width: 100%;
            text-align: left;
        }

        .sidebar-logout-btn:hover {
            background: rgba(220, 76, 100, 0.3);
            color: #fff;
        }

        .role-select {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            font-size: 0.9rem;
        }

        .role-select option {
            background: var(--slate);
            color: #fff;
        }

        .dashboard-content {
            padding: 2rem;
            background: var(--page-bg);
            min-height: 100vh;
        }
    </style>
@endpush

<aside class="sidebar d-flex flex-column">
    <div class="sidebar-user">
        <div class="d-flex align-items-center gap-3">
            <div class="sidebar-user-avatar">
                {{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}
            </div>
            <div>
                <div class="sidebar-user-name">{{ Auth::user()->nama }}</div>
            </div>
        </div>
    </div>

    @php
        $user = Auth::user();
        $roles = $user->roles->pluck('name')->toArray();
        $activeRole = session('active_role', $roles[0] ?? null);
        
        $roleRoutes = [
            'administrator' => 'dashboard.admin',
            'guru' => 'dashboard.guru',
            'wali kelas' => 'dashboard.walikelas',
            'siswa' => 'dashboard.siswa',
        ];
        
        $roleMenus = [
            'administrator' => [
                ['type' => 'link', 'icon' => 'bi-speedometer2', 'label' => 'Dashboard', 'route' => 'dashboard.admin'],
                ['type' => 'link', 'icon' => 'bi-people', 'label' => 'Data Calon Siswa', 'route' => 'admin.calon-siswa.index'],
                
                // Pembungkus Dropdown Data Master
                [
                    'type' => 'dropdown',
                    'icon' => 'bi-database',
                    'label' => 'Data Master',
                    'id' => 'dropdownDataMaster',
                    // Logic ini membuat dropdown otomatis terbuka saat sub-menu di dalamnya aktif
                    'isOpen' => request()->routeIs('admin.siswa.*') || request()->routeIs('admin.guru.*') || request()->routeIs('admin.wali-kelas.*') || request()->routeIs('admin.mata-pelajaran.*') || request()->routeIs('admin.kelas.*') || request()->routeIs('admin.user.*'),
                    'submenus' => [
                        ['icon' => 'bi-person-badge', 'label' => 'Data Guru', 'route' => 'admin.guru.index'],
                        ['icon' => 'bi-person', 'label' => 'Data Siswa', 'route' => 'admin.siswa.index'],
                        ['icon' => 'bi-book', 'label' => 'Mata Pelajaran', 'route' => 'admin.mata-pelajaran.index'],
                        ['icon' => 'bi-door-open', 'label' => 'Data Kelas', 'route' => 'admin.kelas.index'],
                        ['icon' => 'bi-person-check', 'label' => 'Wali Kelas', 'route' => 'admin.wali-kelas.index'],
                        ['icon' => 'bi-person-gear', 'label' => 'Data User', 'route' => 'admin.user.index'],
                    ]
                ],

                ['type' => 'link', 'icon' => 'bi-calendar-week', 'label' => 'Jadwal Pelajaran', 'route' => 'admin.jadwal.index'],
                ['type' => 'link', 'icon' => 'bi-house-door', 'label' => 'Kelola Beranda PPDB', 'route' => 'admin.beranda.index'],
                ['type' => 'link', 'icon' => 'bi-file-earmark-text', 'label' => 'Kelola Syarat PPDB', 'route' => 'admin.persyaratan-ppdb.index'], 
                ['type' => 'link', 'icon' => 'bi-calendar-check', 'label' => 'Kelola Jadwal PPDB', 'route' => 'admin.jadwal-ppdb.index'],         
            ],
            'guru' => [
                ['type' => 'link', 'icon' => 'bi-speedometer2', 'label' => 'Dashboard', 'route' => 'dashboard.guru'],
                ['type' => 'link', 'icon' => 'bi-calendar', 'label' => 'Jadwal Mengajar', 'route' => 'guru.jadwal-mengajar'],
                ['type' => 'link', 'icon' => 'bi-people', 'label' => 'Daftar Siswa', 'route' => 'guru.daftar-siswa'],
                ['type' => 'link', 'icon' => 'bi-file-earmark-spreadsheet', 'label' => 'Input Nilai', 'route' => 'guru.input-nilai'],
                ['type' => 'link', 'icon' => 'bi-file-earmark-text', 'label' => 'Tugas', 'route' => 'guru.daftar-tugas'],
            ],
            'wali kelas' => [
                ['type' => 'link', 'icon' => 'bi-speedometer2', 'label' => 'Dashboard', 'route' => 'dashboard.walikelas'],
                ['type' => 'link', 'icon' => 'bi-calendar-check', 'label' => 'Presensi Siswa', 'route' => 'walikelas.presensi-siswa'],
                ['type' => 'link', 'icon' => 'bi-clipboard-data', 'label' => 'Rekap Presensi', 'route' => 'walikelas.rekap-presensi'],
                ['type' => 'link', 'icon' => 'bi-file-earmark-spreadsheet', 'label' => 'Rekap Nilai', 'route' => 'walikelas.rekap-nilai'],
            ],
            'siswa' => [
                ['type' => 'link', 'icon' => 'bi-speedometer2', 'label' => 'Dashboard', 'route' => 'dashboard.siswa'],
                ['type' => 'link', 'icon' => 'bi-calendar', 'label' => 'Jadwal Pelajaran', 'route' => 'siswa.jadwal-pelajaran'],
                ['type' => 'link', 'icon' => 'bi-clipboard-data', 'label' => 'Nilai', 'route' => 'siswa.nilai'],
                ['type' => 'link', 'icon' => 'bi-calendar-check', 'label' => 'Presensi', 'route' => 'siswa.rekap-presensi'],
                ['type' => 'link', 'icon' => 'bi-file-earmark-text', 'label' => 'Tugas', 'route' => 'siswa.daftar-tugas'],
            ],
        ];
        
        $currentMenu = $roleMenus[$activeRole] ?? [];
    @endphp

    @if(count($roles) > 1 && !in_array('siswa', $roles))
        <div class="sidebar-role-switch">
            <div class="sidebar-role-label">Pilih Role</div>
            <form action="{{ route('switch-role') }}" method="POST" id="roleSwitchForm">
                @csrf
                <select name="role" class="role-select" onchange="document.getElementById('roleSwitchForm').submit()">
                    @foreach($roles as $role)
                        <option value="{{ $role }}" {{ $activeRole == $role ? 'selected' : '' }}>
                            {{ ucwords($role) }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    @endif

<nav class="sidebar-menu">
        @foreach($currentMenu as $menu)
            {{-- JIKA TYPE MENU ADALAH DROPDOWN --}}
            @if(($menu['type'] ?? 'link') === 'dropdown')
                <div>
                    <button class="sidebar-dropdown-toggle" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#{{ $menu['id'] }}" aria-expanded="{{ $menu['isOpen'] ? 'true' : 'false' }}">
                        <i class="bi {{ $menu['icon'] }}"></i>
                        <span>{{ $menu['label'] }}</span>
                        <i class="bi bi-chevron-right arrow-icon"></i>
                    </button>
                    
                    <div class="collapse {{ $menu['isOpen'] ? 'show' : '' }}" id="{{ $menu['id'] }}">
                        <div class="sidebar-dropdown-menu">
                            @foreach($menu['submenus'] as $sub)
                                <a href="{{ route($sub['route']) }}" 
                                   class="sidebar-menu-item {{ request()->routeIs($sub['route']) ? 'active' : '' }}">
                                    <i class="bi {{ $sub['icon'] }}"></i>
                                    <span>{{ $sub['label'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            
            {{-- JIKA TYPE MENU ADALAH LINK BIASA --}}
            @else
                <a href="{{ $menu['route'] != '#' ? route($menu['route']) : '#' }}" 
                   class="sidebar-menu-item {{ request()->routeIs($menu['route']) ? 'active' : '' }}">
                    <i class="bi {{ $menu['icon'] }}"></i>
                    <span>{{ $menu['label'] }}</span>
                </a>
            @endif
        @endforeach
    </nav>

    <div class="sidebar-divider"></div>

    <div class="sidebar-logout">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-logout-btn">
                <i class="bi bi-box-arrow-left"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>