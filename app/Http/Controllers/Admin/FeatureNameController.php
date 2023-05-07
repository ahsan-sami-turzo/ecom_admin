<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeatureNameRequest;
use App\Http\Requests\UpdateFeatureNameRequest;
use App\Models\FeatureName;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class FeatureNameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
       $featureNames = FeatureName::orderBy('display_serial', 'asc')->get();
        return view('admin.feature-name.index', compact("featureNames"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.feature-name.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FeatureNameRequest $request
     * @return Application|Redirector|RedirectResponse
     */
    public function store(FeatureNameRequest $request)
    {
        //return $request->all();
        if (is_array($request->display_type)) {
            foreach ($request->display_type as $key => $value) {
                FeatureName::create([
                    'display_products' => $request->display_products,
                    'display_type' => $key,
                    'name' => $value,
                    'display_serial' => $request->display_serial
                ]);
            }
        }else{
            FeatureName::create($request->all());
        }
        $msg = "Feature name created";
        return redirect(route("feature-name.index"))->with('success', $msg);
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
     * @param FeatureName $feature_name
     * @return Application|Factory|View
     */
    public function edit(FeatureName $feature_name)
    {
        return view('admin.feature-name.edit',compact('feature_name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateFeatureNameRequest $request
     * @param FeatureName $featureName
     * @return Application|Redirector|RedirectResponse
     */
    public function update(UpdateFeatureNameRequest $request, FeatureName $featureName)
    {
       $featureNames = FeatureName::where('display_products',$request->display_products)->where('display_serial',$featureName->display_serial)->get();
        foreach ($featureNames as $serial) {
            $serial->update([
                'display_serial' => $request->display_serial
            ]);
        }
        $featureName->update([
            'name' => $request->name,
        ]);

        $msg = "Feature name Update";
        return redirect(route("feature-name.index"))->with('success', $msg);
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
