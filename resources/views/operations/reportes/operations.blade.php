@extends('layouts.hyper')

@section('title', 'Sistema | Reporte de operaciones')

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
                        <li class="breadcrumb-item active">Reportes</li>
                    </ol>
                </div>
                <h4 class="page-title">Reporte de operaciones</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <p>Ingresa la siguiente información para generar el reporte de operaciones: </p>
                        <form method="POST" action="{{ route('operaciones.reporteoperaciones_generar') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                            <div class="row">
                                <div class="col-2 form-group">
                                    <label for="">Fecha inicio:</label>
                                    <input type="date" name="fecha_inicio" class="form-control " required>
                                </div>
                                <div class="col-2 form-group">
                                    <label for="">Fecha fin:</label>
                                    <input type="date" name="fecha_fin" class="form-control " required>
                                </div>
                                <div class="col-2 form-group">
                                    <label for=""></label>
                                    <button type="submit" class="btn btn-primary mt-3"><i class="mdi mdi-file-document mr-2"></i><b>Generar reporte</b></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->

</div> <!-- container -->

<!-- End Modals -->
@endsection

@section('scripts')

@endsection
