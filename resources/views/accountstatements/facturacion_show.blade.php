@extends('layouts.hyper')

@section('title', 'Sistema | Estados de cuenta de facturas')

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
                        <li class="breadcrumb-item">Facturación</li>
                        <li class="breadcrumb-item active">Estados de cuenta</li>
                    </ol>
                </div>
                <h4 class="page-title">Facturas</h4>
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

                            </div>
                            <div class="col">
                                <div class="text-right">
                                    <a href="javascript:window.print()" class="btn btn-primary"><i class="mdi mdi-printer"></i> Imprimir</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="col">

                        </div>
                        <div class="col">
                            <h5>ESTADO DE CUENTA - {{ $client->razon_social }}</h5>
                        </div>
                    </div>
                    <h5>Moneda: MXN</h5>
                    <div class="table-responsive-sm">
                        <table class="table table-centered table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="12%">Factura</th>
                                    <th width="12%">Fecha factura</th>
                                    <th width="12%">Neto</th>
                                    <th width="12%">IVA</th>
                                    <th width="12%">Total</th>
                                    <th width="12%">Pendiente</th>
                                    <th class="d-print-none">Comentarios</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $totalneto = 0;
                                    $totaliva = 0;
                                    $total = 0;
                                    $totalpendiente = 0;
                                ?>
                                @foreach($invoices as $key => $invoice)
                                    @if($invoice->moneda == "MXN")
                                        @if($status == "pendiente")
                                            @if(number_format($invoice->neto + $invoice->iva, 2, '.', '') != number_format($invoice->payments->pluck('monto')->sum(), 2, '.', ''))
                                                <tr>
                                                    <td>{{ $invoice->factura }}</td>
                                                    <td>{{ $invoice->fecha }}</td>
                                                    <td>$ {{ number_format($invoice->neto, 2, '.', '') }}</td>
                                                    <td>$ {{ number_format($invoice->iva, 2, '.', '') }}</td>
                                                    <td>$ {{ number_format($invoice->neto + $invoice->iva, 2, '.', '') }}</td>
                                                    <td>$ {{ number_format(($invoice->neto + $invoice->iva) - $invoice->payments->pluck('monto')->sum(), 2, '.', '') }}</td>
                                                    <td class="d-print-none">{{ $invoice->comentarios }}</td>
                                                </tr>
                                                <?php
                                                    $totalneto = $totalneto + $invoice->neto;
                                                    $totaliva = $totaliva + $invoice->iva;
                                                    $total = $total + $invoice->neto + $invoice->iva;
                                                    $totalpendiente = $totalpendiente + ($invoice->neto + $invoice->iva - $invoice->payments->pluck('monto')->sum());
                                                ?>
                                            @endif
                                        @else
                                            @if(number_format($invoice->neto + $invoice->iva, 2, '.', '') == number_format($invoice->payments->pluck('monto')->sum(), 2, '.', ''))
                                                <tr>
                                                    <td>{{ $invoice->factura }}</td>
                                                    <td>{{ $invoice->fecha }}</td>
                                                    <td>$ {{ number_format($invoice->neto, 2, '.', '') }}</td>
                                                    <td>$ {{ number_format($invoice->iva, 2, '.', '') }}</td>
                                                    <td>$ {{ number_format($invoice->neto + $invoice->iva, 2, '.', '') }}</td>
                                                    <td>$ {{ number_format(($invoice->neto + $invoice->iva) - $invoice->payments->pluck('monto')->sum(), 2, '.', '') }}</td>
                                                    <td class="d-print-none">{{ $invoice->comentarios }}</td>
                                                </tr>
                                                <?php
                                                    $totalneto = $totalneto + $invoice->neto;
                                                    $totaliva = $totaliva + $invoice->iva;
                                                    $total = $total + $invoice->neto + $invoice->iva;
                                                    $totalpendiente = $totalpendiente + ($invoice->neto + $invoice->iva - $invoice->payments->pluck('monto')->sum());
                                                ?>
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                                @foreach($creditnotes as $key => $creditnote)
                                    @if($creditnote->moneda == "MXN")
                                        @if($status == "pendiente")
                                            <tr>
                                                <td>NC {{ $creditnote->folio }}</td>
                                                <td>{{ $creditnote->fecha }}</td>
                                                <td>-$ {{ number_format($creditnote->monto, 2, '.', '') }}</td>
                                                <td>-$ {{ number_format($creditnote->monto * .16, 2, '.', '') }}</td>
                                                <td>-$ {{ number_format($creditnote->monto * 1.16, 2, '.', '') }}</td>
                                                <td>-$ {{ number_format($creditnote->monto * 1.16, 2, '.', '') }}</td>
                                                <td class="d-print-none">{{ $creditnote->comentarios }}</td>
                                            </tr>
                                            <?php
                                                $totalneto = $totalneto - $creditnote->monto;
                                                $totaliva = $totaliva - $creditnote->monto * .16;
                                                $total = $total - $creditnote->monto * 1.16;
                                                $totalpendiente = $totalpendiente - $creditnote->monto * 1.16;
                                            ?>
                                        @endif
                                    @endif
                                @endforeach
                            </tbody>
                            <tfooter>
                                <tr>
                                    <th width="4%"></th>
                                    <th width="9%">Totales</th>
                                    <th width="8%">$ {{ number_format($totalneto, 2, '.', '') }}</th>
                                    <th width="8%">$ {{ number_format($totaliva, 2, '.', '') }}</th>
                                    <th width="8%">$ {{ number_format($total, 2, '.', '') }}</th>
                                    <th width="8%">$ {{ number_format($totalpendiente, 2, '.', '') }}</th>
                                </tr>
                            </tfooter>
                        </table>
                    </div>
                    <br>
                    <h5>Moneda: USD</h5>
                    <div class="table-responsive-sm">
                        <table class="table table-centered table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="12%">Factura</th>
                                    <th width="12%">Fecha factura</th>
                                    <th width="12%">Neto</th>
                                    <th width="12%">IVA</th>
                                    <th width="12%">Total</th>
                                    <th width="12%">Pendiente</th>
                                    <th class="d-print-none">Comentarios</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $totalneto = 0;
                                    $totaliva = 0;
                                    $total = 0;
                                    $totalpendiente = 0;
                                ?>
                                @foreach($invoices as $key => $invoice)
                                    @if($invoice->moneda == "USD")
                                        @if($status == "pendiente")
                                            @if(number_format($invoice->neto + $invoice->iva, 2, '.', '') != number_format($invoice->payments->pluck('monto')->sum(), 2, '.', ''))
                                                <tr>
                                                    <td>{{ $invoice->factura }}</td>
                                                    <td>{{ $invoice->fecha }}</td>
                                                    <td>$ {{ number_format($invoice->neto, 2, '.', '') }}</td>
                                                    <td>$ {{ number_format($invoice->iva, 2, '.', '') }}</td>
                                                    <td>$ {{ number_format($invoice->neto + $invoice->iva, 2, '.', '') }}</td>
                                                    <td>$ {{ number_format(($invoice->neto + $invoice->iva) - $invoice->payments->pluck('monto')->sum(), 2, '.', '') }}</td>
                                                    <td class="d-print-none">{{ $invoice->comentarios }}</td>
                                                </tr>
                                                <?php
                                                    $totalneto = $totalneto + $invoice->neto;
                                                    $totaliva = $totaliva + $invoice->iva;
                                                    $total = $total + $invoice->neto + $invoice->iva;
                                                    $totalpendiente = $totalpendiente + ($invoice->neto + $invoice->iva - $invoice->payments->pluck('monto')->sum());
                                                ?>
                                            @endif
                                        @else
                                            @if(number_format($invoice->neto + $invoice->iva, 2, '.', '') == number_format($invoice->payments->pluck('monto')->sum(), 2, '.', ''))
                                                <tr>
                                                    <td>{{ $invoice->factura }}</td>
                                                    <td>{{ $invoice->fecha }}</td>
                                                    <td>$ {{ number_format($invoice->neto, 2, '.', '') }}</td>
                                                    <td>$ {{ number_format($invoice->iva, 2, '.', '') }}</td>
                                                    <td>$ {{ number_format($invoice->neto + $invoice->iva, 2, '.', '') }}</td>
                                                    <td>$ {{ number_format(($invoice->neto + $invoice->iva) - $invoice->payments->pluck('monto')->sum(), 2, '.', '') }}</td>
                                                    <td class="d-print-none">{{ $invoice->comentarios }}</td>
                                                </tr>
                                                <?php
                                                    $totalneto = $totalneto + $invoice->neto;
                                                    $totaliva = $totaliva + $invoice->iva;
                                                    $total = $total + $invoice->neto + $invoice->iva;
                                                    $totalpendiente = $totalpendiente + ($invoice->neto + $invoice->iva - $invoice->payments->pluck('monto')->sum());
                                                ?>
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                                @foreach($creditnotes as $key => $creditnote)
                                    @if($creditnote->moneda == "USD")
                                        @if($status == "pendiente")
                                            <tr>
                                                <td>NC {{ $creditnote->folio }}</td>
                                                <td>{{ $creditnote->fecha }}</td>
                                                <td>-$ {{ number_format($creditnote->monto, 2, '.', '') }}</td>
                                                <td>-$ {{ number_format($creditnote->monto * .16, 2, '.', '') }}</td>
                                                <td>-$ {{ number_format($creditnote->monto * 1.16, 2, '.', '') }}</td>
                                                <td>-$ {{ number_format($creditnote->monto * 1.16, 2, '.', '') }}</td>
                                                <td>{{ $creditnote->comentarios }}</td>
                                            </tr>
                                            <?php
                                                $totalneto = $totalneto - $creditnote->monto;
                                                $totaliva = $totaliva - $creditnote->monto * .16;
                                                $total = $total - $creditnote->monto * 1.16;
                                                $totalpendiente = $totalpendiente - $creditnote->monto * 1.16;
                                            ?>
                                        @endif
                                    @endif
                                @endforeach
                            </tbody>
                            <tfooter>
                                <tr>
                                    <th width="4%"></th>
                                    <th width="9%">Totales</th>
                                    <th width="8%">$ {{ number_format($totalneto, 2, '.', '') }}</th>
                                    <th width="8%">$ {{ number_format($totaliva, 2, '.', '') }}</th>
                                    <th width="8%">$ {{ number_format($total, 2, '.', '') }}</th>
                                    <th width="8%">$ {{ number_format($totalpendiente, 2, '.', '') }}</th>
                                </tr>
                            </tfooter>
                        </table>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->

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
            var table = $("#invoices-datatable").DataTable({
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
    </script>
@endsection