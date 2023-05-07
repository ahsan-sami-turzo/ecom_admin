<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryAsideNavberRequest;
use App\Models\Category;
use App\Models\CategoryAsideNavbar;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;

class CategoryAsideNavbarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $categoryAsideNavbars = CategoryAsideNavbar::all();
        return view('admin.category-aside-navbar.index', compact('categoryAsideNavbars'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $categories = Category::parentIdZero()->status()->get();
        return view('admin.category-aside-navbar.create', compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(CategoryAsideNavberRequest $request)
    {
        $data = $request->all();
        foreach ($data['category_id'] as $key => $val) {
            CategoryAsideNavbar::create([
                'slug' => Str::uuid(),
                'category_id' => $val,
                'effectiveDate' => $data['effectiveDate'],
                'status' => 1
            ]);
        }
        $msg = "Category Aside Navbar created";
        return redirect(route("category-aside-navbar.index"))->with('success', $msg);

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
     * @param CategoryAsideNavbar $categoryAsideNavbar
     * @return Application|Factory|View
     */
    public function edit(CategoryAsideNavbar $categoryAsideNavbar)
    {
        $categories = Category::all();
        return view('admin.category-aside-navbar.edit', compact('categories','categoryAsideNavbar'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param CategoryAsideNavbar $categoryAsideNavbar
     * @return Application|Redirector|RedirectResponse
     */
    public function update(Request $request, CategoryAsideNavbar $categoryAsideNavbar)
    {
        $data = $request->all();
        $categoryAsideNavbar->update($data);
        $msg = "Category Aside Navbar updated";
        return redirect(route("category-aside-navbar.index"))->with('success', $msg);


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
