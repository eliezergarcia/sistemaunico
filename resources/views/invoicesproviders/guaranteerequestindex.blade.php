@extends('layouts.hyper')

@section('title', 'Sistema | Solicitudes de garantía')

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
                        <li class="breadcrumb-item active">Solicitudes de garantía</li>
                    </ol>
                </div>
                <h4 class="page-title">Solicitudes de garantía</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- <div class="form-group form-inline">
                        <label for="">Mostrar &nbsp;</label>
                        <select name="filtro-datatables" id="filtro-datatables" class="form-control">
                            <option value="Pendiente">Pendientes</option>
                            <option value="Finalizado">Finalizados</option>
                            <option value="Cancelado">Cancelados</option>
                            <option value="Todo" selected>Todos</option>
                        </select>
                    </div> --}}
                    {{-- <div class="row mb-2">
                        <div class="col-sm-4">
                            <button id="btnModal" class="btn btn-primary mb-2" data-toggle="modal" data-target="#register-invoice-modal"><i class="mdi mdi-plus-circle mr-2"></i> <b>Registrar factura</b></button>
                        </div>
                    </div> --}}
                    @if(Auth::user()->present()->isFin() || Auth::user()->present()->isAdminGeneral())
                        <div class="row justify-content-around">
                            <div class="col-9">
                                    <button id="btnModal" class="btn btn-primary mb-2" onclick="generate_revision_modal()"><i class="mdi mdi-file-check mr-2"></i> <b>Generar revisión</b></button>
                                    <button id="btnModal" class="btn btn-primary mb-2" onclick="register_payment_modal()"><i class="mdi mdi-plus-circle mr-2"></i> <b>Registrar devolución</b></button>
                            </div>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="col">
                                <div class="row align-items-end">
                                    <div class="col">
                                        <h5>Neto:</h5>
                                        <h5>Vat:</h5>
                                        <h5>Retention:</h5>
                                        <h5>Others:</h5>
                                        <h4>Total:</h4>
                                    </div>
                                    <div class="col">
                                        <h5 id="label-neto"></h5>
                                        <h5 id="label-vat"></h5>
                                        <h5 id="label-retention"></h5>
                                        <h5 id="label-others"></h5>
                                        <h4 id="label-total"></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2 form-group form-inline">
                                <label for="">Mostrar &nbsp;</label>
                                <select name="filtro-datatables" id="filtro-datatables" class="form-control">
                                    <option value="Pendiente autorización">Pdt. autorización</option>
                                    <option value="Pendiente revisión" selected>Pdt. revisión</option>
                                    <option value="Pendiente factura">Pdt. factura</option>
                                    <option value="Todo">Todos</option>
                                </select>
                            </div>
                            <div class="col-10">
                            </div>
                        </div>
                    @endif
                    <div class="table-responsive-sm">
                        <table id="invoices-datatable" class="table table-centered table-striped dt-responsive nowrap w-100 dataTable no-footer dtr-inline">
                            <thead>
                                <tr>
                                    @if(auth()->user()->present()->isFin() || auth()->user()->present()->isAdminGeneral())
                                        <th>Revisión
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="selectAllRevision">
                                                <label class="custom-control-label" for="selectAllRevision">&nbsp;</label>
                                            </div>
                                        </th>
                                        <th>Dev.
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="selectAllPago">
                                                <label class="custom-control-label" for="selectAllPago">&nbsp;</label>
                                            </div>
                                        </th>
                                    @endif
                                    <th>CÓDIGO</th>
                                    <th width="10%">Proveedor</th>
                                    <th width="9%">Neto</th>
                                    <th width="9%">Vat</th>
                                    <th width="9%">Retention</th>
                                    <th width="9%">Total</th>
                                    <th>Concepto(s)</th>
                                    <th>Revisión</th>
                                    <th width="10%">Status</th>
                                    <th width="5%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoices as $key => $invoice)
                                    <tr>
                                        @if($invoice->canceled_at)
                                            <td></td>
                                            <td></td>
                                        @else
                                            @if(auth()->user()->present()->isFin() || auth()->user()->present()->isAdminGeneral())
                                                <td>
                                                    @if($invoice->aut_oper && !$invoice->aut_fin)
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="checkrevision{{ $invoice->id }}" value="{{ $invoice->id }}" name="invoicesrevision">
                                                            <label class="custom-control-label" for="checkrevision{{ $invoice->id }}">&nbsp;</label>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($invoice->pagado < $invoice->total)
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="checkpago{{ $invoice->id }}" value="{{ $invoice->id }}" name="invoicespago">
                                                            <label class="custom-control-label" for="checkpago{{ $invoice->id }}">&nbsp;</label>
                                                        </div>
                                                    @endif
                                                </td>
                                            @endif
                                        @endif
                                        <td>{{ $invoice->controlcode }}</td>
                                        <td>{{ $invoice->provider->codigo_proveedor }}</td>
                                        <td>$ {{ number_format($invoice->neto, 2, '.', ',') }}</td>
                                        <td>$ {{ number_format($invoice->vat, 2, '.', ',') }}</td>
                                        <td class="text-danger">$ - {{ number_format($invoice->retention, 2, '.', ',') }}</td>
                                        <td>$ {{ $invoice->total }}</td>
                                        <td>
                                            @foreach($invoice->conceptsinvoice as $key => $concept)
                                                {{ $concept->concept->description }} <br>
                                            @endforeach
                                        </td>
                                        <td>{{ $invoice->autfinanzas }}</td>
                                        <td>{{ $invoice->present()->statusBadgeGuarantee() }}</td>
                                        <td>
                                            @if(!$invoice->canceled_at)
                                                @if((Auth::user()->present()->isAdmin() && Auth::user()->present()->isOper()) || Auth::user()->present()->isAdminGeneral() || Auth::user()->present()->isFin())
                                                    <a href="{{ route('operations.guaranteeRequest', $invoice->id ) }}" class="action-icon btn btn-link" data-toggle="tooltip" data-placement="top" title data-original-title="Ver pdf"> <i class="mdi mdi-file-pdf"></i></a>
                                                    <a  href="javascript:void(0)" class="action-icon btn btn-link"
                                                data-toggle="tooltip" data-placemente="top" data-original-title="Editar información"
                                                onclick="information_invoice_modal({{ $invoice->id }});"><i class="mdi mdi-square-edit-outline"></i></a>
                                                    @if(!$invoice->aut_oper)
                                                        <a href="javascript:void(0)" class="action-icon btn btn-link"
                                                        data-toggle="tooltip" data-placemente="top" data-original-title="Autorizar factura"
                                                        onclick="authorize_invoice_modal({{ $invoice->id }})"> <i class="mdi mdi-file-check"></i></a>
                                                    @endif
                                                    @if($invoice->aut_fin)
                                                        <a href="javascript:void(0)" class="action-icon btn btn-link"
                                                        data-toggle="tooltip" data-placemente="top" data-original-title="Cancelar revisión"
                                                        onclick="canceled_revision_modal({{ $invoice->id }})"> <i class="mdi mdi-file-excel-box"></i></a>
                                                    @endif
                                                @endif
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
                        <h4 class="modal-title" id="primary-header-modalLabel">Información de anticipo</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form id="information-invoice-form" method="POST" action="{{ route('facturasproveedor.modificar') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                            {!! csrf_field() !!}
                            <input type="hidden" name="invoice_id">
                            <div class="row">
                                 <div class="col-7">
                                    <div class="form-group">
                                        <label>Proveedor <span class="text-danger">*</span></label>
                                        <select class="form-control {{ $errors->has('provider_id') ? ' is-invalid' : '' }}" name="provider_id">
                                            <option value="">Selecciona...</option>
                                            @foreach($providers as $provider)
                                                <option value="{{ $provider->id }}">{{ $provider->razon_social }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('provider_id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('provider_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                 <div class="col-2">
                                    <div class="form-group">
                                        <label>Folio</label>
                                        <input type="text" class="form-control {{ $errors->has('factura') ? ' is-invalid' : '' }}" name="factura">
                                        @if ($errors->has('factura'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('factura') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Invoice date</label>
                                        <input type="date" class="form-control {{ $errors->has('invoice_date') ? ' is-invalid' : '' }}" name="invoice_date">
                                        @if ($errors->has('invoice_date'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('invoice_date') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Expense type <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control {{ $errors->has('expense_tipe') ? ' is-invalid' : '' }}" name="expense_tipe" value="Freight Expenses">
                                        @if ($errors->has('expense_tipe'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('expense_tipe') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Expense description <span class="text-danger">*</span></label>
                                        <select class="form-control {{ $errors->has('expense_description') ? ' is-invalid' : '' }}" name="expense_description">
                                            <option value="INVOICE" selected>INVOICE</option>
                                            <option value="INVOICE EXTRANJERO">INVOICE EXTRANJERO</option>
                                            <option value="DEBIT NOTE">DEBIT NOTE</option>
                                        </select>
                                        @if ($errors->has('expense_description'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('expense_description') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-4">
                                </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Neto <span class="text-danger">*</span></label>
                                    <input type="number" step="any" class="form-control {{ $errors->has('neto') ? ' is-invalid' : '' }}" name="neto" required="" onchange="calcularTotal()">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Vat</label>
                                    <input type="number" step="any" class="form-control {{ $errors->has('vat') ? ' is-invalid' : '' }}" name="vat" value="0" onchange="calcularTotal()">
                                    @if ($errors->has('vat'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('vat') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Retention</label>
                                    <input type="number" step="any" class="form-control {{ $errors->has('retention') ? ' is-invalid' : '' }}" name="retention" value="0" onchange="calcularTotal()">
                                    @if ($errors->has('retention'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('retention') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Others</label>
                                    <input type="number" step="any" class="form-control {{ $errors->has('others') ? ' is-invalid' : '' }}" name="others" value="0" onchange="calcularTotal()">
                                    @if ($errors->has('others'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('others') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-9"></div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Total</label>
                                    <input type="number" step="any" class="form-control " name="total" value="0">
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

        <div id="deactivate-invoice-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body p-4">
                        <div class="text-center">
                            <i class="dripicons-warning h1 text-danger"></i>
                            <h4 class="mt-2">Precaución!</h4>
                            <p class="mt-3">¿Está seguro(a) de cancelar la factura?</p>
                            <button type="button" class="btn btn-light my-2" data-dismiss="modal">Cancelar</button>
                            <form id="deactivate_invoice_form" style="display: inline;" action="{{ route('facturasproveedor.deactivate') }}" method="POST">
                                {!! csrf_field() !!}
                                {!! method_field('DELETE') !!}
                                <input type="hidden" name="invoice_id">
                                <button type="sumbit" class="btn btn-danger my-2"><b>Aplicar</b></button>
                            </form>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div id="register-payment-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header pr-4 pl-4">
                        <h4 class="modal-title" id="primary-header-modalLabel">Registro de devolución</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form id="register-payment-form" class="pl-2 pr-2">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Monto</label>
                                        <input class="form-control " type="number" step="any" name="monto" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Fecha de devolución</label>
                                        <input class="form-control " type="date" name="fecha_pago" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Comisión</label>
                                        <input class="form-control " type="number" step="any" name="commission" value="0">
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
                        <button type="button" class="btn btn-primary" onclick="register_payment()"><b>Registrar</b></button>
                    </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div id="authorize-invoice-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body p-4">
                        <div class="text-center">
                            <i class="dripicons-warning h1 text-primary"></i>
                            <h4 class="mt-2">Precaución!</h4>
                            <p class="mt-3">¿Está seguro(a) de autorizar esta solicitud de garantía?</p>
                            <button type="button" class="btn btn-light my-2" data-dismiss="modal">Cancelar</button>
                            <form id="authorize_invoice_form" style="display: inline;" action="{{ route('facturasproveedor.authorizeInvoice') }}" method="POST">
                                {!! csrf_field() !!}
                                <input type="hidden" name="invoice_id">
                                <button type="sumbit" class="btn btn-primary my-2"><b>Autorizar</b></button>
                            </form>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div id="generate-revision-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header pr-4 pl-4">
                        <h4 class="modal-title" id="primary-header-modalLabel">Revisión de facturas</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form id="generate-revision-form" class="pl-2 pr-2">
                            <div class="row justify-content-center">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Comisión de banco</label>
                                        <input class="form-control " type="number" step="any" name="comision" required value="0">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Aplicar a balance del dia</label>
                                        <select class="form-control " name="balance_day" required>
                                            <option value="1">Hoy</option>
                                            <option value="2" selected>Siguiente</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="text-right pb-4 pr-4">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="generate_revision()"><b>Generar</b></button>
                    </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div id="canceled-revision-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body p-4">
                        <div class="text-center">
                            <i class="dripicons-warning h1 text-danger"></i>
                            <h4 class="mt-2">Precaución!</h4>
                            <p class="mt-3">¿Está seguro(a) de cancelar la revisión de esta factura?</p>
                            <button type="button" class="btn btn-light my-2" data-dismiss="modal">Cancelar</button>
                            <form id="canceled_revision_form" style="display: inline;" action="{{ route('facturasproveedor.cancelRevision') }}" method="POST">
                                {!! csrf_field() !!}
                                {!! method_field('DELETE') !!}
                                <input type="hidden" name="invoice_id">
                                <button type="sumbit" class="btn btn-danger my-2"><b>Aplicar</b></button>
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

                if(val != "Todo"){
                    table.search( val ).draw();
                }else{
                    table.search( "" ).draw();
                }
            })
            var val = $("#filtro-datatables").val();
            table.search( val ).draw();
        });

        function register_payment_modal()
        {
            var invoices = new Array();
            $("input[name=invoicespago]").each(function (index) {
                if($(this).is(':checked')){
                    invoices.push($(this).val());
                }
            });

            if(invoices.length > 0){
                $('#register-payment-modal').modal('show');
            }else{
                alert("Debes de seleccionar al menos una factura.");
            }
        }

        function generate_revision_modal()
        {
            var invoices = new Array();
            $("input[name=invoicesrevision]").each(function (index) {
                if($(this).is(':checked')){
                    invoices.push($(this).val());
                }
            });

            if(invoices.length > 0){
                $('#generate-revision-modal').modal('show');
            }else{
                alert("Debes de seleccionar al menos una factura.");
            }
        }

        function register_payment()
        {
            var invoices = new Array();
            $("input[name=invoicespago]").each(function (index) {
                if($(this).is(':checked')){
                    invoices.push($(this).val());
                }
            });
            var monto = $('#register-payment-form input[name=monto]').val();
            var commission = $('#register-payment-form input[name=commission]').val();
            var fechapago = $('#register-payment-form input[name=fecha_pago]').val();
            var comentarios = $('#register-payment-form textarea[name=comentarios]').val();
            var option = "guarantee";
            axios.post('/pagosproveedores/facturas', {
                invoices: invoices,
                monto: monto,
                commission: commission,
                fecha_pago: fechapago,
                comentarios: comentarios,
                option: option
              }).then(function (response) {
                $.NotificationApp.send("Bien hecho!", response.data, 'top-right', 'rgba(0,0,0,0.2)', 'success');
                $('#register-payment-modal').modal('hide');
                setInterval("actualizarPagina()", 1000);
              }).catch(function (error) {
                console.log(error);
              });
        }

        function information_invoice_modal($id){
            var url = '/facturasproveedor/buscar/' + $id;
            axios.get(url).then(function(response) {
                console.log(response.data);
                $('#information-invoice-form input[name=invoice_id]').val($id);
                $('#information-invoice-form select[name=provider_id]').val(response.data.invoice.provider_id).change();
                $('#information-invoice-form input[name=factura]').val(response.data.invoice.factura);
                $('#information-invoice-form input[name=invoice_date]').val(response.data.invoice.invoice_date);
                $('#information-invoice-form input[name=expense_tipe]').val(response.data.invoice.expense_tipe);
                $('#information-invoice-form input[name=neto]').val(response.data.invoice.neto);
                $('#information-invoice-form input[name=vat]').val(response.data.invoice.vat);
                $('#information-invoice-form input[name=retention]').val(response.data.invoice.retention);
                $('#information-invoice-form input[name=others]').val(response.data.invoice.others);
                $('#information-invoice-form select[name=expense_description]').val(response.data.invoice.expense_description).change();
                $('#information-invoice-modal').modal('show');
            }).catch(function(error) {
                console.log(response.error);
            })
        }

        function canceled_revision_modal($id)
        {
            $('#canceled_revision_form input[name=invoice_id]').val($id);
            $('#canceled-revision-modal').modal('show');
        }

        function deactivate_invoice($id)
        {
            $('#deactivate_invoice_form input[name=invoice_id]').val($id);
            $('#deactivate-invoice-modal').modal('show');
        }

        function authorize_invoice_modal($id)
        {
            $('#authorize_invoice_form input[name=invoice_id]').val($id);
            $('#authorize-invoice-modal').modal('show');
        }

        function generate_revision()
        {
            var invoices = new Array();
            $("input[name=invoicesrevision]").each(function (index) {
                if($(this).is(':checked')){
                    invoices.push($(this).val());
                }
            });
            var commission = $('#generate-revision-form input[name=comision]').val();
            var balanceday = $('#generate-revision-form select[name=balance_day]').val();
            console.log(invoices);
            console.log(commission);
            console.log(balanceday);
            axios.post('/facturasproveedor/revision', {
                invoices: invoices,
                commission: commission,
                balanceday: balanceday
              }).then(function (response) {
                console.log(response.data);
                $.NotificationApp.send("Bien hecho!", response.data, 'top-right', 'rgba(0,0,0,0.2)', 'success');
                $('#generate-revision-modal').modal('hide');
                setInterval("actualizarPagina()", 1000);
              }).catch(function (error) {
                console.log(error);
              });
        }

        function actualizarPagina(){
            location.reload(true);
        }

        $("input[name=invoicesrevision]").click(function() {
            var invoices = new Array();
            $("input[name=invoicesrevision]").each(function (index) {
                if($(this).is(':checked')){
                    invoices.push($(this).val());
                }
            });

            console.log(invoices);

            axios.get('/pagosproveedores/facturas/total', {
                params: {
                  invoices: invoices
                }
              }).then(function (response) {
                console.log(response);
                document.getElementById('label-neto').innerHTML = "$ " + response.data.neto;
                document.getElementById('label-vat').innerHTML = "$ " + response.data.vat;
                document.getElementById('label-retention').innerHTML = "$ " + response.data.retention;
                document.getElementById('label-others').innerHTML = "$ " + response.data.others;
                document.getElementById('label-total').innerHTML = "$ " + response.data.total;
              }).catch(function (error) {
                console.log(error);
                });
        });

        $("input[name=invoicespago]").click(function() {
            var invoices = new Array();
            $("input[name=invoicespago]").each(function (index) {
                if($(this).is(':checked')){
                    invoices.push($(this).val());
                }
            });

            console.log(invoices);

            axios.get('/pagosproveedores/facturas/total', {
                params: {
                  invoices: invoices
                }
              }).then(function (response) {
                console.log(response);
                document.getElementById('label-neto').innerHTML = "$ " + response.data.neto;
                document.getElementById('label-vat').innerHTML = "$ " + response.data.vat;
                document.getElementById('label-retention').innerHTML = "$ " + response.data.retention;
                document.getElementById('label-others').innerHTML = "$ " + response.data.others;
                document.getElementById('label-total').innerHTML = "$ " + response.data.total;
              }).catch(function (error) {
                console.log(error);
                });
        });

        $("#selectAllRevision").click(function(){
            $("input[name=invoicesrevision]").trigger('click');
         });

        $("#selectAllPago").click(function(){
            $("input[name=invoicespago]").trigger('click');
         });
    </script>
@endsection