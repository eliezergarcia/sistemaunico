@extends('layouts.hyper')

@section('title', 'Facturación | Pagos')

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
                        <li class="breadcrumb-item active">Pagos</li>
                    </ol>
                </div>
                <h4 class="page-title">Pagos</h4>
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
                            <button id="btnModal" class="btn btn-primary mb-2" data-toggle="modal" data-target="#register-payment-modal"><i class="mdi mdi-plus-circle mr-2"></i> <b>Registrar pago</b></button>
                        </div>
                        <div class="col-2 form-group form-inline">
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <label for="">Mostrar &nbsp;</label>
                            <select name="filtro-datatables" id="filtro-datatables" class="form-control">
                                <option value="Abonado">Abonados</option>
                                <option value="Eliminado">Eliminados</option>
                                <option value="Todo" selected>Todos</option>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive-sm">
                        <table id="payments-datatable" class="table table-centered dt-responsive nowrap w-100 dataTable no-footer dtr-inline">
                            <thead class="thead-light">
                                <tr>
                                    <th width="4%">#</th>
                                    <th width="8%">Factura</th>
                                    <th width="8%">Monto pago</th>
                                    <th width="7%">Fecha pago</th>
                                    <th>Comentarios</th>
                                    <th width="7%">Status</th>
                                    <th width="7%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payments as $key => $payment)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td><a href="{{ route('facturas.show', $payment->invoice->factura) }}">{{ $payment->invoice->factura }}</a></td>
                                        <td>$ {{ $payment->monto }}</td>
                                        <td>{{ $payment->fecha_pago }}</td>
                                        <td>{{ $payment->comentarios }}</td>
                                        <td>{{ $payment->present()->statusBadge() }}</td>
                                        <td>
                                            @if(!$payment->deleted_at)
                                                {{-- <a  href="javascript:void(0)" class="action-icon"
                                                data-toggle="tooltip" data-placemente="top" data-original-title="Editar información"
                                                onclick="information_payment_modal({{ $payment->id }});"><i class="mdi mdi-square-edit-outline"></i></a> --}}
                                                <a  href="javascript:void(0)" class="action-icon"
                                                data-toggle="tooltip" data-placemente="top" data-original-title="Cancelar pago"
                                                onclick="cancel_payment({{ $payment->id }});"><i class="mdi mdi-close-box-outline"></i></a>
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

        <div id="register-payment-modal" class="modal fade" tabindex="" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header pr-4 pl-4">
                        <h4 class="modal-title" id="primary-header-modalLabel">Registro de pago</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form id="register-payment-form" method="POST" action="{{ route('pagos.store') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                            {!! csrf_field() !!}
                            <input type="hidden" name="invoice_id">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Factura <span class="text-danger">*</span></label>
                                        <select class="form-control select2" data-toggle="select2" type="text" name="invoice_id" onchange="information_invoice();" required>
                                            <option value="" selected>Selecciona</option>
                                            @foreach($invoices as $invoice)
                                                @if($invoice->pagado != $invoice->total)
                                                    <option value="{{ $invoice->id }}">{{ $invoice->factura }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label>Neto <span class="text-danger">*</span></label>
                                        <input class="form-control " type="number" step="any" name="neto" disabled value="">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label>IVA <span class="text-danger">*</span></label>
                                        <input class="form-control " type="number" step="any" name="iva" disabled value="">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label>Total <span class="text-danger">*</span></label>
                                        <input class="form-control " type="number" step="any" name="total" disabled value="">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label>Pendiente <span class="text-danger">*</span></label>
                                        <input class="form-control " type="number" step="any" name="pendiente" disabled value="">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <br>
                                    <div class="form-group">
                                        <label>Monto <span class="text-danger">*</span></label>
                                        <input class="form-control " type="number" step="any" name="monto" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <br>
                                    <div class="form-group">
                                        <label>Fecha de pago <span class="text-danger">*</span></label>
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

        <div id="information-payment-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header pr-4 pl-4">
                        <h4 class="modal-title" id="primary-header-modalLabel">Información de pago</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form id="information-payment-form" method="POST" action="{{ route('pagos.modificar') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                            {!! csrf_field() !!}
                            <input type="hidden" name="payment_id">
                            <div class="row">
                                <div class="col-6">
                                    <br>
                                    <div class="form-group">
                                        <label>Monto <span class="text-danger">*</span></label>
                                        <input class="form-control " type="number" step="any" name="monto" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <br>
                                    <div class="form-group">
                                        <label>Fecha de pago <span class="text-danger">*</span></label>
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
                        <button type="submit" class="btn btn-primary"><b>Guardar</b></button>
                    </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div id="cancel-payment-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body p-4">
                        <div class="text-center">
                            <i class="dripicons-warning h1 text-danger"></i>
                            <h4 class="mt-2">Precaución!</h4>
                            <p class="mt-3">¿Está seguro(a) de cancelar el pago?</p>
                            <button type="button" class="btn btn-light my-2" data-dismiss="modal">Cancelar</button>
                            <form id="cancel_payment_form" style="display: inline;" action="{{ route('pagos.cancel') }}" method="POST">
                                {!! csrf_field() !!}
                                {!! method_field('DELETE') !!}
                                <input type="hidden" name="payment_id">
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
            var table = $("#payments-datatable").DataTable({
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

                if(val == "Abonado"){
                    table.search( val ).draw();
                }else if(val == "Eliminado"){
                    table.search( val ).draw();
                }else if(val == "Todo"){
                    table.search( "" ).draw();
                }
            })
            table.search( "" ).draw();
        });

        function information_invoice(){
            var id = $('#register-payment-form select[name=invoice_id]').val();
            var url = '/facturas/buscar/' + id;
            axios.get(url).then(function(response) {
                console.log(response.data);
                var neto = response.data.invoice.neto;
                var iva = response.data.invoice.iva;
                var total = parseFloat(neto) + parseFloat(iva);
                $('#register-payment-form input[name=neto]').val(neto);
                $('#register-payment-form input[name=iva]').val(iva);
                $('#register-payment-form input[name=total]').val(total.toFixed(2));
                $('#register-payment-form input[name=pendiente]').val((total - response.data.pagado).toFixed(2));
            }).catch(function(error) {
                console.log(response.error);
            })
        }

        function information_payment_modal($id){
            var url = '/pagos/' + $id;
            axios.get(url).then(function(response) {
                console.log(response.data);
                $('#information-payment-form input[name=payment_id]').val($id);
                $('#information-payment-form input[name=monto]').val(response.data.monto);
                $('#information-payment-form input[name=fecha_pago]').val(response.data.fecha_pago);
                $('#information-payment-form textarea[name=comentarios]').val(response.data.comentarios);
                $('#information-payment-modal').modal('show');
            }).catch(function(error) {
                console.log(response.error);
            })
        }

        function cancel_payment($id)
        {
            $('#cancel_payment_form input[name=payment_id]').val($id);
            $('#cancel-payment-modal').modal('show');
        }

        @if($errors->any())
            $('#information-operation-modal').modal('show');
        @endif
        @if(session()->has('info'))
            $.NotificationApp.send("Bien hecho!", "{{ session('info') }}", 'top-right', 'rgba(0,0,0,0.2)', 'success');
        @endif
    </script>
@endsection