<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\ColorImage;
use App\Models\ColorInfo;
use App\Models\Product;
use App\Models\ProductEntry;
use App\Models\SizeInfo;
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
use function PHPUnit\Framework\isEmpty;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->get();
        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $categories = Category::with('parentCategory')->get();
        $users = User::where('user_type', 'vendor')->where('status', 'APPROVED')->get();
        return view('admin.product.create', compact('categories', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @return void
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
                    'vendor_id' => $data['vendor_id'],
                    'product_name' => $data['product_name'],
                    'category_id' => $data['category_id'],
                    'product_sku' => $data['product_sku'],
                    'productPrice' => $data['productPrice'],
                    'brand_name' => $data['brand_name'],
                    'home_image' => $data['home_image'] ?? '',
                    'description' => $data['description'],
                    'title' => $data['title'],
                    'status' => 'deactive',
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
        return redirect(route("product.index"))->with('success', $msg);
    }

    function createNullObject()
    {
        return ['id' => 0];
    }

    /** @noinspection DuplicatedCode */
    function insertProductsIntoProductEntry($insertedSizes, $insertedWeights, $insertedColors, $product, $data)
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


    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return Application|Factory|View
     */
    public function show(Product $product)
    {

        $product = $product->where('id', $product->id)->with('weight', 'size', 'category', 'vendor', 'color.colorImage')->first();
        $categories = Category::where('parent_category_id', 0)->get();
        $users = User::where('user_type', 'vendor')->where('status', 'APPROVED')->get();
        return view('admin.product.view', compact('categories', 'users', 'product'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return Application|Factory|View
     */
    public function edit(Product $product)
    {
        // return count( $product->color );
        if ($product->isApprove == "authorize") {
            abort(403);
        }

        $product = $product->where('id', $product->id)->with('weight', 'size', 'category', 'vendor', 'color.colorImage')->first();
        $categories = Category::where('parent_category_id', 0)->get();
        $users = User::where('user_type', 'vendor')->where('status', 'APPROVED')->get();
        return view('admin.product.edit', compact('categories', 'users', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param Product $product
     * @return Application|Redirector|RedirectResponse
     */
    public function update(ProductRequest $request, Product $product)
    {
        $request->all();

        DB::transaction(function () use ($product, $request) {
            try {

                $data = $request->all();
                $data['product_sku'] = generateProductSku("$request->product_name", auth()->id());
                if ($request->hasFile('home_image')) {
                    @unlink(asset("uploads/product/$product->home_image"));
                    @unlink(asset("uploads/product/optimize/$product->home_image"));
                    $data['home_image'] = doUploadImage(substr($request->product_name, 0, 3), "uploads/product/", "$request->home_image", "uploads/product/optimize", 100, 100, "jpeg");
                }
                $data['isApprove'] = (request()->has('isApprove') == 'authorize' ? 'authorize' : 'unauthorize');
                $product->update([
                    'vendor_id' => $data['vendor_id'],
                    'product_name' => $data['product_name'],
                    'category_id' => $data['category_id'],
                    'product_sku' => $data['product_sku'],
                    'productPrice' => $data['productPrice'],
                    'brand_name' => $data['brand_name'],
                    'home_image' => $data['home_image'] ?? $product->home_image,
                    'description' => $data['description'],
                    'title' => $data['title'],
                    'isApprove' => $data['isApprove'],
                    'entry_by' => auth()->id(),
                ]);
                $getColors = DB::table('color_infos')->where('product_id', $product->id)->get();
                //$getSizes = DB::table('size_type')->where('product_id', $product->id)->get();


                $updateColorIds = [];
                $updateSizeIds = [];
                $updateWeightIds = [];

                $removeColorObjects = json_decode($request->removeColorObjects);
                if (!empty($removeColorObjects)) {
                    foreach ($removeColorObjects as $key) {
                        ColorInfo::where('id', $key->color_id)->where('product_id', $key->product_id)->update([
                            'softDel' => 1
                        ]);
                    }

                    foreach ($removeColorObjects as $key => $removeColorObject) {
                        $productEntries = ProductEntry::where('product_id', $removeColorObject->product_id)->where('color_id', $removeColorObject->color_id)->get();
                        foreach ($productEntries as $productEntry) {
                            ProductEntry::where('id', $productEntry->id)->update([
                                'softDel' => 0
                            ]);
                        }
                    }
                }

                ///if product color from request
                if ($request->has('color_name')) {
                    foreach ($request->color_id as $key => $colorId) {
                        if (count($request->color_id) > 0) {
                            if (!empty($colorId)) {
                                $colorType = ColorInfo::where('id', $colorId)->first();
                                $update = $colorType->name = $request->color_name[$key];
                                $colorType->save();
                                $updateColorIds[] = $colorType;
                                $colorImageName = \request("color_images_$key");
                                if ($request->hasFile("color_images_$key")) {
                                    foreach ($colorImageName as $imageKey => $imageVal) {
                                        // @unlink(asset("uploads/uploads/product/color/$colorImage->name"));
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
                            } else {
                                $insertedColors[] = $color = ColorInfo::create([
                                    'name' => $request->color_name[$key],
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
                }

                // if product size id from request

                if ($request->has('size_name')) {
                    foreach ($request->size_id as $key => $value) {
                        if (!empty($value)) {
                            $sizeType = SizeType::where('id', $value)->where('product_id', $product->id)->first();
                            $sizeType->name = $request->size_name[$key];
                            $sizeType->save();
                            $updateSizeIds[] = $sizeType;
                        } else {
                            $insertedSizes[] = SizeType::create([
                                'name' => $request->size_name[$key],
                                'product_id' => $product->id,
                                'softDel' => 0,
                                'status' => 1
                            ]);
                        }

                    }
                }


                // if product weight id from request
                if ($request->has('weight_name')) {
                    foreach ($request->weight_id as $key => $value) {
                        if (!empty($value)) {
                            $weightType = WeightType::where('id', $value)->where('product_id', $product->id)->first();
                            $weightType->name = $request->weight_name[$key];
                            $weightType->save();
                            $updateWeightIds[] = $weightType;
                        } else {
                            $insertedWeights[] = WeightType::create([
                                'name' => $request->weight_name[$key],
                                'product_id' => $product->id,
                                'softDel' => 0,
                                'status' => 1
                            ]);
                        }

                    }
                }

                //dd($insertedColors);

                /// dd($insertedSizes,$insertedWeights,$updateColorIds);
                /// Insert to product_details table looping
                ///

                // Insert to product_details table looping
                if (!empty($insertedSizes) && !empty($insertedWeights) && !empty($insertedColors)) {
                    if (empty($insertedSizes)) $insertedSizes = $this->createNullObject();
                    if (empty($insertedWeights)) $insertedWeights = $this->createNullObject();
                    if (empty($insertedColors)) $insertedColors = $this->createNullObject();
                    $newSizeIds = count($product->size) > 0 ? $product->size : $insertedSizes;
                    $newWeightIds = count($product->weight) > 0 ? $product->weight : $insertedWeights;
                    $newColorsIds = count($product->color) > 0 ? $product->color : $insertedColors;
                    //dd($newSizeIds,$newWeightIds,$newColorsIds);
                    $this->insertProductsIntoProductEntry($insertedSizes, $insertedWeights, $insertedColors, $product, $data);

                }

                if (!empty($insertedSizes)) {
                    $this->insertProductsIntoProductEntry($insertedSizes, $product->weight, $product->color, $product, $data);

                }

                if (!empty($insertedColors)) {
                    $this->insertProductsIntoProductEntry($product->size, $product->weight, $insertedColors, $product, $data);

                }

                if (!empty($insertedWeights)) {
                    $this->insertProductsIntoProductEntry($product->size, $insertedWeights, $product->color, $product, $data);
                }


              //  $this->insertProductsIntoProductEntry($insertedSizes, $product->weight, $product->color, $product, $data);
              ///  $this->insertProductsIntoProductEntry($product->size, $insertedWeights, $product->color, $product, $data);


                //Note: don't know why need product_details table add color ,size, weight , product variation. Ins Sha Allah it's will be known.
                DB::commit();

            } catch (\Exception $exception) {
                DB::rollback();
                Session::flash('error', 'Unable to process request.Error:' . json_encode($exception->getFile(), true) . json_encode($exception->getLine(), true) . json_encode($exception->getMessage(), true));
                return redirect()->back();
            }
        });
        $msg = "Product updated";
        return redirect(route("product.index"))->with('success', $msg);
    }


    function updateProductsIntoProductEntry($updateSizes, $updateWeights, $updateColors, $product, $data)
    {
        if ((is_array($updateSizes) or is_array($updateWeights) or is_array($updateColors))) {
            $ddd = DB::table('product_details')->where('product_id', $product->id)->get();
            // dd($updateColors,$updateSizes, $updateWeights,$ddd);
            foreach ($updateSizes as $size) {
                foreach ($updateWeights as $weight) {
                    foreach ($updateColors as $color) {
                        $child_product = [
                            'size_id' => (is_object($size) && isset($size->id)) ? $size->id : 0,
                            'weight_id' => (is_object($weight) && isset($weight->id)) ? $weight->id : 0,
                            'color_id' => (is_object($color) && isset($color->id)) ? $color->id : 0,
                            'product_id' => $product->id,
                            'sku' => generateProductSku($product->product_name, $product->id),
                            'price' => $data['productPrice'],
                        ];
                        //  ProductEntry::create($child_product);
                    }
                }
            }
        }

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

    public function productApprovedBYAdmin(Product $product)
    {

    }
}
