<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommissionRequest;
use App\Http\Requests\CommissionUpdateRequest;
use App\Models\Category;
use App\Models\Commission;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;

class CommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $vendorCounts = User::where('status', 'APPROVED')->where('user_type', 'vendor')->get()->count();
        $commissions = Commission::groupBy('category_id')->selectRaw('category_id')->get();
        $categories = Category::whereIN('id', $commissions)->with('commissions.manyUsers', 'cateName', 'commissionVendor')->get();
        return view('admin.commission.index', compact('categories', 'vendorCounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $categories = Category::where('parent_category_id', 0)->get();
        $users = User::where('user_type', 'vendor')->pluck('name', 'id');
        return view('admin.commission.create', compact('categories', 'users'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CommissionRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(CommissionRequest $request)
    {
        $users = User::where('user_type', 'vendor')->pluck('id');


        try {
            $commission = Commission::where('category_id', $request->category_id)->first();

            if ($commission) {
                $commission = Commission::where('category_id', $request->category_id)->falseAllVendor()->delete();

                /* $commission->update([
                     'percent' => $request->percent,
                 ]);*/
                /*if ($request->is_all_vendor == true) {
                    Commission::create([
                        'category_id' => $request->category_id,
                        'percent' => $request->percent,
                        'slug' => Str::uuid(),
                        'is_all_vendor' => $request->is_all_vendor ?: 'false',
                        'status' => 1,
                        'softDel' => 0,
                        'effectived_date' => $request->effectived_date
                    ]);
                }*/
            }

            if (\request('vendor_id')) {
                //$commission = Commission::where('category_id', $request->category_id)->isAllVendor()->first()->delete();
                foreach (\request('vendor_id') as $vendorId) {
                    $commission = Commission::where('category_id', $request->category_id)->where('vendor_id', $vendorId)->delete();
                    $this->extracted($request, $vendorId);
                }
            }

            if ($request->is_all_vendor == true) {
                Commission::create([
                    'category_id' => $request->category_id,
                    'percent' => $request->percent,
                    'slug' => Str::uuid(),
                    'is_all_vendor' => $request->is_all_vendor ?: 'false',
                    'status' => 1,
                    'softDel' => 0,
                    'effectived_date' => $request->effectived_date
                ]);
            }
        } catch (\Exception $ex) {

            if ($request->is_all_vendor == true) {
                $commission = Commission::where('category_id', $request->category_id)->falseAllVendor()->first()->delete();

                Commission::create([
                    'category_id' => $request->category_id,
                    'percent' => $request->percent,
                    'slug' => Str::uuid(),
                    'is_all_vendor' => $request->is_all_vendor ?: 'false',
                    'status' => 1,
                    'softDel' => 0,
                    'effectived_date' => $request->effectived_date
                ]);
            } else {
                // vendor add when chooses multiple

                foreach (\request('vendor_id') as $vendorId) {
                    $this->extracted($request, $vendorId);
                }
            }
        }


        $msg = "Commission created";
        return redirect(route("commission.index"))->with('success', $msg);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Commission $commission
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $commission = Commission::where('category_id', $id)->first();
        $categoryVendors = Category::with('commissions')->where('id',$id)->first();
         $categoryVendor = $categoryVendors->commissions->pluck('vendor_id');
        $categories = Category::where('parent_category_id', 0)->get();
        $users = User::where('user_type', 'vendor')->pluck('name', 'id');
        return view('admin.commission.edit', compact('categories', 'users', 'commission','categoryVendor'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param CommissionRequest $request
     * @return Application|Redirector|RedirectResponse
     */
    public function update(CommissionRequest $request)
    {
        $commission = Commission::where('category_id', $request->category_id)->delete();

        foreach (\request('vendor_id') as $vendorId) {
            $this->extracted($request, $vendorId);
        }
        $msg = "Commission updated";
        return redirect(route("commission.index"))->with('success', $msg);

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

    /**
     * @param CommissionRequest $request
     * @param $value
     * @return void
     */
    public function extracted(CommissionRequest $request, $value): void
    {
        $newData = Commission::where('category_id', $request->category_id)->where('vendor_id', $value)->first();
        if ($newData) {
            //
            //already category id added and vendor id added
            //
            $newData->update([
                'category_id' => $request->category_id,
                'vendor_id' => $value,
                'percent' => $request->percent,
                'slug' => Str::uuid(),
                'is_all_vendor' => $request->is_all_vendor ?: 'false',
                'status' => 1,
                'softDel' => 0,
                'effectived_date' => $request->effectived_date
            ]);
        } else {
            Commission::create([
                'category_id' => $request->category_id,
                'vendor_id' => $value,
                'percent' => $request->percent,
                'slug' => Str::uuid(),
                'is_all_vendor' => $request->is_all_vendor ?: 'false',
                'status' => 1,
                'softDel' => 0,
                'effectived_date' => $request->effectived_date
            ]);
        }
    }
}
