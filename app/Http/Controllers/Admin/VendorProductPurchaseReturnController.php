<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\PurchaseDetails;
use App\Models\User;
use Illuminate\Http\Request;

class VendorProductPurchaseReturnController extends Controller
{
    public function vendorPurchaseProduct(Request $request)
    {
        try {
            $id = $request->vendor_id;
            $product = PurchaseDetails::where('vendor_id',$id)->with('product')->get();
            return response()->json([
                'success' => json_decode($product),
            ]);
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    public function vendorPurchaseReturns(Request $request)
    {
        try {
            $id = $request->vendor_id;
            $vendorPurchasesReturn = User::where('id',$id)->with('purchasesReturn')->first();
            return response()->json([
                'success' => json_decode($vendorPurchasesReturn),
            ]);
        } catch (\Exception $exception) {
            return $exception;
        }
    }
}
