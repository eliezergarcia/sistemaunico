@extends('layouts.hyper')

@section('title', 'Control de operaciones | Operaciones')

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
                        <li class="breadcrumb-item">Control de operaciones</li>
                        <li class="breadcrumb-item active">Operaciones</li>
                    </ol>
                </div>
                <h4 class="page-title">Operaciones</h4>
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
                            <button id="btnModal" class="btn btn-primary mb-2" data-toggle="modal" data-target="#register-operation-modal"><i class="mdi mdi-plus-circle mr-2"></i> <b>Registrar operación</b></button>
                        </div>
                        <div class="col-sm-2 form-group form-inline">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label for="">Mostrar &nbsp;</label>
                            <select name="filtro-datatables" id="filtro-datatables" class="form-control">
                                <option value="IMPO">Impo</option>
                                <option value="EXPO">Expo</option>
                                <option value="Todo" selected>Todos</option>
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive-sm">
                        <table id="operations-datatable" class="table table-centered dt-responsive nowrap w-100 dataTable no-footer dtr-inline">
                            <thead class="thead-light">
                                <tr>
                                    <th width="4%">#</th>
                                    @if(Auth::user()->present()->isAdmin())
                                        <th>Operador</th>
                                    @endif
                                    <th>Master consignee</th>
                                    <th>House consignee</th>
                                    <th width="8%">ETA</th>
                                    <th>POD</th>
                                    <th>Destino</th>
                                    <th>M B/L</th>
                                    <th width="7%">Tipo</th>
                                    <th width="7%">QTY</th>
                                    <th width="8%">Status</th>
                                    <th width="7%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($operations as $key => $operation)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        @if(Auth::user()->present()->isAdmin())
                                            <td>{{ $operation->user->name }}</td>
                                        @endif
                                        <td>{{ $operation->master->codigo_cliente }}</td>
                                        <td>{{ $operation->house->codigo_cliente }}</td>
                                        <td>{{ $operation->eta }}</td>
                                        <td>{{ $operation->pod }}</td>
                                        <td>{{ $operation->destino }}</td>
                                        <td>{{ $operation->m_bl }}</td>
                                        <td>{{ $operation->impo_expo }}</td>
                                        <td>{{ count($operation->containers) }}</td>
                                        <td>
                                            @if($operation->impo_expo == "IMPO")
                                                {{ $operation->present()->statusBadgeImpo() }}
                                            @else
                                                {{ $operation->present()->statusBadgeExpo() }}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('operaciones.show', $operation->id )}}" class="action-icon btn btn-link" data-toggle="tooltip" data-placement="top" title data-original-title="Ver información"> <i class="mdi mdi-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="thead-light">
                                <tr>
                                    <th></th>
                                    @if(Auth::user()->present()->isAdmin())
                                        <th>Operador</th>
                                    @endif
                                    <th>Master consignee</th>
                                    <th>House consignee</th>
                                    <th>ETA</th>
                                    <th>POD</th>
                                    <th>Destino</th>
                                    <th>M B/L</th>
                                    <th>Tipo</th>
                                    <th>QTY</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->
</div> <!-- container -->

<!-- Start Modals -->
    <div id="register-operation-modal" class="modal fade" tabindex="" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Registro de operación</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('operaciones.store') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        <div id="container-nodes" class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Shipper <span class="text-danger">*</span></label>
                                    <select name="shipper" id="shipper" class="form-control select2" data-toggle="select2">
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->codigo_cliente }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('shipper'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('shipper') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Master consignee <span class="text-danger">*</span></label>
                                    <select class="form-control select2" name="master_consignee" id="master_consignee" data-toggle="select2">
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->codigo_cliente }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('master_consignee'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('master_consignee') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>House consignee <span class="text-danger">*</span></label>
                                    <select class="form-control select2" name="house_consignee" id="house_consignee" data-toggle="select2">
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->codigo_cliente }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('house_consignee'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('house_consignee') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>ETD <span class="text-danger">*</span></label>
                                    {{-- <input class="form-control {{ $errors->has('etd') ? ' is-invalid' : '' }}" type="date" name="etd" value="{{ old('etd') }}"> --}}
                                    <input type="text" name="etd" class="form-control date {{ $errors->has('etd') ? ' is-invalid' : '' }}" id="birthdatepicker" data-toggle="date-picker" data-single-date-picker="true" value="{{ old('etd') }}">
                                    @if ($errors->has('etd'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('etd') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>ETA <span class="text-danger">*</span></label>
                                    {{-- <input class="form-control {{ $errors->has('eta') ? ' is-invalid' : '' }}" type="date" name="eta" value="{{ old('eta') }}"> --}}
                                    <input type="text" name="eta" class="form-control date {{ $errors->has('eta') ? ' is-invalid' : '' }}" id="birthdatepicker" data-toggle="date-picker" data-single-date-picker="true" value="{{ old('eta') }}">
                                    @if ($errors->has('eta'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('eta') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>IMPO/EXPO <span class="text-danger">*</span></label>
                                    <select type="text" class="form-control select2s{{ $errors->has('impo_expo') ? ' is-invalid' : '' }}" value="{{ old('impo_expo') }}"  name="impo_expo" id="impo_expo" data-toggle="select2">
                                        <option value="IMPO">IMPO</option>
                                        <option value="EXPO">EXPO</option>
                                    </select>
                                    @if ($errors->has('impo_expo'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('impo_expo') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>POL <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control {{ $errors->has('pol') ? ' is-invalid' : '' }}" value="{{ old('pol') }}"  name="pol">
                                    @if ($errors->has('pol'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('pol') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>POD <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control {{ $errors->has('pod') ? ' is-invalid' : '' }}" value="{{ old('pod') }}"  name="pod">
                                    @if ($errors->has('pod'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('pod') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Destino <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control {{ $errors->has('destino') ? ' is-invalid' : '' }}" value="{{ old('destino') }}"  name="destino">
                                    @if ($errors->has('destino'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('destino') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Incoterm <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control {{ $errors->has('incoterm') ? ' is-invalid' : '' }}" value="{{ old('incoterm') }}"  name="incoterm">
                                    @if ($errors->has('incoterm'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('incoterm') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Booking #</label>
                                    <input type="text" class="form-control {{ $errors->has('booking') ? ' is-invalid' : '' }}" value="{{ old('booking') }}"  name="booking">
                                    @if ($errors->has('booking'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('booking') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Custom cutoff</label>
                                    <input type="date" class="form-control {{ $errors->has('custom_cutoff') ? ' is-invalid' : '' }}" value="{{ old('custom_cutoff') }}" name="custom_cutoff">
                                    {{-- <input type="text" name="custom_cutoff" class="form-control date {{ $errors->has('custom_cutoff') ? ' is-invalid' : '' }}" id="birthdatepicker" data-toggle="date-picker" data-single-date-picker="true" value="{{ old('custom_cutoff') }}"> --}}
                                    @if ($errors->has('custom_cutoff'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('custom_cutoff') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Vessel <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control {{ $errors->has('vessel') ? ' is-invalid' : '' }}" value="{{ old('vessel') }}"  name="vessel">
                                    @if ($errors->has('vessel'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('vessel') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>O/F</label>
                                    <input type="text" class="form-control {{ $errors->has('o_f') ? ' is-invalid' : '' }}" value="{{ old('o_f') }}"  name="o_f">
                                    @if ($errors->has('o_f'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('o_f') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>AA <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control {{ $errors->has('aa') ? ' is-invalid' : '' }}" value="{{ old('aa') }}"  name="aa">
                                    @if ($errors->has('aa'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('aa') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>M B/L <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control {{ $errors->has('m_bl') ? ' is-invalid' : '' }}" value="{{ old('m_bl') }}"  name="m_bl">
                                    @if ($errors->has('m_bl'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('m_bl') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <div class="col-8">
                            </div>
                            <div id="inputs1" class="col-12">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>C. Invoice <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control {{ $errors->has('c_invoice') ? ' is-invalid' : '' }}" name="c_invoice[]" required>
                                            @if ($errors->has('c_invoice'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('c_invoice') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>H B/L <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control {{ $errors->has('h_bl') ? ' is-invalid' : '' }}" name="h_bl[]" required>
                                            @if ($errors->has('h_bl'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('h_bl') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button id="add-inputs" type="button" class="btn btn-icon btn-success mt-3"><i class="mdi mdi-plus-circle"></i></button>
                                        </div>
                                    </div>
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

            var table = $("#operations-datatable").DataTable({
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

            $('#operations-datatable tfoot th:not(:first-child):not(:last-child)').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" class="form-control" placeholder="'+title+'"/>' );
            })

             table.columns().every( function () {
                var that = this;

                $( 'input', this.footer() ).on( 'keyup change', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                });
            });

            $("#filtro-datatables").on("change", function(){
                var val = $("#filtro-datatables").val();

                if(val == "IMPO"){
                    table.search( val ).draw();
                }else if(val == "EXPO"){
                    table.search( val ).draw();
                }else if(val == "Todo"){
                    table.search( "" ).draw();
                }
            })
            table.search( "" ).draw();
        });

        $("#add-inputs").on("click", function(){
            $("#container-nodes").append('<div id="inputs2" class="col-12"><div class="row"><div class="col-4"><div class="form-group"><label>C. Invoice</label><input type="text" class="form-control {{ $errors->has('c_invoice') ? ' is-invalid' : '' }}" value="" name="c_invoice[]">@if ($errors->has('c_invoice'))<span class="invalid-feedback" role="alert"><strong>{{ $errors->first('c_invoice') }}</strong></span>@endif</div></div><div class="col-4"><div class="form-group"><label>H B/L</label><input type="text" class="form-control {{ $errors->has('h_bl') ? ' is-invalid' : '' }}" value=""  name="h_bl[]">@if ($errors->has('h_bl'))<span class="invalid-feedback" role="alert"><strong>{{ $errors->first('h_bl') }}</strong></span>@endif</div></div><div class="col-4"><div class="form-group"><label>&nbsp;</label><button onclick="delete_inputs();" type="button" class="btn btn-icon btn-danger mt-3"><i class="mdi mdi-minus-circle"></i></button></div></div></div></div>');
        })

        function delete_inputs(){
            var parent = document.getElementById("container-nodes");
            var child = document.getElementById("inputs2");
            parent.removeChild(child);
        }

        @if($errors->any())
            $('#register-operation-modal').modal('show');
        @endif
    </script>
@endsection