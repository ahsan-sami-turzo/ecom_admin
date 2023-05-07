<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseRequest;
use App\Models\ColorInfo;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetails;
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
use function GuzzleHttp\Promise\all;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $purchases = Purchase::with('vendor')->orderBy('id', 'desc')->get();
        return view('admin.purchase.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $id = isset($_POST['vendor_id']);
        $users = User::where('user_type', 'vendor')->get();
        $products = Product::where('vendor_id', $id)->pluck('product_name', 'id');
        return view('admin.purchase.json_new_create', compact('users', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PurchaseRequest $request
     * @return Application|Redirector|RedirectResponse
     */
    public function store(PurchaseRequest $request)
    {
        $data = $request->all();

        DB::transaction(function () use ($request) {
            try {
                $purchase = Purchase::create([
                    'billNo' => $request->billNo,
                    'chalanNo' => $request->chalanNo,
                    'vat_registration' => $request->vat_registration,
                    'purchaseDate' => date('Y-m-d H:i:s', strtotime($request->purchaseDate)),
                    'totalQuantity' => $request->totalQuantity ?? 0,
                    'totalAmount' => $request->totalAmount ?? 0,
                    'createdBy' => auth()->id(),
                    'storedby' => auth()->id(),
                    'supplierId' => $request->vendor_id,
                    'createdDate' => date('Y-m-d H:i:s'),
                    'updatedDate' => date('Y-m-d H:i:s'),
                    'isConfirmed' => true,
                    'status' => 1,
                    'softDel' => 0,
                    'is_approved' => 0,

                ]);
                if (($request->purchase_details)) {

                    foreach (json_decode($request->purchase_details) as $key => $value) {
                        //dd($value->product_id);
                        $productEntry = DB::table('product_entry')
                            ->where('product_id', $value->product_id)
                            ->where('color_id', $value->color_id)
                            ->where('size_id', $value->size_id)
                            ->where('weight_id', $value->weight_id)->first();
                        // $sarry[] = $request->size_id[$key];
                        PurchaseDetails::create([
                            'billNo' => $request->billNo,
                            'purchaseId' => $purchase->id,
                            'productId' => $value->product_id,
                            'colorId' => $value->color_id,
                            'sizeId' => $value->size_id,
                            'weight_id' => $value->weight_id,
                            'quantity' => $value->productQuantity,
                            'price' => $value->productPrice,
                            'totalPrice' => $value->totalPrice,
                            'product_entry_id' => $productEntry->id,
                            'vendor_id' => $request->vendor_id,
                            'createdDate' => date('Y-m-d H:i:s'),
                            'updatedDate' => date('Y-m-d H:i:s',),
                            'status' => 1,
                        ]);
                    }
                }
            } catch (\Exception $exception) {
                DB::rollback();
                Session::flash('error', 'Unable to process request.Error:' . json_encode($exception->getFile(), true) . json_encode($exception->getLine(), true) . json_encode($exception->getMessage(), true));
                return redirect()->back();
            }
        });

        $msg = "Product purchase created";
        return redirect(route("purchase.index"))->with('success', $msg);

    }

    /**
     * Display the specified resource.
     *
     * @param Purchase $purchase
     * @return Application|Factory|View
     */
    public function show(Purchase $purchase)
    {

        $users = User::all();
        $purchase->with('purchaseDetails.product', 'purchaseDetails.size', 'purchaseDetails.color', 'purchaseDetails.weight')->where('id', $purchase->id)->get();
        return view('admin.purchase.show', compact('users', 'purchase'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Purchase $purchase
     * @return Application|Factory|View
     */
    public function edit(Purchase $purchase)
    {
        if ($purchase->is_approved == 1) {
            abort(403);
        }
        $products = $purchase->where('supplierId', $purchase->supplierId)->with('vendor.vendorProducts.weight', 'vendor.vendorProducts.color', 'vendor.vendorProducts.size', 'purchaseDetails')->first();
        $users = User::where('user_type', 'vendor')->get();
        $purchaseDetails = PurchaseDetails::where('purchaseId', $purchase->id)->get();

        return view('admin.purchase.json_new_edit', compact('users', 'purchase', 'products', 'purchaseDetails'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Purchase $purchase
     * @return Response
     */
    public function update(Request $request, Purchase $purchase)
    {

        if ($purchase->is_approved == 1) {
            abort(403);
        }
          $data = $request->all();
        // $request->purchase_details;
        DB::transaction(function () use ($request, $purchase) {
            try {
                $purchase->update([
                    'billNo' => $request->billNo,
                    'chalanNo' => $request->chalanNo,
                    'vat_registration' => $request->vat_registration,
                    'purchaseDate' => date('Y-m-d H:i:s', strtotime($request->purchaseDate)),
                    'totalQuantity' => $request->totalQuantity ?? 0,
                    'totalAmount' => $request->totalAmount ?? 0,
                    'createdBy' => auth()->id(),
                    'storedby' => auth()->id(),
                    'supplierId' => $request->vendor_id,
                    'createdDate' => date('Y-m-d H:i:s'),
                    'updatedDate' => date('Y-m-d H:i:s'),
                    'isConfirmed' => true,
                    'status' => 1,
                    'softDel' => 0,
                    'is_approved' => 0,

                ]);
                if (($request->purchase_details)) {
                    $purchaseDetails = PurchaseDetails::where('purchaseId', $purchase->id)->delete();
                    foreach (json_decode($request->purchase_details) as $key => $value) {
                        //dd($value->product_id);
                        $productEntry = DB::table('product_entry')
                            ->where('product_id', $value->product_id)
                            ->where('color_id', $value->color_id)
                            ->where('size_id', $value->size_id)
                            ->where('weight_id', $value->weight_id)->first();
                        // $sarry[] = $request->size_id[$key];

                        PurchaseDetails::create([
                            'billNo' => $request->billNo,
                            'purchaseId' => $purchase->id,
                            'productId' => $value->product_id,
                            'colorId' => $value->color_id,
                            'sizeId' => $value->size_id,
                            'weight_id' => $value->weight_id,
                            'quantity' => $value->productQuantity,
                            'price' => $value->productPrice,
                            'totalPrice' => $value->totalPrice,
                            'product_entry_id' => $productEntry->id,
                            'vendor_id' => $request->vendor_id,
                            'createdDate' => date('Y-m-d H:i:s'),
                            'updatedDate' => date('Y-m-d H:i:s',),
                            'status' => 1,
                        ]);
                    }
                }
            } catch (\Exception $exception) {
                DB::rollback();
                Session::flash('error', 'Unable to process request.Error:' . json_encode($exception->getFile(), true) . json_encode($exception->getLine(), true) . json_encode($exception->getMessage(), true));
                return redirect()->back();
            }
        });

        $msg = "Product purchase update";
        return redirect(route("purchase.index"))->with('success', $msg);
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
}
