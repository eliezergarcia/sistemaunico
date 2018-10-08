@extends('layouts.hyper')

@section('title', 'Sistema | Edición de usuario')

@section('content')

<!-- Start Content-->
<div class="container-fluid">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">Menú</li>
                        <li class="breadcrumb-item">Administración</li>
                        <li class="breadcrumb-item"><a href="{{ route('usuarios.index') }}">Usuarios</a></li>
                        <li class="breadcrumb-item active">{{ $user->name }}</li>
                    </ol>
                </div>
                <h4 class="page-title">Edición de usuario</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 

    <div class="row">
        <div class="col-sm-12">
            <!-- Profile -->
            <div class="card">
                <div class="card-body profile-user-box">
                    <div class="row justify-content-between">
                        <div class="col-sm-8">
                            <div class="media">
                                <span class="float-left m-2 mr-4"><img src="{{ Storage::url($user->url) }}" style="height: 100px;" alt="" class="rounded-circle img-thumbnail"></span>
                                <div class="media-body">

                                    <h4 class="mt-1 mb-1">{{ $user->name }}</h4>
                                    <p class="font-13">{{ $user->email }}</p>

                                    <ul class="mb-0 list-inline">
                                        <li class="list-inline-item mr-3">
                                            <p class="mb-0 font-13">Departamento</p>
                                            <h5 class="mb-1">{{ $user->present()->roles() }}</h5>
                                        </li>
                                    </ul>
                                </div> <!-- end media-body-->
                            </div>
                        </div> <!-- end col-->

                        <div class="col-sm-2">
                            <div class="text-center mt-sm-0 mt-3 text-sm-right">
                                <button type="submit" class="btn btn-light btn-block" data-toggle="modal" data-target="#information-user-modal">
                                    <i class="mdi mdi-account-edit mr-1"></i> Editar información
                                </button>
                            </div>
                            <br>
                            <div class="text-center mt-sm-0 mt-3 text-sm-right">
                                <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#delete-user-modal">
                                    <i class="mdi mdi-delete mr-1"></i> Eliminar usuario
                                </button>
                            </div>
                        </div> <!-- end col-->
                    </div> <!-- end row -->

                </div> <!-- end card-body/ profile-user-box-->
            </div><!--end profile/ card -->
        </div> <!-- end col-->
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-md-6">
            <!-- Personal-Information -->
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-3">Información del usuario</h4>
                    <p class="text-muted font-13">
                    </p>

                    <hr/>

                    <div class="text-left">
                        <p class="text-muted"><strong>Usuario :</strong> <span class="ml-4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $user->user_name }}</span></p>

                        <p class="text-muted"><strong>Nombre completo :</strong> <span class="ml-2">{{ $user->name }}</span></p>

                        
                        <p class="text-muted"><strong>Correo electrónico :</strong> <span class="ml-2">{{ $user->email }}</span></p>

                        <p class="text-muted"><strong>Teléfono :</strong><span class="ml-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $user->phone }}</span></p>

                        <p class="text-muted mb-0"><strong>Redes sociales :</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a class="d-inline-block ml-2 text-muted" title="" data-placement="top" data-toggle="tooltip" href="" data-original-title="Facebook"><i class="mdi mdi-facebook"></i></a>
                            <a class="d-inline-block ml-2 text-muted" title="" data-placement="top" data-toggle="tooltip" href="" data-original-title="Twitter"><i class="mdi mdi-twitter"></i></a>
                            <a class="d-inline-block ml-2 text-muted" title="" data-placement="top" data-toggle="tooltip" href="" data-original-title="Skype"><i class="mdi mdi-skype"></i></a>
                        </p>

                    </div>
                </div>
            </div>
            <!-- Personal-Information -->
        </div> <!-- end col-->
    </div>

</div> <!-- container -->

<!-- Start Modals    -->
    <div id="information-user-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="primary-header-modalLabel">Editar información</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('usuarios.update', $user->id) }}" enctype="multipart/form-data" class="pl-3 pr-3">
                        {!! csrf_field() !!}
                        {!! method_field('PUT') !!}
                        <div class="form-group">
                            <label>Nombre completo</label>
                            <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" name="name" value="{{ $user->name }}">
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    
                        <div class="form-group">
                            <label>Nombre de usuario</label>
                            <input class="form-control{{ $errors->has('user_name') ? ' is-invalid' : '' }}" type="text" name="user_name" value="{{ $user->user_name }}">
                            @if ($errors->has('user_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('user_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Correo electrónico</label>
                            <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" type="text" name="email" value="{{ $user->email }}">
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Rol <span class="mb-0 font-13">(Departamento)</span></label>
                            <div class="form-inline">
                                @foreach($roles as $role)
                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input{{ $errors->has('roles[]') ? ' is-invalid' : '' }}" id="{{ $role->name }}" value="{{ $role->id }}" name="roles[]"{{ $user->roles->pluck('id')->contains($role->id) ? 'checked' : ''  }}>
                                    <label class="custom-control-label" for="{{ $role->name }}">{{ $role->display_name }}</label>
                                </div>&nbsp;&nbsp;&nbsp;
                                @endforeach
                            </div>
                            @if ($errors->has('roles[]'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('roles[]') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Teléfono</label>
                            <input class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" type="text" name="phone" value="{{ $user->phone }}">
                            @if ($errors->has('phone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Avatar</label>
                            <input class="form-control" type="file" name="avatar">
                        </div>
                                        

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div id="delete-user-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-warning h1 text-danger"></i>
                        <h4 class="mt-2">Precaución!</h4>
                        <p class="mt-3">¿Está seguro(a) de eliminar al usuario <b>{{ $user->name }}</b>?</p>
                        <button type="button" class="btn btn-light my-2" data-dismiss="modal">Cancelar</button>
                        <form style="display: inline;" action="{{ route('usuarios.destroy', $user->id) }}" method="POST">
                            {!! csrf_field() !!}
                            {!! method_field('DELETE') !!}
                            <button type="sumbit" class="btn btn-danger my-2">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<!-- End Modals -->
@endsection
@section('scripts')
    @if($errors->any())
        <script>
            $('#information-user-modal').modal('show');
        </script>
    @endif
    @if(session()->has('info'))
        <script>
            $.NotificationApp.send("Bien hecho!", "{{ session('info') }}", 'top-right', 'rgba(0,0,0,0.2)', 'success');
        </script>
    @endif
@endsection

