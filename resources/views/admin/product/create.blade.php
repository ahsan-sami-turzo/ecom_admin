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
    <form action='{{ route("product.store") }}' method="post" class="dropzone" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card_header">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="card-title card_title"><i class="fab fa-gg-circle"></i> product add

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
                        <div class="form-group row mb-3 {{ $errors->has('product_name') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">Product name</label>
                            <label class="col-sm-1 mt-2 text-center"><span class="req_star ">*</span>:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control form_control" name="product_name"
                                       value="{{old('product_name')}}">
                                @if ($errors->has('product_name'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('product_name') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('category_id') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">Product category</label>
                            <label class="col-sm-1 mt-2 text-center"><span class="req_star ">*</span>:</label>
                            <div class="col-sm-6">
                                <select class="form-control select2" id="parentId" name="category_id">
                                    <option value="">---Select Parent category---</option>
                                    @foreach ($categories as $category)
                                        <option class="custom-style" value="{{ $category->id}}"
                                                style="font-weight: 900 !important; display: block !important; "><?= str_repeat("&nbsp; ", $category->level).'--'?> {{  $category->category_name}}</option>
{{--                                        @if(count($category->parentCategory))--}}
{{--                                            @include('admin.category.include.subcategory',['childs' => $category->parentCategory])--}}
{{--                                        @endif--}}
                                    @endforeach
                                </select>
                                @if ($errors->has('category_id'))
                                    <span class="invalid-feedback" role="alert">
                                 <strong>{{ $errors->first('category_id') }}</strong>
                                 </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3 colorRow d-none">

                                <label style="padding-right: 0 !important;"
                                       class="col-sm-3 col-form-label col_form_label">Color</label>
                            <label class="col-sm-1 mt-2 text-center"><span class="req_star ">*</span>:</label>



                            <div style="padding-left: 0 !important;" class="col-sm-6">
                                <div style="margin-left: -20px" class="row mb-3" id="colorRow">
                                    <div style="padding-left: 32px !important;" class="col-sm-5">
                                        <div class="input-group mb-3">
                                            <input  type="text" autocomplete="off" class="form-control form_control colorRequired"
                                                   name="color_name[]"
                                                   value="">
                                        </div>
                                    </div>
                                    <div style="padding-left: 0 !important; " class="col-sm-6">
                                        <div class="input-images"></div>
                                        @if ($errors->has('color_images'))
                                            <span class="invalid-feedback" role="alert">
                                           <strong>{{ $errors->first('color_images') }}</strong>
                                        </span>
                                        @endif

                                    </div>
                                    <div class="col-sm-1">
                                        <button style="height: 30px" class="btn btn-outline-secondary" type="button"
                                                id="addColor"><i class="fa fa-plus"></i></button>

                                    </div>
                                </div>


                            </div>

                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('size_name') ? ' has-error' : '' }} sizeRow d-none">
                            <label class="col-sm-3 col-form-label col_form_label">Size</label>
                            <label class="col-sm-1 mt-2 text-center"><span class="req_star ">*</span>:</label>
                            <div class="col-sm-3">
                                <div class="input-group mb-3 add-size-name">
                                    <input id="add_size" style="margin-right: 10px;" type="text" autocomplete="off"
                                           class="form-control form_control sizeRequired"
                                           name="size_name[]"
                                           value="">
                                    <button class="btn btn-outline-secondary" type="button" id="addSize"><i
                                            class="fa fa-plus"></i></button>
                                </div>


                            </div>

                        </div>
                        <div class="form-group row mb-3 weightRow d-none">
                            <label class="col-sm-3 col-form-label col_form_label">Weight</label>
                            <label class="col-sm-1 mt-2 text-center"><span class="req_star ">*</span>:</label>

                            <div class="col-sm-3">
                                <div class="input-group mb-3">
                                    <input id="weight_add" style="margin-right: 10px;" type="text" autocomplete="off"
                                           class="form-control form_control weightRequired"
                                           name="weight_name[]"
                                           value="">
                                    <button class="btn btn-outline-secondary" type="button" id="addWeight"><i
                                            class="fa fa-plus"></i></button>
                                </div>


                            </div>

                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('productBrand') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">Product brand </label>
                            <label class="col-sm-1 mt-2 text-center"><span class="req_star ">*</span>:</label>
                            <div class="col-sm-6">
                                <input type="text" autocomplete="off" class="form-control form_control"
                                       name="brand_name"
                                       value="{{old('brand_name')}}">
                                @if ($errors->has('brand_name'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('brand_name') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('productPrice') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">Product price</label>
                            <label class="col-sm-1 mt-2 text-center"><span class="req_star ">*</span>:</label>
                            <div class="col-sm-6">
                                <input type="text" autocomplete="off" class="form-control form_control"
                                       name="productPrice"
                                       value='{{ old("productPrice") }}'>
                                @if ($errors->has('productPrice'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('productPrice') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('title') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">Product title</label>
                            <label class="col-sm-1 mt-2 text-center"><span class="req_star ">*</span>:</label>
                            <div class="col-sm-6">
                                <input type="text" autocomplete="off" class="form-control form_control"
                                       name="title" value="{{old('title')}}">
                                @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('description') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">Product description</label>
                            <label class="col-sm-1 mt-2 text-center"><span class="req_star ">*</span>:</label>
                            <div class="col-sm-6">
                            <textarea type="text" autocomplete="off" class="form-control form_control"
                                      name="description"> {{old('description')}}</textarea>
                                @if ($errors->has('description'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <!-- VENDOR IMAGE  -->
                        <div class="form-group row mb-3 {{ $errors->has('descriptionImage') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">Product Feature Image</label>
                            <label class="col-sm-1 mt-2 text-center"><span class="req_star ">*</span>:</label>
                            <div class="col-sm-4">
                                <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file btnu_browse">
                                        Browse… <input type="file" multiple name="home_image" id="imgInp-one">
                                    </span>
                                </span>
                                    <input type="text"  class="form-control" readonly>
                                </div>
                                @if ($errors->has('home_image'))
                                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('home_image') }}</strong>
                            </span>
                                @endif
                                <img style="height: 80px; margin-top: 10px" id="img-upload-one"/>
                            </div>
                        </div>
                        <!-- Multiple product uploading IMAGE  -->
                        {{--                                                <div class="form-group row mb-3 {{ $errors->has('descriptionImage') ? ' has-error' : '' }}">--}}
                        {{--                                                    <label class="col-sm-3 col-form-label col_form_label ">Product Image</label>--}}
                        {{--                                                    <label class="col-sm-1 mt-2 text-center"><span class="req_star ">*</span>:</label>--}}
                        {{--                                                    <div class="col-sm-6 ">--}}
                        {{--                                                        <div class="input-images"></div>--}}
                        {{--                                                        @if ($errors->has('descriptionImage'))--}}
                        {{--                                                            <span class="invalid-feedback" role="alert">--}}
                        {{--                                                        <strong>{{ $errors->first('descriptionImage') }}</strong>--}}
                        {{--                                                    </span>--}}
                        {{--                                                        @endif--}}
                        {{--                                                        <img style="height: 80px; margin-top: 10px" id="img-upload-one"/>--}}
                        {{--                                                    </div>--}}
                        {{--                                                </div>--}}

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
            $('.select2').select2();
        });
    </script>
    <script>
        //Image Upload Script
        $(document).ready(function () {
            $(document).on('change', '.btn-file :file', function () {
                var input = $(this),
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [label]);
            });

            $('.btn-file :file').on('fileselect', function (event, label) {

                var input = $(this).parents('.input-group').find(':text'),
                    log = label;

                if (input.length) {
                    input.val(log);
                } else {
                    if (log)
                        alert(log);
                }

            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#img-upload-test').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#imgInp-test").change(function () {
                readURL(this);
            });

        });

        //Image Upload Script
        $(document).ready(function () {
            $(document).on('change', '.btn-file :file', function () {
                var input = $(this),
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [label]);
            });

            $('.btn-file :file').on('fileselect', function (event, label) {

                var input = $(this).parents('.input-group').find(':text'),
                    log = label;

                if (input.length) {
                    input.val(log);
                } else {
                    if (log)
                        alert(log);
                }

            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#img-upload-one').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#imgInp-one").change(function () {
                readURL(this);
            });

        });

        //Image Upload Script
        $(document).ready(function () {
            $(document).on('change', '.btn-file :file', function () {
                var input = $(this),
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [label]);
            });

            $('.btn-file :file').on('fileselect', function (event, label) {

                var input = $(this).parents('.input-group').find(':text'),
                    log = label;

                if (input.length) {
                    input.val(log);
                } else {
                    if (log)
                        alert(log);
                }

            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#img-upload-two').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#imgInp-two").change(function () {
                readURL(this);
            });

        });

        //Image Upload Script
        $(document).ready(function () {
            $(document).on('change', '.btn-file :file', function () {
                var input = $(this),
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [label]);
            });

            $('.btn-file :file').on('fileselect', function (event, label) {

                var input = $(this).parents('.input-group').find(':text'),
                    log = label;

                if (input.length) {
                    input.val(log);
                } else {
                    if (log)
                        alert(log);
                }

            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#img-upload-three').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#imgInp-three").change(function () {
                readURL(this);
            });

        });

        //Image Upload Script
        $(document).ready(function () {
            $(document).on('change', '.btn-file :file', function () {
                var input = $(this),
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [label]);
            });

            $('.btn-file :file').on('fileselect', function (event, label) {

                var input = $(this).parents('.input-group').find(':text'),
                    log = label;

                if (input.length) {
                    input.val(log);
                } else {
                    if (log)
                        alert(log);
                }

            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#img-upload-cover').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#imgInp-cover").change(function () {
                readURL(this);
            });

        });
    </script>
    <script>
        $(document).ready(function () {
            $(function () {
                $('.input-images').imageUploader({
                    imagesInputName: 'color_images_0',
                    label: 'Max 5 color images add here',
                    preloadedInputName: 'old',
                    extensions: ['.jpg', '.jpeg', '.png', '.gif', '.svg', '.JPEG', '.JPG', 'TIFF', '.GIF', '.PNG', '.SVG'],
                    mimes: ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'],
                    maxSize: 5 * 1024 * 1024,
                });

            });
        });
    </script>

    <script>
        $(document).ready(function () {
            // if category change into product ,category specification like size, weight,color status show
            $('#parentId').on('change', function () {
                let categoryId = $(this).val();
                $.ajax({
                    method: "post",
                    url: '{{ route("is-specification") }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        category_id: categoryId
                    },
                    success: function (response) {
                        if (response.success) {
                            //alert('ok');
                            if (response.success.is_color == 0) {
                                $(".colorRow").addClass('d-none');
                                $('.colorRequired').removeAttr('required', 'required');
                            }else{
                                $(".colorRow").removeClass('d-none');
                                $('.colorRequired').attr('required', 'required');
                            }
                            if (response.success.is_size == 0) {
                                $(".sizeRow").addClass('d-none');
                                $('.sizeRequired').removeAttr('required', 'required');
                            }else{
                                $(".sizeRow").removeClass('d-none');
                                $('.sizeRequired').attr('required', 'required');
                            }
                            if (response.success.is_weight == 0) {
                                $(".weightRow").addClass('d-none');
                                $('.weightRequired').removeAttr('required','required');
                            }else{
                                $(".weightRow").removeClass('d-none');
                                $('.weightRequired').attr('required', 'required');
                            }
                        } else {
                            $(this).val();
                        }
                    }
                });
            });

        });
    </script>

    <script>
        $(document).ready(function () {
            //add-remove size row function
            $('#addSize').on('click', function () {
                let val = $("#add_size").val();
                let add_size_div = `<div class="input-group mb-3 inputFormRow">
                                    <input style="margin-right: 10px;" type="text" autocomplete="off" class="form-control form_control"
                                           name="size_name[]"
                                           value="`+val+`" >
                                    <button class="btn btn-outline-danger removesize" type="button"><i class="fa fa-minus"></i></button>
                                </div>`;
                $(this).parent().before(add_size_div);
                $('#add_size').val('');
                $(".removesize").on('click', function () {

                    $(this).parent('.inputFormRow').remove();
                });
            });

            //add-remove weight row function
            $('#addWeight').on('click', function () {
                let weightRequired = $('#weight_add').val();
                let add_weight_div = `<div class="input-group mb-3 inputFormRow">
                                    <input style="margin-right: 10px;" type="text" autocomplete="off" class="form-control form_control"
                                           name="weight_name[]"
                                           value="`+weightRequired+`">
                                    <button class="btn btn-outline-danger removeWeight" type="button"><i class="fa fa-minus"></i></button>
                                </div>`;
                $(this).parent().before(add_weight_div);
                $('#weight_add').val('');
                $(".removeWeight").on('click', function () {

                    $(this).parent('.inputFormRow').remove();
                });
            });

            var i = 1;
            $('#addColor').on('click', function () {
               // let add_color_div = ``;
              //  let addColorName = $("#add_color_name"+i).val();
                $(this).parents('#colorRow').clone();
                $(this).parents('#colorRow').before(`<div style="margin-left: -20px" class="row mb-3 ">
                    <div style="padding-left: 32px !important;" class="col-sm-5">
                        <div class="input-group mb-3">
                            <input id="add_color_name`+i+` " type="text" autocomplete="off" class="form-control form_control"
                                   name="color_name[]" value="">
                        </div>
                    </div>
                    <div style="padding-left: 0 !important; " class="col-sm-6">
                        <div class="input-images-`+i+`"></div>
                    </div>
                    <div class="col-sm-1">
                        <button style="height: 30px" class="btn btn-outline-danger removeColor" type="button"
                        ><i class="fa fa-minus"></i></button>
                    </div>
                </div>`);

                $(".input-images-"+i).imageUploader({
                    imagesInputName: 'color_images_'+i,
                    label: 'Color images here',
                    preloadedInputName: 'old',
                    extensions: ['.jpg', '.jpeg', '.png', '.gif', '.svg', '.JPEG', '.JPG', 'TIFF', '.GIF', '.PNG', '.SVG'],
                    mimes: ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'],
                    maxSize: 5 * 1024 * 1024,
                });
                i++;
                $(".removeColor").on('click', function () {
                     $(this).parent().parent().remove();
                });
            });



        });
    </script>
@endpush
