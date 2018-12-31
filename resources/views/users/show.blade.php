@extends('layouts.hyper')

@section('title', 'Administración | Información de usuario')

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
                        <li class="breadcrumb-item"><a href="{{ route('usuarios.index') }}">Usuarios</a></li>
                        <li class="breadcrumb-item active">Usuario: {{ $user->name }}</li>
                    </ol>
                </div>
                <h4 class="page-title">Información de usuario</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-sm-12">
            <!-- Profile -->
            <div class="card">
                <div class="card-body profile-user-box">
                    <div class="row justify-content-between">
                        <div class="col-sm-8">
                            <div class="media">
                                <span class="float-left m-2 mr-4"><img src="{{ Storage::url($user->url) }}" style="height: 100px;" alt="" class="rounded-circle img-thumbnail"></span>
                                <div class="media-body">

                                    <h4 class="mt-1 mb-1">{{ $user->name }}</h4>
                                    <p class="font-13">{{ $user->email_office }}</p>

                                    <ul class="mb-0 list-inline">
                                        <li class="list-inline-item mr-3">
                                            <p class="mb-0 font-13">Departamento(s)</p>
                                            <h5 class="mb-1">{{ $user->present()->roles() }}</h5>
                                        </li>
                                    </ul>
                                </div> <!-- end media-body-->
                            </div>
                        </div> <!-- end col-->

                        <div class="col-sm-2">
                            @if(Auth::user()->id == $user->id || Auth::user()->present()->isAdmin())
                                <div class="text-center mt-sm-0 mt-3 text-sm-right">
                                    <button type="submit" class="btn btn-light btn-block" data-toggle="modal" data-target="#information-user-modal">
                                        <i class="mdi mdi-account-edit mr-1"></i> <b>Editar información</b>
                                    </button>
                                </div>
                                <br>
                                @if(Auth::user()->present()->isAdmin())
                                    @if(!$user->inactive_at)
                                        <div class="text-center mt-sm-0 mt-3 text-sm-right">
                                            <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#deactivate-user-modal">
                                                <i class="mdi mdi-close-box mr-1"></i> <b>Desactivar usuario</b>
                                            </button>
                                        </div>
                                    @else
                                        <div class="text-center mt-sm-0 mt-3 text-sm-right">
                                            <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#activate-user-modal">
                                                <i class="mdi mdi-checkbox-marked mr-1"></i> <b>Activar usuario</b>
                                            </button>
                                        </div>
                                    @endif
                                @endif
                            @endif
                        </div> <!-- end col-->
                    </div> <!-- end row -->

                </div> <!-- end card-body/ profile-user-box-->
            </div><!--end profile/ card -->
        </div> <!-- end col-->
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-md-4">
            <!-- Personal-Information -->
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-3">Información del usuario</h4>
                    <p class="text-muted font-13">
                    </p>

                    <hr/>

                    <div class="row">
                        <div class="col-5"><p>Usuario: </p></div>
                        <div class="col-7"><p><b>{{ $user->user_name }} </b></p></div>
                        <div class="col-5"><p>Nombre: </p></div>
                        <div class="col-7"><p><b>{{ $user->name }} </b></p></div>
                        <div class="col-5"><p>Correo electrónico: </p></div>
                        <div class="col-7"><p><b>{{ $user->email }} </b></p></div>
                        <div class="col-5"><p>Teléfono: </p></div>
                        <div class="col-7"><p><b>{{ $user->phone }} </b></p></div>
                        <div class="col-5"><p>Dirección: </p></div>
                        <div class="col-7"><p><b>{{ $user->address }} </b></p></div>
                        {{-- <div class="col-5"><p>Redes sociales: </p></div>
                        <div class="col-7"><a class="d-inline-block text-muted" title="" data-placement="top" data-toggle="tooltip" href="" data-original-title="Facebook"><i class="mdi mdi-facebook"></i></a>
                            <a class="d-inline-block ml-2 text-muted" title="" data-placement="top" data-toggle="tooltip" href="" data-original-title="Twitter"><i class="mdi mdi-twitter"></i></a>
                            <a class="d-inline-block ml-2 text-muted" title="" data-placement="top" data-toggle="tooltip" href="" data-original-title="Skype"><i class="mdi mdi-skype"></i></a></div> --}}
                    </div>
                </div>
            </div>
            <!-- Personal-Information -->
        </div> <!-- end col-->
        @if(Auth::user()->present()->isOper())
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-3">
                                <h4 class="header-title">Clientes asignados</h4>
                            </div>
                            <div class="col-2 mr-2">
                                <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#register-client-user-modal">
                                    <i class="mdi mdi-plus-circle mr-1"></i> Asignar cliente
                                </button>
                            </div>
                        </div>
                        <hr/>
                        <div class="table-responsive-sm">
                            <table id="clients-user-datatable" class="table table-centered table-hover dt-responsive nowrap w-100 dataTable no-footer dtr-inline">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="4%">#</th>
                                        <th>Cliente</th>
                                        <th>Status cliente</th>
                                        <th width="7%">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->clients as $key => $client)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $client->razon_social }}</td>
                                            <td>{{ $client->present()->statusBadge() }}</td>
                                            <td>
                                                <a href="javascript:void(0)" class="action-icon"
                                                data-toggle="tooltip" data-placemente="top" data-original-title="Quitar cliente"
                                                onclick="disassociate_client({{ $client->id }})"><i class="mdi mdi-close-box"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
       {{--  <div class="{{ Auth::user()->present()->isOper() ? 'col-md-6' : 'col-md-8'}}">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Operaciones de importación</h4>
                    <div id="chart-user-impo" class="apex-charts"></div>
                </div>
                <!-- end card body-->
            </div>
        </div>
        <div class="{{ Auth::user()->present()->isOper() ? 'col-md-6' : 'col-md-8'}}">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Operaciones de exportación</h4>
                    <div id="chart-user-expo" class="apex-charts"></div>
                </div>
                <!-- end card body-->
            </div>
        </div> --}}
    </div>

    {{-- <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Control de operaciones</h4>
                    <div id="chart-admin" class="apex-charts"></div>
                </div>
            </div>
        </div>
    </div> --}}

</div> <!-- container -->

<!-- Start Modals    -->
    <div id="information-user-modal" class="modal fade" tabindex="" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Editar información</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('usuarios.update', $user->id) }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        {!! method_field('PUT') !!}
                        <div class="form-group">
                            <label>Nombre: <span class="text-danger">*</span></label>
                            <input class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" name="name" value="{{ $user->name }}">
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Usuario: <span class="text-danger">*</span></label>
                            <input class="form-control {{ $errors->has('user_name') ? ' is-invalid' : '' }}" type="text" name="user_name" value="{{ $user->user_name }}">
                            @if ($errors->has('user_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('user_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Contraseña: <span class="text-danger">*</span></label>
                            <input class="form-control {{ $errors->has('password_encrypted') ? ' is-invalid' : '' }}" type="text" name="password_encrypted" value="{{ $user->password_encrypted }}">
                            @if ($errors->has('password_encrypted'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password_encrypted') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Correo electrónico: <span class="text-danger">*</span></label>
                            <input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" type="text" name="email" value="{{ $user->email }}">
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        @if(Auth::user()->present()->isAdmin() || Auth::user()->present()->isAdminGeneral())
                            <div class="form-group">
                                <label>Rol: <span class="mb-0 font-13">(Departamento)</span></label>
                                <div class="form-inline">
                                <select class="select2 form-control select2-multiple mb-2{{ $errors->has('roles[]') ? ' is-invalid' : '' }}" name="roles[]" data-toggle="select2" multiple="multiple" data-placeholder="Choose ...">
                                    <optgroup>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ $user->roles->pluck('id')->contains($role->id) ? 'selected' : ''  }}>{{ $role->display_name }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                                </div>
                                @if ($errors->has('roles[]'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('roles[]') }}</strong>
                                    </span>
                                @endif
                            </div>
                        @endif

                        <div class="form-group fallback">
                            <label>Avatar: </label>
                            {{-- <input class="form-control " type="file" name="avatar"> --}}
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="avatar" class="custom-file-input">
                                    <label class="custom-file-label">Selecciona el archivo:</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Teléfono: </label>
                            <input class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" type="text" name="phone" value="{{ $user->phone }}" data-toggle="input-mask" data-mask-format="(00) 0000-0000" placeholder="(xx) xxxxx-xxxx">
                            @if ($errors->has('phone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Dirección: </label>
                            <input class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" type="text" name="address" value="{{ $user->address }}">
                            @if ($errors->has('address'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
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
    <!-- /.modal -->

    <div id="deactivate-user-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-warning h1 text-danger"></i>
                        <h4 class="mt-2">Precaución!</h4>
                        <p class="mt-3">¿Está seguro(a) de desactivar el usuario <b>{{ $user->name }}</b>?</p>
                        <button type="button" class="btn btn-light my-2" data-dismiss="modal">Cancelar</button>
                        <form style="display: inline;" action="{{ route('usuarios.deactivate', $user->id) }}" method="POST">
                            {!! csrf_field() !!}
                            {!! method_field('DELETE') !!}
                            <button type="sumbit" class="btn btn-danger my-2"><b>Aplicar</b></button>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="activate-user-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-warning h1 text-primary"></i>
                        <h4 class="mt-2">Precaución!</h4>
                        <p class="mt-3">¿Está seguro(a) de activar el usuario <b>{{ $user->name }}</b>?</p>
                        <button type="button" class="btn btn-light my-2" data-dismiss="modal">Cancelar</button>
                        <form style="display: inline;" action="{{ route('usuarios.activate', $user->id) }}" method="POST">
                            {!! csrf_field() !!}
                            <button type="sumbit" class="btn btn-primary my-2"><b>Aplicar</b></button>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="register-client-user-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header pr-4 pl-4">
                    <h4 class="modal-title" id="primary-header-modalLabel">Asignación de cliente</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('usuarios.assignmentClient') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                        {!! csrf_field() !!}
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <div class="row">
                             <div class="col-12">
                                <div class="form-group">
                                    <label>Cliente <span class="text-danger">*</span></label>
                                    <select class="form-control {{ $errors->has('client_id') ? ' is-invalid' : '' }}" name="client_id" required>
                                        <option value="">Selecciona...</option>
                                        @foreach($clients as $client)
                                            @if(!$user->clients->pluck('id')->contains($client->id))
                                                <option value="{{ $client->id }}">{{ $client->razon_social }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="text-right pb-4 pr-4">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><b>Asignar</b></button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div id="disassociate-client-user-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-warning h1 text-danger"></i>
                        <h4 class="mt-2">Precaución!</h4>
                        <p class="mt-3">¿Está seguro(a) de desasignar el cliente?</p>
                        <button type="button" class="btn btn-light my-2" data-dismiss="modal">Cancelar</button>
                        <form id="disassociate_client_user_form" style="display: inline;" action="{{ route('usuarios.disassociateClient') }}" method="POST">
                            {!! csrf_field() !!}
                            {!! method_field('DELETE') !!}
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <input type="hidden" name="client_id">
                            <button type="sumbit" class="btn btn-danger my-2"><b>Aplicar</b></button>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<!-- End Modals -->
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/vendor/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.checkboxes.min.js') }}"></script>
    <script src="{{ asset('assets/js/idioma_espanol.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/demo.apex-column.js') }}"></script>
    <script>
        $(document).ready(function(){
            $("#clients-user-datatable").DataTable({
                language: idioma_espanol,
                pageLength: 3,
                lengthChange: false,
                searching: false,
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

            var url = '/operaciones/chart_user';
            axios.get(url).then(function(response) {
                console.log(response.data);
                var operaciones = response.data;
                var colors = ['#39afd1', '#727cf5', '#727cf5', '#727cf5', '#727cf5', '#727cf5', '#727cf5', '#727cf5', '#727cf5', '#727cf5', '#727cf5', '#727cf5', '#727cf5', '#727cf5', '#0acf97'];
                var options = {
                    chart: {
                        height: 327,
                        type: 'bar',
                        events: {
                            click: function(chart, w, e) {
                                console.log(chart, w, e )
                            }
                        },
                    },
                    colors: colors,
                    plotOptions: {
                        bar: {
                            columnWidth: '80%',
                            distributed: true
                        }
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    series: [{
                        data: [
                            operaciones.impo.totales,
                            operaciones.impo.recibir,
                            operaciones.impo.revision,
                            operaciones.impo.mandar,
                            operaciones.impo.revalidacion,
                            operaciones.impo.tocapiso,
                            operaciones.impo.proforma,
                            operaciones.impo.pagoproforma,
                            operaciones.impo.soltransporte,
                            operaciones.impo.despuerto,
                            operaciones.impo.portetd,
                            operaciones.impo.dlvday,
                            operaciones.impo.solicitud,
                            operaciones.impo.facturaunmx,
                            operaciones.impo.fechafactura,
                        ]
                    }],
                    xaxis: {
                        categories: ['Totales', 'Recibir', 'Revisión', 'Mandar', 'Revalidación', 'Toca piso', 'Proforma', 'Pago proforma', 'Sol. transporte', 'Desp. puerto', 'Port ETD', 'Dlv day', 'Solicitud', 'Factura unmx', 'Fecha factura'],
                        labels: {
                            style: {
                                colors: colors,
                                fontSize: '13px'
                            }
                        }
                    }
                }

                var chart = new ApexCharts(
                    document.querySelector("#chart-user-impo"),
                    options
                );

                chart.render();

                var operaciones = response.data;
                var colors = ['#39afd1', '#727cf5', '#727cf5', '#727cf5', '#727cf5', '#727cf5', '#727cf5', '#727cf5', '#727cf5', '#727cf5', '#727cf5', '#727cf5', '#727cf5'];
                var options = {
                    chart: {
                        height: 327,
                        type: 'bar',
                        events: {
                            click: function(chart, w, e) {
                                console.log(chart, w, e )
                            }
                        },
                    },
                    colors: colors,
                    plotOptions: {
                        bar: {
                            columnWidth: '80%',
                            distributed: true
                        }
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    series: [{
                        data: [
                            operaciones.expo.totales,
                            operaciones.expo.booking,
                            operaciones.expo.confbooking,
                            operaciones.expo.progrecoleccion,
                            operaciones.expo.recoleccion,
                            operaciones.expo.llegadapuerto,
                            operaciones.expo.cierredocumental,
                            operaciones.expo.pesaje,
                            operaciones.expo.ingreso,
                            operaciones.expo.despacho,
                            operaciones.expo.zarpe,
                            operaciones.expo.enviopapelera,
                            operaciones.expo.solicitud,
                        ]
                    }],
                    xaxis: {
                        categories: ['Totales', 'Booking', 'Conf. booking', 'Prog. recolección', 'Recolección', 'Llegada puerto', 'Cierre documental', 'Pesaje', 'Ingreso', 'Despacho', 'Zarpe', 'Envio papelera', 'Solicitud'],
                        labels: {
                            style: {
                                colors: colors,
                                fontSize: '13px'
                            }
                        }
                    }
                }

                var chart = new ApexCharts(
                    document.querySelector("#chart-user-expo"),
                    options
                );

                chart.render();
            }).catch(function(error) {
                console.log(response.error);
            })


            var url = '/operaciones/chart_admin';
            axios.get(url).then(function(response) {
                var operaciones = response.data;
                console.log(operaciones);
                var options = {
                    chart: {
                        height: 400,
                        type: 'bar',
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            endingShape: 'rounded',
                            columnWidth: '55%',
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 1,
                        colors: ['transparent']
                    },
                    series: operaciones,
                    xaxis: {
                        categories: ['Recibir', 'Revisión', 'Mandar', 'Revalidación', 'Toca piso', 'Proforma', 'Pago proforma', 'Sol. transporte', 'Desp. puerto', 'Port Etd', 'Dlv Day', 'Factura Unmx', 'Fecha factura'],
                    },
                    yaxis: {
                        title: {
                            text: 'Cantidad'
                        }
                    },
                    fill: {
                        opacity: 1

                    },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return val
                            }
                        }
                    }
                }

                var chart = new ApexCharts(
                    document.querySelector("#chart-admin"),
                    options
                );

                chart.render();
            }).catch(function(error) {
                console.log(response.error);
            })
        })

        function disassociate_client($id)
        {
            console.log($id);
            $('#disassociate_client_user_form input[name=client_id]').val($id);
            $('#disassociate-client-user-modal').modal('show');
        }

        @if($errors->any())
            $('#information-user-modal').modal('show');
        @endif
        @if(session()->has('info'))
            $.NotificationApp.send("Bien hecho!", "{{ session('info') }}", 'top-right', 'rgba(0,0,0,0.2)', 'success');
        @endif
    </script>
@endsection

