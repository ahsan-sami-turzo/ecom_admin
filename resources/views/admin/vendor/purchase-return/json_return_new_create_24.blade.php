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
            background: #eee !important;
            text-align: center;
        }
    </style>
@endpush

@section('content')
    <form action='{{ route("purchase-returns.store") }}' method="post" class="dropzone" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card_header">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="card-title card_title"><i class="fab fa-gg-circle"></i> product Purchase
                                    return add

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


                        <div class="form-group row mb-3 {{ $errors->has('purchaseReturnBillNo') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">Purchase Return Bill No </label>
                            <label class="col-sm-1 mt-2 text-center"><span class="req_star ">*</span>:</label>
                            <div class="col-sm-6">
                                <input id="purchaseReturnBillNo" type="text" autocomplete="off"
                                       class="form-control form_control"
                                       name="purchaseReturnBillNo"
                                       value="{{$billNumber}}">
                                @if ($errors->has('purchaseReturnBillNo'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('purchaseReturnBillNo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('purchaseReturnDate') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">Purchase Return Date </label>
                            <label class="col-sm-1 mt-2 text-center"><span class="req_star ">*</span>:</label>
                            <div class="col-sm-6">
                                <input type="date" autocomplete="off" class="form-control form_control"
                                       name="purchaseReturnDate"
                                       value="{{old('purchaseReturnDate',(new DateTime())->format('Y-m-d'))}}">
                                @if ($errors->has('purchaseReturnDate'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('purchaseReturnDate') }}</strong>
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
                                       value='{{ old("totalQuantity") }}'>
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
                                       name="totalAmount" value="{{old('totalAmount')}}">
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
                                        <option value="">---Select product name---</option>
                                        @foreach( $products as $product)
                                            <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('product_id'))
                                        <span class="invalid-feedback" role="alert">
                                             <strong>{{ $errors->first('product_id') }}</strong>
                                        </span>
                                    @endif
                                </td>
                                <td id="td_show_color" class="text-center hide-th-td" style="width: 15%">
                                    <select class="form-control color-name select-box" id="colorId" name="color_id[]">
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
                                        <option value="0">Size name</option>
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
                                        <option value="0">Weight name</option>
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
                                                                                 oninput="calculate('productQuantity','productPrice','totalPrice')"/>
                                    <span id="getQuantityTotal"></span>
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
                                        <button class="btn btn-sm pointer-events-none" id="addRowBtn" type="button"><i
                                                style="font-size: 14px" class="mdi mdi-plus"></i></button>
                                    </div>
                                </td>
                            </tr>

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
        });
    </script>


    <script>
        $(document).ready(function () {




            let quantity = $("#productQuantity").val();
            let price = $("#productQuantity").val();

            $("#product-entry-form").removeClass('d-none');
            // $('.product-name').select2({});
            let purchaseProducts = [];
            let vendorId = $(this).val();
            let totalProductQuantity = 0;
            $("#addRowBtn").on('click', function () {

                let htmlBtn = `<i style="font-size: 14px" class="mdi mdi-minus"></i>`;

                let add_row = $(".addRowTr").first().clone();
                $("#alltableinfo tbody tr:first").find('input').val('');
                let productCode = $('.product').val();
                let colorCode = $('.color-name').val();
                let sizeCode = $('.size-name').val();
                let weightCode = $('.weight-name').val();
                //let product_quantity = $('.productQuantity').val();


                let productPrice = $('.productPrice').val();
                $("#alltableinfo tbody tr:first").find('.select-box').val('').trigger('change');
                $('#alltableinfo tr:last').after(add_row);

                $("#alltableinfo tbody tr:last").find('button').html(htmlBtn).addClass('removeRowBtn').removeAttr('id');
                $("#alltableinfo tbody tr:last").find('.productQuantity');
                $("#alltableinfo tbody tr:last").find('.productPrice').attr('readonly', true);

                $("#alltableinfo tbody tr:last").find(".product-name").addClass("pointer-events-none");
                $("#alltableinfo tbody tr:last").find(".product-name option[value=" + productCode + "]").attr('selected', 'selected').addClass("pointer-events-none");
                $("#alltableinfo tbody tr:last").find(".color-name").addClass("pointer-events-none");
                $("#alltableinfo tbody tr:last").find(".color-name option[value=" + colorCode + "]").attr('selected', 'selected').attr('name', 'color_id[]');
                $("#alltableinfo tbody tr:last").find(".size-name").addClass("pointer-events-none");
                $("#alltableinfo tbody tr:last").find(".size-name option[value=" + sizeCode + "]").attr('selected', 'selected');
                $("#alltableinfo tbody tr:last").find(".weight-name").addClass("pointer-events-none");
                $("#alltableinfo tbody tr:last").find(".weight-name option[value=" + weightCode + "]").attr('selected', 'selected');
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
                        //  console.log(purchaseProducts);
                    }

                });


            });


            // billNumbers change when product name
            $('#billNumbers').on('change', function () {
                let purchaseBilNumber = $(this).val();
                let htmlBtn = `<i style="font-size: 14px" class="mdi mdi-minus"></i>`;

                $("#product-entry-form").removeClass('d-none');
                $(".product-name").empty();
                $.ajax({
                    method: "post",
                    url: '{{ route("vendor-active-purchase-products-list") }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        bill_number: purchaseBilNumber
                    },
                    success: function (response) {
                        const purchaseDetails = (response.success);

                        if (jQuery.inArray(purchaseDetails.purchase_details)) {
                            var html_specification_details_names = `<option value=""> Select Purchase Bill Name </option>`;
                            $.each(purchaseDetails.purchase_details, function (index, value) {
                                html_specification_details_names += `<option value="` + value.product.id + `">` + value.product.product_name + `</option>`;
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
                $("#productPrice").val('');

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
                            var html_color_names = `<option value="0"> Select color Name </option>`;
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
                            var html_size_types = `<option value="0"> Select Size Name </option>`;
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
                            var html_weight_types = `<option value="0"> Select Weight Name </option>`;
                            $.each(weight_types, function (index, value) {
                                html_weight_types += `<option value="` + index + `">` + value + `</option>`;
                            });
                            $('#weightId').append(html_weight_types);
                        } else {
                            $('#weightId').addClass('select-hide');
                        }
                    },
                });
                getQuantity();
            });

            //Color Size Weight on change variant product information

            $("#colorId").on('change', function () {
                let colorIDval = $(this).val();
                getQuantity();
            });
            $("#sizeId").on('change', function () {
                let sizeId = $(this).val();
                getQuantity();
            });
            $("#weightId").on('change', function () {
                let weightId = $(this).val();
                getQuantity();
            });
            $(".productQuantity").on('change', function () {
                let productQuantity = $(this).val();
                getQuantity();
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
        // get quantity with variant product total
        function getQuantity(productId = null, colorId = null, sizeId = null, weightId = null, productQuantity = null) {
            purchaseId = $(".purchaseId").val();
            //  productEntryId = $(".product-from-id").val();
            productId = $("#productId").val();
            colorId = $("#colorId").val() || 0;
            sizeId = $("#sizeId").val() || 0;
            weightId = $("#weightId").val() || 0;
            // productQuantity = $(".productQuantity").val();

            $.ajax({
                method: "post",
                url: '{{ route("get-purchase-stock-quantity") }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    product_id: productId,
                    color_id: colorId,
                    size_id: sizeId,
                    weight_id: weightId,
                    //product_entry_id: productEntryId,
                },
                success: function (response) {
                    const quantity = (response.success);
                    let unitePrice = (response.successPrice);
                    //console.log(quantity,unitePrice);
                    // $("#getQuantityTotal").html(quantity);
                    $("#productQuantity").val();
                    $("#productPrice").val(response.successPrice.price);
                    $('#productQuantity').on("keyup", function () {
                        var dInput = this.value;


                        if (quantity < dInput) {
                            $(this).css("border", "1px solid red");
                            //console.log(quantity);
                            $(this).attr({
                                "max": quantity,
                                "min": 1
                            });
                            alert('Your product quantity already stock out ! Your total quantity  ' + quantity);
                            $("#productQuantity").val('');

                        } else {
                            $(this).css("border", "1px solid green");
                            $(this).attr({
                                "max": quantity,
                                "min": 1
                            });
                        }
                    });
                },
            });
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
    <script>

        let productQuantity = $("#productQuantity").val();
        let productPrice = $("#productPrice").val();

        function test() {
            if ($('.inputCheck').eq(0).val() !== '' && $('.inputCheck').eq(0).val() > 0 && $('.inputCheck').eq(1).val() !== '' && $('.inputCheck').eq(1).val() > 0) {
                $("#addRowBtn").removeClass('pointer-events-none');
                $("#addRowBtn").addClass('btn-dark');
            }
        }


    </script>
@endpush
