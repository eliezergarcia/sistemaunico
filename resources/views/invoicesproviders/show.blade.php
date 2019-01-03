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
                        <li class="breadcrumb-item"><a href="{{ route('facturasproveedor.index') }}">Facturas de proveedor</a></li>
                        <li class="breadcrumb-item active">Factura #{{ $invoice->factura }}</li>
                    </ol>
                </div>
                <h4 class="page-title">Información de factura # {{ $invoice->factura }}</h4>
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
	                        <button class="btn btn-light action-icon" data-toggle="modal" data-target="#information-invoice-modal"><i class="mdi mdi-square-edit-outline"></i> Editar información</button>
                            @if(Auth::user()->present()->isAdmin() || Auth::user()->present()->isFin())
	                        <button class="btn btn-danger action-icon" data-toggle="modal" data-target="#deactivate-invoice-modal"><i class="mdi mdi-close-box-outline"></i> Cancelar factura</button>
                            @endif
	                    @else
	                    @endif
                	</div>
                    <div class="table-responsive-sm">
                        <table id="invoice-datatable" class="table table-centered table-striped dt-responsive dataTable no-footer dtr-inline">
                            <thead>
                                <tr>
                                    <th width="20%">Proveedor</th>
                                    <th width="8%">Código de control</th>
                                    <th width="8%">Fecha invoice</th>
                                    <th width="8%">Expense type</th>
                                    <th width="8%">Expense description</th>
                                    <th width="7%">Neto</th>
                                    <th width="7%">Vat</th>
                                    <th width="7%">Retention</th>
                                    <th width="7%">Others</th>
                                    <th width="8%">Total</th>
                                    <th width="8%">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $invoice->provider->razon_social }}</td>
                                    <td>{{ $invoice->controlcode }}</td>
                                    <td>{{ $invoice->invoice_date }}</td>
                                    <td>{{ $invoice->expense_tipe }}</td>
                                    <td>{{ $invoice->expense_description }}</td>
                                    <td>$ {{ $invoice->neto }}</td>
                                    <td>{{ $invoice->vat }}</td>
                                    <td class="text-danger">- {{ $invoice->retention }}</td>
                                    <td>{{ $invoice->others }}</td>
                                    <td>{{ $invoice->total }}</td>
                                    <td>
                                        {{ $invoice->present()->statusBadge() }}
                                    </td>
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
                    @if(Auth::user()->present()->isAdmin() || Auth::user()->present()->isFin())
                        @if($invoice->pagado < $invoice->total)
                            <div class="col-2">
                                <button id="btnModal" class="btn btn-primary mb-2" data-toggle="modal" data-target="#register-payment-modal"><i class="mdi mdi-plus-circle mr-2"></i> <b>Registrar pago</b></button>
                            </div>
                        @endif
                    @endif
                    <div class="table-responsive-sm">
                        <table id="payments-datatable" class="table table-centered table-striped dt-responsive nowrap w-100 dataTable no-footer dtr-inline">
                            <thead>
                                <tr>
                                    <th width="4%">#</th>
                                    <th width="8%">Monto pago</th>
                                    <th width="7%">Fecha pago</th>
                                    <th>Comentarios</th>
                                    <th width="7%">Status</th>
                                    <th width="7%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoice->payments as $key => $payment)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>$
                                            @if(number_format($payment->monto, 2, '.', ',') <= $invoice->total)
                                                {{ $payment->monto }}
                                            @else
                                                {{ $invoice->total }}
                                            @endif
                                        </td>
                                        <td>{{ $payment->fecha_pago }}</td>
                                        <td>{{ $payment->comentarios }}</td>
                                        <td>
                                            @if(!$payment->deleted_at)
                                                <span class="badge badge-success-lighten">Aplicado</span>
                                            @else
                                                <span class="badge badge-danger-lighten">Cancelado</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!$payment->deleted_at)
                                                @if(number_format($payment->monto, 2, '.', ',') <= $invoice->total)
                                                    <a  href="javascript:void(0)" class="action-icon"
                                                    data-toggle="tooltip" data-placemente="top" data-original-title="Editar información"
                                                    onclick="information_payment_modal({{ $payment->id }});"><i class="mdi mdi-square-edit-outline"></i></a>
                                                    <a  href="javascript:void(0)" class="action-icon"
                                                    data-toggle="tooltip" data-placemente="top" data-original-title="Eliminar pago"
                                                    onclick="deactivate_payment({{ $payment->id }});"><i class="mdi mdi-delete"></i></a>
                                                @else
                                                    <a href="{{ route('pagosproveedores.index')}}" class="action-icon btn btn-link" data-toggle="tooltip" data-placement="top" title data-original-title="Ver pago"> <i class="mdi mdi-eye"></i></a>
                                                @endif
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
        </div>
        <div class="col-6">
            <h4>Información de solicitud</h4>
            <div class="card">
                <div class="card-body">
					<div class="row">
						<div class="col-6"><p>Operación: </p></div>
						<div class="col-6"><b><a href="{{ route('operaciones.show', $invoice->operation->id )}}"># {{ $invoice->operation->id }}</a></b></div>
						<div class="col-6"><p>Operador: </p></div>
						<div class="col-6"><b>{{ $invoice->operation->user->name }}</b></div>
					</div>
					<hr>
					<div class="row">
                        <div class="col-6"><p>Cliente (House consignee): </p></div>
                        <div class="col-6"><b>{{ $invoice->operation->house->razon_social }}</b></div>
						<div class="col-6"><p>M B/L: </p></div>
						<div class="col-6"><b>{{ $invoice->operation->m_bl }}</b></div>
						<div class="col-6"><p>H B/L: </p></div>
						<div class="col-6"><b>{{ $invoice->operation->h_bl }}</b></div>
						<div class="col-6"><p>ETA: </p></div>
						<div class="col-6"><b>{{ $invoice->operation->eta }}</b></div>
					</div>
					<hr>
                    <h5>Conceptos de factura</h5>
					<div class="row">
                        <div class="col">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
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
                                        <?php $neto = 0; $iva = 0; $foreigntotal = 0; ?>
                                        @foreach($invoice->conceptsinvoice as $key => $concept)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $concept->concept->description }}</td>
                                                <td class="text-center">{{ $concept->concept->curr }}</td>
                                                <td class="text-center">{{ $concept->qty }}</td>
                                                <td class="text-right">{{ number_format($concept->rate,2,".","") }}</td>
                                                <td class="text-right">{{ number_format($concept->iva,2,".","") }}</td>
                                                <td class="text-right">{{ number_format(($concept->rate * $concept->qty) + ($concept->iva * $concept->qty),2,".","") }}</td>
                                            </tr>
                                            <?php
                                                $foreigntotal = $foreigntotal + ($concept->rate * $concept->qty) + ($concept->iva * $concept->qty);
                                                $neto = $neto + ($concept->rate * $concept->qty);
                                                $iva = $iva + ($concept->iva * $concept->qty);
                                            ?>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end table-responsive-->
                            <div class="row justify-content-end pl-4 pr-4">
                                <div class="float-right mt-3">
                                    <p><b>Total:</b> <span class="float-right">{{ number_format($foreigntotal ,2,".","") }}</span></p>
                                    <h5>FOREIGN TOTAL: &nbsp;&nbsp;&nbsp;&nbsp; {{ number_format($foreigntotal ,2,".","") }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
		<div class="col-6">
            <h4>Factura(s) UNICO</h4>
             <div class="card">
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table id="containers-datatable" class="table table-centered table-striped table-hover table-striped dt-responsive nowrap w-100 dataTable no-footer dtr-inline">
                            <thead>
                                <tr>
                                    <th>Folio</th>
                                    <th>Fecha</th>
                                    <th>Cliente</th>
                                    <th>Neto</th>
                                    <th>IVA</th>
                                    <th>Total</th>
                                    <th class="text-center">Status</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($invoice->operation->debitnotes->isNotEmpty())
                                	@foreach($invoice->operation->debitnotes as $debitnote)
                                        @if($debitnote->invoices->isNotEmpty())
        	                            	<tr>
        	                            		<td>{{ $debitnote->invoices->first()->factura }}</td>
        	                            		<td>{{ $debitnote->invoices->first()->fecha_factura }}</td>
        	                            		<td>{{ $debitnote->invoices->first()->client->codigo_cliente }}</td>
        	                            		<td>$ {{ $debitnote->invoices->first()->neto }}</td>
        	                            		<td>$ {{ $debitnote->invoices->first()->iva }}</td>
        	                            		<td>$ {{ $debitnote->invoices->first()->neto + $debitnote->invoices->first()->iva }}</td>
        	                            		<td>{!! $debitnote->invoices->first()->status !!}</td>
        	                            		<td><a href="{{ route('facturas.show', $debitnote->invoices->first()->factura )}}" class="action-icon" data-toggle="tooltip" data-placement="top" title data-original-title="Ver factura"> <i class="mdi mdi-eye"></i></a></td>
        	                            	</tr>
                                        @endif
                                	@endforeach
                                @endif
                                @if($invoice->operation->prefactures->isNotEmpty())
    								@foreach($invoice->operation->prefactures as $prefacture)
                                        @if($prefacture->invoices->isNotEmpty())
        	                            	<tr>
        	                            		<td>{{ $prefacture->invoices->first()->factura }}</td>
        	                            		<td>{{ $prefacture->invoices->first()->fecha_factura }}</td>
        	                            		<td>{{ $prefacture->invoices->first()->client->codigo_cliente }}</td>
        	                            		<td>$ {{ $prefacture->invoices->first()->neto }}</td>
        	                            		<td>$ {{ $prefacture->invoices->first()->iva }}</td>
        	                            		<td>$ {{ $prefacture->invoices->first()->neto + $prefacture->invoices->first()->iva }}</td>
        	                            		<td>{!! $prefacture->invoices->first()->status !!}</td>
        	                            		<td><a href="{{ route('facturas.show', $prefacture->invoices->first()->factura )}}" class="action-icon" data-toggle="tooltip" data-placement="top" title data-original-title="Ver factura"> <i class="mdi mdi-eye"></i></a></td>
        	                            	</tr>
                                        @endif
                                	@endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <h4>Información de operación</h4>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 justify-content-center">
                            <div class="col-6">
                                <p>Operador:</p>
                            </div>
                            <div class="col-6">
                                <h5>{{ $invoice->operation->user->name }}</h5>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-6">
                                    <p>Master consginee:</p>
                                </div>
                                <div class="col-6">
                                    <p><b>{{ $invoice->operation->master->codigo_cliente }}</b></p>
                                </div>
                                <div class="col-6">
                                    <p>Shipper</p>
                                </div>
                                <div class="col-6">
                                    <p><b>{{ $invoice->operation->ship->codigo_cliente }}</b></p>
                                </div>
                                <div class="col-6">
                                    <p>House consignee:</p>
                                </div>
                                <div class="col-6">
                                    <p><b>{{ $invoice->operation->house->codigo_cliente }}</b></p>
                                </div>
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
                                    <p><b>{{ $invoice->operation->etd }}</b></p>
                                </div>
                                <div class="col-6">
                                    <p>Tipo:</p>
                                </div>
                                <div class="col-6">
                                    <p><b>{{ $invoice->operation->impo_expo }}</b></p>
                                </div>
                                <div class="col-6">
                                    <p>POD:</p>
                                </div>
                                <div class="col-6">
                                    <p><b>{{ strtoupper($invoice->operation->pod) }}</b></p>
                                </div>
                                <div class="col-6">
                                    <p>Incoterm:</p>
                                </div>
                                <div class="col-6">
                                    <p><b>{{ strtoupper($invoice->operation->incoterm) }}</b></p>
                                </div>
                                <div class="col-6">
                                    <p>Custom cutoff:</p>
                                </div>
                                <div class="col-6">
                                    <p><b>{{ $invoice->operation->custom_cutoff }}</b></p>
                                </div>
                                <div class="col-6">
                                    <p>O/F:</p>
                                </div>
                                <div class="col-6">
                                    <p><b>{{ strtoupper($invoice->operation->o_f) }}</b></p>
                                </div>
                                <div class="col-6">
                                    <p>M B/L:</p>
                                </div>
                                <div class="col-6">
                                    <p><b>{{ strtoupper($invoice->operation->m_bl) }}</b></p>
                                </div>
                                <div class="col-6">
                                    <p>AA:</p>
                                </div>
                                <div class="col-6">
                                    <p><b>{{ strtoupper($invoice->operation->aa) }}</b></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-6">
                                    <p>ETA:</p>
                                </div>
                                <div class="col-6">
                                    <p><b>{{ $invoice->operation->eta }}</b></p>
                                </div>
                                <div class="col-6">
                                    <p>POL:</p>
                                </div>
                                <div class="col-6">
                                    <p><b>{{ strtoupper($invoice->operation->pol) }}</b></p>
                                </div>
                                <div class="col-6">
                                    <p>Destino:</p>
                                </div>
                                <div class="col-6">
                                    <p><b>{{ strtoupper($invoice->operation->destino) }}</b></p>
                                </div>
                                <div class="col-6">
                                    <p>Booking #:</p>
                                </div>
                                <div class="col-6">
                                    <p><b>{{ strtoupper($invoice->operation->booking) }}</b></p>
                                </div>
                                <div class="col-6">
                                    <p>Vessel:</p>
                                </div>
                                <div class="col-6">
                                    <p><b>{{ strtoupper($invoice->operation->vessel) }}</b></p>
                                </div>
                                <div class="col-6">
                                    <p>C. Invoice:</p>
                                </div>
                                <div class="col-6">
                                    <p><b>{{ strtoupper($invoice->operation->c_invoice) }}</b></p>
                                </div>
                                <div class="col-6">
                                    <p>H B/L:</p>
                                </div>
                                <div class="col-6">
                                    <p><b>{{strtoupper($invoice->operation->h_bl) }}</b></p>
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
                            <p><b>{{ count($invoice->operation->containers) }}</b></p>
                        </div>
                        <div class="col-6">
                        </div>
                        <div class="col-3">
                            <p>Weight:</p>
                        </div>
                        <div class="col-3">
                            <p><b>{{ $invoice->operation->containers->pluck('weight')->sum() }} KGS</b></p>
                        </div>
                        <div class="col-6">
                        </div>
                        <div class="col-3">
                            <p>Measures:</p>
                        </div>
                        <div class="col-3">
                            <p><b>{{ $invoice->operation->containers->pluck('measures')->sum() }} CBM
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
                        <table id="containers-datatable" class="table table-centered table-striped table-hover table-striped dt-responsive nowrap w-100 dataTable no-footer dtr-inline">
                            <thead>
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
                                @foreach($invoice->operation->containers as $key => $container)
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
                        <form id="information-invoice-form" method="POST" action="{{ route('facturasproveedor.modificar') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                            {!! csrf_field() !!}
                            <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                            <div class="row">
                                 <div class="col-7">
                                    <div class="form-group">
                                        <label>Proveedor <span class="text-danger">*</span></label>
                                        <select class="form-control {{ $errors->has('provider_id') ? ' is-invalid' : '' }}" name="provider_id">
                                            <option value="">Selecciona...</option>
                                            @foreach($providers as $provider)
                                                @if($provider->id == $invoice->provider_id)
                                                    <option value="{{ $provider->id }}" selected>{{ $provider->razon_social }}</option>
                                                @else
                                                    <option value="{{ $provider->id }}">{{ $provider->razon_social }}</option>
                                                @endif
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
                                        <label>Folio <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control {{ $errors->has('factura') ? ' is-invalid' : '' }}" name="factura" value="{{ $invoice->factura }}">
                                        @if ($errors->has('factura'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('factura') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Invoice date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control {{ $errors->has('invoice_date') ? ' is-invalid' : '' }}" name="invoice_date" value="{{ $invoice->invoice_date }}">
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
                                        <input type="text" class="form-control {{ $errors->has('expense_tipe') ? ' is-invalid' : '' }}" name="expense_tipe" value="{{ $invoice->expense_tipe }}">
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
                                            <option value="INVOICE" {{ $invoice->expense_description == "INVOICE" ? 'selected' : ''}}>INVOICE</option>
                                            <option value="INVOICE EXTRANJERO" {{ $invoice->expense_description == "INVOICE EXTRANJERO" ? 'selected' : ''}}>INVOICE EXTRANJERO</option>
                                            <option value="DEBIT NOTE" {{ $invoice->expense_description == "DEBIT NOTE" ? 'selected' : ''}}>DEBIT NOTE</option>
                                        </select>
                                        @if ($errors->has('expense_description'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('expense_description') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-4"></div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Neto <span class="text-danger">*</span></label>
                                        <input type="number" step="any" class="form-control {{ $errors->has('neto') ? ' is-invalid' : '' }}" name="neto" value="{{ $invoice->neto }}">
                                        @if ($errors->has('neto'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('neto') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Vat <span class="text-danger">*</span></label>
                                        <input type="number" step="any" class="form-control {{ $errors->has('vat') ? ' is-invalid' : '' }}" name="vat" value="{{ $invoice->vat }}">
                                        @if ($errors->has('vat'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('vat') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Retention <span class="text-danger">*</span></label>
                                        <input type="number" step="any" class="form-control {{ $errors->has('retention') ? ' is-invalid' : '' }}" name="retention" value="{{ $invoice->retention }}">
                                        @if ($errors->has('retention'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('retention') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Others <span class="text-danger">*</span></label>
                                        <input type="number" step="any" class="form-control {{ $errors->has('others') ? ' is-invalid' : '' }}" name="others" value="{{ $invoice->others }}">
                                        @if ($errors->has('others'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('others') }}</strong>
                                            </span>
                                        @endif
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
                                <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
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
                        <h4 class="modal-title" id="primary-header-modalLabel">Registro de pago</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form id="register-payment-form" method="POST" action="{{ route('pagosproveedores.store') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                            {!! csrf_field() !!}
                            {{-- <input type="hidden" name="invoice_id"> --}}
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Factura</label>
                                        <input class="form-control " type="text" name="invoice_id" required value="{{ $invoice->id }}">
                                        </input>
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
                                        <label>Vat</label>
                                        <input class="form-control " type="number" step="any" name="vat" disabled value="">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label>- Retention</label>
                                        <input class="form-control " type="number" step="any" name="retention" disabled value="">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label>Others</label>
                                        <input class="form-control " type="number" step="any" name="others" disabled value="">
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
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Monto</label>
                                        <input class="form-control " type="number" step="any" name="monto" required>
                                    </div>
                                </div>
                                <div class="col-4">
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

        <div id="information-payment-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header pr-4 pl-4">
                        <h4 class="modal-title" id="primary-header-modalLabel">Información de pago</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form id="information-payment-form" method="POST" action="{{ route('pagosproveedores.modificar') }}" enctype="multipart/form-data" class="pl-2 pr-2">
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

        <div id="deactivate-payment-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body p-4">
                        <div class="text-center">
                            <i class="dripicons-warning h1 text-danger"></i>
                            <h4 class="mt-2">Precaución!</h4>
                            <p class="mt-3">¿Está seguro(a) de cancelar el pago?</p>
                            <button type="button" class="btn btn-light my-2" data-dismiss="modal">Cancelar</button>
                            <form id="deactivate_payment_form" style="display: inline;" action="{{ route('pagosproveedores.deactivate') }}" method="POST">
                                {!! csrf_field() !!}
                                {!! method_field('DELETE') !!}
                                <input type="hidden" name="payment_id">
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

        function deactivate_invoice($id)
        {
            $('#deactivate_invoice_form input[name=invoice_id]').val($id);
            $('#deactivate-invoice-modal').modal('show');
        }

        $('#register-payment-modal').on('shown.bs.modal', function (e) {
            information_invoice();
        })

        function information_invoice(){
            var id = $('#register-payment-form input[name=invoice_id]').val();
            console.log(id);
            var url = '/facturasproveedor/buscar/' + id;
            axios.get(url).then(function(response) {
                console.log(response.data);
                var neto = response.data.invoice.neto;
                var vat = response.data.invoice.vat;
                var retention = response.data.invoice.retention;
                var others = response.data.invoice.others;
                var total = (parseFloat(neto) + parseFloat(vat) + parseFloat(others)) - parseFloat(retention);
                $('#register-payment-form input[name=neto]').val(neto);
                $('#register-payment-form input[name=vat]').val(vat);
                $('#register-payment-form input[name=retention]').val(retention);
                $('#register-payment-form input[name=others]').val(others);
                $('#register-payment-form input[name=total]').val(total.toFixed(2));
                $('#register-payment-form input[name=pendiente]').val((total - response.data.pagado).toFixed(2));
            }).catch(function(error) {
                console.log(response.error);
            })
        }

        function information_payment_modal($id){
            var url = '/pagosproveedores/' + $id;
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

        function deactivate_payment($id)
        {
            $('#deactivate_payment_form input[name=payment_id]').val($id);
            $('#deactivate-payment-modal').modal('show');
        }

        @if($errors->any())
            $('#information-invoice-modal').modal('show');
        @endif
        @if(session()->has('info'))
            $.NotificationApp.send("Bien hecho!", "{{ session('info') }}", 'top-right', 'rgba(0,0,0,0.2)', 'success');
        @endif
    </script>
@endsection