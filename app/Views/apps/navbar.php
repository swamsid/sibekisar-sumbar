<!-- partial:partials/_navbar.html -->

<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="<?php  echo base_url('apps/dashboard') ?>">
            <img src="<?php echo base_url("assets/images/logo-sibekisar.png") ?>" alt="logo" class="logo-dark" />
            <img src="<?php echo base_url("assets/images/logo-sibekisar.png") ?>" alt="logo-light" class="logo-light">
        </a>
        <a class="navbar-brand brand-logo-mini" href="<?php echo base_url('apps/dashboard')?>"><img src="<?php echo base_url("assets/images/logo-mini.svg") ?>" alt="logo" /></a>
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="icon-menu"></span>
        </button>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center">
        <h5 class="mb-0 font-weight-medium d-none d-lg-flex">Selamat datang di aplikasi SIBEKISAR</h5>
        <ul class="navbar-nav navbar-nav-right">
           <!--<form class="search-form d-none d-md-block" action="#">
                <i class="icon-magnifier"></i>
                <input type="search" class="form-control" placeholder="Search Here" title="Search here">
            </form>
            <li class="nav-item"><a href="#" class="nav-link"><i class="icon-chart"></i></a></li>-->

            <li class="nav-item dropdown d-xl-inline-flex user-dropdown">
                <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                    <img class="img-xs rounded-circle ml-2" src="<?php echo base_url("assets/images/logo.png") ?>" alt="Profile image"> <span class="font-weight-normal"><?php echo (isset($user)?$user->nama:'') ?> </span></a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                    <div class="dropdown-header text-center">
                        <img class="img-md rounded-circle" src="<?php echo base_url("assets/images/logo.png") ?>" alt="Profile image">
                        <p class="mb-1 mt-3"><?php echo (isset($user)?$user->nama:'') ?></p>
                        <p class="font-weight-light text-muted mb-0"><?php echo (isset($user)?$user->email:'') ?></p>
                    </div>
                    <a class="dropdown-item" href="<?php echo base_url('apps/profile') ?>"><i class="dropdown-item-icon icon-user text-primary"></i> Ganti Password</a>
                    <!--<a class="dropdown-item"><i class="dropdown-item-icon icon-speech text-primary"></i> Messages</a>
                    <a class="dropdown-item"><i class="dropdown-item-icon icon-energy text-primary"></i> Activity</a>
                    <a class="dropdown-item"><i class="dropdown-item-icon icon-question text-primary"></i> FAQ</a>-->
                    <a class="dropdown-item" href="<?php echo base_url('auth/logout') ?>"><i class="dropdown-item-icon icon-power text-primary"></i>Sign Out</a>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="icon-menu"></span>
        </button>
    </div>
</nav>