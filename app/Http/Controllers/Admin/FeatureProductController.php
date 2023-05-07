<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeatureNameRequest;
use App\Http\Requests\FeatureProductRequest;
use App\Models\Category;
use App\Models\FeatureName;
use App\Models\FeatureProduct;
use App\Models\Product;
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

class FeatureProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $featureProducts = FeatureProduct::with('featureName')->orderBy('id', 'asc')->get();
        foreach ($featureProducts as $featureProduct) {
            $productID = json_decode($featureProduct->product_id);
            $featureProduct->product = Product::whereIn('id', $productID)->get();
        }

        //return $featureProducts;
        return view('admin.feature-product.index', compact("featureProducts"));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $featureNames = FeatureName::orderBY('id', 'desc')->get();
        $products = Product::orderBY('id', 'desc')->get();
        $users = User::where('user_type', 'vendor')->orderBY('id', 'desc')->get();
        $categories = Category::where('parent_category_id', 0)->orderBY('id', 'asc')->get();
        return view('admin.feature-product.create', compact('featureNames', 'products', 'users', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FeatureProductRequest $request
     * @return RedirectResponse
     */
    public function store(FeatureProductRequest $request)
    {

        try {
            DB::transaction(function () use ($request) {
                $data = $request->all();
                $data['product_id'] = json_encode($request->product_id);
                //foreach (\request('product_id') as $key => $value) {
                FeatureProduct::create([
                    'display_products' => $request->display_products,
                    'feature_id' => $data['feature_id'],
                    'product_id' => $data['product_id'],
                    'status' => 1,
                ]);
                // }

            });

            $msg = "Feature product created";
            return redirect(route("feature-product.index"))->with('success', $msg);

        } catch (\Exception $exception) {
            Session::flash('error', 'Unable to process request.Error:' . json_encode($exception->getMessage(), true));
            return redirect()->back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param FeatureProduct $feature_product
     * @return Application|Factory|View
     */
    public function edit(FeatureProduct $feature_product)
    {

        $featureNames = FeatureName::orderBY('id', 'desc')->get();
        $products = Product::orderBY('id', 'desc')->get();
        $users = User::where('user_type', 'vendor')->orderBY('id', 'desc')->get();
        $categories = Category::where('parent_category_id', 0)->orderBY('id', 'asc')->get();
        return view('admin.feature-product.edit', compact('featureNames', 'products', 'users', 'categories', 'feature_product'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param FeatureProduct $feature_product
     * @return Application|Redirector|RedirectResponse
     */
    public function update(Request $request, FeatureProduct $feature_product)
    {
        try {
            DB::transaction(function () use ($request, $feature_product) {
                $data = $request->all();
                $data['product_id'] = json_encode($request->product_id);
                //foreach (\request('product_id') as $key => $value) {
                $feature_product->update([
                    'display_products' => $request->display_products,
                    'feature_id' => $data['feature_id'],
                    'product_id' => $data['product_id'],
                    'status' => 1,
                ]);
                // }

            });

            $msg = "Feature product updated";
            return redirect(route("feature-product.index"))->with('success', $msg);

        } catch (\Exception $exception) {
            Session::flash('error', 'Unable to process request.Error:' . json_encode($exception->getMessage(), true));
            return redirect()->back();
        }
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
