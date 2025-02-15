<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Online Exam</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="/vendors/feather/feather.css">
    <link rel="stylesheet" href="/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="js/select.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="js/select.dataTables.min.css">
<!-- Dans la section head de votre layout -->
<link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.9.55/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- inject:css -->
    <link rel="stylesheet" href="/css/vertical-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="/images/favicon.png" />
    <link rel="shortcut icon" href="/images/.png" />


</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html  headd -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
            <a class="navbar-brand brand-logo mr-5" href="{{ route('admin.dashboard') }}">
                <div class="logo-container" style="display: flex; align-items: center;">
                    <i class="ti-write mr-2" style="font-size: 24px; color: #4CAF50;"></i>
                    <span style="font-size: 20px; font-weight: bold; background: linear-gradient(45deg, #4CAF50, #2196F3); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        ExamOnline
                    </span>
                </div>
            </a>
            <a class="navbar-brand brand-logo-mini" href="{{ route('admin.dashboard') }}">
                <i class="ti-write" style="font-size: 24px; color: #4CAF50;"></i>
            </a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="icon-menu"></span>
                </button>
                <ul class="navbar-nav mr-lg-2">
                    <li class="nav-item nav-search d-none d-lg-block">
                        <div class="input-group">
                            <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                                <span class="input-group-text" id="search">
                                    <i class="icon-search"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now"
                                aria-label="search" aria-describedby="search">
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item">
                        <button id="darkModeToggle" class="btn" style="margin-right: 15px;">
                            <i class="ti-light-bulb" style="font-size: 1.2rem;"></i>
                        </button>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#"
                            data-toggle="dropdown">
                            <i class="icon-bell mx-0"></i>
                            <span class="count"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                            aria-labelledby="notificationDropdown">
                            <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-success">
                                        <i class="ti-info-alt mx-0"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject font-weight-normal">Application Error</h6>
                                    <p class="font-weight-light small-text mb-0 text-muted">
                                        Just now
                                    </p>
                                </div>
                            </a>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-warning">
                                        <i class="ti-settings mx-0"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject font-weight-normal">Settings</h6>
                                    <p class="font-weight-light small-text mb-0 text-muted">
                                        Private message
                                    </p>
                                </div>
                            </a>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-info">
                                        <i class="ti-user mx-0"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject font-weight-normal">New user registration</h6>
                                    <p class="font-weight-light small-text mb-0 text-muted">
                                        2 days ago
                                    </p>
                                </div>
                            </a>
                        </div>
                    </li>
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                            @php
                                $admin = session('LoggedAdminInfo');
                                $hasPicture = false;
                                $picturePath = '';
                                
                                if (is_object($admin)) {
                                    $hasPicture = !empty($admin->picture);
                                    $picturePath = $admin->picture ?? '';
                                } elseif (is_array($admin)) {
                                    $hasPicture = !empty($admin['picture']);
                                    $picturePath = $admin['picture'] ?? '';
                                }
                            @endphp

                            @if ($hasPicture)
                                <img src="{{ asset('storage/' . $picturePath) }}" alt="Profile">
                            @else
                                <img src="{{ asset('images/default-avatar.png') }}" alt="Default Profile">
                            @endif
                        </a>
                        
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                            aria-labelledby="profileDropdown">
                            <a class="dropdown-item">
                                <i class="ti-settings text-primary"></i>
                                Settings
                            </a>
                           <!-- <form action= route(admin.logout) }} method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="ti-power-off text-primary"></i>
                                    Logout
                                </button>
                            </form>-->
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="ti-power-off text-primary"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </li>
                     <li class="nav-item nav-settings d-none d-lg-flex">
                        <a class="nav-link" href="#">
                            <i class="icon-ellipsis"></i>
                        </a>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                data-toggle="offcanvas">
                <span class="icon-menu"></span>
            </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_settings-panel.html -->
            <div class="theme-setting-wrapper">
                <div id="settings-trigger"><i class="ti-settings"></i></div>
                <div id="theme-settings" class="settings-panel">
                    <i class="settings-close ti-close"></i>
                    <p class="settings-heading">SIDEBAR SKINS</p>
                    <div class="sidebar-bg-options selected" id="sidebar-light-theme">
                        <div class="img-ss rounded-circle bg-light border mr-3"></div>Light
                    </div>
                    <div class="sidebar-bg-options" id="sidebar-dark-theme">
                        <div class="img-ss rounded-circle bg-dark border mr-3"></div>Dark
                    </div>
                    <p class="settings-heading mt-2">HEADER SKINS</p>
                    <div class="color-tiles mx-0 px-4">
                        <div class="tiles success"></div>
                        <div class="tiles warning"></div>
                        <div class="tiles danger"></div>
                        <div class="tiles info"></div>
                        <div class="tiles dark"></div>
                        <div class="tiles default"></div>
                    </div>
                </div>
            </div>
            <div id="right-sidebar" class="settings-panel">
                <i class="settings-close ti-close"></i>
                <ul class="nav nav-tabs border-top" id="setting-panel" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="todo-tab" data-toggle="tab" href="#todo-section" role="tab"
                            aria-controls="todo-section" aria-expanded="true">TO DO LIST</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="chats-tab" data-toggle="tab" href="#chats-section" role="tab"
                            aria-controls="chats-section">CHATS</a>
                    </li>
                </ul>
                <div class="tab-content" id="setting-content">
                    <div class="tab-pane fade show active scroll-wrapper" id="todo-section" role="tabpanel"
                        aria-labelledby="todo-section">
                        <div class="add-items d-flex px-3 mb-0">
                            <form class="form w-100">
                                <div class="form-group d-flex">
                                    <input type="text" class="form-control todo-list-input" placeholder="Add To-do">
                                    <button type="submit" class="add btn btn-primary todo-list-add-btn"
                                        id="add-task">Add</button>
                                </div>
                            </form>
                        </div>
                        <div class="list-wrapper px-3">
                            <ul class="d-flex flex-column-reverse todo-list">
                                <li>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="checkbox" type="checkbox">
                                            Team review meeting at 3.00 PM
                                        </label>
                                    </div>
                                    <i class="remove ti-close"></i>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="checkbox" type="checkbox">
                                            Prepare for presentation
                                        </label>
                                    </div>
                                    <i class="remove ti-close"></i>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="checkbox" type="checkbox">
                                            Resolve all the low priority tickets due today
                                        </label>
                                    </div>
                                    <i class="remove ti-close"></i>
                                </li>
                                <li class="completed">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="checkbox" type="checkbox" checked>
                                            Schedule meeting for next week
                                        </label>
                                    </div>
                                    <i class="remove ti-close"></i>
                                </li>
                                <li class="completed">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="checkbox" type="checkbox" checked>
                                            Project review
                                        </label>
                                    </div>
                                    <i class="remove ti-close"></i>
                                </li>
                            </ul>
                        </div>
                        <h4 class="px-3 text-muted mt-5 font-weight-light mb-0">Events</h4>
                        <div class="events pt-4 px-3">
                            <div class="wrapper d-flex mb-2">
                                <i class="ti-control-record text-primary mr-2"></i>
                                <span>Feb 11 2018</span>
                            </div>
                            <p class="mb-0 font-weight-thin text-gray">Creating component page build a js</p>
                            <p class="text-gray mb-0">The total number of sessions</p>
                        </div>
                        <div class="events pt-4 px-3">
                            <div class="wrapper d-flex mb-2">
                                <i class="ti-control-record text-primary mr-2"></i>
                                <span>Feb 7 2018</span>
                            </div>
                            <p class="mb-0 font-weight-thin text-gray">Meeting with Alisa</p>
                            <p class="text-gray mb-0 ">Call Sarah Graves</p>
                        </div>
                    </div>
                    <!-- To do section tab ends -->
                    <div class="tab-pane fade" id="chats-section" role="tabpanel" aria-labelledby="chats-section">
                        <div class="d-flex align-items-center justify-content-between border-bottom">
                            <p class="settings-heading border-top-0 mb-3 pl-3 pt-0 border-bottom-0 pb-0">Friends</p>
                            <small
                                class="settings-heading border-top-0 mb-3 pt-0 border-bottom-0 pb-0 pr-3 font-weight-normal">See
                                All</small>
                        </div>
                        <ul class="chat-list">
                            <li class="list active">
                                <div class="profile"><img src="images/faces/face1.jpg" alt="image"><span
                                        class="online"></span></div>
                                <div class="info">
                                    <p>Thomas Douglas</p>
                                    <p>Available</p>
                                </div>
                                <small class="text-muted my-auto">19 min</small>
                            </li>
                            <li class="list">
                                <div class="profile"><img src="images/faces/face2.jpg" alt="image"><span
                                        class="offline"></span></div>
                                <div class="info">
                                    <div class="wrapper d-flex">
                                        <p>Catherine</p>
                                    </div>
                                    <p>Away</p>
                                </div>
                                <div class="badge badge-success badge-pill my-auto mx-2">4</div>
                                <small class="text-muted my-auto">23 min</small>
                            </li>
                            <li class="list">
                                <div class="profile"><img src="images/faces/face3.jpg" alt="image"><span
                                        class="online"></span></div>
                                <div class="info">
                                    <p>Daniel Russell</p>
                                    <p>Available</p>
                                </div>
                                <small class="text-muted my-auto">14 min</small>
                            </li>
                            <li class="list">
                                <div class="profile"><img src="images/faces/face4.jpg" alt="image"><span
                                        class="offline"></span></div>
                                <div class="info">
                                    <p>James Richardson</p>
                                    <p>Away</p>
                                </div>
                                <small class="text-muted my-auto">2 min</small>
                            </li>
                            <li class="list">
                                <div class="profile"><img src="images/faces/face5.jpg" alt="image"><span
                                        class="online"></span></div>
                                <div class="info">
                                    <p>Madeline Kennedy</p>
                                    <p>Available</p>
                                </div>
                                <small class="text-muted my-auto">5 min</small>
                            </li>
                            <li class="list">
                                <div class="profile"><img src="images/faces/face6.jpg" alt="image"><span
                                        class="online"></span></div>
                                <div class="info">
                                    <p>Sarah Graves</p>
                                    <p>Available</p>
                                </div>
                                <small class="text-muted my-auto">47 min</small>
                            </li>
                        </ul>
                    </div>
                    <!-- chat tab ends -->
                </div>
            </div>
            <!-- partial -->
            <!-- partial:partials/_sidebar.html JAANNBB  -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        @if(session('LoggedUserRole') === 'admin')
            <!-- Admin Menu -->
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
            <!-- Rest of your existing admin menu items -->
            
            @elseif(session('LoggedUserRole') === 'formateur')
    <!-- Formateur Menu -->
    <li class="nav-item">
        <a class="nav-link {{ request()->is('formateur/dashboard') ? 'active' : '' }}"
            href="{{ route('formateur.dashboard') }}">
            <i class="icon-grid menu-icon"></i>
            <span class="menu-title">Dashboard</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('formateur.profile') }}">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Profile</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('cours.index') }}">
            <i class="fas fa-book menu-icon"></i>
            <span class="menu-title">Cours</span>
        </a>
    </li>

    <li class="nav-item menu-groupe">
        <a class="nav-link" href="{{ route('groupes.index') }}">
            <i class="fas fa-users menu-icon"></i>
            <span class="menu-title">Groupes</span>
        </a>
    </li>

    <!-- Examens Dropdown -->
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#examens" aria-expanded="false">
            <i class="fas fa-clipboard-check menu-icon"></i>
            <span class="menu-title">Examens</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="examens">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('examens.index') }}">
                        <span class="menu-title">Liste des Examens</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('examens.create') }}">
                        <span class="menu-title">Créer un Examen</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('examens.corrections.list') }}">
                        <span class="menu-title">Corrections</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>

    <!-- Stagiaires Dropdown -->
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#stagiaire" aria-expanded="false">
            <i class="fas fa-users menu-icon"></i>
            <span class="menu-title">Stagiaires</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="stagiaire">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('stagiaire.index') }}">
                        <span class="menu-title">List Stagiaire</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <form action="{{ route('logout') }}" method="POST" class="nav-link">
            @csrf
            <button type="submit" class="btn btn-link text-danger p-0">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
    </li>
        @elseif(session('LoggedUserRole') === 'stagiaire')
            <!-- Stagiaire Menu -->
            <li class="nav-item">
                <a class="nav-link {{ request()->is('stagiaire/dashboard') ? 'active' : '' }}"
                    href="{{ route('stagiaire.dashboard') }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('stagiaire.profile') }}">
                    <i class="icon-layout menu-icon"></i>
                    <span class="menu-title">Profile</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('stagiaire.examens') }}">
                    <i class="fas fa-clipboard-check menu-icon"></i>
                    <span class="menu-title">Mes Examens</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('stagiaire.cours') }}">
                    <i class="fas fa-book menu-icon"></i>
                    <span class="menu-title">Mes Cours</span>
                </a>
            </li>
        @endif

       
    </ul>
</nav>
            
            
                @yield('content') <!-- Content Section -->
            



    
        </div>
    </div>
</div>
    <!-- container-scroller -->

    <!-- plugins:js -->
    <script src="/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="/vendors/chart.js/Chart.min.js"></script>
    <script src="/vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <script src="/js/dataTables.select.min.js"></script>

    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="/js/off-canvas.js"></script>
    <script src="/js/hoverable-collapse.js"></script>
    <script src="/js/template.js"></script>
    <script src="/js/settings.js"></script>
    <script src="/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="/js/dashboard.js"></script>
    <script src="/js/Chart.roundedBarCharts.js"></script>
    <!-- End custom js for this page-->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const darkModeToggle = document.getElementById('darkModeToggle');
        const body = document.body;
        
        // Check for saved dark mode preference
        if (localStorage.getItem('darkMode') === 'enabled') {
            body.classList.add('dark-mode');
            darkModeToggle.innerHTML = '<i class="ti-light-bulb" style="font-size: 1.2rem; color: #ffd700;"></i>';
        }

        // Toggle dark mode
        darkModeToggle.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
            
            // Save preference
            if (body.classList.contains('dark-mode')) {
                localStorage.setItem('darkMode', 'enabled');
                darkModeToggle.innerHTML = '<i class="ti-light-bulb" style="font-size: 1.2rem; color: #ffd700;"></i>';
            } else {
                localStorage.setItem('darkMode', null);
                darkModeToggle.innerHTML = '<i class="ti-light-bulb" style="font-size: 1.2rem;"></i>';
            }
        });
    });
    </script>

    <style>
    /* Base dark mode styles */
    body.dark-mode {
        background-color: #1a1a1a !important;
        color: #e4e4e4 !important;
    }

    /* Main wrapper styles */
    body.dark-mode .container-scroller {
        background-color: #1a1a1a !important;
    }

    /* Navbar styles */
    body.dark-mode .navbar {
        background-color: #2d2d2d !important;
        border-bottom: 1px solid #3d3d3d !important;
    }

    body.dark-mode .navbar .navbar-brand-wrapper {
        background-color: #2d2d2d !important;
        border-right: 1px solid #3d3d3d !important;
    }

    body.dark-mode .navbar .navbar-menu-wrapper {
        background-color: #2d2d2d !important;
    }

    /* Sidebar styles */
    body.dark-mode .sidebar {
        background-color: #2d2d2d !important;
        border-right: 1px solid #3d3d3d !important;
    }

    body.dark-mode .sidebar .nav .nav-item .nav-link {
        color: #e4e4e4 !important;
    }

    body.dark-mode .sidebar .nav .nav-item.active .nav-link {
        background: #3d3d3d !important;
    }

    body.dark-mode .sidebar .nav .nav-item .nav-link i {
        color: #e4e4e4 !important;
    }

    /* Main panel styles */
    body.dark-mode .main-panel {
        background-color: #1a1a1a !important;
    }

    body.dark-mode .content-wrapper {
        background-color: #1a1a1a !important;
    }

    /* Footer styles */
    body.dark-mode footer {
        background-color: #2d2d2d !important;
        border-top: 1px solid #3d3d3d !important;
    }

    /* Card styles */
    body.dark-mode .card:not(.card-tale):not(.card-dark-blue):not(.card-light-blue):not(.card-light-danger) {
        background-color: #2d2d2d !important;
        border: 1px solid #3d3d3d !important;
    }

    /* Text colors */
    body.dark-mode .text-black,
    body.dark-mode .text-dark {
        color: #e4e4e4 !important;
    }

    /* Form elements */
    body.dark-mode input,
    body.dark-mode select,
    body.dark-mode textarea {
        background-color: #2d2d2d !important;
        color: #e4e4e4 !important;
        border: 1px solid #3d3d3d !important;
    }

    /* Dropdown menus */
    body.dark-mode .dropdown-menu {
        background-color: #2d2d2d !important;
        border: 1px solid #3d3d3d !important;
    }

    body.dark-mode .dropdown-item {
        color: #e4e4e4 !important;
    }

    body.dark-mode .dropdown-item:hover {
        background-color: #3d3d3d !important;
    }

    /* Table styles */
    body.dark-mode .table {
        color: #e4e4e4 !important;
    }

    body.dark-mode .table thead th {
        background-color: #3d3d3d !important;
        color: #e4e4e4 !important;
        border-color: #4d4d4d !important;
    }

    body.dark-mode .table td,
    body.dark-mode .table th {
        border-color: #4d4d4d !important;
        color: #e4e4e4 !important;
    }

    /* Settings panel */
    body.dark-mode .settings-panel {
        background-color: #2d2d2d !important;
        border-left: 1px solid #3d3d3d !important;
    }

    /* Modal styles */
    body.dark-mode .modal-content {
        background-color: #2d2d2d !important;
        color: #e4e4e4 !important;
    }

    /* Breadcrumb */
    body.dark-mode .page-title-wrapper {
        background-color: #2d2d2d !important;
    }

    /* Links */
    body.dark-mode a:not(.btn) {
        color: #45B6FE !important;
    }

    body.dark-mode a:not(.btn):hover {
        color: #2196F3 !important;
    }

    /* Ensure all headings are visible */
    body.dark-mode h1,
    body.dark-mode h2,
    body.dark-mode h3,
    body.dark-mode h4,
    body.dark-mode h5,
    body.dark-mode h6 {
        color: #e4e4e4 !important;
    }

    /* Navigation active states */
    body.dark-mode .nav-item.active > .nav-link {
        background-color: #3d3d3d !important;
    }

    /* Ensure proper transitions */
    body *,
    .navbar,
    .sidebar,
    .content-wrapper,
    .main-panel,
    .card,
    .table,
    .dropdown-menu {
        transition: all 0.3s ease !important;
    }

    /* Keep all existing styles and update/add only these card styles */

    /* Statistics Cards - Consistent colors for both light and dark modes */
    .card.card-tale,
    body.dark-mode .card.card-tale {
        background: linear-gradient(45deg, #7978e9, #4747A1) !important;
        border: none !important;
        box-shadow: 0 2px 10px rgba(71, 71, 161, 0.3) !important;
    }

    .card.card-dark-blue,
    body.dark-mode .card.card-dark-blue {
        background: linear-gradient(45deg, #47b3ff, #2196F3) !important;
        border: none !important;
        box-shadow: 0 2px 10px rgba(33, 150, 243, 0.3) !important;
    }

    .card.card-light-blue,
    body.dark-mode .card.card-light-blue {
        background: linear-gradient(45deg, #66bb6a, #43a047) !important;
        border: none !important;
        box-shadow: 0 2px 10px rgba(76, 175, 80, 0.3) !important;
    }

    .card.card-light-danger,
    body.dark-mode .card.card-light-danger {
        background: linear-gradient(45deg, #ff6b6b, #f44336) !important;
        border: none !important;
        box-shadow: 0 2px 10px rgba(244, 67, 54, 0.3) !important;
    }

    /* Ensure text in cards is always white and visible */
    .card.card-tale *,
    .card.card-dark-blue *,
    .card.card-light-blue *,
    .card.card-light-danger *,
    body.dark-mode .card.card-tale *,
    body.dark-mode .card.card-dark-blue *,
    body.dark-mode .card.card-light-blue *,
    body.dark-mode .card.card-light-danger * {
        color: #ffffff !important;
    }

    /* Card hover effects */
    .card.card-tale:hover,
    .card.card-dark-blue:hover,
    .card.card-light-blue:hover,
    .card.card-light-danger:hover,
    body.dark-mode .card.card-tale:hover,
    body.dark-mode .card.card-dark-blue:hover,
    body.dark-mode .card.card-light-blue:hover,
    body.dark-mode .card.card-light-danger:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.3) !important;
    }

    /* Ensure card body stays transparent */
    .card.card-tale .card-body,
    .card.card-dark-blue .card-body,
    .card.card-light-blue .card-body,
    .card.card-light-danger .card-body,
    body.dark-mode .card.card-tale .card-body,
    body.dark-mode .card.card-dark-blue .card-body,
    body.dark-mode .card.card-light-blue .card-body,
    body.dark-mode .card.card-light-danger .card-body {
        background: transparent !important;
    }

    /* Card text styles */
    .card .fs-30,
    body.dark-mode .card .fs-30 {
        font-size: 2rem !important;
        font-weight: 600 !important;
        margin-bottom: 0.5rem !important;
    }

    .card .mb-4,
    body.dark-mode .card .mb-4 {
        font-size: 1.1rem !important;
        font-weight: 400 !important;
    }

    /* Enhanced Table Styles for ALL tables */
    body.dark-mode table,
    body.dark-mode .table,
    body.dark-mode .datatable,
    body.dark-mode .dataTable,
    body.dark-mode .table-bordered,
    body.dark-mode .table-responsive {
        background-color: #2d2d2d !important;
        color: #e4e4e4 !important;
    }

    body.dark-mode table th,
    body.dark-mode table td,
    body.dark-mode .table th,
    body.dark-mode .table td {
        background-color: #2d2d2d !important;
        color: #e4e4e4 !important;
        border-color: #3d3d3d !important;
    }

    body.dark-mode table thead th,
    body.dark-mode .table thead th {
        background-color: #3d3d3d !important;
        color: #ffffff !important;
        border-bottom: 2px solid #4d4d4d !important;
    }

    /* Table striping */
    body.dark-mode .table-striped tbody tr:nth-of-type(odd) {
        background-color: #262626 !important;
    }

    body.dark-mode .table-hover tbody tr:hover {
        background-color: #363636 !important;
        color: #ffffff !important;
    }

    /* Comprehensive Text Color Fixes */
    body.dark-mode *:not(.btn):not(.card-tale *):not(.card-dark-blue *):not(.card-light-blue *):not(.card-light-danger *) {
        color: #e4e4e4 !important;
    }

    body.dark-mode h1,
    body.dark-mode h2,
    body.dark-mode h3,
    body.dark-mode h4,
    body.dark-mode h5,
    body.dark-mode h6,
    body.dark-mode p,
    body.dark-mode span,
    body.dark-mode label,
    body.dark-mode div,
    body.dark-mode td,
    body.dark-mode th,
    body.dark-mode li,
    body.dark-mode input,
    body.dark-mode select,
    body.dark-mode textarea {
        color: #e4e4e4 !important;
    }

    /* Form Elements */
    body.dark-mode input,
    body.dark-mode select,
    body.dark-mode textarea,
    body.dark-mode .form-control {
        background-color: #2d2d2d !important;
        color: #e4e4e4 !important;
        border-color: #3d3d3d !important;
    }

    body.dark-mode input::placeholder,
    body.dark-mode select::placeholder,
    body.dark-mode textarea::placeholder {
        color: #888888 !important;
    }

    /* DataTables Specific */
    body.dark-mode .dataTables_wrapper .dataTables_length,
    body.dark-mode .dataTables_wrapper .dataTables_filter,
    body.dark-mode .dataTables_wrapper .dataTables_info,
    body.dark-mode .dataTables_wrapper .dataTables_processing,
    body.dark-mode .dataTables_wrapper .dataTables_paginate {
        color: #e4e4e4 !important;
    }

    body.dark-mode .dataTables_wrapper .dataTables_paginate .paginate_button {
        color: #e4e4e4 !important;
        background-color: #2d2d2d !important;
        border-color: #3d3d3d !important;
    }

    body.dark-mode .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background-color: #3d3d3d !important;
        border-color: #4d4d4d !important;
    }

    /* Modal Fixes */
    body.dark-mode .modal-content {
        background-color: #2d2d2d !important;
        border-color: #3d3d3d !important;
    }

    body.dark-mode .modal-header,
    body.dark-mode .modal-footer {
        border-color: #3d3d3d !important;
    }

    /* List Groups */
    body.dark-mode .list-group-item {
        background-color: #2d2d2d !important;
        border-color: #3d3d3d !important;
        color: #e4e4e4 !important;
    }

    /* Dropdown Menus */
    body.dark-mode .dropdown-menu {
        background-color: #2d2d2d !important;
        border-color: #3d3d3d !important;
    }

    body.dark-mode .dropdown-item {
        color: #e4e4e4 !important;
    }

    body.dark-mode .dropdown-item:hover {
        background-color: #3d3d3d !important;
    }

    /* Links */
    body.dark-mode a:not(.btn):not(.nav-link) {
        color: #45B6FE !important;
    }

    body.dark-mode a:not(.btn):not(.nav-link):hover {
        color: #2196F3 !important;
    }

    /* Card Content (except statistics cards) */
    body.dark-mode .card:not(.card-tale):not(.card-dark-blue):not(.card-light-blue):not(.card-light-danger) {
        background-color: #2d2d2d !important;
        border-color: #3d3d3d !important;
    }

    /* Alerts and Notifications */
    body.dark-mode .alert {
        background-color: #2d2d2d !important;
        border-color: #3d3d3d !important;
        color: #e4e4e4 !important;
    }

    /* Badges */
    body.dark-mode .badge {
        background-color: #3d3d3d !important;
        color: #e4e4e4 !important;
    }

    /* Search Inputs */
    body.dark-mode input[type="search"] {
        background-color: #2d2d2d !important;
        color: #e4e4e4 !important;
        border-color: #3d3d3d !important;
    }

    /* Panel Headers */
    body.dark-mode .panel-heading,
    body.dark-mode .card-header {
        background-color: #3d3d3d !important;
        border-bottom-color: #4d4d4d !important;
    }

    /* Force text color for any elements that might be missed */
    body.dark-mode [class*="text-dark"],
    body.dark-mode [class*="text-black"] {
        color: #e4e4e4 !important;
    }

    /* Chart Text Colors */
    body.dark-mode .apexcharts-text,
    body.dark-mode .apexcharts-text tspan,
    body.dark-mode .apexcharts-title-text,
    body.dark-mode .apexcharts-legend-text,
    body.dark-mode .apexcharts-xaxis-label,
    body.dark-mode .apexcharts-yaxis-label,
    body.dark-mode .apexcharts-yaxis-title,
    body.dark-mode .apexcharts-xaxis-title {
        fill: #e4e4e4 !important;
        color: #e4e4e4 !important;
    }

    body.dark-mode .apexcharts-legend-series {
        color: #e4e4e4 !important;
    }

    body.dark-mode .apexcharts-yaxis text,
    body.dark-mode .apexcharts-xaxis text {
        fill: #e4e4e4 !important;
    }

    /* Chart tooltip */
    body.dark-mode .apexcharts-tooltip {
        background-color: #2d2d2d !important;
        border: 1px solid #3d3d3d !important;
        color: #e4e4e4 !important;
    }

    body.dark-mode .apexcharts-tooltip-title {
        background-color: #3d3d3d !important;
        border-bottom: 1px solid #4d4d4d !important;
        color: #e4e4e4 !important;
    }

    /* Logo styles */
    .navbar-brand {
        padding: 15px 0;
    }

    .logo-container {
        transition: all 0.3s ease;
    }

    .logo-container:hover {
        transform: scale(1.05);
    }

    /* Dark mode support for logo */
    body.dark-mode .logo-container span {
        background: linear-gradient(45deg, #66bb6a, #64b5f6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    body.dark-mode .navbar-brand.brand-logo-mini i,
    body.dark-mode .logo-container i {
        color: #66bb6a !important;
    }
    </style>



</body>

</html>