<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $brands = Brand::with('user')->orderBy('id', 'asc')->get();
        return view('admin.brand.index', compact('brands'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $users = User::where('user_type', '=', 'vendor')->get();
        return view('admin.brand.create', compact('users'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BrandRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(BrandRequest $request)
    {
        $data =$this->getData($request);
        Brand::create($data);
        $msg = "Brand created";
        return redirect(route("brand.index"))->with('success', $msg);
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
     * @param Brand $brand
     * @return Application|Factory|View
     */
    public function edit(Brand $brand)
    {
        $users = User::all();
        return view('admin.brand.edit', compact('users', 'brand'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param BrandRequest $request
     * @param Brand $brand
     * @return Application|Redirector|RedirectResponse
     */
    public function update(BrandRequest $request, Brand $brand)
    {
        $data = $this->getData($request);
        $brand->update($data);
        $msg = "Brand updated";
        return redirect(route("brand.index"))->with('success', $msg);

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
     * @param BrandRequest $request
     * @return array
     */
    public function getData(Request $request): array
    {
        $data = $request->all();
        $data['slug'] = md5(time() . time() . rand());
        if ($request->hasFile('image')) {
            $data['image'] = doUploadImage($data['slug'], 'uploads/brand', $request->image, 'uploads/brand/optimize', 100, 100, 'jpeg');
        }
        $data['status'] = 1;
        $data['user_id'] = auth()->id();
        return $data;
    }
}
