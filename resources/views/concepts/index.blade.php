@extends('layouts.hyper')

@section('title', 'Administración | Conceptos de cliente')

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
                        <li class="breadcrumb-item">Administración</li>
                        <li class="breadcrumb-item active">Conceptos de cliente</li>
                    </ol>
                </div>
                <h4 class="page-title">Conceptos de cliente</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <button id="btnModal" class="btn btn-primary mb-2" data-toggle="modal" data-target="#register-concept-modal"><i class="mdi mdi-plus-circle mr-2"></i> <b>Registrar concepto</b></button>
                        </div>
                    </div>

                    <div class="table-responsive-sm">
                        <table id="users-datatable" class="table table-centered table-striped table-hover table-striped table-striped dt-responsive nowrap w-100 dataTable no-footer dtr-inline">
                            <thead>
                                <tr>
                                    <th width="4%">#</th>
                                    <th>Descripción</th>
                                    <th>Moneda</th>
                                    <th>Rate</th>
                                    <th width="8%">Estado</th>
                                    <th width="8%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            	@foreach($concepts as $key => $concept)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $concept->description }}</td>
                                    <td>{{ $concept->curr }}</td>
                                    <td>$ {{ $concept->rate }}</td>
                                    <td>{{ $concept->present()->statusBadge() }}</td>
                                    <td>
                                        <a  href="javascript:void(0)" class="action-icon"
                                            data-toggle="tooltip" data-placemente="top" data-original-title="Editar información"
                                            onclick="information_concept_modal({{ $concept->id }});"><i class="mdi mdi-square-edit-outline"></i></a>
                                        @if(!$concept->inactive_at)
                                            <a  href="javascript:void(0)" class="action-icon"
                                            data-toggle="tooltip" data-placemente="top" data-original-title="Desactivar concepto"
                                            onclick="deactivate_concept({{ $concept->id }});"><i class="mdi mdi-close-box-outline"></i></a>
                                        @else
                                            <a  href="javascript:void(0)" class="action-icon"
                                            data-toggle="tooltip" data-placemente="top" data-original-title="Activar concepto"
                                            onclick="activate_concept({{ $concept->id }});"><i class="mdi mdi-checkbox-marked-outline"></i></a>
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
    <div id="register-concept-modal" class="modal fade" tabindex="" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Registro de concepto</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('conceptos.store') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        <div class="row">
                             <div class="col-12">
                                <div class="form-group">
                                    <label>Descripción<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" name="description">
                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Moneda <span class="text-danger">*</span></label>
                                    <select type="text" class="form-control select2{{ $errors->has('curr') ? ' is-invalid' : '' }}" name="curr" data-toggle="select2">
                                        <option value="">Selecciona...</option>
                                        <option value="USD">USD</option>
                                        <option value="EUR">EUR</option>
                                        <option value="MXN">MXN</option>
                                    </select>
                                    @if ($errors->has('curr'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('curr') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Rate</label>
                                    <input type="number" step="any" class="form-control " name="rate" value="0">
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

    <div id="information-concept-modal" class="modal fade" tabindex="" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Información de concepto</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="information-concept-form" method="POST" action="{{ route('conceptos.update') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        <input type="hidden" name="concept_id">
                        <div class="row">
                             <div class="col-12">
                                <div class="form-group">
                                    <label>Descripción<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " required name="description">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Moneda <span class="text-danger">*</span></label>
                                    <select type="text" class="form-control select2" required name="curr" data-toggle="select2">
                                        <option value="USD">USD</option>
                                        <option value="EUR">EUR</option>
                                        <option value="MXN">MXN</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Rate</label>
                                    <input type="number" step="any" class="form-control " name="rate" value="0">
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

    <div id="activate-concept-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-warning h1 text-primary"></i>
                        <h4 class="mt-2">Precaución!</h4>
                        <p class="mt-3">¿Está seguro(a) de activar el concepto?</p>
                        <button type="button" class="btn btn-light my-2" data-dismiss="modal">Cancelar</button>
                        <form id="activate_concept_form" style="display: inline;" action="{{ route('conceptos.activate') }}" method="POST">
                            {!! csrf_field() !!}
                            <input type="hidden" name="concept_id">
                            <button type="sumbit" class="btn btn-primary my-2"><b>Activar</b></button>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="deactivate-concept-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-warning h1 text-danger"></i>
                        <h4 class="mt-2">Precaución!</h4>
                        <p class="mt-3">¿Está seguro(a) de desactivar el concepto?</p>
                        <button type="button" class="btn btn-light my-2" data-dismiss="modal">Cancelar</button>
                        <form id="deactivate_concept_form" style="display: inline;" action="{{ route('conceptos.deactivate') }}" method="POST">
                            {!! csrf_field() !!}
                            {!! method_field('DELETE') !!}
                            <input type="hidden" name="concept_id">
                            <button type="sumbit" class="btn btn-danger my-2"><b>Desactivar</b></button>
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
            $("#users-datatable").DataTable({
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

        function information_concept_modal($id){
            var url = '/conceptos/buscar/' + $id;
            axios.get(url).then(function(response) {
                console.log(response.data);
                $('#information-concept-form input[name=concept_id]').val($id);
                $('#information-concept-form input[name=description]').val(response.data.description);
                $('#information-concept-form select[name=curr]').val(response.data.curr).change();
                $('#information-concept-form input[name=rate]').val(response.data.rate);
                $('#information-concept-modal').modal('show');
            }).catch(function(error) {
                console.log(response.error);
            })
        }

        function activate_concept($id)
        {
            $('#activate_concept_form input[name=concept_id]').val($id);
            $('#activate-concept-modal').modal('show');
        }

        function deactivate_concept($id)
        {
            $('#deactivate_concept_form input[name=concept_id]').val($id);
            $('#deactivate-concept-modal').modal('show');
        }

        @if($errors->any())
            $('#register-concept-modal').modal('show');
        @endif
    </script>
@endsection
