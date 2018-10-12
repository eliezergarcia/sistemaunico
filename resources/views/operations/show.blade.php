@extends('layouts.hyper')

@section('title', 'Sistema | Información de operación')

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
                        <li class="breadcrumb-item"><a href="{{ route('operaciones.index') }}">Control de operaciones</a></li>
                        <li class="breadcrumb-item active"></li>
                    </ol>
                </div>
                <h4 class="page-title">Información de la operación</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 

    <div class="row">
        <div class="col-md-12">
            <!-- Personal-Information -->
            <div class="card">
                <div class="card-body">
                    <div class="row col justify-content-between">
                        <!-- <div class="col-6"> -->
                            @if(Auth::user()->id == $operation->user->id || Auth::user()->isAdmin())
                                <button type="submit" class="btn btn-light" data-toggle="modal" data-target="#information-operation-modal">
                                    <i class="mdi mdi-file-document mr-1"></i> Editar información
                                </button>
                            @endif
                        <!-- </div> -->
                        <!-- <div class="col-6"> -->
                            <div class="btn-group">
                                <div class="btn-group dropleft" role="group">
                                    <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <span class="sr-only">Toggle Dropleft</span>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                        <!-- <div class="dropdown-divider"></div> -->
                                        <!-- <a class="dropdown-item" href="#">Separated link</a> -->
                                    </div>
                                </div>
                                <button type="button" class="btn btn-danger">
                                    <i class="mdi mdi-file-pdf"></i>
                                    PDF
                                </button>
                            </div>
                        <!-- </div> -->
                    </div>
                    <p class="text-muted font-13">
                    </p>

                    <hr/>
                    <div class="row">
                        <div class="col-6 row">
                            <div class="col-6">
                                <p><strong>Operador:</strong></p>
                            </div>
                            <div class="col-6">
                                {{ $operation->user->name }}
                            </div>
                            <div class="col-6">
                                <p><strong>Master consigner:</strong></p>
                            </div>
                            <div class="col-6">
                                {{ $operation->master_consigner }}
                            </div>
                            <div class="col-6">
                                <p><strong>ETD:</strong></p>
                            </div>
                            <div class="col-6">
                                {{ $operation->etd }}
                            </div>
                            <div class="col-6">
                                <p><strong>Impo/expo:</strong></p>
                            </div>
                            <div class="col-6">
                                {{ $operation->impo_expo }}
                            </div>
                            <div class="col-6">
                                <p><strong>POD:</strong></p>
                            </div>
                            <div class="col-6">
                                {{ $operation->pod }}
                            </div>
                            <div class="col-6">
                                <p><strong>Incoterm:</strong></p>
                            </div>
                            <div class="col-6">
                                {{ $operation->incoterm }}
                            </div>
                            <div class="col-6">
                                <p><strong>Custom cutoff:</strong></p>
                            </div>
                            <div class="col-6">
                                {{ $operation->custom_cutoff }}
                            </div>
                            <div class="col-6">
                                <p><strong>O/F:</strong></p>
                            </div>
                            <div class="col-6">
                                {{ $operation->o_f }}
                            </div>
                            <div class="col-6">
                                <p><strong>M B/L:</strong></p>
                            </div>
                            <div class="col-6">
                                {{ $operation->m_bl }}
                            </div>
                            <div class="col-6">
                                <p><strong>CNTR #:</strong></p>
                            </div>
                            <div class="col-6">
                                {{ $operation->cntr }}
                            </div>
                            <div class="col-6">
                                <p><strong>Size:</strong></p>
                            </div>
                            <div class="col-6">
                                {{ $operation->size }}
                            </div>
                            <div class="col-6">
                                <p><strong>Weight/Measures:</strong></p>
                            </div>
                            <div class="col-6">
                                {{ $operation->weight_measures }}
                            </div>
                            <div class="col-6">
                                <p><strong>AA:</strong></p>
                            </div>
                            <div class="col-6">
                                {{ $operation->aa }}
                            </div>
                        </div>
                        <div class="col-6 row">
                            <div class="col-6">
                                <p><strong>Shipper:</strong></p>
                            </div>
                            <div class="col-6">
                                {{ $operation->shipper }}
                            </div>
                            <div class="col-6">
                                <p><strong>House consigner:</strong></p>
                            </div>
                            <div class="col-6">
                                {{ $operation->house_consigner }}
                            </div>
                            <div class="col-6">
                                <p><strong>ETA:</strong></p>
                            </div>
                            <div class="col-6">
                                {{ $operation->eta }}
                            </div>
                            <div class="col-6">
                                <p><strong>POL:</strong></p>
                            </div>
                            <div class="col-6">
                                {{ $operation->pol }}
                            </div>
                            <div class="col-6">
                                <p><strong>Destino:</strong></p>
                            </div>
                            <div class="col-6">
                                {{ $operation->destino }}
                            </div>
                            <div class="col-6">
                                <p><strong>Booking #:</strong></p>
                            </div>
                            <div class="col-6">
                                {{ $operation->booking }}
                            </div>
                            <div class="col-6">
                                <p><strong>Vessel:</strong></p>
                            </div>
                            <div class="col-6">
                                {{ $operation->vessel }}
                            </div>
                            <div class="col-6">
                                <p><strong>C. Invoice:</strong></p>
                            </div>
                            <div class="col-6">
                                {{ $operation->c_invoice }}
                            </div>
                            <div class="col-6">
                                <p><strong>H B/L:</strong></p>
                            </div>
                            <div class="col-6">
                                {{ $operation->h_bl }}
                            </div>
                            <div class="col-6">
                                <p><strong>Type:</strong></p>
                            </div>
                            <div class="col-6">
                                {{ $operation->type }}
                            </div>
                            <div class="col-6">
                                <p><strong>QTY:</strong></p>
                            </div>
                            <div class="col-6">
                                {{ $operation->qty }}
                            </div>
                            <div class="col-6">
                                <p><strong>Modalidad:</strong></p>
                            </div>
                            <div class="col-6">
                                {{ $operation->modalidad }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Personal-Information -->
        </div> <!-- end col-->
    </div>

</div> <!-- container -->

<!-- Start Modals    -->
    <div id="information-operation-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Información de operación</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('operaciones.update', $operation->id) }}" enctype="multipart/form-data" class="pl-3 pr-3">
                        {!! csrf_field() !!}
                        {!! method_field('PUT') !!}
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Shipper <span class="text-danger">*</span></label>
                                    <input class="form-control{{ $errors->has('shipper') ? ' is-invalid' : '' }}" type="text" name="shipper" value="{{ $operation->shipper }}">
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
                                    <input class="form-control{{ $errors->has('master_consigner') ? ' is-invalid' : '' }}" type="text" name="master_consigner" value="{{ $operation->master_consigner }}">
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
                                    <input class="form-control{{ $errors->has('house_consigner') ? ' is-invalid' : '' }}" type="text" name="house_consigner" value="{{ $operation->house_consigner }}">
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
                                    <input class="form-control{{ $errors->has('etd') ? ' is-invalid' : '' }}" type="date" name="etd" value="{{ $operation->etd }}">
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
                                    <input class="form-control{{ $errors->has('eta') ? ' is-invalid' : '' }}" type="date" name="eta" value="{{ $operation->eta }}">
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
                                    <input type="text" class="form-control{{ $errors->has('impo_expo') ? ' is-invalid' : '' }}" value="{{ $operation->impo_expo }}"  name="impo_expo">
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
                                    <input type="text" class="form-control{{ $errors->has('pol') ? ' is-invalid' : '' }}" value="{{ $operation->pol }}"  name="pol">
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
                                    <input type="text" class="form-control{{ $errors->has('pod') ? ' is-invalid' : '' }}" value="{{ $operation->pod }}"  name="pod">
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
                                    <input type="text" class="form-control{{ $errors->has('destino') ? ' is-invalid' : '' }}" value="{{ $operation->destino }}"  name="destino">
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
                                    <input type="text" class="form-control{{ $errors->has('incoterm') ? ' is-invalid' : '' }}" value="{{ $operation->incoterm }}"  name="incoterm">
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
                                    <input type="text" class="form-control{{ $errors->has('booking') ? ' is-invalid' : '' }}" value="{{ $operation->booking }}"  name="booking">
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
                                    <input type="date" class="form-control{{ $errors->has('custom_cutoff') ? ' is-invalid' : '' }}" value="{{ $operation->custom_cutoff }}"  name="custom_cutoff">
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
                                    <input type="text" class="form-control{{ $errors->has('vessel') ? ' is-invalid' : '' }}" value="{{ $operation->vessel }}"  name="vessel">
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
                                    <input type="text" class="form-control{{ $errors->has('o_f') ? ' is-invalid' : '' }}" value="{{ $operation->o_f }}"  name="o_f">
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
                                    <input type="text" class="form-control{{ $errors->has('c_invoice') ? ' is-invalid' : '' }}" value="{{ $operation->c_invoice }}"  name="c_invoice">
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
                                    <input type="text" class="form-control{{ $errors->has('m_bl') ? ' is-invalid' : '' }}" value="{{ $operation->m_bl }}"  name="m_bl">
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
                                    <input type="text" class="form-control{{ $errors->has('h_bl') ? ' is-invalid' : '' }}" value="{{ $operation->h_bl }}"  name="h_bl">
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
                                    <input type="text" class="form-control{{ $errors->has('cntr') ? ' is-invalid' : '' }}" value="{{ $operation->cntr }}"  name="cntr">
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
                                    <input type="text" class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" value="{{ $operation->type }}"  name="type">
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
                                    <input type="text" class="form-control{{ $errors->has('size') ? ' is-invalid' : '' }}" value="{{ $operation->size }}"  name="size">
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
                                    <input type="text" class="form-control{{ $errors->has('qty') ? ' is-invalid' : '' }}" value="{{ $operation->qty }}"  name="qty">
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
                                    <input type="text" class="form-control{{ $errors->has('weight_measures') ? ' is-invalid' : '' }}" value="{{ $operation->weight_measures }}"  name="weight_measures">
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
                                    <input type="text" class="form-control{{ $errors->has('modalidad') ? ' is-invalid' : '' }}" value="{{ $operation->modalidad }}"  name="modalidad">
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
                                    <input type="text" class="form-control{{ $errors->has('aa') ? ' is-invalid' : '' }}" value="{{ $operation->aa }}"  name="aa">
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
                    <button type="submit" class="btn btn-primary"><b>Guardar</b></button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


     <div id="delete-user-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-warning h1 text-danger"></i>
                        <h4 class="mt-2">Precaución!</h4>
                        <p class="mt-3">¿Está seguro(a) de eliminar la operación <b></b>?</p>
                        <button type="button" class="btn btn-light my-2" data-dismiss="modal">Cancelar</button>
                        <form style="display: inline;" action="{{ route('operaciones.destroy', $operation->id) }}" method="POST">
                            {!! csrf_field() !!}
                            {!! method_field('DELETE') !!}
                            <button type="sumbit" class="btn btn-danger my-2">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<!-- End Modals -->
@endsection
@section('scripts')
    @if($errors->any())
        <script>
            $('#information-operation-modal').modal('show');
        </script>
    @endif
    @if(session()->has('info'))
        <script>
            $.NotificationApp.send("Bien hecho!", "{{ session('info') }}", 'top-right', 'rgba(0,0,0,0.2)', 'success');
        </script>
    @endif
@endsection

