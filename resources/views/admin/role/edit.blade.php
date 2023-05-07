@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12">
            <form method="post" action="{{ route('roles.update',$role->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="card">
                    <div class="card-header card_header">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="card-title card_title"><i class="fab fa-gg-circle"></i> Add Role</h4>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="" class="btn btn-dark btn-md waves-effect btn-label waves-light card_btn"><i class="fas fa-th label-icon"></i>All Roles</a>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-7">
                                {{-- @if(Session::has('success'))
                                   <div class="alert alert-success alertsuccess" role="alert">
                                      <strong>Success!</strong> {{Session::get('success')}}
                                   </div>
                                 @endif
                                 @if(Session::has('error'))
                                   <div class="alert alert-danger alerterror" role="alert">
                                      <strong>Opps!</strong> {{Session::get('error')}}
                                   </div>
                                 @endif--}}
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label col_form_label text-left">Role name<span class="req_star">*</span>: </label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control form_control @error('name') is-invalid @enderror" name="name" value="{{ $role->name }}">
                                {{--@if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif--}}
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('permission') ? ' has-error' : '' }}">
                            <label class="col-sm-3 col-form-label col_form_label">Permission Name<span class="req_star">*</span>:</label>
                            <div class="col-sm-7">

                                @foreach($permissions as $value)
                                    <input style="margin-right: 5px" name="permission[]" value="{{ $value->id }}" type="checkbox" {{ in_array($value->id, $rolePermissions) ? 'checked' : ''}} >{{ $value->name ?:'' }} <br>
                                @endforeach

                                @if ($errors->has('permission'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('permission') }}</strong>
                        </span>
                                @endif
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
