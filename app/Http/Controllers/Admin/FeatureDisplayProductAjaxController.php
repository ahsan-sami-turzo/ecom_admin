<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeatureName;
use Illuminate\Http\Request;


class FeatureDisplayProductAjaxController extends Controller
{
    public function index(Request $request)
    {

        try {
            $display = $request->display_products;
            $featureNames = FeatureName::where('display_products', $display)->get();
            return response()->json([
                'success' => json_decode($featureNames),
            ]);
        } catch (\Exception $exception) {
            return $exception;
        }
    }
}
