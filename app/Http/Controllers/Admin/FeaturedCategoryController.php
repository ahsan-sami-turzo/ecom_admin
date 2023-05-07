<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeaturedCategoryRequest;
use App\Models\Category;
use App\Models\FeaturedCategory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class FeaturedCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $featuredCategories = FeaturedCategory::all();
        return view('admin.featured-category.index', compact('featuredCategories'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.featured-category.create', compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FeaturedCategoryRequest $request
     * @return Application|Redirector|RedirectResponse
     */
    public function store(FeaturedCategoryRequest $request)
    {
        $data = $request->all();
        foreach ($data['category_id'] as $key => $val) {
            FeaturedCategory::create([
                'category_id' => $val,
                'effectiveDate' => $data['effectiveDate'],
                'status' => 1
            ]);
        }
        $msg = "Feature Category created";
        return redirect(route("featured-category.index"))->with('success', $msg);
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
     * @param FeaturedCategory $featuredCategory
     * @return Application|Factory|View
     */
    public function edit(FeaturedCategory $featuredCategory)
    {
        $categories = Category::all();
        return view('admin.featured-category.edit', compact('categories','featuredCategory'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param FeaturedCategoryRequest $request
     * @param FeaturedCategory $featuredCategory
     * @return Application|RedirectResponse|Redirector
     */
    public function update(FeaturedCategoryRequest $request, FeaturedCategory $featuredCategory)
    {
        $data = $request->all();
        $featuredCategory->update($data);
        $msg = "Feature Category updated";
        return redirect(route("featured-category.index"))->with('success', $msg);

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
