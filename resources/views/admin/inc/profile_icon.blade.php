<div class="dropdown d-inline-block">
    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-1.jpg"
            alt="Header Avatar">
        <span class="d-none d-xl-inline-block ms-1" key="t-henry">Henry</span>
        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-end">
        <!-- item-->
        <a class="dropdown-item" href="#"><i
                class="bx bx-user font-size-16 align-middle me-1"></i> <span
                key="t-profile">Profile</span></a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-danger" href="{{ route('admin.logout') }}"><i
                class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span
                key="t-logout">Logout</span></a>
    </div>
</div>
