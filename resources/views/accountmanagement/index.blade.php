@extends('layouts.hyper')

@section('title', 'Finanzas | Manejo de cuentas')

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
                        <li class="breadcrumb-item">Finanzas</li>
                        <li class="breadcrumb-item active">Manejo de cuentas</li>
                    </ol>
                </div>
                <h4 class="page-title">Manejo de cuentas</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <p>Ingresa la siguiente información para generar el manejo de cuentas: </p>
                        <form method="POST" action="{{ route('manejocuentas.show') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                            <div class="row">
                                <div class="col-2">
                                    <h5>Account Management</h5>
                                </div>
                                <div class="col-2 form-group">
                                    <label for="">Fecha inicial al dia de mañana:</label>
                                    <input type="date" name="am_fecha_inicio" class="form-control form-control-light">
                                </div>
                                <div class="col-8"></div>
                                <div class="col-2">
                                    <h5>Daily Approval</h5>
                                </div>
                                <div class="col-2 form-group">
                                    <label for="">Fecha del balance:</label>
                                    <input type="date" name="da_fecha_inicio" class="form-control form-control-light">
                                </div>
                                <div class="col-8"></div>
                                <div class="col-2">
                                    <h5>Facturas de proveedores</h5>
                                </div>
                                <div class="col-2 form-group">
                                    <label for="">Fecha de inicio:</label>
                                    <input type="date" name="fp_fecha_inicio" class="form-control form-control-light">
                                </div>
                                <div class="col-2 form-group">
                                    <label for="">Fecha de fin:</label>
                                    <input type="date" name="fp_fecha_fin" class="form-control form-control-light">
                                </div>
                                <div class="col-6">

                                </div>
                                <div class="col-9"></div>
                                <div class="col">
                                    <button type="submit" class="btn btn-primary mt-3"><i class="mdi mdi-file-document mr-2"></i><b>Acount Management</b></button>
                                    <button type="submit" class="btn btn-primary mt-3"><i class="mdi mdi-file-document mr-2"></i><b>Daily Approval</b></button>
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
