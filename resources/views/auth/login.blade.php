@extends('layouts.app')

@section('content')
<body class="authentication-bg">
    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card">

                        <!-- Logo -->
                        <div class="card-header pt-4 pb-4 text-center bg-primary">
                            <a href="index.html">
                                <img src="{{ asset('assets/images/logos/unico imagen.jpg') }}" alt="" height="45">
                            </a>
                        </div>

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center mt-0 font-weight-bold">Inicio de sesión</h4>
                                <p class="text-muted mb-4">Ingresa tu usuario y contraseña para acceder al panel de administración.</p>
                            </div>

                            <form class="{{ $errors->any() ? 'needs-validation was-validated' : '' }}" method="POST" action="{{ route('login') }}" novalidate>
                                {{ csrf_field() }}

                                <div class="form-group mb-3">
                                    <label for="user_name">Usuario</label>
                                    <input class="form-control{{ $errors->has('user_name') ? ' is-invalid' : '' }}" type="user_name" name="user_name" placeholder="Usuario" value="{{ old('user_name') }}">
                                    @if ($errors->has('user_name'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('user_name') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password">Contraseña</label>
                                    <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" name="password" placeholder="Contraseña" value="{{ old('password') }}">
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
                                    <button class="btn btn-primary" type="submit"> Ingresar </button>
                                </div>

                            </form>
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <!-- App js -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
</body>
@endsection
