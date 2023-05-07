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

        .disabled_input,
        .select2-container--default .select2-selection--single,
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            background: rgba(114, 109, 109, 0.24) !important;
            color: #0e0e0e;
            font-weight: 600;
            cursor: default;
        }
    </style>
@endpush

@section('content')
    <form action='{{ route("authorize-update",$product->id) }}' method="post" class="dropzone"
          enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card_header">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="card-title card_title"><i class="fab fa-gg-circle"></i> product authorize

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
                                <select disabled class="form-control select2 disabled_input" id="vendorId">
                                    <option value="">---Select Vendor name---</option>
                                    @foreach ($users as $user)
                                        <option class="custom-style"
                                                value="{{ $user->id}}" {{ $product->vendor_id == $user->id ? "selected" : '' }}> {{  $user->name ?: ''}}</option>

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
                        <div class="form-group row mb-3 {{ $errors->has('category_id') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">Product category</label>
                            <label class="col-sm-1 mt-2 text-center"><span class="req_star ">*</span>:</label>
                            <div class="col-sm-6">
                                <select disabled class="form-control select2" id="parentId" name="category_id">
                                    <option value="">---Select Parent category---</option>
                                    @foreach ($categories as $category)
                                        <option class="custom-style" value="{{ $category->id}}"
                                                {{ $category->id == $product->category_id ? "selected" : '' }}
                                                style="font-weight: 900 !important; display: block !important; "><?= str_repeat("&nbsp; ", $category->level)?> {{  $category->category_name}}</option>
                                        @if(count($category->parentCategory))
                                            @include('admin.category.include.productSubcategory',['childs' => $category->parentCategory,'cateId' =>$product->category_id])
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('category_id'))
                                    <span class="invalid-feedback" role="alert">
                                 <strong>{{ $errors->first('category_id') }}</strong>
                                 </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('product_name') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">Product name</label>
                            <label class="col-sm-1 mt-2 text-center"><span class="req_star ">*</span>:</label>
                            <div class="col-sm-6">
                                <input disabled type="text" class="disabled_input form-control form_control"
                                       value="{{old('product_name',$product->product_name)}}">
                                @if ($errors->has('product_name'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('product_name') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>

                        <div
                            class="form-group row mb-3 colorRow {{ isset($product->category) ? ($product->category->is_color == 0) ? 'd-none' : '' : '' }}">

                            <label style="padding-right: 0 !important;"
                                   class="col-sm-3 col-form-label col_form_label">Color</label>
                            <label class="col-sm-1 mt-2 text-center"><span class="req_star ">*</span>:</label>


                            <div style="padding-left: 0 !important;" class="col-sm-6">
                                @if(count($product->color) > 0)
                                    @foreach($product->color as $key => $value)
                                        <div style="margin-left: -20px" class="row mb-3" id="colorRow">
                                            <div style="padding-left: 32px !important;" class="col-sm-6">
                                                <div class="input-group mb-3">
                                                    <input disabled class="disabled_input" value="{{ $value->id }}"
                                                           hidden>
                                                    <input disabled type="text" autocomplete="off"
                                                           class="form-control form_control colorRequired disabled_input"
                                                           value="{{$value->name ?: ''}}">
                                                </div>
                                            </div>
                                            <div style="padding-left: 0 !important; " class="col-sm-6">
                                                <div class="input-images-{{\Str::slug($value->name)}}"></div>
                                                @if ($errors->has('color_images'))
                                                    <span class="invalid-feedback" role="alert">
                                           <strong>{{ $errors->first('color_images') }}</strong>
                                        </span>
                                                @endif
                                            </div>

                                        </div>
                                    @endforeach
                                @else
                                    <div style="margin-left: -20px"
                                         class="row mb-3 colorRow {{ isset($product->category) ? ($product->category->is_color == 0) ? 'd-none' : '' : '' }}"
                                         id="colorRow">
                                        <div style="padding-left: 0 !important;" class="col-sm-5">
                                            <div class="input-group mb-3">
                                                <input disabled type="text" autocomplete="off"
                                                       class="form-control form_control colorRequired"
                                                       value="" {{ isset($product->category) ? ($product->category->is_color == 1) ? 'required' : '' : '' }}>
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

                                    </div>
                                @endif

                            </div>

                        </div>
                        <div
                            class="form-group row mb-3 {{ $errors->has('size_name') ? ' has-error' : '' }} sizeRow {{ isset($product->category) ? ($product->category->is_size == 0) ? 'd-none' : '' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">Size</label>
                            <label class="col-sm-1 mt-2 text-center"><span class="req_star ">*</span>:</label>
                            <div class="col-sm-3">
                                @if(count($product->size) > 0)
                                    @foreach($product->size as$key => $value)
                                        <div class="input-group mb-3 add-size-name inputFormRow"
                                             @if($key !== 0) style="width: 100% !important;" @endif>
                                            <input disabled required style="margin-right: 10px;" type="text"
                                                   autocomplete="off"
                                                   class="form-control form_control sizeRequired disabled_input"
                                                   value="{{$value->name?: ''}}">
                                        </div>
                                    @endforeach
                                @else
                                    <div
                                        class="input-group mb-3 add-size-name sizeRow {{ isset($product->category) ? ($product->category->is_size == 0) ? 'd-none' : '' : '' }}">
                                        <input disabled style="margin-right: 10px;" type="text" autocomplete="off"
                                               class="form-control form_control sizeRequired"

                                               value="" {{ isset($product->category) ? ($product->category->is_size == 1) ? 'required' : '' : '' }}>

                                    </div>
                                @endif
                            </div>

                        </div>
                        <div
                            class="form-group row mb-3 weightRow {{ isset($product->category) ? ($product->category->is_weight == 0) ? 'd-none' : '' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">Weight</label>
                            <label class="col-sm-1 mt-2 text-center"><span class="req_star ">*</span>:</label>
                            <div class="col-sm-3">
                                @if(count($product->weight) > 0)
                                    @foreach($product->weight as $key => $value )
                                        <div class="input-group mb-3 inputFormRow"
                                             @if($key !== 0) style="width: 100% !important;" @endif>
                                            <input disabled style="margin-right: 10px; width: 100px !important;"
                                                   type="text" autocomplete="off"
                                                   class="form-control form_control disabled_input"
                                                   value="{{ $value->name?: ''}}">
                                        </div>
                                    @endforeach
                                @else
                                    <div
                                        class="input-group mb-3 add-weight-name weightRow {{ isset($product->category) ? ($product->category->is_weight == 0) ? 'd-none' : '' : '' }}">
                                        <input style="margin-right: 10px;" type="text" autocomplete="off"
                                               class="form-control form_control disabled_input"
                                               value="" {{ isset($product->category) ? ($product->category->is_weight == 1) ? 'required' : '' : '' }}>

                                    </div>
                                @endif


                            </div>

                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('productBrand') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">Product brand </label>
                            <label class="col-sm-1 mt-2 text-center"><span class="req_star ">*</span>:</label>
                            <div class="col-sm-6">
                                <input disabled type="text" autocomplete="off"
                                       class="form-control form_control disabled_input"
                                       name="brand_name"
                                       value="{{old('brand_name',$product->brand_name)}}">
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
                                <input disabled type="text" autocomplete="off"
                                       class="form-control form_control disabled_input"
                                       name="productPrice"
                                       value='{{ old("productPrice",$product->productPrice) }}'>
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
                                <input disabled type="text" autocomplete="off"
                                       class="form-control form_control disabled_input"
                                       name="title" value="{{old('title',$product->title)}}">
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
                            <textarea disabled type="text" autocomplete="off"
                                      class="form-control form_control disabled_input"
                                      name="description"> {{old('description',$product->description)}}</textarea>
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

                                </span>

                                </div>
                                @if ($errors->has('home_image'))
                                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('home_image') }}</strong>
                            </span>
                                @endif
                                <img style="height: 80px; margin-top: 10px" id="img-upload-one"
                                     @isset($product->home_image) src=' {{ asset("uploads/product/optimize/$product->home_image") }}' @endisset/>
                            </div>
                        </div>
                        <input hidden name="isApprove" value="authorize">
                    </div>
                    <div class="card-footer card_footer text-center">
                        <button type="submit" class="btn btn-md btn-success">Approved</button>
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

            @foreach($product->color as $key => $color)
            let preloaded_image_{{$key}} = [
                    @foreach($color->colorImage as $image)
                {
                    id:{{$image->id}},
                    src: '{{ asset("uploads/product/color/$image->name") }}',
                },
                @endforeach

            ];
            $(".input-images-{{\Str::slug($color->name)}}").imageUploader({
                imagesInputName: 'color_images_{{$key}}',
                label: 'max 5 color images add here',
                preloaded: preloaded_image_{{$key}},
                preloadedInputName: 'color_images_{{$key}}',
                extensions: ['.jpg', '.jpeg', '.png', '.gif', '.svg', '.JPEG', '.JPG', 'TIFF', '.GIF', '.PNG', '.SVG'],
                mimes: ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'],
                maxSize: 5 * 1024 * 1024,
            });
            for (var j = 0; j < Object.keys(preloaded_image_{{$key}}).length; j++) {
                console.log(preloaded_image_{{$key}}[j].src);
            }

            @endforeach

        });
    </script>


@endpush
