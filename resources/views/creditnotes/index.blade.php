@extends('layouts.hyper')

@section('title', 'Sistema | Notas de crédito')

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
                        <li class="breadcrumb-item">Facturación</li>
                        <li class="breadcrumb-item active">Notas de crédito</li>
                    </ol>
                </div>
                <h4 class="page-title">Notas de crédito</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2 pl-2 justify-content-between">
                        <div class="col-2">
                            <button id="btnModal" class="btn btn-primary mb-2" data-toggle="modal" data-target="#register-creditnote-modal"><i class="mdi mdi-plus-circle mr-2"></i> <b>Registrar nota de crédito</b></button>
                        </div>
                        <div class="col-sm-2 form-group form-inline">
                            <label for="">Mostrar &nbsp;</label>
                            <select name="filtro-datatables" id="filtro-datatables" class="form-control">
                                <option value="Aplicado">Aplicados</option>
                                <option value="Eliminado">Eliminados</option>
                                <option value="Todo" selected>Todos</option>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive-sm">
                        <table id="creditnotes-datatable" class="table table-centered dt-responsive nowrap w-100 dataTable no-footer dtr-inline">
                            <thead class="thead-light">
                                <tr>
                                    <th width="4%">#</th>
                                    <th width="12%">Cliente</th>
                                    <th width="7%">Folio</th>
                                    <th width="8%">Monto</th>
                                    <th width="8%">Moneda</th>
                                    <th width="9%">Fecha nota</th>
                                    <th>Comentarios</th>
                                    <th width="7%">Status</th>
                                    <th width="7%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($creditnotes as $key => $creditnote)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $creditnote->client->codigo_cliente }}</td>
                                        <td>{{ $creditnote->folio }}</td>
                                        <td>$ {{ $creditnote->monto }}</td>
                                        <td>{{ $creditnote->moneda }}</td>
                                        <td>{{ $creditnote->fecha_pago }}</td>
                                        <td>{{ $creditnote->comentarios }}</td>
                                        <td>{{ $creditnote->present()->statusBadge() }}</td>
                                        <td>
                                            @if(!$creditnote->deleted_at)
                                                <a  href="javascript:void(0)" class="action-icon"
                                                data-toggle="tooltip" data-placemente="top" data-original-title="Editar información"
                                                onclick="information_creditnote_modal({{ $creditnote->id }});"><i class="mdi mdi-square-edit-outline"></i></a>
                                                <a  href="javascript:void(0)" class="action-icon"
                                                data-toggle="tooltip" data-placemente="top" data-original-title="Cancelar nota de crédito"
                                                onclick="deactivate_creditnote({{ $creditnote->id }});"><i class="mdi mdi-delete"></i></a>
                                            @else
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

    <!-- Start modals -->
        <div id="register-creditnote-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header pr-4 pl-4">
                        <h4 class="modal-title" id="primary-header-modalLabel">Registro de nota de crédito</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form id="register-creditnote-form" method="POST" action="{{ route('notascredito.store') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                            {!! csrf_field() !!}
                            <div class="row">
                                <div class="col-8">
                                    <div class="form-group">
                                        <label>Cliente <span class="text-danger">*</span></label>
                                        <select class="form-control form-control-light" type="text" name="client_id" required>
                                            <option value="">Selecciona un cliente...</option>
                                            @foreach($clients as $client)
                                                <option value="{{ $client->id }}">{{ $client->codigo_cliente }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Folio <span class="text-danger">*</span></label>
                                        <input class="form-control form-control-light" type="text" name="folio" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Monto <span class="text-danger">*</span></label>
                                        <input class="form-control form-control-light" type="number" step="any" name="monto" required>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label>Moneda <span class="text-danger">*</span></label>
                                        <select name="moneda" id="" class="form-control form-control-light">
                                            <option value="MXN">MXN</option>
                                            <option value="USD">USD</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Fecha de nota <span class="text-danger">*</span></label>
                                        <input class="form-control form-control-light" type="date" name="fecha_pago" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Comentarios</label>
                                        <textarea class="form-control form-control-light" type="date" name="comentarios"></textarea>
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

        <div id="information-creditnote-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header pr-4 pl-4">
                        <h4 class="modal-title" id="primary-header-modalLabel">Información de nota de crédito</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form id="information-creditnote-form" method="POST" action="{{ route('notascredito.modificar') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                            {!! csrf_field() !!}
                            <input type="hidden" name="creditnote_id">
                            <div class="row">
                                <div class="col-8">
                                    <div class="form-group">
                                        <label>Cliente</label>
                                        <select class="form-control form-control-light" type="text" name="client_id" required>
                                            <option value="">Selecciona un cliente...</option>
                                            @foreach($clients as $client)
                                                <option value="{{ $client->id }}">{{ $client->codigo_cliente }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Folio</label>
                                        <input class="form-control form-control-light" type="text" name="folio" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Monto</label>
                                        <input class="form-control form-control-light" type="number" step="any" name="monto" required>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label>Moneda</label>
                                        <select name="moneda" id="" class="form-control form-control-light">
                                            <option value="MXN">MXN</option>
                                            <option value="USD">USD</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Fecha de nota</label>
                                        <input class="form-control form-control-light" type="date" name="fecha_pago" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Comentarios</label>
                                        <textarea class="form-control form-control-light" type="date" name="comentarios"></textarea>
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

        <div id="deactivate-creditnote-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body p-4">
                        <div class="text-center">
                            <i class="dripicons-warning h1 text-danger"></i>
                            <h4 class="mt-2">Precaución!</h4>
                            <p class="mt-3">¿Está seguro(a) de eliminar la nota de crédito?</p>
                            <button type="button" class="btn btn-light my-2" data-dismiss="modal">Cancelar</button>
                            <form id="deactivate_creditnote_form" style="display: inline;" action="{{ route('notascredito.deactivate') }}" method="POST">
                                {!! csrf_field() !!}
                                {!! method_field('DELETE') !!}
                                <input type="hidden" name="creditnote_id">
                                <button type="sumbit" class="btn btn-danger my-2"><b>Eliminar</b></button>
                            </form>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    <!-- End modals -->

</div> <!-- container -->

@endsection
@section('scripts')
    <script src="{{ asset('assets/js/vendor/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.checkboxes.min.js') }}"></script>
    <script src="{{ asset('assets/js/idioma_espanol.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = $("#creditnotes-datatable").DataTable({
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


            $("#filtro-datatables").on("change", function(){
                var val = $("#filtro-datatables").val();

                if(val == "Aplicado"){
                    table.search( val ).draw();
                }else if(val == "Eliminado"){
                    table.search( val ).draw();
                }else if(val == "Todo"){
                    table.search( "" ).draw();
                }
            })
            table.search( "" ).draw();
        });


        function information_creditnote_modal($id){
            var url = '/notascredito/' + $id;
            axios.get(url).then(function(response) {
                console.log(response.data);
                $('#information-creditnote-form input[name=creditnote_id]').val($id);
                $('#information-creditnote-form select[name=client_id]').val(response.data.client_id).change();
                $('#information-creditnote-form input[name=folio]').val(response.data.folio);
                $('#information-creditnote-form input[name=monto]').val(response.data.monto);
                $('#information-creditnote-form select[name=moneda]').val(response.data.moneda).change();
                $('#information-creditnote-form input[name=fecha_pago]').val(response.data.fecha_pago);
                $('#information-creditnote-form textarea[name=comentarios]').val(response.data.comentarios);
                $('#information-creditnote-modal').modal('show');
            }).catch(function(error) {
                console.log(response.error);
            })
        }

        function deactivate_creditnote($id)
        {
            $('#deactivate_creditnote_form input[name=creditnote_id]').val($id);
            $('#deactivate-creditnote-modal').modal('show');
        }

        @if($errors->any())
            $('#information-operation-modal').modal('show');
        @endif
    </script>
@endsection