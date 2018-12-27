@extends('layouts.hyper')

@section('title', 'Gasto de caja chica')

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
                        <li class="breadcrumb-item"><a href="{{ route('estadogastos.index')}}">Finanzas</a></li>
                        <li class="breadcrumb-item active">Factura {{ $expense->invoice }}</li>
                    </ol>
                </div>
                <h4 class="page-title">Gasto de caja chica</h4>
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
                                <div class="text-right">
                                    <button data-toggle="modal" data-target="#notes-expense-modal" class="btn btn-light"><i class="mdi mdi-note-text"></i> Agregar/Editar notas</button>
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
                            {{-- <img src="{{ asset('assets/images/logos/unico.jpg') }}" alt="" height="80"> --}}
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
                                <h3>&nbsp;&nbsp;&nbsp;&nbsp;CAJA CHICA<br><h2>( {{ $expense->controlcode }} )<h2></h3>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row" style="border-width: 1px; border-style: solid;">
                        <div class="col-6 pt-3 pb-3" style="border-width: 0px 1px 0px 0px; border-style: solid;">
                            <div class="row">
                                <div class="col-5">
                                    <h5 style="margin: 10px;">Reporting entity</h5>
                                    <h5 style="margin: 10px;">Deparment</h5>
                                    <h5 style="margin: 10px;">Date</h5>
                                    <h5 style="margin: 10px;">Subject description</h5>
                                </div>
                                <div class="col-7">
                                    <h5 style="margin: 10px;">: Edith Valdez</h5>
                                    <h5 style="margin: 10px;">: Administración</h5>
                                    <h5 style="margin: 10px;">: {{ $expense->created_at->format('d-m-Y') }}</h5>
                                    <h5 style="margin: 10px;">: {{ $expense->expense_type }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 pt-3 pb-3">
                            <div class="row justify-content-center">
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-6">
                                            <h5 style="margin: 10px;">Reporting entity:</h5>
                                        </div>
                                        <div class="col-6" style="border-bottom: 1px solid;"></div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-4">
                                            <h5 style="margin: 10px;">Date:</h5>
                                        </div>
                                        <div class="col-6" style="border-bottom: 1px solid;"></div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-6">
                                            <h5 style="margin: 10px; margin-top: 35px;">ULMEX Approval:</h5>
                                        </div>
                                        <div class="col-6" style="border-bottom: 1px solid;"></div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-4">
                                            <h5 style="margin: 10px; margin-top: 35px;">Date:</h5>
                                        </div>
                                        <div class="col-6" style="border-bottom: 1px solid;"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row" style="border-width: 1px; border-style: solid;">
                        <div class="col-6 pt-3 pb-3">
                            <div class="row">
                                <div class="col-12">
                                    {{-- <h5 style="margin: 10px;">General information </h5> --}}
                                </div>
                            </div>
                            <div class="row">
                                {{-- <div class="col-12">
                                    <div class="row"> --}}
                                        <div class="col-4">
                                            <h5 style="margin: 10px;">GENERAL INFORMATION</h5>
                                            <br>
                                            <h5 style="margin: 10px;">SOLICITADO POR</h5>
                                        </div>
                                        <div class="col-7">
                                            <h5 style="margin: 10px;">
                                                : {{ $expense->notes }}
                                            </h5>
                                            <br>
                                            <h5 style="margin: 10px;">
                                                : {{ strtoupper($expense->solicitadoPor->name) }}
                                            </h5>
                                        </div>
                                    {{-- </div>
                                </div> --}}
                            </div>
                        </div>
                        <div class="col-6 pt-3 pb-3">
                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <h5 style="margin: 10px;"></h5>
                                </div>
                                <div class="col-4">
                                    <h5 style="margin: 10px;">PURPOSE - PROVIDER</h5>
                                </div>
                                <div class="col-8">
                                    <h3 style="margin: 10px;">
                                        {{ strtoupper($expense->description) }}
                                    </h3>
                                </div>
                                <div class="col-4">
                                    <h5 style="margin: 10px;">INVOICE</h5>
                                </div>
                                <div class="col-8">
                                    <h5 style="margin: 10px;">
                                        {{ $expense->invoice }}
                                    </h5>
                                </div>
                                <div class="col-4">
                                    <h5 style="margin: 10px;">PAYMENT SOURCE</h5>
                                </div>
                                <div class="col-8">
                                    <h5 style="margin: 10px;">
                                        {{ $expense->payment_source }}
                                    </h5>
                                </div>
                                <div class="col-4">
                                    <h5 style="margin: 10px;">PAYMENT STATUS</h5>
                                </div>
                                <div class="col-8">
                                    <h5 style="margin: 10px;">
                                        {{ $expense->payment_status }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row" style="border-width: 1px; border-style: solid;">
                        <div class="col-6 pt-3 pb-3">
                            <div class="row">
                                <div class="col-4">
                                    <h5 style="margin: 10px;">Notes </h5>
                                </div>
                                <div class="col-8">
                                    <h5 style="margin: 10px;">
                                        {{ $expense->additional_notes }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 pt-3 pb-3">
                            <div class="row">
                                <div class="col-12">
                                    <h5 style="margin: 10px;">Estimated amount</h5>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-3">
                                            <h5 style="margin: 10px;">Neto:</h5>
                                            <h5 style="margin: 10px;">Vat:</h5>
                                            <h5 style="margin: 10px;">Retention:</h5>
                                            <h5 style="margin: 10px;">Others:</h5>
                                            <h5 style="margin: 10px;">Total:</h5>
                                        </div>
                                        <div class="col-8 text-right">
                                            {{-- <div class="">

                                            </div> --}}
                                            <h4 style="margin: 10px;">{{ number_format($expense->neto, 2, '.', ',') }}</h4>
                                            <h4 style="margin: 10px;">{{ number_format($expense->vat, 2, '.', ',') }}</h4>
                                            <h4 style="margin: 10px;">- {{ number_format($expense->retention, 2, '.', ',') }}</h4>
                                            <h4 style="margin: 10px;">{{ number_format($expense->others, 2, '.', ',') }}</h4>
                                            <h3 style="margin: 10px;">{{ number_format($expense->total, 2, '.', ',') }} {{ $expense->currency }}</h3>
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

    <div id="notes-expense-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Notas</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('estadogastos.notes', $expense->id) }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        <div class="row">
                             <div class="col-12">
                                <div class="form-group">
                                    <textarea class="form-control form-control-light" rows="5" name="note">{{ $expense->additional_notes }}</textarea>
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

</div> <!-- container -->
@endsection
@section('scripts')
    <script>

    </script>
@endsection