<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

@section('htmlheader')
    @include('adminlte::super_layout.partials.htmlheader')
@show

<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="skin-black-light  sidebar-mini">
<div id="app">
    <div class="wrapper">

    @include('adminlte::super_layout.partials.mainheader')

    @include('adminlte::super_layout.partials.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        @yield('header')
        <!-- Main content -->
        <section class="content">
            <!-- Your Page Content Here -->
            @yield('main-content')
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    @include('adminlte::super_layout.partials.controlsidebar')

    @include('adminlte::super_layout.partials.footer')

</div><!-- ./wrapper -->
</div>
@section('scripts')
    @include('adminlte::super_layout.partials.scripts')
@show
<script src="{{ asset('/plugins/select2/select2.js') }}" type="text/javascript"></script>
@yield('footer-script')
    <script>

    $('.select2').select2();
    // Enable pusher logging - don't include this in production
    //Pusher.logToConsole = true;

    var pusher = new Pusher('a07b0f4928ae83a12227', {
      cluster: 'ap1',
      forceTLS: true
    });

    var channel = pusher.subscribe('loading-channel');
    channel.bind('loading-notification', function(data) {
      if(JSON.stringify(data.notification) != null){
          alertmessage = data.notification;
          alertmessage = alertmessage.replace(/"/g, "'");
          toastr.warning(alertmessage,'Message!');
      }
    });
  </script>

</body>
</html>
