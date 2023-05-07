<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SizeInfoRequest;
use App\Http\Requests\SizeTypeRequest;
use App\Models\SizeInfo;
use App\Models\SizeType;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class SizeInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $sizeInfos = SizeInfo::orderBy('id', 'asc')->get();
        return view('admin.size-info.index', compact('sizeInfos'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $sizeTypes = SizeType::all();
        return view('admin.size-info.create',compact('sizeTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SizeInfoRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(SizeInfoRequest $request)
    {
        $data = $request->all();
        $data['softDel'] = 0;
        $data['status'] = 1;
        SizeInfo::create($data);
        $msg = "Size Information created";
        return redirect(route("size-info.index"))->with('success', $msg);

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
     * @param SizeInfo $sizeInfo
     * @return Application|Factory|View
     */
    public function edit(SizeInfo $sizeInfo)
    {
        $sizeTypes = SizeType::all();
        return view('admin.size-info.edit', compact('sizeInfo','sizeTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SizeInfoRequest $request
     * @param SizeInfo $sizeInfo
     * @return Application|Redirector|RedirectResponse
     */
    public function update(SizeInfoRequest $request, SizeInfo $sizeInfo)
    {
        $data = $request->all();
        $sizeInfo->update($data);
        $msg = "Size Information updated";
        return redirect(route("size-info.index"))->with('success', $msg);

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
