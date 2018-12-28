@extends('layouts.hyper')

@section('title', 'Debit Note')

@section('content')

 <div class="container-fluid" style="color: #545353;">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">Menú</li>
                        <li class="breadcrumb-item">Operaciones</li>
                        <li class="breadcrumb-item"><a href="{{ route('operaciones.index')}}">Control de operaciones</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('operaciones.show', $debitnote->operation->id)}}">Operación # {{ $debitnote->operation->id }}</a></li>
                        <li class="breadcrumb-item active">{{ $debitnote->numberFormat }}</li>
                    </ol>
                </div>
                <h4 class="page-title">Debit note {{ $debitnote->numberFormat }}</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-print-none">
                        <div class="row justify-content-around">
                            <div class="col">
                                @if(!$debitnote->canceled_at)
                                    @if(Auth::user()->present()->isFac() || Auth::user()->present()->isAdminGeneral())
                                        @if($debitnote->invoices->isEmpty())
                                            <button class="btn btn-light" data-toggle="modal" data-target="#register-invoice-modal"><i class="mdi mdi-square-edit-outline"></i> Ingresar información de factura</button>
                                        @else
                                            @if($debitnote->invoices->pluck('canceled_at')->contains(null))
                                                <h5><a class="btn btn-info" href="{{ route('facturas.show', $debitnote->invoices->first()->factura )}}" data-toggle="tooltip" data-placemente="top" data-original-title="Ver información de factura">Ver factura {{ $debitnote->invoices->first()->factura }}</a></h5>
                                            @else
                                                <h5><a class="btn btn-danger" href="{{ route('facturas.show', $debitnote->invoices->first()->factura )}}" data-toggle="tooltip" data-placemente="top" data-original-title="Ver información de factura">Factura {{ $debitnote->invoices->first()->factura }} Cancelada</a></h5>
                                            @endif
                                        @endif
                                    @endif
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#cancel-debitnote-modal"><i class="mdi mdi-close-box-outline"></i> Cancelar</button>
                                @else
                                    <h5><a class="btn btn-danger" href="javascript:void(0)">Cancelado</a></h5>
                                @endif
                            </div>
                            <div class="col">
                                <div class="text-right">
                                    <a href="javascript:window.print()" class="btn btn-primary"><i class="mdi mdi-printer"></i> Imprimir</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    {{-- <hr style="background-color: #5b5a5a; height: 0px; margin-top: -1px; margin-bottom: -1px; border-color: #5b5a5a;"> --}}
                    <div class="row justify-content-center">
                        <div class="col-4 row justify-content-center align-items-center">
                            <img src="{{ asset('assets/images/logos/unico imagen.jpg') }}" alt="" height="45">
                        </div>
                        <div class="col-5 row justify-content-center align-items-center">
                            <div class="mt-3">
                                <h4>UNICO LOGISTICS MEX S DE RL DE CV</h4>
                                <p>AV. MIGUEL ALEMÁN #804 LOCAL 2<br>
                                COL. HACIENDA LAS FUENTES, C.P. 66477<br>
                                SAN NICOLÁS DE LOS GARZA, N.L. MÉXICO<br>
                                TEL: +(52) 81-1090-9472 / 81-1090-8987</p>
                            </div>
                        </div>
                        <div class="col-3 row justify-content-center align-items-center">
                            <div class="">
                                <h3>&nbsp;DEBIT NOTE<br><h4>( {{ $debitnote->numberformat }} )<h4></h3>
                            </div>
                        </div>
                    </div>
                    <hr style="background-color: #5b5a5a; height: 0px; border-color: #5b5a5a;">
                    <div class="row justify-content-center">
                        <div class="col-9">
                            <p>TO:  {{ strtoupper($debitnote->client->razon_social) }} </p>
                        </div>
                        <div class="col-3">
                            <p>FECHA: {{ $debitnote->created_at->format('d-m-Y') }}</p>
                        </div>
                    </div>
                    <hr style="background-color:#5b5a5a; height: 0px; margin-top: -1px; border-color: #5b5a5a;">
                    <div class="row justify-content-around mt-2 pl-4 pr-4">
                        <div class="col-6 row">
                            <div class="col-5">
                                <h5 style="margin: 5px;">H B/L NO.</h5>
                            </div>
                            <div class="col-7">
                                <h5 style="margin: 5px;">: {{ $debitnote->operation->h_bl }}</h5>
                            </div>
                            <div class="col-5">
                                <h5 style="margin: 5px;">P.O.L</h5>
                            </div>
                            <div class="col-7">
                                <h5 style="margin: 5px;">: {{ $debitnote->operation->pol }}</h5>
                            </div>
                            <div class="col-5">
                                <h5 style="margin: 5px;">P.O.D</h5>
                            </div>
                            <div class="col-7">
                                <h5 style="margin: 5px;">: {{ $debitnote->operation->pod }}</h5>
                            </div>
                            <div class="col-5">
                                <h5 style="margin: 5px;">Pleace of Delivery</h5>
                            </div>
                            <div class="col-7">
                                <h5 style="margin: 5px;">: {{ $debitnote->operation->destino }}</h5>
                            </div>
                            <div class="col-5">
                                <h5 style="margin: 5px;">WEIGHT</h5>
                            </div>
                            <div class="col-7">
                                <h5 style="margin: 5px;">: {{ number_format($debitnote->operation->containers->pluck('weight')->sum(), 2, ".", ",") }} KGS</h5>
                            </div>
                            <div class="col-5">
                                <h5 style="margin: 5px;">MEASUREMENT</h5>
                            </div>
                            <div class="col-7">
                                <h5 style="margin: 5px;">: {{ number_format($debitnote->operation->containers->pluck('measures')->sum(), 2, ".", ",") }} CBM</h5>>
                            </div>
                        </div>
                        <div class="col-6 row">
                            <div class="col-5">
                                <h5 style="margin: 5px;">M B/L NO.</h5>
                            </div>
                            <div class="col-7">
                                <h5 style="margin: 5px;">: {{ $debitnote->operation->m_bl }}</h5>
                            </div>
                            <div class="col-5">
                                <h5 style="margin: 5px;">VSL/VOY</h5>
                            </div>
                            <div class="col-7">
                                <h5 style="margin: 5px;">: {{ $debitnote->operation->vessel }}</h5>
                            </div>
                            <div class="col-5">
                                <h5 style="margin: 5px;">E.T.D</h5>
                            </div>
                            <div class="col-7">
                                <h5 style="margin: 5px;">: {{ $debitnote->operation->etdFormat }}</h5>
                            </div>
                            <div class="col-5">
                                <h5 style="margin: 5px;">E.T.A</h5>
                            </div>
                            <div class="col-7">
                                <h5 style="margin: 5px;">: {{ $debitnote->operation->etaFormat }}</h5>
                            </div>
                            <div class="col-5">
                                <h5 style="margin: 5px;"></h5>
                            </div>
                            <div class="col-7">
                                <h5 style="margin: 5px;"></h5>
                            </div>
                            <div class="col-5">
                                <h5 style="margin: 5px;">CONTAINER</h5>
                            </div>
                            <div class="col-7">
                                <h5 style="margin: 5px;">
                                    : {{ $debitnote->operation->present()->containersgroup() }}
                                </h5>
                            </div>
                            <div class="col-5">
                                <h5 style="margin: 5px;"></h5>
                            </div>
                            <div class="col-7">
                                <h5 style="margin: 5px;">
                                    &nbsp;&nbsp;{{ $debitnote->operation->containers->pluck('c_invoice')->implode(', ') }}
                                </h5>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                    <div class="row pl-4 pr-4">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mt-4">
                                    <thead>
                                        <tr class="text-center" style="border-color: #545353;">
                                            <th width="5%">#</th>
                                            <th><b>DESCRIPTION</b></th>
                                            <th class="text-center">CURR</th>
                                            <th class="text-center">QTY</th>
                                            <th class="text-center">RATE</th>
                                            <th class="text-center">IVA</th>
                                            <th class="text-center">FOREIGN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($debitnote->conceptsoperations as $key => $concept)
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td>{{ $concept->concept->description }}</td>
                                                <td class="text-center">{{ $concept->curr }}</td>
                                                <td class="text-center">{{ $concept->qty }}</td>
                                                <td class="text-right">{{ number_format($concept->rate, 2, ".", ",") }}</td>
                                                <td class="text-right">{{ number_format($concept->iva, 2, ".", ",") }}</td>
                                                <td class="text-right">{{ number_format(($concept->rate * $concept->qty) + ($concept->iva * $concept->qty), 2, ".", ",") }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end table-responsive-->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                    <div class="row justify-content-end pl-4 pr-4">
                        <div class="col-sm-6">
                            <div class="float-right mt-3">
                               <p><b>Rate Total:</b> <span class="float-right">{{ number_format($debitnote->ratetotal, 2, ".", ",") }}</span></p>
                                <p><b>Iva:</b> <span class="float-right">{{ number_format($debitnote->ivatotal, 2, ".", ",") }}</span></p>
                                <h4>FOREIGN TOTAL: &nbsp;&nbsp;&nbsp;&nbsp; {{ number_format($debitnote->foreigntotal, 2, ".", ",") }}</h4>
                            </div>
                            <div class="clearfix"></div>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row-->

                    <br><br><br><br>
                    <div class="row pl-4 pr-4">
                        <div class="col-7" style="border: 1px solid #e3eaef; border-color: #5b5a5a;">
                            <div class="row mt-2">
                                <div class="col-4">
                                    <p class="text-center">BANK NAME</p>
                                    <p class="text-left">KEB HANA BANK(USD)</p>
                                    <p class="text-left">KEB HANA BANK(EUR)</p>
                                </div>
                                <div class="col-4">
                                    <p class="text-center">SWIFT CODE</p>
                                    <p class="text-left">KOEXKRSE</p>
                                    <p class="text-left">KOEXKRSE</p>
                                </div>
                                <div class="col-4 text-center">
                                    <p>ACC.</p>
                                    <p>010-JSD-103573-2</p>
                                    <p>010-JSD-104872-1</p>
                                </div>
                                <div class="col-12">
                                    <br><br><br>
                                    <p>BENEFICIARY NAME : UNICO LOGISTICS CO., LTD.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="row mt-2">
                                <div class="col-12">
                                    <p><b>AUTHORIZED SIGNATURE</b></p>
                                    <br>
                                    <img src="{{ asset('assets/images/logos/firma_sr_kim.png') }}" alt="" height="50">
                                    <br><br>
                                </div>
                                <div class="col-12" style="border: 1px solid #e3eaef; border-color: #5b5a5a;">
                                    <div class="row mt-2">
                                        <div class="col-6">
                                            <p>SALESMAN : DSPARK</p>
                                            <p>ATTN : Cerena Cho</p>
                                        </div>
                                        <div class="col-6">
                                            <p>TEL : 02-3708-1531</p>
                                            <p>TEL : 02-3708-1513</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card -->
        </div> <!-- end col-->
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
                                <input type="hidden" name="debit_note_id" value="{{ $debitnote->id }}">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Factura <span class="text-danger">*</span></label>
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
                                        <label>Fecha factura <span class="text-danger">*</span></label>
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
                                        <label>Moneda <span class="text-danger">*</span></label>
                                        <select type="text" class="form-control form-control-light{{ $errors->has('moneda') ? ' is-invalid' : '' }}" value="{{ old('moneda') }}"  name="moneda">
                                            <option value="MXN">MXN</option>
                                            <option value="USD" selected>USD</option>
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
                                        <input class="form-control form-control-light{{ $errors->has('neto') ? ' is-invalid' : '' }}" type="number" step="any" name="neto" value="{{ $debitnote->ratetotal }}" onchange="calcularTotal()">
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
                                        <input class="form-control form-control-light{{ $errors->has('iva') ? ' is-invalid' : '' }}" type="number" step="any" name="iva" value="{{ $debitnote->ivatotal }}" onchange="calcularTotal()">
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
                                        <input class="form-control form-control-light" type="number" step="any" id="total" value="{{ $debitnote->ratetotal + $debitnote->ivatotal }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Comentarios</label>
                                        <textarea class="form-control form-control-light" type="date" name="comentarios"></textarea>
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

        <div id="cancel-debitnote-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body p-4">
                        <div class="text-center">
                            <i class="dripicons-warning h1 text-danger"></i>
                            <h4 class="mt-2">Precaución!</h4>
                            <p class="mt-3">¿Está seguro(a) de cancelar el debit note?</p>
                            <button type="button" class="btn btn-light my-2" data-dismiss="modal">Cancelar</button>
                            <form id="cancel_debitnote_form" style="display: inline;" action="{{ route('debitnote.cancel') }}" method="POST">
                                {!! csrf_field() !!}
                                {!! method_field('DELETE') !!}
                                <input type="hidden" name="debitnote_id" value="{{ $debitnote->id }}">
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
    <script>
        function calcularTotal()
        {
            var neto = $('#register-invoice-form input[name=neto]').val();
            var iva = $('#register-invoice-form input[name=iva]').val();
            var total = (parseFloat(neto) + parseFloat(iva));
            $('#register-invoice-form #total').val(parseFloat(total).toFixed(2));
        }

        @if($errors->any())
            $('#register-invoice-modal').modal('show');
        @endif
    </script>
@endsection