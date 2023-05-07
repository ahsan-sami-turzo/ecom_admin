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
                <div class="kt-portlet__body">
                    <div class="kt-section kt-section--first">
                        <div class="kt-section__body">

                            <div class="form-group row justify-content-center">
                                <div class="col-lg-8 col-xl-8">
                                    <label class="col-form-label">Activity Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           value="" name="name"
                                           placeholder="Activity name here">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row justify-content-center">
                                <div style="position: relative" class="col-lg-8 col-xl-8">
                                    <label class="col-form-label">Project Name <span class="text-danger">*</span></label>
                                    <select id="projectId" style="width: 100%" class="form-control select2 @error('goal_id') is-invalid @enderror" name="project_id">
                                        <option value="">--Select project Name--</option>

                                        <option value="">name</option>

                                    </select>



                                    @error('project_id')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>



                            </div>

                            <div class="form-group row justify-content-center">
                                <div class="col-lg-8 col-xl-8">
                                    <label class="col-form-label">Activity Description</label>
                                    <textarea type="text" class="form-control @error('description') is-invalid @enderror"
                                              name="description"
                                              placeholder=" Activity description here">{{ !empty($activity)? $activity->description : old('description') }}</textarea>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row justify-content-center">

                                <div style="padding-left: -30px" class="col-lg-4 col-xl-4">
                                    <label class="col-form-label">Start Date <span class="text-danger">* </span></label>
                                    <input class="form-control @error('start_date') is-invalid @enderror" type="date" name="start_date"
                                           value="{{ !empty($activity)? $activity->start_date : old('start_date') }}">
                                    @error('start_date')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <div class="col-lg-4 col-xl-4">
                                    <label class="col-form-label">End Date <span class="text-danger"> </span></label>
                                    <input class="form-control" type="date" name="end_date"
                                           value="{{ !empty($activity)? $activity->end_date : old('end_date') }}">

                                </div>

                            </div>
                            <div class="form-group row justify-content-center">
                                <div style="padding-left: -30px" class="col-lg-4 col-xl-4">
                                    <label class="col-form-label">Time <span class="text-danger">* </span></label>
                                    <input class="form-control @error('hour') is-invalid @enderror"  type="text" name="hour"
                                           value="{{ !empty($activity)? $activity->hour : old('hour') }}" placeholder=" Activity hour here">
                                    @error('hour')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <div class="col-lg-4 col-xl-4"></div>

                            </div>
                            <div class="form-group row justify-content-center">
                                <div class="col-lg-8 col-xl-6">
                                    <div>
                                        <label class="col-form-label ">Image<span class="text-danger"></span></label>
                                    </div>
                                    <div class="kt-avatar kt-avatar--outline kt-avatar--circle-" id="kt_profile_avatar">
                                        <div class="kt-avatar__holder"
                                             style="background-image: url('{{ !empty($activity)? asset("uploads/events/$activity->image") : asset('uploads/avatar.jpg') }}');"></div>
                                        <label class="kt-avatar__upload" data-toggle="kt-tooltip" title=""
                                               data-original-title="Change avatar">
                                            <i class="fa fa-pen"></i>
                                            <input class="" type="file" name="image"/>
                                        </label>
                                        <span class="kt-avatar__cancel" data-toggle="kt-tooltip" title=""
                                              data-original-title="Cancel avatar">
                                                <i class="fa fa-times"></i>
                                            </span>
                                    </div>
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 col-xl-6">
                                <button type="submit" class="btn btn-brand btn-bold">Submit</button>&nbsp;
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end:: Content -->
        @endsection
        @push('js')
            <script src="{{ asset('contents/admin') }}/assets/plugins/custom/datatables/datatables.bundle.js"></script>
            <script src="{{ asset('contents/admin') }}/assets/js/pages/components/datatables/data-sources/html.js"></script>
        @endpush



