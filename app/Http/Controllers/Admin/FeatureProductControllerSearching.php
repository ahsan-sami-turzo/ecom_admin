<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeatureProduct;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;

class FeatureProductControllerSearching extends Controller
{
    public function index(Request $request)
    {
        try {
            $id = $request->vendor_id;
            $vendor = Vendor::where('vendor_id', $id)->pluck('product_category')->first();
            return response()->json([
                'success' => json_decode($vendor),
            ]);
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    public function categoryProducts(Request $request)
    {

        try {
            $id = $request->category_id;
            $products = Product::where('category_id', $id)->get();
            return response()->json([
                'success' => json_decode($products),
            ]);
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    public function featureNameProducts(Request $request)
    {
        try {
            $id = $request->feature_id;
            $products = FeatureProduct::where('feature_id', $id)->pluck('product_id')->first();
            return response()->json([
                'success' => json_decode($products),
            ]);
        } catch (\Exception $exception) {
            return $exception;
        }
    }
}
