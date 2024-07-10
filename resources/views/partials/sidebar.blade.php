{{-- SIDEBAR SECTION --}}
 <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" target="_blank">
        <img src="{{ asset('style/assets/img/Logo.png')}}" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">ANTROMAPS</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
      {{-- Menu Dashboard --}}
        <li class="nav-item">
          <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Menu Pemetaan Lokasi</h6>
        </li>
        {{-- Menu Tampilan Pemetaan Lokasi --}}
        <li class="nav-item">
          <a class="nav-link {{ request()->is('pemetaan-lokasi') ? 'active' : '' }}" href="{{ route('pemetaan-lokasi') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
             <i class="fas fa-map-marker-alt text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Gambar Pemetaan Lokasi</span>
          </a>
        </li>
        {{-- Menu Tampilan Manajemen Lokasi --}}
        <li class="nav-item">
           <a class="nav-link {{ request()->is('manajemen-lokasi') ? 'active' : '' }}" href="{{ route('manajemen-lokasi') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-file text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Manajemen Lokasi</span>
          </a>
        </li>
        @if (auth()->user()->role != 'Guest')
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Menu Informasi Pasien</h6>
        </li>
        {{-- Laman Daftar Pasien --}}
        <li class="nav-item">
           <a class="nav-link {{ request()->is('list-pasien') ? 'active' : '' }}" href="{{ route('list-pasien') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-app text-info text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Daftar Pasien</span>
          </a>
        </li>
        @endif
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Pengaturan Akun</h6>
        </li>
        {{-- Laman Profil --}}
        <li class="nav-item">
          <a class="nav-link {{ request()->is('profil') ? 'active' : '' }}" href="{{ route('profil') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Profil</span>
          </a>
        </li>
        {{-- Laman Manajemen Role User --}}
        @if (auth()->user()->role != 'Guest' && auth()->user()->role != 'Operator')
        <li class="nav-item">
           <a class="nav-link {{ request()->is('list-user') ? 'active' : '' }}" href="{{ route('list-user') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-single-copy-04 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Manajemen Role User</span>
          </a>
        </li>
        @endif
      </ul>
    </div>
    <div class="sidenav-footer mx-3 ">
      <div class="card card-plain shadow-none" id="sidenavCard">
      {{-- Logo Poltekes --}}
        <img class="w-50 mx-auto mt-5" src="{{ asset('style/assets/img/illustrations/icon-documentation.svg')}}" alt="sidebar_illustration">
        <div class="card-body text-center p-3 w-100 pt-0">
          <div class="docs-info">
            <h6 class="mb-0">Butuh Bantuan ?</h6>
            <p class="text-xs font-weight-bold mb-0">Hubungi Nomor ini untuk info lebih lanjut +62 821-XXXXXXXX</p>
          </div>
        </div>
      </div>
    </div>
  </aside>


    {{-- @can('admin')
    @endcan --}}