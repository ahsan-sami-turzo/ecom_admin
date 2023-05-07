<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Country;
use App\Models\Language;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorListController extends Controller
{
    public function active()
    {
        $vendors = User::where('user_type', User::TYPE)->where('status', User::APPROVED)->get();
        return view('admin.vendor.index', compact('vendors'));
    }

    public function pending()
    {
        $vendors = User::where('status', User::PENDING_INFO_ENTRY)->where('user_type',User::TYPE)->get();
        return view('admin.vendor.pending', compact('vendors'));
    }

    public function show($vendor)
    {
        $vendor = User::where('id', $vendor)->where('status', User::PENDING_INFO_ENTRY)->with('vendorProfile')->first();
        $vendorImage = isset($vendor->vendorProfile) ? $vendor->vendorProfile->vendorImage : '' ;

        $brandImage = isset($vendor->vendorProfile) ? $vendor->vendorProfile->brandImage : '';
        $logoImage = isset($vendor->vendorProfile) ? $vendor->vendorProfile->logo : '';
        $coverImage = isset($vendor->vendorProfile) ? $vendor->vendorProfile->cover_photo : '';
        $countries = Country::pluck('name', 'id');
        $languages = Language::pluck('name', 'id');
        $categories = Category::where('parent_category_id', 0)->get();

        return view('admin.vendor.show', compact('vendor', 'countries', 'languages', 'categories', 'vendorImage', 'brandImage', 'logoImage', 'coverImage'));
    }

    public function approveStatusStore(Request $request)
    {
        $data = $request->all();
        $user = User::find($data['id']);
       // return $user;
       // $data['status'] = User::APPROVED;
      //  $data['user_type'] = User::TYPE;
        $user->status = User::APPROVED;
        $user->user_type = User::TYPE;
        $user->save();

        DB::table('model_has_roles')->where('model_id',$data['id'])->delete();

        $user->assignRole(['vendor']);
        return redirect(route('vendor.active.list'))->with('success', 'Vendor profile approved successfully');

    }
}
