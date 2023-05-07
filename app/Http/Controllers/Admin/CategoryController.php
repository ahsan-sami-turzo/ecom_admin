<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct()
    {
                $this->middleware('permission:category-list', ['only' => ['index','store']]);
                $this->middleware('permission:category-create', ['only' => ['create','store']]);
                $this->middleware('permission:category-edit', ['only' => ['edit','update']]);
                $this->middleware('permission:category-delete', ['only' => ['destroy']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $categories = Category::with('parentCategory')->get();
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $categories = Category::with('parentCategory')->get();
        return view('admin.category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->all();

        $parentId = $request->parent_category_id;
        try {
            $product = Product::where('category_id', $parentId)->firstOrFail();
            if ($product) {
                $data['parent_category_id'] = 0;
                $msg = "already product added !! ( $request->category_name ) category so you can not created child category";
                return redirect(route('category.index'))->with('success', $msg);
            }
        } catch (\Exception $ex) {
            $data['parent_category_id'] = $request->parent_category_id;
        }

        if ($parentId == 0) {
            $data['level'] = 1;
        } else {
            $parentLevel = Category::where('id', $parentId)->first()->level;
            $data['level'] = $parentLevel + 1;
        }
        $data['softDel'] = 0;
        $data['slug'] = Str::slug($request->category_name) . '-' . Str::uuid();
        Category::create($data);
        $msg = "Category created";
        return redirect(route('category.index'))->with('success', $msg);

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
     * @param Category $category
     * @return Application|Factory|View
     */
    public function edit(Category $category)
    {
        $categories = Category::where('parent_category_id', 0)->get();
        return view('admin.category.edit', compact('categories', 'category'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryRequest $request
     * @param Category $category
     * @return Application|Redirector|RedirectResponse
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $data = $request->all();
        $parentId = $request->parent_category_id;
        if ($parentId == 0) {
            $data['level'] = 1;
        } else {
            $parentLevel = $category->where('id', $parentId)->first()->level;
            $data['level'] = $parentLevel + 1;
        }
        $data['is_color'] = (!request()->has('is_color') == '1' ? '0' : '1');
        $data['is_size'] = (!request()->has('is_size') == '1' ? '0' : '1');
        $data['is_weight'] = (!request()->has('is_weight') == '1' ? '0' : '1');
        $data['softDel'] = 0;
        $data['slug'] = Str::slug($request->category_name) . '-' . Str::uuid();

        $category->update($data);
        $msg = "Category Updated";
        return redirect(route('category.index'))->with('success', $msg);
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

    public function hasProduct(Request $request): JsonResponse
    {
        try {
            $id = $request->category_id;
            $product = Product::where('category_id', $id)->firstOrFail();
            return response()->json(['success' => $product]);
        } catch (\Exception $ex) {
            return response()->json(['success' => 'not found']);
        }

    }

    public function specification(Request $request): JsonResponse
    {
        try {
            $id = $request->category_id;
            $category = Category::where('id', $id)->firstOrFail();
            return response()->json(['success' => $category]);
        } catch (\Exception $ex) {
            return response()->json(['success' => 'not found']);
        }

    }

    public function hasVariant(Request $request): JsonResponse
    {
        try {
            $id = $request->category_id;
            $category = Category::where('id', $id)->firstOrFail();
            return response()->json(['success' => $category]);
        } catch (\Exception $ex) {
            return response()->json(['success' => 'not found']);
        }

    }
}
