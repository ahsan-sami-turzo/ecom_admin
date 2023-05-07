<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ColorInfo;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetails;
use App\Models\SizeType;
use App\Models\Vendor;
use App\Models\WeightType;
use Illuminate\Http\Request;

class VendorProductController extends Controller
{
    public function vendorProduct(Request $request)
    {
        try {
            $id = $request->vendor_id;
            $product = Product::where('vendor_id',$id)->where('isApprove','authorize')->pluck('product_name','id');
            return response()->json([
                'success' => json_decode($product),
            ]);
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    public function productColorName(Request $request)
    {
        try {
            $id = $request->product_id;
            $colorNames = ColorInfo::where('product_id',$id)->pluck('name','id');
            return response()->json([
                'success' => json_decode($colorNames),
            ]);
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    public function productSizeName(Request $request)
    {
        try {
            $id = $request->product_id;
            $sizeNames = SizeType::where('product_id',$id)->pluck('name','id');
            return response()->json([
                'success' => json_decode($sizeNames),
            ]);
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    public function productWeightName(Request $request)
    {
        try {
            $id = $request->product_id;
            $weightTypes = WeightType::where('product_id',$id)->pluck('name','id');
            return response()->json([
                'success' => json_decode($weightTypes),
            ]);
        } catch (\Exception $exception) {
            return $exception;
        }
    }


    public function vendorPurchases(Request $request)
    {

        try {
            $id = $request->vendor_id;
            $product = Purchase::where('supplierId', $id)->where('is_approved',1)->get();
            return response()->json([
                'success' => json_decode($product),
            ]);
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    public function vendorPurchaseProducts(Request $request)
    {

        try {
            $id = $request->bill_number;
            $product = Purchase::where('id',$id)->with('purchaseDetails.product','purchaseDetails.color','purchaseDetails.size','purchaseDetails.weight')->where('is_approved',1)->first();
            return response()->json([
                'success' => json_decode($product),
            ]);
        } catch (\Exception $exception) {
            return $exception;
        }
    }
}
