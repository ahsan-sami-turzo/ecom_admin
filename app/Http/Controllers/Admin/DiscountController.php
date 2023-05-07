<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DiscountRequest;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $discounts = Discount::orderBy('id', 'desc')->get();

        foreach ($discounts as $discount) {
            $vendorId = json_decode($discount->vendor_id);
            $discount->vendors = User::whereIn('id', $vendorId)->where('user_type', User::TYPE)->pluck('name');
        }

        foreach ($discounts as $discount) {
            $categoryID = json_decode($discount->category_id);
            $discount->categories = Category::whereIn('id', $categoryID)->pluck('category_name')->take(8);
        }

        foreach ($discounts as $discount) {
            $productID = json_decode($discount->product_id);
            $discount->products = Product::whereIn('id', $productID)->pluck('product_name')->take(8);
        }

        //return $discounts;
        return view('admin.discount.index', compact('discounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        $vendors = User::orderBy('id', 'desc')->where('user_type', User::TYPE)->get();
        $products = Product::orderBy('id', 'desc')->get();
        return view('admin.discount.create', compact('categories', 'vendors', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DiscountRequest $request
     *
     */
    public function store(DiscountRequest $request)
    {
        $data = $request->all();

        if (request('is_all_vendors')) {
            $data['vendor_id'] = User::where('user_type', User::TYPE)->orderBy('id', 'desc')->pluck('id');
            $data['is_all_vendors'] = 1;
        }

        if (request('is_all_categories')) {
            $data['category_id'] = Category::orderBy('id', 'desc')->pluck('id');
            $data['is_all_categories'] = 1;
        }

        if (request('is_all_products')) {
            $data['product_id'] = Product::orderBy('id', 'desc')->pluck('id');
            $data['is_all_products'] = 1;
        }

        if (request('product_id')) {
            $data['product_id'] = json_encode(request('product_id'));
        }

        if (request('category_id')) {
            $data['category_id'] = json_encode(request('category_id'));
        }

        if (request('vendor_id')) {
            $data['vendor_id'] = json_encode(request('vendor_id'));
        }

        Discount::create($data);

        $msg = "Discount created";
        return redirect(route("discounts.index"))->with('success', $msg);
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
     * @param Discount $discount
     * @return Application|Factory|View
     */
    public function edit(Discount $discount)
    {

        $categories = Category::orderBy('id', 'desc')->get();
        $vendors = User::where('user_type', User::TYPE)->orderBy('id', 'desc')->get();
        $products = Product::orderBy('id', 'desc')->get();

        return view('admin.discount.edit', compact('categories', 'vendors', 'products','discount'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Discount $discount
     * @return Application|RedirectResponse|Redirector
     */
    public function update(Request $request, Discount $discount)
    {
        $data = $request->all();
        if (request('is_all_vendors')) {
            $data['vendor_id'] = User::where('user_type', User::TYPE)->orderBy('id', 'desc')->pluck('id');
            $data['is_all_vendors'] = 1;
        }

        if (request('is_all_categories')) {
            $data['category_id'] = Category::orderBy('id', 'desc')->pluck('id');
            $data['is_all_categories'] = 1;
        }

        if (request('is_all_products')) {
            $data['product_id'] = Product::orderBy('id', 'desc')->pluck('id');
            $data['is_all_products'] = 1;
        }

        if (request('product_id')) {
            $data['product_id'] = json_encode(request('product_id'));
            $data['is_all_products'] = 0;
        }else{
            $data['product_id'] = [];
        }

        if (request('category_id')) {
            $data['category_id'] = json_encode(request('category_id'));
            $data['is_all_categories'] = 0;
        }else{
            $data['category_id'] = [];
        }

        if (request('vendor_id')) {
            $data['vendor_id'] = json_encode(request('vendor_id'));
            $data['is_all_vendors'] = 0;
        }else{
            $data['vendor_id'] = [];
        }

        if (request('percentage')) {
            $data['amount'] = 0;
        }
        if (request('amount')) {
            $data['percentage'] = 0;
        }
        //return $data;
        $discount->update($data);

        $msg = "Discount update";
        return redirect(route("discounts.index"))->with('success', $msg);
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
