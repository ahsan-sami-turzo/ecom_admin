@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header card_header">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="card-title card_title"><i class="fab fa-gg-circle"></i> All discount campaign Information</h4>
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
                    <div class="row">
                        @foreach($discountCampaigns as $discountCampaign)
                        <div class="col-3">
                            <div class="card" style="border: 1px solid #efefef">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $discountCampaign->name ?: '' }}</h5>
                                    <p class="card-text">{{ \Illuminate\Support\Str::words($discountCampaign->description ?: '',10) }}</p>
                                    <h6 class="card-link"></h6>
                                    <div class="pb-3">
                                        <strong style="float: left" class="card-link">{{ $discountCampaign->campagin_discount_type == "percentage" ? $discountCampaign->campagin_discount_type : $discountCampaign->campagin_discount_type }}</strong>
                                        <strong style="float: right" class="card-link">{{ $discountCampaign->campagin_discount_type == "percentage" ? $discountCampaign->percentage . '%' : $discountCampaign->amount . 'tk' }}</strong>
                                    </div>
                                    <div class="pt-3">
                                        <div style="float: left; width: 45%" class="">
                                           <span class="font-weight-bold text-info"> From date</span>
                                            <p>{{ $discountCampaign->effective_from }}</p>
                                        </div>
                                        <div style="float: right;width: 45%" class="text-right">
                                            <span class="font-weight-bold text-pink"> To date</span>
                                            <p>{{ $discountCampaign->effective_to }}</p>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="text-center bg-info">
                                        <a data-id="{{ $discountCampaign->id }}" href='{{ route("campaign-offer.view",$discountCampaign->id) }}' style="display: block" class="pt-2 pb-2 text-white viewOffer">View Campaign</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        @endforeach
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

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {

            $('.viewOffer').on('click', function () {
                let id = $(this).data('id');
              //  alert(id);
            });


        });
    </script>

@endpush
