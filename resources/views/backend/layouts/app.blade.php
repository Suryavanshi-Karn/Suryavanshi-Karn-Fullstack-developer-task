<!DOCTYPE html>
<html class="loading" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="author" content="TECHVERDEN">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Admin</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('backend/img/') }}">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700,900%7CMontserrat:300,400,500,600,700,800,900" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="{{ url('backend/css/techverden.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('backend/fonts/feather/style.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('backend/fonts/simple-line-icons/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('backend/fonts/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('backend/vendors/css/perfect-scrollbar.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('backend/vendors/css/prism.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('backend/vendors/css/switchery.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('backend/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('backend/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('backend/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('backend/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('backend/css/themes/layout-dark.css') }}">
    <link rel="stylesheet" href="{{ url('backend/css/plugins/switchery.css') }}">
    <link rel="stylesheet" href="{{ url('backend/vendors/css/datatables/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('backend/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('backend/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('backend/css/pages/charts-apex.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('backend/css/apexcharts.css') }}">
    <!-- Added by arjun singh -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.8/css/intlTelInput.css" />
    <link rel="stylesheet" type="text/css" href="{{ url('backend/vendors/css/daterangepicker/daterangepicker.css') }}">
    <script src="{{ url('backend/vendors/js/core/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('backend/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ url('backend/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ url('backend/vendors/js/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('backend/vendors/js/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ url('backend/js/bootbox.min.js') }}"></script> 
    <!-- Added by arjun singh -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.8/js/intlTelInput-jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
  
.logout-button {
    position: absolute;
    bottom: 0; /* Push the logout button to the bottom */
    width: 100%; /* Ensure it spans the full width of the sidebar */
}   


</style>
</head>

<body class="vertical-layout vertical-menu 2-columns" data-menu="vertical-menu" data-col="2-columns" id="container">
    <nav class="navbar navbar-expand-lg navbar-light header-navbar navbar-fixed mt-2">
        <div class="container-fluid navbar-wrapper">
            <div class="navbar-header d-flex pull-left">
                <div class="navbar-toggle menu-toggle d-xl-none d-block float-left align-items-center justify-content-center" data-toggle="collapse"><i class="ft-menu font-medium-3"></i></div>
                <li class="nav-item mr-2 d-none d-lg-block">
                    {{-- <a class="nav-link apptogglefullscreen" id="navbar-fullscreen" href="javascript:;">
                        <i class="ft-maximize font-medium-3" style="color:black !important"></i>
                    </a> --}}
                </li>
                   
                
            </div>
            <div class="navbar-container pull-right">
                <div class="collapse navbar-collapse d-block" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                    
                    <li class="dropdown nav-item d-xl-none d-block">
    <a id="dropdownBasic3" href="#" data-toggle="dropdown" class="nav-link position-relative dropdown-toggle">
        {{ Auth::user()->name ?? 'Guest' }}
        <i class="ft-user font-medium-3 blue-grey darken-4"></i>
    </a>

                            <div class="dropdown-menu text-left dropdown-menu-right m-0 pb-0 dropdownBasic3Content" aria-labelledby="dropdownBasic2">
                                <a class="dropdown-item" href="{{url('/profile')}}">
                                    <div class="d-flex align-items-center"><i class="fa fa-user-circle-o mr-2"></i><span>Edit Profile</span></div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{url('/updatePassword')}}">
                                    <div class="d-flex align-items-center"><i class="ft-edit mr-2"></i><span>Update Password</span></div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                  @csrf
                                <a class="dropdown-item" :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    <div class="d-flex align-items-center"><i class="ft-power mr-2"></i><span>Logout</span></div>
                                </a>
                                </form>
                            </div>
                        </li>
                        <li class="dropdown nav-item mr-1"><a class="nav-link dropdown-toggle user-dropdown d-flex align-items-end" id="dropdownBasic2" href="javascript:;" data-toggle="dropdown">
                                <div class="user d-md-flex d-none mr-2"><span class="text-right"><h5 class="translateLable padding-top-sm padding-left-sm pt-1"  data-translate="welcome_to_admin_panel"><i class="fa fa-user-circle-o fa-lg mr-2"></i>{{ Auth::user()->name ?? 'Guest' }} <i class="fa fa-caret-down" aria-hidden="true"></i></h5></span></div>
                            </a>
                            <div class="dropdown-menu text-left dropdown-menu-right m-0 pb-0" aria-labelledby="dropdownBasic2"><a class="dropdown-item" href="{{url('/profile')}}">
                                    <div class="d-flex align-items-center"><i class="ft-edit mr-2"></i><span>Edit Profile</span></div>
                                </a><a class="dropdown-item" href="{{url('/updatePassword')}}">
                                    <div class="d-flex align-items-center"><i class="fa fa-key fa-lg mr-2"></i><span>Update Password</span></div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                  @csrf
                                <a class="dropdown-item" :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    <div class="d-flex align-items-center"><i class="ft-power mr-2"></i><span>Logout</span></div>
                                </a>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="wrapper">
        <!-- <div class="app-sidebar menu-fixed" data-background-color="man-of-steel" data-image="{{ url('backend/img/sidebar-bg/01.jpg') }}" data-scroll-to-active="true"> -->
        <div class="app-sidebar menu-fixed" data-background-color="man-of-steel" data-image="" data-scroll-to-active="true">
            <div class="sidebar-header">
                <div class="logo clearfix">
                    <a class="logo-text float-left" href="dashboard">
                        <div class="logo-img" style="">
                            <!-- <img id="sidebar-logo" src="{{ url('backend/img/') }}" alt="Logo"/> -->
                        </div>
                    </a>
                    <a class="nav-toggle d-none d-lg-none d-xl-block is-active"  id="sidebarToggle" href="javascript:;"><i id="left-menu-icon" class="toggle-icon ft-arrow-left-circle" data-toggle="collapsed"></i></a>
                    <a class="nav-close d-block d-lg-block d-xl-none" id="sidebarClose" href="javascript:;"><i class="ft-x"></i></a>
                </div>
            </div>
            <div class="sidebar-content main-menu-content scroll">
                <div class="nav-container">
                    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                        <!-- Dashboard -->
                        <li class="nav-item {{ Request::path() ==  'dashboard' ? 'active' : ''  }}">
                            <a href="{{url('/dashboard')}}"><i class="ft-home"></i><span class="menu-title" data-i18n="Documentation">Dashboard</span></a>
                        </li>
                        <li class="nav-item {{ Request::path() == 'teacher' ? 'active' : '' }}">
                            <a href="{{ url('teacher') }}">
                                <i class="fa fa-chalkboard-teacher"></i>
                                <span class="menu-title" data-i18n="Documentation">Teacher</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::path() == 'student' ? 'active' : '' }}">
                            <a href="{{ url('student') }}">
                                <i class="fa fa-user-graduate"></i>
                                <span class="menu-title" data-i18n="Documentation">Student</span>
                            </a>
                        </li>
                    </ul>

                <ul class="navigation logout-button">
                    <li class="nav-item {{ Request::path() == 'logout' ? 'active' : '' }}">
                        <a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out-alt"></i>
                            <span class="menu-title" data-i18n="Documentation">Logout</span>
                        </a>
                        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>


                </div>
            </div>
            
            <div class="sidebar-background"></div>
        </div>
        <div class="main-panel">
            @yield('content')
            <footer class="footer">
                <p class="clearfix text-muted m-0"><span>Copyright &copy; <?php echo date("Y"); ?> &nbsp;</span><span class="d-none d-sm-inline-block"> All rights reserved.</span></p>
            </footer>
            <button class="btn btn-primary scroll-top" type="button"><i class="ft-arrow-up"></i></button>
        </div>
        <div class="sidenav-overlay"></div>
        <div class="drag-target"></div>
    </div>
</body>
<script src="{{ url('backend/vendors/js/switchery.min.js') }}"></script>
<script src="{{ url('backend/vendors/js/apexcharts.min.js') }}"></script>
<!-- <script src="{{ url('backend/js/charts-apex.js') }}"></script> -->
<script src="{{ url('backend/js/core/app-menu.js') }}"></script>
<script src="{{ url('backend/js/core/app.js') }}"></script>
<script src="{{ url('backend/js/notification-sidebar.js') }}"></script>
<script src="{{ url('backend/js/customizer.js') }}"></script>
<script src="{{ url('backend/js/scroll-top.js') }}"></script>
<script src="{{ url('backend/js/scripts.js') }}"></script>
<script src="{{ url('backend/js/techverden.min.js') }}"></script>
<script src="{{ url('backend/js/select2.min.js') }}"></script>
<script src="{{ url('backend/js/sweetalert2.all.min.js') }}"></script>
<script src="{{ url('backend/js/dropzone.min.js') }}"></script>
<script src="{{ url('backend/vendors/js/pickadate/picker.js') }}"></script>
<script src="{{ url('backend/vendors/js/pickadate/picker.date.js') }}"></script>
<script src="{{ url('backend/vendors/js/pickadate/picker.time.js') }}"></script>
<script src="{{ url('backend/vendors/js/daterangepicker/moment.min.js') }}"></script>
<script src="{{ url('backend/vendors/js/daterangepicker/daterangepicker.min.js') }}"></script>
<script src="{{ url('backend/js/ajax-custom.js') }}"></script>

</html>