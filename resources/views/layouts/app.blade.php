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
  {!! Html::style('plugins/bootstrap/css/bootstrap.css') !!}

  <!-- Waves Effect Css -->
  <!-- <link href="plugins/node-waves/waves.css" rel="stylesheet" />-->
  {!! Html::style('plugins/node-waves/waves.css') !!}

  <!-- Animation Css -->
  <!-- <link href="plugins/animate-css/animate.css" rel="stylesheet" />-->
  {!! Html::style('plugins/animate-css/animate.css') !!} 

  <!-- Sweetalert Css -->
  {!! Html::style('plugins/sweetalert/sweetalert.css') !!}

  <!-- Morris Chart Css-->
  <!-- <link href="plugins/morrisjs/morris.css" rel="stylesheet" />-->

  <!-- JQuery DataTable Css -->
  <!-- <link href="../../plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">-->  
  {!! Html::style('plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') !!}
  {!! Html::style('https://cdn.datatables.net/responsive/2.2.0/css/responsive.dataTables.min.css') !!}


  <!-- Bootstrap Material Datetime Picker Css -->
  <!-- <link href="../../plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" /> -->
  {!! Html::style('plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') !!}

  <!-- Dropzone Css -->
  {!! Html::style('/plugins/dropzone/dropzone.css') !!}
  
  <!-- Wait Me Css -->
  <!-- <link href="../../plugins/waitme/waitMe.css" rel="stylesheet" /> -->
  {!! Html::style('plugins/waitme/waitMe.css') !!}

  <!-- <link href="../../plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" /> -->
  {!! Html::style('plugins/bootstrap-select/css/bootstrap-select.css') !!}

  {!! Html::style('css/ajax-bootstrap-select.css') !!}
  
  <!-- Custom Css -->
  <!-- <link href="css/style.css" rel="stylesheet">-->
  {!! Html::style('css/style.css') !!}

  <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
  <!-- <link href="css/themes/all-themes.css" rel="stylesheet" />-->
  {!! Html::style('css/themes/theme-black.css') !!}

</head>
<body id="app-layout" class="theme-black {{Auth::guest() == true ? 'login-page' : ''}}">

  @if (Auth::guest())
 <!--  <li><a href="{{ route('login') }}">Login</a></li>
 <li><a href="{{ route('register') }}">Register</a></li> -->
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

@endif

 <!-- JavaScripts -->

 <!-- Jquery Core Js -->
 {!! Html::script('/plugins/jquery/jquery.min.js') !!}


 <!-- Bootstrap Core Js -->
 {!! Html::script('/plugins/bootstrap/js/bootstrap.js') !!}

 <!-- Dropzone Plugin Js -->
 <!--  {!! Html::script('/plugins/dropzone/dropzone.js') !!} -->

 <!-- Select Plugin Js -->
 {!! Html::script('/plugins/bootstrap-select/js/bootstrap-select.js') !!}

 {!! Html::script('/js/ajax-bootstrap-select.js') !!}

 {!! Html::script('/js/script.js') !!}

 <!-- Slimscroll Plugin Js -->
 {!! Html::script('/plugins/jquery-slimscroll/jquery.slimscroll.js') !!}

 <!-- Jquery Validation Plugin Css -->
 {!! Html::script('/plugins/jquery-validation/jquery.validate.js') !!}

 <!-- JQuery Steps Plugin Js -->
 {!! Html::script('/plugins/jquery-steps/jquery.steps.js') !!}

 <!-- Jquery CountTo Plugin Js -->
 {!! Html::script('/plugins/jquery-countto/jquery.countTo.js') !!}

 <!-- Autosize Plugin Js -->
 {!! Html::script('/plugins/autosize/autosize.js') !!}

 <!-- Moment Plugin Js -->
 {!! Html::script('/plugins/momentjs/moment.js') !!}
 {!! Html::script('/plugins/momentjs/pt-br.js') !!}

 <!-- Waves Effect Plugin Js -->
 {!! Html::script('/plugins/node-waves/waves.js') !!}

 <!-- Input Mask Plugin Js -->
 {!! Html::script('/plugins/jquery-inputmask/jquery.inputmask.bundle.js') !!}

 <!-- Bootstrap Material Datetime Picker Plugin Js -->
 {!! Html::script('/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') !!}

 <!-- Jquery DataTable Plugin Js -->
 {!! Html::script('/plugins/jquery-datatable/jquery.dataTables.js') !!}
 {!! Html::script('/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') !!}
 {!! Html::script('https://cdn.datatables.net/responsive/2.2.0/js/dataTables.responsive.min.js')!!}
 {!! Html::script('/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js') !!}
 {!! Html::script('/plugins/jquery-datatable/extensions/export/buttons.flash.min.js') !!}
 {!! Html::script('/plugins/jquery-datatable/extensions/export/jszip.min.js') !!}
 {!! Html::script('/plugins/jquery-datatable/extensions/export/pdfmake.min.js') !!}
 {!! Html::script('/plugins/jquery-datatable/extensions/export/vfs_fonts.js') !!}
 {!! Html::script('/plugins/jquery-datatable/extensions/export/buttons.html5.min.js') !!}
 {!! Html::script('/plugins/jquery-datatable/extensions/export/buttons.print.min.js') !!}
 <!-- Sparkline Chart Plugin Js -->
 <!-- {!! Html::script('/plugins/jquery-sparkline/jquery.sparkline.js') !!} -->
 <!-- Custom Js -->

 <!-- SweetAlert Plugin Js -->
 {!! Html::script('/plugins/sweetalert/sweetalert.min.js') !!}


 {!! Html::script('/js/admin.js') !!}
 {!! Html::script('/js/pages/ui/dialogs.js') !!}
 {!! Html::script('/js/pages/forms/form-wizard.js') !!}
 {!! Html::script('/js/pages/tables/jquery-datatable.js') !!}
 {!! Html::script('/js/pages/forms/basic-form-elements.js') !!}
 {!! Html::script('/js/pages/forms/advanced-form-elements.js') !!}
 {!! Html::script('/js/pages/ui/modals.js') !!}

 <!-- {!! Html::script('/js/pages/index.js') !!} -->

 <!-- Demo Js -->
 <!-- {!! Html::script('/js/demo.js') !!} -->
</body>
</html>
