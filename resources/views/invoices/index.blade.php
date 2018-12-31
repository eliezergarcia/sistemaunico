@extends('layouts.hyper')

@section('title', 'Facturación | Facturas de clientes')

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
                        <li class="breadcrumb-item active">Facturas de clientes</li>
                    </ol>
                </div>
                <h4 class="page-title">Facturas de clientes</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2 justify-content-between">
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-2 form-group form-inline">
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <label for="">Mostrar &nbsp;</label>
                            <select name="filtro-datatables" id="filtro-datatables" class="form-control">
                                <option value="Pendiente">Pendientes</option>
                                <option value="Finalizado">Finalizados</option>
                                <option value="Cancelado">Cancelados</option>
                                <option value="Todo">Todos</option>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive-sm">
                        <table id="invoices-datatable" class="table table-centered dt-responsive nowrap w-100 dataTable no-footer dtr-inline">
                            <thead class="thead-light">
                                <tr>
                                    <th width="4%">#</th>
                                    <th>Operador</th>
                                    <th width="6%">Folio</th>
                                    <th width="9%">Fecha factura</th>
                                    <th>Cliente</th>
                                    <th width="6%">Tipo</th>
                                    <th width="6%">Lugar</th>
                                    <th width="6%">Moneda</th>
                                    <th width="8%">Neto</th>
                                    <th width="8%">IVA</th>
                                    <th width="8%">Total</th>
                                    <th width="9%">Fecha pago</th>
                                    <th width="10%">Status</th>
                                    <th width="5%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoices as $key => $invoice)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $invoice->operador }}</td>
                                        <td>{{ $invoice->factura }}</td>
                                        <td>{{ $invoice->fechaFacturaFormat }}</td>
                                        <td>{{ $invoice->client->codigo_cliente }}</td>
                                        <td>{{ $invoice->tipo }}</td>
                                        <td>{{ $invoice->lugar }}</td>
                                        <td>{{ $invoice->moneda }}</td>
                                        <td>$ {{ number_format($invoice->neto, 2, '.', ',') }}</td>
                                        <td>$ {{ number_format($invoice->iva, 2, '.', ',') }}</td>
                                        <td>$ {{ number_format($invoice->neto + $invoice->iva, 2, '.', ',') }}</td>
                                        <td>{{ $invoice->present()->fechaPagos() }}</td>
                                        <td>{{ $invoice->present()->statusBadge() }}</td>
                                        <td>
                                            <a href="{{ route('facturas.show', $invoice->factura ) }}" class="action-icon" data-toggle="tooltip" data-placement="top" title data-original-title="Ver información"> <i class="mdi mdi-eye"></i></a>
                                            @if(!$invoice->canceled_at)
                                                <a  href="javascript:void(0)" class="action-icon"
                                                data-toggle="tooltip" data-placemente="top" data-original-title="Editar información"
                                                onclick="information_invoice_modal({{ $invoice->id }});"><i class="mdi mdi-square-edit-outline"></i></a>
                                                @if($invoice->pagado != $invoice->total)
                                                    <a  href="javascript:void(0)" class="action-icon"
                                                    data-toggle="tooltip" data-placemente="top" data-original-title="Agregar pago"
                                                    onclick="agree_payment_modal({{ $invoice->id }});"><i class="mdi mdi-credit-card-plus"></i></a>
                                                @endif
                                                <a  href="javascript:void(0)" class="action-icon"
                                                data-toggle="tooltip" data-placemente="top" data-original-title="Cancelar factura"
                                                onclick="cancel_invoice({{ $invoice->id }});"><i class="mdi mdi-close-box-outline"></i></a>
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
        <div id="information-invoice-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header pr-4 pl-4">
                        <h4 class="modal-title" id="primary-header-modalLabel">Información de factura</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form id="information-invoice-form" method="POST" action="{{ route('facturas.modificar') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                            {!! csrf_field() !!}
                            <input type="hidden" name="invoice_id">
                            <div id="container-nodes" class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Factura <span class="text-danger">*</span></label>
                                        <input class="form-control " type="text" name="factura" value="" required="">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Fecha factura <span class="text-danger">*</span></label>
                                        <input class="form-control " type="date" name="fecha_factura" value="" required="">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Moneda <span class="text-danger">*</span></label>
                                        <select type="text" class="form-control " value=""  name="moneda" required="">
                                            <option value="MXN">MXN</option>
                                            <option value="USD">USD</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Tipo <span class="text-danger">*</span></label>
                                        <select type="text" class="form-control " value=""  name="tipo" required="">
                                            <option value="IMPO">IMPO</option>
                                            <option value="EXPO">EXPO</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Lugar <span class="text-danger">*</span></label>
                                        <input class="form-control " type="text" name="lugar" value="" required="">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Neto <span class="text-danger">*</span></label>
                                        <input class="form-control " type="number" step="any" name="neto" value="" required="">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Iva <span class="text-danger">*</span></label>
                                        <input class="form-control " type="number" step="any" name="iva" value="" required="">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Comentarios</label>
                                        <textarea class="form-control " type="date" name="comentarios"></textarea>
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

        <div id="cancel-invoice-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body p-4">
                        <div class="text-center">
                            <i class="dripicons-warning h1 text-danger"></i>
                            <h4 class="mt-2">Precaución!</h4>
                            <p class="mt-3">¿Está seguro(a) de eliminar la factura?</p>
                            <button type="button" class="btn btn-light my-2" data-dismiss="modal">Cancelar</button>
                            <form id="cancel_invoice_form" style="display: inline;" action="{{ route('facturas.cancel') }}" method="POST">
                                {!! csrf_field() !!}
                                {!! method_field('DELETE') !!}
                                <input type="hidden" name="invoice_id">
                                <button type="sumbit" class="btn btn-danger my-2"><b>Eliminar</b></button>
                            </form>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div id="agree-payment-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header pr-4 pl-4">
                        <h4 class="modal-title" id="primary-header-modalLabel">Registro de pago</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form id="agree-payment-form" method="POST" action="{{ route('pagos.store') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                            {!! csrf_field() !!}
                            <input type="hidden" name="invoice_id">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Factura</label>
                                        <input class="form-control " type="text" name="factura" disabled value="">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label>Neto</label>
                                        <input class="form-control " type="number" step="any" name="neto" disabled value="">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label>IVA</label>
                                        <input class="form-control " type="number" step="any" name="iva" disabled value="">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label>Total</label>
                                        <input class="form-control " type="number" step="any" name="total" disabled value="">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label>Pendiente</label>
                                        <input class="form-control " type="number" step="any" name="pendiente" disabled value="">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <br>
                                    <div class="form-group">
                                        <label>Monto</label>
                                        <input class="form-control " type="number" step="any" name="monto" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <br>
                                    <div class="form-group">
                                        <label>Fecha de pago</label>
                                        <input class="form-control " type="date" name="fecha_pago" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Comentarios</label>
                                        <textarea class="form-control " type="date" name="comentarios"></textarea>
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
            var table = $("#invoices-datatable").DataTable({
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

                if(val == "Pendiente"){
                    table.search( val ).draw();
                }else if(val == "Finalizado"){
                    table.search( val ).draw();
                }else if(val == "Cancelado"){
                    table.search( val ).draw();
                }else if(val == "Todo"){
                    table.search( "" ).draw();
                }
            })
            table.search( "" ).draw();
        });

        function information_invoice_modal($id){
            var url = '/facturas/buscar/' + $id;
            axios.get(url).then(function(response) {
                console.log(response.data);
                $('#information-invoice-form input[name=invoice_id]').val($id);
                $('#information-invoice-form input[name=factura]').val(response.data.invoice.factura);
                $('#information-invoice-form input[name=fecha_factura]').val(response.data.invoice.fecha_factura);
                $('#information-invoice-form select[name=moneda]').val(response.data.invoice.moneda).change();
                $('#information-invoice-form select[name=tipo]').val(response.data.invoice.tipo).change();
                $('#information-invoice-form input[name=lugar]').val(response.data.invoice.lugar);
                $('#information-invoice-form input[name=neto]').val(response.data.invoice.neto);
                $('#information-invoice-form input[name=iva]').val(response.data.invoice.iva);
                $('#information-invoice-modal').modal('show');
            }).catch(function(error) {
                console.log(response.error);
            })
        }

        function agree_payment_modal($id)
        {
            var url = '/facturas/buscar/' + $id;
            axios.get(url).then(function(response) {
                console.log(response.data);
                var neto = response.data.invoice.neto;
                var iva = response.data.invoice.iva;
                var total = parseFloat(neto) + parseFloat(iva);
                console.log(neto);
                console.log(iva);
                console.log(total);
                $('#agree-payment-form input[name=invoice_id]').val($id);
                $('#agree-payment-form input[name=factura]').val(response.data.invoice.factura);
                $('#agree-payment-form input[name=neto]').val(neto);
                $('#agree-payment-form input[name=iva]').val(iva);
                $('#agree-payment-form input[name=total]').val(total);
                $('#agree-payment-form input[name=pendiente]').val((total - response.data.pagado).toFixed(2));
                $('#agree-payment-modal').modal('show');
            }).catch(function(error) {
                console.log(response.error);
            })
        }

        function cancel_invoice($id)
        {
            $('#cancel_invoice_form input[name=invoice_id]').val($id);
            $('#cancel-invoice-modal').modal('show');
        }

        @if($errors->any())
            $('#information-operation-modal').modal('show');
        @endif
    </script>
@endsection