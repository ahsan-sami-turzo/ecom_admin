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

        .disabled_input {
            background: rgba(114, 109, 109, 0.24) !important;
            color: #0e0e0e;
            font-weight: 600;
            cursor: default;
        }

        .select-hide {
            display: none !important;
        }
    </style>
@endpush

@section('content')
    <form action='{{ route("purchase.update",$purchase->id) }}' method="post" class="dropzone"
          enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card_header">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="card-title card_title"><i class="fab fa-gg-circle"></i> product Purchase add

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
                                                value="{{ $user->id}}" {{ $user->id  == $purchase->supplierId ? 'selected' : ''}} > {{  $user->name ?: ''}}</option>
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
                        <div class="form-group row mb-3 {{ $errors->has('billNo') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">Bill No</label>
                            <label class="col-sm-1 mt-2 text-center"><span class="req_star ">*</span>:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control form_control" name="billNo"
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
                                <input type="text" class="form-control form_control" name="chalanNo"
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
                                <input type="text" autocomplete="off" class="form-control form_control"
                                       name="purchaseDate"
                                       value="{{old('purchaseDate',date('d-m-Y',strtotime($purchase->purchaseDate)))}}">
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
        <div class="row ">
            <div class="col-12">
                <div class="card ">
                    <div id="product-entry-form" class="card-body">
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
                            @foreach( $purchase->purchaseDetails as $key => $d)

                                <tr class="addRowTr">

                                        <td class="text-center" style="width: 25%">
                                            <select class="form-control product-name product select-box" id="productId"
                                                    name="product_id[]">
                                                <option value="">---Select product name---</option>
                                                @foreach( $products->vendor->vendorProducts as $data)
                                                <option
                                                    value="{{ $data->id }}" {{ $data->id == $d->productId ? 'selected' : ''  }}>{{ $data->product_name }}</option>

                                                @endforeach
                                            </select>
                                            @if ($errors->has('product_id'))
                                                <span class="invalid-feedback" role="alert">
                                             <strong>{{ $errors->first('product_id') }}</strong>
                                            </span>
                                            @endif
                                        </td>
                                        <td class="text-center hide-th-td" style="width: 15%">
                                            <div class="td_show_color {{ count($d->product->color) == null ? 'd-none' : '' }}">
                                                <select class="form-control color-name select-box" id="colorId"
                                                        name="color_id[]">
                                                    <option value="">Color name</option>
                                                    @foreach( $products->vendor->vendorProducts->color as $dataColor)
                                                        <option value="{{ $dataColor->id }}" {{ $dataColor->id == $purchaseProduct[0]->id ? 'selected' : '' }}>{{ $dataColor->name  }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('color_id'))
                                                    <span class="invalid-feedback" role="alert">
                                             <strong>{{ $errors->first('color_id') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td id="" class="text-center hide-th-td" style="width: 13%">
                                            <div class="td_show_size {{ count($d->product->size) == null ? 'd-none' : '' }}">
                                                <select class="form-control size-name select-box" id="sizeId"
                                                        name="size_id[]">
                                                    <option value="">Size name</option>
                                                    @foreach( $d->product->size as $dataSize)
                                                        <option value="{{ $dataSize->id }}">{{ $dataSize->name }}</option>
                                                    @endforeach

                                                </select>
                                                @if ($errors->has('size_id'))
                                                    <span class="invalid-feedback" role="alert">
                                             <strong>{{ $errors->first('size_id') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td id="" class="text-center hide-th-td " style="width: 12%">
                                            <div class="td_show_weight {{ count($d->product->weight) == null ? 'd-none' : '' }}">
                                                <select class="form-control weight-name select-box " id="weightId"
                                                        name="weight_id[]">
                                                    <option value="">Weight name</option>
                                                    @foreach( $d->product->weight as $dataWeight)
                                                        <option value="{{ $dataWeight->id }}">{{ $dataWeight->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('weight_id'))
                                                    <span class="invalid-feedback" role="alert">
                                             <strong>{{ $errors->first('weight_id') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center" style="width: 5%"><input
                                                style="height: 28px; padding: 0;"
                                                type="text" autocomplete="off"
                                                class="form-control form_control productQuantity"
                                                id="productQuantity"
                                                name="productQuantity[]"
                                                value='{{ $d->quantity }}'
                                                oninput="calculate('productQuantity','productPrice','totalPrice')">
                                        </td>
                                        <td class="text-center" style="width: 10%"><input id="productPrice"
                                                                                          style="height: 28px; padding: 0;"
                                                                                          type="text" autocomplete="off"
                                                                                          class="form-control form_control productPrice"
                                                                                          name="productPrice[]"
                                                                                          value='{{ $d->price }}'
                                                                                          oninput="calculate('productQuantity','productPrice','totalPrice')">
                                        </td>
                                        <td class="text-center"><input disabled id="totalPrice"
                                                                       style="height: 28px; padding: 0;" type="text"
                                                                       autocomplete="off"
                                                                       class="form-control form_control totalPrice"
                                                                       name="totalPrice[]"
                                                                       value='{{ $d->quantity * $d->price }}'></td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button
                                                    class="btn btn-dark btn-sm {{ $key != 0 ? 'removeRowBtn' : '' }}"
                                                    {{ $key == 0 ? 'id=addRowBtn' : '' }}  type="button"><i
                                                        style="font-size: 14px"
                                                        class="mdi {{ $key == 0 ? 'mdi-plus' : 'mdi-minus' }}  "></i>
                                                </button>
                                            </div>
                                        </td>

                                </tr>

                            @endforeach


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
    <script src="{{asset('contents/admin')}}/assets/js/image-uploader.js"></script>

    <script>
        $(document).ready(function () {
            $('.select2').select2({});
        });
        $(document).ready(function () {
            $('.product-name').select2({});
            $('.color-name').select2({});
            $('.size-name').select2({});
            $('.weight-name').select2({});
        });
    </script>


    <script>
        $(document).ready(function () {
            $('#vendorId').on('change', function () {
                $("#product-entry-form").removeClass('d-none');
                $('.product-name').select2({});

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

                        if (jQuery.inArray(details_name)) {
                            let i = 1;
                            $("#addRowBtn").on('click', function () {

                                var vendor_Id = $("#vendorId").attr('data-id', vendorId);
                                var vendoId = $("#vendorId").data('id');
                                let idd = $("#vendorId").val(vendorId);
                                let htmlBtn = `<i style="font-size: 14px" class="mdi mdi-minus"></i>`;

                                let add_row = $(".addRowTr").first().clone();
                                ;
                                $("#alltableinfo tbody tr:first").find('input').val('');
                                $("#alltableinfo tbody tr:first").find('.select-box').val('').trigger('change');
                                $('#alltableinfo tr:last').after(add_row);
                                $("#alltableinfo tbody tr:last").find('button').html(htmlBtn).addClass('removeRowBtn').removeAttr('id');
                                $("#alltableinfo tbody tr:last").find('.productQuantity').attr('readonly', true);
                                $("#alltableinfo tbody tr:last").find('.productPrice').attr('readonly', true);

                                // $("#productId" + i).select2({});

                                // product name change when color name, size name, weight name
                                //  console.log(i);


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
                            $('.td_show_color').removeClass('d-none');
                            var html_color_names = `<option value="0">Color Name </option>`;
                            $.each(color_names, function (index, value) {
                                html_color_names += `<option value="` + index + `">` + value + `</option>`;
                            });

                            $('#colorId').append(html_color_names);
                        } else {
                            $('.td_show_color').addClass('d-none');
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
                            $('.td_show_size ').removeClass('d-none');
                            var html_size_types = `<option value="0">Size Name </option>`;
                            $.each(size_types, function (index, value) {
                                html_size_types += `<option value="` + index + `">` + value + `</option>`;
                            });
                            $('#sizeId').append(html_size_types);
                        } else {
                            $('.td_show_size ').addClass('d-none');
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
                            $('.td_show_weight').removeClass('d-none');
                            var html_weight_types = `<option value="0">Weight Name </option>`;
                            $.each(weight_types, function (index, value) {
                                html_weight_types += `<option value="` + index + `">` + value + `</option>`;
                            });
                            $('#weightId').append(html_weight_types);
                        } else {
                            $('.td_show_weight').addClass('d-none');
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
