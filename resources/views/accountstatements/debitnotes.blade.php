@extends('layouts.hyper')

@section('title', 'Sistema | Estados de cuenta')

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
                <h4 class="page-title">Estados de cuenta de Debit Notes</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <p>Ingresa la siguiente información para generar el estado de cuenta: </p>
                        <form method="POST" action="{{ route('accountstatements.debitnotes_generar') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                            <div class="row">
                                <div class="col-4 form-group">
                                    <label for="">Cliente:</label>
                                    <select name="client_id" id="" class="form-control " required>
                                        <option value="">Selecciona...</option>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->codigo_cliente }} - {{ $client->razon_social }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-2 form-group">
                                    <label for=""></label>
                                    <button type="submit" class="btn btn-primary mt-3"><i class="mdi mdi-file-document mr-2"></i><b>Generar estado de cuenta</b></button>
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
