@extends('layouts.hyper')

@section('title', 'Sistema | Estados de cuenta de Debit Notes')

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
                <h4 class="page-title">Debit Notes</h4>
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
                            <h5>DEBIT NOTES - {{ $client->razon_social }}</h5>
                        </div>
                    </div>
                    <h5>Moneda: USD</h5>
                    <div class="table-responsive-sm">
                        <table class="table table-centered table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="12%">Folio</th>
                                    <th width="12%">Fecha</th>
                                    <th width="12%">Neto</th>
                                    <th width="12%">Total</th>
                                    <th width="12%">M-B/L</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $totalneto = 0; $totaltotal = 0; ?>
                                @foreach($debitnotes as $key => $debitnote)
                                    @if($debitnote->invoices->isEmpty())
                                        <?php $neto = 0; $total = 0; ?>
                                        @foreach($debitnote->conceptsoperations as $concept)
                                            <?php
                                                $neto = $neto + ($concept->rate * $concept->qty);
                                                $total = $total + ($concept->rate * $concept->qty);
                                            ?>
                                        @endforeach
                                        <tr>
                                            <td>{{ $debitnote->numberformat }}</td>
                                            <td>{{ $debitnote->fecha }}</td>
                                            <td>$ {{ number_format($neto, 2, '.', '') }}</td>
                                            <td>$ {{ number_format($total, 2, '.', '') }}</td>
                                            <td>{{ $debitnote->operation->m_bl }}</td>
                                        </tr>
                                        <?php
                                            $totalneto = $totalneto + $neto;
                                            $totaltotal = $totaltotal + $total;
                                        ?>
                                    @endif
                                @endforeach
                            </tbody>
                            <tfooter>
                                <tr>
                                    <th></th>
                                    <th width="9%">Totales</th>
                                    <th width="8%">$ {{ number_format($totalneto, 2, '.', '') }}</th>
                                    <th width="8%">$ {{ number_format($totaltotal, 2, '.', '') }}</th>
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