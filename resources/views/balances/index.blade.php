@extends('layouts.hyper')

@section('title', 'Finanzas | Balances')

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
                        <li class="breadcrumb-item active">Balances</li>
                    </ol>
                </div>
                <h4 class="page-title">Balances</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table id="balances-datatable" class="table table-centered table-striped table-hover table-striped dt-responsive nowrap w-100 dataTable no-footer dtr-inline">
                            <thead>
                                <tr>
                                    <th width="4%">#</th>
                                    <th>Fecha</th>
                                    <th>MXN</th>
                                    <th>USD</th>
                                    <th>DEBIT</th>
                                    <th width="8%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            	@foreach($balances as $key => $balance)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $balance->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $balance->mxn }}</td>
                                    <td>$ {{ $balance->usd }}</td>
                                    <td>{{ $balance->debit }}</td>
                                    <td>
                                        <a  href="javascript:void(0)" class="action-icon"
                                            data-toggle="tooltip" data-placemente="top" data-original-title="Editar información"
                                            onclick="information_balance_modal({{ $balance->id }});"><i class="mdi mdi-square-edit-outline"></i></a>
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
    <div id="information-balance-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Información de balance</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="information-balance-form" method="POST" action="{{ route('balances.update') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        <input type="hidden" name="balance_id">
                        <div class="row">
                             <div class="col-3">
                                <div class="form-group">
                                    <label>Fecha<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " required name="created_at" disabled>
                                </div>
                            </div>
                            <div class="col-9"></div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>MXN <span class="text-danger">*</span></label>
                                    <input type="number" step="any" class="form-control " name="mxn" value="0">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>USD</label>
                                    <input type="number" step="any" class="form-control " name="usd" value="0">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>DEBIT</label>
                                    <input type="number" step="any" class="form-control " name="debit" value="0">
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
            $("#balances-datatable").DataTable({
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

        function information_balance_modal($id){
            var url = '/balances/buscar/' + $id;
            axios.get(url).then(function(response) {
                console.log(response.data);
                $('#information-balance-form input[name=balance_id]').val($id);
                $('#information-balance-form input[name=created_at]').val(response.data.created_at);
                $('#information-balance-form input[name=mxn]').val(response.data.mxn);
                $('#information-balance-form input[name=usd]').val(response.data.usd);
                $('#information-balance-form input[name=debit]').val(response.data.debit);
                $('#information-balance-modal').modal('show');
            }).catch(function(error) {
                console.log(response.error);
            })
        }
    </script>
@endsection
