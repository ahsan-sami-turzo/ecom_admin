<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VendorDiscountCampaignRequest;
use App\Models\Category;
use App\Models\DiscountCampaign;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\VendorDiscountCampaign;
use Illuminate\Http\Request;

class RequestVendorDiscountCampaignController extends Controller
{
    public function view(DiscountCampaign $discountCampaign ,VendorDiscountCampaign $vendorDiscountCampaign)
    {
        $vendor = VendorDiscountCampaign::with('ven')->where('vendor_id', $vendorDiscountCampaign->vendor_id)->where('campaign_id',$discountCampaign->id)->first();
        $vendor->categories = Category::whereIn('id', json_decode($vendor->category_id))->pluck('category_name', 'id');
        $vendor->products = Product::whereIn('id', json_decode($vendor->product_id))->pluck('product_name', 'id');

        return view('admin.discount-campaign-offer.view', compact('discountCampaign', 'vendor','vendorDiscountCampaign'));
    }

    public function accept(Request $request, DiscountCampaign $discountCampaign,VendorDiscountCampaign $vendorDiscountCampaign)
    {

        $vendorDiscountCampaign->update([
            'status' => 'active'
        ]);
        return redirect(route('all-vendor-campaign.all'))->with('success', 'Vendor discount campaign accepted');

    }


}
