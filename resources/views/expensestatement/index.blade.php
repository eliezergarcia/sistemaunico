@extends('layouts.hyper')

@section('title', 'Finanzas | Caja chica')

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
                        <li class="breadcrumb-item active">Caja chica</li>
                    </ol>
                </div>
                <h4 class="page-title">Caja chica</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col">
                            <button id="btnModal" class="btn btn-primary mb-2" data-toggle="modal" data-target="#register-expense-modal"><i class="mdi mdi-plus-circle"></i> <b>Registrar gasto</b></button>
                            <a id="btnModal" class="btn btn-success mb-2" href="{{ route('estadogastos.expenseStatement') }}"><i class="mdi mdi-file-excel"></i> <b>Exportar excel</b></a>
                            <button class="btn btn-light mb-2 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Plantilla
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <button class="dropdown-item" data-toggle="modal" data-target="#register-template-modal">Registrar</button>
                                <button class="dropdown-item" data-toggle="modal" data-target="#information-template-modal">Editar</button>
                                <button class="dropdown-item" data-toggle="modal" data-target="#delete-template-modal">Eliminar</button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive-sm">
                        <table id="expenses-datatable" class="table table-centered table-striped table-hover table-striped dt-responsive nowrap w-100 dataTable no-footer dtr-inline">
                            <thead>
                                <tr>
                                    <th width="10%">CÓDIGO</th>
                                    <th width="10%">Factura</th>
                                    <th width="10%">Tipo de gasto</th>
                                    <th width="10%">Descripción</th>
                                    <th width="10%">Neto</th>
                                    <th width="10%">Vat</th>
                                    <th width="10%">Retención</th>
                                    <th width="10%">Otros</th>
                                    <th width="10%">Total</th>
                                    <th>Status</th>
                                    <th>Descripción de gasto</th>
                                    <th width="10%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            	@foreach($expenses as $key => $expense)
                                <tr>
                                    <td>{{ $expense->controlcode }}</td>
                                    <td>{{ $expense->facturaLimit }}</td>
                                    <td>{{ $expense->expense_type }}</td>
                                    <td>{{ $expense->description }}</td>
                                    <td>{{ $expense->currency == "USD" ? '$ ' : '' }}{{ number_format($expense->neto, 2, '.', ',') }}</td>
                                    <td>{{ $expense->currency == "USD" ? '$ ' : '' }}{{ number_format($expense->vat, 2, '.', ',') }}</td>
                                    <td class="text-danger">{{ $expense->currency == "USD" ? '$ ' : '' }}- {{ number_format($expense->retention, 2, '.', ',') }}</td>
                                    <td>{{ $expense->currency == "USD" ? '$ ' : '' }}{{ number_format($expense->others, 2, '.', ',') }}</td>
                                    <td>{{ $expense->currency == "USD" ? '$ ' : '' }}{{ $expense->total }}</td>
                                    <td>{{ $expense->present()->statusBadge() }}</td>
                                    <td>{{ $expense->expense_description }}</td>
                                    <td>
                                        <a href="{{ route('estadogastos.pdf', $expense->id )}}" class="action-icon" data-toggle="tooltip" data-placement="top" title data-original-title="Ver pdf"> <i class="mdi mdi-file-pdf"></i></a>
                                        @if(!$expense->canceled_at)
                                            <a  href="javascript:void(0)" class="action-icon"
                                                data-toggle="tooltip" data-placemente="top" data-original-title="Editar información"
                                                onclick="information_expense_modal({{ $expense->id }});"><i class="mdi mdi-square-edit-outline"></i></a>
                                            <a  href="javascript:void(0)" class="action-icon"
                                            data-toggle="tooltip" data-placemente="top" data-original-title="Cancelar gasto"
                                            onclick="cancel_expense({{ $expense->id }});"><i class="mdi mdi-close-box-outline"></i></a>
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
    <div id="register-expense-modal" class="modal fade" tabindex="" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Registro de gasto</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="register-expense-form" method="POST" action="{{ route('estadogastos.store') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Plantilla</label>
                                    <select type="text" class="form-control select2" data-toggle="select2" onchange="buscar_datos_plantilla(value);">
                                        <option value="">Sin plantilla</option>
                                        @foreach($templates as $template)
                                            <option value="{{ $template->id }}">{{ $template->template_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-8"></div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Invoice</label>
                                    <input type="text" class="form-control {{ $errors->has('invoice') ? ' is-invalid' : '' }}" name="invoice">
                                    @if ($errors->has('invoice'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('invoice') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
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
                                    <label>Payment month</label>
                                    <input type="date" class="form-control {{ $errors->has('payment_month') ? ' is-invalid' : '' }}" name="payment_month">
                                    @if ($errors->has('payment_month'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('payment_month') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Expense type <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control {{ $errors->has('expense_type') ? ' is-invalid' : '' }}" name="expense_type">
                                    @if ($errors->has('expense_type'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('expense_type') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Description <span class="text-danger">*</span></label>
                                    <select class="form-control select2{{ $errors->has('description') ? ' is-invalid' : '' }}" data-toggle="select2" name="description">
                                        <option value="">Selecciona...</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service->servicio }}">{{ $service->servicio }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Expense description <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " name="expense_description" value="INVOICE">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Payment source <span class="text-danger">*</span></label>
                                    <select class="form-control select2" data-toggle="select2" name="payment_source">
                                        <option value="C.A.">C.A.</option>
                                        <option value="D.C.">D.C.</option>
                                        <option value="P.A.">P.A.</option>
                                        <option value="JULIA P.A.">JULIA P.A.</option>
                                        <option value="DIEGO P.A.">DIEGO P.A.</option>
                                        <option value="DINORAH P.A.">DINORAH P.A.</option>
                                        <option value="KAREN P.A.">KAREN P.A.</option>
                                        <option value="EDITH P.A.">EDITH P.A.</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Payment Status</label>
                                    <input type="text" class="form-control " name="payment_status">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Solicitado por</label>
                                    <select name="solicited_by" class="form-control select2" data-toggle="select2">
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Moneda</label>
                                    <select name="currency" class="form-control select2" data-toggle="select2">
                                        <option value="MXN">MXN</option>
                                        <option value="USD">USD</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Purpose - Provider</label>
                                    <input type="text" class="form-control " name="purpose_provider">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Notas</label>
                                    <textarea class="form-control " name="notes"></textarea>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Neto <span class="text-danger">*</span></label>
                                    <input type="number" step="any" class="form-control {{ $errors->has('neto') ? ' is-invalid' : '' }}" name="neto" onchange="calcularTotal()">
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
                            <hr>
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

    <div id="register-template-modal" class="modal fade" tabindex="" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Registro de plantilla</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="register-template-form" method="POST" action="{{ route('estadogastos.templateStore') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Nombre de plantilla <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " name="template_name" required>
                                </div>
                            </div>
                            <div class="col-6"></div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Invoice</label>
                                    <input type="text" class="form-control {{ $errors->has('invoice') ? ' is-invalid' : '' }}" name="invoice">
                                    @if ($errors->has('invoice'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('invoice') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
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
                                    <label>Payment month</label>
                                    <input type="date" class="form-control {{ $errors->has('payment_month') ? ' is-invalid' : '' }}" name="payment_month">
                                    @if ($errors->has('payment_month'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('payment_month') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Expense type</label>
                                    <input type="text" class="form-control {{ $errors->has('expense_type') ? ' is-invalid' : '' }}" name="expense_type">
                                    @if ($errors->has('expense_type'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('expense_type') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Description</label>
                                    <select class="form-control select2{{ $errors->has('description') ? ' is-invalid' : '' }}" data-toggle="select2" name="description">
                                        <option value="">Selecciona...</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service->servicio }}">{{ $service->servicio }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Expense description</label>
                                    <input type="text" class="form-control " name="expense_description" value="INVOICE">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Payment source <span class="text-danger">*</span></label>
                                    <select class="form-control select2" data-toggle="select2" name="payment_source">
                                        <option value="C.A.">C.A.</option>
                                        <option value="D.C.">D.C.</option>
                                        <option value="P.A.">P.A.</option>
                                        <option value="JULIA P.A.">JULIA P.A.</option>
                                        <option value="DIEGO P.A.">DIEGO P.A.</option>
                                        <option value="DINORAH P.A.">DINORAH P.A.</option>
                                        <option value="KAREN P.A.">KAREN P.A.</option>
                                        <option value="EDITH P.A.">EDITH P.A.</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Payment Status</label>
                                    <input type="text" class="form-control " name="payment_status">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Solicitado por</label>
                                    <select name="solicited_by" class="form-control select2" data-toggle="select2">
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Moneda</label>
                                    <select name="currency" class="form-control select2" data-toggle="select2">
                                        <option value="MXN">MXN</option>
                                        <option value="USD">USD</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Purpose - Provider</label>
                                    <input type="text" class="form-control " name="purpose_provider">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Notas</label>
                                    <textarea class="form-control " name="notes"></textarea>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Neto</label>
                                    <input type="number" step="any" class="form-control {{ $errors->has('neto') ? ' is-invalid' : '' }}" name="neto" onchange="calcularTotal()">
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
                    <button type="submit" class="btn btn-primary"><b>Registrar</b></button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div id="information-template-modal" class="modal fade" tabindex="" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Información de plantilla</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="information-template-form" method="POST" action="{{ route('estadogastos.templateUpdate') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        <input type="hidden" name="expense_id">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Plantilla</label>
                                    <select type="text" class="form-control select2" data-toggle="select2" onchange="buscar_datos_plantilla(value);">
                                        <option value="">Sin plantilla</option>
                                        @foreach($templates as $template)
                                            <option value="{{ $template->id }}">{{ $template->template_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-8"></div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Invoice</label>
                                    <input type="text" class="form-control {{ $errors->has('invoice') ? ' is-invalid' : '' }}" name="invoice">
                                    @if ($errors->has('invoice'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('invoice') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
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
                                    <label>Payment month</label>
                                    <input type="date" class="form-control {{ $errors->has('payment_month') ? ' is-invalid' : '' }}" name="payment_month">
                                    @if ($errors->has('payment_month'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('payment_month') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Expense type <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control {{ $errors->has('expense_type') ? ' is-invalid' : '' }}" name="expense_type">
                                    @if ($errors->has('expense_type'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('expense_type') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Description <span class="text-danger">*</span></label>
                                    <select class="form-control select2{{ $errors->has('description') ? ' is-invalid' : '' }}" data-toggle="select2" name="description">
                                        <option value="">Selecciona...</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service->servicio }}">{{ $service->servicio }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Expense description <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " name="expense_description" value="INVOICE">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Payment source <span class="text-danger">*</span></label>
                                    <select class="form-control select2" data-toggle="select2" name="payment_source">
                                        <option value="C.A.">C.A.</option>
                                        <option value="D.C.">D.C.</option>
                                        <option value="P.A.">P.A.</option>
                                        <option value="JULIA P.A.">JULIA P.A.</option>
                                        <option value="DIEGO P.A.">DIEGO P.A.</option>
                                        <option value="DINORAH P.A.">DINORAH P.A.</option>
                                        <option value="KAREN P.A.">KAREN P.A.</option>
                                        <option value="EDITH P.A.">EDITH P.A.</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Payment Status</label>
                                    <input type="text" class="form-control " name="payment_status">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Solicitado por</label>
                                    <select name="solicited_by" class="form-control select2" data-toggle="select2">
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Moneda</label>
                                    <select name="currency" class="form-control select2" data-toggle="select2">
                                        <option value="MXN">MXN</option>
                                        <option value="USD">USD</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Purpose - Provider</label>
                                    <input type="text" class="form-control " name="purpose_provider">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Notas</label>
                                    <textarea class="form-control " name="notes"></textarea>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Neto <span class="text-danger">*</span></label>
                                    <input type="number" step="any" class="form-control {{ $errors->has('neto') ? ' is-invalid' : '' }}" name="neto" onchange="calcularTotal()">
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
                            <hr>
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

    <div id="delete-template-modal" class="modal fade" tabindex="" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-warning h1 text-danger"></i>
                        <h4 class="mt-2">Precaución!</h4>
                        <form id="delete_template_form" style="display: inline;" action="{{ route('estadogastos.templateDelete') }}" method="POST">
                            {!! csrf_field() !!}
                            {!! method_field('DELETE') !!}
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Plantilla</label>
                                    <select type="text" class="form-control " name="expense_id">
                                        <option value="">Sin plantilla</option>
                                        @foreach($templates as $template)
                                            <option value="{{ $template->id }}">{{ $template->template_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <button type="button" class="btn btn-light my-2" data-dismiss="modal">Cancelar</button>
                            <button type="sumbit" class="btn btn-danger my-2"><b>Eliminar</b></button>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="information-expense-modal" class="modal fade" tabindex="" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Registro de gasto</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="information-expense-form" method="POST" action="{{ route('estadogastos.modificar') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        <input type="hidden" name="expense_id">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Invoice</label>
                                    <input type="text" class="form-control {{ $errors->has('invoice') ? ' is-invalid' : '' }}" name="invoice">
                                    @if ($errors->has('invoice'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('invoice') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
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
                                    <label>Payment month</label>
                                    <input type="date" class="form-control {{ $errors->has('payment_month') ? ' is-invalid' : '' }}" name="payment_month">
                                    @if ($errors->has('payment_month'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('payment_month') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Expense type <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control {{ $errors->has('expense_type') ? ' is-invalid' : '' }}" name="expense_type">
                                    @if ($errors->has('expense_type'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('expense_type') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Description <span class="text-danger">*</span></label>
                                    <select class="form-control select2{{ $errors->has('description') ? ' is-invalid' : '' }}" data-toggle="select2" name="description">
                                        <option value="">Selecciona...</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service->servicio }}">{{ $service->servicio }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Expense description <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " name="expense_description" value="INVOICE">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Payment source <span class="text-danger">*</span></label>
                                    <select class="form-control select2" data-toggle="select2" name="payment_source">
                                        <option value="C.A.">C.A.</option>
                                        <option value="D.C.">D.C.</option>
                                        <option value="P.A.">P.A.</option>
                                        <option value="JULIA P.A.">JULIA P.A.</option>
                                        <option value="DIEGO P.A.">DIEGO P.A.</option>
                                        <option value="DINORAH P.A.">DINORAH P.A.</option>
                                        <option value="KAREN P.A.">KAREN P.A.</option>
                                        <option value="EDITH P.A.">EDITH P.A.</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Payment Status</label>
                                    <input type="text" class="form-control " name="payment_status">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Solicitado por</label>
                                    <select name="solicited_by" class="form-control select2" data-toggle="select2">
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Moneda</label>
                                    <select name="currency" class="form-control select2" data-toggle="select2">
                                        <option value="MXN">MXN</option>
                                        <option value="USD">USD</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Purpose - Provider</label>
                                    <input type="text" class="form-control " name="purpose_provider">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Notas</label>
                                    <textarea class="form-control " name="notes"></textarea>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Neto <span class="text-danger">*</span></label>
                                    <input type="number" step="any" class="form-control {{ $errors->has('neto') ? ' is-invalid' : '' }}" name="neto" onchange="calcularTotalInformation()">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Vat</label>
                                    <input type="number" step="any" class="form-control {{ $errors->has('vat') ? ' is-invalid' : '' }}" name="vat" value="0" onchange="calcularTotalInformation()">
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
                                    <input type="number" step="any" class="form-control {{ $errors->has('retention') ? ' is-invalid' : '' }}" name="retention" value="0" onchange="calcularTotalInformation()">
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
                                    <input type="number" step="any" class="form-control {{ $errors->has('others') ? ' is-invalid' : '' }}" name="others" value="0" onchange="calcularTotalInformation()">
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
                            <hr>
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

    <div id="cancel-expense-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-warning h1 text-danger"></i>
                        <h4 class="mt-2">Precaución!</h4>
                        <p class="mt-3">¿Está seguro(a) de cancelar el gasto?</p>
                        <button type="button" class="btn btn-light my-2" data-dismiss="modal">Cancelar</button>
                        <form id="cancel_expense_form" style="display: inline;" action="{{ route('estadogastos.cancel') }}" method="POST">
                            {!! csrf_field() !!}
                            {!! method_field('DELETE') !!}
                            <input type="hidden" name="expense_id">
                            <button type="sumbit" class="btn btn-danger my-2"><b>Aplicar</b></button>
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
            $("#expenses-datatable").DataTable({
                language: idioma_espanol,
                pageLength: 25,
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

        function information_expense_modal($id){
            var url = '/estadogastos/buscar/' + $id;
            axios.get(url).then(function(response) {
                console.log(response.data);
                $('#information-expense-form input[name=expense_id]').val($id);
                $('#information-expense-form input[name=invoice]').val(response.data.invoice);
                $('#information-expense-form input[name=invoice_date]').val(response.data.invoice_date);
                $('#information-expense-form input[name=payment_month]').val(response.data.payment_month);
                $('#information-expense-form input[name=expense_type]').val(response.data.expense_type);
                $('#information-expense-form select[name=description]').val(response.data.description).change();
                $('#information-expense-form input[name=expense_description]').val(response.data.expense_description);
                $('#information-expense-form select[name=payment_source]').val(response.data.payment_source).change();
                $('#information-expense-form input[name=payment_status]').val(response.data.payment_status);
                $('#information-expense-form select[name=solicited_by]').val(response.data.solicited_by).change();
                $('#information-expense-form select[name=currency]').val(response.data.currency).change();
                $('#information-expense-form input[name=purpose_provider]').val(response.data.purpose_provider);
                $('#information-expense-form textarea[name=notes]').val(response.data.notes);
                $('#information-expense-form input[name=neto]').val(response.data.neto);
                $('#information-expense-form input[name=vat]').val(response.data.vat);
                $('#information-expense-form input[name=retention]').val(response.data.retention);
                $('#information-expense-form input[name=others]').val(response.data.others);
                calcularTotalInformation();
                $('#information-expense-modal').modal('show');
            }).catch(function(error) {
                console.log(response.error);
            })
        }

        function calcularTotalInformation()
        {
            var neto = $('#information-expense-form input[name=neto]').val();
            var vat = $('#information-expense-form input[name=vat]').val();
            var retention = $('#information-expense-form input[name=retention]').val();
            var others = $('#information-expense-form input[name=others]').val();
            var total = (parseFloat(neto) + parseFloat(vat) + parseFloat(others)) - parseFloat(retention);
            $('#information-expense-form input[name=total]').val(parseFloat(total).toFixed(2));
        }

        function calcularTotal()
        {
            var neto = $('#register-expense-form input[name=neto]').val();
            var vat = $('#register-expense-form input[name=vat]').val();
            var retention = $('#register-expense-form input[name=retention]').val();
            var others = $('#register-expense-form input[name=others]').val();
            var total = (parseFloat(neto) + parseFloat(vat) + parseFloat(others)) - parseFloat(retention);
            $('#register-expense-form input[name=total]').val(parseFloat(total).toFixed(2));

            var neto = $('#register-template-form input[name=neto]').val();
            var vat = $('#register-template-form input[name=vat]').val();
            var retention = $('#register-template-form input[name=retention]').val();
            var others = $('#register-template-form input[name=others]').val();
            var total = (parseFloat(neto) + parseFloat(vat) + parseFloat(others)) - parseFloat(retention);
            $('#register-template-form input[name=total]').val(parseFloat(total).toFixed(2));
        }

        function buscar_datos_plantilla($id)
        {
            var url = '/estadogastos/buscar/' + $id;
            axios.get(url).then(function(response) {
                console.log(response.data);
                $('#register-expense-form input[name=expense_id]').val($id);
                $('#register-expense-form input[name=invoice]').val(response.data.invoice);
                $('#register-expense-form input[name=invoice_date]').val(response.data.invoice_date);
                $('#register-expense-form input[name=payment_month]').val(response.data.payment_month);
                $('#register-expense-form input[name=expense_type]').val(response.data.expense_type);
                $('#register-expense-form select[name=description]').val(response.data.description).change();
                $('#register-expense-form input[name=expense_description]').val(response.data.expense_description);
                $('#register-expense-form select[name=payment_source]').val(response.data.payment_source).change();
                $('#register-expense-form input[name=payment_status]').val(response.data.payment_status);
                $('#register-expense-form select[name=solicited_by]').val(response.data.solicited_by).change();
                $('#register-expense-form select[name=currency]').val(response.data.currency).change();
                $('#register-expense-form input[name=purpose_provider]').val(response.data.purpose_provider);
                $('#register-expense-form textarea[name=notes]').val(response.data.notes);
                $('#register-expense-form input[name=neto]').val(response.data.neto);
                $('#register-expense-form input[name=vat]').val(response.data.vat);
                $('#register-expense-form input[name=retention]').val(response.data.retention);
                $('#register-expense-form input[name=others]').val(response.data.others);
                calcularTotalInformation();
                $('#information-template-form input[name=expense_id]').val($id);
                $('#information-template-form input[name=invoice]').val(response.data.invoice);
                $('#information-template-form input[name=invoice_date]').val(response.data.invoice_date);
                $('#information-template-form input[name=payment_month]').val(response.data.payment_month);
                $('#information-template-form input[name=expense_type]').val(response.data.expense_type);
                $('#information-template-form select[name=description]').val(response.data.description).change();
                $('#information-template-form input[name=expense_description]').val(response.data.expense_description);
                $('#information-template-form select[name=payment_source]').val(response.data.payment_source).change();
                $('#information-template-form input[name=payment_status]').val(response.data.payment_status);
                $('#information-template-form select[name=solicited_by]').val(response.data.solicited_by).change();
                $('#information-template-form select[name=currency]').val(response.data.currency).change();
                $('#information-template-form input[name=purpose_provider]').val(response.data.purpose_provider);
                $('#information-template-form textarea[name=notes]').val(response.data.notes);
                $('#information-template-form input[name=neto]').val(response.data.neto);
                $('#information-template-form input[name=vat]').val(response.data.vat);
                $('#information-template-form input[name=retention]').val(response.data.retention);
                $('#information-template-form input[name=others]').val(response.data.others);
                calcularTotalInformation();
            }).catch(function(error) {
                console.log(response.error);
            })
        }

        function cancel_expense($id)
        {
            $('#cancel_expense_form input[name=expense_id]').val($id);
            $('#cancel-expense-modal').modal('show');
        }

        @if($errors->any())
            $('#register-expense-modal').modal('show');
        @endif
    </script>
@endsection
