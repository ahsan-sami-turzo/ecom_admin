<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ColorInfoRequest;
use App\Models\ColorInfo;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class ColorInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $colorInfos = ColorInfo::orderBy('id','asc')->get();
        return view('admin.color.index',compact('colorInfos'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.color.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ColorInfoRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(ColorInfoRequest $request)
    {
        $data = $request->all();
        $data['softDel'] = 0 ;
        $data['status'] = 1 ;
        ColorInfo::create($data);
        $msg = "Color Information created";
        return redirect(route("color-info.index"))->with('success', $msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ColorInfo $colorInfo
     * @return Application|Factory|View
     */
    public function edit(ColorInfo $colorInfo)
    {
        return view('admin.color.edit',compact('colorInfo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ColorInfoRequest $request
     * @param ColorInfo $colorInfo
     * @return Application|Redirector|RedirectResponse
     */
    public function update(ColorInfoRequest $request, ColorInfo $colorInfo)
    {

        $data = $request->all();
        $colorInfo->update($data);
        $msg = "Color Information updated";
        return redirect(route("color-info.index"))->with('success', $msg);
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
