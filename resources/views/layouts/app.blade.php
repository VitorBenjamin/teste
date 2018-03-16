<!DOCTYPE html>
<html lang="pt-br" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>{{config('constantes.title')}}</title>

    <!-- Favicon-->
    <link rel="icon"  href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <!-- <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet"> -->
    {!! Html::style('plugins/bootstrap/css/bootstrap.min.css') !!}

    <!-- Waves Effect Css -->
    <!-- <link href="plugins/node-waves/waves.css" rel="stylesheet" />-->
    {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/node-waves/0.7.5/waves.min.css') !!}

    <!-- Animation Css -->
    <!-- <link href="plugins/animate-css/animate.css" rel="stylesheet" />-->
    {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css') !!} 

    <!-- Sweetalert Css -->
    {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css') !!}

    <!-- Morris Chart Css-->
    <!-- <link href="plugins/morrisjs/morris.css" rel="stylesheet" />-->

    <!-- JQuery DataTable Css -->
    <!-- <link href="../../plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">-->  
    {!! Html::style('plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.min.css') !!}
    {!! Html::style('https://cdn.datatables.net/responsive/2.2.0/css/responsive.dataTables.min.css') !!}


    <!-- Bootstrap Material Datetime Picker Css -->
    <!-- <link href="../../plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" /> -->
    {!! Html::style('plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.min.css') !!}

    <!-- Wait Me Css -->
    <!-- <link href="../../plugins/waitme/waitMe.css" rel="stylesheet" /> -->
    {!! Html::style('plugins/waitme/waitMe.min.css') !!}

    <!--     {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/ajax-bootstrap-select/1.4.3/css/ajax-bootstrap-select.min.css') !!} -->
    <!-- <link href="../../plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" /> -->
    {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css') !!}
    
    {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css') !!}

    <!-- Custom Css -->
    <!-- <link href="css/style.css" rel="stylesheet">-->
    {!! Html::style('css/style.min.css') !!}

    
    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <!-- <link href="css/themes/all-themes.css" rel="stylesheet" />-->
    {!! Html::style('css/themes/theme-black.min.css') !!}

</head>
<body id="app-layout" class="theme-black {{Auth::guest() == true ? 'login-page' : ''}}">
    
    @if (Auth::guest())
    {{-- <li><a href="{{ route('login') }}">Login</a></li>
    <li><a href="{{ route('register') }}">Register</a></li> --}}
    

    @yield('content-login')
    @else
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-black">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Por favor Aguarde...</p>
        </div>
    </div>
    
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Top Bar -->
    
    @include('layouts._includes._nav')

    <!-- Left Sidebar -->
    @include('layouts._includes._aside-left')

    <!-- Right Sidebar -->
    @include('layouts._includes._aside-right')

    @yield('content')

    <!-- JavaScripts -->

    <!-- Jquery Core Js -->
    {!! Html::script('https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js') !!}

    <!-- Bootstrap Core Js -->
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js') !!}

    
    
    <!-- Jquery Validation Plugin Css -->
    {!! Html::script('/plugins/jquery-validation/jquery.validate.js') !!}

    <!-- JQuery Steps Plugin Js -->
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.1.0/jquery.steps.min.js') !!}
    {!! Html::script('/js/pages/forms/form-wizard.js') !!}
    
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js') !!}
    <!-- Select Plugin Js -->
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js') !!}

    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/ajax-bootstrap-select/1.4.3/js/ajax-bootstrap-select.min.js') !!}
    
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js') !!}
    <!-- Moment Plugin Js -->
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.4/moment.min.js') !!}
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.4/locale/pt-br.js') !!}
<!-- Bootstrap Material Datetime Picker Plugin Js -->
    {!! Html::script('/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') !!}
    
    {!! Html::script('/js/script.js') !!}
    
    <!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script> -->
    
    <!-- Slimscroll Plugin Js -->
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js') !!}

    <!-- Jquery CountTo Plugin Js -->
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/jquery-countto/1.2.0/jquery.countTo.min.js') !!}

    <!-- Autosize Plugin Js -->
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/autosize.js/4.0.0/autosize.min.js') !!}

    

    <!-- Waves Effect Plugin Js -->
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/node-waves/0.7.5/waves.min.js') !!}

    <!-- Input Mask Plugin Js -->
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js') !!}

    

    <!-- Jquery DataTable Plugin Js -->
    @yield('scripts')
    @stack('scripts')
    
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/js/jquery.dataTables.min.js') !!}
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/js/dataTables.bootstrap.min.js') !!}
    {!! Html::script('https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js')!!}
    {!! Html::script('https://cdn.datatables.net/plug-ins/1.10.16/sorting/date-uk.js')!!}
    {!! Html::script('https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js') !!}
    {!! Html::script('https://cdn.datatables.net/buttons/1.5.0/js/buttons.flash.min.js') !!}
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js') !!}
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.34/pdfmake.min.js') !!}
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.34/vfs_fonts.js') !!}
    {!! Html::script('https://cdn.datatables.net/buttons/1.5.0/js/buttons.html5.min.js') !!}
    {!! Html::script('https://cdn.datatables.net/buttons/1.5.0/js/buttons.print.min.js') !!}
    <!-- Sparkline Chart Plugin Js -->
    <!-- {!! Html::script('/plugins/jquery-sparkline/jquery.sparkline.js') !!} -->
    <!-- Custom Js -->

    <!-- SweetAlert Plugin Js -->
    {!! Html::script('/plugins/sweetalert/sweetalert.min.js') !!}


    {!! Html::script('/js/admin.min.js') !!}
    {!! Html::script('/js/pages/ui/dialogs.min.js') !!}
    {!! Html::script('/js/pages/tables/jquery-datatable.js') !!}
    {!! Html::script('/js/pages/forms/basic-form-elements.min.js') !!}
    {!! Html::script('/js/pages/forms/advanced-form-elements.js') !!}
    {!! Html::script('/js/pages/ui/tooltips-popovers.js') !!}

    {!! Html::script('/js/pages/ui/modals.js') !!}
    @endif
    <!-- {!! Html::script('/js/pages/index.min.js') !!} -->

    <!-- Demo Js -->
    <!-- {!! Html::script('/js/demo.min.js') !!} -->
</body>
</html>