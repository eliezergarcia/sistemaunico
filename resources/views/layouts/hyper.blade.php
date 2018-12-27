<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <title>@yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">


        <!-- third party css -->
        <link href="{{ asset('assets/css/vendor/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/vendor/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/vendor/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
        <!-- third party css end -->

        <!-- App css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

    </head>

    <body>
    {{-- <body class="enlarged" data-keep-enlarged="true"> --}}

        <!-- Begin page -->
        <div class="wrapper">
            @include('layouts.left-sidebar')

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    @include('layouts.topbar')

                    <!-- Start Content-->
                    @yield('content')

                </div> <!-- content -->
            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->
        </div>
        <!-- END wrapper -->


        <!-- @@include('./partials/right-sidebar.html') -->


        <!-- App js -->
        <script src="{{ asset('assets/js/app.min.js') }}"></script>
        <script src="{{ asset('assets/js/axios.min.js') }}"></script>
        <script src="{{ asset('assets/js/vendor/jquery-ui.min.js') }}"></script>
        {{-- <script src="{{ asset('assets/js/vendor/dropzone.min.js') }}"></script>
        <script src="{{ asset('assets/js/ui/component.fileupload.js') }}"></script>
        <script src="{{ asset('assets/js/vendor/fullcalendar.min.js') }}"></script>
        <script src="{{ asset('assets/js/vendor/apexcharts.min.js') }}"></script>
        <script src="{{ asset('assets/js/vendor/dataTables.checkboxes.min.js') }}"></script>
        <script src="{{ asset('assets/js/vendor/dragula.min.js') }}"></script>
        <script src="{{ asset('assets/js/ui/component.dragula.js') }}"></script> --}}

        {{-- <script src="{{ asset('assets/js/pages/demo.calendar.js') }}"></script> --}}
        <!-- <script src="{{ asset('assets/js/pages/demo.sellers.js') }}"></script> -->
        @yield('scripts')
        <script>
            @if(session()->has('success'))
                $.NotificationApp.send("Bien hecho!", "{{ session('success') }}", 'top-right', 'rgba(0,0,0,0.2)', 'success');
            @endif
            @if(session()->has('error'))
                $.NotificationApp.send("Error!", "{{ session('error') }}", 'top-right', 'rgba(0,0,0,0.2)', 'error');
            @endif
            @if(session()->has('warning'))
                $.NotificationApp.send("Advertencia!", "{{ session('warning') }}", 'top-right', 'rgba(0,0,0,0.2)', 'warning');
            @endif
            @if(session()->has('info'))
                $.NotificationApp.send("Información!", "{{ session('info') }}", 'top-right', 'rgba(0,0,0,0.2)', 'info');
            @endif
        </script>
    </body>
</html>
