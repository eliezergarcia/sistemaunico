@extends('layouts.hyper')

@section('title', 'Sistema | House B/L')

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
                        <li class="breadcrumb-item">Operaciones</li>
                        <li class="breadcrumb-item active">House B/L</li>
                    </ol>
                </div>
                <h4 class="page-title">House B/L</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table id="housebls-datatable" class="table table-centered dt-responsive nowrap w-100 dataTable no-footer dtr-inline">
                            <thead class="thead-light">
                                <tr>
                                    <th width="4%">#</th>
                                    @if(Auth::user()->present()->isAdmin() || Auth::user()->present()->isFac())
                                    <th width="12%">Operador</th>
                                    @endif
                                    <th width="12%">Cód. control</th>
                                    <th width="">Shipper</th>
                                    <th width="">House consignee</th>
                                    <th width="">M B/L</th>
                                    <th width="">H B/L</th>
                                    <th width="9%">Status</th>
                                    <th width="7%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($housebls as $key => $housebl)
                                	@if(Auth::user()->id == $housebl->operation->user->id || Auth::user()->present()->isAdmin() || Auth::user()->present()->isFac())
	                                    <tr>
                                            <td>{{ $key + 1 }}</td>
	                                        @if(Auth::user()->present()->isAdmin() || Auth::user()->present()->isFac())
	                                           <td>{{ $housebl->operation->user->name }}</td>
	                                        @endif
											<td>{{ $housebl->numberformat }}</td>
											<td>{{ $housebl->operation->ship->codigo_cliente }}</td>
                                            <td>{{ $housebl->operation->house->codigo_cliente }}</td>
                                            <td>{{ $housebl->operation->h_bl }}</td>
											<td>{{ $housebl->operation->h_bl }}</td>
                                            <td>{{ $housebl->present()->statusBadge() }}</td>
	                                        <td>
	                                            <a href="{{ route('housebls.show', $housebl->id )}}" class="action-icon btn btn-link" data-toggle="tooltip" data-placement="top" title data-original-title="Ver información"> <i class="mdi mdi-eye"></i></a>
                                                @if($housebl->invoices->isEmpty())
                                                {{-- <a href="#" onclick="register_invoice_modal({{ $housebl->id }})" class="action-icon btn btn-link" data-toggle="tooltip" data-placement="top" title data-original-title="Ingresar información de factura"> <i class="mdi mdi-file-plus"></i></a> --}}
                                                @endif
	                                        </td>
	                                    </tr>
                                    @endif
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
    <div id="register-invoice-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Registro de factura</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="register-invoice-form" method="POST" action="{{ route('facturas.store') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        <div id="container-nodes" class="row">
                            <input type="hidden" name="housebl_id" value="">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Factura</label>
                                    <input class="form-control form-control-light{{ $errors->has('factura') ? ' is-invalid' : '' }}" type="text" name="factura" value="{{ old('factura') }}">
                                    @if ($errors->has('factura'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('factura') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Fecha factura</label>
                                    <input class="form-control form-control-light{{ $errors->has('fecha_factura') ? ' is-invalid' : '' }}" type="date" name="fecha_factura" value="{{ old('fecha_factura') }}">
                                    @if ($errors->has('fecha_factura'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('fecha_factura') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Moneda</label>
                                    <select type="text" class="form-control form-control-light{{ $errors->has('moneda') ? ' is-invalid' : '' }}" value="{{ old('moneda') }}"  name="moneda">
                                        <option value="MXN">MXN</option>
                                        <option value="USD">USD</option>
                                    </select>
                                    @if ($errors->has('moneda'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('moneda') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Neto</label>
                                    <input class="form-control form-control-light{{ $errors->has('neto') ? ' is-invalid' : '' }}" type="number" step="any" name="neto" value="{{ old('neto') }}">
                                    @if ($errors->has('neto'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('neto') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Fecha de pago</label>
                                    <input class="form-control form-control-light{{ $errors->has('fecha_pago') ? ' is-invalid' : '' }}" type="date" name="fecha_pago" value="{{ old('fecha_pago') }}">
                                    @if ($errors->has('fecha_pago'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('fecha_pago') }}</strong>
                                        </span>
                                    @endif
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
            $("#housebls-datatable").DataTable({
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

        function register_invoice_modal($id)
        {
            console.log($id);
            $('#register-invoice-form input[name=housebl_id]').val($id);
            $('#register-invoice-modal').modal('show');
        }
    </script>
@endsection