<?php

namespace App\Http\Controllers\Amin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductSpecificationDetailsRequest;
use App\Models\Category;
use App\Models\ProductSpecificationDetails;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class ProductSpecificationDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $productSpecificationDetails = ProductSpecificationDetails::with('category')->orderBy('id', 'asc')->get();
        return view('admin.product-specifications-details.index', compact('productSpecificationDetails'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.product-specifications-details.create', compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductSpecificationDetailsRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(ProductSpecificationDetailsRequest $request)
    {
        $data = $this->getData($request);

        $productDetailsName = ProductSpecificationDetails::where('category_id', $data['category_id'])->first();
        if (isset($productDetailsName)) {
            $productDetailsName->update($data);
        } else {
            ProductSpecificationDetails::create($data);
        }
        $msg = "Product specification details created";
        return redirect(route("product-specification-details.index"))->with('success', $msg);

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
     * @param ProductSpecificationDetails $product_specification_detail
     * @return Application|Factory|View
     */
    public function edit(ProductSpecificationDetails $product_specification_detail)
    {

        $categories = Category::all();
        return view('admin.product-specifications-details.edit', compact('categories', 'product_specification_detail'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductSpecificationDetailsRequest $request
     * @param ProductSpecificationDetails $product_specification_detail
     * @return Application|Redirector|RedirectResponse
     */
    public function update(ProductSpecificationDetailsRequest $request, ProductSpecificationDetails $product_specification_detail)
    {
        $data = $this->getData($request);

        $product_specification_detail->update($data);
        $msg = "Product specification details updated";
        return redirect(route("product-specification-details.index"))->with('success', $msg);

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

    /**
     * @param ProductSpecificationDetailsRequest $request
     * @return array
     */
    public function getData(Request $request): array
    {
        $data = $request->all();
        $data['specification_details_name'] = json_encode($request->specification_details_name);
        $data['status'] = 'active';
        $data['softDel'] = 0;
        $data['entry_by'] = auth()->id();
        $data['user_id'] = auth()->id();
        $data['entry_user_type'] = json_encode(auth()->user()->getRoleNames());
        return $data;
    }

    public function getName(Request $request): JsonResponse
    {
        try {
            $id = $request->category_id;
            $specificationDetailNames = ProductSpecificationDetails::where('category_id', $id)->firstOrFail();
            return response()->json(['success' => $specificationDetailNames]);
        } catch (\Exception $ex) {
            return response()->json(['success' => 'not found']);
        }

    }
}
