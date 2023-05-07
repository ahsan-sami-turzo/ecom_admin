@extends('layouts.admin')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <form method="post" action="{{ route('feature-product.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header card_header">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="card-title card_title"><i class="fab fa-gg-circle"></i> Add feature product</h4>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="{{ route('feature-product.index') }}"
                                   class="btn btn-dark btn-md waves-effect btn-label waves-light card_btn"><i
                                        class="fas fa-th label-icon"></i>All feature product</a>
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
                        <div class="form-group row mb-3 {{ $errors->has('display_products') ? ' has-error' : '' }}">
                            <label class="col-sm-4 col-form-label col_form_label text-left">Feature display product<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-5">
                                <select class="form-control display-product" id="displayProducts" name="display_products">
                                    <option value=""></option>
                                    <option value="7">Feature Products (7)</option>
                                    <option value="5">Slider Products (5)</option>
                                    <option value="3">Selected Products (3)</option>
                                    <option value="2">Special Products (2)</option>
                                </select>
                                @if ($errors->has('display_products'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('display_products') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('feature_id') ? ' has-error' : '' }}">
                            <label class="col-sm-4 col-form-label col_form_label text-left">Feature Name<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-5">
                                <select class="form-control " id="featureName" name="feature_id">
                                    <option value=""></option>

                                </select>
                                @if ($errors->has('feature_id'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('feature_id') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3 ">
                            <label class="col-sm-4 col-form-label col_form_label text-left">Vendor Name<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-5">
                                <select class="form-control" id="vendorId" name="vendor_id">
                                    <option value=""></option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id}}"
                                                style="font-size: 12px; font-weight:bold !important;"> {{  $user->name ?: ''}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('vendor_id'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('vendor_id') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3 ">
                            <label class="col-sm-4 col-form-label col_form_label text-left">Category Name<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-5">
                                <select class="form-control" id="categoryIdName" name="category_id">
                                    <option value=""></option>
                                    @foreach ( $categories as $category )
                                        <option value="{{ $category->id}}"
                                                style="font-size: 12px; font-weight:bold !important;"> {{  $category->category_name ?: '' }}</option>
                                    @endforeach

                                </select>
                                @if ($errors->has('feature_id'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('feature_id') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('product_id') ? ' has-error' : '' }}">
                            <label class="col-sm-4 col-form-label col_form_label text-left">Product Name<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-5">
                                <select class="form-control productName" id="parentId" name="product_id[]" multiple>
                                    <option value=""></option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                                style="font-size: 12px; font-weight:bold !important;"> {{  $product->product_name ?: ''}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('product_id'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('product_id') }}</strong>
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
            $("#displayProducts").select2({
                placeholder: "Select display products"
            });
            $("#featureName").select2({
                placeholder: "Select Feature Name "
            });
            $("#vendorId").select2({
                placeholder: "Select Vendor Name "
            });
            $("#categoryIdName").select2({
                placeholder: "Select Category Name "
            });
            $(".productName").select2({
                placeholder: "Select Product Name "
            });
        });


        $(document).ready(function () {

            // display product list
            $("#displayProducts").on("change", function () {
                let displayId = $(this).val();
                $("#featureName").empty();
                $.ajax({
                    method: "post",
                    url: '{{ route("feature-display-products") }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        display_products: displayId
                    },
                    success: function (response) {
                        if(jQuery.inArray(response.success)){
                            var featureName = ``;
                            $.each(response.success, function(index, value){
                                featureName +=  `<option value="` + value.id + `" >` + value.name + `</option>`;
                            });
                            $('#featureName').append(featureName);
                        }
                    }
                });
            });


            // Feature name products list
            $("#featureName").on("change", function () {
                let featureId = $(this).val();
               // $(".productName").empty();
                $.ajax({
                    method: "post",
                    url: '{{ route("feature-name-products") }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        feature_id: featureId
                    },
                    success: function (response) {
                        if(jQuery.inArray(response.success)){
                            var productName = ``;
                            $.each(response.success, function(index, value){
                                productName +=  `<option value="` + value + `" selected >` + value + `</option>`;
                            });
                            $('#parentId').append(productName);
                        }
                    }
                });
            });
            // vendor category list
            $("#vendorId").on("change", function () {
                let vendorId = $(this).val();
                $("#categoryIdName").empty();
                $.ajax({
                    method: "post",
                    url: '{{ route("vendor-categories-list") }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        vendor_id: vendorId
                    },
                    success: function (response) {
                       // alert(response.success)

                        if(jQuery.inArray(response.success)){
                            var categoryName = ``;
                            $.each(response.success, function(index, value){
                                categoryName +=  `<option value="` + value + `" selected >` + value + `</option>`;
                            });
                            $('#categoryIdName').append(categoryName);
                        }

                    }
                });
            });

            // category products list
            $("#categoryIdName").on("change", function () {
                let categoryId = $(this).val();
                $(".productName").empty();
                $.ajax({
                    method: "post",
                    url: '{{ route("category-products") }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        category_id: categoryId
                    },
                    success: function (response) {
                        if(jQuery.inArray(response.success)){
                            var productName = ``;
                            $.each(response.success, function(index, value){
                                productName +=  `<option value="` + value.id + `" >` + value.product_name + `</option>`;
                            });
                            $('#parentId').append(productName);
                        }
                    }
                });
            });
        });
    </script>
@endpush
