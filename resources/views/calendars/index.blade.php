@extends('layouts.hyper')

@section('title', 'Sistema | Calendario')

@section('content')
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Menú</a></li>
                        <li class="breadcrumb-item active">Calendario</li>
                    </ol>
                </div>
                <h4 class="page-title">Calendario</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-10">
                            <div id="calendar"></div>
                        </div> <!-- end col -->

                        <div class="col-sm-12 col-md-2">
                            <br>
                            <a href="#" data-toggle="modal" data-target="#register-event-modal" onclick="register_event_modal()" class="btn btn-lg font-16 btn-primary btn-block  ">
                                <i class="mdi mdi-calendar-edit"></i> Crear nuevo evento
                            </a>
                           {{--  <div id="external-events" class="m-t-20">
                                <br>
                                <p class="text-muted">Arrastra y suelta tu evento o haz clic en el calendario.</p>
                                <div class="external-event bg-success" data-class="bg-success">
                                    <i class="mdi mdi-checkbox-blank-circle mr-2 vertical-middle"></i>New Theme Release
                                </div>
                                <div class="external-event bg-info" data-class="bg-info">
                                    <i class="mdi mdi-checkbox-blank-circle mr-2 vertical-middle"></i>My Event
                                </div>
                                <div class="external-event bg-warning" data-class="bg-warning">
                                    <i class="mdi mdi-checkbox-blank-circle mr-2 vertical-middle"></i>Meet manager
                                </div>
                                <div class="external-event bg-danger" data-class="bg-danger">
                                    <i class="mdi mdi-checkbox-blank-circle mr-2 vertical-middle"></i>Create New theme
                                </div>
                            </div> --}}

                            <!-- checkbox -->
                           {{--  <div class="custom-control custom-checkbox mt-3">
                                <input type="checkbox" class="custom-control-input" id="drop-remove">
                                <label class="custom-control-label" for="drop-remove">Eliminar después de mover</label>
                            </div> --}}

                            <div class="mt-5 d-none d-xl-block">
                                <h5 class="text-center">Cómo funciona ?</h5>

                                <ul class="pl-3">
                                    <li class="text-muted mb-3">
                                        Para crear un evento solo hay que dar click al botón "Crear nuevo evento" o dar click a un día dentro del calendario e ingresar la información que se pide.
                                    </li>
                                    <li class="text-muted mb-3">
                                        Los eventos se pueden modificar dando click al evento dentro del calendario y solo se pueden modificar los eventos creados por el mismo usuario.
                                    </li>
                                    <li class="text-muted mb-3">
                                        Al eliminar un evento que se encuentra compartido con usuarios o departamentos, este se elimina para todos los usuarios asignados.
                                    </li>
                                    <li class="text-muted mb-3">
                                        Se puede navegar por las vistas de "Mes, Semana y Día" para poder ver solo los eventos creados dentro del mes, semana o día.
                                    </li>
                                    <li class="text-muted mb-3">
                                        Si se encuentra navegando por otro mes diferente al actual se puede dar click al botón "Hoy" para regresar al mes y día actual.
                                    </li>
                                </ul>
                            </div>
                        </div> <!-- end col-->
                    </div>  <!-- end row -->
                </div> <!-- end card body-->
            </div>

            <!-- Add New Event MODAL -->
            <div class="modal fade" id="event-modal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header pr-4 pl-4 border-bottom-0 d-block">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Add New Event</h4>
                        </div>
                        <div class="modal-body pt-3 pr-4 pl-4">
                        </div>
                        <div class="text-right pb-4 pr-4">
                            <button type="button" class="btn btn-light " data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success save-event  ">Create event</button>
                            <button type="button" class="btn btn-danger delete-event  " data-dismiss="modal">Delete</button>
                        </div>
                    </div> <!-- end modal-content-->
                </div> <!-- end modal dialog-->
            </div>
            <!-- end modal-->

            <!-- Modal Add Category -->
            <div class="modal fade" id="add-category" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header border-bottom-0 d-block">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Add a category</h4>
                        </div>
                        <div class="modal-body p-4">
                            <form>
                                <div class="form-group">
                                    <label class="control-label">Category Name</label>
                                    <input class="form-control form-white" placeholder="Enter name" type="text" name="category-name"/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Choose Category Color</label>
                                    <select class="form-control form-white" data-placeholder="Choose a color..." name="category-color">
                                        <option value="primary">Primary</option>
                                        <option value="success">Success</option>
                                        <option value="danger">Danger</option>
                                        <option value="info">Info</option>
                                        <option value="warning">Warning</option>
                                        <option value="dark">Dark</option>
                                    </select>
                                </div>

                            </form>

                            <div class="text-right">
                                <button type="button" class="btn btn-light " data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary ml-1   save-category" data-dismiss="modal">Save</button>
                            </div>

                        </div> <!-- end modal-body-->
                    </div> <!-- end modal-content-->
                </div> <!-- end modal dialog-->
            </div>
            <!-- end modal-->

            <!-- Registrar nuevo evento Modal -->
            <div id="register-event-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header pr-4 pl-4">
                            <h4 class="modal-title" id="primary-header-modalLabel">Registro de evento</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form id="register-event-form" method="POST" action="{{ route('calendarios.store') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                                {!! csrf_field() !!}
                                <div class="form-group">
                                    <label>Titulo de evento: <span class="text-danger">*</span></label>
                                    <input class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" type="text" name="title" value="{{ old('title') }}">
                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Compartir con usuario:</label>
                                        <select class="select2 form-control select2-multiple" name="share_users[]" data-toggle="select2" multiple="multiple" data-placeholder="Choose ...">
                                            <optgroup>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Compartir con departamento:</label>
                                        <select class="select2 form-control select2-multiple" name="share_departments[]" data-toggle="select2" multiple="multiple" data-placeholder="Choose ...">
                                            <optgroup>
                                                @foreach($departments as $department)
                                                    <option value="{{ $department->id }}">{{ $department->display_name }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                </div>
                                <div class="row">
                                    <div class="col-6 form-group">
                                        <label>Fecha inicio: <span class="text-danger">*</span></label>
                                        <input type="text" name="startdate" class="form-control date" id="birthdatepicker" data-toggle="date-picker" data-single-date-picker="true">
                                    </div>
                                    <div class="col-6 form-group">
                                        <label>&nbsp;</label>
                                        <div class="input-group">
                                            <input type="text" name="start_time" class="form-control" data-toggle='timepicker'data-show-meridian="false">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="dripicons-clock"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 form-group">
                                        <label>Fecha fin: <span class="text-danger">*</span></label>
                                        <input type="text" name="enddate" class="form-control date" id="birthdatepicker" data-toggle="date-picker" data-single-date-picker="true">
                                    </div>
                                    <div class="col-6 form-group">
                                        <label>&nbsp;</label>
                                        <div class="input-group">
                                            <input type="text" name="end_time" class="form-control" data-toggle='timepicker' data-show-meridian="false">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="dripicons-clock"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Color:</label>
                                    <select class="form-control select2" data-toggle="select2" name="color">
                                        <option value="bg-primary">Primary</option>
                                        <option value="bg-success">Success</option>
                                        <option value="bg-danger">Danger</option>
                                        <option value="bg-info">Info</option>
                                        <option value="bg-warning">Warning</option>
                                        <option value="bg-dark">Dark</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Mensaje: <span class="text-danger">*</span></label>
                                    <textarea class="form-control {{ $errors->has('message') ? ' is-invalid' : '' }}" name="message" rows="5">{{ old('message') }}</textarea>
                                    @if ($errors->has('message'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('message') }}</strong>
                                        </span>
                                    @endif
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

            <div id="update-event-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header pr-4 pl-4">
                            <h4 class="modal-title" id="primary-header-modalLabel">Información de evento</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form id="update-event-form" method="POST" action="{{ route('calendarios.modificar') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                                {!! csrf_field() !!}
                                <input type="hidden" name="calendar_id">
                                <div class="form-group">
                                    <label>Titulo de evento: <span class="text-danger">*</span></label>
                                    <input class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" type="text" name="title" value="{{ old('title') }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Compartir con usuario:</label>
                                        <select class="select2 form-control select2-multiple" name="share_users[]" id="share_users_update" data-toggle="select2" multiple="multiple" data-placeholder="Choose ...">
                                            <optgroup>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Compartir con departamento:</label>
                                        <select class="select2 form-control select2-multiple" name="share_departments[]" id="share_departments_update" data-toggle="select2" multiple="multiple" data-placeholder="Choose ...">
                                            <optgroup>
                                                @foreach($departments as $department)
                                                    <option value="{{ $department->id }}">{{ $department->display_name }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                </div>
                                <div class="row">
                                    <div class="col-6 form-group">
                                        <label>Fecha inicio: <span class="text-danger">*</span></label>
                                        <input type="text" name="startdate" class="form-control date" id="birthdatepicker" data-toggle="date-picker" data-single-date-picker="true">
                                    </div>
                                    <div class="col-6 form-group">
                                        <label>&nbsp;</label>
                                        <div class="input-group">
                                            <input type="text" name="start_time" class="form-control" data-toggle='timepicker'data-show-meridian="false">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="dripicons-clock"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 form-group">
                                        <label>Fecha fin: <span class="text-danger">*</span></label>
                                        <input type="text" name="enddate" class="form-control date" id="birthdatepicker" data-toggle="date-picker" data-single-date-picker="true">
                                    </div>
                                    <div class="col-6 form-group">
                                        <label>&nbsp;</label>
                                        <div class="input-group">
                                            <input type="text" name="end_time" class="form-control" data-toggle='timepicker' data-show-meridian="false">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="dripicons-clock"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Color:</label>
                                    <select class="form-control select2" data-toggle="select2" name="color">
                                        <option value="bg-primary">Primary</option>
                                        <option value="bg-success">Success</option>
                                        <option value="bg-danger">Danger</option>
                                        <option value="bg-info">Info</option>
                                        <option value="bg-warning">Warning</option>
                                        <option value="bg-dark">Dark</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Mensaje: <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="message" rows="5"></textarea>
                                </div>

                        </div>
                        <div class="row justify-content-between pb-3 pl-4">
                            <div class="col-6">
                                <button type="button" class="btn btn-danger" onclick="delete_event()" data-dismiss="modal">Eliminar</button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary"><b>Guardar</b></button>
                            </div>
                        </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

            <div id="info-event-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header pr-4 pl-4">
                            <h4 class="modal-title" id="primary-header-modalLabel">Información de evento</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form id="info-event-form" method="POST" action="{{ route('calendarios.modificar') }}" enctype="multipart/form-data" class="pl-2 pr-2">
                                {!! csrf_field() !!}
                                <input type="hidden" name="calendar_id">
                                <div class="form-group">
                                    <label>Titulo de evento:</label>
                                    <input class="form-control" type="text" name="title" value="" disabled="">
                                </div>
                                <div class="form-group">
                                    <label>Creado por:</label>
                                    <input class="form-control" type="text" name="created_by" value="" disabled="">
                                </div>
                                <div class="form-group">
                                    <label for="">Compartido con usuario(s):</label>
                                        <select class="select2 form-control select2-multiple" name="share_users[]" id="share_users_info" data-toggle="select2" multiple="multiple" data-placeholder="Choose ..." disabled="">
                                            <optgroup>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Compartido con departamento(s):</label>
                                        <select class="select2 form-control select2-multiple" name="share_departments[]" id="share_departments_info" data-toggle="select2" multiple="multiple" data-placeholder="Choose ..." disabled="">
                                            <optgroup>
                                                @foreach($departments as $department)
                                                    <option value="{{ $department->id }}">{{ $department->display_name }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                </div>
                                <div class="row">
                                    <div class="col-6 form-group">
                                        <label>Fecha inicio:</label>
                                        <input type="text" name="startdate" class="form-control date" id="birthdatepicker" data-toggle="date-picker" data-single-date-picker="true" disabled="">
                                    </div>
                                    <div class="col-6 form-group">
                                        <label>&nbsp;</label>
                                        <div class="input-group">
                                            <input type="text" name="start_time" class="form-control" data-toggle='timepicker'data-show-meridian="false" disabled="">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="dripicons-clock"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 form-group">
                                        <label>Fecha fin:</label>
                                        <input type="text" name="enddate" class="form-control date" id="birthdatepicker" data-toggle="date-picker" data-single-date-picker="true" disabled="">
                                    </div>
                                    <div class="col-6 form-group">
                                        <label>&nbsp;</label>
                                        <div class="input-group">
                                            <input type="text" name="end_time" class="form-control" data-toggle='timepicker' data-show-meridian="false" disabled="">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="dripicons-clock"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Mensaje:</label>
                                    <textarea class="form-control" name="message" rows="5" disabled=""></textarea>
                                </div>

                        </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- End Modal -->
        </div>
        <!-- end col-12 -->
    </div> <!-- end row -->

</div> <!-- container -->
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/vendor/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/es.js') }}"></script>
    <script src="{{ asset('assets/js/pages/demo.calendar.js') }}"></script>
    <script>
        @if($errors->any())
            $('#register-event-modal').modal('show');
        @endif

        function delete_event()
        {
            var id = $('#update-event-form input[name=calendar_id]').val();
            axios.post('/calendarios/eliminar', {
                id: id
              }).then(function (response) {
                $.NotificationApp.send("Bien hecho!", response.data, 'top-right', 'rgba(0,0,0,0.2)', 'success');
                setInterval("actualizarPagina()", 3500);
              }).catch(function (error) {
                    console.log(response.error);
                    $.NotificationApp.send("Error!", "Ocurrió un problema al eliminar el evento.", 'top-right', 'rgba(0,0,0,0.2)', 'error');
              });
        }

        function actualizarPagina(){
            location.reload(true);
        }

        function register_event_modal()
        {
            $('#register-event-form input[name=startdate]').val(moment().format('MM/DD/YYYY'));
            $('#register-event-form input[name=enddate]').val(moment().format('MM/DD/YYYY'));
            $('#register-event-modal').modal('show');
        }
    </script>
@endsection