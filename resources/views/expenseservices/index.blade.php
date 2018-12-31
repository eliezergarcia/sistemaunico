@extends('layouts.hyper')

@section('title', 'Finanzas | Servicios de gastos')

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
                        <li class="breadcrumb-item">Finanzas</li>
                        <li class="breadcrumb-item active">Servicios de gastos</li>
                    </ol>
                </div>
                <h4 class="page-title">Servicios de gastos</h4>
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
                            <button id="btnModal" class="btn btn-primary mb-2" data-toggle="modal" data-target="#register-service-modal"><i class="mdi mdi-plus-circle mr-2"></i> <b>Registrar servicio</b></button>
                        </div>
                    </div>

                    <div class="table-responsive-sm">
                        <table id="users-datatable" class="table table-centered table-striped table-hover table-striped dt-responsive nowrap w-100 dataTable no-footer dtr-inline">
                            <thead>
                                <tr>
                                    <th width="4%">#</th>
                                    <th>Número de usuario</th>
                                    <th>Servicio</th>
                                    <th>Concepto de pago</th>
                                    <th width="8%">Estado</th>
                                    <th width="8%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            	@foreach($services as $key => $service)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $service->numero_usuario }}</td>
                                    <td>{{ $service->servicio }}</td>
                                    <td>{{ $service->concepto_pago }}</td>
                                    <td>{{ $service->present()->statusBadge() }}</td>
                                    <td>
                                        <a  href="javascript:void(0)" class="action-icon"
                                            data-toggle="tooltip" data-placemente="top" data-original-title="Editar información"
                                            onclick="information_service_modal({{ $service->id }});"><i class="mdi mdi-square-edit-outline"></i></a>
                                        @if(!$service->inactive_at)
                                            <a  href="javascript:void(0)" class="action-icon"
                                            data-toggle="tooltip" data-placemente="top" data-original-title="Desactivar servicio"
                                            onclick="deactivate_service({{ $service->id }});"><i class="mdi mdi-close-box-outline"></i></a>
                                        @else
                                            <a  href="javascript:void(0)" class="action-icon"
                                            data-toggle="tooltip" data-placemente="top" data-original-title="Activar servicio"
                                            onclick="activate_service({{ $service->id }});"><i class="mdi mdi-checkbox-marked-outline"></i></a>
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
    <div id="register-service-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Registro de servicio</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('serviciosgastos.store') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Número de usuario</label>
                                    <input type="text" class="form-control " name="numero_usuario">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Servicio <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " name="servicio" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Concepto de pago</label>
                                    <input type="text" class="form-control " name="concepto_pago">
                                </div>
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

    <div id="information-service-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Información de servicio</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="information-service-form" method="POST" action="{{ route('serviciosgastos.modificar') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        <input type="hidden" name="service_id">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Número de usuario</label>
                                    <input type="text" class="form-control " name="numero_usuario">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Servicio <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " name="servicio" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Concepto de pago</label>
                                    <input type="text" class="form-control " name="concepto_pago">
                                </div>
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

    <div id="activate-service-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-warning h1 text-primary"></i>
                        <h4 class="mt-2">Precaución!</h4>
                        <p class="mt-3">¿Está seguro(a) de activar el servicio?</p>
                        <button type="button" class="btn btn-light my-2" data-dismiss="modal">Cancelar</button>
                        <form id="activate_service_form" style="display: inline;" action="{{ route('serviciosgastos.activate') }}" method="POST">
                            {!! csrf_field() !!}
                            <input type="hidden" name="service_id">
                            <button type="sumbit" class="btn btn-primary my-2"><b>Activar</b></button>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="deactivate-service-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-warning h1 text-danger"></i>
                        <h4 class="mt-2">Precaución!</h4>
                        <p class="mt-3">¿Está seguro(a) de desactivar el servicio?</p>
                        <button type="button" class="btn btn-light my-2" data-dismiss="modal">Cancelar</button>
                        <form id="deactivate_service_form" style="display: inline;" action="{{ route('serviciosgastos.deactivate') }}" method="POST">
                            {!! csrf_field() !!}
                            {!! method_field('DELETE') !!}
                            <input type="hidden" name="service_id">
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

        function information_service_modal($id){
            var url = '/serviciosgastos/buscar/' + $id;
            axios.get(url).then(function(response) {
                console.log(response.data);
                $('#information-service-form input[name=service_id]').val($id);
                $('#information-service-form input[name=numero_usuario]').val(response.data.numero_usuario);
                $('#information-service-form input[name=servicio]').val(response.data.servicio);
                $('#information-service-form input[name=concepto_pago]').val(response.data.concepto_pago);
                $('#information-service-modal').modal('show');
            }).catch(function(error) {
                console.log(response.error);
            })
        }

        function activate_service($id)
        {
            $('#activate_service_form input[name=service_id]').val($id);
            $('#activate-service-modal').modal('show');
        }

        function deactivate_service($id)
        {
            $('#deactivate_service_form input[name=service_id]').val($id);
            $('#deactivate-service-modal').modal('show');
        }

        @if($errors->any())
            $('#register-service-modal').modal('show');
        @endif
    </script>
@endsection
