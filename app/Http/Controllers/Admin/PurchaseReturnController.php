<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductEntry;
use App\Models\Purchase;
use App\Models\PurchaseDetails;
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

class PurchaseReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {

        $purchaseReturns = PurchaseReturn::with('purchase')->orderBy('id', 'desc')->get();
        return view('admin.purchase-return.index', compact('purchaseReturns'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $users = User::where('user_type', 'vendor')->get();
        $purchaseProducts = Purchase::all();
        // return view('admin.purchase-return.create', compact('users', 'purchaseProducts'));

        return view('admin.purchase-return.json_return_new_create_24', compact('users', 'purchaseProducts'));

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
                            'vendor_id' => $request->vendor_id,
                            'createdDate' => date('Y-m-d H:i:s'),
                            'updatedDate' => date('Y-m-d H:i:s'),
                            'status' => 1,
                        ]);

                        Stock::create([
                            'vendorId' => $request->vendor_id,
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
        return redirect(route("purchase-return.index"))->with('success', $msg);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
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
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function get_purchase_quantity(Request $request)
    {
        try {
            $productId = $request->product_id;
            $colorId = $request->color_id;
            $sizeId = $request->size_id;
            $weightId = $request->weight_id;
            $purchaseId = $request->purchaseId;
            $purchaseReturnDetails = PurchaseDetails::where('productId', $productId)
                ->where('colorId', $colorId)
                ->where('sizeId', $sizeId)
                ->where('weight_id', $weightId)
                ->where('purchaseId', $purchaseId)
                ->sum('quantity');

            return response()->json([
                'success' => json_decode($purchaseReturnDetails),
            ]);
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    public function get_purchase_stock(Request $request)
    {
        try {
            $productId = $request->product_id;
            $colorId = $request->color_id;
            $sizeId = $request->size_id;
            $weightId = $request->weight_id;
            //$productEntryId = $request->product_entry_id;
            $productEntry = ProductEntry::where('product_id', $productId)
                ->where('color_id', $colorId)
                ->where('size_id', $sizeId)
                ->where('weight_id', $weightId)
                ->first();

            if (isset($productEntry->id)) {
                $stock = Stock::where('productId', $productId)->where('product_entry_id', $productEntry->id)->sum('quantity');
                $totalPrice = PurchaseDetails::where('product_entry_id', $productEntry->id)->latest('id')->first('price');
            }


            return response()->json([
                    'success' => json_decode($stock) ?? 0,
                    'successPrice' => json_decode($totalPrice)
                ]);

        } catch (\Exception $exception) {
            return $exception;
        }
    }

    public function productsPurchaseInfo()
    {

    }
}
