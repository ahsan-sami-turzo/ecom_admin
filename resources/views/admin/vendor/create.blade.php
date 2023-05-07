@extends('layouts.admin')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

    <style>
        .col_form_label {
            margin-left: 45px !important;
            text-align: left !important;
        }
    </style>
@endpush
@section('content')
    <form action='{{ route("vendor-information.store") }}' method="post" enctype="multipart/form-data">
        @csrf
        {{-- @isset($vendor)
        @method('PATCH')
        @endisset --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card_header">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="card-title card_title"><i class="fab fa-gg-circle"></i> VENDOR personal
                                    INFORMATION

                                </h4>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-7">
                                @if(Session::has('success'))
                                    <div class="alert alert-success alertsuccess" role="alert">
                                        <strong>Success!</strong> {{Session::get('success')}}
                                    </div>
                                @endif
                                @if(Session::has('error'))
                                    <div class="alert alert-danger alerterror" role="alert">
                                        <strong>Opps!</strong> {{Session::get('error')}}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">Name<span
                                    class="req_star text-left">*</span></label>
                            <label class="col-sm-1 mt-2 text-center">:</label>
                            <div class="col-sm-6">
                                <input name="id" value="{{ isset($vendor) ?  $vendor->id : ''  }}" hidden>
                                <input type="text" class="form-control form_control" name="name"
                                       value="{{old('name', isset($vendor) ?  $vendor->name : Auth::user()->name)}}">
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">Email<span class="req_star ">*</span></label>
                            <label class="col-sm-1 mt-2 text-center">:</label>
                            <div class="col-sm-6">
                                <input type="text" autocomplete="off" class="form-control form_control" name="email"
                                       value="{{old('email',  isset($vendor) ?  $vendor->email : Auth::user()->email)}}">
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">Mobile<span class="req_star ">*</span></label>
                            <label class="col-sm-1 mt-2 text-center">:</label>
                            <div class="col-sm-6">
                                <input type="text" autocomplete="off" class="form-control form_control"
                                       name="phone"
                                       value="{{old('phone', isset($vendor) ?  $vendor->phone  : auth()->user()->phone)}}">
                                @if ($errors->has('phone'))
                                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('nid') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">National ID<span
                                    class="req_star ">*</span></label>
                            <label class="col-sm-1 mt-2 text-center">:</label>
                            <div class="col-sm-6">
                                <input type="text" autocomplete="off" class="form-control form_control"
                                       name="nid" value="{{old('nid', isset($vendor) ? $vendor->nid ?: '' : '')}}">
                                @if ($errors->has('nid'))
                                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('nid') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('dob') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">Date Of Birth<span
                                    class="req_star ">*</span></label>
                            <label class="col-sm-1 mt-2 text-center">:</label>
                            <div class="col-sm-6">
                                <input type="date" autocomplete="off" class="form-control form_control"
                                       name="dob" value="{{old('dob', isset($vendor) ? $vendor->dob ?: '' : '')}}">
                                @if ($errors->has('dob'))
                                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('dob') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('present_address') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">Present Address<span
                                    class="req_star ">*</span></label>
                            <label class="col-sm-1 mt-2 text-center">:</label>
                            <div class="col-sm-6">
                                <textarea type="date" autocomplete="off" class="form-control form_control"
                                          name="present_address"> {{old('present_address', isset($vendor) ? $vendor->present_address ?: '' : '')}}</textarea>
                                @if ($errors->has('present_address'))
                                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('present_address') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card_header">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="card-title card_title"><i class="fab fa-gg-circle"></i> VENDOR Business
                                    INFORMATION

                                </h4>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row mb-3 {{ $errors->has('product_category') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">Product Category<span
                                    class="req_star ">*</span></label>
                            <label class="col-sm-1 mt-2 text-center">:</label>
                            <div class="col-sm-6">
                                <select class="form-control form_control select2" name="product_category[]" multiple>
                                    @if(!empty($vendor->product_category) )
                                        @foreach($categories as $category)
                                            <option
                                                value="{{ $category->id }}"
                                                @if($vendor->product_category != "null")
                                                {{ in_array($category->id, json_decode($vendor->product_category)) ? 'selected' : ''}}
                                                    @endif
                                                >{{ $category->category_name ?: '' }}</option>
                                        @endforeach
                                    @else
                                        @foreach($categories as $category)
                                            <option class="custom-style" value="{{ $category->id}}"
                                                    style="font-weight: 900 !important; display: block !important; "><?= str_repeat("&nbsp; ", $category->level)?> {{  $category->category_name}}</option>
                                            @endforeach
                                        @endif

                                    </select>
                                    @if ($errors->has('product_category'))
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('product_category') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row mb-3 {{ $errors->has('trade_licence') ? ' has-error' : '' }}">
                                <label class="col-sm-3 col-form-label col_form_label">Trade Licence<span
                                        class="req_star ">*</span></label>
                                <label class="col-sm-1 mt-2 text-center">:</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form_control" name="trade_licence"
                                           value="{{old('trade_licence', isset($vendor) ? $vendor->trade_licence ?: '' : '')}}">
                                    @if ($errors->has('trade_licence'))
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('trade_licence') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row mb-3 {{ $errors->has('tin') ? ' has-error' : '' }}">
                                <label class="col-sm-3 col-form-label col_form_label">Tin<span
                                        class="req_star ">*</span></label>
                                <label class="col-sm-1 mt-2 text-center">:</label>
                                <div class="col-sm-6">
                                    <input type="text" autocomplete="off" class="form-control form_control" name="tin"
                                           value="{{old('tin', isset($vendor) ? $vendor->tin ?: '' : '')}}">
                                    @if ($errors->has('tin'))
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('tin') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row mb-3 {{ $errors->has('vat_registration') ? ' has-error' : '' }}">
                                <label class="col-sm-3 col-form-label col_form_label">VAT Registration No.<span
                                        class="req_star ">*</span></label>
                                <label class="col-sm-1 mt-2 text-center">:</label>
                                <div class="col-sm-6">
                                    <input type="text" autocomplete="off" class="form-control form_control"
                                           name="vat_registration"
                                           value="{{old('vat_registration',isset($vendor) ? $vendor->vat_registration ?: '' : '')}}">
                                    @if ($errors->has('vat_registration'))
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('vat_registration') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row mb-3 {{ $errors->has('dob') ? ' has-error' : '' }}">
                                <label class="col-sm-3 col-form-label col_form_label">Business Start Date<span
                                        class="req_star ">*</span></label>
                                <label class="col-sm-1 mt-2 text-center">:</label>
                                <div class="col-sm-6">
                                    <input type="date" autocomplete="off" class="form-control form_control"
                                           name="dob" value="{{old('dob',isset($vendor) ? $vendor->dob ?: '' : '')}}">
                                    @if ($errors->has('dob'))
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('dob') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card_header">
                            <div class="row">
                                <div class="col-md-8">
                                    <h4 class="card-title card_title"><i class="fab fa-gg-circle"></i> VENDOR Shop
                                        INFORMATION

                                    </h4>
                                </div>

                            </div>
                        </div>
                        <div class="card-body">

                            <div class="form-group row mb-3 {{ $errors->has('shop_name') ? ' has-error' : '' }}">
                                <label class="col-sm-3 col-form-label col_form_label">Shop Name<span
                                        class="req_star ">*</span></label>
                                <label class="col-sm-1 mt-2 text-center">:</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form_control" name="shop_name"
                                           value="{{old('shop_name',isset($vendor) ? $vendor->shop_name ?: '' : '')}}">
                                    @if ($errors->has('shop_name'))
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('shop_name') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-3 {{ $errors->has('shop_language') ? ' has-error' : '' }}">
                                <label class="col-sm-3 col-form-label col_form_label">Shop Language<span
                                        class="req_star ">*</span></label>
                                <label class="col-sm-1 mt-2 text-center">:</label>
                                <div class="col-sm-6">
                                    <select class="form-control form_control select2" name="shop_language">
                                        <option value="0">--Select Language Name--</option>
                                        @foreach ( $languages as $key => $language)
                                            <option value="{{ $language }}"
                                                {{ isset($vendor->shop_language) ? $language == $vendor->shop_language ? 'selected' : '' : '' }} >{{ $language ?: '' }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('shop_language'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('shop_language') }}</strong>
                                        </span>
                                    @endif

                                </div>
                            </div>
                            <div class="form-group row mb-3 {{ $errors->has('shop_country') ? ' has-error' : '' }}">
                                <label class="col-sm-3 col-form-label col_form_label">Shop Country<span
                                        class="req_star ">*</span></label>
                                <label class="col-sm-1 mt-2 text-center">:</label>
                                <div class="col-sm-6">
                                    <select class="form-control form_control select2" name="shop_country">
                                        <option value="0">--Select Country Name--</option>
                                        @foreach ( $countries as $key => $country)
                                            <option
                                                value="{{ $country }}" {{ isset($vendor->shop_country) ? $country == $vendor->shop_country ? 'selected' : '' : '' }} >{{ $country ?: '' }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('shop_country'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('shop_country') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card_header">
                            <div class="row">
                                <div class="col-md-8">
                                    <h4 class="card-title card_title"><i class="fab fa-gg-circle"></i> Vendor Image
                                        information
                                    </h4>
                                </div>

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-7">
                                    @if(Session::has('success'))
                                        <div class="alert alert-success alertsuccess" role="alert">
                                            <strong>Success!</strong> {{Session::get('success')}}
                                        </div>
                                    @endif
                                    @if(Session::has('error'))
                                        <div class="alert alert-danger alerterror" role="alert">
                                            <strong>Opps!</strong> {{Session::get('error')}}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-2"></div>
                            </div>

                            <!-- VENDOR IMAGE  -->
                            <div class="form-group row mb-3 {{ $errors->has('vendorImage') ? ' has-error' : '' }}">
                                <label class="col-sm-3 col-form-label col_form_label">Vendor Image (240 x 240)<span
                                        class="req_star ">*</span></label>
                                <label class="col-sm-1 mt-2 text-center">:</label>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <span class="btn btn-default btn-file btnu_browse">
                                                Browse… <input type="file" name="vendorImage" id="imgInp-one">
                                            </span>
                                        </span>
                                        <input type="text" class="form-control" readonly>
                                    </div>
                                    @if ($errors->has('vendorImage'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('vendorImage') }}</strong>
                                    </span>
                                    @endif
                                    <img style="height: 80px; margin-top: 10px" id="img-upload-one"
                                         src='{{ isset($vendor->vendorImage) ? asset("uploads/vendor/vendor-image/optimize/$vendor->vendorImage") : ''}}'/>
                                </div>
                            </div>

                            <!-- BRAND IMAGE  -->
                            <div class="form-group row mb-3 {{ $errors->has('brandImage') ? ' has-error' : '' }}">
                                <label class="col-sm-3 col-form-label col_form_label">Brand Image (1800 x 600)<span
                                        class="req_star ">*</span></label>
                                <label class="col-sm-1 mt-2 text-center">:</label>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <span class="btn btn-default btn-file btnu_browse">
                                                Browse… <input type="file" name="brandImage" id="imgInp-two">
                                            </span>
                                        </span>
                                        <input type="text" class="form-control" readonly>
                                    </div>
                                    @if ($errors->has('brandImage'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('brandImage') }}</strong>
                                    </span>
                                    @endif
                                    <img style="height: 80px; margin-top: 10px" id="img-upload-two"
                                         src='{{ isset($vendor->brandImage) ? asset("uploads/vendor/brand-image/optimize/$vendor->brandImage") : ''}}'/>
                                </div>
                            </div>

                            <!-- LOGO  -->
                            <div class="form-group row mb-3 {{ $errors->has('logo') ? ' has-error' : '' }}">
                                <label class="col-sm-3 col-form-label col_form_label">Vendor logo (240 x 240)<span
                                        class="req_star ">*</span></label>
                                <label class="col-sm-1 mt-2 text-center">:</label>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <span class="btn btn-default btn-file btnu_browse">
                                                Browse… <input type="file" name="logo" id="imgInp-three">
                                            </span>
                                        </span>
                                        <input type="text" class="form-control" readonly>
                                    </div>
                                    @if ($errors->has('logo'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('logo') }}</strong>
                                    </span>
                                    @endif
                                    <img style="height: 80px; margin-top: 10px" id="img-upload-three"
                                         src='{{ isset($vendor->logo) ? asset("uploads/vendor/logo/optimize/$vendor->logo") : ''}}'/>
                                </div>
                            </div>

                            <!-- COVER PHOTO  -->
                            <div class="form-group row mb-3 {{ $errors->has('cover_photo') ? ' has-error' : '' }}">
                                <label class="col-sm-3 col-form-label col_form_label">Vendor Cover Image (1800 x 600)<span
                                        class="req_star ">*</span></label>
                                <label class="col-sm-1 mt-2 text-center">:</label>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <span class="btn btn-default btn-file btnu_browse">
                                                Browse… <input type="file" name="cover_photo" id="imgInp-cover">
                                            </span>
                                        </span>
                                        <input type="text" class="form-control" readonly>
                                    </div>
                                    @if ($errors->has('cover_photo'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('cover_photo') }}</strong>
                                    </span>
                                    @endif
                                    <img style="height: 80px; margin-top: 10px" id="img-upload-cover"
                                         src='{{ isset($vendor->cover_photo) ? asset("uploads/vendor/cover/optimize/$vendor->cover_photo") : ''}}'/>
                                </div>
                            </div>


                        </div>
                        <div class="card-footer card_footer text-center">
                            <button type="submit" class="btn btn-md btn-dark">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endsection
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function () {
                $('.select2').select2();
            });
        </script>
        <script>
            //Image Upload Script
            $(document).ready(function () {
                $(document).on('change', '.btn-file :file', function () {
                    var input = $(this),
                        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                    input.trigger('fileselect', [label]);
                });

                $('.btn-file :file').on('fileselect', function (event, label) {

                    var input = $(this).parents('.input-group').find(':text'),
                        log = label;

                    if (input.length) {
                        input.val(log);
                    } else {
                        if (log)
                            alert(log);
                    }

                });

                function readURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function (e) {
                            $('#img-upload-test').attr('src', e.target.result);
                        }

                        reader.readAsDataURL(input.files[0]);
                    }
                }

                $("#imgInp-test").change(function () {
                    readURL(this);
                });

            });

            //Image Upload Script
            $(document).ready(function () {
                $(document).on('change', '.btn-file :file', function () {
                    var input = $(this),
                        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                    input.trigger('fileselect', [label]);
                });

                $('.btn-file :file').on('fileselect', function (event, label) {

                    var input = $(this).parents('.input-group').find(':text'),
                        log = label;

                    if (input.length) {
                        input.val(log);
                    } else {
                        if (log)
                            alert(log);
                    }

                });

                function readURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function (e) {
                            $('#img-upload-one').attr('src', e.target.result);
                        }

                        reader.readAsDataURL(input.files[0]);
                    }
                }

                $("#imgInp-one").change(function () {
                    readURL(this);
                });

            });

            //Image Upload Script
            $(document).ready(function () {
                $(document).on('change', '.btn-file :file', function () {
                    var input = $(this),
                        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                    input.trigger('fileselect', [label]);
                });

                $('.btn-file :file').on('fileselect', function (event, label) {

                    var input = $(this).parents('.input-group').find(':text'),
                        log = label;

                    if (input.length) {
                        input.val(log);
                    } else {
                        if (log)
                            alert(log);
                    }

                });

                function readURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function (e) {
                            $('#img-upload-two').attr('src', e.target.result);
                        }

                        reader.readAsDataURL(input.files[0]);
                    }
                }

                $("#imgInp-two").change(function () {
                    readURL(this);
                });

            });

            //Image Upload Script
            $(document).ready(function () {
                $(document).on('change', '.btn-file :file', function () {
                    var input = $(this),
                        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                    input.trigger('fileselect', [label]);
                });

                $('.btn-file :file').on('fileselect', function (event, label) {

                    var input = $(this).parents('.input-group').find(':text'),
                        log = label;

                    if (input.length) {
                        input.val(log);
                    } else {
                        if (log)
                            alert(log);
                    }

                });

                function readURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function (e) {
                            $('#img-upload-three').attr('src', e.target.result);
                        }

                        reader.readAsDataURL(input.files[0]);
                    }
                }

                $("#imgInp-three").change(function () {
                    readURL(this);
                });

            });

            //Image Upload Script
            $(document).ready(function () {
                $(document).on('change', '.btn-file :file', function () {
                    var input = $(this),
                        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                    input.trigger('fileselect', [label]);
                });

                $('.btn-file :file').on('fileselect', function (event, label) {

                    var input = $(this).parents('.input-group').find(':text'),
                        log = label;

                    if (input.length) {
                        input.val(log);
                    } else {
                        if (log)
                            alert(log);
                    }

                });

                function readURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function (e) {
                            $('#img-upload-cover').attr('src', e.target.result);
                        }

                        reader.readAsDataURL(input.files[0]);
                    }
                }

                $("#imgInp-cover").change(function () {
                    readURL(this);
                });

            });
        </script>
    @endpush
