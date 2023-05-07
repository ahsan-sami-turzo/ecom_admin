@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12">
            <form method="post" action="{{ route('weight-info.update',$weightInfo->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="card">
                    <div class="card-header card_header">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="card-title card_title"><i class="fab fa-gg-circle"></i> Add weight Info</h4>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="" class="btn btn-dark btn-md waves-effect btn-label waves-light card_btn"><i class="fas fa-th label-icon"></i>All weight Info</a>
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
                        <div class="form-group row mb-3">
                            <label class="col-sm-4 col-form-label col_form_label text-left">weight name<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control form_control @error('name') is-invalid @enderror"
                                       name="weight" value="{{old('weight',$weightInfo->weight)}}">
                                @if ($errors->has('weight'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('weight') }}</strong>
                                    </span>
                                @endif
                                @error('weight')
                                <div class="text-danger"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('weight_type_id') ? ' has-error' : '' }}">
                            <label class="col-sm-4 col-form-label col_form_label">weight Type Name<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-5">
                                <select class="form-control select2" id="parentId" name="weight_type_id">
                                    @foreach ($weightTypes as $weightType)
                                        <option value="{{ $weightType->id}}"
                                                style="font-weight: 12px; font-weight:bold !important;" {{ $weightType->id == $weightInfo->weight_type_id ? 'selected' : '' }} > {{  $weightType->name ?: ''}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('weight_type_id'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('weight_type_id') }}</strong>
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
