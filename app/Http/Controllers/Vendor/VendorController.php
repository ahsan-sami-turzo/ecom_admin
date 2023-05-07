<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Requests\VendorPersonalRequest;
use App\Models\Country;
use App\Models\Language;
use App\Models\User;
use Illuminate\Support\Str;

use Image;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function create()
    {

        if (auth()->user()->user_type == null) {
            $vendor = User::where('id', auth()->id())->first();
            $ddd = [];
        }else{
            $vendor = Vendor::where('vendor_id', auth()->id())->first();
            $ddd[] = json_decode($vendor->product_category);
        }


        // dd(in_array(34,json_decode($vendor->product_category)));
        // $vendor->cates = Category::whereIn('id', json_decode($vendor->product_category))->pluck('category_name','id');


        $countries = Country::pluck('name', 'id');

        $languages = Language::pluck('name', 'id');
        $categories = Category::orderBy('id', 'asc')->get();
        return view('admin.vendor.create', compact('categories', 'vendor', 'countries', 'languages', 'ddd'));
    }

    public function store(VendorPersonalRequest $request)
    {

        $data = $request->all();
        $vendor = Vendor::where('id', $request->id)->first();

        $vendorImageName = Str::slug(auth()->user()->name) . '-vendor-image-' . hexdec(uniqid());
        $vendorBrandName = Str::slug(auth()->user()->name) . '-brand-image-' . hexdec(uniqid());
        $vendorLogoName = Str::slug(auth()->user()->name) . '-logo-image-' . hexdec(uniqid());
        $vendorCoverName = Str::slug(auth()->user()->name) . '-cover-image-' . hexdec(uniqid());

        if (isset($vendor)) {
            if ($request->hasFile('vendorImage')) {
                $vendor->vendorImage = doUploadImage("$vendorImageName", "uploads/vendor/vendor-image", "$request->vendorImage", "uploads/vendor/vendor-image/optimize", '', 100, 'png');
            }
            if ($request->hasFile('brandImage')) {
                $vendor->brandImage = doUploadImage("$vendorBrandName", "uploads/vendor/brand-image", "$request->brandImage", "uploads/vendor/brand-image/optimize", '', 100, 'png');
            }
            if ($request->hasFile('logo')) {
                $vendor->logo = doUploadImage("$vendorLogoName", "uploads/vendor/logo", "$request->logo", "uploads/vendor/logo/optimize", '', 100, 'png');
            }
            if ($request->hasFile('cover_photo')) {
                $vendor->cover_photo = doUploadImage("$vendorCoverName", "uploads/vendor/cover", "$request->cover_photo", "uploads/vendor/cover/optimize", '', 100, 'png');
            }

            $vendor->name = $request->name;
            $vendor->slug = Str::slug("$request->name");
            $vendor->email = $request->email;
            $vendor->phone = $request->phone;
            $vendor->nid = $request->nid;
            $vendor->dob = $request->dob;
            $vendor->present_address = $request->present_address;
            $vendor->shop_language = $request->shop_language;
            $vendor->shop_country = $request->shop_country;
            $vendor->shop_currency = $request->shop_currency;
            $vendor->shop_name = $request->shop_name;
            $vendor->trade_licence = $request->trade_licence;
            $vendor->business_start_date = $request->business_start_date;
            $vendor->tin = $request->tin;
            $vendor->vendor_id = auth()->id();
            $vendor->product_category = json_encode($request->product_category);
            $vendor->status = 1;
            $vendor->vat_registration = $request->vat_registration;
            $vendor->step_completed = 'approved';
            $vendor->softDel = 1;
            $vendor->update();

        } else {

            if ($request->hasFile('vendorImage')) {
                $data['vendorImage'] = doUploadImage("$vendorImageName", "uploads/vendor/vendor-image", "$request->vendorImage", "uploads/vendor/vendor-image/optimize", '', 100, 'png');
            }
            if ($request->hasFile('brandImage')) {
                $data['brandImage'] = doUploadImage("$vendorBrandName", "uploads/vendor/brand-image", "$request->brandImage", "uploads/vendor/brand-image/optimize", '', 100, 'png');

            }
            if ($request->hasFile('logo')) {
                $data['logo'] = doUploadImage("$vendorLogoName", "uploads/vendor/logo", "$request->logo", "uploads/vendor/logo/optimize", '', 100, 'png');
            }
            if ($request->hasFile('cover_photo')) {
                $data['cover_photo'] = doUploadImage("$vendorCoverName", "uploads/vendor/cover", "$request->cover_photo", "uploads/vendor/cover/optimize", '', 100, 'png');
            }

            $data['vendor_id'] = auth()->id();
            $data['vat_registration'] = $request->vat_registration;
            $data['product_category'] = json_encode($request->product_category);
            $data['status'] = 1;
            $data['step_completed'] = 'approved';
            $data['softDel'] = 1;

            Vendor::create($data);
            $user = User::find(auth()->id());
            $user->phone = $request->phone;
            $user->user_type = User::TYPE;
            $user->save();
        }

        return redirect(route('vendor-information'))->with('success', 'your profile updated successfully');


    }


}







