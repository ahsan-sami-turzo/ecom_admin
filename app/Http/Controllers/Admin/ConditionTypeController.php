<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConditionTypeRequest;
use App\Models\ConditionType;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class ConditionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $conditionTypes = ConditionType::orderBy('id', 'asc')->get();
        return view('admin.condition-type.index', compact('conditionTypes'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.condition-type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {

        $data = $request->all();
        $data['softDel'] = 0;
        $data['status'] = 1;
        ConditionType::create($data);
        $msg = "Condition Type created";
        return redirect(route("condition-type.index"))->with('success', $msg);

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
     * @param ConditionType $conditionType
     * @return Application|Factory|View
     */
    public function edit(ConditionType $condition_type)
    {
        return view('admin.condition-type.edit', compact("condition_type"));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param ConditionTypeRequest $request
     * @param ConditionType $conditionType
     * @return Application|RedirectResponse|Redirector
     */
    public function update(ConditionTypeRequest $request, ConditionType $conditionType)
    {

        $data = $request->all();
        $conditionType->update($data);
        $msg = "Condition Type update";
        return redirect(route("condition-type.index"))->with('success', $msg);
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
