<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountCampaign;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class DiscountCampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
       $discountCampaigns = DiscountCampaign::orderBy('id', 'desc')->get();
        return view('admin.discount-campaign.index',compact('discountCampaigns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.discount-campaign.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        $data = $request->all();
        DiscountCampaign::create($data);
        $msg = "Discount campaign created";
        return redirect(route("discount-campaign.index"))->with('success', $msg);

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
     * @param DiscountCampaign $discount_campaign
     * @return Application|Factory|View
     */
    public function edit(DiscountCampaign $discount_campaign)
    {
        return view('admin.discount-campaign.edit',compact('discount_campaign'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param DiscountCampaign $discount_campaign
     * @return Application|Redirector|RedirectResponse
     */
    public function update(Request $request, DiscountCampaign $discount_campaign)
    {
        $data = $request->all();
        if (\request('campagin_discount_type') == 'percentage') {
            $discount_campaign->update([
                'amount' => 0
            ]);
        }else{
            $discount_campaign->update([
                'percentage' => 0
            ]);
        }

        $discount_campaign->update($data);
        $msg = "Discount campaign updated";
        return redirect(route("discount-campaign.index"))->with('success', $msg);
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
