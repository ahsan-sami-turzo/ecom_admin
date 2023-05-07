<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SizeTypeRequest;
use App\Models\ColorInfo;
use App\Models\SizeType;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class SizeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $sizeTypes = SizeType::all();
        return view('admin.size-type.index',compact('sizeTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.size-type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SizeTypeRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(SizeTypeRequest $request)
    {
        $data = $request->all();
        $data['softDel'] = 0 ;
        $data['status'] = 1 ;
        SizeType::create($data);
        $msg = "Size type created";
        return redirect(route("size-type.index"))->with('success', $msg);
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
     * @param SizeType $sizeType
     * @return Application|Factory|View
     */
    public function edit(SizeType $sizeType)
    {
        return view('admin.size-type.edit',compact('sizeType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SizeTypeRequest $request
     * @param SizeType $sizeType
     * @return Application|Redirector|RedirectResponse
     */
    public function update(SizeTypeRequest $request, SizeType $sizeType)
    {
        $data = $request->all();
        $sizeType->update($data);
        $msg = "Size type updated";
        return redirect(route("size-type.index"))->with('success', $msg);
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
