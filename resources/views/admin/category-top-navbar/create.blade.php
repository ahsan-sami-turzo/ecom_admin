@extends('layouts.admin')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <form method="post" action="{{route('category-top-navbar.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header card_header">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="card-title card_title"><i class="fab fa-gg-circle"></i> Add Category top navbar
                                </h4>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="{{route('category-top-navbar.index')}}"
                                   class="btn btn-dark btn-md waves-effect btn-label waves-light card_btn"><i
                                        class="fas fa-th label-icon"></i>All Category Top Navbar</a>
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
                       <div class="form-group row mb-3 {{ $errors->has('category_id') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label text-left">Parent Category Name<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-7">
                                <select class ="form-control select2" id ="parentId" name="category_id[]" multiple="multiple">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id}}" style="font-size: 12px; font-weight:bold !important;"> {{  $category->category_name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('category_id'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('category_id') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('effectiveDate') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label text-left">Effective Date<span class="req_star">*</span>:</label>
                            <div class="col-sm-7">
                                <input type="date" autocomplete="off" class="form-control form_control" name="effectiveDate"
                                       value="{{old('effectiveDate')}}">
                                @if ($errors->has('effectiveDate'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('effectiveDate') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>

<!--                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label col_form_label">Photo:</label>
                            <div class="col-sm-4">
                                <div class="input-group">
                        <span class="input-group-btn">
                            <span class="btn btn-default btn-file btnu_browse">
                                Browse… <input type="file" name="image" id="imgInp">
                            </span>
                        </span>
                                    <input type="text" class="form-control" readonly>
                                </div>
                                <img id="img-upload"/>
                            </div>
                        </div>-->
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
            $(".select2").select2({
                placeholder: "Select Parent Category "
            });
        });
    </script>
@endpush
