<header class="navigation fixed-top">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-white">
            <a class="navbar-brand order-1" href="{{ route('home.index') }}">
                <img class="img-fluid" width="100px" src="frontend/images/logo.png"
                    alt="Reader | Hugo Personal Blog Template">
            </a>
            <div class="collapse navbar-collapse text-center order-lg-2 order-3" id="navigation">
                {!! $html !!}
            </div>

            <div class="order-2 order-lg-3 d-flex align-items-center">
                <div class="order-2 order-lg-3 d-flex align-items-center">
                    @if (isset(Auth::user()->id))
                        <ul class="navbar-nav mx-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link text-success" href="#" role="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Xin chào, {{ Auth::user()->name }}<i class="ti-angle-down ml-1"></i>
                                </a>
                                <div class="dropdown-menu">
                                    @php
                                        $name = createSlug(Auth::user()->name);
                                        $id = Auth::user()->id;
                                    @endphp
                                    <a class="dropdown-item"
                                        href="{{ route('client.managerAccount', ['name' => $name, 'id' => $id]) }}">Quản
                                        lý tài
                                        khoản</a>
                                    <a class="dropdown-item" href="{{ route('client.logout') }}">Đăng xuất</a>
                                </div>
                            </li>
                        </ul>
                    @else
                        <button id="openModal" class="btn btn-primary">
                            <i class="ti ti-user"></i> Đăng Nhập
                        </button>
                    @endif
                </div>

                <div id="myModal" class="modal">
                </div>

                {{-- <div class="order-2 order-lg-3 d-flex align-items-center">
                    <a href="{{route('client')}}" class="text-success">
                        <i class="ti ti-user"></i> Đăng nhập</a>
                </div> --}}
                <button class="navbar-toggler border-0 order-1" type="button" data-toggle="collapse"
                    data-target="#navigation">
                    <i class="ti-menu"></i>
                </button>
            </div>

        </nav>
    </div>
</header>
