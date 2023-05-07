@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header card_header">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="card-title card_title"><i class="fab fa-gg-circle"></i> All Discounts Information</h4>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('discounts.create') }}"
                               class="btn btn-dark btn-md waves-effect btn-label waves-light card_btn"><i
                                    class="fas fa-plus-circle label-icon"></i>Add Discount</a>
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
                    <table id="alltableinfo"
                           class="table table-bordered table-striped table-hover dt-responsive nowrap custom_table">
                        <thead class="thead-dark">
                        <tr>
                            <th>Vendors Name</th>
                            <th>Categories Name</th>
                            <th>Products Name</th>
                            <th>Percentage</th>
                            <th>Amount</th>
                            <th>Date From</th>
                            <th>Date To</th>
                            <th>Status</th>
                            <th>Manage</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($discounts as $discount)
                            <tr>
                                <td>
                                    <ul>
                                        @if($discount->is_all_vendors == 0)
                                            @foreach($discount->vendors as $vendor)
                                                <li>{{ $vendor }}</li>
                                            @endforeach
                                        @else
                                            <button class="btn btn-success btn-sm" type="button">All vendors</button>
                                        @endif
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        @if($discount->	is_all_categories == 0)
                                            @foreach($discount->categories as $category)
                                                <li>{{ $category }}</li>
                                            @endforeach
                                        @else
                                            <button class="btn btn-success btn-sm" type="button">All category</button>
                                        @endif
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        @if($discount->is_all_products == 0)
                                            @foreach($discount->products as $product)
                                                <li>{{ $product }}</li>
                                            @endforeach
                                        @else
                                            <button class="btn btn-success btn-sm" type="button">All product</button>
                                        @endif
                                    </ul>
                                </td>
                                <td>{{ $discount->percentage ?: '' }}</td>
                                <td>{{ $discount->amount ?: '' }}</td>
                                <td>{{ $discount->effective_from ?: '' }}</td>
                                <td>{{ $discount->effective_to ?: '' }}</td>
                                <td>{{ $discount->status ?: '' }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-dark btn-sm" type="button">Manage</button>
                                        <button type="button"
                                                class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split waves-effect btn-label waves-light card_btn"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="mdi mdi-chevron-down"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="">Publish</a>
                                            <a class="dropdown-item" href=''>Change Permission</a>
                                            <a class="dropdown-item" href='{{route("discounts.edit",$discount->id)}}'>Edit</a>
                                            <a class="dropdown-item" href="#" id="softDelete" title="delete"
                                               data-toggle="modal" data-target="#softDelModal"
                                               data-id="{{$discount->id}}">Delete</a>
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
            <form method="post" action="{{url('dashboard/user/softdelete')}}">
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
