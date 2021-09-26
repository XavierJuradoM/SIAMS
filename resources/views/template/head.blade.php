<head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <!-- Meta, title, CSS, favicons, etc. -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="icon" href="img/favicon.ico" type="image/ico" />

      <title>SIAMS | @yield('title')</title>

      <!-- Bootstrap -->
      <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
      <!-- Font Awesome -->
      <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
      <!-- NProgress -->
      <link href="{{ asset('css/nprogress.css') }}" rel="stylesheet">
      <!-- iCheck -->
      <link href="{{ asset('css/flat/green.css') }}" rel="stylesheet">

      <!-- bootstrap-progressbar -->
      <link href="{{ asset('css/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet">
      <!-- JQVMap -->
      <link href="{{ asset('css/jqvmap.min.css') }}" rel="stylesheet" />
      <!-- bootstrap-daterangepicker -->
      <link href="{{ asset('css/daterangepicker.css') }}" rel="stylesheet">

      <!-- Custom Theme Style -->
      <link href="{{ asset('css/custom.min.css') }}" rel="stylesheet">
      <link href="{{ asset('css/leaflet.css') }}" rel="stylesheet">
      <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet">

      {{-- For create grafics charts --}}
      <link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
      <script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
      <script src="{{asset('js/chartist-plugin-threshold.js')}}"></script>
      <script src="{{asset('js/chartist-plugin-pointlabels.js')}}"></script>

      <script src="https://kit.fontawesome.com/dfea41f182.js" crossorigin="anonymous"></script>

      @yield('estilo')
      <link href="{{ asset('css/base.css') }}" rel="stylesheet">
      
  </head>