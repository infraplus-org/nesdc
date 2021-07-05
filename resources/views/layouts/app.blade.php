<!doctype html>
<html class="no-js " lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">

    <title>การจัดการโครงการ</title>
    <link rel="icon" href="{{ asset('Content/Assets/images/favicon.ico') }}" type="image/x-icon"><!-- Favicon-->
    <link rel="stylesheet" href="{{ asset('Content/Assets/plugins/bootstrap-4.5.3-dist/css/bootstrap.min.css') }}">
    
    @yield('css')

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('Content/Assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('Content/Assets/css/hm-style.css'.'?t='.time()) }}">
    <link rel="stylesheet" href="{{ asset('Content/Assets/css/color_skins.css') }}">
    <link rel="stylesheet" href="{{ asset('Content/Assets/css/custom.css') }}">
</head>

<body class="theme-cyan nesdc-theme">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30"><img class="zmdi-hc-spin" src="{{ asset('Content/Assets/images/logo.svg') }}" width="48" height="48" alt="Compass"></div>
            <p>Please wait...</p>
        </div>
    </div>

    @if (session('response'))
        <div id="nesdc-message-result" class="alert alert-response alert-{{ session('response')['class'] }}" tabindex="-1" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ session('response')['message'] }}
        </div>
    @endif

    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>

    <!-- Top Bar -->
    <nav class="navbar">
        <div class="col-12">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="#"><img src="{{ asset('Content/Assets/images/NESDClogo1.png') }}" width="30" alt="Compass"><span class="m-l-10">NESDC</span></a>
            </div>
            <ul class="nav navbar-nav navbar-right" id="navbarCollapse">
                @if (!Auth::check())
                    <li><a href="{{ url('register') }}" class="mega-menu" data-close="true" title="ลงทะเบียนบัญชีผู้ใช้งาน"><i class="zmdi zmdi-account-add"></i></a></li>
                    <li><a href="{{ url('login') }}" class="mega-menu" data-close="true" title="ลงชื่อเข้าใช้งาน"><i class="zmdi zmdi-power"></i></a></li>
                @else
                    <li><a>{{ Auth::user()->name }}</a><a href="{{ url('logout') }}"><i class="zmdi zmdi-power"></i></a></a></li>
                @endif
            </ul>
        </div>
    </nav>

    <!-- Menu Bar -->
    <div class="menu-container">
        <div class="menu">
            <ul class="menu-pc">
                @include('layouts.navigation')
            </ul>
        </div>
    </div>

    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <div class="menu">
            <ul class="list menu-mobile">
                @include('layouts.navigation')
            </ul>
        </div>
    </aside>

    <!-- Content -->
    @yield('content')

    <!-- Modal -->
    <div id="modal-content" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card">
                        <div class="loader" style="text-align: center;">
                            <div class="m-t-30"><img class="zmdi-hc-spin" src="{{ asset('Content/Assets/images/logo.svg') }}" width="48" height="48" alt="Compass"></div>
                            <p>Please wait...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-content-fullscreen-xl" class="modal modal-fullscreen-xl fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card">
                        <div class="loader" style="text-align: center;">
                            <div class="m-t-30"><img class="zmdi-hc-spin" src="{{ asset('Content/Assets/images/logo.svg') }}" width="48" height="48" alt="Compass"></div>
                            <p>Please wait...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery Core Js -->
     <!-- Lib Scripts Plugin Js -->
    <script src="{{ asset('Content/Assets/bundles/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('Content/Assets/plugins/bootstrap-4.5.3-dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('Content/Assets/bundles/vendorscripts.bundle.js') }}"></script> <!-- Lib Scripts Plugin Js -->

    <!-- ส่วนนี้เป็น Plugin Script เพิ่มเฉพาะที่ใช้ในเพจนั้น ๆ เท่านั้น -->
    @yield('js')

    <!-- ส่วนนี้ต้องใส่ในทุกเพจ -->
    <script src="{{ asset('Content/Assets/bundles/mainscripts.bundle.js') }}"></script>
    <script src="{{ asset('Content/Assets/bundles/mainscript.page.js') }}"></script>
    <script>
        $(document).ready(function(){
            // Countdown hide response message
            // setInterval(function(){
            //     $('div#nesdc-message-result').fadeOut('slow', function(){
            //         $(this).remove();
            //     });
            // }, 5000);

            // Initialize bootstrap plugins
            $('[data-toggle="tooltip"]').tooltip();

            $.ajaxSetup({
                statusCode: {
                    401: function(){
                        window.location.href = "{{ url('login') }}";
                    }
                }
            });

            // ป้องกันการกด Enter แล้ว Submit form
            $('form input').keydown(function (e) {
                if (e.keyCode == 13) {
                    e.preventDefault();
                    return false;
                }
            });
        }); 
    </script>

    @yield('jsscript')

</body>
</html>
