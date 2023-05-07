<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Dashboard for Software and Website" name="description"/>
    <meta content="Uzzal" name="author"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard</title>
    <link rel="shortcut icon" href="{{asset('contents/admin')}}/assets/images/csl-icon.png">
    <link rel="stylesheet" href="{{asset('contents/admin')}}/assets/css/bootstrap.min.css" id="bootstrap-style"/>
    <link rel="stylesheet"
          href="{{asset('contents/admin')}}/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css"/>
    <link rel="stylesheet"
          href="{{asset('contents/admin')}}/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="{{asset('contents/admin')}}/assets/css/icons.min.css"/>
    <link rel="stylesheet" href="{{asset('contents/admin')}}/assets/css/app.min.css" id="app-style"/>
    @stack('css')
    <link rel="stylesheet" href="{{asset('contents/admin')}}/assets/css/style.css"/>

    <script src="{{asset('contents/admin')}}/assets/libs/jquery/jquery.min.js"></script>

</head>
<body data-sidebar="dark">
<div id="layout-wrapper">
    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <div class="navbar-brand-box bg-white">
                    <a href="{{url('dashboard')}}" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="{{asset('contents/admin')}}/assets/images/csl-icon-white.png" alt=""
                                     height="22">
                            </span>
                        <span class="logo-lg">
                                <img src='{{ asset("uploads/logo/logo.png") }}' alt="logo" height="50">
                            </span>
                    </a>
                </div>
                <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect"
                        id="vertical-menu-btn">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
                <form class="app-search d-none d-lg-block">
                    <div class="position-relative">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="bx bx-search-alt"></span>
                    </div>
                </form>
            </div>
            <div class="d-flex">
                <div class="dropdown d-inline-block d-lg-none ml-2">
                    <button type="button" class="btn header-item noti-icon waves-effect"
                            id="page-header-search-dropdown"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="mdi mdi-magnify"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                         aria-labelledby="page-header-search-dropdown">
                        <form class="p-3">
                            <div class="form-group m-0">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search ..."
                                           aria-label="Recipient's username">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="dropdown d-none d-lg-inline-block ml-1">
                    <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                        <i class="bx bx-fullscreen"></i>
                    </button>
                </div>
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item noti-icon waves-effect"
                            id="page-header-notifications-dropdown"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-bell bx-tada"></i>
                        <span class="badge badge-danger badge-pill">1</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                         aria-labelledby="page-header-notifications-dropdown">
                        <div class="p-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="m-0" key="t-notifications"> Notifications </h6>
                                </div>
                                <div class="col-auto">
                                    <a href="#!" class="small" key="t-view-all"> View All</a>
                                </div>
                            </div>
                        </div>
                        <div data-simplebar style="max-height: 230px;">
                            <a href="#" class="text-reset notification-item">
                                <div class="media">
                                    <div class="avatar-xs mr-3">
                                                <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                    <i class="bx bx-cart"></i>
                                                </span>
                                    </div>
                                    <div class="media-body">
                                        <h6 class="mt-0 mb-1" key="t-your-order">Your order is placed</h6>
                                        <div class="font-size-12 text-muted">
                                            <p class="mb-1" key="t-grammer">languages coalesce the grammar</p>
                                            <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-min-ago">3 min ago</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="p-2 border-top">
                            <a class="btn btn-sm btn-link font-size-14 btn-block text-center" href="javascript:void(0)">
                                <i class="mdi mdi-arrow-right-circle mr-1"></i> <span
                                    key="t-view-more">View More..</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle header-profile-user"
                             src="{{asset('contents/admin')}}/assets/images/users/avatar-black.png" alt="Header Avatar">
                        <span class="d-none d-xl-inline-block ml-1" key="t-henry">{{ auth()->user()->name ?: ''}}<br>
                                @if(!empty(Auth::user()->getRoleNames()))
                                @foreach(Auth::user()->getRoleNames() as $v)
                                    <label class="badge badge-success">{{ $v }}</label>
                                @endforeach
                            @endif
                                </span><i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{url('dashboard/account')}}"><i
                                class="bx bx-user font-size-16 align-middle mr-1"></i> <span>Profile</span></a>
                        <a class="dropdown-item" href="#"><i class="bx bx-wallet font-size-16 align-middle mr-1"></i>
                            <span>My Wallet</span></a>
                        <a class="dropdown-item d-block" href="#"><i
                                class="bx bx-wrench font-size-16 align-middle mr-1"></i> <span>Settings</span></a>
                        <a class="dropdown-item" href="#"><i class="bx bx-lock-open font-size-16 align-middle mr-1"></i>
                            <span>Lock screen</span></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                           onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                                class="bx bx-power-off font-size-16 align-middle mr-1 text-danger"></i>
                            <span>Logout</span></a>


                    </div>

                </div>
            </div>
        </div>
    </header>
    <div class="vertical-menu">
        <div data-simplebar class="h-100">
            <div id="sidebar-menu">
                <ul class="metismenu list-unstyled" id="side-menu">
                    <li class="menu-title" key="t-menu">Navigation</li>

                    <li>
                        <a href="{{route('dash')}}" class="waves-effect"><i class="bx bx-home-circle"></i><span>Dashboard</span></a>
                    </li>
                    @role('vendor')
                    <li><a href="#" class="waves-effect"><i class="bx bx-store"></i><span>Products</span></a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('products.index') }}">Products list</a></li>
                        </ul>
                    </li>
                    <li><a href="#" class="waves-effect"><i class="bx bx-store"></i><span>Product Purchase</span></a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('purchases.index') }}">Product Purchase list</a></li>
                            <li><a href={{ route("purchase-returns.index") }}>Purchase Return List</a></li>
                        </ul>
                    </li>

                    @endrole

                    {{--                            <li><a href="#" class="waves-effect"><i class="bx bx-cog"></i><span>Setting</span></a>--}}
                    {{--                                <ul class="sub-menu" aria-expanded="false">--}}
                    {{--                                    <li><a href="{{route('user.index')}}">User list</a></li>--}}
                    {{--                                    <li><a href="{{route('role.index')}}">Role Permission</a></li>--}}
                    {{--                                    <li><a href="{{url('dashboard/manage/social')}}">Social Media</a></li>--}}
                    {{--                                    <li><a href="{{url('dashboard/manage/contact')}}">Contact Information</a></li>--}}
                    {{--                                </ul>--}}
                    {{--                            </li>--}}
                    @role('admin')
                    <li><a href="#" class="waves-effect"><i class="bx bx-album"></i><span>Category</span></a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href={{ route("category.index") }}>Category List</a></li>
                            <li><a href={{ route("featured-category.index") }}>Feature Category List</a></li>
                            <li><a href={{ route("category-aside-navbar.index") }}>Category Aside Navbar List</a></li>
                            <li><a href={{ route("category-top-navbar.index") }}>Category Top Navbar List</a></li>

                        </ul>
                    </li>
                    <li><a href="#" class="waves-effect"><i class="bx bx-store"></i><span>Products Configuration</span></a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href={{ route("color-info.index") }}>Color Info list</a></li>
                            <li><a href={{ route("size-type.index") }}>Size Type list</a></li>
                            <li><a href={{ route("size-info.index") }}>Size Info list</a></li>
                            <li><a href={{ route("weight-type.index") }}>Weight Type list</a></li>
                            <li><a href={{ route("weight-info.index") }}>Weight Info list</a></li>
                            <li><a href={{ route("unity-of-measurement.index") }}>Unit of measurement list</a></li>
                            <li><a href={{ route("product-specification-details.index") }}>Product Specification Details
                                    list</a></li>
                            <li><a href={{ route("product-specification-info.index") }}>Product Specification Details
                                    Info list</a></li>

                            {{--                            <li><a href={{ route("size-type.index") }}>Size Type List</a></li>--}}
                            {{--                            <li><a href={{ route("size-info.index") }}>Size Info List</a></li>--}}
                            {{--                            <li><a href={{ route("weight-type.index") }}>Weight Type List</a></li>--}}

                        </ul>
                    </li>
                    <li><a href="#" class="waves-effect"><i class="bx bx-store"></i><span>Products</span></a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('product.index') }}">Products list</a></li>
                            <li><a href={{ route("feature-name.index") }}>Feature Name List</a></li>
                            <li><a href={{ route("feature-product.index") }}>Add Feature Product List</a></li>
                        </ul>
                    </li>
                    <li><a href="#" class="waves-effect"><i class="bx bx-store"></i><span>Product Purchase</span></a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('purchase.index') }}">Product Purchase list</a></li>
                            <li><a href={{ route("purchase-return.index") }}>Purchase Return List</a></li>
                        </ul>
                    </li>
                    <li><a href="#" class="waves-effect"><i class="bx bx-album"></i><span>Vendor</span></a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href={{ route("vendor.pending.list") }}>Vendor Pending List</a></li>
                            <li><a href={{ route("vendor.active.list") }}>Vendor Active List</a></li>
                        </ul>
                    </li>

                    <li><a href="#" class="waves-effect"><i class="bx bx-album"></i><span>Setting</span></a>
                        <ul class="sub-menu" aria-expanded="false">

                            <li><a href={{ route("roles.index") }}>Role List</a></li>
                            <li><a href={{ route("user.index") }}>User List</a></li>

                            <li><a href={{ route("commission.index") }}>Commission list</a></li>
                            <li><a href={{ route("language.index") }}>language list</a></li>
                            <li><a href={{ route("country.index") }}>Country list</a></li>
                            <li><a href={{ route("brand.index") }}>Brand list</a></li>
                            <li><a href={{ route("banner.index") }}>Banner list</a></li>
                            <li><a href={{ route("advertisement.index") }}>Advertisement list</a></li>
                            <li><a href={{ route("condition-type.index") }}>Condition type list</a></li>
                            <li><a href={{ route("terms.index") }}>Terms Condition list</a></li>
                            <li><a href={{ route("discounts.index") }}>Discount list</a></li>
                            <li><a href={{ route("coupons.index") }}>Coupon list</a></li>


                            {{--<li><a href='{{ "#" }}'>User list</a></li>--}}
                            {{--                                    <li><a href="{{"#"}}">Role Permission</a></li>--}}
                            {{--                                    <li><a href="{{"#"}}">Social Media</a></li>--}}
                            {{--                                    <li><a href="{{"#"}}">Contact Information</a></li>--}}
                        </ul>
                    </li>
                    @endrole

                    <li><a href="#" class="waves-effect"><i class="bx bx-store"></i><span>CAMPAIGNS</span>
                            <span style="position: absolute;right: 24px;top: 0;" class="badge badge-danger badge-pill">1</span><i style="float: right" class="bx bx-bell bx-tada"></i></a>
                        <ul class="sub-menu" aria-expanded="false">
                            @role('admin')
                                 <li><a href={{ route("discount-campaign.index") }}>Discount campaign</a></li>
                            <li><a href={{ route("all-vendor-campaign.all") }}>All Vendors discount campaign offer</a></li>

                            @endrole
                            @role('vendor')
                                 <li><a href={{ route("campaign-offer.index") }}>Discount campaign offer</a></li>
                                 <li><a href={{ route("vendor-campaign-list.all") }}>Vendor discount campaign offer</a></li>

                            @endrole
                        </ul>
                    </li>

                    {{-- <li><a href="{{ route('logout') }}"
                           onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                           class="waves-effect"><i class="bx bx-power-off"></i><span>Logout</span></a></li> --}}

                    <li>
                        <a class="waves-effect" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();"><i
                                class="bx bx-power-off"></i><span> {{ __('Logout') }}</span></a>


                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Dashboard</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Home</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                @yield('content')
            </div>
        </div>
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        Copyright © 2021 | All rights reserved by Dashboard.
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-right d-none d-sm-block">
                            Development by ambalait.com.
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<form id="logout-form" action="{{ ('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<script src="{{asset('contents/admin')}}/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('contents/admin')}}/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{asset('contents/admin')}}/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{asset('contents/admin')}}/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="{{asset('contents/admin')}}/assets/libs/metismenu/metisMenu.min.js"></script>
<script src="{{asset('contents/admin')}}/assets/libs/simplebar/simplebar.min.js"></script>
<script src="{{asset('contents/admin')}}/assets/libs/node-waves/waves.min.js"></script>
<script src="{{asset('contents/admin')}}/assets/js/pages/dashboard.init.js"></script>
<script src="{{asset('contents/admin')}}/assets/js/app.js"></script>
@stack('scripts')
<script src="{{asset('contents/admin')}}/assets/js/custom.js"></script>
<script>
    $(document).on("scroll", function () {
        if
        ($(document).scrollTop() > 86) {
            $(".top-navbar").addClass("onScroll");
        } else {
            $(".top-navbar").removeClass("onScroll");
        }
    });

</script>
</body>
</html>
