{{-- HEADER SECTION --}}
<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur"
    data-scroll="false">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <h6 class="font-weight-bolder text-white mt-4 text-lg">@yield('title')</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                {{-- Kolom Search --}}
            </div>
            <ul class="navbar-nav  justify-content-end">
                <li class="nav-item d-flex align-items-center">
                    <a href="{{ route('profil') }}" class="nav-link text-white font-weight-bold px-0">
                        <i class="bi bi-person me-sm-1"></i>
                        <span class="d-sm-inline d-none">{{ auth()->user()->name }}</span>
                    </a>
                </li>
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                        </div>
                    </a>
                </li>
                <li class="nav-item dropdown px-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-gear me-sm-1"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton" style="border-radius: 0.375rem; box-shadow: none;">
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="{{ route('profil') }}">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <i class="bi bi-person-circle avatar avatar-sm bg-gradient-primary me-3"></i>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold" style="color: black;">Profil</span>
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">
                                            Laman User Profil
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="mb-2">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <a class="dropdown-item border-radius-md" href="javascript:;" onclick="document.getElementById('logout-form').submit();">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <i class="bi bi-box-arrow-right avatar avatar-sm bg-gradient-primary me-3"></i>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold" style="color: black;">Logout</span>
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">
                                            Laman Login
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->
