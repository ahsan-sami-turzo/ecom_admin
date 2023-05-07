@extends('layouts.admin')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <form method="post" action="{{route('category.update',$category->id)}}" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="card">
                    <div class="card-header card_header">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="card-title card_title"><i class="fab fa-gg-circle"></i> Submit
                                </h4>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="{{route('category.index')}}"
                                   class="btn btn-dark btn-md waves-effect btn-label waves-light card_btn"><i
                                        class="fas fa-th label-icon"></i>All Category</a>
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
                        <div class="form-group row mb-3 {{ $errors->has('category_name') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label text-left">Category Name<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control form_control" name="category_name"
                                       value="{{old('category_name',$category->category_name)}}">
                                @if ($errors->has('category_name'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('category_name') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3 {{ $errors->has('description') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label text-left">Description<span class="req_star">*</span><span class="text-left">:</span></label>
                            <div class="col-sm-7">
                                <input type="text" autocomplete="off" class="form-control form_control" name="description"
                                       value="{{old('description',$category->description )}}">
                                @if ($errors->has('description'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('parent_category_id') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label text-left">Parent category<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-7">
                                <select class ="form-control select2" id ="parentId" name="parent_category_id">
                                    <option value="0">---Select Parent category---</option>
                                    @foreach ($categories as $cate)
                                        <option value="{{ $cate->id}}" style="font-size: 12px; font-weight:bold !important;" {{ $cate->id == $category->parent_category_id ? 'selected' : '' }} ><?= str_repeat("&nbsp; ", $cate->level)?> {{  $cate->category_name}}</option>
                                        @if(count($cate->parentCategory))
                                            @include('admin.category.include.subcategory',['childs' => $cate->parentCategory,'category_parentID' =>$cate->id])
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('parent_category_id'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('parent_category_id') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label col_form_label">Has Color<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-1">
                                <input style="margin-top: 12px;" type="checkbox" id="isColor" name="is_color"
                                       value="1" {{ ($category->is_color == 1) ? 'checked' : '' }} >

                            </div>
                            <label class="col-sm-2 col-form-label col_form_label">Has Size<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-1">
                                <input style="margin-top: 12px;" type="checkbox" id="isSize" name="is_size"
                                       value="1" {{ ($category->is_size == 1) ? 'checked' : '' }}>

                            </div>
                            <label class="col-sm-2 col-form-label col_form_label">Has Weight<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-1">
                                <input style="margin-top: 12px;" type="checkbox" id="isWeight" name="is_weight"
                                       value="1" {{ ($category->is_weight == 1) ? 'checked' : '' }} >

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
        $(document).ready(function() {
            $('.select2').select2({
                selectionCssClass: 'my-class-section'
            });
            // if category add into product ,category can't create child
            $('#parentId').on('change', function () {
                let categoryId = $(this).val();
                // $("#isSize").attr('checked', false);
                $("#isSize").prop("checked", false);
                $.ajax({
                    method: "post",
                    url: '{{ route("is-product") }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        category_id: categoryId
                    },
                    success: function (response) {
                        if (response.success.id ) {
                            alert('already product added this category so you can not created child category');
                            $(this).val('');
                        }else {
                            $(this).val();
                        }
                    }
                });

                $.ajax({
                    method: "post",
                    url: '{{ route("is-variation") }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        category_id: categoryId
                    },
                    success: function (response) {
                        if (response.success.is_size == 1) {
                            $("#isSize").prop('checked', true);
                            $("#isSize").click(function () {
                                $("#isSize").prop('checked',true);;
                            });
                        }else{
                            $("#isSize").prop('checked', false);
                            $("#isSize").click(function () {
                                $("#isSize").attr('checked',false);;
                            });
                        }

                        if (response.success.is_weight == 1) {
                            $("#isWeight").prop('checked', true);
                            $("#isWeight").click(function () {
                                $("#isWeight").prop('checked',false);;
                            });
                        }else{
                            $("#isWeight").prop('checked', false);
                            $("#isWeight").click(function () {
                                $("#isWeight").attr('checked',false);;
                            });
                        }
                        if (response.success.is_weight == 1) {
                            $("#isColor").prop('checked', true);
                            $("#isColor").click(function () {
                                $("#isColor").prop('checked',false);;
                            });
                        }else{
                            $("#isColor").prop('checked', false);
                            $("#isColor").click(function () {
                                $("#isColor").attr('checked',false);;
                            });
                        }


                        if (response.success.id ) {
                            $(this).val('');
                        }else {
                            $(this).val();
                        }
                    }
                });


            });


        });
    </script>

@endpush
