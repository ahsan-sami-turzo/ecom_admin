<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductAuthorizeController extends Controller
{
    public function authorizeUpdate(Request $request, Product $product)
    {
         $product->update([
            'isApprove' => $request->isApprove,
        ]);

        $msg = "Product authorize updated";
        return redirect()->back()->with('success',$msg);
    }
}
