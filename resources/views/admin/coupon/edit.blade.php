@extends('layouts.admin')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <form method="post" action="{{route('coupons.update',$coupon->id)}}" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="card">
                    <div class="card-header card_header">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="card-title card_title"><i class="fab fa-gg-circle"></i> Update Coupon
                                </h4>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="{{route('coupons.index')}}"
                                   class="btn btn-dark btn-md waves-effect btn-label waves-light card_btn"><i
                                        class="fas fa-th label-icon"></i>All Coupon</a>
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
                        <div class="form-group row mb-3 {{ $errors->has('vendor_id') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label text-left"> Vendor name<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-6">
                                <select {{ $coupon->is_all_vendors == 1 ? 'disabled' : '' }} class="form-control select2 vendors " id="parentId" name="vendor_id[]" multiple>
                                    @foreach ($vendors as $vendor)
                                        <option class="custom-style"  {{ in_array($vendor->id, json_decode($coupon->vendor_id)) ? 'selected' : ''}}  value="{{ $vendor->id}}" style="font-weight: 900 !important; display: block !important; "> {{  $vendor->name }}</option>
                                    @endforeach

                                </select>
                                @if ($errors->has('vendor_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('vendor_id') }}</strong>
                                     </span>
                                @endif
                            </div>
                            <div class="col-sm-3">
                                <input id="allVendors"  {{ $coupon->is_all_vendors == 1 ? 'checked' : '' }} type="checkbox" style="margin-top:10px" name="is_all_vendors"
                                       value="true">
                                <span style="font-size: 14px"> all vendors</span>
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('category_id') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label text-left"> Category name<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-6">
                                <select  {{ $coupon->is_all_categories == 1 ? 'disabled' : '' }} class="form-control select2 category" id="categoryId" name="category_id[]" multiple>
                                    @foreach ($categories as $category)
                                        <option class="custom-style"  {{ in_array($category->id, json_decode($coupon->category_id)) ? 'selected' : ''}} value="{{ $category->id}}"
                                                style="font-weight: 900 !important; display: block !important; "> {{  $category->category_name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('category_id'))
                                    <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('category_id') }}</strong>
                                     </span>
                                @endif
                            </div>
                            <div class="col-sm-3">
                                <input id="allCategories" {{ $coupon->is_all_categories == 1 ? 'checked' : '' }}  type="checkbox" style="margin-top:10px" name="is_all_categories"
                                       value="true">
                                <span style="font-size: 14px"> all categories</span>
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('product_id') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label text-left">Product Name<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-6">
                                <select  {{ $coupon->is_all_products == 1 ? 'disabled' : '' }} class="form-control select2 product" id="productId" name="product_id[]" multiple>
                                    @foreach ($products as $product)
                                            <option class="custom-style"  {{ in_array($product->id, json_decode($coupon->product_id)) ? 'selected' : ''}} value="{{ $product->id }}"
                                                    style="font-weight: 900 !important; display: block !important;"> {{  $product->product_name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('category_id'))
                                    <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('category_id') }}</strong>
                                     </span>
                                @endif
                                @if ($errors->has('category_id'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('category_id') }}</strong>
                        </span>
                                @endif
                            </div>
                            <div class="col-sm-3">
                                <input id="allProducts" {{ $coupon->is_all_products == 1 ? 'checked' : '' }} type="checkbox" style="margin-top:10px" name="is_all_products" value="true">
                                <span style="font-size: 14px"> all products</span>
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('percentage') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label text-left">coupon type<span
                                    class="req_star">*</span>:</label>

                            <div class="col-3">
                                <select class ="form-control " id ="coupon_type" name="discount_type">
                                    <option value="0">---Select coupon type---</option>
                                    <option class="custom-style" {{ $coupon->discount_type == 'amount' ? 'selected' : '' }} value="amount" style="font-weight: 500 !important; "> Amount</option>
                                </select>
                                @if ($errors->has('coupon_type'))
                                    <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('coupon_type') }}</strong>
                                     </span>
                                @endif
                            </div>
                            <div class="col-sm-2">
                                <input type="number" id="couponNum" autocomplete="off" class="form-control form_control" name="{{ !empty($coupon->amount) ? 'amount' : 'percentage' }}"
                                       value="{{ !empty($coupon->amount) ? $coupon->amount : $coupon->percentage }}" placeholder="">
                                @if ($errors->has('amount'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('coupon_code') ? 'has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label text-left">Coupon Code<span
                                    class="req_star">*</span>:</label>

                            <div class="col-sm-2">
                                <input type="text" id="couponCode" autocomplete="off" class="form-control form_control"
                                       name="coupon_code"
                                       value="{{old('coupon_code',$coupon->coupon_code)}}" placeholder="">
                                @if ($errors->has('coupon_code'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('coupon_code') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-sm-3">
                                <input id="autoCodeGenerate" type="checkbox"  style="margin-top:10px" value="">
                                <span style="font-size: 14px">Promo Code Generate</span>
                            </div>

                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('effective_from') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label text-left">Effective form<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-2">
                                <input type="date" autocomplete="off" class="form-control form_control"
                                       name="effective_from"
                                       value="{{old('effective_from',$coupon->effective_from)}}">
                                @if ($errors->has('effective_from',))
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
                                       value="{{old('effective_to',$coupon->effective_to)}}">
                                @if ($errors->has('effective_to'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('effective_to') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('percentage') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label text-left">Promo code usable limit<span
                                    class="req_star">*</span>:</label>


                            <div class="col-sm-2">
                                <input type="text" id="usableCode" autocomplete="off" class="form-control form_control"
                                       name="code_usable"
                                       value="{{old('code_usable', $coupon->code_usable)}}" placeholder="">
                                @if ($errors->has('code_usable'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('code_usable') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-sm-3">
                                <input id="unlimitedUsable" type="checkbox"  {{ $coupon->code_usable == 'unlimited' ? 'checked' : '' }} style="margin-top:10px" value="unlimited">
                                <span style="font-size: 14px">Unlimited usable</span>
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
                if ($(this).val() == 'percentage') {
                    $('#couponNum').attr("placeholder", "% here").attr('name', 'percentage');

                } else {
                    $('#couponNum').attr("placeholder", "Tk here").attr('name', 'amount');
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

            //Coupon Code dynamic
            $('#autoCodeGenerate').on('click', function () {
                let isChecked = $(this).is(':checked');
                if (isChecked) {
                    let code = codeGenerate();
                    $('#couponCode').val(code);
                } else {
                    $("#couponCode").val('');
                }
                function codeGenerate() {
                    var text = "";
                    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

                    for (var i = 0; i < 5; i++)
                        text += possible.charAt(Math.floor(Math.random() * possible.length));

                    return text;
                }
            });

            //Promo code usable limit
            $('#unlimitedUsable').on('click', function () {
                let isChecked = $(this).is(':checked');
                if (isChecked) {
                    let usableCode = $(this).val();
                    $("#usableCode").val(usableCode).prop('readonly', true);
                } else {
                    $("#usableCode").val('').prop('readonly', false);
                }

            });



        });
    </script>

@endpush
