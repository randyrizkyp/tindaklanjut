<div class="page">
	<div class="page-main">

        <!-- app-Header -->
        <div class="app-header header sticky">
            <div class="container-fluid main-container">
                <div class="d-flex">
                    <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-bs-toggle="sidebar" href="javascript:void(0)"></a>
                    <!-- sidebar-toggle-->
                    <a class="logo-horizontal " href="/user">
                        <img src="/storage/image/lampura.png" style="width: 30px;" class="header-brand-img desktop-logo" alt="logo">
                        <img src="/storage/image/lampura.png" style="width: 30px;" class="header-brand-img light-logo1" alt="logo">
                    </a>

                    <div class="main-header-center ms-3 d-none d-lg-block">
                        <h1 class="page-title">{{ $title }}</h1>
                    </div>

                    <div class="d-flex order-lg-2 ms-auto header-right-icons">
                        <!-- SEARCH -->
                        <button class="navbar-toggler navresponsive-toggler d-lg-none ms-auto" type="button"
                            data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4"
                            aria-controls="navbarSupportedContent-4" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon fe fe-more-vertical"></span>
                        </button>
                        <div class="navbar navbar-collapse responsive-navbar p-0">
                            <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                                <div class="d-flex order-lg-2">                                    
                                    <div class="d-flex">
                                        <a class="nav-link icon theme-layout nav-link-bg layout-setting">
                                            <span class="dark-layout"><i class="fe fe-moon"></i></span>
                                            <span class="light-layout"><i class="fe fe-sun"></i></span>
                                        </a>
                                    </div>                                
                                    
                                    <div class="dropdown d-flex">
                                        <a class="nav-link icon full-screen-link nav-link-bg">
                                            <i class="fe fe-minimize fullscreen-button"></i>
                                        </a>
                                    </div>
                                    
                                    <div class="dropdown d-flex notifications">
                                        <a class="nav-link icon" data-bs-toggle="dropdown"><i
                                                class="fe fe-bell"></i><span class=" pulse"></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                            <div class="drop-heading border-bottom">
                                                <div class="d-flex">
                                                    <h6 class="mt-1 mb-0 fs-16 fw-semibold text-dark">Notifications
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="notifications-menu">
                                                <a class="dropdown-item d-flex" href="notify-list.html">
                                                    <div class="me-3 notifyimg  bg-primary brround box-shadow-primary">
                                                        <i class="fe fe-mail"></i>
                                                    </div>
                                                    <div class="mt-1 wd-80p">
                                                        <h5 class="notification-label mb-1">New Application received
                                                        </h5>
                                                        <span class="notification-subtext">3 days ago</span>
                                                    </div>
                                                </a>                                                
                                            </div>
                                            <div class="dropdown-divider m-0"></div>
                                            <a href="notify-list.html"
                                                class="dropdown-item text-center p-3 text-muted">View all
                                                Notification</a>
                                        </div>
                                    </div>
                                    
                                    <div class="dropdown d-flex profile-1">
                                        <a href="javascript:void(0)" data-bs-toggle="dropdown" class="nav-link leading-none d-flex">
                                            <img src="/assets/images/users/21.jpg" alt="profile-user" class="avatar  profile-user brround cover-image">
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                            <div class="drop-heading">
                                                <div class="text-center">
                                                    <h5 class="text-dark mb-0 fs-14 fw-semibold">{{ Session::get('nama') }}</h5>
                                                    <small class="text-muted">Admin</small>
                                                </div>
                                            </div>
                                            <div class="dropdown-divider m-0"></div>
                                            <a class="dropdown-item" href="#">
                                                <i class="dropdown-icon fe fe-user"></i> Profil
                                            </a>                                           
                                            <a class="dropdown-item" href="/signout">
                                                <i class="dropdown-icon fe fe-alert-circle"></i> Log out
                                            </a>
                                        </div>
                                    </div>

                                    <div class="d-flex">
                                        <img src="/storage/image/yaibettah.png" style="width: 30px;">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /app-Header -->