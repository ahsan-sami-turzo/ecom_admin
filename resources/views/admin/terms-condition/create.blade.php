@extends('layouts.admin')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <form method="post" action="{{ route('terms.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header card_header">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="card-title card_title"><i class="fab fa-gg-circle"></i> Add terms and conditions</h4>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="{{ route('terms.index') }}"
                                   class="btn btn-dark btn-md waves-effect btn-label waves-light card_btn"><i
                                        class="fas fa-th label-icon"></i>All terms and conditions</a>
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
                            <label class="col-sm-4 col-form-label col_form_label">terms and conditions name<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-5">
                                <textarea style="height: 200px" type="text" class="form-control form_control @error('terms_and_conditions') is-invalid @enderror"
                                       name="terms_and_conditions" >{{old('terms_and_conditions')}}</textarea>

                                @error('terms_and_conditions')
                                <div class="text-danger"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('condition_type_id') ? ' has-error' : '' }}">
                            <label class="col-sm-4 col-form-label col_form_label">Condition type name<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-5">
                                <select class="form-control select2" id="parentId" name="condition_type_id">
                                    @foreach ($conditionTypes as $conditionType)
                                        <option value=""></option>
                                        <option value="{{ $conditionType->id}}"
                                                style="font-weight: 12px; font-weight:bold !important;"> {{  $conditionType->name ?: ''}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('condition_type_id'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('condition_type_id') }}</strong>
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
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $(".select2").select2({
                placeholder: "Select condition type"
            });
        });
    </script>
@endpush
