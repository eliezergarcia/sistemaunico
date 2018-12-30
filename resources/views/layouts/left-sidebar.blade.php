<!-- Left Sidebar Start -->
<div class="left-side-menu left-side-menu-light">

    <div class="slimscroll-menu">

        <!-- LOGO -->
        <a href="{{ route('calendarios.index') }}" class="logo text-center">
            <span class="logo-lg">
                <img src="{{ asset('assets/images/logos/unico.jpg') }}" alt="" height="45">
            </span>
            <span class="logo-sm">
                <img src="{{ asset('assets/images/logo_sm.png') }}" alt="" height="16">
            </span>
        </a>

        <!--- Sidemenu -->
        <ul class="metismenu side-nav side-nav-light">

            <li class="side-nav-title side-nav-item">MENU</li>

            <!-- <li class="side-nav-item">
                <a href="{{ route('calendarios.index') }}" class="side-nav-link">
                    <i class="dripicons-calendar"></i>
                    <span class="badge badge-success float-right">7</span>
                    <span> Calendario </span>
                </a>
            </li> -->

            <!-- <li class="side-nav-item">
                <a href="javascript: void(0);" class="side-nav-link">
                    <i class="dripicons-view-apps"></i>
                    <span> Apps </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="side-nav-second-level" aria-expanded="false">
                    <li>
                        <a href="apps-calendar.html">Calendar</a>
                    </li>
                    <li class="side-nav-item">
                        <a href="javascript: void(0);" aria-expanded="false">Projects
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="side-nav-third-level" aria-expanded="false">
                            <li>
                                <a href="apps-projects-list.html">List</a>
                            </li>
                            <li>
                                <a href="apps-projects-details.html">Details</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="apps-tasks.html">Tasks</a>
                    </li>
                    <li class="side-nav-item">
                        <a href="javascript: void(0);" aria-expanded="false">eCommerce
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="side-nav-third-level" aria-expanded="false">
                            <li>
                                <a href="apps-ecommerce-products.html">Products</a>
                            </li>
                            <li>
                                <a href="apps-ecommerce-products-details.html">Products Details</a>
                            </li>
                            <li>
                                <a href="apps-ecommerce-orders.html">Orders</a>
                            </li>
                            <li>
                                <a href="apps-ecommerce-orders-details.html">Order Details</a>
                            </li>
                            <li>
                                <a href="apps-ecommerce-customers.html">Customers</a>
                            </li>
                            <li>
                                <a href="apps-ecommerce-shopping-cart.html">Shopping Cart</a>
                            </li>
                            <li>
                                <a href="apps-ecommerce-checkout.html">Checkout</a>
                            </li>
                            <li>
                                <a href="apps-ecommerce-sellers.html">Sellers</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li> -->
            <li class="side-nav-item">
                <a href="{{ route('calendarios.index') }}" class="side-nav-link">
                    <i class="mdi mdi-calendar-text"></i>Calendario
                </a>
            </li>
            {{-- <li class="side-nav-item">
                <a href="javascript: void(0);" class="side-nav-link">
                    <i class="dripicons-stack"></i>
                    <span> Ctl. de operaciones </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="side-nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{ route('calendarios.index') }}" aria-expanded="false">Calendario
                        </a>
                    </li>
                </ul>
            </li> --}}
            @if(Auth::user()->present()->isOper() || Auth::user()->present()->isAdminGeneral())
                <li class="side-nav-item">
                    <a href="javascript: void(0);" class="side-nav-link">
                        <i class="dripicons-stack"></i>
                        <span> Control de &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;operaciones </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="side-nav-second-level" aria-expanded="false">
                        <li>
                            <a href="{{ route('operaciones.index') }}" aria-expanded="false">Operaciones
                            </a>
                        </li>
                    </ul>
                    <ul class="side-nav-second-level" aria-expanded="false">
                        <li>
                            <a href="{{ route('debitnotes.index') }}" aria-expanded="false">Debit Notes
                            </a>
                        </li>
                    </ul>
                    <ul class="side-nav-second-level" aria-expanded="false">
                        <li>
                            <a href="{{ route('prefacturas.index') }}" aria-expanded="false">Prefacturas
                            </a>
                        </li>
                    </ul>
                    <ul class="side-nav-second-level" aria-expanded="false">
                        <li>
                            <a href="{{ route('housebls.index') }}" aria-expanded="false">House B/L
                            </a>
                        </li>
                    </ul>
                    <ul class="side-nav-second-level" aria-expanded="false">
                        <li>
                            <a href="{{ route('facturasproveedor.index') }}" aria-expanded="false">Facturas de proveedor
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            @if(Auth::user()->present()->isFac() || Auth::user()->present()->isAdminGeneral())
                <li class="side-nav-item">
                    <a href="javascript: void(0);" class="side-nav-link">
                        <i class="dripicons-box"></i>
                        <span> Facturación </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="side-nav-second-level" aria-expanded="false">
                        <li>
                            <a href="{{ route('debitnotes.index') }}" aria-expanded="false">Debit Notes
                            </a>
                        </li>
                    </ul>
                    <ul class="side-nav-second-level" aria-expanded="false">
                        <li>
                            <a href="{{ route('prefacturas.index') }}" aria-expanded="false">Prefacturas
                            </a>
                        </li>
                    </ul>
                    <ul class="side-nav-second-level" aria-expanded="false">
                        <li>
                            <a href="{{ route('facturas.index') }}" aria-expanded="false">Facturas
                            </a>
                        </li>
                    </ul>
                    <ul class="side-nav-second-level" aria-expanded="false">
                        <li>
                            <a href="{{ route('pagos.index') }}" aria-expanded="false">Pagos
                            </a>
                        </li>
                    </ul>
                    <ul class="side-nav-second-level" aria-expanded="false">
                        <li>
                            <a href="{{ route('notascredito.index') }}" aria-expanded="false">Notas de crédito
                            </a>
                        </li>
                    </ul>
                    {{-- <ul class="side-nav-second-level" aria-expanded="false">
                        <li>
                            <a href="{{ route('accountstatements.facturacion') }}" aria-expanded="false">Estados de cuenta
                            </a>
                        </li>
                    </ul> --}}
                    <ul class="side-nav-second-level" aria-expanded="false">
                        <li class="side-nav-item">
                            <a href="javascript: void(0);" aria-expanded="false">Estados de cuenta
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="side-nav-third-level" aria-expanded="false">
                                <li>
                                    <a href="{{ route('accountstatements.facturacion') }}" aria-expanded="false">Facturas
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('accountstatements.debitnotes') }}" aria-expanded="false">Debit Notes
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            @endif
            @if(Auth::user()->present()->isFin() || Auth::user()->present()->isAdminGeneral())
                <li class="side-nav-item">
                    <a href="javascript: void(0);" class="side-nav-link">
                        <i class="mdi mdi-finance"></i>
                        <span> Finanzas </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="side-nav-second-level" aria-expanded="false">
                        <li>
                            <a href="{{ route('facturasproveedor.index') }}" aria-expanded="false">Facturas
                            </a>
                        </li>
                    </ul>
                    <ul class="side-nav-second-level" aria-expanded="false">
                        <li>
                            <a href="{{ route('facturasproveedor.guaranteerequests') }}" aria-expanded="false">Solicitudes de garantía
                            </a>
                        </li>
                    </ul>
                    <ul class="side-nav-second-level" aria-expanded="false">
                        <li>
                            <a href="{{ route('facturasproveedor.advancerequests') }}" aria-expanded="false">Solicitudes de anticipo
                            </a>
                        </li>
                    </ul>
                    <ul class="side-nav-second-level" aria-expanded="false">
                        <li>
                            <a href="{{ route('pagosproveedores.index') }}" aria-expanded="false">Pagos
                            </a>
                        </li>
                    </ul>
                    <ul class="side-nav-second-level" aria-expanded="false">
                        <li>
                            <a href="{{ route('balances.index') }}" aria-expanded="false">Balances
                            </a>
                        </li>
                    </ul>
                    <ul class="side-nav-second-level" aria-expanded="false">
                        <li>
                            <a href="{{ route('manejocuentas.index') }}" aria-expanded="false">Manejo de cuentas
                            </a>
                        </li>
                    </ul>
                    <ul class="side-nav-second-level" aria-expanded="false">
                        <li>
                            <a href="{{ route('estadogastos.index') }}" aria-expanded="false">Caja chica
                            </a>
                        </li>
                    </ul>
                    <ul class="side-nav-second-level" aria-expanded="false">
                        <li>
                            <a href="{{ route('serviciosgastos.index') }}" aria-expanded="false">Servicios de gastos
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            @if(Auth::user()->present()->isAdmin() || Auth::user()->present()->isAdminGeneral())
                <li class="side-nav-item">
                    <a href="javascript: void(0);" class="side-nav-link">
                        <i class="mdi mdi-home-lock"></i>
                        <span> Administración </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="side-nav-second-level" aria-expanded="false">
                        <li>
                            <a href="{{ route('usuarios.index') }}" aria-expanded="false">Usuarios
                            </a>
                        </li>
                    </ul>
                    <ul class="side-nav-second-level" aria-expanded="false">
                        <li>
                            <a href="{{ route('clientes.index') }}" aria-expanded="false">Clientes
                            </a>
                        </li>
                    </ul>
                    <ul class="side-nav-second-level" aria-expanded="false">
                        <li>
                            <a href="{{ route('proveedores.index') }}" aria-expanded="false">Proveedores
                            </a>
                        </li>
                    </ul>
                    <ul class="side-nav-second-level" aria-expanded="false">
                        <li class="side-nav-item">
                            <a href="javascript: void(0);" aria-expanded="false">Conceptos
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="side-nav-third-level" aria-expanded="false">
                                <li>
                                    <a href="{{ route('conceptos.index') }}" aria-expanded="false">Cliente
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('conceptosproveedor.index') }}" aria-expanded="false">Proveedor
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End