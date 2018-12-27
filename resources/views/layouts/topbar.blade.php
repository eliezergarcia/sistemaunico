<!-- Topbar Start  -->
{{ Auth::user()->notificationsStorage() }}
{{ Auth::user()->notificationsDelay() }}
<div class="navbar-custom">
    <ul class="list-unstyled topbar-right-menu float-right mb-0">

        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle arrow-none" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <i class="dripicons-bell noti-icon"></i>
                @if(Auth::user()->unreadNotifications->isNotEmpty())
                    <span class="noti-icon-badge badge badge-primary">{{ Auth::user()->unreadNotifications->count() }}</span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-lg">

                <!-- item-->
                <div class="dropdown-item noti-title">
                    <h5 class="m-0">
                        <span class="float-right">
                            <a href="javascript: void(0);" class="text-dark">
                                {{-- <small>Clear All</small> --}}
                            </a>
                        </span>Notificaciones
                    </h5>
                </div>

                <div class="slimscroll" style="max-height: 230px;">
                    <!-- item-->
                    @foreach(Auth::user()->unreadNotifications as $notification)
                        <a href="{{ $notification->data['link'] }}" class="dropdown-item notify-item">
                            <div class="notify-icon bg-primary">
                                <i class="dripicons-stack"></i>
                            </div>
                            <?php
                                $fechaEmision = \Carbon\Carbon::parse($notification->created_at);
                                $fechaExpiracion = \Carbon\Carbon::now();

                                $minDiferencia = $fechaExpiracion->diffInMinutes($fechaEmision);
                                $hoursDiferencia = $fechaExpiracion->diffInHours($fechaEmision);
                                $daysDiferencia = $fechaExpiracion->diffInDays($fechaEmision);
                            ?>
                            <p class="notify-details">{{ $notification->data['message'] }}
                                @if($minDiferencia <= 60)
                                    <small class="text-muted">Hace {{ $minDiferencia }} minutos - {{ Auth::user()->present()->createdUserNotification($notification)->name }}
                                        @if($notification->data['priority'] == 1)
                                            <span class="badge badge-danger">Prioridad - Alta</span>
                                        @elseif($notification->data['priority'] == 2)
                                            <span class="badge badge-warning">Prioridad - Media</span>
                                        @elseif($notification->data['priority'] == 3)
                                            <span class="badge badge-success">Prioridad - Baja</span>
                                        @else
                                            <span class="badge badge-secondary">Prioridad - Sin prioridad</span>
                                        @endif
                                    </small>
                                @elseif($minDiferencia > 60 && $hoursDiferencia <= 24 )
                                    <?php
                                        $horas = floor($minDiferencia / 60);
                                        $minutos = $minDiferencia - (60 * $horas);
                                    ?>
                                    <small class="text-muted">Hace {{ $horas }} hora(s), {{ $minutos }} minutos - {{ Auth::user()->present()->createdUserNotification($notification)->name }}
                                        @if($notification->data['priority'] == 1)
                                            <span class="badge badge-danger">Prioridad - Alta</span>
                                        @elseif($notification->data['priority'] == 2)
                                            <span class="badge badge-warning">Prioridad - Media</span>
                                        @elseif($notification->data['priority'] == 3)
                                            <span class="badge badge-success">Prioridad - Baja</span>
                                        @else
                                            <span class="badge badge-secondary">Prioridad - Sin prioridad</span>
                                        @endif
                                    </small>
                                @elseif($hoursDiferencia > 24)
                                    <?php
                                        $dias = floor($hoursDiferencia / 24);
                                        $horas = $hoursDiferencia - (24 * $dias);
                                        $minutos = $minDiferencia - (60 * $hoursDiferencia);
                                    ?>
                                    <small class="text-muted">Hace {{ $dias }} dia(s) ,{{ $horas }} hora(s), {{ $minutos }} minutos - {{ Auth::user()->present()->createdUserNotification($notification)->name }}
                                        @if($notification->data['priority'] == 1)
                                            <span class="badge badge-danger">Prioridad - Alta</span>
                                        @elseif($notification->data['priority'] == 2)
                                            <span class="badge badge-warning">Prioridad - Media</span>
                                        @elseif($notification->data['priority'] == 3)
                                            <span class="badge badge-success">Prioridad - Baja</span>
                                        @else
                                            <span class="badge badge-secondary">Prioridad - Sin prioridad</span>
                                        @endif
                                    </small>
                                @endif
                                {{-- @if($notification->data['priority'] == 1)
                                    <span class="badge badge-danger">Alta</span>
                                @elseif($notification->data['priority'] == 2)
                                    <span class="badge badge-warning">Media</span>
                                @elseif($notification->data['priority'] == 3)
                                    <span class="badge badge-success">Baja</span>
                                @else
                                    <span class="badge badge-secondary">Sin prioridad</span>
                                @endif --}}

                            </p>
                        </a>
                    @endforeach
                </div>

                <!-- All-->
                <a href="{{ route('notificaciones.show', Auth::user()->id) }}" class="dropdown-item text-center text-primary notify-item notify-all">
                    Ver todo
                </a>

            </div>
        </li>

        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user arrow-none mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                aria-expanded="false">
                <span class="account-user-avatar">
                    <img src="{{ Storage::url(Auth::user()->url) }}" alt="user-image" class="rounded-circle">
                </span>
                <span>
                    <span class="account-user-name">{{ Auth::user()->name }}</span>
                    <span class="account-position">{{ Auth::user()->present()->roles() }}</span>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown ">
                <div class=" dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Menú</h6>
                </div>
                <a class="dropdown-item notify-item" href="{{ route('usuarios.show', Auth::user()->id) }}">
                    <i class="mdi mdi-account-circle"></i>
                    <span>Mi cuenta</span>
                </a>
                <a class="dropdown-item notify-item" href="{{ route('notificaciones.show', Auth::user()->id) }}">
                    <i class="mdi mdi-message-text"></i>
                    <span>Notificaciones</span>
                </a>
                <!-- item-->
                <a class="dropdown-item notify-item" +
                    href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <i class="mdi mdi-logout"></i>
                    <span>Cerrar sesión</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

            </div>
        </li>

    </ul>
    <button class="button-menu-mobile open-left disable-btn">
        <i class="mdi mdi-menu"></i>
    </button>
</div>
<!-- end Topbar