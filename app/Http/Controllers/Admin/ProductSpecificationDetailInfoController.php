<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductSpecificationDetailInfoRequest;
use App\Models\Category;
use App\Models\ProductSpecificationDetailInfo;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class ProductSpecificationDetailInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {

        $productSpecificationDetailInfo = ProductSpecificationDetailInfo::with('category')->orderBy('id', 'asc')->get();
        return view('admin.product-specifications-details-info.index', compact('productSpecificationDetailInfo'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.product-specifications-details-info.create', compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductSpecificationDetailInfoRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(ProductSpecificationDetailInfoRequest $request)
    {
        $data = $this->getData($request);
        ProductSpecificationDetailInfo::create($data);
        $msg = "Product specification details info created";
        return redirect(route("product-specification-details-info.index"))->with('success', $msg);

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
     * @param ProductSpecificationDetailInfo $product_specification_info
     * @return Application|Factory|View
     */
    public function edit(ProductSpecificationDetailInfo $product_specification_info)
    {
        $categories = Category::all();
        return view('admin.product-specifications-details-info.edit', compact('categories','product_specification_info'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ProductSpecificationDetailInfo $product_specification_info
     * @return Application|Redirector|RedirectResponse
     */
    public function update(Request $request, ProductSpecificationDetailInfo $product_specification_info)
    {
        $data = $this->getData($request);
        $product_specification_info->update($data);
        $msg = "Product specification details info updated";
        return redirect(route("product-specification-info.index"))->with('success', $msg);

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
    private function getData(Request $request):array
    {
        $data = [
            'category_id'                   =>$request->category_id,
            'name'                          =>json_encode($request->name),
            'specification_detail_name'     =>$request->specification_detail_name,
            'status'                        =>'active',
            'softDel'                       =>0,
            'user_id'                       =>auth()->id(),
            'entry_user_type'               =>json_encode(auth()->user()->getRoleNames()),
        ];

        return $data;
    }

    /*public function getName(Request $request): \Illuminate\Http\JsonResponse
    {
        $id = $request->category_id;
        $specificationDetailNames = Category::with('productSpecificationDetails')->where('id', $id)->get();
        return response()->json(['success' => $specificationDetailNames ]);
    }*/


}
