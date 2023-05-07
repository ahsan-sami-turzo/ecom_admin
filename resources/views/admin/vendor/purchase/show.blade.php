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
    </style>
@endpush

@section('content')
    <form action='{{ route("purchases-approved") }}' method="post" class="dropzone"
          enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card_header">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="card-title card_title"><i class="fab fa-gg-circle"></i> product Purchase View

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
                                <input readonly class="form-control form_control"
                                       value="{{ isset( $purchase->vendor) ? $purchase->vendor->name : ''}}">
                            </div>
                        </div>
                        @endrole
                        <div class="form-group row mb-3 {{ $errors->has('billNo') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">Bill No</label>
                            <label class="col-sm-1 mt-2 text-center"><span class="req_star ">*</span>:</label>
                            <div class="col-sm-6">
                                <input readonly type="text" class="form-control form_control" name=""
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
                                <input readonly type="text" class="form-control form_control" name=""
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
                                <input readonly type="text" class="form-control form_control"
                                       value="{{old('vat_registration',$purchase->vat_registration)}}">

                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('purchaseDate') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">Purchase Date </label>
                            <label class="col-sm-1 mt-2 text-center"><span class="req_star ">*</span>:</label>
                            <div class="col-sm-6">
                                <input readonly type="text" autocomplete="off" class="form-control form_control"
                                       value="{{old('purchaseDate',date('d-m-Y',strtotime($purchase->purchaseDate)))}}">
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('totalQuantity') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">Total Quantity</label>
                            <label class="col-sm-1 mt-2 text-center"><span class="req_star ">*</span>:</label>
                            <div class="col-sm-6">
                                <input id="totalQuantity" disabled type="text" autocomplete="off"
                                       class="form-control form_control"
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
                                <input id="totalAmount" disabled type="text" autocomplete="off"
                                       class="form-control form_control"
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
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id=""
                               class="table table-bordered table-striped table-hover dt-responsive ">
                            <thead class="thead-dark">
                            <tr>
                                <th class="text-center" style="width: 25%">Search Product</th>
                                <th class="text-center" style="width: 10%">Color</th>
                                <th class="text-center" style="width: 10%">Size</th>
                                <th class="text-center" style="width: 10%">Weight</th>
                                <th class="text-center" style="width: 5%">Quantity</th>
                                <th class="text-center" style="width: 10%">Unite Price</th>
                                <th class="text-center">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($purchase->purchaseDetails) > 0)
                                @foreach($purchase->purchaseDetails as $key => $purchaseDetail )

                                    <tr class="addRowTr">
                                        <td class="text-center" style="width: 25%">
                                            <input readonly class="form-control form_control "
                                                   value="{{$purchaseDetail->product->product_name ?? '' }}">
                                        </td>
                                        <td class="text-center" style="width: 15%">
                                            <input readonly class="form-control form_control "
                                                   value="{{ isset($purchaseDetail->color) ? $purchaseDetail->color->name : '' }}">
                                        </td>
                                        <td class="text-center" style="width: 13%">
                                            <input readonly class="form-control form_control "
                                                   value="{{  isset($purchaseDetail->size) ? $purchaseDetail->size->name : '' }}">

                                        </td>
                                        <td class="text-center" style="width: 12%">
                                            <input readonly class="form-control form_control "
                                                   value="{{ isset($purchaseDetail->weight) ? $purchaseDetail->weight  ->name : ''  }}">
                                        </td>
                                        <td class="text-center" style="width: 5%"><input
                                                style="height: 28px; padding: 0;" type="text" autocomplete="off"
                                                class="form-control form_control productQuantity" id="productQuantity"
                                                value='{{ $purchaseDetail->quantity }}'
                                            ></td>
                                        <td class="text-center" style="width: 10%"><input id="productPrice"
                                                                                          style="height: 28px; padding: 0;"
                                                                                          type="text" autocomplete="off"
                                                                                          class="form-control form_control productPrice"
                                                                                          value='{{ $purchaseDetail->price }}'>
                                        </td>
                                        <td class="text-center"><input disabled id="totalPrice"
                                                                       style="height: 28px; padding: 0;" type="text"
                                                                       autocomplete="off"
                                                                       class="form-control form_control totalPrice"
                                                                       value='{{ $purchaseDetail->price * $purchaseDetail->quantity }}'>
                                        </td>

                                    </tr>

                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer card_footer text-center">
                        @if(count($purchase->purchaseDetails) > 0)
                            <input value="1" name="is_approved" hidden>
                            <input value="{{ $purchase->id }}" name="purchaseId" hidden>
                            <button
                                {{ $purchase->is_approved == 1 ? 'disabled' :'' }}  type="{{ $purchase->is_approved == 1 ? 'button' :'submit' }}"
                                class="btn btn-md {{ $purchase->is_approved == 1 ? 'btn-success' :'btn-info' }} ">
                                Approved
                            </button>
                        @endif
                        @if($purchase->is_approved == 0)
                            <a href='{{ route( "purchase.index" ) }}' class="btn btn-md btn-danger">Cancel</a>
                        @endif
                    </div>

                </div>
            </div>
        </div>

    </form>
@endsection

@push('scripts')
    <script>export default {
            components: {Index}
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{asset('contents/admin')}}/assets/js/image-uploader.js"></script>

    <script>
        $(document).ready(function () {
            $('.product-name').select2({});
        });
        $(document).ready(function () {
            $('.select2').select2({});
        });
    </script>

    <script>
        $(document).ready(function () {
            var i = 1;
            $("#addRowBtn").on('click', function () {
                let add_row = `<tr class="addRowTr">
                                    <td class="text-center" style="width: 25%">
<select class="form-control product-name product " id="productId"  name="product_id[]">
                                                    <option value="">---Select product name---</option>

                                                </select>
</td>
                <td class="text-center" style="width: 15%">
                    <select class="form-control color-name" id="colorId" name="color_id[]">
                        <option value="">Color name</option>

                    </select>
                </td>
                <td class="text-center" style="width: 13%">
                    <select class="form-control size-name" id="sizeId" name="size_id[]">
                        <option value="">Size name</option>

                    </select>

                </td>
                <td class="text-center" style="width: 12%">
                    <select class="form-control weight-name" id="weightId" name="weight_id[]">
                        <option value="">Weight name</option>

                    </select>

                </td>
                <td class="text-center" style="width: 5%"><input style="height: 28px; padding: 0;" type="text" autocomplete="off" class="form-control form_control productQuantity" id="productQuantity` + i + `"
                                                                 name="productQuantity[]"
                                                                 value='' oninput="calculate('productQuantity` + i + `','productPrice` + i + `','totalPrice` + i + `')"></td>
                                    <td class="text-center"  style="width: 10%"><input id="productPrice` + i + `" style="height: 28px; padding: 0;" type="text" autocomplete="off" class="form-control form_control productPrice"
                                                                                       name="productPrice[]"
                                                                                       value='' oninput="calculate('productQuantity` + i + `','productPrice` + i + `','totalPrice` + i + `')"></td>
                                    <td class="text-center"><input disabled id="totalPrice` + i + `" style="height: 28px; padding: 0;" type="text" autocomplete="off" class="form-control form_control totalPrice"
                                                                   name="totalPrice[]"
                                                                   value='' ></td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button class="btn btn-dark btn-sm removeRowBtn" id="removeRowBtn` + i + `" type="button" ><i style="font-size: 14px" class="mdi mdi-minus"></i></button>
                                        </div>
                                    </td>
                                </tr>`;

                $('#alltableinfo tr:last').after(add_row);
                i++;
                $(".removeRowBtn").on('click', function () {
                    $(this).parent().parent().parent().remove();
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

            });


        });
    </script>

    <script>
        $(document).ready(function () {
            $('#vendorId').on('change', function () {
                let vendorId = $(this).val();
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
            $('#productId').on('change', function () {
                let productId = $(this).val();
                $(".color-name").empty();
                $(".size-name").empty();
                $(".weight-name").empty();

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

                        if (jQuery.inArray(color_names)) {
                            var html_color_names = `<option value="">Color Name </option>`;
                            $.each(color_names, function (index, value) {
                                html_color_names += `<option value="` + index + `">` + value + `</option>`;
                            });
                            $('.color-name').append(html_color_names);
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

                        if (jQuery.inArray(size_types)) {
                            var html_size_types = `<option value="">Size Name </option>`;
                            $.each(size_types, function (index, value) {
                                html_size_types += `<option value="` + index + `">` + value + `</option>`;
                            });
                            $('.size-name').append(html_size_types);
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

                        if (jQuery.inArray(weight_types)) {
                            var html_weight_types = `<option value="">Weight Name </option>`;
                            $.each(weight_types, function (index, value) {
                                html_weight_types += `<option value="` + index + `">` + value + `</option>`;
                            });
                            $('.weight-name').append(html_weight_types);
                        }
                    },
                });
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
@endpush
