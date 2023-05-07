@extends('layouts.admin')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .custom-style{
            font-weight: 900 !important;
            display: block !important;
            color: #0a53be !important;
        }
        /*.my-class-section{*/
        /*    color: #000000 !important;*/
        /*    font-weight: 900 !important;*/
        /*}*/

    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <form method="post" action="{{route('user.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header card_header">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="card-title card_title"><i class="fab fa-gg-circle"></i> User Registration
                                </h4>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="{{route('user.index')}}"
                                   class="btn btn-dark btn-md waves-effect btn-label waves-light card_btn"><i
                                        class="fas fa-th label-icon"></i>All User</a>
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
                        <div class="form-group row mb-3 {{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label text-left">Name<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control form_control " name="name"
                                       value="{{old('name')}}">
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
<!--                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label col_form_label">Phone:</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control form_control" name="phone"
                                       value="">
                            </div>
                        </div>-->
                        <div class="form-group row mb-3 {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label text-left">Email<span class="req_star">*</span>:</label>
                            <div class="col-sm-7">
                                <input type="text" autocomplete="off" class="form-control form_control" name="email"
                                       value="{{old('email')}}">
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label text-left">Password<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-7">
                                <input type="password" autocomplete="off" class="form-control form_control"
                                       name="password" value="">
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label col_form_label text-left">Confirm-Password<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-7">
                                <input type="password" class="form-control form_control" id="password_confirmation"
                                       name="password_confirmation" value="">
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('roles') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label text-left">User Role<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-7">

                                <select class="form-control form_control select2" name="roles[]" multiple>
                                    @foreach ( $roles as $role => $value)
                                        <option value="{{ $role }}"> {{ $value }}</option>
                                    @endforeach

                                </select>
                                @if ($errors->has('roles'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('roles') }}</strong>
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
                        <button type="submit" class="btn btn-md btn-dark">REGISTRATION</button>
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

        });
    </script>

@endpush


