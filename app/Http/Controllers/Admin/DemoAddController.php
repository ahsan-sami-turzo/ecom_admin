<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DemoAddController extends Controller
{
    public function index()
    {
        $id = isset($_POST['vendor_id']);
        $users = User::where('user_type','vendor')->get();
        $products = Product::where('vendor_id',$id)->pluck('product_name','id');
        return view('admin.banner.new_create',compact('users','products'));

    }
}
