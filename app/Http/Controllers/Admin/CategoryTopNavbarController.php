<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryTopNavbarRequest;
use App\Models\Category;
use App\Models\CategoryTopNavbar;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;

class CategoryTopNavbarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $categoryTopNavbars = CategoryTopNavbar::all();
        return view('admin.category-top-navbar.index', compact('categoryTopNavbars'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.category-top-navbar.create', compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryTopNavbarRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(CategoryTopNavbarRequest $request)
    {
        $data = $request->all();
        foreach ($data['category_id'] as $key => $val) {
            CategoryTopNavbar::create([
                'slug' => Str::uuid(),
                'category_id' => $val,
                'effectiveDate' => $data['effectiveDate'],
                'status' => 1
            ]);
        }
        $msg = "Category Top navbar created";
        return redirect(route("category-top-navbar.index"))->with('success', $msg);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return abort('404');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CategoryTopNavbar $categoryTopNavbar
     * @return Application|Factory|View
     */
    public function edit(CategoryTopNavbar  $categoryTopNavbar)
    {
        $categories = Category::all();
        return view('admin.category-top-navbar.edit', compact('categories','categoryTopNavbar'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryTopNavbarRequest $request
     * @param CategoryTopNavbar $categoryTopNavbar
     * @return Application|Redirector|RedirectResponse
     */
    public function update(CategoryTopNavbarRequest $request, CategoryTopNavbar $categoryTopNavbar)
    {
        $data = $request->all();
        $categoryTopNavbar->update($data);
        $msg = "Category Top navbar updated";
        return redirect(route("category-top-navbar.index"))->with('success', $msg);

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
