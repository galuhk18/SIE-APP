<nav class="navbar navbar-expand navbar-dark bg-light topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link text-dark  rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                
                @if (session()->has('admin_id'))
                    @php
                        $user_admin = DB::table('admin')->where('id', session('admin_id'))->first();
                    @endphp
                    <span class="mr-2 d-none d-lg-inline text-dark">Hi, {{ $user_admin->name }} </span>
                @endif
                
                @if (session()->has('executive_id'))
                    @php
                        $user_executive = DB::table('executive')->where('id', session('executive_id'))->first();
                    @endphp
                    <span class="mr-2 d-none d-lg-inline text-dark">Hi, {{ $user_executive->name }} </span>
                @endif
               
                <i class="fa fa-user text-dark"></i>
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    @if (session()->has('admin_id'))
                        {{ $user_admin->username }}
                    @endif

                    @if (session()->has('executive_id'))
                        {{ $user_executive->username }}
                    @endif
                </a>



                <div class="dropdown-divider"></div>

                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
