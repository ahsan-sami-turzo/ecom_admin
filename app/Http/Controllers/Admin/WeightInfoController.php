<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\WeightInfoRequest;
use App\Models\WeightInfo;
use App\Models\WeightType;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class WeightInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $weightInfos = WeightInfo::orderBy('id', 'asc')->get();
        return view('admin.weight-info.index', compact('weightInfos'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $weightTypes = WeightType::all();
        return view('admin.weight-info.create',compact('weightTypes'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param WeightInfoRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(WeightInfoRequest $request)
    {
        $data = $request->all();
        $data['softDel'] = 0;
        $data['status'] = 1;
        WeightInfo::create($data);
        $msg = "Weight Information created";
        return redirect(route("weight-info.index"))->with('success', $msg);

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
     * @param WeightInfo $weightInfo
     * @return Application|Factory|View
     */
    public function edit(WeightInfo $weightInfo)
    {
        $weightTypes = WeightType::all();
        return view('admin.weight-info.edit', compact('weightInfo','weightTypes'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param WeightInfoRequest $request
     * @param WeightInfo $weightInfo
     * @return Response
     */
    public function update(WeightInfoRequest $request, WeightInfo $weightInfo)
    {
        $data = $request->all();
        $weightInfo->update($data);
        $msg = "Weight updated";
        return redirect(route("weight-info.index"))->with('success', $msg);

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
