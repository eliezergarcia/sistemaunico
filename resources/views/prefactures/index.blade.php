@extends('layouts.hyper')

@section('title', 'Sistema | Prefacturas')

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
                        <li class="breadcrumb-item active">Prefacturas</li>
                    </ol>
                </div>
                <h4 class="page-title">Prefacturas</h4>
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
                        <table id="prefacturas-datatable" class="table table-centered dt-responsive nowrap w-100 dataTable no-footer dtr-inline">
                            <thead class="thead-light">
                                <tr>
                                    <th width="4%">#</th>
                                    @if(Auth::user()->present()->isAdmin() || Auth::user()->present()->isFac())
                                        <th width="12%">Operador</th>
                                    @endif
                                    <th width="12%">Cód. control</th>
                                    <th>Cliente</th>
                                    <th>M B/L</th>
                                    <th>H B/L</th>
                                    <th width="9%">Status</th>
                                    <th width="7%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($prefacturas as $key => $prefactura)
                                	@if(Auth::user()->id == $prefactura->operation->user->id || Auth::user()->present()->isAdmin() || Auth::user()->present()->isFac())
	                                    <tr>
                                            <td>{{ $key + 1 }}</td>
	                                        @if(Auth::user()->present()->isAdmin() || Auth::user()->present()->isFac())
	                                        <td>{{ $prefactura->operation->user->name }}</td>
	                                        @endif
											<td>{{ $prefactura->numberformat }}</td>
											<td>{{ $prefactura->client->razon_social }}</td>
                                            <td>{{ $prefactura->operation->m_bl }}</td>
                                            <td>{{ $prefactura->operation->h_bl }}</td>
                                            <td>{{ $prefactura->present()->statusBadge() }}</td>
	                                        <td>
	                                            <a href="{{ route('operations.prefacture', $prefactura->id )}}" class="action-icon btn btn-link" data-toggle="tooltip" data-placement="top" title data-original-title="Ver información"> <i class="mdi mdi-eye"></i></a>
                                                @if(!$prefactura->canceled_at)
                                                    @if($prefactura->invoices->isEmpty())
                                                        <a href="#" onclick="register_invoice_modal({{ $prefactura->id }})" class="action-icon btn btn-link" data-toggle="tooltip" data-placement="top" title data-original-title="Ingresar información de factura"> <i class="mdi mdi-file-plus"></i></a>
                                                    @endif
                                                    <a href="javascript:void(0)" class="action-icon btn btn-link"
                                                    data-toggle="tooltip" data-placemente="top" data-original-title="Cancelar prefactura"
                                                    onclick="cancel_prefactura({{ $prefactura->id }});"><i class="mdi mdi-close-box-outline"></i></a>
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
                            <input type="hidden" name="prefacture_id" value="">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Factura <span class="text-danger">*</span></label>
                                    <input class="form-control {{ $errors->has('factura') ? ' is-invalid' : '' }}" type="text" name="factura" value="{{ old('factura') }}">
                                    @if ($errors->has('factura'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('factura') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Fecha factura <span class="text-danger">*</span></label>
                                    <input class="form-control {{ $errors->has('fecha_factura') ? ' is-invalid' : '' }}" type="date" name="fecha_factura" value="{{ old('fecha_factura') }}">
                                    @if ($errors->has('fecha_factura'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('fecha_factura') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Moneda <span class="text-danger">*</span></label>
                                    <select type="text" class="form-control {{ $errors->has('moneda') ? ' is-invalid' : '' }}" value="{{ old('moneda') }}"  name="moneda">
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
                                    <label>Neto <span class="text-danger">*</span></label>
                                    <input class="form-control {{ $errors->has('neto') ? ' is-invalid' : '' }}" type="number" step="any" name="neto" value="{{ old('neto') }}" onchange="calcularTotal()">
                                    @if ($errors->has('neto'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('neto') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Iva <span class="text-danger">*</span></label>
                                    <input class="form-control {{ $errors->has('iva') ? ' is-invalid' : '' }}" type="number" step="any" name="iva" value="{{ old('iva') }}" onchange="calcularTotal()">
                                    @if ($errors->has('iva'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('iva') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Total</label>
                                    <input class="form-control " type="number" step="any" id="total">
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

    <div id="cancel-prefactura-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body p-4">
                        <div class="text-center">
                            <i class="dripicons-warning h1 text-danger"></i>
                            <h4 class="mt-2">Precaución!</h4>
                            <p class="mt-3">¿Está seguro(a) de cancelar la prefactura?</p>
                            <button type="button" class="btn btn-light my-2" data-dismiss="modal">Cancelar</button>
                            <form id="cancel_prefactura_form" style="display: inline;" action="{{ route('prefacture.cancel') }}" method="POST">
                                {!! csrf_field() !!}
                                {!! method_field('DELETE') !!}
                                <input type="hidden" name="prefactura_id">
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
            table = $("#prefacturas-datatable").DataTable({
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
            table.search( "Pendiente" ).draw();
        });

        function register_invoice_modal($id)
        {
            var url = '/prefacturas/buscar/' + $id;
            axios.get(url).then(function(response) {
                console.log(response.data);
                $('#register-invoice-form input[name=prefacture_id]').val($id);
                $('#register-invoice-form input[name=neto]').val(response.data.ratetotal);
                $('#register-invoice-form input[name=iva]').val(response.data.ivatotal);
                var neto = $('#register-invoice-form input[name=neto]').val();
                var iva = $('#register-invoice-form input[name=iva]').val();
                var total = (parseFloat(neto) + parseFloat(iva));
                $('#register-invoice-form #total').val(parseFloat(total).toFixed(2));
                $('#register-invoice-modal').modal('show');
            }).catch(function(error) {
                console.log(response.error);
            })
        }

        function calcularTotal()
        {
            var neto = $('#register-invoice-form input[name=neto]').val();
            var iva = $('#register-invoice-form input[name=iva]').val();
            var total = (parseFloat(neto) + parseFloat(iva));
            $('#register-invoice-form #total').val(parseFloat(total).toFixed(2));
        }

        function cancel_prefactura($id)
        {
            $('#cancel_prefactura_form input[name=prefactura_id]').val($id);
            $('#cancel-prefactura-modal').modal('show');
        }
    </script>
    <script>
        @if($errors->any())
            $('#register-invoice-modal').modal('show');
        @endif
    </script>
@endsection