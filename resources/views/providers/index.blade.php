@extends('layouts.hyper')

@section('title', 'Administración | Proveedores')

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
                        <li class="breadcrumb-item active">Proveedores</li>
                    </ol>
                </div>
                <h4 class="page-title">Proveedores</h4>
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
                            <button id="btnModal" class="btn btn-primary mb-2" data-toggle="modal" data-target="#register-provider-modal"><i class="mdi mdi-plus-circle mr-2"></i> <b>Registrar proveedor</b></button>
                            <button class="btn btn-info mb-2" data-toggle="modal" data-target="#import-providers-modal"><i class="mdi mdi-file-import"></i> <b>Cargar proveedores</b></button>
                        </div>
                    </div>

                    <div class="table-responsive-sm">
                        <table id="providers-datatable" class="table table-centered table-striped table-hover table-striped table-striped dt-responsive nowrap w-100 dataTable no-footer dtr-inline">
                            <thead>
                                <tr>
                                    <th width="4%">#</th>
                                    <th>Código</th>
                                    <th>Razón Social</th>
                                    <th>R.F.C</th>
                                    <th width="7%">Status</th>
                                    <th width="7%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            	@foreach($providers as $key => $provider)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $provider->codigo_proveedor }}</td>
                                    <td>{{ $provider->razon_social }}</td>
                                    <td>{{ $provider->rfc }}</td>
                                    <td>{{ $provider->present()->statusBadge() }}</td>
                                    <td>
                                        <a href="{{ route('proveedores.show', $provider->id )}}" class="action-icon btn btn-link" data-toggle="tooltip" data-placement="top" title data-original-title="Ver información"> <i class="mdi mdi-eye"></i></a>
                                        @if(!$provider->inactive_at)
                                            <button class="btn btn-link action-icon" type="button" data-toggle="tooltip" data-placement="top" title data-original-title="Editar información" onclick="information_provider_modal({{ $provider->id }})"> <i class="mdi mdi-square-edit-outline"></i></button>
                                            <button id="btnModal" class="btn btn-link action-icon" data-toggle="tooltip" data-placemente="top" data-original-title="Agregar cuenta"
                                            onclick="account_bank({{ $provider->id }});"><i class="mdi mdi-bank"></i></button>
                                            <button class="btn btn-link action-icon"
                                            data-toggle="tooltip" data-placemente="top" data-original-title="Desactivar proveedor"
                                            onclick="deactivate_provider({{ $provider->id }});"><i class="mdi mdi-close-box-outline">
                                            </i></button>
                                        @else
                                            <button class="btn btn-link action-icon"
                                            data-toggle="tooltip" data-placemente="top" data-original-title="Activar proveedor"
                                            onclick="activate_provider({{ $provider->id }});"><i class="mdi mdi-checkbox-marked-outline"></i></button>
                                        @endif
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
    <div id="register-provider-modal" class="modal fade" tabindex="" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Registro de proveedor</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('proveedores.store') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="form-group col-3">
                                <label>Código de proveedor: <span class="text-danger">*</span></label>
                                <input class="form-control {{ $errors->has('codigo_proveedor') ? ' is-invalid' : '' }}" type="text" name="codigo_proveedor" value="{{ old('codigo_proveedor') }}">
                                @if ($errors->has('codigo_proveedor'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('codigo_proveedor') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group col-9">
                                <label>Razón social: <span class="text-danger">*</span></label>
                                <input class="form-control {{ $errors->has('razon_social') ? ' is-invalid' : '' }}" type="text" name="razon_social" value="{{ old('razon_social') }}">
                                @if ($errors->has('razon_social'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('razon_social') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group col-6">
                                <label>RFC:</label>
                                <input class="form-control {{ $errors->has('rfc') ? ' is-invalid' : '' }}" type="text" name="rfc" value="{{ old('rfc') }}">
                                @if ($errors->has('rfc'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('rfc') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label>Número interior: </label>
                                <input class="form-control {{ $errors->has('numero_interior') ? ' is-invalid' : '' }}" type="text" name="numero_interior" value="{{ old('numero_interior') }}">
                                @if ($errors->has('numero_interior'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('numero_interior') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label>Número exterior: </label>
                                <input class="form-control {{ $errors->has('numero_exterior') ? ' is-invalid' : '' }}" type="text" name="numero_exterior" value="{{ old('numero_exterior') }}">
                                @if ($errors->has('numero_exterior'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('numero_exterior') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label>Calle:</label>
                                <input class="form-control {{ $errors->has('calle') ? ' is-invalid' : '' }}" type="text" name="calle" value="{{ old('calle') }}">
                                @if ($errors->has('calle'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('calle') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label>Colonia:</label>
                                <input class="form-control {{ $errors->has('colonia') ? ' is-invalid' : '' }}" type="text" name="colonia" value="{{ old('colonia') }}">
                                @if ($errors->has('colonia'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('colonia') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label>Código postal:</label>
                                <input class="form-control {{ $errors->has('codigo_postal') ? ' is-invalid' : '' }}" type="text" name="codigo_postal" value="{{ old('codigo_postal') }}">
                                @if ($errors->has('codigo_postal'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('codigo_postal') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label>País:</label>
                                <input class="form-control {{ $errors->has('pais') ? ' is-invalid' : '' }}" type="text" name="pais" value="{{ old('pais') }}">
                                @if ($errors->has('pais'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('pais') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label>Estado:</label>
                                <input class="form-control {{ $errors->has('estado') ? ' is-invalid' : '' }}" type="text" name="estado" value="{{ old('estado') }}">
                                @if ($errors->has('estado'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('estado') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label>Ciudad:</label>
                                <input class="form-control {{ $errors->has('ciudad') ? ' is-invalid' : '' }}" type="text" name="ciudad" value="{{ old('ciudad') }}">
                                @if ($errors->has('ciudad'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('ciudad') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label>Municipio:</label>
                                <input class="form-control {{ $errors->has('municipio') ? ' is-invalid' : '' }}" type="text" name="municipio" value="{{ old('municipio') }}">
                                @if ($errors->has('municipio'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('municipio') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label>Teléfono #1: </label>
                                <input class="form-control {{ $errors->has('telefono1') ? ' is-invalid' : '' }}" type="text" name="telefono1" value="{{ old('telefono1') }}">
                                @if ($errors->has('telefono1'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('telefono1') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label>Teléfono #2: </label>
                                <input class="form-control {{ $errors->has('telefono2') ? ' is-invalid' : '' }}" type="text" name="telefono2" value="{{ old('telefono2') }}">
                                @if ($errors->has('telefono2'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('telefono2') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label>Service:</label>
                                <select class="form-control {{ $errors->has('service') ? ' is-invalid' : '' }}" type="text" name="service" value="{{ old('service') }}">
                                    <option value="Trucking">Trucking</option>
                                    <option value="Ocean">Ocean</option>
                                </select>
                                @if ($errors->has('service'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('service') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label>Días de crédito: </label>
                                <input class="form-control {{ $errors->has('credit_days') ? ' is-invalid' : '' }}" type="number" name="credit_days" value="{{ old('credit_days') }}">
                                @if ($errors->has('credit_days'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('credit_days') }}</strong>
                                    </span>
                                @endif
                            </div>
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

    <div id="register-account-modal" class="modal fade" tabindex="" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Registro de cuenta</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="register_account_form" method="POST" action="{{ route('cuentasproveedor.store') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        <input type="hidden" name="provider_id">
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Cuenta: <span class="text-danger">*</span></label>
                                <input class="form-control " type="text" name="account" required>
                            </div>

                            <div class="form-group col-6">
                                <label>Moneda: <span class="text-danger">*</span></label>
                                <select class="form-control select2" data-toggle="select2" type="text" name="currency" required>
                                    <option value="MXN">MXN</option>
                                    <option value="USD">USD</option>
                                </select>
                            </div>

                            <div class="form-group col-6">
                                <label>Banco: <span class="text-danger">*</span></label>
                                <input class="form-control " type="text" name="name_bank" required>
                            </div>
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

    <div id="import-providers-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Carga de proveedores</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        Para cargar correctamente los proveedores en el sistema hay que seguir los siguientes pasos:
                        <p><br><b>1.</b> El archivo a subir deberá ser de tipo Excel.</p>
                        <p><b>2.</b> El archivo a subir debe de contener solo una hoja de datos.</p>
                        <p><b>3.</b> Las filas de datos deberán seguir el siguiente orden y sin encabezados:<br>
                        </p>
                        <div class="row justify-content-between">
                            <div class="col">
                                · Código cliente<br>
                                · Razón social<br>
                                · RFC<br>
                                · Calle<br>
                                · Número interior<br>
                                · Número exterior<br>
                                · Colonia<br>
                                · Código postal<br>
                            </div>
                            <div class="col">
                                · País<br>
                                · Estado<br>
                                · Ciudad<br>
                                · Municipio<br>
                                · Teléfono #1<br>
                                · Teléfono #2<br>
                                · Días de crédito<br>
                                · Servicio<br>
                            </div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('import.providers') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="excel" class="custom-file-input">
                                <label class="custom-file-label">Selecciona el archivo:</label>
                            </div>
                        </div>
                </div>
                <div class="text-right pb-4 pr-4">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><b>Cargar</b></button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div id="information-provider-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Información de proveedor</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="information-provider-form" method="POST" action="{{ route('proveedores.modificar') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        <input type="hidden" name="provider_id">
                        <div class="row">
                            <div class="form-group col-3">
                                <label>Código de proveedor: <span class="text-danger">*</span></label>
                                <input class="form-control " type="text" name="codigo_proveedor" required>
                            </div>

                            <div class="form-group col-9">
                                <label>Razón social: <span class="text-danger">*</span></label>
                                <input class="form-control " type="text" name="razon_social" required>
                            </div>

                            <div class="form-group col-6">
                                <label>RFC:</label>
                                <input class="form-control " type="text" name="rfc">
                            </div>
                            <div class="form-group col-3">
                                <label>Número interior: </label>
                                <input class="form-control " type="text" name="numero_interior">
                            </div>
                            <div class="form-group col-3">
                                <label>Número exterior: </label>
                                <input class="form-control " type="text" name="numero_exterior">
                            </div>
                            <div class="form-group col-3">
                                <label>Calle:</label>
                                <input class="form-control " type="text" name="calle">
                            </div>
                            <div class="form-group col-3">
                                <label>Colonia:</label>
                                <input class="form-control " type="text" name="colonia">
                            </div>
                            <div class="form-group col-3">
                                <label>Código postal:</label>
                                <input class="form-control " type="text" name="codigo_postal">
                            </div>
                            <div class="form-group col-3">
                                <label>País:</label>
                                <input class="form-control " type="text" name="pais">
                            </div>
                            <div class="form-group col-3">
                                <label>Estado:</label>
                                <input class="form-control " type="text" name="estado">
                            </div>
                            <div class="form-group col-3">
                                <label>Ciudad:</label>
                                <input class="form-control " type="text" name="ciudad">
                            </div>
                            <div class="form-group col-3">
                                <label>Municipio:</label>
                                <input class="form-control " type="text" name="municipio">
                            </div>
                            <div class="form-group col-3">
                                <label>Teléfono #1: </label>
                                <input class="form-control " type="text" name="telefono1">
                            </div>
                            <div class="form-group col-3">
                                <label>Teléfono #2: </label>
                                <input class="form-control " type="text" name="telefono2">
                            </div>
                            <div class="form-group col-3">
                                <label>Service:</label>
                                <input class="form-control " type="text" name="service">
                            </div>
                            <div class="form-group col-3">
                                <label>Días de crédito: </label>
                                <input class="form-control " type="number" name="credit_days">
                            </div>
                        </div>
                </div>
                <div class="text-right pb-4 pr-4">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><b>Guardar</b></button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div id="activate-provider-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-warning h1 text-primary"></i>
                        <h4 class="mt-2">Precaución!</h4>
                        <p class="mt-3">¿Está seguro(a) de activar el proveedor?</p>
                        <button type="button" class="btn btn-light my-2" data-dismiss="modal">Cancelar</button>
                        <form id="activate_provider_form" style="display: inline;" action="{{ route('proveedores.activate') }}" method="POST">
                            {!! csrf_field() !!}
                            {{-- {!! method_field('PATCH') !!} --}}
                            <input type="hidden" name="provider_id">
                            <button type="sumbit" class="btn btn-primary my-2"><b>Activar</b></button>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="deactivate-provider-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-warning h1 text-danger"></i>
                        <h4 class="mt-2">Precaución!</h4>
                        <p class="mt-3">¿Está seguro(a) de desactivar el proveedor?</p>
                        <button type="button" class="btn btn-light my-2" data-dismiss="modal">Cancelar</button>
                        <form id="deactivate_provider_form" style="display: inline;" action="{{ route('proveedores.deactivate') }}" method="POST">
                            {!! csrf_field() !!}
                            {!! method_field('DELETE') !!}
                            <input type="hidden" name="provider_id">
                            <button type="sumbit" class="btn btn-danger my-2"><b>Desactivar</b></button>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
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
            $("#providers-datatable").DataTable({
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

        function information_provider_modal($id)
        {
            var url = '/proveedores/buscar/' + $id;
            axios.get(url).then(function(response) {
                console.log(response.data);
                $('#information-provider-form input[name=provider_id]').val($id);
                $('#information-provider-form input[name=codigo_proveedor]').val(response.data.codigo_proveedor);
                $('#information-provider-form input[name=razon_social]').val(response.data.razon_social);
                $('#information-provider-form input[name=rfc]').val(response.data.rfc);
                $('#information-provider-form input[name=numero_interior]').val(response.data.numero_interior);
                $('#information-provider-form input[name=numero_exterior]').val(response.data.numero_exterior);
                $('#information-provider-form input[name=calle]').val(response.data.calle);
                $('#information-provider-form input[name=colonia]').val(response.data.colonia);
                $('#information-provider-form input[name=codigo_postal]').val(response.data.codigo_postal);
                $('#information-provider-form input[name=pais]').val(response.data.pais);
                $('#information-provider-form input[name=estado]').val(response.data.estado);
                $('#information-provider-form input[name=ciudad]').val(response.data.ciudad);
                $('#information-provider-form input[name=municipio]').val(response.data.municipio);
                $('#information-provider-form input[name=telefono1]').val(response.data.telefono1);
                $('#information-provider-form input[name=telefono2]').val(response.data.telefono2);
                $('#information-provider-form input[name=credit_days]').val(response.data.credit_days);
                $('#information-provider-form input[name=service]').val(response.data.service);
                $('#information-provider-modal').modal('show');
            }).catch(function(error) {
                console.log(response.error);
            })
        }

        function account_bank($id)
        {
            $('#register_account_form input[name=provider_id]').val($id);
            $('#register-account-modal').modal('show');
        }

        function information_accounts_provider_modal($id)
        {
            var accountproviderid = $('input[name=accounts_provider_id]').val($id);
            $('#information-accounts-provider-modal').modal('show');
        }

        function activate_provider($id)
        {
            $('#activate_provider_form input[name=provider_id]').val($id);
            $('#activate-provider-modal').modal('show');
        }

        function deactivate_provider($id)
        {
            $('#deactivate_provider_form input[name=provider_id]').val($id);
            $('#deactivate-provider-modal').modal('show');
        }

        @if($errors->any())
            $('#register-provider-modal').modal('show');
        @endif
        @if(session()->has('info'))
            $.NotificationApp.send("Bien hecho!", "{{ session('info') }}", 'top-right', 'rgba(0,0,0,0.2)', 'success');
        @endif
    </script>
@endsection
