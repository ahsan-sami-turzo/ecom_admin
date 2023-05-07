<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnDetails;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class VendorPurchaseReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $purchaseReturns = PurchaseReturn::where('supplierId',auth()->id())->orderBy('id','desc')->get();
        return view('admin.vendor.purchase-return.index',compact('purchaseReturns'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $user = User::where('id',auth()->id())->first();
        $products = Product::where('vendor_id', auth()->id())->where('isApprove','authorize')->get();
        $purchaseProducts = Purchase::all();
        $purchaseReturn = PurchaseReturn::where('supplierId', auth()->id())->orderBy('id', 'desc')->first();

        if (!empty($purchaseReturn)) {
            $lastNum = substr($purchaseReturn->billNo, -5);
            $billNumber = strtoupper(substr($user->name, 0, 3)) . '-' . substr(sprintf("%'.03d\n", $user->id), 0, 3) . '-' . sprintf("%'.05d\n", $lastNum + 1);
        } else {
            $billNumber = strtoupper(substr($user->name, 0, 3)) . '-' . substr(sprintf("%'.03d\n", $user->id), 0, 3) . '-' . sprintf("%'.05d\n", 1);
        }
        //return $billNumber;
        return view('admin.vendor.purchase-return.json_return_new_create_24',compact('user','purchaseProducts','billNumber','products'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        $data = $request->all();

        DB::transaction(function () use ($request, $data) {
            try {
                $purchaseReturn = PurchaseReturn::create([
                    'purchaseReturnBillNo' => $request->purchaseReturnBillNo,
                    'purchaseReturnDate' => $request->purchaseReturnDate,
                    'totalQuantity' => $request->totalQuantity ?? 0,
                    'totalAmount' => $request->totalAmount ?? 0,
                    'createdBy' => auth()->id(),
                    'supplierId' => auth()->id(),
                    'createdDate' => date('Y-m-d H:i:s'),
                    'updatedDate' => date('Y-m-d H:i:s'),
                    'isConfirmed' => 1,
                    'status' => 1,
                ]);

                if (($request->purchase_details)) {

                    foreach (json_decode($request->purchase_details) as $key => $value) {

                        $productEntry = DB::table('product_entry')
                            ->where('product_id', $value->product_id)
                            ->where('color_id', $value->color_id)
                            ->where('size_id', $value->size_id)
                            ->where('weight_id', $value->weight_id)->first();

                        $purchaseReturnDetails = PurchaseReturnDetails::create([
                            'purchaseReturnId' => $purchaseReturn->id,
                            'productId' => $productEntry->product_id,
                            'colorId' => $productEntry->color_id,
                            'sizeId' => $productEntry->size_id,
                            'weight_id' => $productEntry->weight_id,
                            'quantity' => $value->productQuantity,
                            'price' => $value->productPrice,
                            'product_entry_id' => $productEntry->id,
                            'vendor_id' => auth()->id(),
                            'createdDate' => date('Y-m-d H:i:s'),
                            'updatedDate' => date('Y-m-d H:i:s'),
                            'status' => 1,
                        ]);

                        Stock::create([
                            'vendorId' => auth()->id(),
                            'productId' => $productEntry->product_id,
                            'quantity' => '-' . $value->productQuantity,
                            'operation_type' => 'purchase_return',
                            'operation_id' => $purchaseReturn->id,
                            'operation_date' => $purchaseReturn->purchaseReturnDate,
                            'product_entry_id' => $productEntry->id,
                            'softDel' => 0,
                            'status' => 1,
                            'createdBy' => auth()->id(),
                        ]);

                    }
                }
            } catch (\Exception $exception) {
                DB::rollback();
                Session::flash('error', 'Unable to process request.Error:' . json_encode($exception->getFile(), true) . json_encode($exception->getLine(), true) . json_encode($exception->getMessage(), true));
                return redirect()->back();
            }
        });

        $msg = "Product purchase returned created";
        return redirect(route("purchase-returns.index"))->with('success', $msg);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
