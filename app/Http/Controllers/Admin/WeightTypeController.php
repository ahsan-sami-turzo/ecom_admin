<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\WeightTypeRequest;
use App\Models\WeightType;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class WeightTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $weightTypes = WeightType::all();
        return view('admin.weight-type.index',compact('weightTypes'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.weight-type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param WeightTypeRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(WeightTypeRequest $request)
    {
        $data = $request->all();
        $data['softDel'] = 0 ;
        $data['status'] = 1 ;
        WeightType::create($data);
        $msg = "Weight type created";
        return redirect(route("weight-type.index"))->with('success', $msg);

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
     * @param  int  $id
     * @return Response
     */
    public function edit(WeightType $weightType)
    {
        return view('admin.weight-type.edit',compact('weightType'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, WeightType $weightType)
    {
        $data = $request->all();
        $weightType->update($data);
        $msg = "Weight type updated";
        return redirect(route("weight-type.index"))->with('success', $msg);

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
