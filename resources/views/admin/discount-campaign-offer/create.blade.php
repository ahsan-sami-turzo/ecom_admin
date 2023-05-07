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
            <form method="post" action="{{ route('campaign-offer.store',$discountCampaign->id)}}" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header card_header">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="card-title card_title"><i class="fab fa-gg-circle"></i> Add discount campaign offer
                                </h4>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="{{route('vendor-campaign-list.all')}}"
                                   class="btn btn-dark btn-md waves-effect btn-label waves-light card_btn"><i
                                        class="fas fa-th label-icon"></i>My discount campaign offer</a>
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
                        <div class="form-group row mb-3 {{ $errors->has('category_id') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label text-left"> Category name<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-6">
                                <select class="form-control select2 category" id="categoryId" name="category_id[]" multiple="multiple">
                                    <option value="">Select categories</option>
                                    <option value="all_category">All categories</option>
                                    @foreach ($vendor->categories as $key => $category)
                                        <option class="custom-style" {{ (collect(old('category_id'))->contains($key)) ? 'selected':'' }} value="{{ $key }}"
                                                style="font-weight: 900 !important; display: block !important; "> {{  $category }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('category_id'))
                                    <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('category_id') }}</strong>
                                     </span>
                                @endif
                            </div>
{{--                            <div class="col-sm-3">--}}
{{--                                <input id="allCategories" type="checkbox" style="margin-top:10px" name="is_all_categories"--}}
{{--                                       value="true">--}}
{{--                                <span style="font-size: 14px"> all categories</span>--}}
{{--                            </div>--}}
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('product_id') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label text-left">Product Name<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-6">
                                <select class="form-control select2 product" id="productId" name="product_id[]" multiple>
                                    <option value="">Select Products</option>
                                    <option value="all_product">All Product</option>
                                    @foreach ($vendor->products as $product)
                                        <option class="custom-style" {{ (collect(old('product_id'))->contains($product->id)) ? 'selected':'' }} value="{{ $product->id }}"
                                                style="font-weight: 900 !important; display: block !important;"> {{  $product->product_name }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('product_id'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('product_id') }}</strong>
                        </span>
                                @endif
                            </div>
{{--                            <div class="col-sm-3">--}}
{{--                                <input id="allProducts" type="checkbox" style="margin-top:10px" name="is_all_products" value="true">--}}
{{--                                <span style="font-size: 14px"> all products</span>--}}
{{--                            </div>--}}
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('percentage') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label text-left">Discount type<span
                                    class="req_star">*</span>:</label>

                            <div class="col-3">
                                <select disabled class ="form-control " id ="discount_type" name="discount_type">
                                    <option value="0">---Select Discount type---</option>
                                    <option class="custom-style" {{ $discountCampaign->campagin_discount_type == "percentage" ? 'selected' : ''  }} value="percentage" style="font-weight: 500 !important; "> Percentage</option>
                                    <option class="custom-style" {{ $discountCampaign->campagin_discount_type == "taka" ? 'selected' : ''  }} value="amount" style="font-weight: 500 !important; "> Amount</option>
                                </select>
                                @if ($errors->has('discount_type'))
                                    <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('discount_type') }}</strong>
                                     </span>
                                @endif
                            </div>
                            <div class="col-sm-2">
                                <input disabled type="number" id="discountNum" autocomplete="off"
                                       class="form-control form_control" name="{{  $discountCampaign->campagin_discount_type == "percentage" ? 'percentage' : 'taka'  }}"
                                       value="{{  $discountCampaign->campagin_discount_type == "percentage" ? $discountCampaign->percentage : $discountCampaign->amount  }}" max="99" min="0" placeholder="">
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
                                <input disabled type="date" autocomplete="off" class="form-control form_control"
                                       name="effective_from"
                                       value="{{old('effective_from',$discountCampaign->effective_from)}}">
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
                                <input disabled type="date" autocomplete="off" class="form-control form_control"
                                       name="effective_to"
                                       value="{{old('effective_to',$discountCampaign->effective_to)}}">
                                @if ($errors->has('effective_to'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('effective_to') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer card_footer text-center">
                        <button type="submit" class="btn btn-md btn-success font-weight-bold">Confirm campaign</button>
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
                    $('.vendors').prop( "disabled", true );
                }else {
                    $('.vendors').prop("disabled", false);

                }

            });

            // all Categories checked
            $('#categoryId').on('change', function () {
                let cateVal = $(this).val();
                if (cateVal == "all_category") {
                    $(this).removeAttr('multiple',"multiple");

                }else {
                    $(this).attr('multiple','multiple');
                    $("#categoryId option[value='all_category']").remove();
                }
            });

            // all Products checked
            $('#productId').on('change', function () {
                let productVal = $(this).val();
                if (productVal == "all_product") {
                    $(this).removeAttr('multiple',"multiple");

                }else {
                    $(this).attr('multiple','multiple');
                    $("#productId option[value='all_product']").remove();
                }
            });

            // all discount_type checked
            $("#discount_type").on('change', function () {
                if ($(this).val()=='percentage') {
                    $('#discountNum').attr("placeholder", "% here").attr('name', 'percentage');

                }else {
                    $('#discountNum').attr("placeholder", "Tk here").attr('name', 'amount');
                }
            });
            // all discount_type checked

            $("#delivery_type").on('change', function () {
                if ($(this).val()=='delivery_amount') {
                    $('#deliveryAmount').removeClass('d-none');
                    $('#deliveryAmount').attr("placeholder", "Amount here").attr('name', 'delivery_amount');
                }else {
                    $('#deliveryAmount').addClass('d-none');
                }
            });

            $('#categoryId').on('change', function () {
                let categorysId = $(this).val();
                $(".product").empty();
                //console.log(categorysId);
                //product name change size name
                $.ajax({
                    method: "post",
                    url: '{{ route("vendor-categories-products") }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        category_id: categorysId
                    },
                    success: function (response) {
                        const productNames = (response.success);

                        if (jQuery.inArray(productNames)) {
                            var product_names_fields = `<option value="">Product Name </option>`;
                            $.each(productNames, function (index, value) {
                                product_names_fields += `<option value="` + index + `">` + value + `</option>`;
                            });
                            $('.product ').append(product_names_fields);
                        }
                    },
                });

            });

        });
    </script>

@endpush
