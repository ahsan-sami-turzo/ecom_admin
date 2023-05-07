<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdvertisementRequest;
use App\Http\Requests\AdvertisementUpdateRequest;
use App\Models\Advertisement;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $advertisements = Advertisement::orderBy('id', 'asc')->get();
        return view('admin.advertisement.index', compact('advertisements'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.advertisement.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AdvertisementRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(AdvertisementRequest $request)
    {
        $data = $this->getData($request);
        Advertisement::create($data);
        $msg = "Advertisement created";
        return redirect(route("advertisement.index"))->with('success', $msg);

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
     * @param Advertisement $advertisement
     * @return Application|Factory|View
     */
    public function edit(Advertisement $advertisement)
    {
        return view('admin.advertisement.edit', compact("advertisement"));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param AdvertisementUpdateRequest $request
     * @param Advertisement $advertisement
     * @return Application|Redirector|RedirectResponse
     */
    public function update(AdvertisementUpdateRequest $request, Advertisement $advertisement)
    {
        $data = $request->all();
        $imageName = Str::slug($data['name']);
        if ($request->hasFile('image')) {
            $data['image'] = doUploadImage($imageName, 'uploads/advertisement', $request->image, 'uploads/advertisement/optimize', 100, 100, 'jpeg');
        }
        $data['status'] = 1;
        $data['softDel'] = 0;
        $advertisement->update($data);
        $msg = "Advertisement updated";
        return redirect(route("advertisement.index"))->with('success', $msg);

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
     * @param AdvertisementRequest $request
     * @return array
     */
    public function getData(AdvertisementRequest $request): array
    {
        $data = $request->all();
        $imageName = Str::slug($data['name']);
        if ($request->hasFile('image')) {
            $data['image'] = doUploadImage($imageName, 'uploads/advertisement', $request->image, 'uploads/advertisement/optimize', 100, 100, 'jpeg');
        }
        $data['status'] = 1;
        $data['softDel'] = 0;

        return $data;
    }
}
