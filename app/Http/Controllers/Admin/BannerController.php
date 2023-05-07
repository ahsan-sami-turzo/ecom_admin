<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Http\Requests\BannerUpdateRequest;
use App\Http\Requests\BrandRequest;
use App\Models\Banner;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $banners = Banner::orderBy('id', 'asc')->get();
        return view('admin.banner.index', compact('banners'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.banner.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BannerRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(BannerRequest $request)
    {

        $data =$this->getData($request);
        Banner::create($data);
        $msg = "Brand created";
        return redirect(route("banner.index"))->with('success', $msg);

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
     * @param Banner $banner
     * @return Application|Factory|View
     */
    public function edit(Banner $banner)
    {
        return view('admin.banner.edit', compact("banner"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BannerUpdateRequest $request
     * @param Banner $banner
     * @return Application|Redirector|RedirectResponse
     */
    public function update(BannerUpdateRequest $request, Banner $banner)
    {
        $data = $request->all();
        $imageName = Str::slug($data['name']);
        if ($request->hasFile('image')) {
            $data['image'] = doUploadImage($imageName, 'uploads/banner', $request->image, 'uploads/banner/optimize', 100, 100, 'jpeg');
        }
        $data['status'] = 1;
        $data['softDel'] = 0;

        $banner->update($data);
        $msg = "Banner updated";
        return redirect(route("banner.index"))->with('success', $msg);
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

    /**
     * @param BannerRequest $request
     * @return array
     */
    public function getData(BannerRequest $request): array
    {
        $data = $request->all();

        $imageName = Str::slug($data['name']);
        if ($request->hasFile('image')) {
            $data['image'] = doUploadImage($imageName, 'uploads/banner', $request->image, 'uploads/banner/optimize', 100, 100, 'jpeg');
        }
        $data['status'] = 1;
        $data['softDel'] = 0;

        return $data;
    }
}
