<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Discount;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $coupons = Coupon::orderBy('id', 'desc')->get();

        foreach ($coupons as $coupon) {
            $vendorId = json_decode($coupon->vendor_id);
            $coupon->vendors = User::whereIn('id', $vendorId)->where('user_type', User::TYPE)->pluck('name');
        }

        foreach ($coupons as $coupon) {
            $categoryID = json_decode($coupon->category_id);
            $coupon->categories = Category::whereIn('id', $categoryID)->pluck('category_name')->take(8);
        }

        foreach ($coupons as $coupon) {
            $productID = json_decode($coupon->product_id);
            $coupon->products = Product::whereIn('id', $productID)->pluck('product_name')->take(8);
        }
        //return $coupons;
        return view('admin.coupon.index', compact('coupons'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $categories =   Category::orderBy('id', 'desc')->get();
        $vendors    =   User::orderBy('id', 'desc')->where('user_type', User::TYPE)->get();
        $products   =   Product::orderBy('id', 'desc')->get();
        return view('admin.coupon.create', compact('categories', 'vendors', 'products'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(CouponRequest $request)
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

        Coupon::create($data);

        $msg = "Coupon created";
        return redirect(route("coupons.index"))->with('success', $msg);

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
     * @param Coupon $coupon
     * @return Application|Factory|View
     */

    public function edit(Coupon $coupon)
    {
        $categories = Category::orderBy('id', 'desc')->get();
        $vendors = User::where('user_type', User::TYPE)->orderBy('id', 'desc')->get();
        $products = Product::orderBy('id', 'desc')->get();
     
        return view('admin.coupon.edit', compact('categories', 'vendors', 'products','coupon'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Coupon $coupon
     * @return Application|Redirector|RedirectResponse
     */

    public function update(CouponRequest $request, Coupon $coupon)
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
        }else{
            $data['product_id'] = [];
        }

        if (request('category_id')) {
            $data['category_id'] = json_encode(request('category_id'));
        }else{
            $data['category_id'] = [];
        }

        if (request('vendor_id')) {
            $data['vendor_id'] = json_encode(request('vendor_id'));
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
        $coupon->update($data);

        $msg = "Coupon update";
        return redirect(route("coupons.index"))->with('success', $msg);

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
