@extends('layouts.hyper')

@section('title', 'Administración | Información de proveedor')

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
                        <li class="breadcrumb-item"><a href="{{ route('proveedores.index') }}">Proveedores</a></li>
                        <li class="breadcrumb-item active">Información de proveedor</li>
                    </ol>
                </div>
                <h4 class="page-title">Proveedor: {{ $provider->razon_social }}</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2 justify-content-end">
                        <div class="col">
                            @if(!$provider->inactive_at)
                                <button id="btnModal" class="btn btn-light mb-2 mr-1" data-toggle="modal" data-target="#information-provider-modal"><i class="mdi mdi-square-edit-outline"></i> <b>Modificar información</b></button>
                                <button class="btn btn-danger mb-2" onclick="deactivate_provider({{ $provider->id }});"><i class="mdi mdi-close-box-outline"></i> <b>Desactivar proveedor</b></button>
                            @else
                                <button class="btn btn-success mb-2" onclick="activate_provider({{ $provider->id }});"><i class="mdi mdi-checkbox-marked-outline"></i><b>Activar proveedor</b></button>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <div class="table-responsive-sm">
                                <table class="table table-centered table-hover dt-responsive dataTable no-footer dtr-inline">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Código</th>
                                            <th>Razón Social</th>
                                            <th>R.F.C</th>
                                            <th>Calle</th>
                                            <th>Número exterior</th>
                                            <th>Colonia</th>
                                            <th>Código postal</th>
                                            <th>País</th>
                                            <th>Estado</th>
                                            <th>Ciudad</th>
                                            <th>Municipio</th>
                                            <th>Teléfono #1</th>
                                            <th>Días de crédito</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $provider->codigo_proveedor }}</td>
                                            <td>{{ $provider->razon_social }}</td>
                                            <td>{{ $provider->rfc }}</td>
                                            <td>{{ $provider->calle }}</td>
                                            <td>{{ $provider->numero_exterior }}</td>
                                            <td>{{ $provider->colonia }}</td>
                                            <td>{{ $provider->codigo_postal }}</td>
                                            <td>{{ $provider->pais }}</td>
                                            <td>{{ $provider->estado }}</td>
                                            <td>{{ $provider->ciudad }}</td>
                                            <td>{{ $provider->municipio }}</td>
                                            <td>{{ $provider->telefono1 }}</td>
                                            <td>{{ $provider->credit_days }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-12">
                            @if(!$provider->inactive_at)
                                <button id="btnModal" class="btn btn-success mb-2" data-toggle="modal" data-target="#register-account-modal"><i class="mdi mdi-bank"></i> <b>Agregar cuenta</b></button>
                            @endif
                        </div>
                        <div class="col-6">
                            <h5>Cuentas MXN</h5>
                            <div class="table-responsive-sm">
                                <table class="table table-centered table-hover dt-responsive nowrap w-100 dataTable no-footer dtr-inline">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="4%">#</th>
                                            <th>Cuenta</th>
                                            <th>Moneda</th>
                                            <th>Banco</th>
                                            <th width="7%">Status</th>
                                            <th width="7%">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($provider->accounts as $key => $account)
                                            @if($account->currency == "MXN")
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $account->account }}</td>
                                                    <td>{{ $account->currency }}</td>
                                                    <td>{{ $account->name_bank }}</td>
                                                    <td>
                                                        @if(!$account->inactive_at)
                                                            <span class="badge badge-success-lighten">Activo</span>
                                                        @else
                                                            <span class="badge badge-danger-lighten">Inactivo</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(!$provider->inactive_at)
                                                            @if(!$account->inactive_at)
                                                                <button class="btn btn-link action-icon" type="button" data-toggle="tooltip" data-placement="top" title data-original-title="Ver información" onclick="information_provider_modal({{ $account->id }})"> <i class="mdi mdi-square-edit-outline"></i></button>
                                                                <button class="btn btn-link action-icon"
                                                                data-toggle="tooltip" data-placemente="top" data-original-title="Desactivar proveedor"
                                                                onclick="deactivate_account({{ $account->id }});"><i class="mdi mdi-close-box-outline"></i></button>
                                                            @else
                                                                <button class="btn btn-link action-icon"
                                                                data-toggle="tooltip" data-placemente="top" data-original-title="Activar proveedor"
                                                                onclick="activate_account({{ $account->id }});"><i class="mdi mdi-checkbox-marked-outline"></i></button>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-6">
                            <h5>Cuentas USD</h5>
                            <div class="table-responsive-sm">
                                <table class="table table-centered table-hover dt-responsive nowrap w-100 dataTable no-footer dtr-inline">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="4%">#</th>
                                            <th>Cuenta</th>
                                            <th>Moneda</th>
                                            <th>Banco</th>
                                            <th width="7%">Status</th>
                                            <th width="7%">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($provider->accounts as $key => $account)
                                            @if($account->currency == "USD")
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $account->account }}</td>
                                                    <td>
                                                        {{ $account->currency }}
                                                    </td>
                                                    <td>{{ $account->name_bank }}</td>
                                                    <td>
                                                        @if(!$account->inactive_at)
                                                            <span class="badge badge-success-lighten">Activo</span>
                                                        @else
                                                            <span class="badge badge-danger-lighten">Inactivo</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(!$provider->inactive_at)
                                                            @if(!$account->inactive_at)
                                                                <button class="btn btn-link action-icon" type="button" data-toggle="tooltip" data-placement="top" title data-original-title="Ver información" onclick="information_provider_modal({{ $account->id }})"> <i class="mdi mdi-square-edit-outline"></i></button>
                                                                <button class="btn btn-link action-icon"
                                                                data-toggle="tooltip" data-placemente="top" data-original-title="Desactivar proveedor"
                                                                onclick="deactivate_account({{ $account->id }});"><i class="mdi mdi-close-box-outline"></i></button>
                                                            @else
                                                                <button class="btn btn-link action-icon"
                                                                data-toggle="tooltip" data-placemente="top" data-original-title="Activar proveedor"
                                                                onclick="activate_account({{ $account->id }});"><i class="mdi mdi-checkbox-marked-outline"></i></button>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->

</div> <!-- container -->

<!-- Start Modals -->
    <div id="information-provider-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Información de proveedor</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('proveedores.modificar') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        <input type="hidden" name="provider_id">
                        <div class="row">
                            <div class="form-group col-3">
                                <label>Código de proveedor: <span class="text-danger">*</span></label>
                                <input class="form-control {{ $errors->has('codigo_proveedor') ? ' is-invalid' : '' }}" type="text" name="codigo_proveedor" value="{{ $provider->codigo_proveedor }}">
                                @if ($errors->has('codigo_proveedor'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('codigo_proveedor') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group col-9">
                                <label>Razón social: <span class="text-danger">*</span></label>
                                <input class="form-control {{ $errors->has('razon_social') ? ' is-invalid' : '' }}" type="text" name="razon_social" value="{{ $provider->razon_social }}">
                                @if ($errors->has('razon_social'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('razon_social') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group col-6">
                                <label>RFC: <span class="text-danger">*</span></label>
                                <input class="form-control {{ $errors->has('rfc') ? ' is-invalid' : '' }}" type="text" name="rfc" value="{{ $provider->rfc }}">
                                @if ($errors->has('rfc'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('rfc') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label>Número interior: </label>
                                <input class="form-control {{ $errors->has('numero_interior') ? ' is-invalid' : '' }}" type="text" name="numero_interior" value="{{ $provider->numero_interior }}">
                                @if ($errors->has('numero_interior'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('numero_interior') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label>Número exterior: </label>
                                <input class="form-control {{ $errors->has('numero_exterior') ? ' is-invalid' : '' }}" type="text" name="numero_exterior" value="{{ $provider->numero_exterior }}">
                                @if ($errors->has('numero_exterior'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('numero_exterior') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label>Calle: <span class="text-danger">*</span></label>
                                <input class="form-control {{ $errors->has('calle') ? ' is-invalid' : '' }}" type="text" name="calle" value="{{ $provider->calle }}">
                                @if ($errors->has('calle'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('calle') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label>Colonia: <span class="text-danger">*</span></label>
                                <input class="form-control {{ $errors->has('colonia') ? ' is-invalid' : '' }}" type="text" name="colonia" value="{{ $provider->colonia }}">
                                @if ($errors->has('colonia'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('colonia') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label>Código postal: <span class="text-danger">*</span></label>
                                <input class="form-control {{ $errors->has('codigo_postal') ? ' is-invalid' : '' }}" type="text" name="codigo_postal" value="{{ $provider->codigo_postal }}">
                                @if ($errors->has('codigo_postal'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('codigo_postal') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label>País: <span class="text-danger">*</span></label>
                                <input class="form-control {{ $errors->has('pais') ? ' is-invalid' : '' }}" type="text" name="pais" value="{{ $provider->pais }}">
                                @if ($errors->has('pais'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('pais') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label>Estado: <span class="text-danger">*</span></label>
                                <input class="form-control {{ $errors->has('estado') ? ' is-invalid' : '' }}" type="text" name="estado" value="{{ $provider->estado }}">
                                @if ($errors->has('estado'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('estado') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label>Ciudad: <span class="text-danger">*</span></label>
                                <input class="form-control {{ $errors->has('ciudad') ? ' is-invalid' : '' }}" type="text" name="ciudad" value="{{ $provider->ciudad }}">
                                @if ($errors->has('ciudad'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('ciudad') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label>Municipio: <span class="text-danger">*</span></label>
                                <input class="form-control {{ $errors->has('municipio') ? ' is-invalid' : '' }}" type="text" name="municipio" value="{{ $provider->municipio }}">
                                @if ($errors->has('municipio'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('municipio') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label>Teléfono #1: </label>
                                <input class="form-control {{ $errors->has('telefono1') ? ' is-invalid' : '' }}" type="text" name="telefono1" value="{{ $provider->telefono1 }}">
                                @if ($errors->has('telefono1'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('telefono1') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label>Teléfono #2: </label>
                                <input class="form-control {{ $errors->has('telefono2') ? ' is-invalid' : '' }}" type="text" name="telefono2" value="{{ $provider->telefono2 }}">
                                @if ($errors->has('telefono2'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('telefono2') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label>Service: <span class="text-danger">*</span></label>
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
                                <input class="form-control {{ $errors->has('credit_days') ? ' is-invalid' : '' }}" type="number" name="credit_days" value="{{ $provider->credit_days }}">
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
                    <button type="submit" class="btn btn-primary"><b>Guardar</b></button>
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
                    <form method="POST" action="{{ route('cuentasproveedor.store') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        <input type="hidden" name="provider_id" value="{{ $provider->id }}">
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

    <div id="information-account-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Información de cuenta</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="information-account-form" method="POST" action="{{ route('cuentasproveedor.update') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        <input type="hidden" name="account_id">
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
                    <button type="submit" class="btn btn-primary"><b>Guardar</b></button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div id="activate-account-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-warning h1 text-primary"></i>
                        <h4 class="mt-2">Precaución!</h4>
                        <p class="mt-3">¿Está seguro(a) de activar la cuenta?</p>
                        <button type="button" class="btn btn-light my-2" data-dismiss="modal">Cancelar</button>
                        <form id="activate_account_form" style="display: inline;" action="{{ route('cuentasproveedor.activate') }}" method="POST">
                            {!! csrf_field() !!}
                            {{-- {!! method_field('PATCH') !!} --}}
                            <input type="hidden" name="account_id">
                            <button type="sumbit" class="btn btn-primary my-2"><b>Activar</b></button>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="deactivate-account-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-warning h1 text-danger"></i>
                        <h4 class="mt-2">Precaución!</h4>
                        <p class="mt-3">¿Está seguro(a) de desactivar la cuenta?</p>
                        <button type="button" class="btn btn-light my-2" data-dismiss="modal">Cancelar</button>
                        <form id="deactivate_account_form" style="display: inline;" action="{{ route('cuentasproveedor.deactivate') }}" method="POST">
                            {!! csrf_field() !!}
                            {!! method_field('DELETE') !!}
                            <input type="hidden" name="account_id">
                            <button type="sumbit" class="btn btn-danger my-2"><b>Desactivar</b></button>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

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
            var url = '/cuentasproveedor/' + $id;
            axios.get(url).then(function(response) {
                console.log(response.data);
                $('#information-account-form input[name=account_id]').val($id);
                $('#information-account-form input[name=account]').val(response.data.account);
                $('#information-account-form select[name=currency]').val(response.data.currency).change();
                $('#information-account-form input[name=name_bank]').val(response.data.name_bank);
                $('#information-account-modal').modal('show');
            }).catch(function(error) {
                console.log(response.error);
            })
        }

        function activate_account($id)
        {
            $('#activate_account_form input[name=account_id]').val($id);
            $('#activate-account-modal').modal('show');
        }

        function deactivate_account($id)
        {
            $('#deactivate_account_form input[name=account_id]').val($id);
            $('#deactivate-account-modal').modal('show');
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
