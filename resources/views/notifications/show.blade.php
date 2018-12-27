@extends('layouts.hyper')

@section('title', 'Sistema | Notificaciones')

@section('content')
    <style>
        .tasks{
            width: 48rem;
        }
    </style>
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Notificaciones</h4>
                </div>
            </div>
        </div>
    <!-- end page title -->


    <div class="row">
        <div class="col-12">
            <div class="board">
                <div class="tasks" data-plugin="dragula" data-containers='["task-list-one", "task-list-two", "task-list-three", "task-list-four"]'>
                    <h5 class="mt-0 task-header">PENDIENTES ({{ Auth::user()->unreadNotifications->count() }})</h5>

                    <div id="task-list-one" class="task-list-items">

                        <!-- Task Item -->
                        @foreach(Auth::user()->unreadNotifications as $notification)
                            <?php
                                $fechaEmision = \Carbon\Carbon::parse($notification->created_at);
                                $fechaExpiracion = \Carbon\Carbon::now();

                                $minDiferencia = $fechaExpiracion->diffInMinutes($fechaEmision);
                                $hoursDiferencia = $fechaExpiracion->diffInHours($fechaEmision);
                                $daysDiferencia = $fechaExpiracion->diffInDays($fechaEmision);
                            ?>
                            <div class="card mb-0">
                                <div class="card-body p-3">
                                    @if($minDiferencia <= 60)
                                    <small class="text-muted float-right">Hace {{ $minDiferencia }} minutos</small>
                                    @elseif($minDiferencia > 60 && $hoursDiferencia <= 24 )
                                        <?php
                                            $horas = floor($minDiferencia / 60);
                                            $minutos = $minDiferencia - (60 * $horas);
                                        ?>
                                        <small class="text-muted float-right">Hace {{ $horas }} hora(s), {{ $minutos }} minutos</small>
                                    @elseif($hoursDiferencia > 24)
                                        <?php
                                            $dias = floor($hoursDiferencia / 24);
                                            $horas = $hoursDiferencia - (24 * $dias);
                                            $minutos = $minDiferencia - (60 * $hoursDiferencia);
                                        ?>
                                        <small class="text-muted float-right">Hace {{ $dias }} dia(s) ,{{ $horas }} hora(s), {{ $minutos }} minutos</small>
                                    @endif
                                    Prioridad:
                                    @if($notification->data['priority'] == 1)
                                        <span class="badge badge-danger">Alta</span>
                                    @elseif($notification->data['priority'] == 2)
                                        <span class="badge badge-warning">Media</span>
                                    @elseif($notification->data['priority'] == 3)
                                        <span class="badge badge-success">Baja</span>
                                    @else
                                        <span class="badge badge-secondary">Sin prioridad</span>
                                    @endif


                                    <h5 class="mt-2 mb-2">
                                        <a href="{{ $notification->data['link'] }}" class="text-body">{{ $notification->data['message'] }}</a>
                                    </h5>

                                    <div class="dropdown float-right">
                                        <a href="javascript:void(0);" class="dropdown-toggle text-muted arrow-none" data-toggle="dropdown" aria-expanded="false">
                                            <i class="mdi mdi-dots-vertical font-18"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <!-- item-->
                                            <form class="form-inline" method="POST" action="{{ route('notificaciones.update', $notification->id) }}" enctype="multipart/form-data" class="pl-2 pr-2">
                                                {!! csrf_field() !!}
                                                {!! method_field('PUT') !!}
                                                <input type="hidden" name="option" value="terminada">
                                                <button type="submit" class="dropdown-item"><i class="mdi mdi-pencil mr-1"></i>Marcar como terminada</button>
                                            </form>
                                            <!-- item-->
                                            <form class="form-inline" method="POST" action="{{ route('notificaciones.destroy', $notification->id) }}" enctype="multipart/form-data" class="pl-2 pr-2">
                                                {!! csrf_field() !!}
                                                {!! method_field('DELETE') !!}
                                                <button type="submit" class="dropdown-item"><i class="mdi mdi-delete mr-1"></i>Eliminar notificación</button>
                                            </form>
                                        </div>
                                    </div>

                                    <p class="mb-0">
                                        <img src="{{ Storage::url(Auth::user()->present()->createdUserNotification($notification)->avatar) }}" alt="user-img" class="avatar-xs rounded-circle mr-1" />
                                        <span class="align-middle">{{ Auth::user()->present()->createdUserNotification($notification)->name }}</span>
                                    </p>
                                </div> <!-- end card-body -->
                            </div>
                        @endforeach
                        <!-- Task Item End -->

                    </div> <!-- end company-list-1-->
                </div>

                <div class="tasks">
                    <h5 class="mt-0 task-header text-uppercase">TERMINADAS ({{ Auth::user()->readNotifications->count() }})</h5>

                    <div id="task-list-two" class="task-list-items">

                        <!-- Task Item -->
                        @foreach(Auth::user()->readNotifications as $notification)
                            <?php
                                $fechaEmision = \Carbon\Carbon::parse($notification->created_at);
                                $fechaExpiracion = \Carbon\Carbon::now();

                                $minDiferencia = $fechaExpiracion->diffInMinutes($fechaEmision);
                                $hoursDiferencia = $fechaExpiracion->diffInHours($fechaEmision);
                                $daysDiferencia = $fechaExpiracion->diffInDays($fechaEmision);
                            ?>
                            <div class="card mb-0">
                                <div class="card-body p-3">
                                    @if($minDiferencia <= 60)
                                    <small class="text-muted float-right">Hace {{ $minDiferencia }} minutos</small>
                                    @elseif($minDiferencia > 60 && $hoursDiferencia <= 24 )
                                        <?php
                                            $horas = floor($minDiferencia / 60);
                                            $minutos = $minDiferencia - (60 * $horas);
                                        ?>
                                        <small class="text-muted float-right">Hace {{ $horas }} hora(s), {{ $minutos }} minutos</small>
                                    @elseif($hoursDiferencia > 24)
                                        <?php
                                            $dias = floor($hoursDiferencia / 24);
                                            $horas = $hoursDiferencia - (24 * $dias);
                                            $minutos = $minDiferencia - (60 * $hoursDiferencia);
                                        ?>
                                        <small class="text-muted float-right">Hace {{ $dias }} dia(s) ,{{ $horas }} hora(s), {{ $minutos }} minutos</small>
                                    @endif
                                     Prioridad:
                                    @if($notification->data['priority'] == 1)
                                        <span class="badge badge-danger">Alta</span>
                                    @elseif($notification->data['priority'] == 2)
                                        <span class="badge badge-warning">Media</span>
                                    @elseif($notification->data['priority'] == 3)
                                        <span class="badge badge-success">Baja</span>
                                    @else
                                        <span class="badge badge-secondary">Sin prioridad</span>
                                    @endif

                                    <h5 class="mt-2 mb-2">
                                        <a href="{{ $notification->data['link'] }}" class="text-body">{{ $notification->data['message'] }}</a>
                                    </h5>

                                    <div class="dropdown float-right">
                                        <a href="javascript:void(0);" class="dropdown-toggle text-muted arrow-none" data-toggle="dropdown" aria-expanded="false">
                                            <i class="mdi mdi-dots-vertical font-18"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <!-- item-->
                                            <form class="form-inline" method="POST" action="{{ route('notificaciones.update', $notification->id) }}" enctype="multipart/form-data" class="pl-2 pr-2">
                                                {!! csrf_field() !!}
                                                {!! method_field('PUT') !!}
                                                <input type="hidden" name="option" value="pendiente">
                                                <button type="submit" class="dropdown-item"><i class="mdi mdi-pencil mr-1"></i>Marcar como pendiente</button>
                                            </form>
                                            <!-- item-->
                                            <form class="form-inline" method="POST" action="{{ route('notificaciones.destroy', $notification->id) }}" enctype="multipart/form-data" class="pl-2 pr-2">
                                                {!! csrf_field() !!}
                                                {!! method_field('DELETE') !!}
                                                <button type="submit" class="dropdown-item"><i class="mdi mdi-delete mr-1"></i>Eliminar notificación</button>
                                            </form>
                                        </div>
                                    </div>

                                    <p class="mb-0">
                                        <img src="{{ Storage::url(Auth::user()->present()->createdUserNotification($notification)->avatar) }}" alt="user-img" class="avatar-xs rounded-circle mr-1" />
                                        <span class="align-middle">{{ Auth::user()->present()->createdUserNotification($notification)->name }}</span>
                                    </p>
                                </div> <!-- end card-body -->
                            </div>
                        @endforeach
                        <!-- Task Item End -->

                    </div> <!-- end company-list-2-->
                </div>
            </div> <!-- end .board-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->

</div> <!-- container -->


<!-- End Modals -->
@endsection

@section('scripts')
    <script>
        @if(session()->has('info'))
            $.NotificationApp.send("Bien hecho!", "{{ session('info') }}", 'top-right', 'rgba(0,0,0,0.2)', 'success');
        @endif
    </script>
@endsection
