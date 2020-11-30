<!DOCTYPE html>
<html>
<head>
  <title>@yield('title')</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- CSRF Token -->
  <meta name="_token" content="{{ csrf_token() }}">
  
  <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}">
  <!-- plugin css -->
<link rel="stylesheet" href="{{asset('assets/fonts/feather-font/css/iconfont.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.css')}}">
  <!-- end plugin css -->
  <link href="toastr.css" rel="stylesheet"/>

  @stack('plugin-styles')

  <!-- common css -->
  <link rel="stylesheet" href="{{asset('css/app.css')}}">
   @toastr_css
  <!-- end common css -->

  @stack('style')
</head>
<body data-base-url="{{url('/')}}" class="loaded nimbus-is-editor settings-open sidebar-dark">
<script src="{{asset('assets/js/spinner.js')}}"></script>


  <div class="main-wrapper" id="app">
    @include('admin.layout.sidebar')
    <div class="page-wrapper">
      @include('admin.layout.header')
      <div class="page-content">
        @yield('content')
      </div>
      @include('admin.layout.footer')
    </div>
  </div>

    <!-- base js -->
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('assets/plugins/feather-icons/feather.min.js')}}"></script>
    <script src="{{asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
    <!-- end base js -->

    <!-- plugin js -->
    @stack('plugin-scripts')
    <!-- end plugin js -->

    <!-- common js -->
    <script src="{{asset('assets/js/template.js')}}"></script>
    <!-- end common js -->
    
    @stack('custom-scripts')
    {{--  toastr  --}}
   
</body>
    @jquery
    @toastr_js
    @toastr_render
</html>