@extends('layouts.hyper')

@section('title', 'Sistema | Control de operaciones')

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
                        <li class="breadcrumb-item active">Control de operaciones</li>
                    </ol>
                </div>
                <h4 class="page-title">Control de operaciones</h4>
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
                            <button id="btnModal" class="btn btn-primary mb-2" data-toggle="modal" data-target="#register-operation-modal"><i class="mdi mdi-plus-circle mr-2"></i> <b>Registrar operación</b></button>
                        </div>
                        <!-- <div class="col-sm-8">
                            <div class="text-sm-right">
                                <button type="button" class="btn btn-info mb-2 mr-1"><i class="mdi mdi-settings"></i></button>
                                <button type="button" class="btn btn-light mb-2">Export</button>
                            </div>
                        </div> -->
                    </div>

                    <div class="table-responsive-sm">
                        <table id="operations-datatable" class="table table-centered table-striped dt-responsive nowrap w-100 dataTable no-footer dtr-inline">
                            <thead>
                                <tr>
                                    @if(Auth::user()->isAdmin())
                                    <th>Operador</th>
                                    @endif
                                    <th>Master consigner</th>
                                    <th>House consigner</th>
                                    <th>incoterm</th>
                                    <th>POD</th>
                                    <th>Destino</th>
                                    <th>M B/L</th>
                                    <th>QTY</th>
                                    <th>Modalidad</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($operations as $operation)
                                    <tr>
                                        @if(Auth::user()->isAdmin())
                                        <td>{{ $operation->user->name }}</td>
                                        @endif
                                        <td>{{ $operation->master_consigner }}</td>
                                        <td>{{ $operation->house_consigner }}</td>
                                        <td>{{ $operation->incoterm }}</td>
                                        <td>{{ $operation->pod }}</td>
                                        <td>{{ $operation->destino }}</td>
                                        <td>{{ $operation->m_bl }}</td>
                                        <td>{{ $operation->qty }}</td>
                                        <td>{{ $operation->modalidad }}</td>
                                        <td>
                                            <a href="{{ route('operaciones.show', $operation->id )}}" class="action-icon btn btn-link" data-toggle="tooltip" data-placement="top" title data-original-title="Ver información"> <i class="mdi mdi-eye"></i></a>
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

<!-- Start Modals	 -->
    <div id="register-operation-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Registro de operación</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('operaciones.store') }}" enctype="multipart/form-data" class="pl-3 pr-3">
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Shipper <span class="text-danger">*</span></label>
                                    <input class="form-control{{ $errors->has('shipper') ? ' is-invalid' : '' }}" type="text" name="shipper" value="{{ old('shipper') }}">
                                    @if ($errors->has('shipper'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('shipper') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Master consigner <span class="text-danger">*</span></label>
                                    <input class="form-control{{ $errors->has('master_consigner') ? ' is-invalid' : '' }}" type="text" name="master_consigner" value="{{ old('master_consigner') }}">
                                    @if ($errors->has('master_consigner'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('master_consigner') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>House consigner <span class="text-danger">*</span></label>
                                    <input class="form-control{{ $errors->has('house_consigner') ? ' is-invalid' : '' }}" type="text" name="house_consigner" value="{{ old('house_consigner') }}">
                                    @if ($errors->has('house_consigner'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('house_consigner') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>ETD <span class="text-danger">*</span></label>                            
                                    <input class="form-control{{ $errors->has('etd') ? ' is-invalid' : '' }}" type="date" name="etd" value="{{ old('etd') }}">
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
                                    <input class="form-control{{ $errors->has('eta') ? ' is-invalid' : '' }}" type="date" name="eta" value="{{ old('eta') }}">
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
                                    <input type="text" class="form-control{{ $errors->has('impo_expo') ? ' is-invalid' : '' }}" value="{{ old('impo_expo') }}"  name="impo_expo">
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
                                    <input type="text" class="form-control{{ $errors->has('pol') ? ' is-invalid' : '' }}" value="{{ old('pol') }}"  name="pol">
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
                                    <input type="text" class="form-control{{ $errors->has('pod') ? ' is-invalid' : '' }}" value="{{ old('pod') }}"  name="pod">
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
                                    <input type="text" class="form-control{{ $errors->has('destino') ? ' is-invalid' : '' }}" value="{{ old('destino') }}"  name="destino">
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
                                    <input type="text" class="form-control{{ $errors->has('incoterm') ? ' is-invalid' : '' }}" value="{{ old('incoterm') }}"  name="incoterm">
                                    @if ($errors->has('incoterm'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('incoterm') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Booking # <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control{{ $errors->has('booking') ? ' is-invalid' : '' }}" value="{{ old('booking') }}"  name="booking">
                                    @if ($errors->has('booking'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('booking') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Custom cutoff <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control{{ $errors->has('custom_cutoff') ? ' is-invalid' : '' }}" value="{{ old('custom_cutoff') }}"  name="custom_cutoff">
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
                                    <input type="text" class="form-control{{ $errors->has('vessel') ? ' is-invalid' : '' }}" value="{{ old('vessel') }}"  name="vessel">
                                    @if ($errors->has('vessel'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('vessel') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>O/F <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control{{ $errors->has('o_f') ? ' is-invalid' : '' }}" value="{{ old('o_f') }}"  name="o_f">
                                    @if ($errors->has('o_f'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('o_f') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>C. Invoice <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control{{ $errors->has('c_invoice') ? ' is-invalid' : '' }}" value="{{ old('c_invoice') }}"  name="c_invoice">
                                    @if ($errors->has('c_invoice'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('c_invoice') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>M B/L <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control{{ $errors->has('m_bl') ? ' is-invalid' : '' }}" value="{{ old('m_bl') }}"  name="m_bl">
                                    @if ($errors->has('m_bl'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('m_bl') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>H B/L <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control{{ $errors->has('h_bl') ? ' is-invalid' : '' }}" value="{{ old('h_bl') }}"  name="h_bl">
                                    @if ($errors->has('h_bl'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('h_bl') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>CNTR # <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control{{ $errors->has('cntr') ? ' is-invalid' : '' }}" value="{{ old('cntr') }}"  name="cntr">
                                    @if ($errors->has('cntr'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('cntr') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Type <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" value="{{ old('type') }}"  name="type">
                                    @if ($errors->has('type'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('type') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Size <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control{{ $errors->has('size') ? ' is-invalid' : '' }}" value="{{ old('size') }}"  name="size">
                                    @if ($errors->has('size'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('size') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>QTY <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control{{ $errors->has('qty') ? ' is-invalid' : '' }}" value="{{ old('qty') }}"  name="qty">
                                    @if ($errors->has('qty'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('qty') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Weight/Measures <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control{{ $errors->has('weight_measures') ? ' is-invalid' : '' }}" value="{{ old('weight_measures') }}"  name="weight_measures">
                                    @if ($errors->has('weight_measures'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('weight_measures') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Modalidad <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control{{ $errors->has('modalidad') ? ' is-invalid' : '' }}" value="{{ old('modalidad') }}"  name="modalidad">
                                    @if ($errors->has('modalidad'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('modalidad') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>AA <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control{{ $errors->has('aa') ? ' is-invalid' : '' }}" value="{{ old('aa') }}"  name="aa">
                                    @if ($errors->has('aa'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('aa') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><b>Registrar</b></button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div id="register-operation-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="primary-header-modalLabel">Registro de operación</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">

                    <div class="text-center mt-2 mb-4">
                        <p>Ingresa la siguiente información para registrar al operación.</p>
                    </div>
                    

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Registrar</button>
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
  <script>
    $(document).ready(function() {
        $("#operations-datatable").DataTable({
            language: {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                    },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }             
            },
            pageLength: 5,
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

        $('#register-user-modal').on('shown.bs.modal', function (e) {
            
        })

        // function abrirModal(){
        //     $('#register-user-modal').modal('show');
        // }
  });
  </script>
    @if($errors->any())
        <script>
            $('#register-user-modal').modal('show');
        </script>
    @endif
    @if(session()->has('info'))
        <script>
            $.NotificationApp.send("Bien hecho!", "{{ session('info') }}", 'top-right', 'rgba(0,0,0,0.2)', 'success');
        </script>
    @endif
@endsection
