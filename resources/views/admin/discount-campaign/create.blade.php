@extends('layouts.admin')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <style>
        .custom-style {
            font-weight: 900 !important;
            display: block !important;
        }

    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <form method="post" action="{{route('discount-campaign.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header card_header">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="card-title card_title"><i class="fab fa-gg-circle"></i> Add Discount Campaign
                                </h4>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="{{route('discount-campaign.index')}}"
                                   class="btn btn-dark btn-md waves-effect btn-label waves-light card_btn"><i
                                        class="fas fa-th label-icon"></i>All Discount Campaign</a>
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
                            <label class="col-sm-3 col-form-label col_form_label text-left">Campaign name<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-5">
                                <input type="text" autocomplete="off" class="form-control form_control"
                                       name="name"
                                       value="{{old('name')}}">
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('campagin_discount_type') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label text-left">Discount type<span
                                    class="req_star">*</span>:</label>

                            <div class="col-3">
                                <select class="form-control " id="discount_type" name="campagin_discount_type">
                                    <option value="0">---Select Discount type---</option>
                                    <option class="custom-style" value="percentage"
                                            style="font-weight: 500 !important; "> Percentage
                                    </option>
                                    <option class="custom-style" value="taka" style="font-weight: 500 !important; ">
                                        Amount
                                    </option>
                                </select>
                                @if ($errors->has('discount_type'))
                                    <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('discount_type') }}</strong>
                                     </span>
                                @endif
                            </div>
                            <div class="col-sm-2">
                                <input type="number" id="discountNum" autocomplete="off"
                                       class="form-control form_control" name=""
                                       value="{{old('amount')}}" max="99" min="0" placeholder="">
                                @if ($errors->has('amount'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('effective_from') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label text-left">Effective form<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-2">
                                <input type="date" autocomplete="off" class="form-control form_control"
                                       name="effective_from"
                                       value="{{old('effective_from')}}">
                                @if ($errors->has('effective_from'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('effective_from') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('effective_to') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label text-left">Effective to<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-2">
                                <input type="date" autocomplete="off" class="form-control form_control"
                                       name="effective_to"
                                       value="{{old('effective_to')}}">
                                @if ($errors->has('effective_to'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('effective_to') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('description') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label text-left">Campaign description<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-5">
                                <textarea style="height: 150px" type="text" autocomplete="off"
                                          class="form-control form_control"
                                          name="description">{{old('description')}}</textarea>
                                @if ($errors->has('description'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                    </div>
                    <div class="card-footer card_footer text-center">
                        <button type="submit" class="btn btn-md btn-dark">Submit</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2(
                {
                    placeholder: "Select name",
                    tags: true,
                    tokenSeparators: [',', ' ']
                }
            );
            // all vendors checked
            $('#allVendors').on('change', function () {
                if ($(this).is(':checked')) {
                    // Do something...
                    $('.vendors').prop("disabled", true);
                } else {
                    $('.vendors').prop("disabled", false);

                }

            });

            // all Categories checked
            $('#allCategories').on('change', function () {
                if ($(this).is(':checked')) {
                    // Do something...
                    $('.category').prop("disabled", true);
                } else {
                    $('.category').prop("disabled", false);
                }
            });

            // all Products checked
            $('#allProducts').on('change', function () {
                if ($(this).is(':checked')) {
                    // Do something...
                    $('.product').prop("disabled", true);
                } else {
                    $('.product').prop("disabled", false);
                }

            });
            // all discount_type checked
            $("#discount_type").on('change', function () {
                $("#discountNum").val(0);
                if ($(this).val() == 'percentage') {
                    $('#discountNum').attr("placeholder", "% here").attr('name', 'percentage');

                } else {
                    $('#discountNum').attr("placeholder", "Tk here").attr('name', 'amount');
                }
            });
            // all discount_type checked

            $("#delivery_type").on('change', function () {
                if ($(this).val() == 'delivery_amount') {
                    $('#deliveryAmount').removeClass('d-none');
                    $('#deliveryAmount').attr("placeholder", "Amount here").attr('name', 'delivery_amount');
                } else {
                    $('#deliveryAmount').addClass('d-none');
                }
            });

            $('#vendorsID').on('change', function () {
                let vendorsId = $(this).val();

            });

        });
    </script>

@endpush
