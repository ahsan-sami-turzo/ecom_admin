@extends('layouts.admin')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <form method="post" action="{{ route('product-specification-details.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header card_header">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="card-title card_title"><i class="fab fa-gg-circle"></i> Add Specification Details</h4>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="{{ route('product-specification-details.index') }}"
                                   class="btn btn-dark btn-md waves-effect btn-label waves-light card_btn"><i
                                        class="fas fa-th label-icon"></i>All Specification Details</a>
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
                                <select class="form-control select2 text-left" id="categoryId" name="category_id">
                                    <option value="0">Select Parent Category </option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id}}"
                                                style="font-weight: 12px; font-weight:bold !important;"> {{  $category->category_name ?: ''}}</option>
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
                            <label class="col-sm-4 col-form-label col_form_label text-left">Specification Details Name<span
                                    class="req_star">*</span>:</label>
                            <div class="col-sm-5">
                                <select class="form-control tags" multiple  name="specification_details_name[]">

                                </select>
                                @if ($errors->has('specification_details_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('specification_details_name') }}</strong>
                                    </span>
                                @endif
                                @error('specification_details_name')
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

            $(".tags").select2({
                tags: true,
                tokenSeparators: [',', ' ']
            });

            $('#categoryId').on('change', function () {
                let categoryId = $(this).val();
                $(".tags").empty();
                $.ajax({
                    method: "post",
                    url: '{{route("speication-detail-name")}}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        category_id: categoryId
                    },
                    success: function (response) {
                        const details_name = JSON.parse(response.success.specification_details_name);
                        if(details_name.length > 0) {
                            var html_specification_details_names = ``;
                            $.each(details_name, function(index, value){
                                html_specification_details_names +=  `<option value="` + value + `" selected >` + value + `</option>`;
                            });
                            $('.tags').append(html_specification_details_names);

                        }

                    }
                });
            });
        });
    </script>
@endpush
