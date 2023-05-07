<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\Stock;
use Illuminate\Http\Request;

class VendorApprovedPurchaseController extends Controller
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
                'productId' => $purchaseDetail->purchaseId,
                'quantity' => $purchaseDetail->quantity,
                'vendorId' => auth()->id(),
                'purchase_id' => $purchase->id,
                'product_entry_id' => $purchaseDetail->product_entry_id,
                'createdBy' => auth()->id(),
                'softDel' => 0,
                'status' => 1,
            ]);
        }
        $msg = 'Product purchase approved';
        return redirect(route("purchases.index"))->with('success', $msg);

    }
}
