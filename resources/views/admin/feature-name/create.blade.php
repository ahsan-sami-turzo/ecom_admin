@extends('layouts.admin')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .custom-style{
            font-weight: 900 !important;
            display: block !important;
        }

    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <form method="post" action="{{ route('feature-name.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header card_header">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="card-title card_title"><i class="fab fa-gg-circle"></i> Add Feature Name</h4>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="{{ route('feature-name.index') }}"
                                   class="btn btn-dark btn-md waves-effect btn-label waves-light card_btn"><i
                                        class="fas fa-th label-icon"></i>All Feature Name</a>
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

                        <div class="form-group row mb-3 {{ $errors->has('display_products') ? ' has-error' : '' }}">
                            <label class="col-sm-4 col-form-label col_form_label text-left">Feature Name<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-4">
                                <select class ="form-control select2" id ="display_products" name="display_products">
                                    <option value="0">---display products section---</option>
                                        <option class="custom-style" value="7" style="font-weight: 900 !important; display: block !important; ">Feature Products</option>
                                        <option class="custom-style" value="5" style="font-weight: 900 !important; display: block !important; ">Slider Products</option>
                                        <option class="custom-style" value="3" style="font-weight: 900 !important; display: block !important; ">Selected Products</option>
                                        <option class="custom-style" value="2" style="font-weight: 900 !important; display: block !important; ">Special Products</option>
                                </select>
                                @if ($errors->has('display_products'))
                                    <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('display_products') }}</strong>
                                     </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3 name" >
                            <label class="col-sm-4 col-form-label col_form_label text-left">Name<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control form_control @error('name') is-invalid @enderror"
                                       name="name" value="{{old('name')}}">
                                {{--@if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif--}}
                                @error('name')
                                <div class="text-danger"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>
                        </div>
                       <div id="leftRight" class="d-none">
                           <div class="form-group row mb-3">
                               <label class="col-sm-4 col-form-label col_form_label text-left">Left Feature Name<span
                                       class="req_star">*</span>:</label>
                               <div class="col-sm-4">
                                   <input  type="text" class="leftRightInput form-control form_control @error('display_type') is-invalid @enderror"
                                          name="display_type[]" value="{{old('display_type')}}">
                                   {{--@if ($errors->has('title'))
                                       <span class="invalid-feedback" role="alert">
                                           <strong>{{ $errors->first('title') }}</strong>
                                       </span>
                                   @endif--}}
                                   @error('display_type')
                                   <div class="text-danger"><strong>{{ $message }}</strong></div>
                                   @enderror
                               </div>
                           </div>
                           <div class="form-group row mb-3">
                               <label class="col-sm-4 col-form-label col_form_label text-left">Right Feature Name<span
                                       class="req_star">*</span>:</label>
                               <div class="col-sm-4">
                                   <input type="text" class="leftRightInput form-control form_control @error('display_type') is-invalid @enderror"
                                          name="display_type[]" value="{{old('display_type')}}">
                                   {{--@if ($errors->has('title'))
                                       <span class="invalid-feedback" role="alert">
                                           <strong>{{ $errors->first('title') }}</strong>
                                       </span>
                                   @endif--}}
                                   @error('display_type')
                                   <div class="text-danger"><strong>{{ $message }}</strong></div>
                                   @enderror
                               </div>
                           </div>
                       </div>
                        <div id="displaySerial" class="form-group row mb-3 ">
                            <label class="col-sm-4 col-form-label col_form_label text-left">Serial<span class="req_star">*</span>:</label>
                            <div class="col-sm-4">
                                <input  type="text" class="displaySerial form-control form_control @error('display_serial') is-invalid @enderror"
                                       name="display_serial" value="{{old('display_serial')}}">
                                {{--@if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif--}}
                                @error('display_serial')
                                <div class="text-danger"><strong>{{ $message }}</strong></div>
                                @enderror
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
            $('.select2').select2();
            // if category add into product ,category can't create child

            $("#display_products").on('change', function () {
                let displayProducts = $(this).val();
                $("#leftRight").addClass('d-none');
                $(".leftRightInput").prop('disabled', true);
                $("#displaySerial").removeClass('d-none');
                $('.name').removeClass('d-none');
                if (displayProducts == 3 || displayProducts == 2) {
                    $("#leftRight").removeClass('d-none');
                    $('.name').addClass('d-none');
                    $(".leftRightInput").prop('disabled', false);
                }
                if (displayProducts == 7) {
                    $("#displaySerial").addClass('d-none');
                    $(".displaySerial").val(0);
                   // $("#displaySerial").removeClass('d-none');
                }

            });
        });
    </script>

@endpush
