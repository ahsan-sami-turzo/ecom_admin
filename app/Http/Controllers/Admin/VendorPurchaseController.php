<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\Request;

class VendorPurchaseController extends Controller
{
    public function vendorPurchaseProduct(Request $request)
    {
        try {
            $id = $request->vendor_id;
            $vendorPurchases = User::where('id',$id)->with('purchases')->first();
            return response()->json([
                'success' => json_decode($vendorPurchases),
            ]);
        } catch (\Exception $exception) {
            return $exception;
        }
    }
}
