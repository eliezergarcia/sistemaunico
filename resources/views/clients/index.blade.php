@extends('layouts.hyper')

@section('title', 'Administración | Clientes')

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
                        <li class="breadcrumb-item active">Clientes</li>
                    </ol>
                </div>
                <h4 class="page-title">Clientes</h4>
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
                            <button id="btnModal" class="btn btn-primary mb-2" data-toggle="modal" data-target="#register-client-modal"><i class="mdi mdi-plus-circle mr-2"></i> <b>Registrar cliente</b></button>
                            <button class="btn btn-info mb-2" data-toggle="modal" data-target="#import-clients-modal"><i class="mdi mdi-file-import"></i> <b>Cargar clientes</b></button>
                        </div>
                    </div>

                    <div class="table-responsive-sm">
                        <table id="clients-datatable" class="table table-centered table-hover dt-responsive nowrap w-100 dataTable no-footer dtr-inline">
                            <thead class="thead-light">
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
                            	@foreach($clients as $key => $client)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $client->codigo_cliente }}</td>
                                    <td>{{ $client->razon_social }}</td>
                                    <td>{{ $client->rfc }}</td>
                                    <td>{{ $client->present()->statusBadge() }}</td>
                                    <td>
                                        <a href="javascript:void(0)" class="action-icon" data-toggle="tooltip" data-placement="top" title data-original-title="Ver información" onclick="information_client_modal({{ $client->id }})"> <i class="mdi mdi-square-edit-outline"></i></a>
                                        @if(!$client->inactive_at)
                                            <a href="javascript:void(0)" class="action-icon"
                                            data-toggle="tooltip" data-placemente="top" data-original-title="Desactivar cliente"
                                            onclick="deactivate_client({{ $client->id }});"><i class="mdi mdi-close-box-outline"></i></a>
                                        @else
                                            <a href="javascript:void(0)" class="action-icon"
                                            data-toggle="tooltip" data-placemente="top" data-original-title="Activar cliente"
                                            onclick="activate_client({{ $client->id }});"><i class="mdi mdi-checkbox-marked-outline"></i></a>
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
    <div id="register-client-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Registro de cliente</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('clientes.store') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="form-group col-3">
                                <label>Código de cliente: <span class="text-danger">*</span></label>
                                <input class="form-control {{ $errors->has('codigo_cliente') ? ' is-invalid' : '' }}" type="text" name="codigo_cliente" value="{{ old('codigo_cliente') }}">
                                @if ($errors->has('codigo_cliente'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('codigo_cliente') }}</strong>
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
                                <label>RFC: <span class="text-danger">*</span></label>
                                <input class="form-control {{ $errors->has('rfc') ? ' is-invalid' : '' }}" type="text" name="rfc" value="{{ old('email') }}">
                                @if ($errors->has('rfc'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('rfc') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label>Calle: <span class="text-danger">*</span></label>
                                <input class="form-control {{ $errors->has('calle') ? ' is-invalid' : '' }}" type="text" name="calle" value="{{ old('calle') }}">
                                @if ($errors->has('calle'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('calle') }}</strong>
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
                                <label>Colonia:</label>
                                <input class="form-control " type="text" name="colonia" value="{{ old('colonia') }}">
                            </div>
                            <div class="form-group col-3">
                                <label>Municipio:</label>
                                <input class="form-control " type="text" name="municipio" value="{{ old('municipio') }}">
                            </div>
                            <div class="form-group col-3">
                                <label>Ciudad: <span class="text-danger">*</span></label>
                                <input class="form-control {{ $errors->has('ciudad') ? ' is-invalid' : '' }}" type="text" name="ciudad" value="{{ old('ciudad') }}">
                                @if ($errors->has('ciudad'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('ciudad') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label>Estado: <span class="text-danger">*</span></label>
                                <input class="form-control {{ $errors->has('estado') ? ' is-invalid' : '' }}" type="text" name="estado" value="{{ old('estado') }}">
                                @if ($errors->has('estado'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('estado') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label>País: <span class="text-danger">*</span></label>
                                <input class="form-control {{ $errors->has('pais') ? ' is-invalid' : '' }}" type="text" name="pais" value="{{ old('pais') }}">
                                @if ($errors->has('pais'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('pais') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label>Código postal: <span class="text-danger">*</span></label>
                                <input class="form-control {{ $errors->has('codigo_postal') ? ' is-invalid' : '' }}" type="text" name="codigo_postal" value="{{ old('codigo_postal') }}">
                                @if ($errors->has('codigo_postal'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('codigo_postal') }}</strong>
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

    <div id="import-clients-modal" class="modal fade" tabindex="" role="dialog" aria-hidden="">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Carga de clientes</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        Para cargar correctamente los clientes en el sistema hay que seguir los siguientes pasos:
                        <p><br><b>1.</b> El archivo a subir deberá ser de tipo Excel.</p>
                        <p><b>2.</b> Las filas de datos deberán seguir el siguiente orden (primera fila de izquierda a derecha) y con encabezados:<br>
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
                            </div>
                            <div class="col">
                                · Código postal<br>
                                · País<br>
                                · Estado<br>
                                · Ciudad<br>
                                · Municipio<br>
                                · Teléfono #1<br>
                                · Teléfono #2<br>
                            </div>
                        </div>
                    </div>
                    {{-- <form method="POST" action="{{ route('import.clients') }}" enctype="multipart/form-data" class="pl-2 pr-2 dropzone" id="myAwesomeDropzone" data-plugin="dropzone" data-previews-container="#file-previews" data-upload-preview-template="#uploadPreviewTemplate">
                        {!! csrf_field() !!}
                        <div class="fallback">
                            <input name="excel" type="file">
                        </div>

                        <div class="dz-message needsclick">
                            <i class="h1 text-muted dripicons-cloud-upload"></i>
                            <h3>Drop files here or click to upload.</h3>
                            <span class="text-muted font-13">(This is just a demo dropzone. Selected files are
                                <strong>not</strong> actually uploaded.)</span>
                        </div>
 --}}
                    {{-- <div class="dropzone-previews mt-3" id="file-previews"></div> --}}
                    <form method="POST" action="{{ route('import.clients') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="excel" class="custom-file-input">
                                <label class="custom-file-label">Selecciona el archivo:</label>
                            </div>
                        </div>

                    {{-- <div class="d-none" id="uploadPreviewTemplate">
                        <div class="card mt-1 mb-0 shadow-none border border-light">
                            <div class="p-2">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <img data-dz-thumbnail class="avatar-sm rounded bg-light" alt="">
                                    </div>
                                    <div class="col pl-0">
                                        <a href="javascript:void(0);" class="text-muted font-weight-bold" data-dz-name></a>
                                        <p class="mb-0" data-dz-size></p>
                                    </div>
                                    <div class="col-auto">
                                        <!-- Button -->
                                        <a href="" class="btn btn-link btn-lg text-muted" data-dz-remove>
                                            <i class="dripicons-cross"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
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

    <div id="information-client-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Información de cliente</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="information-client-form" method="POST" action="{{ route('clientes.modificar') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        <input type="hidden" name="client_id">
                        <div class="row">
                            <div class="form-group col-3">
                                <label>Código de cliente: <span class="text-danger">*</span></label>
                                <input class="form-control " type="text" name="codigo_cliente" required>
                            </div>

                            <div class="form-group col-9">
                                <label>Razón social: <span class="text-danger">*</span></label>
                                <input class="form-control " type="text" name="razon_social" required>
                            </div>

                            <div class="form-group col-6">
                                <label>RFC: <span class="text-danger">*</span></label>
                                <input class="form-control " type="text" name="rfc" required>
                            </div>
                            <div class="form-group col-3">
                                <label>Calle: <span class="text-danger">*</span></label>
                                <input class="form-control " type="text" name="calle" required>
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
                                <label>Colonia:</label>
                                <input class="form-control " type="text" name="colonia" required>
                            </div>
                            <div class="form-group col-3">
                                <label>Municipio:</label>
                                <input class="form-control " type="text" name="municipio" required>
                            </div>
                            <div class="form-group col-3">
                                <label>Ciudad: <span class="text-danger">*</span></label>
                                <input class="form-control " type="text" name="ciudad" required>
                            </div>
                            <div class="form-group col-3">
                                <label>Estado: <span class="text-danger">*</span></label>
                                <input class="form-control " type="text" name="estado" required>
                            </div>
                            <div class="form-group col-3">
                                <label>País: <span class="text-danger">*</span></label>
                                <input class="form-control " type="text" name="pais" required>
                            </div>
                            <div class="form-group col-3">
                                <label>Código postal: <span class="text-danger">*</span></label>
                                <input class="form-control " type="text" name="codigo_postal" required>
                            </div>
                            <div class="form-group col-3">
                                <label>Teléfono #1: </label>
                                <input class="form-control " type="text" name="telefono1">
                            </div>
                            <div class="form-group col-3">
                                <label>Teléfono #2: </label>
                                <input class="form-control " type="text" name="telefono2">
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

    <div id="activate-client-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-warning h1 text-primary"></i>
                        <h4 class="mt-2">Precaución!</h4>
                        <p class="mt-3">¿Está seguro(a) de activar el cliente?</p>
                        <button type="button" class="btn btn-light my-2" data-dismiss="modal">Cancelar</button>
                        <form id="activate_client_form" style="display: inline;" action="{{ route('clientes.activate') }}" method="POST">
                            {!! csrf_field() !!}
                            {{-- {!! method_field('PATCH') !!} --}}
                            <input type="hidden" name="client_id">
                            <button type="sumbit" class="btn btn-primary my-2"><b>Activar</b></button>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="deactivate-client-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-warning h1 text-danger"></i>
                        <h4 class="mt-2">Precaución!</h4>
                        <p class="mt-3">¿Está seguro(a) de desactivar el cliente?</p>
                        <button type="button" class="btn btn-light my-2" data-dismiss="modal">Cancelar</button>
                        <form id="deactivate_client_form" style="display: inline;" action="{{ route('clientes.deactivate') }}" method="POST">
                            {!! csrf_field() !!}
                            {!! method_field('DELETE') !!}
                            <input type="hidden" name="client_id">
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
    <script src="{{ asset('assets/js/vendor/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets/js/ui/component.fileupload.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.checkboxes.min.js') }}"></script>
    <script src="{{ asset('assets/js/idioma_espanol.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#clients-datatable").DataTable({
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

        function information_client_modal($id)
        {
            var url = '/clientes/buscar/' + $id;
            axios.get(url).then(function(response) {
                console.log(response.data);
                $('#information-client-form input[name=client_id]').val($id);
                $('#information-client-form input[name=codigo_cliente]').val(response.data.codigo_cliente);
                $('#information-client-form input[name=razon_social]').val(response.data.razon_social);
                $('#information-client-form input[name=rfc]').val(response.data.rfc);
                $('#information-client-form input[name=numero_interior]').val(response.data.numero_interior);
                $('#information-client-form input[name=numero_exterior]').val(response.data.numero_exterior);
                $('#information-client-form input[name=calle]').val(response.data.calle);
                $('#information-client-form input[name=colonia]').val(response.data.colonia);
                $('#information-client-form input[name=codigo_postal]').val(response.data.codigo_postal);
                $('#information-client-form input[name=pais]').val(response.data.pais);
                $('#information-client-form input[name=estado]').val(response.data.estado);
                $('#information-client-form input[name=ciudad]').val(response.data.ciudad);
                $('#information-client-form input[name=municipio]').val(response.data.municipio);
                $('#information-client-form input[name=telefono1]').val(response.data.telefono1);
                $('#information-client-form input[name=telefono2]').val(response.data.telefono2);
                $('#information-client-modal').modal('show');
            }).catch(function(error) {
                console.log(response.error);
            })
        }

        function activate_client($id)
        {
            $('#activate_client_form input[name=client_id]').val($id);
            $('#activate-client-modal').modal('show');
        }

        function deactivate_client($id)
        {
            $('#deactivate_client_form input[name=client_id]').val($id);
            $('#deactivate-client-modal').modal('show');
        }

        @if($errors->any())
            $('#register-client-modal').modal('show');
        @endif
        @if(session()->has('info'))
            $.NotificationApp.send("Bien hecho!", "{{ session('info') }}", 'top-right', 'rgba(0,0,0,0.2)', 'success');
        @endif
    </script>
@endsection
