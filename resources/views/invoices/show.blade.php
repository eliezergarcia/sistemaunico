@extends('layouts.hyper')

@section('title', 'Sistema | Información de factura')

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
                        <li class="breadcrumb-item"><a href="{{ route('facturas.index') }}">Facturas</a></li>
                        <li class="breadcrumb-item active">Factura {{ $invoice->factura }}</li>
                    </ol>
                </div>
                <h4 class="page-title">Información de factura {{ $invoice->factura }}</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="float-right mb-2">
                        @if(!$invoice->canceled_at)
                            <button class="btn btn-light action-icon" onclick="information_invoice_modal({{ $invoice->id }})"><i class="mdi mdi-square-edit-outline"></i> Editar información</button>
                            <button class="btn btn-danger action-icon" data-toggle="modal" data-target="#cancel-invoice-modal"><i class="mdi mdi-close-box-outline"></i> Cancelar factura</button>
                        @else
                        @endif
                    </div>
                    <div class="table-responsive-sm">
                        <table class="table table-centered dt-responsive nowrap w-100 dataTable no-footer dtr-inline">
                            <thead class="thead-light">
                                <tr>
                                    <th width="5%">Folio</th>
                                    <th width="10%">Fecha factura</th>
                                    <th>Cliente</th>
                                    <th width="7%">Tipo</th>
                                    <th width="7%">Lugar</th>
                                    <th width="7%">Moneda</th>
                                    <th width="10%">Neto</th>
                                    <th width="10%">IVA</th>
                                    <th width="10%">Total</th>
                                    <th width="5%">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $invoice->factura }}</td>
                                    <td>{{ $invoice->fechaFacturaFormat }}</td>
                                    <td>{{ strtoupper($invoice->client->codigo_cliente) }}</td>
                                    <td>{{ $invoice->tipo }}</td>
                                    <td>{{ $invoice->lugar }}</td>
                                    <td>{{ $invoice->moneda }}</td>
                                    <td>$ {{ number_format($invoice->neto, 2, '.', ',') }}</td>
                                    <td>$ {{ number_format($invoice->iva, 2, '.', ',') }}</td>
                                    <td>$ {{ number_format($invoice->neto + $invoice->iva, 2, '.', ',') }}</td>
                                    <td>{{ $invoice->present()->statusBadge() }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <h4>Información de pagos</h4>
            <div class="card">
                <div class="card-body">
                    @if($invoice->pagado != $invoice->total)
                        @if(!$invoice->canceled_at)
                            <div class="col-2">
                                <button id="btnModal" class="btn btn-primary mb-2" data-toggle="modal" data-target="#register-payment-modal"><i class="mdi mdi-plus-circle mr-2"></i> <b>Registrar pago</b></button>
                            </div>
                        @endif
                    @endif
                    <table id="payments-datatable" class="table table-centered dt-responsive  w-100 dataTable no-footer dtr-inline">
                            <thead class="thead-light">
                                <tr>
                                    <th width="2%">#</th>
                                    <th width="3%">Factura</th>
                                    <th width="15%">Monto pago</th>
                                    <th width="16%">Fecha pago</th>
                                    <th>Comentarios</th>
                                    <th width="8%">Status</th>
                                    <th width="5%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payments as $key => $payment)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $payment->invoice->factura }}</td>
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
            </div>
        </div>
        <div class="col-6">
            <h4>Información de solicitud</h4>
            <div class="card">
                <div class="card-body">
                    <p>Solicitado por: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>{{ $operation->user->name }}</b></p>
                    <p>Tipo de solicitud: &nbsp;&nbsp;
                        <b>
                            @if($invoice->debitnotes->isNotEmpty())
                                <a href="{{ route('operations.debitnote', $solicitado->id )}}" data-toggle="tooltip" data-placemente="top" data-original-title="Ver información de solicitud">Debitnote - {{ $solicitado->numberformat }}</a>
                            @else
                                <a href="{{ route('operations.prefacture', $solicitado->id )}}" data-toggle="tooltip" data-placemente="top" data-original-title="Ver información de solicitud">Prefactura - {{ $solicitado->numberformat }}</a>
                            @endif
                        </b>
                    </p>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <p>Cliente: </p>
                                </div>
                                <div class="col">
                                    <p><b>{{ $solicitado->client->razon_social }}</b></p>
                                </div>
                            </div>
                        </div>
                        <div class="col">

                        </div>
                    </div>
                    <h5>Conceptos de operación</h5>
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead class="thead-light">
                                        <tr style="border-color: #545353;">
                                            <th>#</th>
                                            <th><b>Description</b></th>
                                            <th class="text-center">Curr</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-right">Rate</th>
                                            <th class="text-right">Iva</th>
                                            <th class="text-right">Foreign</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($solicitado->conceptsoperations as $key => $concept)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $concept->concept->description }}</td>
                                                <td class="text-center">{{ $concept->concept->curr }}</td>
                                                <td class="text-center">{{ $concept->qty }}</td>
                                                <td class="text-right">{{ number_format($concept->rate, 2, ".", ",") }}</td>
                                                <td class="text-right">{{ number_format($concept->iva, 2, ".", ",") }}</td>
                                                <td class="text-right">{{ number_format(($concept->rate * $concept->qty) + ($concept->iva * $concept->qty), 2, ".", ",") }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end table-responsive-->
                            <div class="row justify-content-end pl-4 pr-4">
                                <div class="float-right mt-3">
                                    <p><b>Rate Total:</b> <span class="float-right">{{ number_format($solicitado->ratetotal, 2, ".", ",") }}</span></p>
                                    <p><b>Iva:</b> <span class="float-right">{{ number_format($solicitado->ivatotal, 2, ".", ",") }}</span></p>
                                    <h4>FOREIGN TOTAL: &nbsp;&nbsp;&nbsp;&nbsp; {{ number_format($solicitado->foreigntotal, 2, ".", ",") }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
        <div class="col-6">
            <h4>Información de operación</h4>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-6"><p>Operador:</p></div>
                                <div class="col-6"><h5>{{ $operation->user->name }}</h5></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-6"><p>Master consginee:</p></div>
                                <div class="col-6"><p><b>{{ $operation->master->codigo_cliente }}</b></p></div>
                                <div class="col-6"><p>Shipper</p></div>
                                <div class="col-6"><p><b>{{ $operation->ship->codigo_cliente }}</b></p></div>
                                <div class="col-6"><p>House consignee:</p></div>
                                <div class="col-6"><p><b>{{ $operation->house->codigo_cliente }}</b></p></div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-6 align-items-middle">
                            <div class="row">
                                <div class="col-6">
                                    <p>ETD:</p>
                                </div>
                                <div class="col-6">
                                    <p><b>{{ $operation->etd }}</b></p>
                                </div>
                                <div class="col-6">
                                    <p>Tipo:</p>
                                </div>
                                <div class="col-6">
                                    <p><b>{{ $operation->impo_expo }}</b></p>
                                </div>
                                <div class="col-6">
                                    <p>POD:</p>
                                </div>
                                <div class="col-6">
                                    <p><b>{{ strtoupper($operation->pod) }}</b></p>
                                </div>
                                <div class="col-6">
                                    <p>Incoterm:</p>
                                </div>
                                <div class="col-6">
                                    <p><b>{{ strtoupper($operation->incoterm) }}</b></p>
                                </div>
                                <div class="col-6">
                                    <p>Custom cutoff:</p>
                                </div>
                                <div class="col-6">
                                    <p><b>{{ $operation->custom_cutoff }}</b></p>
                                </div>
                                <div class="col-6">
                                    <p>O/F:</p>
                                </div>
                                <div class="col-6">
                                    <p><b>{{ strtoupper($operation->o_f) }}</b></p>
                                </div>
                                <div class="col-6">
                                    <p>M B/L:</p>
                                </div>
                                <div class="col-6">
                                    <p><b>{{ strtoupper($operation->m_bl) }}</b></p>
                                </div>
                                <div class="col-6">
                                    <p>AA:</p>
                                </div>
                                <div class="col-6">
                                    <p><b>{{ strtoupper($operation->aa) }}</b></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-6">
                                    <p>ETA:</p>
                                </div>
                                <div class="col-6">
                                    <p><b>{{ $operation->eta }}</b></p>
                                </div>
                                <div class="col-6">
                                    <p>POL:</p>
                                </div>
                                <div class="col-6">
                                    <p><b>{{ strtoupper($operation->pol) }}</b></p>
                                </div>
                                <div class="col-6">
                                    <p>Destino:</p>
                                </div>
                                <div class="col-6">
                                    <p><b>{{ strtoupper($operation->destino) }}</b></p>
                                </div>
                                <div class="col-6">
                                    <p>Booking #:</p>
                                </div>
                                <div class="col-6">
                                    <p><b>{{ strtoupper($operation->booking) }}</b></p>
                                </div>
                                <div class="col-6">
                                    <p>Vessel:</p>
                                </div>
                                <div class="col-6">
                                    <p><b>{{ strtoupper($operation->vessel) }}</b></p>
                                </div>
                                <div class="col-6">
                                    <p>C. Invoice:</p>
                                </div>
                                <div class="col-6">
                                    <p><b>{{ strtoupper($operation->c_invoice) }}</b></p>
                                </div>
                                <div class="col-6">
                                    <p>H B/L:</p>
                                </div>
                                <div class="col-6">
                                    <p><b>{{strtoupper($operation->h_bl) }}</b></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <hr/>
                    <div class="row justify-content-end">
                        <div class="col-6">
                        </div>
                        <div class="col-3">
                            <p>QTY:</p>
                        </div>
                        <div class="col-3">
                            <p><b>{{ count($operation->containers) }}</b></p>
                        </div>
                        <div class="col-6">
                        </div>
                        <div class="col-3">
                            <p>Weight:</p>
                        </div>
                        <div class="col-3">
                            <p><b>{{ number_format($operation->containers->pluck('weight')->sum(), 2, ".", ",") }} KGS</b></p>
                        </div>
                        <div class="col-6">
                        </div>
                        <div class="col-3">
                            <p>Measures:</p>
                        </div>
                        <div class="col-3">
                            <p><b>{{ number_format($operation->containers->pluck('measures')->sum(), 2, ".", ",") }} CBM
                        </div></b></p>
                    </div>
                </div>
            </div>
            <!-- Personal-Information -->
        </div> <!-- end col-->
        <div class="col-6">
            <h4>Información de contenedores</h4>
             <div class="card">
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table id="containers-datatable" class="table table-centered table-hover dt-responsive nowrap w-100 dataTable no-footer dtr-inline">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Cntr #</th>
                                    <th>Seal No.</th>
                                    <th>Type</th>
                                    <th>Size</th>
                                    <th class="text-center">QTY</th>
                                    <th>Modalidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($operation->containers as $key => $container)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $container->cntr }}</td>
                                        <td>{{ $container->seal_no }}</td>
                                        <td>{{ $container->type }}</td>
                                        <td>{{ $container->size }}</td>
                                        <td class="text-center">{{ $container->qty }}</td>
                                        <td>{{ $container->modalidad }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
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
                            <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                            <div id="container-nodes" class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Factura</label>
                                        <input class="form-control " type="text" name="factura" value="">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Fecha factura</label>
                                        <input class="form-control " type="date" name="fecha_factura" value="">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Moneda</label>
                                        <select type="text" class="form-control select2" data-toggle="select2" value=""  name="moneda">
                                            <option value="MXN">MXN</option>
                                            <option value="USD">USD</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Tipo</label>
                                        <select type="text" class="form-control select2" data-toggle="select2" value=""  name="tipo">
                                            <option value="IMPO">IMPO</option>
                                            <option value="EXPO">EXPO</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Lugar</label>
                                        <input class="form-control " type="text" name="lugar" value="">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Neto</label>
                                        <input class="form-control " type="number" step="any" name="neto" value="">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Iva</label>
                                        <input class="form-control " type="number" step="any" name="iva" value="">
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
                            <p class="mt-3">¿Está seguro(a) de cancelar la factura?</p>
                            <button type="button" class="btn btn-light my-2" data-dismiss="modal">Cancelar</button>
                            <form id="cancel_invoice_form" style="display: inline;" action="{{ route('facturas.cancel') }}" method="POST">
                                {!! csrf_field() !!}
                                {!! method_field('DELETE') !!}
                                <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                                <button type="sumbit" class="btn btn-danger my-2"><b>Eliminar</b></button>
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
                        <h4 class="modal-title" id="primary-header-modalLabel">Registro de pago</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form id="register-payment-form" method="POST" action="{{ route('pagos.store') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                            {!! csrf_field() !!}
                            <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Factura <span class="text-danger">*</span></label>
                                        <input class="form-control " type="text" name="invoice_id" value="{{ $invoice->factura }}" disabled="">
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
                }else if(val == "Todo"){
                    table.search( "" ).draw();
                }
            })
            table.search( "" ).draw();

            var id = $('#register-payment-form input[name=invoice_id]').val();
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
        });

        function information_invoice_modal(id){
            console.log(id);
            var url = '/facturas/buscar/' + id;
            axios.get(url).then(function(response) {
                console.log(response.data);
                // $('#information-invoice-form input[name=invoice_id]').val(id);
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

        function cancel_invoice($id)
        {
            $('#cancel_invoice_form input[name=invoice_id]').val($id);
            $('#cancel-invoice-modal').modal('show');
        }

        function information_invoice(){
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
    </script>
@endsection