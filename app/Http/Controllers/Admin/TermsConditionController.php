<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TermsConditionRequest;
use App\Models\ConditionType;
use App\Models\TermsCondition;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class TermsConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $termsConditions = TermsCondition::with('condition')->orderBy('id', 'asc')->get();
        return view('admin.terms-condition.index', compact('termsConditions'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $conditionTypes = ConditionType::orderBy('id', 'asc')->get();
        return view('admin.terms-condition.create',compact('conditionTypes'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TermsConditionRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(TermsConditionRequest $request)
    {
        $data = $request->all();
        $data['softDel'] = 0;
        $data['status'] = 1;
        TermsCondition::create($data);
        $msg = "Terms condition created";
        return redirect(route("terms.index"))->with('success', $msg);

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
     * @param TermsCondition $terms_condition
     * @return Application|Factory|View
     */
    public function edit(TermsCondition $term)
    {
        $conditionTypes = ConditionType::orderBy('id', 'asc')->get();
        return view('admin.terms-condition.edit',compact('conditionTypes','term'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param TermsConditionRequest $request
     * @param TermsCondition $terms
     * @return Application|Redirector|RedirectResponse
     */
    public function update(TermsConditionRequest $request, TermsCondition $term)
    {
        $data = $request->all();
        $term->update($data);
        $msg = "Terms condition updated";
        return redirect(route("terms.index"))->with('success', $msg);

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
