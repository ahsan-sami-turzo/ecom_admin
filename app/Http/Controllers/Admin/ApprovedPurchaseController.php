<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApprovedPurchaseController extends Controller
{
    public function index(Request $request)
    {

        $data = $request->all();
        $purchase = Purchase::where('id', $data['purchaseId'])->first();

        $purchase->update([
            'is_approved' => $data['is_approved'],
        ]);

        foreach ($purchase->purchaseDetails as $purchaseDetail) {
            Stock::create([
                'productId' => $purchaseDetail->productId,
                'quantity' => $purchaseDetail->quantity,
                'vendorId' => $purchase->supplierId,
                'product_entry_id' => $purchaseDetail->product_entry_id,
                'createdBy' => auth()->id(),
                'softDel' => 0,
                'status' => 1,
                'operation_type' => 'purchase',
                'operation_date' => $purchase->purchaseDate,
                'operation_id' => $purchase->id,


            ]);
        }
        $msg = 'Product purchase approved';
        if (auth()->user()->user_type == 'vendor') {
            return redirect(route("purchases.index"))->with('success', $msg);
        }else{
            return redirect(route("purchase.index"))->with('success', $msg);
        }


    }
}
