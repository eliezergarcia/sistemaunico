<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu left-side-menu-light">

    <div class="slimscroll-menu">

        <!-- LOGO -->
        <a href="{{ route('calendar.index') }}" class="logo text-center">
            <span class="logo-lg">
                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="16">
            </span>
            <span class="logo-sm">
                <img src="{{ asset('assets/images/logo_sm.png') }}" alt="" height="16">
            </span>
        </a>

        <!--- Sidemenu -->
        <ul class="metismenu side-nav side-nav-light">

            <li class="side-nav-title side-nav-item">MENU</li>

            <li class="side-nav-item">
                <a href="{{ route('calendar.index') }}" class="side-nav-link">
                    <i class="dripicons-calendar"></i>
                    <span class="badge badge-success float-right">7</span>
                    <span> Calendario </span>
                </a>
            </li>

            <li class="side-nav-item">
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
            </li>

            <li class="side-nav-item">
                <a href="javascript: void(0);" class="side-nav-link">
                    <i class="dripicons-lock"></i>
                    <span> Administración </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="side-nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{ route('usuarios.index') }}" aria-expanded="false">Usuarios
                        </a>
                    </li>
                </ul>
            </li>
            
        </ul>

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->