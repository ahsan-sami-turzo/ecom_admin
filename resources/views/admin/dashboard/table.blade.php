@extends('layouts.admin')
@push('css')
    <link href="{{ asset('contents/admin') }}/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@endpush
@section('contents')
        <!-- end:: Header -->
        <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!-- begin:: Subheader -->
        <div class="kt-subheader   kt-grid__item" id="kt_subheader">
            <div class="kt-container  kt-container--fluid ">
                <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">Dashboard</h3>
                    <span class="kt-subheader__separator kt-hidden"></span>
                    <div class="kt-subheader__breadcrumbs">
                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link">
                            Dashboards </a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link">
                            Navy Aside </a>
                        <!-- <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Active link</span> -->
                    </div>

                </div>
                <div class="kt-subheader__toolbar">
                    <div class="kt-subheader__wrapper">
                        <a href="#" class="btn btn-icon btn btn-label btn-label-brand btn-bold" data-toggle="kt-tooltip"
                           title="Reports" data-placement="top"><i class="flaticon2-writing"></i></a>
                        <a href="#" class="btn btn-icon btn btn-label btn-label-brand btn-bold" data-toggle="kt-tooltip"
                           title="Calendar" data-placement="top"><i class="flaticon2-hourglass-1"></i></a>
                        <div class="dropdown dropdown-inline" data-toggle="kt-tooltip" title="Quick actions"
                             data-placement="top">
                            <a href="#" class="btn btn-icon btn btn-label btn-label-brand btn-bold"
                               data-toggle="dropdown" data-offset="0px,0px" aria-haspopup="true" aria-expanded="false">
                                <i class="flaticon2-add-1"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                <ul class="kt-nav kt-nav--active-bg" role="tablist">
                                    <li class="kt-nav__item">
                                        <a href="#" class="kt-nav__link">
                                            <i class="kt-nav__link-icon flaticon2-psd"></i>
                                            <span class="kt-nav__link-text">Document</span>
                                        </a>
                                    </li>
                                    <li class="kt-nav__item">
                                        <a class="kt-nav__link" role="tab">
                                            <i class="kt-nav__link-icon flaticon2-supermarket"></i>
                                            <span class="kt-nav__link-text">Message</span>
                                        </a>
                                    </li>
                                    <li class="kt-nav__item">
                                        <a href="#" class="kt-nav__link">
                                            <i class="kt-nav__link-icon flaticon2-shopping-cart"></i>
                                            <span class="kt-nav__link-text">Product</span>
                                        </a>
                                    </li>
                                    <li class="kt-nav__item">
                                        <a class="kt-nav__link" role="tab">
                                            <i class="kt-nav__link-icon flaticon2-chart2"></i>
                                            <span class="kt-nav__link-text">Report</span>
                                            <span class="kt-nav__link-badge">
                                        <span
                                            class="kt-badge kt-badge--danger kt-badge--inline kt-badge--rounded">pdf</span>
                                    </span>
                                        </a>
                                    </li>
                                    <li class="kt-nav__item">
                                        <a href="#" class="kt-nav__link">
                                            <i class="kt-nav__link-icon flaticon2-sms"></i>
                                            <span class="kt-nav__link-text">Post</span>
                                        </a>
                                    </li>
                                    <li class="kt-nav__item">
                                        <a href="#" class="kt-nav__link">
                                            <i class="kt-nav__link-icon flaticon2-avatar"></i>
                                            <span class="kt-nav__link-text">Customer</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <a href="#" class="btn btn-sm btn-elevate btn-brand btn-elevate"
                           id="kt_dashboard_daterangepicker" data-toggle="kt-tooltip" title="" data-placement="left"
                           data-original-title="Select dashboard daterange">
                            <span class="kt-opacity-7" id="kt_dashboard_daterangepicker_title">Today:</span>&nbsp;
                            <span class="kt-font-bold" id="kt_dashboard_daterangepicker_date">Jan 11</span>
                            <i class="flaticon-calendar-with-a-clock-time-tools kt-padding-l-5 kt-padding-r-0"></i>
                        </a>

                    </div>
                </div>
            </div>
        </div>
        <!-- end:: Subheader -->

        <!-- begin:: content -->
        <div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Activity list :
                        </h3>
                    </div>
                    <div class="kt-portlet__head-label text-right">
                        <a href="" class="btn btn-primary"><i class="fa fa-project-diagram"></i> Add Data</a>
                    </div>
                </div>

                <div class="kt-portlet__body">
                    <!--begin: Datatable -->
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                        <thead>
                        <tr>
                            <th>Sl NO.</th>

                            <th>Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach ($data as $row)
                            <tr>
                                <td></td>
                                 <td nowrap>
                                <span class="dropdown">
                                    <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">
                                      <i class="la la-angle-down"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href=""><i class="la la-edit"></i> Edit Details</a>
                                           <form class="d-inline" action="" method="post">
                                           @method('delete')
                                              @csrf
                                           <button type="submit" onclick="return confirm('Are you sure?')" class="btn font-13 dropdown-item"><i class="fa fa-trash"></i> Delete</button>
                                          </form>

                                    </div>
                                </span>
                                    <a href="" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>

                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <!--end: Datatable -->
                </div>
            </div>
        </div>
        <!-- end:: Content -->
@endsection
@push('js')
    <script src="{{ asset('contents/admin') }}/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="{{ asset('contents/admin') }}/assets/js/pages/components/datatables/data-sources/html.js"></script>
@endpush


