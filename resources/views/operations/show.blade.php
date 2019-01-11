@extends('layouts.hyper')

@section('title', 'Control de operaciones | Información de operación')

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
                        <li class="breadcrumb-item"><a href="{{ route('operaciones.index') }}">Control de operaciones</a></li>
                        <li class="breadcrumb-item active">Operación # {{ $operation->id }}</li>
                    </ol>
                </div>
                <h4 class="page-title">Información de operación # {{ $operation->id }}</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    @if($operation->containers->isNotEmpty())
        @if($operation->impo_expo == "IMPO")
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="row justify-content-end">
                        <div class="col-3">
                            @if(Auth::user()->id == $operation->user->id || Auth::user()->present()->isAdmin())
                                <button class="btn btn-light dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-file-plus mr-1"></i> Crear solicitud
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    {{ $operation->present()->facturasProveedor() }}
                                    {{ $operation->present()->solicitudGarantias() }}
                                    {{ $operation->present()->solicitudAnticipo() }}
                                    <a class="dropdown-item" data-toggle="modal" data-target="#register-invoice-provider-modal">Crear factura de proveedor</a>
                                     <a class="dropdown-item" data-toggle="modal" data-target="#register-advancerequest-modal">Crear solicitud de anticipo</a>
                                    <a class="dropdown-item" data-toggle="modal" data-target="#register-guaranteerequest-modal">Crear solicitud de garantías</a>
                                </div>
                                <button class="btn btn-light" data-toggle="modal" data-target="#status-operation-impo-modal"><i class="mdi mdi-calendar-edit mr-1"></i> Agregar/Editar fechas</button>
                            @endif
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <h4>Status</h4>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-10 col-md-10 col-sm-11">
                            <div class="horizontal-steps mt-3 mb-4 pb-4">
                                <div class="horizontal-steps-content horizontal-steps-content-alter">
                                    <div class="step-item {{ !$operation->recibir ? 'current' : '' }}"></div>
                                    <div class="step-item {{ $operation->recibir && !$operation->revision ? 'current' : '' }}">
                                        <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{ $operation->recibir }}"><h5>Recibir</h5></span>
                                    </div>
                                    <div class="step-item {{ $operation->revision && !$operation->mandar ? 'current' : '' }}">
                                        <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{ $operation->revision }}"><h5>Revisión</h5></span>
                                    </div>
                                    <div class="step-item {{ $operation->mandar && !$operation->revalidacion ? 'current' : '' }}">
                                        <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{ $operation->mandar }}"><h5>Mandar</h5></span>
                                    </div>
                                    <div class="step-item {{ $operation->revalidacion && !$operation->toca_piso ? 'current' : '' }}">
                                        <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{ $operation->revalidacion }}"><h5>Revalidación</h5></span>
                                    </div>
                                    <div class="step-item {{ $operation->toca_piso && $operation->containers->pluck('proforma')->contains(null) ? 'current' : '' }}">
                                        <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{ $operation->toca_piso }}"><h5>Toca piso</h5></span>
                                    </div>
                                    <div class="step-item {{ !$operation->containers->pluck('proforma')->contains(null) && $operation->containers->pluck('pago_proforma')->contains(null) ? 'current' : '' }}">
                                        <span><h5>Proforma</h5></span>
                                    </div>
                                </div>
                                {!! (!$operation->recibir) ? '<div class="process-line" style="width: 0%;"></div>' : '' !!}
                                {!! ($operation->recibir) ? '<div class="process-line" style="width: 17%;"></div>' : '' !!}
                                {!! ($operation->revision) ? '<div class="process-line" style="width: 34%;"></div>'  : '' !!}
                                {!! ($operation->mandar) ? '<div class="process-line" style="width: 50%;"></div>'  : '' !!}
                                {!! ($operation->revalidacion) ? '<div class="process-line" style="width: 66%;"></div>'  : '' !!}
                                {!! ($operation->toca_piso) ? '<div class="process-line" style="width: 83%;"></div>'  : '' !!}
                                {!! (!$operation->containers->pluck('proforma')->contains(null))? '<div class="process-line" style="width: 100%;"></div>' : '' !!}
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-10 col-md-10 col-sm-11">
                            <div class="horizontal-steps mb-4 pb-3">
                                <div class="horizontal-steps-content">
                                    <div class="step-item {{ !$operation->containers->pluck('pago_proforma')->contains(null) && $operation->containers->pluck('despachado_puerto')->contains(null) ? 'current' : '' }}">
                                        <span><h5>Pago proforma</h5></span>
                                    </div>
                                    <div class="step-item {{ !$operation->containers->pluck('despachado_puerto')->contains(null) && $operation->containers->pluck('solicitud_transporte')->contains(null) ? 'current' : '' }}">
                                        <span><h5>Des. puerto</h5></span>
                                    </div>
                                    <div class="step-item {{ !$operation->containers->pluck('solicitud_transporte')->contains(null) && $operation->containers->pluck('port_etd')->contains(null) ? 'current' : '' }}">
                                        <span><h5>Sol. transporte</h5></span>
                                    </div>
                                    <div class="step-item {{ !$operation->containers->pluck('port_etd')->contains(null) && $operation->containers->pluck('dlv_day')->contains(null) ? 'current' : '' }}">
                                        <span><h5>PORT ETD</h5></span>
                                    </div>
                                    <div class="step-item {{ (!$operation->containers->pluck('dlv_day')->contains(null)) && ($operation->debitnotes->isEmpty()) && (!$operation->containers->pluck('dlv_day')->contains(null)) && ($operation->prefactures->isEmpty()) ? 'current' : '' }}">
                                        <span><h5>DLV DAY</h5></span>
                                    </div>
                                    <div class="step-item {{ ($operation->debitnotes->isNotEmpty() || $operation->prefactures->isNotEmpty()) && $operation->present()->solicitudesNoFacturadas() != 0 ? 'current' : '' }}">
                                        <span><h5>Solicitado<h5>
                                            {{ ($operation->debitnotes->isNotEmpty()) ? 'Debit note' : '' }}
                                            {!! ($operation->debitnotes->isNotEmpty() && $operation->prefactures->isNotEmpty()) ? '<br>' : '' !!}
                                            {{ ($operation->prefactures->isNotEmpty()) ? 'Prefactura' : '' }}
                                        </span>
                                    </div>
                                    <div class="step-item {{ $operation->present()->solicitudesNoFacturadas() == 0 ? 'current' : '' }}">
                                        <span>
                                            <h5 class="text-success">Factura UNMX</h5>
                                        </span>
                                    </div>
                                </div>
                                {!! (!$operation->containers->pluck('pago_proforma')->contains(null)) ? '<div class="process-line" style="width: 0%;"></div>' : '' !!}
                                {!! (!$operation->containers->pluck('despachado_puerto')->contains(null)) ? '<div class="process-line" style="width: 17%;"></div>' : '' !!}
                                {!! (!$operation->containers->pluck('solicitud_transporte')->contains(null)) ? '<div class="process-line" style="width: 34%;"></div>' : '' !!}
                                {!! (!$operation->containers->pluck('port_etd')->contains(null)) ? '<div class="process-line" style="width: 50%;"></div>' : '' !!}
                                {!! (!$operation->containers->pluck('dlv_day')->contains(null)) ? '<div class="process-line" style="width: 66%;"></div>' : '' !!}
                                {!! ($operation->debitnotes->isNotEmpty() || $operation->prefactures->isNotEmpty()) ? '<div class="process-line" style="width: 83%;"></div>' : '' !!}
                                {!! ($operation->present()->solicitudesNoFacturadas() == 0) ? '<div class="process-line" style="width: 100%;"></div>' : '' !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="row justify-content-end">
                        <div class="col-3">
                            @if(Auth::user()->id == $operation->user->id || Auth::user()->present()->isAdmin())
                                <button class="btn btn-light dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-file-plus mr-1"></i> Crear solicitud
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    {{ $operation->present()->facturasProveedor() }}
                                    {{ $operation->present()->solicitudGarantias() }}
                                    {{ $operation->present()->solicitudAnticipo() }}
                                    <a class="dropdown-item" data-toggle="modal" data-target="#register-invoice-provider-modal">Crear factura de proveedor</a>
                                     <a class="dropdown-item" data-toggle="modal" data-target="#register-advancerequest-modal">Crear solicitud de anticipo</a>
                                    <a class="dropdown-item" data-toggle="modal" data-target="#register-guaranteerequest-modal">Crear solicitud de garantías</a>
                                </div>
                                <button class="btn btn-light" data-toggle="modal" data-target="#status-operation-expo-modal"><i class="mdi mdi-calendar-edit mr-1"></i> Agregar/Editar fechas</button>
                            @endif
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <h4>Status</h4>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-10 col-md-10 col-sm-11">
                            <div class="horizontal-steps mt-3 mb-4 pb-4">
                                <div class="horizontal-steps-content horizontal-steps-content-alter">
                                    <div class="step-item {{ !$operation->booking_expo ? 'current' : '' }}">
                                        <span></span>
                                    </div>
                                    <div class="step-item {{ $operation->booking_expo && !$operation->conf_booking ? 'current' : '' }}">
                                        <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{ $operation->booking_expo }}"><h5>Booking</h5></span>
                                    </div>
                                    <div class="step-item {{ $operation->conf_booking && !$operation->prog_recoleccion ? 'current' : '' }}">
                                        <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{ $operation->conf_booking }}"><h5>Conf. Booking</h5></span>
                                    </div>
                                    <div class="step-item {{ $operation->prog_recoleccion && !$operation->recoleccion ? 'current' : '' }}">
                                        <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{ $operation->prog_recoleccion }}"><h5>Prog. Recolección</h5></span>
                                    </div>
                                    <div class="step-item {{ $operation->recoleccion && !$operation->llegada_puerto ? 'current' : '' }}">
                                        <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{ $operation->recoleccion }}"><h5>Recolección</h5></span>
                                    </div>
                                    <div class="step-item {{ $operation->llegada_puerto && !$operation->cierre_documental ? 'current' : '' }}">
                                        <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{ $operation->llegada_puerto }}"><h5>Llegada puerto</h5></span>
                                    </div>
                                    <div class="step-item {{ $operation->cierre_documental && !$operation->pesaje ? 'current' : '' }}">
                                        <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{ $operation->cierre_documental }}"><h5>Cierre documental</h5></span>
                                    </div>
                                </div>
                                {!! (!$operation->booking_expo) ? '<div class="process-line" style="width: 0%;"></div>' : '' !!}
                                {!! ($operation->booking_expo) ? '<div class="process-line" style="width: 17%;"></div>' : '' !!}
                                {!! ($operation->conf_booking) ? '<div class="process-line" style="width: 34%;"></div>' : '' !!}
                                {!! ($operation->prog_recoleccion) ? '<div class="process-line" style="width: 50%;"></div>' : '' !!}
                                {!! ($operation->recoleccion) ? '<div class="process-line" style="width: 66%;"></div>' : '' !!}
                                {!! ($operation->llegada_puerto) ? '<div class="process-line" style="width: 83%;"></div>' : '' !!}
                                {!! ($operation->cierre_documental) ? '<div class="process-line" style="width: 100%;"></div>' : '' !!}
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-10 col-md-10 col-sm-11">
                            <div class="horizontal-steps mt-3 mb-4 pb-4">
                                <div class="horizontal-steps-content horizontal-steps-content-alter">
                                    <div class="step-item {{ $operation->pesaje && !$operation->ingreso ? 'current' : '' }}">
                                        <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{ $operation->pesaje }}"><h5>Pesaje</h5></span>
                                    </div>
                                    <div class="step-item {{ $operation->ingreso && !$operation->despacho ? 'current' : '' }}">
                                        <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{ $operation->ingreso }}"><h5>Ingreso</h5></span>
                                    </div>
                                    <div class="step-item {{ $operation->despacho && !$operation->zarpe ? 'current' : '' }}">
                                        <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{ $operation->despacho }}"><h5>Despacho</h5></span>
                                    </div>
                                    <div class="step-item {{ $operation->zarpe && !$operation->envio_papelera ? 'current' : '' }}">
                                        <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{ $operation->zarpe }}"><h5>Zarpe</h5></span>
                                    </div>
                                    <div class="step-item {{ $operation->envio_papelera && ($operation->debitnotes->isEmpty() && $operation->prefactures->isEmpty()) ? 'current' : '' }}">
                                        <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{ $operation->envio_papelera }}"><h5>Envio prealerta</h5></span>
                                    </div>
                                    <div class="step-item {{ ($operation->debitnotes->isNotEmpty() || $operation->prefactures->isNotEmpty()) && $operation->present()->solicitudesNoFacturadas() != 0 ? 'current' : '' }}">
                                        <span><h5>Solicitado<h5>
                                            {{ ($operation->debitnotes->isNotEmpty()) ? 'Debit note' : '' }}
                                            {!! ($operation->debitnotes->isNotEmpty() && $operation->prefactures->isNotEmpty()) ? '<br>' : '' !!}
                                            {{ ($operation->prefactures->isNotEmpty()) ? 'Prefactura' : '' }}
                                        </span>
                                    </div>
                                    <div class="step-item {{ $operation->present()->solicitudesNoFacturadas() == 0 ? 'current' : '' }}">
                                        <span>
                                            <h5 class="text-success">Factura UNMX</h5>
                                        </span>
                                    </div>
                                </div>
                                {!! (!$operation->pesaje) ? '<div class="process-line" style="width: 0%;"></div>' : '' !!}
                                {!! ($operation->ingreso) ? '<div class="process-line" style="width: 17%;"></div>' : '' !!}
                                {!! ($operation->despacho) ? '<div class="process-line" style="width: 34%;"></div>' : '' !!}
                                {!! ($operation->zarpe) ? '<div class="process-line" style="width: 50%;"></div>' : '' !!}
                                {!! ($operation->envio_papelera) ? '<div class="process-line" style="width: 66%;"></div>' : '' !!}
                                {!! ($operation->debitnotes->isNotEmpty() || $operation->prefactures->isNotEmpty()) ? '<div class="process-line" style="width: 83%;"></div>' : '' !!}
                                {!! ($operation->present()->solicitudesNoFacturadas() == 0) ? '<div class="process-line" style="width: 100%;"></div>' : '' !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
    <!-- end row -->

    <div class="row">
        <div class="col-md-6">
            <!-- Operation-Information -->
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-around">
                        <div class="col">
                            <div class="text-left">
                                @if(Auth::user()->id == $operation->user->id || Auth::user()->present()->isAdmin())
                                    <button class="btn btn-light" data-toggle="modal" data-target="#information-operation-modal">
                                        <i class="mdi mdi-file-document mr-1"></i> Editar información
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-right">
                                @if($operation->impo_expo == "IMPO")
                                    @if($operation->containers->isNotEmpty() && !$operation->containers->pluck('dlv_day')->contains(null))
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-warning dropdown-toggle"
                                                    data-toggle="dropdown"
                                                    aria-haspopup="true"
                                                    aria-expanded="false">
                                                    PDF <i class="mdi mdi-file-pdf"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                {{ $operation->present()->debitnotes() }}
                                                {{ $operation->present()->prefactures() }}
                                                <button class="dropdown-item text-primary" data-toggle="modal" data-target="#create-debitnote-modal">Crear Debit Note</button>
                                                <a class="dropdown-item text-primary" data-toggle="modal" data-target="#create-prefactura-modal">Crear Prefactura</a>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-warning dropdown-toggle"
                                                data-toggle="dropdown"
                                                aria-haspopup="true"
                                                aria-expanded="false">
                                                PDF <i class="mdi mdi-file-pdf"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            {{ $operation->present()->housebls() }}
                                            {{ $operation->present()->debitnotes() }}
                                            {{ $operation->present()->prefactures() }}
                                            <a class="dropdown-item text-primary" data-toggle="modal" data-target="#create-hbl-modal">Crear House BL</a>
                                            @if($operation->envio_papelera)
                                                    <a class="dropdown-item text-primary" data-toggle="modal" data-target="#create-debitnote-modal">Crear Debit Note</a>
                                                    <a class="dropdown-item text-primary" data-toggle="modal" data-target="#create-prefactura-modal">Crear Prefactura</a>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-6"><p>Operador:</p></div>
                                <div class="col-6"><h5>{{ $operation->user->name }}</h5></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-6"><p>Master consginee:</p></div>
                                <div class="col-6"><p><b>{{ $operation->master->codigo_cliente }}</b></p></div>
                                <div class="col-6"><p>Shipper</p></div>
                                <div class="col-6"><p><b>{{ $operation->ship->codigo_cliente }}</b></p></div>
                                <div class="col-6"><p>House consignee:</p></div>
                                <div class="col-6"><p><b>{{ $operation->house->codigo_cliente }}</b></p></div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-6 align-items-middle">
                            <div class="row">
                                <div class="col-6"><p>ETD:</p></div>
                                <div class="col-6"><p><b>{{ $operation->etdformat }}</b></p></div>
                                <div class="col-6"><p>Tipo:</p></div>
                                <div class="col-6"><p><b>{{ $operation->impo_expo }}</b></p></div>
                                <div class="col-6"><p>POD:</p></div>
                                <div class="col-6"><p><b>{{ strtoupper($operation->pod) }}</b></p></div>
                                <div class="col-6"><p>Incoterm:</p></div>
                                <div class="col-6"><p><b>{{ strtoupper($operation->incoterm) }}</b></p></div>
                                <div class="col-6"><p>Custom cutoff:</p></div>
                                <div class="col-6"><p><b>{{ $operation->customcutoffformat }}</b></p></div>
                                <div class="col-6"><p>O/F:</p></div>
                                <div class="col-6"><p><b>{{ strtoupper($operation->o_f) }}</b></p></div>
                                <div class="col-6"><p>M B/L:</p></div>
                                <div class="col-6"><p><b>{{ strtoupper($operation->m_bl) }}</b></p></div>
                                <div class="col-6"><p>AA:</p></div>
                                <div class="col-6"><p><b>{{ strtoupper($operation->aa) }}</b></p></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-6"><p>ETA:</p></div>
                                <div class="col-6"><p><b>{{ $operation->etaformat }}</b></p></div>
                                <div class="col-6"><p>POL:</p></div>
                                <div class="col-6"><p><b>{{ strtoupper($operation->pol) }}</b></p></div>
                                <div class="col-6"><p>Destino:</p></div>
                                <div class="col-6"><p><b>{{ strtoupper($operation->destino) }}</b></p></div>
                                <div class="col-6"><p>Booking #:</p></div>
                                <div class="col-6"><p><b>{{ strtoupper($operation->booking) }}</b></p></div>
                                <div class="col-6"><p>Vessel:</p></div>
                                <div class="col-6"><p><b>{{ strtoupper($operation->vessel) }}</b></p></div>
                                <div class="col-6"><p>C. Invoice:</p></div>
                                <div class="col-6"><p><b>{{ strtoupper($operation->c_invoice) }}</b></p></div>
                                <div class="col-6"><p>H B/L:</p></div>
                                <div class="col-6"><p><b>{{strtoupper($operation->h_bl) }}</b></p></div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row justify-content-end">
                        <div class="col-6"></div>
                        <div class="col-3"><p>QTY:</p></div>
                        <div class="col-3"><p><b>{{ count($operation->containers) }}</b></p></div>
                        <div class="col-6"></div>
                        <div class="col-3"><p>Weight:</p></div>
                        <div class="col-3"><p><b>{{ number_format($operation->containers->pluck('weight')->sum(), 2, ".", ",") }} KGS</b></p></div>
                        <div class="col-6"></div>
                        <div class="col-3"><p>Measures:</p></div>
                        <div class="col-3"><p><b>{{ number_format($operation->containers->pluck('measures')->sum(), 2, ".", ",") }} CBM</div></b></p>
                    </div>
                </div>
            </div>
            <!-- Operation-Information -->
        </div> <!-- end col-->

        <div class="col-md-6">
            <div class="row">
                <div class="col-12">
                    <!-- Containers-Information -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                @if(Auth::user()->id == $operation->user->id || Auth::user()->present()->isAdmin())
                                    <div class="col-sm-4">
                                        <button id="btnModal" class="btn btn-primary mb-2" data-toggle="modal" data-target="#register-container-modal"><i class="mdi mdi-plus-circle mr-2"></i> <b>Agregar contenedor</b></button>
                                    </div>
                                @endif
                            </div>
                            <div class="table-responsive-sm">
                                <table id="containers-datatable" class="table table-centered table-striped table-hover table-striped table-striped dt-responsive nowrap w-100 dataTable no-footer dtr-inline">
                                    <thead>
                                        <tr>
                                            <th width="3%">#</th>
                                            <th>Cntr #</th>
                                            <th>Seal No.</th>
                                            <th>Type</th>
                                            <th>Size</th>
                                            <th class="text-center">QTY</th>
                                            <th>Modalidad</th>
                                            @if($operation->impo_expo == "IMPO")
                                                <th>Status</th>
                                            @endif
                                            <th width="5%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($containers as $key => $container)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $container->cntr }}</td>
                                                <td>{{ $container->seal_no }}</td>
                                                <td>{{ $container->type }}</td>
                                                <td>{{ $container->size }}</td>
                                                <td class="text-center">{{ $container->qty }}</td>
                                                <td>{{ $container->modalidad }}</td>
                                                @if($operation->impo_expo == "IMPO")
                                                    <td>{{ $container->present()->statusBadge() }}</td>
                                                @endif
                                                <td>
                                                    @if(!$container->canceled_at)
                                                         <button type="button" class="btn btn-link action-icon"
                                                            data-toggle="tooltip" data-placemente="top" data-original-title="Editar información"
                                                            onclick="information_container_modal({{ $container->id }});"><i class="mdi mdi-square-edit-outline"></i></a>
                                                        {{-- <form id="delete-container" style="display: inline;" action="{{ route('contenedores.destroy', $container->id) }}" method="POST">
                                                            {!! csrf_field() !!}
                                                            {!! method_field('DELETE') !!} --}}
                                                            <button onclick="delete_container_modal({{ $container->id }})" type="submit" class="btn btn-link action-icon"
                                                                data-toggle="tooltip" data-placemente="top" data-original-title="Eliminar contenedor"><i class="mdi mdi-delete"></i></button>
                                                        {{-- </form> --}}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Containers-Information -->
                </div>
                <div class="col-12">
                    <!-- Containers-Information -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-around">
                        <div class="col">
                            <div class="text-left">
                                @if(Auth::user()->id == $operation->user->id || Auth::user()->present()->isAdmin())
                                    <button data-toggle="modal" data-target="#notes-operation-modal" class="btn btn-light"><i class="mdi mdi-note-text"></i> Agregar/Editar notas</button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-4"><p>Notas:</p></div>
                                <div class="col-8"><h5>{{ $operation->notes }}</h5></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div> <!-- container -->

<!-- Start Modals    -->
    <div id="status-operation-impo-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Información de la operación</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('operaciones.updatestatus', $operation->id) }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        {!! method_field('PUT') !!}
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Recibir</label>
                                    <input class="form-control {{ $errors->has('recibir') ? ' is-invalid' : '' }}" type="date" name="recibir" value="{{ $operation->recibir }}">
                                    @if ($errors->has('recibir'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('recibir') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Revisión</label>
                                    <input class="form-control {{ $errors->has('revision') ? ' is-invalid' : '' }}" type="date" name="revision" value="{{ $operation->revision }}">
                                    @if ($errors->has('revision'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('revision') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Mandar</label>
                                    <input class="form-control {{ $errors->has('mandar') ? ' is-invalid' : '' }}" type="date" name="mandar" value="{{ $operation->mandar }}">
                                    @if ($errors->has('mandar'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('mandar') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Revalidación</label>
                                    <input class="form-control {{ $errors->has('revalidacion') ? ' is-invalid' : '' }}" type="date" name="revalidacion" value="{{ $operation->revalidacion }}">
                                    @if ($errors->has('revalidacion'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('revalidacion') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Toca piso</label>
                                    <input class="form-control {{ $errors->has('toca_piso') ? ' is-invalid' : '' }}" type="date" name="toca_piso" value="{{ $operation->toca_piso }}">
                                    @if ($errors->has('toca_piso'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('toca_piso') }}</strong>
                                        </span>
                                    @endif
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

    <div id="status-operation-expo-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Información de la operación</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('operaciones.updatestatus', $operation->id) }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        {!! method_field('PUT') !!}
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Booking</label>
                                    <input class="form-control {{ $errors->has('booking_expo') ? ' is-invalid' : '' }}" type="date" name="booking_expo" value="{{ $operation->booking_expo }}">
                                    @if ($errors->has('booking_expo'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('booking_expo') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Confirmación de booking</label>
                                    <input class="form-control {{ $errors->has('conf_booking') ? ' is-invalid' : '' }}" type="date" name="conf_booking" value="{{ $operation->conf_booking }}">
                                    @if ($errors->has('conf_booking'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('conf_booking') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Programación de recolección</label>
                                    <input class="form-control {{ $errors->has('prog_recoleccion') ? ' is-invalid' : '' }}" type="date" name="prog_recoleccion" value="{{ $operation->prog_recoleccion }}">
                                    @if ($errors->has('prog_recoleccion'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('prog_recoleccion') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Recolección</label>
                                    <input class="form-control {{ $errors->has('recoleccion') ? ' is-invalid' : '' }}" type="date" name="recoleccion" value="{{ $operation->recoleccion }}">
                                    @if ($errors->has('recoleccion'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('recoleccion') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Llegada puerto</label>
                                    <input class="form-control {{ $errors->has('llegada_puerto') ? ' is-invalid' : '' }}" type="date" name="llegada_puerto" value="{{ $operation->llegada_puerto }}">
                                    @if ($errors->has('llegada_puerto'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('llegada_puerto') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Cierre documental</label>
                                    <input class="form-control {{ $errors->has('cierre_documental') ? ' is-invalid' : '' }}" type="date" name="cierre_documental" value="{{ $operation->cierre_documental }}">
                                    @if ($errors->has('cierre_documental'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('cierre_documental') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Pesaje</label>
                                    <input class="form-control {{ $errors->has('pesaje') ? ' is-invalid' : '' }}" type="date" name="pesaje" value="{{ $operation->pesaje }}">
                                    @if ($errors->has('pesaje'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('pesaje') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Ingreso</label>
                                    <input class="form-control {{ $errors->has('ingreso') ? ' is-invalid' : '' }}" type="date" name="ingreso" value="{{ $operation->ingreso }}">
                                    @if ($errors->has('ingreso'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('ingreso') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Despacho</label>
                                    <input class="form-control {{ $errors->has('despacho') ? ' is-invalid' : '' }}" type="date" name="despacho" value="{{ $operation->despacho }}">
                                    @if ($errors->has('despacho'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('despacho') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Zarpe</label>
                                    <input class="form-control {{ $errors->has('zarpe') ? ' is-invalid' : '' }}" type="date" name="zarpe" value="{{ $operation->zarpe }}">
                                    @if ($errors->has('zarpe'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('zarpe') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Envio prealerta</label>
                                    <input class="form-control {{ $errors->has('envio_papelera') ? ' is-invalid' : '' }}" type="date" name="envio_papelera" value="{{ $operation->envio_papelera }}">
                                    @if ($errors->has('envio_papelera'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('envio_papelera') }}</strong>
                                        </span>
                                    @endif
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

     <div id="register-invoice-provider-modal" class="modal fade" tabindex="" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Registro de factura</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="register-invoice-provider-form" method="POST" action="{{ route('facturasproveedor.store') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        <input type="hidden" name="operation_id" value="{{ $operation->id }}">
                        <input type="hidden" name="client_id" value="{{ $operation->house->id }}">
                        <input type="hidden" name="guarantee_request" value="">
                        <input type="hidden" name="advance_request" value="">
                        <div class="row">
                             <div class="col-7">
                                <div class="form-group">
                                    <label>Proveedor <span class="text-danger">*</span></label>
                                    <select class="form-control select2{{ $errors->has('provider_id') ? ' is-invalid' : '' }}" name="provider_id" data-toggle="select2" required="" onchange="search_accounts()">
                                        <option value="">Selecciona...</option>
                                        @foreach($providers as $provider)
                                            <option value="{{ $provider->id }}">{{ $provider->codigo_proveedor }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                             <div class="col-2">
                                <div class="form-group">
                                    <label>Folio <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control {{ $errors->has('factura') ? ' is-invalid' : '' }}" name="factura" required="">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Invoice date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control {{ $errors->has('invoice_date') ? ' is-invalid' : '' }}" name="invoice_date" required="">
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="form-group">
                                    <label>Expense type <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control {{ $errors->has('expense_tipe') ? ' is-invalid' : '' }}" name="expense_tipe" value="Freight Expenses" required="">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Expense description <span class="text-danger">*</span></label>
                                    <select class="form-control select2{{ $errors->has('expense_description') ? ' is-invalid' : '' }}" name="expense_description" data-toggle="select2" required="">
                                        <option value="INVOICE" selected>INVOICE</option>
                                        <option value="INVOICE EXTRANJERO">INVOICE EXTRANJERO</option>
                                        <option value="DEBIT NOTE">DEBIT NOTE</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Cuenta <span class="text-danger">*</span></label>
                                    <select class="form-control select2{{ $errors->has('account_bank') ? ' is-invalid' : '' }}" name="account_provider_id" data-toggle="select2" required="">
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Neto <span class="text-danger">*</span></label>
                                    <input type="number" step="any" class="form-control {{ $errors->has('neto') ? ' is-invalid' : '' }}" name="neto" required="" onchange="calcularTotal()">
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
                            <div class="col-3">
                                <hr>
                                <br>
                                <div class="form-group">
                                    <label>M B/L <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " required name="m_bl" value="{{ $operation->m_bl }}" required="">
                                </div>
                            </div>
                            <div class="col-3">
                                <hr>
                                <br>
                                <div class="form-group">
                                    <label>H B/L <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " required name="h_bl" value="{{ $operation->h_bl }}" required="">
                                </div>
                            </div>
                            <div class="col-3">
                                <hr>
                                <br>
                                <div class="form-group">
                                    <label>ETA <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control " required name="eta" value="{{ $operation->eta }}" required="">
                                </div>
                            </div>
                            <div class="col-3">
                                <hr>
                                <br>
                            </div>
                            <div class="col-12">
                            <br>
                            <label>Conceptos</label>
                            <table id="conceptsTable" class="table table-sm">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th width="40%">Description</th>
                                        <th width="15%">Curr</th>
                                        <th>Rate</th>
                                        <th width="5%">Iva</th>
                                        <th width="11%">Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($conceptsinvoices as $conceptinvoices)
                                        <tr>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="checkconceptinvoices{{ $conceptinvoices->id }}" value="{{ $conceptinvoices->id }}" name="conceptsinvoices[]">
                                                    <label class="custom-control-label" for="checkconceptinvoices{{ $conceptinvoices->id }}">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td>{{ $conceptinvoices->description }}</td>
                                            <td>
                                                <select name="curr[]" class="form-control select2" data-toggle="select2">
                                                    <option value="MXN" {{ $conceptinvoices->curr == "MXN" ? 'selected' : ''}}>MXN</option>
                                                    <option value="USD" {{ $conceptinvoices->curr == "USD" ? 'selected' : ''}}>USD</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" name="rates[]" step="any" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="ivaconceptinvoices[]" class="custom-control-input" id="checkivainvoices{{ $conceptinvoices->id }}" value="{{ $conceptinvoices->id }}">
                                                    <label class="custom-control-label" for="checkivainvoices{{ $conceptinvoices->id }}">&nbsp;</label>
                                                </div>
                                                {{-- <input type="number" name="iva[]" step="any" class="form-control form-control-sm" value="0"> --}}
                                            </td>
                                            <td>
                                                <input type="number" name="qty[]" step="any" class="form-control form-control-sm" value="1">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <hr>
                            </div>
                            <div class="col-8">

                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Prioridad</label>
                                    <select class="form-control select2" data-toggle="select2" type="text" name="priority">
                                        <option value="3">Baja</option>
                                        <option value="2">Media</option>
                                        <option value="1">Alta</option>
                                    </select>
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

    <div id="register-guaranteerequest-modal" class="modal fade" tabindex="" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Solicitud de garantía</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="register-guaranteerequest-form" method="POST" action="{{ route('facturasproveedor.store') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        <input type="hidden" name="operation_id" value="{{ $operation->id }}">
                        <input type="hidden" name="client_id" value="{{ $operation->house->id }}">
                        <?php
                            use Carbon\Carbon;
                        ?>
                        <input type="hidden" name="guarantee_request" value="{{ Carbon::now() }}">
                        <input type="hidden" name="advance_request" value="">
                        <div class="row">
                             <div class="col-7">
                                <div class="form-group">
                                    <label>Proveedor <span class="text-danger">*</span></label>
                                    <select class="form-control select2{{ $errors->has('provider_id') ? ' is-invalid' : '' }}" name="provider_id" data-toggle="select2" required="" onchange="search_accounts()">
                                        <option value="">Selecciona...</option>
                                        @foreach($providers as $provider)
                                            <option value="{{ $provider->id }}">{{ $provider->codigo_proveedor }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                             <div class="col-2">
                                <div class="form-group">
                                    <label>Folio</label>
                                    <input type="text" class="form-control {{ $errors->has('factura') ? ' is-invalid' : '' }}" name="factura">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Invoice date</label>
                                    <input type="date" class="form-control {{ $errors->has('invoice_date') ? ' is-invalid' : '' }}" name="invoice_date">
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="form-group">
                                    <label>Expense type <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control {{ $errors->has('expense_tipe') ? ' is-invalid' : '' }}" name="expense_tipe" value="Advanced Payment" required="">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Expense description <span class="text-danger">*</span></label>
                                    <select class="form-control select2{{ $errors->has('expense_description') ? ' is-invalid' : '' }}" name="expense_description" data-toggle="select2" required="">
                                        <option value="INVOICE" selected>INVOICE</option>
                                        <option value="INVOICE EXTRANJERO">INVOICE EXTRANJERO</option>
                                        <option value="DEBIT NOTE">DEBIT NOTE</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Cuenta <span class="text-danger">*</span></label>
                                    <select class="form-control select2{{ $errors->has('account_bank') ? ' is-invalid' : '' }}" name="account_provider_id" data-toggle="select2" required="">
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Neto <span class="text-danger">*</span></label>
                                    <input type="number" step="any" class="form-control {{ $errors->has('neto') ? ' is-invalid' : '' }}" name="neto" required="" onchange="calcularTotal()">
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
                            <div class="col-3">
                                <hr>
                                <br>
                                <div class="form-group">
                                    <label>M B/L <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " required name="m_bl" value="{{ $operation->m_bl }}" required="">
                                </div>
                            </div>
                            <div class="col-3">
                                <hr>
                                <br>
                                <div class="form-group">
                                    <label>H B/L <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " required name="h_bl" value="{{ $operation->h_bl }}" required="">
                                </div>
                            </div>
                            <div class="col-3">
                                <hr>
                                <br>
                                <div class="form-group">
                                    <label>ETA <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control " required name="eta" value="{{ $operation->eta }}" required="">
                                </div>
                            </div>
                            <div class="col-3">
                                <hr>
                                <br>
                            </div>
                            <div class="col-12">
                            <br>
                            <label>Conceptos</label>
                            <table id="conceptsTable" class="table table-sm">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th width="40%">Description</th>
                                        <th width="15%">Curr</th>
                                        <th>Rate</th>
                                        <th width="5%">Iva</th>
                                        <th width="11%">Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($conceptsinvoices as $conceptinvoices)
                                        <tr>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="checkconceptguarantee{{ $conceptinvoices->id }}" value="{{ $conceptinvoices->id }}" name="conceptsguarantee[]">
                                                    <label class="custom-control-label" for="checkconceptguarantee{{ $conceptinvoices->id }}">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td>{{ $conceptinvoices->description }}</td>
                                            <td>
                                                <select name="curr[]" class="form-control select2" data-toggle="select2">
                                                    <option value="MXN" {{ $conceptinvoices->curr == "MXN" ? 'selected' : ''}}>MXN</option>
                                                    <option value="USD" {{ $conceptinvoices->curr == "USD" ? 'selected' : ''}}>USD</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" name="rates[]" step="any" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="ivaconceptguarantee[]" class="custom-control-input" id="checkivainvoices{{ $conceptinvoices->id }}" value="{{ $conceptinvoices->id }}">
                                                    <label class="custom-control-label" for="checkivaguarantee{{ $conceptinvoices->id }}">&nbsp;</label>
                                                </div>
                                                {{-- <input type="number" name="iva[]" step="any" class="form-control form-control-sm" value="0"> --}}
                                            </td>
                                            <td>
                                                <input type="number" name="qty[]" step="any" class="form-control form-control-sm" value="1">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <hr>
                            </div>
                            <div class="col-8">

                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Prioridad</label>
                                    <select class="form-control select2" data-toggle="select2" type="text" name="priority">
                                        <option value="3">Baja</option>
                                        <option value="2">Media</option>
                                        <option value="1">Alta</option>
                                    </select>
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

    <div id="register-advancerequest-modal" class="modal fade" tabindex="" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Solicitud de anticipo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="register-advancerequest-form" method="POST" action="{{ route('facturasproveedor.store') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        <input type="hidden" name="operation_id" value="{{ $operation->id }}">
                        <input type="hidden" name="client_id" value="{{ $operation->house->id }}">
                        <input type="hidden" name="guarantee_request" value="">
                        <input type="hidden" name="advance_request" value="{{ Carbon::now() }}">
                        <div class="row">
                             <div class="col-7">
                                <div class="form-group">
                                    <label>Proveedor <span class="text-danger">*</span></label>
                                    <select class="form-control select2{{ $errors->has('provider_id') ? ' is-invalid' : '' }}" name="provider_id" data-toggle="select2" required="" onchange="search_accounts()">
                                        <option value="">Selecciona...</option>
                                        @foreach($providers as $provider)
                                            <option value="{{ $provider->id }}">{{ $provider->codigo_proveedor }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                             <div class="col-2">
                                <div class="form-group">
                                    <label>Folio</label>
                                    <input type="text" class="form-control {{ $errors->has('factura') ? ' is-invalid' : '' }}" name="factura">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Invoice date</label>
                                    <input type="date" class="form-control {{ $errors->has('invoice_date') ? ' is-invalid' : '' }}" name="invoice_date">
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="form-group">
                                    <label>Expense type <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control {{ $errors->has('expense_tipe') ? ' is-invalid' : '' }}" name="expense_tipe" value="Advanced Payment" required="">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Expense description <span class="text-danger">*</span></label>
                                    <select class="form-control select2{{ $errors->has('expense_description') ? ' is-invalid' : '' }}" name="expense_description" data-toggle="select2" required="">
                                        <option value="INVOICE" selected>INVOICE</option>
                                        <option value="INVOICE EXTRANJERO">INVOICE EXTRANJERO</option>
                                        <option value="DEBIT NOTE">DEBIT NOTE</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Cuenta <span class="text-danger">*</span></label>
                                    <select class="form-control select2{{ $errors->has('account_bank') ? ' is-invalid' : '' }}" name="account_provider_id" data-toggle="select2" required="">
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Neto <span class="text-danger">*</span></label>
                                    <input type="number" step="any" class="form-control {{ $errors->has('neto') ? ' is-invalid' : '' }}" name="neto" required="" onchange="calcularTotal()">
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
                            <div class="col-3">
                                <hr>
                                <br>
                                <div class="form-group">
                                    <label>M B/L <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " required name="m_bl" value="{{ $operation->m_bl }}" required="">
                                </div>
                            </div>
                            <div class="col-3">
                                <hr>
                                <br>
                                <div class="form-group">
                                    <label>H B/L <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " required name="h_bl" value="{{ $operation->h_bl }}" required="">
                                </div>
                            </div>
                            <div class="col-3">
                                <hr>
                                <br>
                                <div class="form-group">
                                    <label>ETA <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control " required name="eta" value="{{ $operation->eta }}" required="">
                                </div>
                            </div>
                            <div class="col-3">
                                <hr>
                                <br>
                            </div>
                            <div class="col-12">
                            <br>
                            <label>Conceptos</label>
                            <table id="conceptsTable" class="table table-sm">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th width="40%">Description</th>
                                        <th width="15%">Curr</th>
                                        <th>Rate</th>
                                        <th width="5%">Iva</th>
                                        <th width="11%">Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($conceptsinvoices as $conceptinvoices)
                                        <tr>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="checkconceptadvance{{ $conceptinvoices->id }}" value="{{ $conceptinvoices->id }}" name="conceptsadvance[]">
                                                    <label class="custom-control-label" for="checkconceptadvance{{ $conceptinvoices->id }}">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td>{{ $conceptinvoices->description }}</td>
                                            <td>
                                                <select name="curr[]" class="form-control select2" data-toggle="select2">
                                                    <option value="MXN" {{ $conceptinvoices->curr == "MXN" ? 'selected' : ''}}>MXN</option>
                                                    <option value="USD" {{ $conceptinvoices->curr == "USD" ? 'selected' : ''}}>USD</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" name="rates[]" step="any" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="ivaconceptadvance[]" class="custom-control-input" id="checkivainvoices{{ $conceptinvoices->id }}" value="{{ $conceptinvoices->id }}">
                                                    <label class="custom-control-label" for="checkivaadvance{{ $conceptinvoices->id }}">&nbsp;</label>
                                                </div>
                                                {{-- <input type="number" name="iva[]" step="any" class="form-control form-control-sm" value="0"> --}}
                                            </td>
                                            <td>
                                                <input type="number" name="qty[]" step="any" class="form-control form-control-sm" value="1">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <hr>
                            </div>
                            <div class="col-8">

                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Prioridad</label>
                                    <select class="form-control select2" data-toggle="select2" type="text" name="priority">
                                        <option value="3">Baja</option>
                                        <option value="2">Media</option>
                                        <option value="1">Alta</option>
                                    </select>
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

    <div id="information-operation-modal" class="modal fade" tabindex="" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Información de operación</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('operaciones.update', $operation->id) }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        {!! method_field('PUT') !!}
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Shipper <span class="text-danger">*</span></label>
                                    <select class="form-control select2{{ $errors->has('shipper') ? ' is-invalid' : '' }}" type="text" name="shipper" id="shipper" value="{{ $operation->shipper }}" data-toggle="select2">
                                        @foreach($clients as $client)
                                            @if($client->id == $operation->shipper)
                                                <option value="{{ $operation->shipper }}" selected>{{ $client->codigo_cliente }}</option>
                                            @endif
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
                                    <select class="form-control select2{{ $errors->has('master_consignee') ? ' is-invalid' : '' }}" type="text" name="master_consignee" id="master_consignee" value="{{ $operation->master_consignee }}" data-toggle="select2">
                                        @foreach($clients as $client)
                                            @if($client->id == $operation->master_consignee)
                                                <option value="{{ $operation->master_consignee }}" selected>{{ $client->codigo_cliente }}</option>
                                            @endif
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
                                    <select class="form-control select2{{ $errors->has('house_consignee') ? ' is-invalid' : '' }}" type="text" name="house_consignee" id="house_consignee" value="{{ $operation->house_consignee }}" data-toggle="select2">
                                        @foreach($clients as $client)
                                            @if($client->id == $operation->house_consignee)
                                                <option value="{{ $operation->house_consignee }}" selected>{{ $client->codigo_cliente }}</option>
                                            @endif
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
                                    {{-- <input class="form-control {{ $errors->has('etd') ? ' is-invalid' : '' }}" type="date" name="etd" value="{{ $operation->etd }}"> --}}
                                    <input type="text" name="etd" class="form-control date {{ $errors->has('etd') ? ' is-invalid' : '' }}" id="birthdatepicker" data-toggle="date-picker" data-single-date-picker="true" value="{{ Carbon::parse($operation->etd)->format('m/d/Y') }}">
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
                                    {{-- <input class="form-control {{ $errors->has('eta') ? ' is-invalid' : '' }}" type="date" name="eta" value="{{ $operation->eta }}"> --}}
                                    <input type="text" name="eta" class="form-control date {{ $errors->has('eta') ? ' is-invalid' : '' }}" id="birthdatepicker" data-toggle="date-picker" data-single-date-picker="true" value="{{ Carbon::parse($operation->eta)->format('m/d/Y') }}">
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
                                    {{-- <input type="text" class="form-control {{ $errors->has('impo_expo') ? ' is-invalid' : '' }}" value="{{ $operation->impo_expo }}"  name="impo_expo"> --}}
                                    <select type="text" class="form-control select2{{ $errors->has('impo_expo') ? ' is-invalid' : '' }}" value="{{ old('impo_expo') }}"  name="impo_expo" id="impo_expo" data-toggle="select2">
                                        <option value="IMPO" {{ $operation->impo_expo == "IMPO" ? 'selected' : ''}}>IMPO</option>
                                        <option value="EXPO" {{ $operation->impo_expo == "EXPO" ? 'selected' : ''}}>EXPO</option>
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
                                    <input type="text" class="form-control {{ $errors->has('pol') ? ' is-invalid' : '' }}" value="{{ $operation->pol }}"  name="pol">
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
                                    <input type="text" class="form-control {{ $errors->has('pod') ? ' is-invalid' : '' }}" value="{{ $operation->pod }}"  name="pod">
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
                                    <input type="text" class="form-control {{ $errors->has('destino') ? ' is-invalid' : '' }}" value="{{ $operation->destino }}"  name="destino">
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
                                    <input type="text" class="form-control {{ $errors->has('incoterm') ? ' is-invalid' : '' }}" value="{{ $operation->incoterm }}"  name="incoterm">
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
                                    <input type="text" class="form-control {{ $errors->has('booking') ? ' is-invalid' : '' }}" value="{{ $operation->booking }}"  name="booking">
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
                                    <input type="date" class="form-control {{ $errors->has('custom_cutoff') ? ' is-invalid' : '' }}" value="{{ $operation->custom_cutoff }}"  name="custom_cutoff">
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
                                    <input type="text" class="form-control {{ $errors->has('vessel') ? ' is-invalid' : '' }}" value="{{ $operation->vessel }}"  name="vessel">
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
                                    <input type="text" class="form-control {{ $errors->has('o_f') ? ' is-invalid' : '' }}" value="{{ $operation->o_f }}"  name="o_f">
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
                                    <input type="text" class="form-control {{ $errors->has('aa') ? ' is-invalid' : '' }}" value="{{ $operation->aa }}"  name="aa">
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
                                    <input type="text" class="form-control {{ $errors->has('m_bl') ? ' is-invalid' : '' }}" value="{{ $operation->m_bl }}"  name="m_bl">
                                    @if ($errors->has('m_bl'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('m_bl') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>C. Invoice <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control {{ $errors->has('c_invoice') ? ' is-invalid' : '' }}" value="{{ $operation->c_invoice }}"  name="c_invoice">
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
                                    <input type="text" class="form-control {{ $errors->has('h_bl') ? ' is-invalid' : '' }}" value="{{ $operation->h_bl }}"  name="h_bl">
                                    @if ($errors->has('h_bl'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('h_bl') }}</strong>
                                        </span>
                                    @endif
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

    <div id="register-container-modal" class="modal fade" tabindex="" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Registro de contenedor</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('contenedores.store') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        <input type="hidden" name="operation_id" value="{{ $operation->id }}">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label id="cntr_container_label">CNTR # <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " id="cntr_container" required name="cntr">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label id="sealno_container_label">Seal No. <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " id="sealno_container" required name="seal_no">
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label>Type <span class="text-danger">*</span></label>
                                    <select type="text" class="form-control select2" data-toggle="select2" id="type_container" onchange="container_required()" required name="type">
                                        <option value="FCL">FCL</option>
                                        <option value="LCL">LCL</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Size <span class="text-danger">*</span></label>
                                    <select type="text" class="form-control select2" data-toggle="select2" required name="size">
                                        <option value="20 DV">20 DV</option>
                                        <option value="20 FT">20 FT</option>
                                        <option value="40 DV">40 DV</option>
                                        <option value="40 HQ">40 HQ</option>
                                        <option value="40 FR">40 FR</option>
                                        <option value="40 OT">40 OT</option>
                                        <option value="Pallet">Pallet</option>
                                        <option value="Package">Package</option>
                                        <option value="Box">Box</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>QTY <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " required name="qty">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Modalidad <span class="text-danger">*</span></label>
                                    <select type="text" class="form-control select2" data-toggle="select2" required name="modalidad">
                                        <option value="Rail & Truck">Rail & Truck</option>
                                        <option value="Truck">Truck</option>
                                        <option value="Dedicado">Dedicado</option>
                                        <option value="Consolidado">Consolidado</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Weight <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " required name="weight">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Measures <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " required name="measures">
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

    <div id="information-container-modal" class="modal fade" tabindex="" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Información de contenedor</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="infoContainerForm" method="POST" action="{{ route('contenedores.modificar') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        <input type="hidden" name="container_id" value="">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label id="cntr_container_label2">CNTR # <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " id="cntr_container2" required value=""  name="cntr">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label id="sealno_container_label2">Seal No. <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " id="sealno_container2" required value=""  name="seal_no">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Type <span class="text-danger">*</span></label>
                                    <select type="text" class="form-control select2" id="type_container2" data-toggle="select2" onchange="container_required2()" required value=""  name="type">
                                        <option value="FCL">FCL</option>
                                        <option value="LCL">LCL</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Size <span class="text-danger">*</span></label>
                                    <select type="text" class="form-control select2" data-toggle="select2" required value=""  name="size">
                                        <option value="20 DV">20 DV</option>
                                        <option value="20 FT">20 FT</option>
                                        <option value="40 DV">40 DV</option>
                                        <option value="40 HQ">40 HQ</option>
                                        <option value="40 FR">40 FR</option>
                                        <option value="40 OT">40 OT</option>
                                        <option value="Pallet">Pallet</option>
                                        <option value="Package">Package</option>
                                        <option value="Box">Box</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>QTY <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " required value=""  name="qty">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Modalidad <span class="text-danger">*</span></label>
                                    <select type="text" class="form-control select2" data-toggle="select2" required value=""  name="modalidad">
                                        <option value="Rail & Truck">Rail & Truck</option>
                                        <option value="Truck">Truck</option>
                                        <option value="Dedicado">Dedicado</option>
                                        <option value="Consolidado">Consolidado</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Weight <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " required value=""  name="weight">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Measures <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " required value=""  name="measures">
                                </div>
                            </div>
                            <div class="col-4"></div>
                            <hr>
                            @if($operation->impo_expo == "IMPO")
                                <div class="col-4">
                                    <br>
                                    <div class="form-group">
                                        <label>Proforma</label>
                                        <input type="date" class="form-control "  name="proforma" value="">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <br>
                                    <div class="form-group">
                                        <label>Pago proforma</label>
                                        <input type="date" class="form-control "  name="pago_proforma" value="">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <br>
                                    <div class="form-group">
                                        <label>Despachado puerto</label>
                                        <input type="date" class="form-control " value=""  name="despachado_puerto">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Solicitud transporte</label>
                                        <input type="date" class="form-control " value=""  name="solicitud_transporte">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Port etd</label>
                                        <input type="date" class="form-control " value=""  name="port_etd">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Dlv day</label>
                                        <input type="date" class="form-control " value=""  name="dlv_day">
                                    </div>
                                </div>
                                {{-- <div class="col-4">
                                    <div class="form-group">
                                        <label>Factura Unmx</label>
                                        <input type="date" class="form-control " value=""  name="factura_unmx">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Fecha factura</label>
                                        <input type="date" class="form-control " value=""  name="fecha_factura">
                                    </div>
                                </div> --}}
                            @endif
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

    <div id="delete-container-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-warning h1 text-danger"></i>
                        <h4 class="mt-2">Precaución!</h4>
                        <p class="mt-3">¿Está seguro(a) de eliminar la información del contenedor?</p>
                        <button type="button" class="btn btn-light my-2" data-dismiss="modal">Cancelar</button>
                        <form id="delete_container_form" style="display: inline;" action="{{ route('contenedores.destroy', $operation->id) }}" method="POST">
                            {!! csrf_field() !!}
                            {!! method_field('DELETE') !!}
                            <input type="hidden" name="container_id">
                            <button type="sumbit" class="btn btn-danger my-2">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div>
    </div>

    <div id="create-prefactura-modal" class="modal fade" tabindex="" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Creación de prefactura</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="createPrefacturaForm" method="POST" action="{{ route('prefacturas.store') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        <input type="hidden" name="operation_id" value="{{ $operation->id }}">
                        <div class="row">
                            <div class="col-8">
                                <div class="form-group">
                                    <label>Cliente <span class="text-danger">*</span></label>
                                    <select class="form-control select2" data-toggle="select2" type="text" name="client_id" value="{{ $operation->client_id }}" required>
                                        <option value="">Selecciona...</option>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->razon_social }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <br>
                                <label>Conceptos</label>
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th width="40%">Description</th>
                                            <th width="15%">Curr</th>
                                            <th>Rate</th>
                                            <th width="5%">Iva</th>
                                            <th width="11%">Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($concepts as $concept)
                                            <tr>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="checkconcept2{{ $concept->id }}" value="{{ $concept->id }}" name="concepts[]">
                                                        <label class="custom-control-label" for="checkconcept2{{ $concept->id }}">&nbsp;</label>
                                                    </div>
                                                </td>
                                                <td>{{ $concept->description }}</td>
                                                <td>
                                                    <select name="curr[]" class="form-control select2" data-toggle="select2">
                                                        <option value="MXN" {{ $concept->curr == "MXN" ? 'selected' : ''}}>MXN</option>
                                                        <option value="USD" {{ $concept->curr == "USD" ? 'selected' : ''}}>USD</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="rates[]" step="any" class="form-control form-control-sm">
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="ivaConcept[]" class="custom-control-input" id="checkiva2{{ $concept->id }}" value="{{ $concept->id }}">
                                                        <label class="custom-control-label" for="checkiva2{{ $concept->id }}">&nbsp;</label>
                                                    </div>
                                                    {{-- <input type="number" name="iva[]" step="any" class="form-control form-control-sm" value="0"> --}}
                                                </td>
                                                <td>
                                                    <input type="number" name="qty[]" step="any" class="form-control form-control-sm" value="1">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-8">

                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Prioridad</label>
                                    <select class="form-control select2" data-toggle="select2" type="text" name="priority">
                                        <option value="3">Baja</option>
                                        <option value="2">Media</option>
                                        <option value="1">Alta</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="text-right pb-4 pr-4">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><b>Crear</b></button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div id="create-debitnote-modal" class="modal fade" tabindex="" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Creación de debit note</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="createDebitnoteForm" method="POST" action="{{ route('debitnotes.store') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        <input type="hidden" name="operation_id" value="{{ $operation->id }}">
                        <div class="row">
                            <div class="col-8">
                                <div class="form-group">
                                    <label>Cliente <span class="text-danger">*</span></label>
                                    <select class="form-control select2" data-toggle="select2" type="text" name="client_id" value="{{ $operation->client_id }}" required>
                                        <option value="">Selecciona...</option>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->razon_social }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <br>
                                <label>Conceptos</label>
                                <table id="conceptsTable" class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th width="40%">Description</th>
                                            <th width="15%">Curr</th>
                                            <th>Rate</th>
                                            <th width="5%">Iva</th>
                                            <th width="11%">Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($concepts as $concept)
                                            <tr>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="checkconcept{{ $concept->id }}" value="{{ $concept->id }}" name="concepts[]">
                                                        <label class="custom-control-label" for="checkconcept{{ $concept->id }}">&nbsp;</label>
                                                    </div>
                                                </td>
                                                <td>{{ $concept->description }}</td>
                                                <td>
                                                    <select name="curr[]" class="form-control select2" data-toggle="select2">
                                                        <option value="MXN" {{ $concept->curr == "MXN" ? 'selected' : ''}}>MXN</option>
                                                        <option value="USD" {{ $concept->curr == "USD" ? 'selected' : ''}}>USD</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="rates[]" step="any" class="form-control form-control-sm">
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="ivaConcept[]" class="custom-control-input" id="checkiva{{ $concept->id }}" value="{{ $concept->id }}">
                                                        <label class="custom-control-label" for="checkiva{{ $concept->id }}">&nbsp;</label>
                                                    </div>
                                                    {{-- <input type="number" name="iva[]" step="any" class="form-control form-control-sm" value="0"> --}}
                                                </td>
                                                <td>
                                                    <input type="number" name="qty[]" step="any" class="form-control form-control-sm" value="1">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                            <div class="col-8">

                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Prioridad</label>
                                    <select class="form-control select2" data-toggle="select2" type="text" name="priority">
                                        <option value="3">Baja</option>
                                        <option value="2">Media</option>
                                        <option value="1">Alta</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="text-right pb-4 pr-4">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><b>Crear</b></button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div id="create-hbl-modal" class="modal fade" tabindex="" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Creación de House BL</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="createHouseblForm" method="POST" action="{{ route('housebls.store') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        <input type="hidden" name="operation_id" value="{{ $operation->id }}">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Shipper <span class="text-danger">*</span></label>
                                    <select class="form-control select2{{ $errors->has('shipper') ? ' is-invalid' : '' }}" data-toggle="select2" type="text" name="shipper">
                                        @foreach($clients as $client)
                                            @if($client->id == $operation->shipper)
                                                <option value="{{ $operation->shipper }}" selected>{{ $client->codigo_cliente }}</option>
                                            @endif
                                                <option value="{{ $client->id }}">{{ $client->codigo_cliente }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>House consignee <span class="text-danger">*</span></label>
                                    <select class="form-control select2{{ $errors->has('house_consignee') ? ' is-invalid' : '' }}" type="text" name="house_consignee" data-toggle="select2">
                                        @foreach($clients as $client)
                                            @if($client->id == $operation->house_consignee)
                                                <option value="{{ $operation->house_consignee }}" selected>{{ $client->codigo_cliente }}</option>
                                            @endif
                                                <option value="{{ $client->id }}">{{ $client->codigo_cliente }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Notify Party <span class="text-danger">*</span></label>
                                    <textarea class="form-control " type="text" name="notify_party"></textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>No. Pkgs <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " type="text" name="no_pkgs">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Cargo Type <span class="text-danger">*</span></label>
                                    <select class="form-control select2" data-toggle="select2" type="text" name="cargo_type">
                                        <option value="EMPTY">EMPTY</option>
                                        <option value="FCL">FCL</option>
                                        <option value="LCL">LCL</option>
                                        <option value="BULK">BULK</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Freight Term <span class="text-danger">*</span></label>
                                    <select class="form-control select2" data-toggle="select2" type="text" name="freight_term">
                                        <option value="PREPAID">PREPAID</option>
                                        <option value="COLLECT">COLLECT</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <label>Service Term <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <select class="form-control select2" data-toggle="select2" type="text" name="service_term1">
                                                <option value="BT">BT</option>
                                                <option value="BULK">BULK</option>
                                                <option value="FI">FI</option>
                                                <option value="FO">FO</option>
                                                <option value="FOR">FOR</option>
                                                <option value="FOT">FOT</option>
                                                <option value="LI">LI</option>
                                                <option value="TKL">TKL</option>
                                                <option value="CFS">CFS</option>
                                                <option value="CY">CY</option>
                                                <option value="DOOR">DOOR</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <select class="form-control select2" data-toggle="select2" type="text" name="service_term2">
                                                <option value="BT">BT</option>
                                                <option value="BULK">BULK</option>
                                                <option value="FI">FI</option>
                                                <option value="FO">FO</option>
                                                <option value="FOR">FOR</option>
                                                <option value="FOT">FOT</option>
                                                <option value="LI">LI</option>
                                                <option value="TKL">TKL</option>
                                                <option value="CFS">CFS</option>
                                                <option value="CY">CY</option>
                                                <option value="DOOR">DOOR</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-9">

                            </div>
                            <br/>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Descripción de contenedor(es) <span class="text-danger">*</span></label>
                                    <select class="form-control select2" data-toggle="select2" type="text" name="description_header1">
                                        <option value="SHIPPER'S SEALED/RISK ON DESK">SHIPPER'S SEALED/RISK ON DESK</option>
                                        <option value="SHIPPER'S LOAD & COUNT & SEALED">SHIPPER'S LOAD & COUNT & SEALED</option>
                                        <option value="SHIPPER'S LOAD, COUNT, STOW & SEAL">SHIPPER'S LOAD, COUNT, STOW & SEAL</option>
                                        <option value="SHIPPER'S LOAD & COUNT">SHIPPER'S LOAD & COUNT</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label><span class="text-danger">*</span></label>
                                    <select class="form-control select2" data-toggle="select2" type="text" name="description_header2">
                                        <option value="SAID TO CONTAIN SHIPPER'S WEIGHT AND MEASUREMENT :">SAID TO CONTAIN SHIPPER'S WEIGHT AND MEASUREMENT :</option>
                                        <option value="SAID TO BE :">SAID TO BE :</option>
                                        <option value="SAID TO CONTAIN :">SAID TO CONTAIN :</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <textarea class="form-control " type="text" name="description" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <table id="containers-datatable" class="table table-centered table-striped table-hover table-striped dt-responsive nowrap w-100 dataTable no-footer dtr-inline">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>CNTR #</th>
                                            <th>Type</th>
                                            <th>Size</th>
                                            <th class="text-center">QTY</th>
                                            <th>Modalidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($containers as $container)
                                            <tr>
                                                 <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="checkcontainer{{ $container->id }}" value="{{ $container->id }}" name="containers[]">
                                                        <label class="custom-control-label" for="checkcontainer{{ $container->id }}">&nbsp;</label>
                                                    </div>
                                                </td>
                                                <td>{{ $container->cntr }}</td>
                                                <td>{{ $container->type }}</td>
                                                <td>{{ $container->size }}</td>
                                                <td class="text-center">{{ $container->qty }}</td>
                                                <td>{{ $container->modalidad }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                </div>
                <div class="text-right pb-4 pr-4">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><b>Crear</b></button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div id="notes-operation-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Notas</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('operaciones.notes', $operation->id) }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        <div class="row">
                             <div class="col-12">
                                <div class="form-group">
                                    <textarea class="form-control " rows="5" name="note">{{ $operation->notes }}</textarea>
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
            $("#containers-datatable").DataTable({
                language: idioma_espanol,
                pageLength: 4,
                searching: false,
                info: false,
                lengthChange: false,
                ordering: false,
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

        $("input[name=ivaConcept]").click(function(){
            var id = $(this).parents("tr").find("td").eq(3).val();
            console.log(id);
        });

        function information_container_modal($id){
            var url = '/contenedores/' + $id;
            axios.get(url).then(function(response) {
                console.log(response.data);
                var id_container = $id;
                $('#infoContainerForm input[name=container_id]').val($id);
                $('#infoContainerForm input[name=cntr]').val(response.data.cntr);
                $('#infoContainerForm input[name=seal_no]').val(response.data.seal_no);
                $('#infoContainerForm select[name=type]').val(response.data.type).change();
                $('#infoContainerForm select[name=size]').val(response.data.size).change();
                $('#infoContainerForm input[name=qty]').val(response.data.qty);
                $('#infoContainerForm input[name=qty]').val(response.data.qty);
                $('#infoContainerForm select[name=modalidad]').val(response.data.modalidad).change();
                $('#infoContainerForm input[name=weight]').val(response.data.weight);
                $('#infoContainerForm input[name=measures]').val(response.data.measures);
                $('#infoContainerForm input[name=proforma]').val(response.data.proforma);
                $('#infoContainerForm input[name=pago_proforma]').val(response.data.pago_proforma);
                $('#infoContainerForm input[name=solicitud_transporte]').val(response.data.solicitud_transporte);
                $('#infoContainerForm input[name=despachado_puerto]').val(response.data.despachado_puerto);
                $('#infoContainerForm input[name=port_etd]').val(response.data.port_etd);
                $('#infoContainerForm input[name=dlv_day]').val(response.data.dlv_day);
                $('#infoContainerForm input[name=factura_unmx]').val(response.data.factura_unmx);
                $('#infoContainerForm input[name=fecha_factura]').val(response.data.fecha_factura);
                $('#information-container-modal').modal('show');
            }).catch(function(error) {
                console.log(response.error);
            })
        }

        function delete_container_modal($id)
        {
            $('#delete_container_form input[name=container_id]').val($id);
            $('#delete-container-modal').modal('show');
        }

        function calcularTotal()
        {
            var neto = $('#register-invoice-provider-form input[name=neto]').val();
            var vat = $('#register-invoice-provider-form input[name=vat]').val();
            var retention = $('#register-invoice-provider-form input[name=retention]').val();
            var others = $('#register-invoice-provider-form input[name=others]').val();
            var total = (parseFloat(neto) + parseFloat(vat) + parseFloat(others)) - parseFloat(retention);
            $('#register-invoice-provider-form input[name=total]').val(parseFloat(total).toFixed(2));

            var neto = $('#register-guaranteerequest-form input[name=neto]').val();
            var vat = $('#register-guaranteerequest-form input[name=vat]').val();
            var retention = $('#register-guaranteerequest-form input[name=retention]').val();
            var others = $('#register-guaranteerequest-form input[name=others]').val();
            var total = (parseFloat(neto) + parseFloat(vat) + parseFloat(others)) - parseFloat(retention);
            $('#register-guaranteerequest-form input[name=total]').val(parseFloat(total).toFixed(2));

            var neto = $('#register-advancerequest-form input[name=neto]').val();
            var vat = $('#register-advancerequest-form input[name=vat]').val();
            var retention = $('#register-advancerequest-form input[name=retention]').val();
            var others = $('#register-advancerequest-form input[name=others]').val();
            var total = (parseFloat(neto) + parseFloat(vat) + parseFloat(others)) - parseFloat(retention);
            $('#register-advancerequest-form input[name=total]').val(parseFloat(total).toFixed(2));
        }

        function search_accounts()
        {
            var provider_id = $('#register-invoice-provider-form select[name=provider_id]').val();
            if (provider_id == "") {
                var provider_id = $('#register-guaranteerequest-form select[name=provider_id]').val();
            }
            if (provider_id == "") {
                var provider_id = $('#register-advancerequest-form select[name=provider_id]').val();
            }
            axios.get('/proveedores/buscarcuentas', {
                params: {
                    provider_id: provider_id
                }
            }).then(function (response) {
                console.log(response.data.length);
                $("select[name=account_bank]").append("<option value=''>Selecciona...</option>");
                for(var i=0;i<=response.data.length;i++){
                    $("select[name=account_provider_id]").append("<option value='"+ response.data[i].id + "'>" + response.data[i].currency + " - " + response.data[i].account + "</option>");
                }
            }).catch(function (error) {
                console.log(error);
            });
        }

        function container_required()
        {
            if ($('#type_container').val() == "LCL") {
                $('#cntr_container').removeAttr("required");
                $('#sealno_container').removeAttr("required");
                document.getElementById('cntr_container_label').innerHTML= 'CNTR #';
                document.getElementById('sealno_container_label').innerHTML= 'Seal no.';
            }else{
                $('#cntr_container').attr("required",true);
                $('#sealno_container').attr("required",true);
                document.getElementById('cntr_container_label').innerHTML= 'CNTR # <span class="text-danger">*</span>';
                document.getElementById('sealno_container_label').innerHTML= 'Seal no. <span class="text-danger">*</span>';
            }
        }

        function container_required2()
        {
            if ($('#type_container2').val() == "LCL") {
                $('#cntr_container2').removeAttr("required");
                $('#sealno_container2').removeAttr("required");
                document.getElementById('cntr_container_label2').innerHTML= 'CNTR #';
                document.getElementById('sealno_container_label2').innerHTML= 'Seal no.';
            }else{
                $('#cntr_container2').attr("required",true);
                $('#sealno_container2').attr("required",true);
                document.getElementById('cntr_container_label2').innerHTML= 'CNTR # <span class="text-danger">*</span>';
                document.getElementById('sealno_container_label2').innerHTML= 'Seal no. <span class="text-danger">*</span>';
            }
        }


        @if($errors->any())
            $('#information-operation-modal').modal('show');
        @endif
    </script>
@endsection

