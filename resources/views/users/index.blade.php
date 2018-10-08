@extends('layouts.hyper')

@section('title', 'Sistema | Usuarios')

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
                        <li class="breadcrumb-item active">Usuarios</li>
                    </ol>
                </div>
                <h4 class="page-title">Usuarios</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <button id="btnModal" class="btn btn-primary mb-2" data-toggle="modal" data-target="#register-user-modal"><i class="mdi mdi-plus-circle mr-2"></i> Agregar usuario</button>
                        </div>
                        <!-- <div class="col-sm-8">
                            <div class="text-sm-right">
                                <button type="button" class="btn btn-info mb-2 mr-1"><i class="mdi mdi-settings"></i></button>
                                <button type="button" class="btn btn-light mb-2">Export</button>
                            </div>
                        </div> -->
                    </div>

                    <div class="table-responsive-sm">
                        <table id="users-datatable" class="table table-centered table-hover w-100 dt-responsive nowrap">
                            <thead class="thead-light">
                                <tr>
                                    <!-- <th style="width: 20px;">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                                            <label class="custom-control-label" for="customCheck1">&nbsp;</label>
                                        </div>
                                    </th> -->
                                    <th>Nombre completo</th>
                                    <th>Usuario</th>
                                    <th>Correo electrónico</th>
                                    <th>Rol</th>
                                    <th style="width: 50px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            	@foreach($users as $user)
                                <tr>
                                    <!-- <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck2">
                                            <label class="custom-control-label" for="customCheck2">&nbsp;</label>
                                        </div>
                                    </td> -->
                                    <td class="table-user">
                                        <img src="{{ Storage::url($user->url) }}" alt="table-user" class="mr-2 rounded-circle">
                                        <a href="javascript:void(0);" class="text-body font-weight-semibold">{{ $user->name }}</a>
                                    </td>
                                    <td>
                                        {{ $user->user_name }}
                                    </td>
                                    <td>
                                        <span class="font-weight-semibold">{{ $user->email }}</span>
                                    </td>
                                    <td>
                                        {{ $user->present()->roles() }}
                                    </td>
                                    <td>
                                        <a href="{{ route('usuarios.edit', $user->id )}}" class="action-icon btn btn-link" data-toggle="tooltip" data-placement="top" title data-original-title="Ver información"> <i class="mdi mdi-eye-settings"></i></a>
                                        <!-- <form name="frmDeleteUser{{$user->id}}" style="display: inline;" action="{{ route('usuarios.destroy', $user->id) }}" method="POST">
                                            {!! csrf_field() !!}
                                            {!! method_field('DELETE') !!}
                                            <button class="action-icon btn btn-link" type="submit" 
                                                data-toggle="tooltip" data-placement="top" 
                                                title data-original-title="Eliminar usuario">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </form> -->
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->
    
</div> <!-- container -->

<!-- Start Modals	 -->
    <div id="register-user-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="primary-header-modalLabel">Registro de usuario</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">

                    <div class="text-center mt-2 mb-4">
                        <p>Ingresa la siguiente información para registrar al usuario.</p>
                    </div>
                    
                    <form method="POST" action="{{ route('usuarios.store') }}" enctype="multipart/form-data" class="pl-3 pr-3">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label>Nombre completo</label>
                            <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" name="name" value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    
                        <div class="form-group">
                            <label>Nombre de usuario</label>
                            <input class="form-control{{ $errors->has('user_name') ? ' is-invalid' : '' }}" type="text" name="user_name" value="{{ old('user_name') }}">
                            @if ($errors->has('user_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('user_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Correo electrónico</label>
                            <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" type="text" name="email" value="{{ old('email') }}">
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
                                    <input type="checkbox" class="custom-control-input{{ $errors->has('roles[]') ? ' is-invalid' : '' }}" id="{{ $role->name }}" value="{{ $role->id }}" name="roles[]">
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
                            <label>Contraseña</label>
                            <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Confirmar contraseña</label>
                            <input class="form-control" type="password" name="password_confirmation">
                        </div>

                        <div class="form-group">
                            <label>Avatar</label>
                            <input class="form-control" type="file" name="avatar">
                        </div>
                                        

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Registrar usuario</button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
<!-- /.modal -->
    
<!-- End Modals -->
@endsection

@section('scripts')
  <script>
    $(document).ready(function() {
        $("#users-datatable").DataTable({
            language: {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                    },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }             
            },
            pageLength: 5,
            drawCallback: function() {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded"), $(".spark-chart").each(function(t) {
                    var o = $(this).data().dataset;
                    e.series = [{
                        data: o
                    }], new ApexCharts($(this)[0], e).render()
                })
            }
        })

        $('#register-user-modal').on('shown.bs.modal', function (e) {
            
        })

        // function abrirModal(){
        //     $('#register-user-modal').modal('show');
        // }
  });
  </script>
    @if($errors->any())
        <script>
            $('#register-user-modal').modal('show');
        </script>
    @endif
    @if(session()->has('info'))
        <script>
            $.NotificationApp.send("Bien hecho!", "{{ session('info') }}", 'top-right', 'rgba(0,0,0,0.2)', 'success');
        </script>
    @endif
@endsection
