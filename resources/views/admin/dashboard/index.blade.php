@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header card_header">
                        <div class="row pb-3" style="border-bottom: 1px solid #eeeeee">
                            <div class="col-md-8">
                                <h4 class="card-title card_title"><i class="fab fa-gg-circle"></i> DASHBOARD  </h4>
                            </div>

                        </div>
                    <div class="row pt-3">
                        @role('admin')
                        <div class="col-md-3">
                            <div class="card" style="border: 1px solid #c08009">
                                <div class="card-body">
                                    <h5 class="card-title" style="color: rgba(77,76,76,0.92)">Vendor list</h5>
                                    <div class="pt-3">
                                        <i style="font-size: 36px; color: #c08009" class="bx bx-user-plus "></i>
                                        <span style="font-size:28px; float: right; color: #bdbdc0">{{ $userCounts }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="border: 1px solid rgba(41,148,6,0.76)">
                                <div class="card-body">
                                    <h5 class="card-title" style="color: rgba(77,76,76,0.92)">Total Products count</h5>
                                    <div class="pt-3">
                                        <i style="font-size: 36px; color: rgba(41,148,6,0.76)" class="bx bx-store "></i>
                                        <span style="font-size:28px; float: right; color: #bdbdc0">{{ $productCounts }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endrole
                        @role('vendor')
                        <div class="col-md-3">
                            <div class="card" style="border: 1px solid rgba(41,148,6,0.76)">
                                <div class="card-body">
                                    <h5 class="card-title" style="color: rgba(77,76,76,0.92)">Total Products count</h5>
                                    <div class="pt-3">
                                        <i style="font-size: 36px; color: rgba(41,148,6,0.76)" class="bx bx-store "></i>
                                        <span style="font-size:28px; float: right; color: #bdbdc0">{{ $vendorProducts }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endrole
                        <div class="col-md-3">
                            <div class="card" style="border: 1px solid #9d072b">
                                <div class="card-body">
                                    <h5 class="card-title" style="color: rgba(77,76,76,0.92)">Sale Today count</h5>
                                    <div class="pt-3">
                                        <i style="font-size: 36px; color: #9d072b" class="bx bx-dollar"></i>
                                        <span style="font-size:28px; float: right; color: #bdbdc0">300</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="border: 1px solid rgba(37,107,234,0.65)">
                                <div class="card-body">
                                    <h5 class="card-title" style="color: rgba(77,76,76,0.92)">Total Sale Amount</h5>
                                    <div class="pt-3">
                                        <i style="font-size: 36px; color: rgba(37,107,234,0.65)" class="bx bxs-dollar-circle "></i>
                                        <span style="font-size:28px; float: right; color: #bdbdc0">30</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="border: 1px solid #f309ea">
                                <div class="card-body">
                                    <h5 class="card-title" style="color: rgba(77,76,76,0.92)">Monthly Sale Amount</h5>
                                    <div class="pt-3">
                                        <i style="font-size: 36px; color: #f309ea" class="bx bx-dollar-circle "></i>
                                        <span style="font-size:28px; float: right; color: #bdbdc0">10</span>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                    </div>
            </div>
        </div>
    </div>
@endsection
