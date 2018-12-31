@extends('layouts.hyper')

@section('title', 'House B/L')

@section('content')
    <style>
        .font14{
            font-size: 14px;
            font-weight: 600;
        }

        .font12{
            font-size: 12px;
            font-weight: 400;
            margin-bottom: 5px;
        }

        .font10{
            font-size: 10px;
            font-weight: 600;
        }

        .mb-0{
            margin-bottom: 0;
        }

        .borderleft{
            border-color: #5b5a5a;
            border-left: 1px solid #5b5a5a;
        }

        .borderleft-dashed{
            border-style: dashed;
            border-color: #5b5a5a;
            /*border-left: 1px solid #5b5a5a;*/
            border-right: none;
            border-top: none;
            border-bottom: none;
        }

        .hr{
            /*background-color: #5b5a5a;*/
            height: 0px;
            margin-top: -1px;
            margin-bottom: -1px;
            border-color: #5b5a5a;
        }

        .rotar {
            -webkit-transform: rotate(-30deg);
            transform: rotate(-30deg);
        }

        pre{
            border: none;
        }
    </style>

 <div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">Menú</li>
                        <li class="breadcrumb-item">Operaciones</li>
                        <li class="breadcrumb-item"><a href="{{ route('operaciones.index')}}">Control de operaciones</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('operaciones.show', $housebl->operation->id)}}">Operación # {{ $housebl->operation->id }}</a></li>
                        <li class="breadcrumb-item active">House B/L {{ $housebl->numberformat }}</li>
                    </ol>
                </div>
                <h4 class="page-title">House B/L {{ $housebl->numberformat }}</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-print-none">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-6">
                                <div class="row align-items-center">
                                    <div class="col-3">
                                        <label for="">B/L Type</label>
                                        <select type="text" class="form-control select2" data-toggle="select2" id="bl_type" onchange="bl_type_print();">
                                            <option value="SURRENDERED">SURRENDERED</option>
                                            <option value="WAYBILL">WAYBILL</option>
                                            <option value="COPY">COPY</option>
                                            <option value="ORIGINAL">ORIGINAL</option>
                                        </select>
                                    </div>
                                    <div class="col-3 custom-control custom-checkbox">
                                        <br>
                                        <input type="checkbox" class="custom-control-input" id="checkCopy" checked>
                                        <label class="custom-control-label" for="checkCopy">Copy Non-Negotiable</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row justify-content-end">
                                    <div class="{{ !$housebl->canceled_at ? 'col-4' : 'col-2' }}">
                                        @if(!$housebl->canceled_at)
                                            <button class="btn btn-danger" data-toggle="modal" data-target="#cancel-housebl-modal"><i class="mdi mdi-close-box-outline"></i> Cancelar</button>
                                        @endif
                                        <a href="javascript:window.print()" class="btn btn-primary"><i class="mdi mdi-printer"></i> Imprimir</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-6">
                            <hr class="hr">
                            <div>
                                <p class="font12">SHIPPER</p>
                                <p class="font14" style="padding-left: 20px;"><b>
                                    {{ ucwords(strtolower($housebl->operation->ship->razon_social)) }}              <br>
                                    {{ ucwords(strtolower($housebl->operation->ship->calle)) }}, #{{ $housebl->operation->ship->numero_exterior }}         <br>
                                    {{ ucwords(strtolower($housebl->operation->ship->colonia)) }}, C.P. {{ $housebl->operation->ship->codigo_postal }}         <br>
                                    {{ ucwords(strtolower($housebl->operation->ship->pais)) }}, {{ ucwords(strtolower($housebl->operation->ship->estado)) }}, {{ ucwords(strtolower($housebl->operation->ship->municipio)) }}         <br>
                                    Tel: {{ $housebl->operation->ship->telefono1 }}   <br>
                                </b></p>
                            </div>
                            <hr class="hr">
                            <div>
                                <p class="font12">CONSIGNEE</p>
                                <p class="font14" style="padding-left: 20px;"><b>
                                    {{ ucwords(strtolower($housebl->operation->house->razon_social)) }}              <br>
                                    {{ ucwords(strtolower($housebl->operation->house->calle)) }}, #{{ $housebl->operation->house->numero_exterior }}         <br>
                                    {{ ucwords(strtolower($housebl->operation->house->colonia)) }}, C.P. {{ $housebl->operation->house->codigo_postal }}         <br>
                                    {{ ucwords(strtolower($housebl->operation->house->pais)) }}, {{ ucwords(strtolower($housebl->operation->house->estado)) }}, {{ ucwords(strtolower($housebl->operation->house->municipio)) }}         <br>
                                    Tel: {{ $housebl->operation->house->telefono1 }}   <br>
                                </b></p>
                            </div>
                            <hr class="hr">
                            <p class="font12">NOTIFY PARTY</p>
                            <p class="font14" style="height: 90px; padding-left: 20px;">
                                {{ strtoupper($housebl->notify_party) }}
                            </p>
                            <hr class="hr">
                            <div class="row">
                                <div class="col-6">
                                    <p class="font12">PRE CARRIAGE BY</p>
                                    <p class="font14 mb-0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>{{ strtoupper($housebl->operation->pol) }}</b></p>
                                </div>
                                <div class="col-6 borderleft">
                                    <p class="font12">PLACE OF RECEIPT</p>
                                    <p class="font14 mb-0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b></b></p>
                                </div>
                            </div>
                            <hr class="hr">
                            <div class="row">
                                <div class="col-6">
                                    <p class="font12">OCEAN VESSEL</p>
                                    <p class="font14 mb-0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>{{ strtoupper($housebl->operation->vessel) }}</b></p>
                                </div>
                                <div class="col-6 borderleft">
                                    <p class="font12">PORT OF LOADING</p>
                                    <p class="font14 mb-0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <b>{{ strtoupper($housebl->operation->pol) }}</b></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <hr class="hr">
                            <div>
                                <p class="font12">B/L No.</p>
                                <div class="row justify-content-center">
                                    <p style="font-size: 20px">{{ $housebl->numberformat }}</p>
                                </div>
                                <div class="row justify-content-center">
                                    <img src="{{ asset('assets/images/logos/unico imagen.jpg') }}" alt="" height="65">
                                </div>
                                <br>
                                <div class="row justify-content-center">
                                    <p style="font-size: 20px" class="mb-0"><b>COMBINED TRANSPORT</b></p>
                                </div>
                                <div class="row justify-content-center">
                                    <p style="font-size: 25px"><b>BILL OF LADING</b></p>
                                </div>
                                <div style="position: absolute; margin-left: 60px; margin-top: 90px;">
                                    <h2 style="font-size: 50px;" id="bl_type_text">SURRENDERED</h2>
                                </div>
                                <div style="position: absolute; margin-left: -220px; margin-top: 430px;">
                                    <h2 class="rotar" style="font-size: 50px; letter-spacing: 100px; filter:alpha(opacity=30);-moz-opacity:.30;opacity:.30;" id="bl_type_text2">COPY</h2>
                                    <h2 class="rotar" style="font-size: 30; letter-spacing: 10px; filter:alpha(opacity=30);-moz-opacity:.30;opacity:.30;" id="bl_type_text3">&nbsp;&nbsp;NON - NEGOTIABLE</h2>
                                </div>
                                <p style="text-align: justify;" class="font10">RECEIVED BY THE CARRIER FROM SHIPPER IN APPARENT GOOD ORDER AND CONDITION UNLESS OTHERWISE INDICATED HEREIN, THE GOODS, OR THE CONTAINER(S) OR PACKAGE(S) SAID TO CONTAIN THE CARGO HEREIN MENTIONED, TO BE CARRIED SUBJECT TO ALL THE TERMS AND CONDITIONS PROVIDED FOR ON THE FACE AND BACK OF THIS BILL OF LADING BY THE VESSEL NAMED OF TRANSPORT FROM THE PLACE OF RECEIPTOR THE PORT OF LOADING TO THE PORT OF DISCHARGE OR THE PLACEOF DELIVERY SHOWN HEREIN AND BE DELIVERED INTO ORDER OF ASSIGNS.<br>
                                IF REQUIRED BY THE CARRIER, THIS BILL OF LADING DULY ENDORSED MUST BE SURRENDERED IN ECHANGE FOR THE GOODS OR DELIVERY ORDER . <br>
                                IN ACCEPTING THIS BILL OF LADING, THE MERCHANT AGREES TO BE BOUND BY ALL THE STIPULATIONS, EXCEPTIONS, TERMS AND CONDITIONS ON THE FACE AND BACK HEREOF, WHETERWRITTEN TYPED, STAMPED OR PRINTED, AS FULLY AS IF SIGNED BY THE MERCHANT, AND LOCAL CUSTOM OR PRIVIEGE TO THE CONTRARY NOTWITHSTANDING,AND AGREES THAT ALL AGREEMENTS OR FREIGHT ENGAGEMENTS FOR AND IN CONNECTION WITH THE CARRIAGE OF THE GOODS ARE SUPERSEDED BY THIS BILL OF LOADING.<br>
                                IN WITNESS WHEREOF, THE NUMBER OF ORIGINAL BILLS OF LOADING STATED HEREIN, ALL OF THIS TENOR AND DATE, HAS BEEN SIGNED, ONE OF WICH BEING ACCOMPLISHED, THE OTHERS TO STAND VOID.</p>
                            </div>
                        </div>
                    </div>
                    <hr class="hr">
                    <div class="row">
                        <div class="col-3">
                            <p class="font12">PORT OF DISCHARGE</p>
                            <p class="font14 mb-0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>{{ strtoupper($housebl->operation->pod) }}</b></p>
                        </div>
                        <div class="col-5 borderleft">
                            <p class="font12">PLACE OF DELIVERY</p>
                            <p class="font14 mb-0" style="margin-top: -1px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>{{ strtoupper($housebl->operation->destino) }}</b></p>
                        </div>
                        <div class="col-4 borderleft">
                            <p class="font12">FINAL DESTINATION (FOR THE MERCHANTS REFRENCE ONLY)</p>
                            <p class="font14 mb-0" style="margin-top: -1px"></p>
                        </div>
                    </div>
                    <hr class="hr">
                    <div class="row" style="height: 375px;">
                        <div class="col-3">
                            <p class="font12">MARKS AND NUMBERS</p>
                            <p class="font14 mb-0" style="padding-left: 20px;">
                                <b>
                                    Container No & Seal No<br>
                                    @foreach($housebl->containershousebl as $container)
                                        {{ $container->container->cntr }}/{{ $container->container->seal_no }}<br>
                                    @endforeach
                                </b>
                            </p>
                            <br><br><br><br><br><br><br><br><br><br><br>
                            <p class="font14 mb-0" style="padding-left: 20px; vertical-align: text-bottom;">
                                <b>
                                    {{ $housebl->service_term1 }}/{{ $housebl->service_term2}}
                                </b>
                            </p>
                        </div>
                        <div class="col-2 borderleft-dashed">
                            <p class="font12">NO. OF PKGS. OR UNITS</p>
                            <p class="font14 mb-0" style="margin-top: -1px;padding-left: 20px">
                                <b>
                                    {{ strtoupper($housebl->no_pkgs) }} PKGS.<br>
                                    {{ $housebl->present()->noPackagesOrUnits() }}
                                </b>
                            </p>
                        </div>
                        <div class="col-3 borderleft-dashed">
                            <div class="row align-items-start">
                                <div class="col align-items-start">
                                    <p class="font12">DESCRIPTION OR PACKAGES AND GOODS</p>
                                    <p class="font12 mb-0" style="margin-top: -1px;padding-left: 10px;">
                                        <b>"{{ $housebl->description_header1 }}"</b>
                                    </p>
                                    <p class="font12 mb-0" style="margin-top: -1px;padding-left: 10px;">
                                        <b>{{ $housebl->description_header2 }}</b>
                                    </p>
                                    <br>
                                    <p class="font14 mb-0" style="margin-top: -1px;padding-left: 20px;">
                                        <?php
                                            $exp = explode("\n", $housebl->description);
                                            $lineas = count($exp );
                                        ?>
                                        @if($lineas <= 12)
                                            <pre class="">{{ strtoupper($housebl->description) }}</pre>
                                            <p class="font14 mb-0" style="margin-top: -1px;padding-left: 45px;"><b>"FREIGHT {{ $housebl->freight_term }}"</b></p>
                                        @else
                                            <p class="font12 mb-0" style="margin-top: -1px;padding-left: 20px;">
                                                == AS PER ATTACHED RIDER ==
                                            </p>
                                            <br><br><br><br><br><br><br><br><br><br>
                                            <p class="font14 mb-0" style="margin-top: -1px;padding-left: 45px;"><b>"FREIGHT {{ $housebl->freight_term }}"</b></p>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            {{-- <div class="row align-items-end"> --}}
                            {{-- </div> --}}
                        </div>
                        <div class="col-2 borderleft-dashed">
                            <p class="font12">GROSS WEIGHT</p>
                            <p class="font14 mb-0" style="margin-top: -1px; padding-left: 20px;">
                                <b>
                                    {{ $housebl->present()->grossWeight() }}
                                </b>
                            </p>
                        </div>
                        <div class="col-2 borderleft-dashed">
                            <p class="font12">MEASUREMENT</p>
                            <p class="font14 mb-0" style="margin-top: -1px; padding-left: 20px;">
                                <b>
                                    {{ $housebl->present()->measurement() }}
                                </b>
                            </p>
                        </div>
                    </div>
                    <hr class="hr">
                    <div class="row">
                        <div class="col-3">
                            <p class="font14 mb-0"><b>TOTAL NUMBER OF PACKAGES OR UNITS (IN WORDS)</b></p>
                        </div>
                        <div class="col-1 borderleft-dashed">

                        </div>
                        <div class="col-4 borderleft-dashed">
                            <p class="font14 mb-0" style="margin-top: -1px">SAY:
                                <b>
                                    {{ $housebl->present()->noPackagesOrUnitsInWords() }}

                                </b>
                            </p>
                        </div>
                        <div class="col-2 borderleft-dashed">
                        </div>
                        <div class="col-2 borderleft-dashed">
                        </div>
                    </div>
                    <hr class="hr">
                    <div class="row">
                        <div class="col-3">
                            <p class="font12">FREIGHT AND CHARGES</p>
                            <p class="font14 mb-0" style="padding-left: 20px;"><b>FREIGHT PREPAID AS ARRANGED</b></p>
                        </div>
                        <div class="col-2 borderleft-dashed">
                            <p class="font12">REVENUE TONS</p>
                            <p class="font14 mb-0" style="margin-top: -1px"></p>
                        </div>
                        <div class="col-2 borderleft-dashed">
                            <p class="font12">RATE</p>
                            <p class="font14 mb-0" style="margin-top: -1px"></p>
                        </div>
                        <div class="col-2 borderleft-dashed">
                            <p class="font12">PREPAID</p>
                            <p class="font14 mb-0" style="margin-top: -1px"></p>
                        </div>
                        <div class="col-2 borderleft-dashed">
                            <p class="font12">COLLECT</p>
                            <p class="font14 mb-0" style="margin-top: -1px"></p>
                        </div>
                        <br><br><br><br><br><br><br><br><br><br><br>
                    </div>
                    <hr class="hr">
                    <div class="row">
                        @if($housebl->freight_term == "PREPAID")
                            <div class="col-3">
                                <p class="font12">FREIGHT PAYABLE AT</p>
                                <p class="font14 mb-0" style="margin-top: -1px; padding-left: 20px;">
                                     {{ strtoupper($housebl->operation->ship->estado) }}, {{ strtoupper($housebl->operation->ship->pais) }}
                                </p>
                            </div>
                            <div class="col-4 borderleft">
                                <p class="font12">NUMBER OF ORIGINAL B/L(S)</p>
                                <p class="font14 mb-0" style="margin-top: -1px; padding-left: 20px;">
                                    ZERO (0)
                                </p>
                            </div>
                            <div class="col-4 borderleft">
                                <p class="font12">PLACE AND DATE OF ISSUE</p>
                                <p class="font14 mb-0" style="margin-top: -1px; padding-left: 20px;">
                                    NUEVO LEÓN, MÉXICO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $housebl->created_at->format('d-m-Y h:i:s') }}
                                </p>
                            </div>
                        @else
                            <div class="col-3">
                                <p class="font12">FREIGHT PAYABLE AT</p>
                                <p class="font14 mb-0" style="margin-top: -1px; padding-left: 20px;"></p>
                            </div>
                            <div class="col-4 borderleft">
                                <p class="font12">NUMBER OF ORIGINAL B/L(S)</p>
                                <p class="font14 mb-0" style="margin-top: -1px; padding-left: 20px;"></p>
                            </div>
                            <div class="col-4 borderleft">
                                <p class="font12">PLACE AND DATE OF ISSUE</p>
                                <p class="font14 mb-0" style="margin-top: -1px; padding-left: 20px;"></p>
                            </div>
                        @endif
                    </div>
                    <hr class="hr">
                    <div class="row">
                        <div class="col-7">
                            <p class="font12">FOR DELIVERY OF GOODS PLASE APPLY TO</p>
                            <p class="font14"> <b>UNICO LOGISTICS MEX S DE RL DE CV              <br>
                                    Av. Miguel Alemán #804 Local2         <br>
                                    Col. Hacienda las Fuentes,  <br>
                                    San Nicolás de los Garza, Nuevo León                   <br>
                                    Me México C.P. 66477<br>
                                    Tel: (52) 81-1090-9472/(52) 81-1090-9603</b><br>
                                </p>
                        </div>
                        <div class="col-4 borderleft">
                            <br>
                            <img src="{{ asset('assets/images/logos/unico.jpg') }}" alt="" height="50">
                        </div>
                    </div>
                    <hr class="hr">
                    <br>
                    <div class="row justify-content-center">
                        <p class="font14">(TERMS CONTINUED ON BACK HEREOF)</p>
                    </div>
                    @if($lineas >= 12)
                        <div class="row justify-content-center">
                            <p style="font-size: 25px;">RIDER</p>
                        </div>
                        <hr class="hr">
                        <div class="row">
                            <div class="col-3">
                                <p class="font14">HOUSE B/L:</p>
                            </div>
                            <div class="col-3">
                                <p class="font14">{{ $housebl->numberformat }}</p>
                            </div>
                            <div class="col-6">
                            </div>
                        </div>
                        <hr class="hr">
                        <div class="row">
                            <div class="col-3">
                                <p class="font12">MARK & NUMBER</p>
                                <p class="font12">Container/Seal No.</p>
                            </div>
                            <div class="col-2 borderleft">
                                <p class="font12">PACKAGE/UNIT</p>
                                <p class="font14 mb-0" style="margin-top: -1px"></p>
                            </div>
                            <div class="col-7 borderleft">
                                <p class="font12">DESCRIPTION</p>
                                <p class="font14 mb-0" style="margin-top: -1px"></p>
                            </div>
                        </div>
                        <hr class="hr">
                        <div class="row">
                            <div class="col-3">
                            </div>
                            <div class="col-2">
                            </div>
                            <div class="col-7">
                                <br>
                                <pre class="">{{ strtoupper($housebl->description) }}</pre>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

    <div id="cancel-housebl-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-warning h1 text-danger"></i>
                        <h4 class="mt-2">Precaución!</h4>
                        <p class="mt-3">¿Está seguro(a) de cancelar el house bl?</p>
                        <button type="button" class="btn btn-light my-2" data-dismiss="modal">Cancelar</button>
                        <form id="cancel_housebl_form" style="display: inline;" action="{{ route('housebl.cancel') }}" method="POST">
                            {!! csrf_field() !!}
                            {!! method_field('DELETE') !!}
                            <input type="hidden" name="housebl_id" value="{{ $housebl->id }}">
                            <button type="sumbit" class="btn btn-danger my-2"><b>Aplicar</b></button>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection
@section('scripts')
    <script>
        function bl_type_print(){
            var bl_type = document.getElementById('bl_type').value;
            var bl_type_text = document.getElementById('bl_type').value;
            if (bl_type_text == "COPY") {
                document.getElementById('bl_type_text').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + bl_type;
            }else if(bl_type_text == "WAYBILL"){
                document.getElementById('bl_type_text').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + bl_type;
            }else if(bl_type_text == "ORIGINAL"){
                document.getElementById('bl_type_text').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + bl_type;
            }else{
                document.getElementById('bl_type_text').innerHTML = bl_type;
            }
        }

        $('#checkCopy').click(function(){
            if($(this).is(':checked')){
                document.getElementById('bl_type_text2').innerHTML = "COPY";
                document.getElementById('bl_type_text3').innerHTML = "&nbsp;&nbsp;NON NEGOTIABLE";
            } else {
                document.getElementById('bl_type_text2').innerHTML = "";
                document.getElementById('bl_type_text3').innerHTML = "";
            }
        });

    </script>
@endsection
