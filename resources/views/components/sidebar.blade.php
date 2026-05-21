@push('styles')
    <style>
        .sidebar {
            background: linear-gradient(180deg, var(--navy), var(--slate));
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

        .sidebar-menu-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: 0.75rem;
            transition: 0.2s ease;
        }

        .sidebar-menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .sidebar-menu-item.active {
            background: linear-gradient(135deg, rgba(120, 160, 131, 0.3), rgba(80, 114, 123, 0.3));
            color: #fff;
            font-weight: 600;
        }

        .sidebar-menu-item i {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
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
                ['icon' => 'bi-speedometer2', 'label' => 'Dashboard', 'route' => 'dashboard.admin'],
                ['icon' => 'bi-person-plus', 'label' => 'Verifikasi Pendaftar', 'route' => 'admin.calon-siswa.index'],
                ['icon' => 'bi-people', 'label' => 'Data Siswa', 'route' => '#'],
                ['icon' => 'bi-person-badge', 'label' => 'Data Guru', 'route' => '#'],
                ['icon' => 'bi-book', 'label' => 'Mata Pelajaran', 'route' => '#'],
            ],
            'guru' => [
                ['icon' => 'bi-speedometer2', 'label' => 'Dashboard', 'route' => 'dashboard.guru'],
                ['icon' => 'bi-calendar', 'label' => 'Jadwal Mengajar', 'route' => '#'],
                ['icon' => 'bi-people', 'label' => 'Daftar Siswa', 'route' => '#'],
                ['icon' => 'bi-file-earmark-spreadsheet', 'label' => 'Input Nilai', 'route' => '#'],
            ],
            'wali kelas' => [
                ['icon' => 'bi-speedometer2', 'label' => 'Dashboard', 'route' => 'dashboard.walikelas'],
                ['icon' => 'bi-calendar-check', 'label' => 'Presensi Siswa', 'route' => '#'],
                ['icon' => 'bi-clipboard-data', 'label' => 'Rekap Presensi', 'route' => '#'],
                ['icon' => 'bi-file-earmark-spreadsheet', 'label' => 'Rekap Nilai', 'route' => '#'],
            ],
            'siswa' => [
                ['icon' => 'bi-speedometer2', 'label' => 'Dashboard', 'route' => 'dashboard.siswa'],
                ['icon' => 'bi-calendar', 'label' => 'Jadwal Pelajaran', 'route' => '#'],
                ['icon' => 'bi-clipboard-data', 'label' => 'Nilai', 'route' => '#'],
                ['icon' => 'bi-calendar-check', 'label' => 'Presensi', 'route' => '#'],
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
            <a href="{{ $menu['route'] != '#' ? route($menu['route']) : '#' }}" 
               class="sidebar-menu-item {{ request()->routeIs($menu['route']) ? 'active' : '' }}">
                <i class="bi {{ $menu['icon'] }}"></i>
                <span>{{ $menu['label'] }}</span>
            </a>
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
