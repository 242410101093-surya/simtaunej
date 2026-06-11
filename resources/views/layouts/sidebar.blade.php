<div class="col-md-3 col-lg-2 d-md-block sidebar-modern min-vh-100 py-4 shadow-sm">
    <div class="position-sticky pt-3">
        
        <ul class="nav flex-column gap-2">
            
            @if(auth()->user()->role === 'dosen')
                <li class="nav-item">
                    <div class="nav-link {{ request()->routeIs('dosen.dashboard') ? 'active' : '' }}" 
                         style="cursor: pointer;" 
                         onclick="window.top.location.href='{{ route('dosen.dashboard') }}';">
                        <i class="bi bi-speedometer2 me-3 fs-5"></i>
                        <span>Dashboard</span>
                    </div>
                </li>
                
                <li class="nav-item">
                    <div class="nav-link {{ request()->routeIs('dosen.mahasiswa.*') ? 'active' : '' }}" 
                         style="cursor: pointer;" 
                         onclick="window.top.location.href='{{ route('dosen.mahasiswa.index') }}';">
                        <i class="bi bi-people me-3 fs-5"></i>
                        <span>Data Mahasiswa</span>
                    </div>
                </li>
                
                <li class="nav-item">
                    <div class="nav-link {{ request()->routeIs('dosen.appointments.*') ? 'active' : '' }}" 
                         style="cursor: pointer;" 
                         onclick="window.top.location.href='{{ route('dosen.appointments.index') }}';">
                        <i class="bi bi-calendar3 me-3 fs-5"></i>
                        <span>Jadwal Bimbingan</span>
                    </div>
                </li>

            @elseif(auth()->user()->role === 'mahasiswa')
                <li class="nav-item">
                    <div class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                         style="cursor: pointer;" 
                         onclick="window.top.location.href='{{ route('dashboard') }}';">
                        <i class="bi bi-speedometer2 me-3 fs-5"></i>
                        <span>Dashboard</span>
                    </div>
                </li>
                
                {{-- MENU PENGAJUAN BIMBINGAN MAHASISWA SUDAH DIHAPUS DARI SINI --}}
                
                <li class="nav-item">
                    <div class="nav-link {{ request()->routeIs('mahasiswa.appointments.index') ? 'active' : '' }}" 
                         style="cursor: pointer;" 
                         onclick="window.top.location.href='{{ route('mahasiswa.appointments.index') }}';">
                        <i class="bi bi-calendar3 me-3 fs-5"></i>
                        <span>Jadwal Bimbingan</span>
                    </div>
                </li>

            @elseif(auth()->user()->role === 'admin')
                <li class="nav-item">
                    <div class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                         style="cursor: pointer;" 
                         onclick="window.top.location.href='{{ route('admin.dashboard') }}';">
                        <i class="bi bi-speedometer2 me-3 fs-5"></i>
                        <span>Dashboard Admin</span>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="nav-link {{ request()->routeIs('admin.mahasiswa.*') ? 'active' : '' }}" 
                         style="cursor: pointer;" 
                         onclick="window.top.location.href='{{ route('admin.mahasiswa.index') }}';">
                        <i class="bi bi-people me-3 fs-5"></i>
                        <span>Data Mahasiswa</span>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="nav-link {{ request()->routeIs('admin.dosen.*') ? 'active' : '' }}" 
                         style="cursor: pointer;" 
                         onclick="window.top.location.href='{{ route('admin.dosen.index') }}';">
                        <i class="bi bi-person-badge me-3 fs-5"></i>
                        <span>Data Dosen</span>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="nav-link {{ request()->routeIs('admin.periods*') ? 'active' : '' }}" 
                         style="cursor: pointer;" 
                         onclick="window.top.location.href='{{ route('admin.periods') }}';">
                        <i class="bi bi-calendar3 me-3 fs-5"></i>
                        <span>Jadwal Bimbingan</span>
                    </div>
                </li>
            @endif
            
        </ul>

    </div>
</div>