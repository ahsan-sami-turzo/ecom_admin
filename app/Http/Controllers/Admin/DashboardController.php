<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {

        $users = User::where('user_type','vendor')->get()->count();
        $productsCounts = Product::orderBy('id','desc')->get()->count();
        $vendorProducts = Product::where('vendor_id',auth()->id())->orderBy('id','desc')->get()->count();
        //return view('layouts.admin');
        return view('admin.dashboard.index',[
            'userCounts' => $users,
            'productCounts' => $productsCounts,
            'vendorProducts' => $vendorProducts,

        ]);
    }
}
