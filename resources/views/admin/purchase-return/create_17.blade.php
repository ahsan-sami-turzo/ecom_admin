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

        .bill-from select {
            background: #eee !important;
        }
    </style>
@endpush

@section('content')
    <form action='{{ route("purchase-return.store") }}' method="post" class="dropzone" enctype="multipart/form-data">
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
                        @role('admin')
                        <div class="form-group row mb-3 {{ $errors->has('vendor_id') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">Vendor name</label>
                            <label class="col-sm-1 mt-2 text-center"><span class="req_star ">*</span>:</label>
                            <div class="col-sm-6">
                                <select class="form-control select2" id="vendorId" name="vendor_id">
                                    <option value="">---Select Vendor name---</option>
                                    @foreach ($users as $user)
                                        <option class="custom-style"
                                                value="{{ $user->id}}"> {{  $user->name ?: ''}}</option>

                                    @endforeach
                                </select>
                                @if ($errors->has('vendor_id'))
                                    <span class="invalid-feedback" role="alert">
                                 <strong>{{ $errors->first('vendor_id') }}</strong>
                                 </span>
                                @endif
                            </div>
                        </div>
                        @endrole
                        <div
                            class="form-group row mb-3 bill-from d-none  {{ $errors->has('purchaseBillNo') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">Bill No</label>
                            <label class="col-sm-1 mt-2 text-center"><span class="req_star ">*</span>:</label>
                            <div class="col-sm-6">
                                <select class="form-control select2" id="billNumbers" name="bill_number">
                                    <option value="">---Select bill name---</option>
                                </select>
                                @if ($errors->has('purchaseBillNo'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('purchaseBillNo') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('purchaseReturnBillNo') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">Purchase Return Bill No </label>
                            <label class="col-sm-1 mt-2 text-center"><span class="req_star ">*</span>:</label>
                            <div class="col-sm-6">
                                <input type="text" autocomplete="off" class="form-control form_control"
                                       name="purchaseReturnBillNo"
                                       value="{{old('purchaseReturnBillNo')}}">
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
                                <input style="background: #eee" readonly id="totalQuantity" type="text"
                                       autocomplete="off"
                                       class="form-control form_control"
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
                                <input style="background: #eee" id="totalAmount" readonly type="text" autocomplete="off"
                                       class="form-control form_control "
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
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div id="product-entry-form" class="card-body ">
                        <table id="alltableinfo"
                               class="table table-bordered table-striped table-hover dt-responsive nowrap custom_table">
                            <thead class="thead-dark">
                            <tr>
                                <th class="text-center" style="width: 25%">Search Product</th>
                                <th class="text-center" colspan="3" style="width: 30%">Specification</th>
                                <th class="text-center" style="width: 5%">Quantity</th>
                                <th class="text-center" style="width: 10%">Unite Price</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Manage</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="addRowTr">
                                <td class="text-center" style="width: 25%">
                                    <input hidden class="form-control purchaseId" name="purchaseId[]"
                                           value=""/>
                                    <input hidden class="form-control product-from-id" name="product_entry_id[]"
                                           value=""/>
                                    <input hidden class="form-control productId" name="product_id[]"
                                           value=""/>
                                    <input class="form-control product-from"
                                           value=""/>


                                </td>
                                <td class="text-center" style="width: 15%">
                                    <input class="form-control colorId" hidden name="colorId[]"
                                           value=""/>
                                    <input class="form-control color-name" id="colorId"/>

                                </td>
                                <td class="text-center" style="width: 13%">
                                    <input class="form-control sizeId" hidden name="sizeId[]"
                                           value=""/>
                                    <input class="form-control size-name" id="sizeId"/>
                                </td>
                                <td class="text-center" style="width: 12%">
                                    <input class="form-control weightId" hidden name="weight_id[]"
                                           value=""/>
                                    <input class="form-control weight-name " id="weightId"/>
                                </td>
                                <td class="text-center" style="width: 5%"><input style="height: 28px; padding: 0;"
                                                                                 type="number" autocomplete="off"
                                                                                 class="form-control form_control productQuantity text-right"
                                                                                 id="productQuantity"
                                                                                 name="productQuantity[]"
                                                                                 value='{{ old("productQuantity") }}'
                                                                                 oninput="calculate('productQuantity','productPrice','totalPrice')">
                                </td>
                                <td class="text-center" style="width: 10%"><input id="productPrice"
                                                                                  style="height: 28px; padding: 0;"
                                                                                  type="text" autocomplete="off"
                                                                                  class="form-control form_control productPrice text-right"
                                                                                  name="productPrice[]"
                                                                                  value='{{ old("productPrice") }}'
                                                                                  oninput="calculate('productQuantity','productPrice','totalPrice')">
                                </td>
                                <td class="text-center"><input disabled id="totalPrice"
                                                               style="height: 28px; padding: 0;" type="text"
                                                               autocomplete="off"
                                                               class="form-control form_control totalPrice text-right"
                                                               name="totalPrice[]"
                                                               value='{{ old("totalPrice") }}'></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button class="btn btn-dark btn-sm " id="addRowBtn" type="button"><i
                                                style="font-size: 14px" class="mdi mdi-plus"></i></button>
                                    </div>
                                </td>
                            </tr>

                            </tbody>
                        </table>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            // $('.product-name').select2({});
        });
        $(document).ready(function () {
            $('.select2').select2({});
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#vendorId').on('change', function () {
                $('.product-name').select2({});
                let vendorId = $(this).val();
                $('.bill-from').removeClass('d-none');
                $("#billNumbers").empty();
                $(".product-name").empty();

                //purchase bill number change name
               // document.getElementById("product-entry-form").innerHTML = '';
                $.ajax({
                    method: "post",
                    url: '{{ route("vendor-purchase-list") }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        vendor_id: vendorId
                    },
                    success: function (response) {
                        const billNumbers = (response.success);
                        if (jQuery.inArray(billNumbers)) {
                            var html_billNumbers = `<option value=""> Select Bill Number </option>`;
                            $.each(billNumbers, function (index, value) {
                                html_billNumbers += `<option value="` + value.id + `">` + value.billNo + `</option>`;
                            });
                            $('#billNumbers').append(html_billNumbers);

                            $('#billNumbers').on('change', function () {
                                let purchaseBilNumber = $(this).val();
                                let htmlBtn = `<i style="font-size: 14px" class="mdi mdi-minus"></i>`;

                               // $("#product-entry-form").addClass('d-none');
                               // document.getElementById("product-entry-form").innerHTML = '';
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
                                        console.log(purchaseDetails.purchase_details);
                                        if (jQuery.inArray(purchaseDetails.purchase_details)) {

                                            $("#totalQuantity").val(purchaseDetails.totalQuantity);
                                            $("#totalAmount").val(purchaseDetails.totalAmount);
                                            $.each(purchaseDetails.purchase_details, function (index, value) {
                                                $('#alltableinfo tr:last').after(` <tr class="addRowTr">
                                <td class="text-center" style="width: 25%">
                                    <input hidden class="form-control purchaseId" name="purchaseId[]"
                                           value=""/>
                                    <input hidden class="form-control product-from-id" name="product_entry_id[]"
                                           value=""/>
                                    <input hidden class="form-control productId" name="product_id[]"
                                           value=""/>
                                    <input class="form-control product-from"
                                           value=""/>


                                </td>
                                <td class="text-center" style="width: 15%">
                                    <input class="form-control colorId" hidden name="colorId[]"
                                           value=""/>
                                    <input class="form-control color-name" id="colorId"/>

                                </td>
                                <td class="text-center" style="width: 13%">
                                    <input class="form-control sizeId" hidden name="sizeId[]"
                                           value=""/>
                                    <input class="form-control size-name" id="sizeId"/>
                                </td>
                                <td class="text-center" style="width: 12%">
                                    <input class="form-control weightId" hidden name="weight_id[]"
                                           value=""/>
                                    <input class="form-control weight-name " id="weightId"/>
                                </td>
                                <td class="text-center" style="width: 5%"><input style="height: 28px; padding: 0;"
                                                                                 type="number" autocomplete="off"
                                                                                 class="form-control form_control productQuantity text-right"
                                                                                 id="productQuantity"
                                                                                 name="productQuantity[]"
                                                                                 value=''
                                                                                 oninput="calculate('productQuantity','productPrice','totalPrice')">
                                </td>
                                <td class="text-center" style="width: 10%"><input id="productPrice"
                                                                                  style="height: 28px; padding: 0;"
                                                                                  type="text" autocomplete="off"
                                                                                  class="form-control form_control productPrice text-right"
                                                                                  name="productPrice[]"
                                                                                  value=''
                                                                                  oninput="calculate('productQuantity','productPrice','totalPrice')">
                                </td>
                                <td class="text-center"><input disabled id="totalPrice"
                                                               style="height: 28px; padding: 0;" type="text"
                                                               autocomplete="off"
                                                               class="form-control form_control totalPrice text-right"
                                                               name="totalPrice[]"
                                                               value=''></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button class="btn btn-dark btn-sm removeRowBtn" type="button"><i
                                                style="font-size: 14px" class="mdi mdi-minus"></i></button>
                                    </div>
                                </td>
                            </tr>`);
                                            });

                                        }
                                    },
                                });
                            });
                        }
                    },
                });
            });
            //remove row tr delete
            $(".removeRowBtn").on('click', function () {
                alert('ok');
                $(this).closest('tr').remove();

                //remove total Quantity number
                var tQuantity = 0;
                $(".productQuantity").each(function () {
                    tQuantity += parseFloat($(this).val());
                });
                $('#totalQuantity').val('');
                $('#totalQuantity').val(tQuantity);

                //remove total Amount number
                var tSum = 0;
                $(".totalPrice").each(function () {
                    tSum += parseFloat($(this).val());
                });
                $('#totalAmount').val('');
                $('#totalAmount').val(tSum);
            });

            $("#colorId").on('change', function () {
                getQunty();
            });
            $("#sizeId").on('change', function () {
                getQunty();
            });
            $("#weightId").on('change', function () {
                getQunty();
            });
            $(".productQuantity").on('change', function () {
                getQunty();
            });

        });
        function getQunty(productId = null, colorId = null, sizeId = null, weightId = null, productQuantity = null, productEntryId = null, purchaseId = null) {
            purchaseId = $(".purchaseId").val();
            productEntryId = $(".product-from-id").val();
            productId = $(".productId").val();
            colorId = $(".colorId").val();
            sizeId = $(".sizeId").val();
            weightId = $(".weightId").val();
            productQuantity = $(".productQuantity").val();
            console.log(productEntryId, productId, colorId, sizeId, weightId, productQuantity);
            $.ajax({
                method: "post",
                url: '{{--{{ route("get-purchase-stock-quantity") }}--}}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    product_id: productId,
                    color_id: colorId,
                    size_id: sizeId,
                    weight_id: weightId,
                    product_entry_id: productEntryId,
                },
                success: function (response) {
                    const quantity = (response.success);
                    $("#productQuantity").val(quantity);
                    $('#productQuantity').on("keyup", function () {
                        var dInput = this.value;

                        if (quantity < dInput) {
                            $(this).css("border", "1px solid red");
                            //console.log(quantity);
                            $(this).attr({
                                "max": quantity,
                                "min": 1
                            });

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

            $.ajax({
                method: "post",
                url: '{{ route("get-purchase-quantity") }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    product_id: productId,
                    color_id: colorId,
                    size_id: sizeId,
                    weight_id: weightId,
                    purchaseId: purchaseId,
                },
                success: function (response) {
                    const quantity = (response.success);
                    $("#productQuantity").val(quantity);
                    $('#productQuantity').on("keyup", function () {
                        var dInput = this.value;

                        /* if (quantity < dInput) {
                             $(this).css("border", "1px solid red");
                             //console.log(quantity);
                             $(this).attr({
                                 "max": quantity,
                                 "min": 1
                             });

                         } else {
                             $(this).css("border", "1px solid green");
                             $(this).attr({
                                 "max": quantity,
                                 "min": 1
                             });
                         }*/
                    });
                },
            });
        }
    </script>
    <script>
        var quantity = 0;
        var total = 0;
        var price = 0;

        function calculate(qtyId, priceId, id) {
            quantity = document.getElementById(qtyId).value;
            price = document.getElementById(priceId).value;

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

    <!--<script>
            //Modal code start
            $(document).ready(function(){
                $(document).on("click", "#delete", function () {
                    var deleteID = $(this).data('id');
                    $(".modal_card #modal_id").val( deleteID );
                });
            });
        </script>-->
@endpush
