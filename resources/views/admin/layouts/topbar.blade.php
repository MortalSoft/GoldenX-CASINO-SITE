<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="/admin" class="logo logo-dark">
                    <span class="logo-sm">
                        WINX.PW
                    </span>
                    <span class="logo-lg">
                        WINX.PW
                    </span>
                </a>

                <a href="/admin" class="logo logo-light">
                    <span class="logo-sm">
                        WINX.PW
                    </span>
                    <span class="logo-lg">
                        WINX.PW
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

          

    </div>

    <style type="text/css">
    .logo span{
        color: white;
        font-size: 22px;
    }
</style>

    <div class="d-flex">

       

        <div class="dropdown d-none d-lg-inline-block ms-1">
            <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                <i class="bx bx-fullscreen"></i>
            </button>
        </div>


        <div class="dropdown d-inline-block">
            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="rounded-circle header-profile-user" src="{{ isset(Auth::user()->avatar) ? asset(Auth::user()->avatar) : asset('/assets/images/users/avatar-1.jpg') }}"
                    alt="Header Avatar">
                <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{ucfirst(Auth::user()->name)}}</span>
                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <!-- item-->
                <a href="/admin/user/{{Auth::user()->id}}" class="dropdown-item" href="contacts-profile"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Мой профиль</span></a>
                
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" href="/" ><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Выйти из админки</span></a>
                
            </div>
        </div>

        <div class="dropdown d-inline-block">
            <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                <i class="bx bx-cog bx-spin"></i>
            </button>
        </div>
        
    </div>
</div>
</header>
