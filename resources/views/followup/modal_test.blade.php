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
    <link rel="stylesheet" href="{{ asset('Content/Assets/css/hm-style.css') }}">
    <link rel="stylesheet" href="{{ asset('Content/Assets/css/color_skins.css') }}">
    <link rel="stylesheet" href="{{ asset('Content/Assets/css/custom.css') }}">
    <style>
        .modal {
            position: inherit;
        }
    </style>
</head>

<body class="theme-cyan nesdc-theme">
<div id="modal-content-fullscreen-xl" class="modal modal-fullscreen-xl fade show" style="padding-right: 17px; display: block;" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

@yield('content')


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
    });
</script>

@yield('jsscript')

</div>
</body>
</html>