<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\ColorImage;
use App\Models\ColorInfo;
use App\Models\Product;
use App\Models\ProductEntry;
use App\Models\SizeType;

use App\Models\User;
use App\Models\WeightType;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class VendorProductAddedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $vendor = User::where('id',auth()->id())->with('vendorProducts')->orderBy('id', 'desc')->first();
        return view('admin.vendor-product.index', compact('vendor'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $categories = Category::where('parent_category_id', 0)->get();
        $users = User::where('user_type', 'vendor')->where('status', 'APPROVED')->get();
        return view('admin.vendor-product.create', compact('categories', 'users'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(ProductRequest $request)
    {
        DB::transaction(function () use ($request) {
            try {
                $data = $request->all();
                $data['product_sku'] = generateProductSku("$request->product_name", auth()->id());
                if ($request->hasFile('home_image')) {
                    $data['home_image'] = doUploadImage(substr($request->product_name, 0, 3), "uploads/product/", "$request->home_image", "uploads/product/optimize", 100, 100, "jpeg");
                }
                $product = Product::create([
                    'vendor_id' => auth()->id(),
                    'product_name' => $data['product_name'],
                    'category_id' => $data['category_id'],
                    'product_sku' => $data['product_sku'],
                    'productPrice' => $data['productPrice'],
                    'brand_name' => $data['brand_name'],
                    'home_image' => $data['home_image'] ?? '',
                    'description' => $data['description'],
                    'title' => $data['title'],
                    'status' => 'active',
                    'isApprove' => 'unauthorize',
                    'entry_by' => auth()->id(),
                    'code' => str_pad(random_int(1, rand(time(), time())), 8, '0', STR_PAD_LEFT)
                ]);

                //if product size from request
                if ($request->size_name) {
                    foreach ($request->size_name as $key => $value) {
                        if ($value == null) {
                            $insertedSizes = [];
                        } else {
                            $insertedSizes[] = SizeType::create([
                                'name' => $value,
                                'product_id' => $product->id,
                                'softDel' => 0,
                                'status' => 1
                            ]);
                        }
                    }
                }

                //if product weight from request
                if ($request->weight_name) {
                    foreach ($request->weight_name as $key => $value) {
                        if ($value == null) {
                            $insertedWeights = [];
                        } else {
                            $insertedWeights[] = WeightType::create([
                                'name' => $value,
                                'product_id' => $product->id,
                                'softDel' => 0,
                                'status' => 1
                            ]);
                        }
                    }
                }

                //if product color from request
                if ($request->color_name) {
                    foreach ($request->color_name as $key => $value) {
                        if ($value == null) {
                            $insertedColors = [];
                        } else {
                            $insertedColors[] = $color = ColorInfo::create([
                                'name' => $value,
                                'product_id' => $product->id,
                                'softDel' => 0,
                                'status' => 1
                            ]);
                            $colorImageName = \request("color_images_$key");

                            if ($request->hasFile("color_images_$key")) {
                                foreach ($colorImageName as $imageKey => $imageVal) {
                                    if ($request->file("color_images_$key")) {
                                        ColorImage::create([
                                            "name" => doUploadImage(Str::slug("$color->name") . $imageKey, "uploads/product/color", "$imageVal", "uploads/product/color/optimize", 100, 100, 'jpeg'),
                                            'color_id' => $color->id,
                                            'softDel' => 0,
                                            'status' => 1
                                        ]);
                                    }
                                }
                            }
                        }
                    }
                }

                // Insert to product_details table looping
                if (empty($insertedSizes)) $insertedSizes = $this->createNullObject();
                if (empty($insertedWeights)) $insertedWeights = $this->createNullObject();
                if (empty($insertedColors)) $insertedColors = $this->createNullObject();

                $this->insertProductsIntoProductEntry($insertedSizes, $insertedWeights, $insertedColors, $product, $data);

                DB::commit();

            } catch (\Exception $exception) {
                DB::rollback();
                Session::flash('error', 'Unable to process request.Error:' . json_encode($exception->getFile(), true) . json_encode($exception->getLine(), true) . json_encode($exception->getMessage(), true));
                return redirect()->back();
            }

        });
        $msg = "Product created";
        return redirect(route("products.index"))->with('success', $msg);
    }
    function createNullObject()
    {
        return ['id' => 0];
    }

    /** @noinspection DuplicatedCode */
    function insertProductsIntoProductEntry($insertedSizes, $insertedWeights, $insertedColors, $product, $data, $updateSizes = null, $updateWeights = null, $updateColors = null)
    {
        foreach ($insertedSizes as $size) {
            foreach ($insertedWeights as $weight) {
                foreach ($insertedColors as $color) {
                    $child_product = [
                        'size_id' => (is_object($size) && isset($size->id)) ? $size->id : 0,
                        'weight_id' => (is_object($weight) && isset($weight->id)) ? $weight->id : 0,
                        'color_id' => (is_object($color) && isset($color->id)) ? $color->id : 0,
                        'product_id' => $product->id,
                        'sku' => generateProductSku($product->product_name, $product->id),
                        'price' => $data['productPrice'],
                    ];
                    ProductEntry::create($child_product);
                }
            }
        }
        if ((is_array($updateSizes) or is_array($updateWeights) or is_array($updateColors))) {
            DB::table('product_details')->where('product_id', $product->id)->delete();
            foreach ($updateSizes as $size) {
                foreach ($updateWeights as $weight) {
                    // DB::table('product_details')->where('product_id',$size->id)->delete();
                    foreach ($updateColors as $color) {
                        // DB::table('product_details')->where('product_id',$size->id)->delete();
                        $child_product = [
                            'size_id' => (is_object($size) && isset($size->id)) ? $size->id : 0,
                            'weight_id' => (is_object($weight) && isset($weight->id)) ? $weight->id : 0,
                            'color_id' => (is_object($color) && isset($color->id)) ? $color->id : 0,
                            'product_id' => $product->id,
                            'sku' => generateProductSku($product->product_name, $product->id),
                            'price' => $data['productPrice'],
                        ];
                        ProductEntry::create($child_product);
                    }
                }
            }
        }

        /* if (count($product->size) > 0){
             foreach ($insertedSizes as $size) {
                 if (count($product->weight) > 0) {
                     foreach ($product->weight as $productWeight) {
                         $child_product = [
                             'size_id' => (is_object($size) && isset($size->id)) ? $size->id : 0,
                             'weight_id' =>  $productWeight->id ?: 0,
                             'color_id' => (is_object($color) && isset($color->id)) ? $color->id : 0,
                             'product_id' => $product->id,
                             'sku' => generateProductSku($product->product_name, $product->id),
                             'price' => $data['productPrice'],
                         ];
                         ProductEntry::create($child_product);
                     }
                 }
                 foreach ($insertedWeights as $weight) {
                     if (count($product->color) > 0) {
                         foreach ($product->color as $productColor) {
                             $child_product = [
                                 'size_id' => (is_object($size) && isset($size->id)) ? $size->id : 0,
                                 'weight_id' => (is_object($weight) && isset($weight->id)) ? $weight->id : 0,
                                 'color_id' => ( isset($productColor->id)) ? $productColor->id : 0,
                                 'product_id' => $product->id,
                                 'sku' => generateProductSku($product->product_name, $product->id),
                                 'price' => $data['productPrice'],
                             ];
                             ProductEntry::create($child_product);
                         }
                     }
                     foreach ($insertedColors as $color) {
                         $child_product = [
                             'size_id' => (is_object($size) && isset($size->id)) ? $size->id : 0,
                             'weight_id' => (is_object($weight) && isset($weight->id)) ? $weight->id : 0,
                             'color_id' => (is_object($color) && isset($color->id)) ? $color->id : 0,
                             'product_id' => $product->id,
                             'sku' => generateProductSku($product->product_name, $product->id),
                             'price' => $data['productPrice'],
                         ];
                         ProductEntry::create($child_product);
                     }
                 }
             }
         }*/
    }


    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return Response
     */
    public function show(Product $product)
    {
        $product = $product->where('id', $product->id)->with('weight', 'size', 'category', 'vendor', 'color.colorImage')->first();
        $categories = Category::where('parent_category_id', 0)->get();
        $users = User::where('user_type', 'vendor')->where('status', 'APPROVED')->get();
        return view('admin.vendor-product.view', compact('categories', 'users', 'product'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Product $product)
    {
        if ($product->isApprove == "authorize") {
            abort(403);
        }
        $product = $product->where('id', $product->id)->with('weight', 'size', 'category', 'vendor', 'color.colorImage')->first();
        $categories = Category::where('parent_category_id', 0)->get();
        $users = User::where('user_type', 'vendor')->where('status', 'APPROVED')->get();

        return view('admin.vendor-product.edit', compact('categories', 'users', 'product'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param Product $product
     * @return Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        if ($product->isApprove == "authorize") {
            abort(403);
        }
        DB::transaction(function () use ($product, $request) {
            try {

                $data = $request->all();
                $data['product_sku'] = generateProductSku("$request->product_name", auth()->id());
                if ($request->hasFile('home_image')) {
                    @unlink(asset("uploads/product/$product->home_image"));
                    @unlink(asset("uploads/product/optimize/$product->home_image"));
                    $data['home_image'] = doUploadImage(substr($request->product_name, 0, 3), "uploads/product/", "$request->home_image", "uploads/product/optimize", 100, 100, "jpeg");
                }

                $product->update([
                    'vendor_id' => auth()->id(),
                    'product_name' => $data['product_name'],
                    'category_id' => $data['category_id'],
                    'product_sku' => $data['product_sku'],
                    'productPrice' => $data['productPrice'],
                    'brand_name' => $data['brand_name'],
                    'home_image' => $data['home_image'] ?? $product->home_image,
                    'description' => $data['description'],
                    'title' => $data['title'],
                    'entry_by' => auth()->id(),
                ]);
                $getColors = DB::table('color_infos')->where('product_id', $product->id)->get();
                $productColorDlt = DB::table('color_infos')->where('product_id', $product->id)->delete();

                $productWeightDlt = DB::table('weight_type')->where('product_id', $product->id)->delete();
                $productTypeDlt = DB::table('size_type')->where('product_id', $product->id)->delete();

                //if product size from request $sizeInsertIds
                if ($request->has('size_name')) {
                    foreach ($request->size_id as $key => $sizeID) {
                        if (count($product->size) > 0) {
                            if (!empty($sizeID)) {
                                $size = SizeType::where('id', $sizeID)->first();
                                $size->name = $request->size_name[$key] ?: '';
                                $size->save();
                                $sizeInsertIds[] = $size;
                            }
                        }
                    }
                    foreach ($request->size_name as $key => $value) {
                        if ($value == null) {
                            $insertedSizes = [];
                        } else {
                            $newSizeInsertIds[] = SizeType::create([
                                'name' => $value,
                                'product_id' => $product->id,
                                'softDel' => 0,
                                'status' => 1
                            ]);
                        }
                    }
                }

                //if product weight from request
                if ($request->has("weight_name")) {
                    foreach ($request->weight_id as $key => $weightId) {
                        if (count($product->weight) > 0) {
                            if (!empty($weightId)) {
                                $weight = WeightType::where('id', $weightId)->first();
                                $weight->name = $request->weight_name[$key];
                                $weight->save();
                                $weightInsertIds[] = $weight;
                            }
                        }
                    }
                    foreach ($request->weight_name as $key => $value) {
                        if ($value == null) {
                            $insertedWeights = [];
                        } else {
                            $newWeightInsertIds[] = WeightType::create([
                                'name' => $value,
                                'product_id' => $product->id,
                                'softDel' => 0,
                                'status' => 1
                            ]);
                        }
                    }
                }

                //if product color from request
                if ($request->has('color_name')) {

                    // dd(request('color_name'),$productColorDlt);
                    foreach ($getColors as $key => $colorId) {

                        if (count($product->color) > 0) {
                            if (!empty($colorId)) {
                                $colorType = ColorInfo::where('id', $colorId->id)->first();

                                $update =  $colorType->name = $request->color_name[$key];
                                $colorType->save();
                                // dd($getColors,$colorId,$update);
                                /*$colorType->name = $request->color_name[$key];
                                $colorType->save();*/
                                $newColorInsertIds[] = $update;
                                $colorImageName = \request("color_images_$key");
                                // dd($colorImageName);
                                if ($request->hasFile("color_images_$key")) {
                                    foreach ($colorImageName as $imageKey => $imageVal) {
                                        if ($request->file("color_images_$key")) {
                                            ColorImage::create([
                                                "name" => doUploadImage(Str::slug("$colorType->name") . $imageKey, "uploads/product/color", "$imageVal", "uploads/product/color/optimize", 100, 100, 'jpeg'),
                                                'color_id' => $colorType->id,
                                                'softDel' => 0,
                                                'status' => 1
                                            ]);
                                        }

                                    }
                                }
                            }
                        }
                    }
                }

                //if color table and color image table not delete
                /*if ($request->has('color_name')) {
                    foreach ($request->color_name as $key => $value) {
                        $colorTypeNewInsert = ColorInfo::where('name', $value)->first();
                        if (empty($colorTypeNewInsert)) {
                            // dd('nu');
                            // $insertedColors = [];

                            $newColorInsertIds[] = $color = ColorInfo::create([
                                'name' => $value,
                                'product_id' => $product->id,
                                'softDel' => 0,
                                'status' => 1
                            ]);

                            $colorImageName = \request("color_images_$key");

                            if ($request->hasFile("color_images_$key")) {
                                foreach ($colorImageName as $imageKey => $imageVal) {
                                    if ($request->file("color_images_$key")) {
                                        ColorImage::create([
                                            "name" => doUploadImage(Str::slug("$color->name") . $imageKey, "uploads/product/color", "$imageVal", "uploads/product/color/optimize", 100, 100, 'jpeg'),
                                            'color_id' => $color->id,
                                            'softDel' => 0,
                                            'status' => 1
                                        ]);
                                    }
                                }
                            }
                        }
                    }
                }*/
                if (count($product->color) == 0) {
                    foreach ($request->color_name as $key => $value) {

                        if ($value == null) {
                            $insertedColors = [];
                        } else {
                            $newColorInsertIds[] = $color = ColorInfo::create([
                                'name' => $value,
                                'product_id' => $product->id,
                                'softDel' => 0,
                                'status' => 1
                            ]);

                            $colorImageName = \request("color_images_$key");

                            if ($request->hasFile("color_images_$key")) {
                                foreach ($colorImageName as $imageKey => $imageVal) {
                                    if ($request->file("color_images_$key")) {
                                        ColorImage::create([
                                            "name" => doUploadImage(Str::slug("$color->name") . $imageKey, "uploads/product/color", "$imageVal", "uploads/product/color/optimize", 100, 100, 'jpeg'),
                                            'color_id' => $color->id,
                                            'softDel' => 0,
                                            'status' => 1
                                        ]);
                                    }
                                }
                            }/*else{
                                $ColorImageUpdateColorId = ColorImage::where('color_id',$getColors[$key]->id)->first();
                                dd($getColors[$key]);
                                $ColorImageUpdateColorId->update([
                                    'color_id' => $color->id,
                                ]);
                            }*/
                        }
                    }
                }

                // Insert to product_details table looping

                DB::table('product_details')->where('product_id', $product->id)->delete();

                if (empty($newSizeInsertIds)) $newSizeInsertIds = $this->createNullObject();
                if (empty($newWeightInsertIds)) $newWeightInsertIds = $this->createNullObject();
                if (empty($newColorInsertIds)) $newColorInsertIds = $this->createNullObject();

                $this->insertProductsIntoProductEntry($newSizeInsertIds, $newWeightInsertIds, $newColorInsertIds, $product, $data, isset($sizeInsertIds), isset($weightInsertIds), isset($insertedColors));
                //Note: don't know why need product_details table add color ,size, weight , product variation. Ins Sha Allah it's will be known.
                DB::commit();

            } catch (\Exception $exception) {
                DB::rollback();
                Session::flash('error', 'Unable to process request.Error:' . json_encode($exception->getFile(), true) . json_encode($exception->getLine(), true) . json_encode($exception->getMessage(), true));
                return redirect()->back();
            }
        });
        $msg = "Products updated";
        return redirect(route("products.index"))->with('success', $msg);
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
