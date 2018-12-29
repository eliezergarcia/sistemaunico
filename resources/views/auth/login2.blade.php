<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/app.js') }}" defer></script>

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
</head>
<body class="auth-fluid-pages pb-0">

    <div class="auth-fluid">
        <!--Auth fluid left content -->
        <div class="auth-fluid-form-box">
            <div class="align-items-center d-flex h-100">
                <div class="card-body">

                    <!-- Logo -->
                    <div class="auth-brand text-center text-lg-left">
                        <a href="javascript: void(0);">
                            <img src="{{ asset('assets/images/logos/ULHQ_LOGO-2.jpg') }}" alt="" height="45">
                            {{-- <img src="{{ asset('assets/images/logos/unico.jpg') }}" alt="" height="75"> --}}
                        </a>
                    </div>

                    <!-- title-->
                    <h4 class="mt-0">Inicio de sesión</h4>
                    <p class="text-muted mb-4">Ingresa tu usuario y contraseña para acceder al sistema.</p>

                    <!-- form -->
                    <form class="" method="POST" action="{{ route('login') }}" novalidate>
                        {{ csrf_field() }}

                        <div class="form-group mb-3">
                            <label for="user_name">Usuario</label>
                            <input class="form-control{{ $errors->has('user_name') ? ' is-invalid' : '' }}" type="user_name" name="user_name" placeholder="Ingres tu nombre de usuario" value="{{ old('user_name') }}" focus>
                            @if ($errors->has('user_name'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('user_name') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <a href="pages-recoverpw-2.html" class="text-muted float-right"><small>Olvidaste tu contraseña?</small></a>
                            <label for="password">Contraseña</label>
                            <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" name="password" placeholder="Ingresa tu contraseña" value="{{ old('password') }}">
                            @if ($errors->has('password'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="remember" class="custom-control-input" id="checkbox-signin" {{ old('remember') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="checkbox-signin">Recuérdame</label>
                            </div>
                        </div>
                        <div class="form-group mb-0 text-center">
                            <button class="btn btn-primary btn-block" type="submit"><b><i class="mdi mdi-login"></i> Iniciar sesión</b> </button>
                        </div>
                    </form>
                    <!-- end form-->
                </div> <!-- end .card-body -->
            </div> <!-- end .align-items-center.d-flex.h-100-->
        </div>
        <!-- end auth-fluid-form-box-->

        <!-- Auth fluid right content -->
        <div class="auth-fluid-right text-center">
            <div class="auth-user-testimonial">
                {{-- <h2 class="mb-3">I love the color!</h2> --}}
                <p class="lead"><i class="mdi mdi-format-quote-open"></i> Lo suficientemente pequeño para cuidar, lo suficientemente grande para entregar. <i class="mdi mdi-format-quote-close"></i>
                </p>
                <p>
                    {{-- - Hyper Admin User --}}
                </p>
            </div> <!-- end auth-user-testimonial-->
        </div>
        <!-- end Auth fluid right content -->
    </div>
    <!-- end auth-fluid-->

    <!-- App js -->
    <script>
        @if(session()->has('info'))
            $.NotificationApp.send("Información!", "{{ session('info') }}", 'top-right', 'rgba(0,0,0,0.2)', 'info');
        @endif
    </script>
</body>
