<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\VendorDiscountCampaignRequest;
use App\Models\Category;
use App\Models\DiscountCampaign;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorDiscountCampaign;
use Illuminate\Http\Request;

class VendorDiscountCampaignController extends Controller
{
    public function index()
    {
        $discountCampaigns = DiscountCampaign::orderBy('id', 'desc')->get();
        return view('admin.discount-campaign-offer.index', compact('discountCampaigns'));
    }

    public function create(DiscountCampaign $discountCampaign)
    {
        //return $discountCampaign;
        $vendor = Vendor::with('products')->where('vendor_id', auth()->id())->first();
        $vendor->categories = Category::whereIn('id', json_decode($vendor->product_category))->pluck('category_name', 'id');

        return view('admin.discount-campaign-offer.create', compact('discountCampaign', 'vendor'));

    }

    public function store(VendorDiscountCampaignRequest $request, DiscountCampaign $discountCampaign)
    {
        $data = $request->all();
        $data['category_id'] = $request->category_id[0];
        $vendor = Vendor::with('products')->where('vendor_id', auth()->id())->first();
        $productId = Product::where('vendor_id', auth()->id())->get()->pluck('id');

        if ($data['category_id'] == 'all_category') {
            $data['category_id'] = ($vendor->product_category);
            $data['product_id'] = json_encode($productId);
        } else {
            $data['category_id'] = json_encode($request->category_id);
            $data['product_id'] = json_encode($request->product_id);
        }

        $data['campaign_id'] = $discountCampaign->id;
        $data['vendor_id'] = auth()->id();

        VendorDiscountCampaign::create($data);
        return redirect(route('campaign-offer.index'))->with('success', 'your discount campaign accepted');

    }

    public function edit(DiscountCampaign $discountCampaign ,VendorDiscountCampaign $vendorDiscountCampaign)
    {
        $vendor = Vendor::with('products')->where('vendor_id', auth()->id())->first();
        $vendor->categories = Category::whereIn('id', json_decode($vendor->product_category))->pluck('category_name', 'id');

        return view('admin.discount-campaign-offer.edit', compact('discountCampaign', 'vendor','vendorDiscountCampaign'));
    }

    public function update(VendorDiscountCampaignRequest $request, DiscountCampaign $discountCampaign,VendorDiscountCampaign $vendorDiscountCampaign)
    {
        $data = $request->all();
        $data['category_id'] = $request->category_id[0];
        $vendor = Vendor::with('products')->where('vendor_id', auth()->id())->first();
        $productId = Product::where('vendor_id', auth()->id())->get()->pluck('id');

        if ($data['category_id'] == 'all_category') {
            $data['category_id'] = ($vendor->product_category);
            $data['product_id'] = json_encode($productId);
        } else {
            $data['category_id'] = json_encode($request->category_id);
            $data['product_id'] = json_encode($request->product_id);
        }

        $data['campaign_id'] = $discountCampaign->id;
        $data['vendor_id'] = auth()->id();

        $vendorDiscountCampaign->update($data);
        return redirect(route('vendor-campaign-list.all'))->with('success', 'Your discount campaign update accepted');

    }


    public function myDiscountCampaign()
    {
        $vendorDiscountCampaigns = VendorDiscountCampaign::with('discountCampaign')->where('vendor_id', auth()->id())->orderBy('id', 'desc')->get();

        foreach ($vendorDiscountCampaigns as $vendorDiscountCampaign) {
            $vendorDiscountCampaign->category =  Category::whereIn('id',json_decode($vendorDiscountCampaign->category_id))->get();
            $vendorDiscountCampaign->products =  Product::whereIn('id',json_decode($vendorDiscountCampaign->product_id))->get();
        }
       // return $vendorDiscountCampaigns;
        return view('admin.discount-campaign-offer.vendor-all-offer', compact('vendorDiscountCampaigns'));
    }

    public function categoriesProducts(Request $request)
    {
        try {
            $id = $request->category_id;
            if ($id == 'all_category') {
                $products = Product::orderBy('id', 'desc')->get()->pluck('product_name', 'id');
            } else {
                $products = Product::whereIn('category_id', $id)->get()->pluck('product_name', 'id');
            }
            return response()->json([
                'success' => json_decode($products),
            ]);
        } catch (\Exception $exception) {
            return $exception;
        }
    }


    public function requestDiscountCampaign()
    {
        $vendorDiscountCampaigns = VendorDiscountCampaign::with('discountCampaign')->orderBy('id', 'desc')->get();
        foreach ($vendorDiscountCampaigns as $vendorDiscountCampaign) {
            $vendorDiscountCampaign->category =  Category::whereIn('id',json_decode($vendorDiscountCampaign->category_id))->get();
            $vendorDiscountCampaign->products =  Product::whereIn('id',json_decode($vendorDiscountCampaign->product_id))->get();
        }

        return view('admin.discount-campaign.all',compact('vendorDiscountCampaigns'));

    }
}
