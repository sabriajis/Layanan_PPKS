<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">PPKS</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">PB</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('dashboard-general-dashboard') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ url('dashboard-general-dashboard') }}">General Dashboard</a>
                    </li>

                </ul>
            </li>


            <li class="nav-item dropdown">
            {{-- @can('view users') <!-- Hanya tampilkan menu ini jika pengguna memiliki izin 'view users' --> --}}
            {{-- @if(auth()->user()->role === 'admin') --}}
            @role('admin|anggota')
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Users</span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="{{ route('user.index') }}">All Users</a>
                    </li>

                </ul>
                {{-- @endif --}}
                {{-- @endcan --}}

                @endrole
            </li>

            @role('anggota')
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Tampilan Pengaduan</span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="{{ route('pengaduan.index') }}">Tampilan Pengaduan</a>
                    </li>
                </ul>
            </li>
            @endrole

            @role('user')
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Buat Pengaduan</span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="{{ route('pengaduan.create') }}">Buat Pengaduan</a>
                    </li>
                </ul>
            </li>
            @endrole


            {{-- <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>tampilan Pengaduan</span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="{{ route('pengaduan.show') }}">Pengaduan Saya</a>
                    </li>
                </ul>
            </li> --}}

            {{-- <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Categories</span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="{{ route('categories.index') }}">All Category</a>
                    </li>

                </ul>
            </li> --}}
        </ul>
    </aside>
</div>
