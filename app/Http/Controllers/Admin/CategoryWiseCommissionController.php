<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Commission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryWiseCommissionController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $id = $request->category_id;
            $commission = Commission::where('category_id',$id)/*->isAllVendor()*/->firstOrFail();
            return response()->json(['success' => $commission]);
        } catch (\Exception $ex) {
            return response()->json(['success' => 'Is all vendor not found']);
        }
    }
}
