@extends('layouts.admin')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <form method="post" action="{{route('discounts.update',$discount->id)}}" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="card">
                    <div class="card-header card_header">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="card-title card_title"><i class="fab fa-gg-circle"></i> Update Discount
                                </h4>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="{{route('discounts.index')}}"
                                   class="btn btn-dark btn-md waves-effect btn-label waves-light card_btn"><i
                                        class="fas fa-th label-icon"></i>All Discount</a>
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
                                <select {{ $discount->is_all_vendors == 1 ? 'disabled' : '' }} class="form-control select2 vendors " id="parentId" name="vendor_id[]" multiple>
                                    @foreach ($vendors as $vendor)
                                        <option class="custom-style"  {{ in_array($vendor->id, json_decode($discount->vendor_id)) ? 'selected' : ''}}  value="{{ $vendor->id}}" style="font-weight: 900 !important; display: block !important; "> {{  $vendor->name }}</option>
                                    @endforeach

                                </select>
                                @if ($errors->has('vendor_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('vendor_id') }}</strong>
                                     </span>
                                @endif
                            </div>
                            <div class="col-sm-3">
                                <input id="allVendors"  {{ $discount->is_all_vendors == 1 ? 'checked' : '' }} type="checkbox" style="margin-top:10px" name="is_all_vendors"
                                       value="true">
                                <span style="font-size: 14px"> all vendors</span>
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('category_id') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label text-left"> Category name<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-6">
                                <select  {{ $discount->is_all_categories == 1 ? 'disabled' : '' }} class="form-control select2 category" id="categoryId" name="category_id[]" multiple>
                                    @foreach ($categories as $category)
                                        <option class="custom-style"  {{ in_array($category->id, json_decode($discount->category_id)) ? 'selected' : ''}} value="{{ $category->id}}"
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
                                <input id="allCategories" {{ $discount->is_all_categories == 1 ? 'checked' : '' }}  type="checkbox" style="margin-top:10px" name="is_all_categories"
                                       value="true">
                                <span style="font-size: 14px"> all categories</span>
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('product_id') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label text-left">Product Name<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-6">
                                <select  {{ $discount->is_all_products == 1 ? 'disabled' : '' }} class="form-control select2 product" id="productId" name="product_id[]" multiple>
                                    @foreach ($products as $product)
                                            <option class="custom-style"  {{ in_array($product->id, json_decode($discount->product_id)) ? 'selected' : ''}} value="{{ $product->id }}"
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
                                <input id="allProducts" {{ $discount->is_all_products == 1 ? 'checked' : '' }} type="checkbox" style="margin-top:10px" name="is_all_products" value="true">
                                <span style="font-size: 14px"> all products</span>
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('percentage') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label text-left">Discount type<span
                                    class="req_star">*</span>:</label>

                            <div class="col-3">
                                <select class ="form-control " id ="discount_type" name="discount_type">
                                    <option value="0">---Select Discount type---</option>
                                    <option class="custom-style"  {{ $discount->discount_type == 'percentage' ? 'selected' : '' }} value="percentage" style="font-weight: 500 !important; "> Percentage</option>
                                    <option class="custom-style" {{ $discount->discount_type == 'amount' ? 'selected' : '' }} value="amount" style="font-weight: 500 !important; "> Amount</option>
                                </select>
                                @if ($errors->has('discount_type'))
                                    <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('discount_type') }}</strong>
                                     </span>
                                @endif
                            </div>
                            <div class="col-sm-2">
                                <input type="number" id="discountNum" autocomplete="off" class="form-control form_control" name="{{ !empty($discount->amount) ? 'amount' : 'percentage' }}"
                                       value="{{ !empty($discount->amount) ? $discount->amount : $discount->percentage }}" placeholder="">
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
                                       value="{{old('effective_from',$discount->effective_from)}}">
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
                                       value="{{old('effective_to',$discount->effective_to)}}">
                                @if ($errors->has('effective_to'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('effective_to') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('delivery_type') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label text-left">Delivery fee<span
                                    class="req_star">*</span>:</label>

                            <div class="col-3">
                                <select class ="form-control " id ="delivery_type" name="delivery_type">
                                    <option value="0">---Select Delivery type---</option>
                                    <option class="custom-style" value="delivery_free"  {{ $discount->delivery_type == 'delivery_free' ? 'selected' : '' }} style="font-weight: 500 !important; "> Free</option>
                                    <option class="custom-style" value="delivery_amount" {{ $discount->delivery_type == 'delivery_amount' ? 'selected' : '' }} style="font-weight: 500 !important; "> Delivery amount</option>
                                </select>
                                @if ($errors->has('discount_type'))
                                    <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('discount_type') }}</strong>
                                     </span>
                                @endif
                            </div>
                            <div class="col-sm-2">
                                <input type="number" id="deliveryAmount" autocomplete="off" class="form-control form_control {{ empty($discount->delivery_amount) ? 'd-none' : '' }}" name="{{ empty($discount->delivery_amount) ? '' : 'delivery_amount' }}"
                                       value="{{ $discount->delivery_amount ?? '' }}" placeholder="">
                                @if ($errors->has('amount'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('amount') }}</strong>
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
                    $('.vendors').prop( "disabled", true );
                }else {
                    $('.vendors').prop( "disabled", false );
                }

            });

            // all Categories checked
            $('#allCategories').on('change', function () {
                if ($(this).is(':checked')) {
                    // Do something...
                    $('.category').prop( "disabled", true );
                }else {
                    $('.category').prop( "disabled", false );
                }
            });

            // all Products checked
            $('#allProducts').on('change', function () {
                if ($(this).is(':checked')) {
                    // Do something...
                    $('.product').prop( "disabled", true );
                }else {
                    $('.product').prop( "disabled", false );
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
                    $('#deliveryAmount').removeAttr('name', 'delivery_amount');
                }
            });

        });
    </script>

@endpush
