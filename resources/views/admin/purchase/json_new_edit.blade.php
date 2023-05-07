@extends('layouts.admin')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{asset('contents/admin')}}/assets/css/image-uploader.css"/>
    <style>
        .custom-style {
            font-weight: 900 !important;
            display: block !important;
        }

        .dropzone {
            border: 2px dashed #999999;
            border-radius: 10px;
        }

        .dropzone .dz-default.dz-message {
            height: 171px;
            background-size: 132px 132px;
            margin-top: -101.5px;
            background-position-x: center;

        }

        .dropzone .dz-default.dz-message span {
            display: block;
            margin-top: 145px;
            font-size: 20px;
            text-align: center;
        }

        .col_form_label {
            margin-left: 45px !important;
            text-align: left !important;

        }

        .col_cus_form_label {
            margin-left: 32px !important;
            text-align: left !important;
            font-size: 14px;
            font-weight: 600;
            padding-right: 0px;

        }

        .image-uploader {
            min-height: 6rem !important;
        }

        .select2-container {
            width: 100% !important;
        }

        .disabled_input {
            background: rgba(114, 109, 109, 0.24) !important;
            color: #0e0e0e;
            font-weight: 600;
            cursor: default;
        }

        .select-hide {
            display: none !important;
        }

        .pointer-events-none {
            pointer-events: none !important;
            background: rgba(114, 109, 109, 0.24) !important;
            text-align: center;
        }
    </style>
@endpush

@section('content')
    <form action='{{  route("purchase.update",$purchase->id) }}' method="post" class="dropzone"
          enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card_header">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="card-title card_title"><i class="fab fa-gg-circle"></i> product Purchase
                                    Update

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
                        @role('admin')
                        <div class="form-group row mb-3 {{ $errors->has('vendor_id') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">Vendor name</label>
                            <label class="col-sm-1 mt-2 text-center"><span class="req_star ">*</span>:</label>
                            <div class="col-sm-6">
                                <select class="form-control select2" id="vendorId" name="vendor_id">
                                        <option class="custom-style"
                                                value="{{ $purchase->supplierId }}" selected> {{  $purchase->vendor->name ?: ''}}</option>


                                </select>
                                @if ($errors->has('vendor_id'))
                                    <span class="invalid-feedback" role="alert">
                                 <strong>{{ $errors->first('vendor_id') }}</strong>
                                 </span>
                                @endif
                            </div>
                        </div>
                        @endrole
                        <div class="form-group row mb-3 {{ $errors->has('billNo') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">Bill No</label>
                            <label class="col-sm-1 mt-2 text-center"><span class="req_star ">*</span>:</label>
                            <div class="col-sm-6">
                                <input readonly id="billNo" type="text" class="form-control form_control" name="billNo"
                                       value="{{old('billNo',$purchase->billNo)}}">
                                @if ($errors->has('billNo'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('billNo') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('chalanNo') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">Chalan No</label>
                            <label class="col-sm-1 mt-2 text-center"><span class="req_star ">*</span>:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control form_control chalanNo" name="chalanNo"
                                       value="{{old('chalanNo',$purchase->chalanNo)}}">
                                @if ($errors->has('chalanNo'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('chalanNo') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('vat_registration') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">VAT Registration</label>
                            <label class="col-sm-1 mt-2 text-center"><span class="req_star ">*</span>:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control form_control" name="vat_registration"
                                       value="{{old('vat_registration',$purchase->vat_registration)}}">
                                @if ($errors->has('vat_registration'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('vat_registration') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('purchaseDate') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">Purchase Date </label>
                            <label class="col-sm-1 mt-2 text-center"><span class="req_star ">*</span>:</label>
                            <div class="col-sm-6">
                                <input type="date" autocomplete="off" class="form-control form_control"
                                       name="purchaseDate"
                                       value="{{old('purchaseDate', (new DateTime())->format('Y-m-d'))}}">
                                @if ($errors->has('purchaseDate'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('purchaseDate') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('totalQuantity') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">Total Quantity</label>
                            <label class="col-sm-1 mt-2 text-center"><span class="req_star ">*</span>:</label>
                            <div class="col-sm-6">
                                <input readonly id="totalProductQuantity" type="text" autocomplete="off"
                                       class="form-control form_control disabled_input"
                                       name="totalQuantity"
                                       value='{{ old("totalQuantity",$purchase->totalQuantity) }}'>
                                @if ($errors->has('totalQuantity'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('totalQuantity') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('totalAmount') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">Total Amount</label>
                            <label class="col-sm-1 mt-2 text-center"><span class="req_star ">*</span>:</label>
                            <div class="col-sm-6">
                                <input id="totalProductAmount" readonly type="text" autocomplete="off"
                                       class="form-control form_control disabled_input"
                                       name="totalAmount" value="{{old('totalAmount',$purchase->totalAmount)}}">
                                @if ($errors->has('totalAmount'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('totalAmount') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <!-- VENDOR IMAGE  -->


                    </div>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-12">
                <div class="card ">
                    <div id="product-entry-form" class="card-body ">
                        <table id="alltableinfo"
                               class="table table-bordered table-striped table-hover dt-responsive nowrap custom_table">
                            <thead class="thead-dark">
                            <tr>
                                <th class="text-center" style="width: 25%">Search Product</th>
                                <th id="th_show" class="text-center hide-th-td" colspan="3" style="width: 30%;">
                                    Specification
                                </th>
                                <th class="text-center" style="width: 5%">Quantity</th>
                                <th class="text-center" style="width: 10%">Unite Price</th>
                                <th class="text-center" style="width: 25%">Total</th>
                                <th class="text-center">Manage</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="addRowTr">
                                <td class="text-center" style="width: 25%">
                                    <select class="form-control product-name product select-box" id="productId"
                                            name="product_id[]">
                                        <option value="0">-- Select Product Name --</option>
                                        @foreach( $products->vendor->vendorProducts as $vProduct)
                                            <option value="{{ $vProduct->id }}">{{ $vProduct->product_name }}</option>
                                        @endforeach


                                    </select>
                                    @if ($errors->has('product_id'))
                                        <span class="invalid-feedback" role="alert">
                                             <strong>{{ $errors->first('product_id') }}</strong>
                                        </span>
                                    @endif
                                </td>
                                <td id="td_show_color" class="text-center hide-th-td" style="width: 15%">
                                    <select class="form-control color-name select-box" id="colorId"
                                            name="color_id[]">
                                        <option value="0">Color name</option>
                                    </select>
                                    @if ($errors->has('color_id'))
                                        <span class="invalid-feedback" role="alert">
                                             <strong>{{ $errors->first('color_id') }}</strong>
                                        </span>
                                    @endif
                                </td>
                                <td id="td_show_size" class="text-center hide-th-td" style="width: 13%">
                                    <select class="form-control size-name select-box" id="sizeId" name="size_id[]">
                                        <option value="">Size name</option>
                                    </select>
                                    @if ($errors->has('size_id'))
                                        <span class="invalid-feedback" role="alert">
                                             <strong>{{ $errors->first('size_id') }}</strong>
                                        </span>
                                    @endif
                                </td>
                                <td id="td_show_weight" class="text-center hide-th-td" style="width: 12%">
                                    <select class="form-control weight-name select-box" name="weight_id[]"
                                            id="weightId">
                                        <option value="">Weight name</option>
                                    </select>
                                    @if ($errors->has('weight_id'))
                                        <span class="invalid-feedback" role="alert">
                                             <strong>{{ $errors->first('weight_id') }}</strong>
                                            </span>
                                    @endif
                                </td>
                                <td class="text-center" style="width: 5%"><input onkeyup="test()"
                                                                                 style="height: 28px; padding: 0;"
                                                                                 type="text"
                                                                                 class="form-control form_control productQuantity inputCheck"
                                                                                 id="productQuantity"
                                                                                 name="productQuantity[]"
                                                                                 value=""
                                                                                 oninput="calculate('productQuantity','productPrice','totalPrice')">
                                </td>
                                <td class="text-center" style="width: 10%"><input onkeyup="test()" id="productPrice"
                                                                                  style="height: 28px; padding: 0;"
                                                                                  type="text" autocomplete="off"
                                                                                  class="form-control form_control productPrice inputCheck"
                                                                                  name="productPrice[]"
                                                                                  value=''
                                                                                  oninput="calculate('productQuantity','productPrice','totalPrice')">
                                </td>
                                <td class="text-center"><input disabled id="totalPrice"
                                                               style="height: 28px; padding: 0;" type="text"
                                                               autocomplete="off"
                                                               class="form-control form_control totalPrice"
                                                               name="totalPrice[]"
                                                               value='{{ old("totalPrice") }}'></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button class="btn btn-sm pointer-events-none" id="addRowBtn" type="button">
                                            <i style="font-size: 14px" class="mdi mdi-plus"></i></button>
                                    </div>
                                </td>
                            </tr>

                            @foreach( $purchaseDetails as $purchaseDetail)
                                <tr class="addRowTr">
                                    <td class="text-center" style="width: 25%">
                                        <select class="form-control product-name product select-box pointer-events-none" id="productId"
                                                name="product_id[]">
                                            <option value="{{ $purchaseDetail->productId }}"
                                                    selected>{{ isset($purchaseDetail->product) ? $purchaseDetail->product->product_name : ''}}</option>

                                        </select>
                                        @if ($errors->has('product_id'))
                                            <span class="invalid-feedback" role="alert">
                                             <strong>{{ $errors->first('product_id') }}</strong>
                                        </span>
                                        @endif
                                    </td>
                                    <td id="td_show_color" class="text-center hide-th-td" style="width: 15%">
                                        <select class="form-control color-name select-box pointer-events-none"
                                                id="colorId"
                                                name="color_id[]">
                                            <option
                                                value="{{ isset($purchaseDetail->colorId) ? $purchaseDetail->colorId : 0 }}"
                                                selected>{{ isset($purchaseDetail->color) ? $purchaseDetail->color->name : ''}}</option>

                                        </select>
                                        @if ($errors->has('color_id'))
                                            <span class="invalid-feedback" role="alert">
                                             <strong>{{ $errors->first('color_id') }}</strong>
                                        </span>
                                        @endif
                                    </td>
                                    <td id="td_show_size" class="text-center hide-th-td" style="width: 13%">
                                        <select class="form-control size-name select-box pointer-events-none"
                                                id="sizeId" name="size_id[]">
                                            <option
                                                value="{{ isset($purchaseDetail->sizeId) ? $purchaseDetail->sizeId : 0 }}"
                                                selected>{{ isset($purchaseDetail->size) ? $purchaseDetail->size->name : ''}}</option>

                                        </select>
                                        @if ($errors->has('size_id'))
                                            <span class="invalid-feedback" role="alert">
                                             <strong>{{ $errors->first('size_id') }}</strong>
                                        </span>
                                        @endif
                                    </td>
                                    <td id="td_show_weight" class="text-center hide-th-td" style="width: 12%">
                                        <select class="form-control weight-name select-box pointer-events-none"
                                                name="weight_id[]"
                                                id="weightId">
                                            <option
                                                value="{{ isset($purchaseDetail->weight_id) ? $purchaseDetail->weight_id : 0 }}"
                                                selected>{{ isset($purchaseDetail->weight) ? $purchaseDetail->weight->name : ''}}</option>

                                        </select>
                                        @if ($errors->has('weight_id'))
                                            <span class="invalid-feedback" role="alert">
                                             <strong>{{ $errors->first('weight_id') }}</strong>
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center" style="width: 5%"><input onkeyup="test()"
                                                                                     style="height: 28px; padding: 0;"
                                                                                     type="text"
                                                                                     class="form-control form_control productQuantity inputCheck pointer-events-none"
                                                                                     id="productQuantity"
                                                                                     name="productQuantity[]"
                                                                                     value="{{ $purchaseDetail->quantity }}"
                                                                                     oninput="calculate('productQuantity','productPrice','totalPrice')">
                                    </td>
                                    <td class="text-center" style="width: 10%"><input onkeyup="test()" id="productPrice"
                                                                                      style="height: 28px; padding: 0;"
                                                                                      type="text" autocomplete="off"
                                                                                      class="form-control form_control productPrice inputCheck pointer-events-none"
                                                                                      name="productPrice[]"
                                                                                      value='{{ $purchaseDetail->price }}'
                                                                                      oninput="calculate('productQuantity','productPrice','totalPrice')">
                                    </td>
                                    <td class="text-center"><input disabled id="totalPrice"
                                                                   style="height: 28px; padding: 0;" type="text"
                                                                   autocomplete="off"
                                                                   class="form-control form_control totalPrice pointer-events-none"
                                                                   name="totalPrice[]"
                                                                   value='{{ $purchaseDetail->quantity * $purchaseDetail->price }}'>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-dark removeRowBtn" type="button">
                                                <i
                                                    style="font-size: 14px" class="mdi mdi-minus"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer card_footer text-center">
                        <input hidden id="purchaseDetails" name="purchase_details" value="">

                        <button type="submit" class="btn btn-md btn-dark">Submit</button>
                    </div>

                </div>
            </div>
        </div>
    </form>
@endsection
@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{asset('contents/admin')}}/assets/js/image-uploader.js"></script>

    <script>
        $(document).ready(function () {
            $('.select2_').select2({});
        });
        $(document).ready(function () {
            $('.product-name_').select2({});
            /*  $('.color-name').select2({});
              $('.size-name').select2({});
              $('.weight-name').select2({});*/
        });
    </script>


    <script>
        $(document).ready(function () {

            $('#vendorId').on('change', function () {
                let quantity = $("#productQuantity").val();
                let price = $("#productQuantity").val();


                $("#product-entry-form").removeClass('d-none');
                // $('.product-name').select2({});
                let purchaseProducts = [];
                let vendorId = $(this).val();
                let totalProductQuantity = 0;


                $(".product-name").empty();
                $.ajax({
                    method: "post",
                    url: '{{ route("vendor-products-list") }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        vendor_id: vendorId
                    },
                    success: function (response) {
                        const details_name = (response.success);

                        if (jQuery.inArray(details_name)) {
                            var html_specification_details_names = `<option value=""> Select Product Name </option>`;
                            $.each(details_name, function (index, value) {
                                html_specification_details_names += `<option value="` + index + `">` + value + `</option>`;
                            });
                            $('.product-name').append(html_specification_details_names);
                        }


                    },
                });
            });
            // product name change when color name, size name, weight name
            $("#productId").on('change', function () {

                let productId = $(this).val();
                $("#colorId").empty();
                $("#sizeId").empty();
                $("#weightId").empty();

                //product name change color name
                $.ajax({
                    method: "post",
                    url: '{{ route("vendor-products-color-list") }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        product_id: productId
                    },
                    success: function (response) {
                        const color_names = (response.success);

                        if (Object.keys(color_names).length > 0) {
                            $('#colorId').removeClass('select-hide');
                            var html_color_names = `<option value="">Color Name </option>`;
                            $.each(color_names, function (index, value) {
                                html_color_names += `<option value="` + index + `">` + value + `</option>`;
                            });

                            $('#colorId').append(html_color_names);
                        } else {
                            //   $(".color-name").data("option").removeAttr('disabled');
                            $('#colorId').addClass('select-hide');
                        }
                    },
                });

                //product name change size name
                $.ajax({
                    method: "post",
                    url: '{{ route("vendor-products-size-list") }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        product_id: productId
                    },
                    success: function (response) {
                        const size_types = (response.success);

                        if (Object.keys(size_types).length > 0) {
                            $('#sizeId').removeClass('select-hide');
                            var html_size_types = `<option value="0">Size Name </option>`;
                            $.each(size_types, function (index, value) {
                                html_size_types += `<option value="` + index + `">` + value + `</option>`;
                            });
                            $('#sizeId').append(html_size_types);
                        } else {
                            $('#sizeId').addClass('select-hide');

                        }
                    },
                });

                //product name change weight name
                $.ajax({
                    method: "post",
                    url: '{{ route("vendor-products-weight-list") }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        product_id: productId
                    },
                    success: function (response) {
                        const weight_types = (response.success);
                        if (Object.keys(weight_types).length > 0) {
                            $('#weightId').removeClass('select-hide');
                            var html_weight_types = `<option value="0">Weight Name </option>`;
                            $.each(weight_types, function (index, value) {
                                html_weight_types += `<option value="` + index + `">` + value + `</option>`;
                            });
                            $('#weightId').append(html_weight_types);
                        } else {
                            $('#weightId').addClass('select-hide');
                        }
                    },
                });


            });
            let purchaseProducts = [];
            $("#addRowBtn").on('click', function () {


                // let vendorId = $(this).val();
                //
                // var vendor_Id = $("#vendorId").attr('data-id', vendorId);
                // var vendoId = $("#vendorId").data('id');
                // let idd = $("#vendorId").val(vendorId);
                let htmlBtn = `<i style="font-size: 14px" class="mdi mdi-minus"></i>`;

                let add_row = $(".addRowTr").first().clone();
                $("#alltableinfo tbody tr:first").find('input').val('');
                let productCode = $('.product').val();
                let colorCode = $('.color-name').val();
                let sizeCode = $('.size-name').val();
                let weightCode = $('.weight-name').val();
                //let product_quantity = $('.productQuantity').val();


                let productPrice = $('.productPrice').val();
                // alert(product_quantity);
                // console.log(productCode, colorCode, sizeCode, sizeCode, product_quantity, productPrice);
                $("#alltableinfo tbody tr:first").find('.select-box').val('').trigger('change');
                $('#alltableinfo tr:last').after(add_row);

                $("#alltableinfo tbody tr:last").find('button').html(htmlBtn).addClass('removeRowBtn').removeAttr('id');
                $("#alltableinfo tbody tr:last").find('.productQuantity');
                $("#alltableinfo tbody tr:last").find('.productPrice').attr('readonly', true);


                $("#alltableinfo tbody tr:last").find(".product-name option[value=" + productCode + "]").attr('selected', 'selected');
                $("#alltableinfo tbody tr:last").find(".color-name option[value=" + colorCode + "]").attr('selected', 'selected').attr('name', 'color_id[]');
                $("#alltableinfo tbody tr:last").find(".size-name option[value=" + sizeCode + "]").attr('selected', 'selected');
                $("#alltableinfo tbody tr:last").find(".weight-name option[value=" + weightCode + "]").attr('selected', 'selected');
                $("#alltableinfo tbody tr:last").find(".product-name").addClass("pointer-events-none");
                $("#alltableinfo tbody tr:last").find(".color-name").addClass("pointer-events-none");
                $("#alltableinfo tbody tr:last").find(".size-name").addClass("pointer-events-none");
                $("#alltableinfo tbody tr:last").find(".weight-name").addClass("pointer-events-none");
                $("#alltableinfo tbody tr:last").find(".productQuantity").addClass("pointer-events-none");
                $("#alltableinfo tbody tr:last").find(".productPrice").addClass("pointer-events-none");
                $("#alltableinfo tbody tr:last").find(".totalPrice").addClass("pointer-events-none");
                let productQuantity = $("#alltableinfo tbody tr:last").find(".productQuantity").val();
                let product_price = $("#alltableinfo tbody tr:last").find(".productPrice").val();
                let product_total_price = $("#alltableinfo tbody tr:last").find(".totalPrice").val();

                let productFormObj = {
                    'product_id': productCode,
                    'color_id': colorCode || 0,
                    'size_id': sizeCode || 0,
                    'weight_id': weightCode || 0,
                    'productQuantity': productQuantity,
                    'productPrice': product_price,
                    'totalPrice': product_total_price,
                }
                purchaseProducts.push(productFormObj);
               // console.log(purchaseProducts);
                var totalProductQuantity = purchaseProducts.map(quantity => quantity.productQuantity).reduce((acc, quantity) => parseInt(quantity) + parseInt(acc));
                var totalProductAmount = purchaseProducts.map(amount => amount.totalPrice).reduce((acc, amount) => parseInt(amount) + parseInt(acc));

                $('#purchaseDetails').val(JSON.stringify(purchaseProducts));
                $('#totalProductQuantity').val(totalProductQuantity);
                $('#totalProductAmount').val(totalProductAmount);

                $("#addRowBtn").addClass('pointer-events-none');
                $("#addRowBtn").removeClass('btn-dark');
                $("#productPrice").val('');

                $(".removeRowBtn").on('click', function () {
                    $(this).parent().parent().parent().remove();

                    const index = purchaseProducts.indexOf(productFormObj);
                    console.log(index);
                    if (index > -1) {
                        purchaseProducts.splice(index, 1);
                    }

                    if (purchaseProducts.length === 0) {
                        var totalProductQuantity = purchaseProducts.map(quantity => quantity.productQuantity).reduce((acc, quantity) => parseInt(quantity) + parseInt(acc));
                        var totalProductAmount = purchaseProducts.map(amount => amount.totalPrice).reduce((acc, amount) => parseInt(amount) + parseInt(acc));

                        $('#totalProductQuantity').val(totalProductQuantity);
                        $('#totalProductAmount').val(totalProductAmount);
                    } else {

                        var totalProductQuantity = purchaseProducts.map(quantity => quantity.productQuantity).reduce((acc, quantity) => parseInt(quantity) + parseInt(acc));
                        var totalProductAmount = purchaseProducts.map(amount => amount.totalPrice).reduce((acc, amount) => parseInt(amount) + parseInt(acc));

                        $('#totalProductQuantity').val(totalProductQuantity);
                        $('#totalProductAmount').val(totalProductAmount);
                        console.log(purchaseProducts);
                    }

                });


            });


            $(".removeRowBtn").on('click', function () {

                $(this).parent().parent().parent().remove();

                const index = purchaseProducts.indexOf(productFormObj);

                if (index > -1) {
                    purchaseProducts.splice(index, 1);
                }

                if (purchaseProducts.length === 0) {
                    $('#totalProductQuantity').val(0);
                    $('#totalProductAmount').val(0);

                } else {

                    var totalProductQuantity = purchaseProducts.map(quantity => quantity.productQuantity).reduce((acc, quantity) => parseInt(quantity) + parseInt(acc));
                    var totalProductAmount = purchaseProducts.map(amount => amount.totalPrice).reduce((acc, amount) => parseInt(amount) + parseInt(acc));

                    $('#totalProductQuantity').val(totalProductQuantity);
                    $('#totalProductAmount').val(totalProductAmount);
                    console.log(purchaseProducts);
                }

            });

        });
    </script>
    <script>
        var quantity = 0;
        var total = 0;
        var price = 0;

        function calculate(qtyId, priceId, id) {
            quantity = document.getElementById(qtyId).value;
            price = document.getElementById(priceId).value;
            if (Number.isInteger(qtyId)) {
                console.log('ok');
            }
            total = quantity * price;
            if (isNaN(total))
                total = 0;
            var sum = 0;
            document.getElementById(id).value = total;

            //total Quantity number
            var sumQuantity = 0;
            $(".productQuantity").each(function () {
                sumQuantity += parseFloat($(this).val());
            });
            $('#totalQuantity').val(sumQuantity);

            //total Amount number
            $(".totalPrice").each(function () {
                sum += parseFloat($(this).val());
            });
            $('#totalAmount').val(sum);
        }

    </script>
    <script>
        $(document).ready(function () {
            $('#vendorId').on('change', function () {
                let vendorId = $(this).val();
                $.ajax({
                    method: "post",
                    url: '{{ route("vendor-purchase-products") }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        vendor_id: vendorId
                    },
                    success: function (response) {
                        const vendor = (response.success);
                        let count = vendor.purchases.length;
                        let pad = '00000';
                        count++;
                        let ctxt = '' + count;
                        //let petten = (vendor.name. slice(0, 3)+'-'+'000'.substr( String(vendor.id).length ) + vendor.id + '-' + pad.substr(0, pad.length - ctxt.length));
                        let petten = vendor.name.toUpperCase().slice(0, 3) + '-' + '000'.substr(String(vendor.id).length) + vendor.id + '-' + (pad.substr(0, pad.length - ctxt.length) + count);

                        $('#billNo').val(petten);
                    },
                });
            });
        });
    </script>
    <script>

        let productQuantity = $("#productQuantity").val();
        let productPrice = $("#productPrice").val();

        function test() {
            if ($('.inputCheck').eq(0).val() !== '' && $('.inputCheck').eq(0).val() > 0 && $('.inputCheck').eq(1).val() !== '' && $('.inputCheck').eq(1).val() > 0) {
                $("#addRowBtn").removeClass('pointer-events-none');
                $("#addRowBtn").addClass('btn-dark');
            } else {
                console.log('something is wrong')
            }
        }


    </script>
    <!--    <script>
            //Modal code start
            $(document).ready(function(){
                $(document).on("click", "#delete", function () {
                    var deleteID = $(this).data('id');
                    $(".modal_card #modal_id").val( deleteID );
                });
            });
        </script>-->
@endpush
