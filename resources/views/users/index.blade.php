@extends('layouts.hyper')

@section('title', 'Administración | Usuarios')

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
                            <button id="btnModal" class="btn btn-primary mb-2" data-toggle="modal" data-target="#register-user-modal"><i class="mdi mdi-plus-circle mr-2"></i> <b>Registrar usuario</b></button>
                        </div>
                    </div>

                    <div class="table-responsive-sm">
                        <table id="users-datatable" class="table table-centered table-hover dt-responsive nowrap w-100 dataTable no-footer dtr-inline">
                            <thead class="thead-light">
                                <tr>
                                    <th width="4%">#</th>
                                    <th>Nombre</th>
                                    <th width="12%">Usuario</th>
                                    <th>Correo electrónico</th>
                                    <th width="25%">Rol(es)</th>
                                    <th width="10%">Status</th>
                                    <th width="7%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            	@foreach($users as $key => $user)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td class="table-user">
                                            <img src="{{ Storage::url($user->url) }}" alt="table-user" class="mr-2 rounded-circle">
                                            <a href="javascript:void(0);" class="text-body font-weight-semibold">{{ $user->name }}</a>
                                        </td>
                                        <td>{{ $user->user_name }}</td>
                                        <td><span class="font-weight-semibold">{{ $user->email_office }}</span></td>
                                        <td>{{ $user->present()->roles() }}</td>
                                        <td>{{ $user->present()->statusBadge() }}</td>
                                        <td>
                                            <a href="{{ route('usuarios.show', $user->id )}}" class="action-icon btn btn-link" data-toggle="tooltip" data-placement="top" title data-original-title="Ver información"> <i class="mdi mdi-eye"></i></a>
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

<!-- Start Modals -->
    <div id="register-user-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Registro de usuario</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('usuarios.store') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label>Nombre: <span class="text-danger">*</span></label>
                            <input class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" name="name" value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Nombre de usuario: <span class="text-danger">*</span></label>
                            <input class="form-control {{ $errors->has('user_name') ? ' is-invalid' : '' }}" type="text" name="user_name" value="{{ old('user_name') }}">
                            @if ($errors->has('user_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('user_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Correo electrónico: <span class="text-danger">*</span></label>
                            <input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" type="text" name="email" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Rol: <span class="mb-0 font-13">(Departamento)</span> <span class="text-danger">*</span></label>
                            <div class="form-inline">
                                {{-- @foreach($roles as $role)
                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input{{ $errors->has('roles[]') ? ' is-invalid' : '' }}" id="{{ $role->name }}" value="{{ $role->id }}" name="roles[]">
                                    <label class="custom-control-label" for="{{ $role->name }}">{{ $role->display_name }}</label>
                                </div>&nbsp;&nbsp;&nbsp;
                                @endforeach --}}
                                <select class="select2 form-control select2-multiple mb-2{{ $errors->has('roles[]') ? ' is-invalid' : '' }}" name="roles[]" data-toggle="select2" multiple="multiple" data-placeholder="Choose ...">
                                    <optgroup>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                            @if ($errors->has('roles[]'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('roles[]') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Contraseña: <span class="text-danger">*</span></label>
                            <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Confirmar contraseña: <span class="text-danger">*</span></label>
                            <input class="form-control" type="password" name="password_confirmation">
                        </div>
                </div>
                <div class="text-right pb-4 pr-4">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><b>Registrar</b></button>
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
    <script src="{{ asset('assets/js/vendor/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.checkboxes.min.js') }}"></script>
    <script src="{{ asset('assets/js/idioma_espanol.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#users-datatable").DataTable({
                language: idioma_espanol,
                pageLength: 10,
                order: [],
                drawCallback: function() {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded"), $(".spark-chart").each(function(t) {
                        var o = $(this).data().dataset;
                        e.series = [{
                            data: o
                        }], new ApexCharts($(this)[0], e).render()
                    })
                }
            })
        });

        @if($errors->any())
            $('#register-user-modal').modal('show');
        @endif
    </script>
@endsection
