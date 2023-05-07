@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header card_header">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="card-title card_title"><i class="fab fa-gg-circle"></i> All Products</h4>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href='{{ route("product.create") }}'
                               class="btn btn-dark btn-md waves-effect btn-label waves-light card_btn"><i
                                    class="fas fa-plus-circle label-icon"></i>Add product </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-7">
                            @if(Session::has('success'))
                                <div class="alert alert-success alertsuccess" role="alert">
                                    <strong>Successfully !</strong> {{Session::get('success')}}
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
                    <table id="alltableinfo"
                           class="table table-bordered table-striped table-hover dt-responsive nowrap custom_table">
                        <thead class="thead-dark">
                        <tr>
                            <th>Product Name</th>
                            <th>Product Image</th>
{{--                            <th>Product Barcode</th>--}}
                            <th>Product Price</th>
                            <th>Product Stock</th>
                            <th>Product Category Name</th>
                            <th>Vendor Name</th>
                            <th>QC Status</th>
{{--                            <th>Status</th>--}}
                            <th>Approve Status</th>
                            <th>Manage</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $data)
                            <tr>
                                <td>{{ $data->product_name ?? '' }}</td>
                                <td><img src="{{ asset("uploads/product/optimize/$data->home_image") }}" alt=""></td>
{{--                                <td>@isset($data->code) <svg class="barcode" jsbarcode-format="CODE39"--}}
{{--                                         jsbarcode-value="{{$data->code}}"--}}
{{--                                         jsbarcode-textmargin="0"--}}
{{--                                         jsbarcode-fontoptions="bold"--}}
{{--                                         jsbarcode-height="50"--}}
{{--                                         jsbarcode-width="1"--}}
{{--                                    ></svg> @endisset</td>--}}
                                {{--                                <td>{{ $data->product_sku ?? '' }}</td>--}}
                                <td>{{ $data->productPrice ?? '' }}</td>
                                <td><label class="font-weight-bold">{{ $data->productStockSum() ?? '' }}</label></td>
                                <td>{{ $data->category->category_name ?? '' }}</td>
                                <td>{{ $data->vendor->name ?? '' }}</td>
                                <td>
                                    <label
                                        class="p-2 badge {{ $data->qc_status == 'yes' ? 'badge-success' : 'badge-danger' }}">{{ $data->qc_status  }}</label>
                                </td>
{{--                                <td>--}}
{{--                                    <label--}}
{{--                                        class="p-2 badge {{ $data->status == 'active' ? 'badge-success' : 'badge-danger' }}">{{ $data->status  }}</label>--}}
{{--                                </td>--}}
                                <td>
                                    <label
                                        class="p-2 badge {{ $data->isApprove == 'authorize' ? 'badge-success' : 'badge-danger' }}">{{ $data->isApprove  }}</label>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-dark btn-sm" type="button">Manage</button>
                                        <button type="button"
                                                class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split waves-effect btn-label waves-light card_btn"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="mdi mdi-chevron-down"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                               href="{{ route('product.show',$data->id) }}">View</a>
                                            @if($data->isApprove == "unauthorize")
                                            <a class="dropdown-item"
                                               href="{{ route('product.edit',$data->id) }}">Edit</a>
                                            <a class="dropdown-item" href="#" id="softDelete" title="delete"
                                               data-toggle="modal" data-target="#softDelModal"
                                               data-id="{{ $data->id }}">Delete</a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer card_footer">
                    <div class="btn-group mt-2" role="group">
                        <a href="#" class="btn btn-secondary">Print</a>
                        <a href="#" class="btn btn-dark">PDF</a>
                        <a href="#" class="btn btn-secondary">Excel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--softdelete modal start-->
    <div id="softDelModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action='{{ url("role/delete") }}'>
                @csrf
                <div class="modal-content">
                    <div class="modal-header modal_header">
                        <h5 class="modal-title mt-0" id="myModalLabel"><i class="fab fa-gg-circle"></i> Confirm Message
                        </h5>
                    </div>
                    <div class="modal-body modal_card">
                        Are you sure you want to delete?
                        <input type="hidden" id="modal_id" name="modal_id">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-md btn-dark waves-effect waves-light">Confirm</button>
                        <button type="button" class="btn btn-md btn-danger waves-effect" data-dismiss="modal">Close
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection

@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
           // alert('ok')
            JsBarcode(".barcode").init();
        });
    </script>
@endpush
