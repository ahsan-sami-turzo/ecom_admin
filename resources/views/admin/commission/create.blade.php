@extends('layouts.admin')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <form method="post" action="{{ route('commission.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header card_header">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="card-title card_title"><i class="fab fa-gg-circle"></i> Add Commission</h4>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="{{ route('commission.index') }}"
                                   class="btn btn-dark btn-md waves-effect btn-label waves-light card_btn"><i
                                        class="fas fa-th label-icon"></i>All Commissions</a>
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
                            <label class="col-sm-4 col-form-label col_form_label text-left">Category Name<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-5">
                                <select class="form-control select2"  id="categoryId" name="category_id">
                                    <option value="">Select Parent Category </option>
                                    @foreach ($categories as $category)
                                        <option class="custom-style" value="{{ $category->id}}" style="font-weight: 900 !important; display: block !important; "><?= str_repeat("&nbsp; ", $category->level)?> {{  $category->category_name}}</option>
                                        @if(count($category->parentCategory))
                                            @include('admin.category.include.subcategory',['childs' => $category->parentCategory,'commision' => 46])
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

                        <div class="form-group row mb-3">
                            <label class="col-sm-4 col-form-label col_form_label text-left">Vendor Name<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-5">
                                <select class="form-control vendors" multiple  name="vendor_id[]">
                                    @foreach ($users as $key => $value )
                                        <option value="{{ $key }}"
                                                style="font-weight: 12px; font-weight:bold !important;"> {{  $value ?: ''}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('vendor_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('vendor_id') }}</strong>
                                    </span>
                                @endif
                                @error('vendor_id')
                                <div class="text-danger"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>
                            <div class="col-sm-3">
                                <input id="allVendors" type="checkbox" style="margin-top:10px" name="is_all_vendor" value="true">
                                <span style="font-size: 14px"> all vendors</span>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label class="col-sm-4 col-form-label col_form_label text-left">Percentage <span class="req_star">*</span>:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control form_control @error('percent') is-invalid @enderror" name="percent" value="{{old('percent')}}">
                                {{--@if ($errors->has('percent'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('percent') }}</strong>
                                    </span>
                                @endif--}}
                                @error('percent')
                                <div class="text-danger"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label class="col-sm-4 col-form-label col_form_label text-left">Effective date <span class="req_star">*</span>:</label>
                            <div class="col-sm-5">
                                <input type="date" class="form-control form_control @error('effectived_date') is-invalid @enderror" name="effectived_date" value="{{old('effectived_date')}}">
                                {{--@if ($errors->has('percent'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('percent') }}</strong>
                                    </span>
                                @endif--}}
                                @error('percent')
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
        $(document).ready(function () {
            $(".select2").select2({
                placeholder: "Select Parent Category"
            });

            $(".vendors").select2({
                tags: true,
                tokenSeparators: [',', ' ']
            });
            // all vendors checked
            $('#allVendors').on('change', function () {
                if ($(this).is(':checked')) {
                    // Do something...
                    $('.vendors').prop( "disabled", true );
                }else {
                    $('.vendors').prop( "disabled", false );
                }

            });


            $('#categoryId').on('change', function () {
                let categoryId = $(this).val();
                $(".tags").empty();
                $('#allVendors').prop('checked',false);
                $.ajax({
                    method: "post",
                    url: "{{ route('commission-isall-vendor') }}",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        category_id: categoryId
                    },
                    success: function (response) {
                        let data = response.success.is_all_vendor;
                         if (data) {
                             alert('Already vendors added this category')
                             let valData = response.success.category_id;
                             $('#categoryId').find('[value="' + valData + '"]').remove();
                            $('.vendors').prop( "disabled", false );
                            $('#allVendors').prop('checked',false);
                        }else {
                            $('.vendors').prop( "disabled", false );
                        }



                    }
                });
            });
        });
    </script>
@endpush
