<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UnityOfMentRequest;
use App\Models\UnityOfMeasurement;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class UnityOfMeasurementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $unityOfMeasurements = UnityOfMeasurement::orderBy('id','asc')->get();
        return view('admin.unityofment.index',compact('unityOfMeasurements'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.unityofment.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UnityOfMentRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(UnityOfMentRequest $request)
    {
        $data = $request->all();
        $data['softDel'] = 0 ;
        $data['status'] = 1 ;
        UnityOfMeasurement::create($data);
        $msg = "Unit Of Measurement Information created";
        return redirect(route("unity-of-measurement.index"))->with('success', $msg);

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
     * @param UnityOfMeasurement $unity_of_measurement
     * @return Application|Factory|View
     */
    public function edit(UnityOfMeasurement $unity_of_measurement)
    {
        return view('admin.unityofment.edit',compact('unity_of_measurement'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param UnityOfMentRequest $request
     * @param UnityOfMeasurement $unity_of_measurement
     * @return Application|Redirector|RedirectResponse
     */
    public function update(UnityOfMentRequest $request, UnityOfMeasurement $unity_of_measurement)
    {
        $data = $request->all();
        $unity_of_measurement->update($data);
        $msg = "Unit Of Measurement Information updated";
        return redirect(route("unity-of-measurement.index"))->with('success', $msg);

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
