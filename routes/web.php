<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Auth::routes(['verify' => true,'register'=>false]);


use App\Http\Controllers\Admin\AdvertisementController;
use App\Http\Controllers\Admin\ApprovedPurchaseController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryAsideNavbarController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CategoryTopNavbarController;
use App\Http\Controllers\Admin\CategoryWiseCommissionController;
use App\Http\Controllers\Admin\ColorInfoController;
use App\Http\Controllers\Admin\CommissionController;
use App\Http\Controllers\Admin\ConditionTypeController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DemoAddController;
use App\Http\Controllers\Admin\DiscountCampaignController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\FeatureDisplayProductAjaxController;
use App\Http\Controllers\Admin\FeatureNameController;
use App\Http\Controllers\Admin\FeatureProductController;
use App\Http\Controllers\Admin\FeatureProductControllerSearching;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FeaturedCategoryController;
use App\Http\Controllers\Admin\ProductAuthorizeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductController_31_07_2022_backup;
use App\Http\Controllers\Admin\ProductSpecificationDetailInfoController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\PurchaseReturnController;
use App\Http\Controllers\Admin\RequestVendorDiscountCampaignController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SizeInfoController;
use App\Http\Controllers\Admin\SizeTypeController;
use App\Http\Controllers\Admin\TermsConditionController;
use App\Http\Controllers\Admin\UnityOfMeasurementController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VendorListController;
use App\Http\Controllers\Admin\VendorProductController;
use App\Http\Controllers\Admin\VendorProductPurchaseReturnController;
use App\Http\Controllers\Admin\VendorPurchaseController;
use App\Http\Controllers\Admin\WeightInfoController;
use App\Http\Controllers\Admin\WeightTypeController;
use App\Http\Controllers\Amin\ProductSpecificationDetailsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Vendor\VendorDiscountCampaignController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});
Route::get('/add-row',[DemoAddController::class,'index']);
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::prefix('admin')->middleware(['auth','vendorAuth'])->group(function() {
   // Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard',DashboardController::class)->name('dash');
    Route::resource('/roles', RoleController::class);
    Route::resource('/user', UserController::class);
    Route::resource('/category', CategoryController::class);
    Route::resource('/featured-category', FeaturedCategoryController::class);
    Route::resource('/category-top-navbar', CategoryTopNavbarController::class);
    Route::resource('/category-aside-navbar', CategoryAsideNavbarController::class);
    Route::resource('/color-info', ColorInfoController::class);
    Route::resource('/size-type', SizeTypeController::class);
    Route::resource('/size-info', SizeInfoController::class);
    Route::resource('/weight-type', WeightTypeController::class);
    Route::resource('/weight-info', WeightInfoController::class);
    Route::resource('/product-specification-details', ProductSpecificationDetailsController::class);
    Route::post('specification-detail-name', [ProductSpecificationDetailsController::class,'getName'])->name('speication-detail-name');
    Route::resource('/product-specification-info', ProductSpecificationDetailInfoController::class);
    Route::resource('/commission', CommissionController::class);
    Route::resource('/language', LanguageController::class);
    Route::resource('/country', CountryController::class);
    Route::post('commission-is-all-vendor', CategoryWiseCommissionController::class)->name('commission-isall-vendor');
    Route::resource('/product',ProductController::class);
    Route::resource('/unity-of-measurement',UnityOfMeasurementController::class);
    Route::resource('/brand',BrandController::class);
    Route::resource('/feature-name',FeatureNameController::class);
    Route::resource('/feature-product',FeatureProductController::class);
    Route::resource('/banner',BannerController::class);
    Route::resource('/advertisement',AdvertisementController::class);
    Route::resource('/condition-type',ConditionTypeController::class);
    Route::resource('/terms',TermsConditionController::class);
    Route::resource('/purchase',PurchaseController::class);
    Route::post('/approved-purchase',[ApprovedPurchaseController::class,'index'])->name('purchase-approved');
    Route::resource('/purchase-return',PurchaseReturnController::class);
    Route::get('/vendor-active-list',[VendorListController::class,'active'])->name('vendor.active.list');
    Route::get('/vendor-pending-list',[VendorListController::class,'pending'])->name('vendor.pending.list');
    Route::get('/vendor-pending/{vendor}/show',[VendorListController::class,'show'])->name('vendor.approve');
    Route::post('/vendor-pending/{vendor}/show',[VendorListController::class,'approveStatusStore'])->name('vendor.approve.store');
    Route::resource('/discounts',DiscountController::class);
    Route::resource('/coupons',CouponController::class);
    Route::resource('/discount-campaign',DiscountCampaignController::class);
    Route::get('vendor-campaign-request-list',[VendorDiscountCampaignController::class,'requestDiscountCampaign'])->name('all-vendor-campaign.all');
    Route::get('/discount-campaign-request/{discountCampaign}/view/{vendorDiscountCampaign}/show',[RequestVendorDiscountCampaignController::class,'view'])->name('request-campaign-offer.view');
    Route::post('/discount-campaign-request/{discountCampaign}/view/{vendorDiscountCampaign}/show',[RequestVendorDiscountCampaignController::class,'accept'])->name('request-campaign-offer.accept');



//ajax request
    Route::post('has-product-category', [CategoryController::class,'hasProduct'])->name('is-product');
    Route::post('has-category-variant', [CategoryController::class,'hasVariant'])->name('is-variation');
    Route::post('category-specification', [CategoryController::class,'specification'])->name('is-specification');
//feature product add searching ajax request
    Route::post("vendor-category-list",[FeatureProductControllerSearching::class,'index'])->name('vendor-categories-list');
    Route::post("category-products-list",[FeatureProductControllerSearching::class,'categoryProducts'])->name('category-products');
    Route::post("feature-name-products-list",[FeatureProductControllerSearching::class,'featureNameProducts'])->name('feature-name-products');
    Route::post("feature-display-products-list",[FeatureDisplayProductAjaxController::class,'index'])->name('feature-display-products');
    Route::post("vendor-product-list",[VendorProductController::class,'vendorProduct'])->name('vendor-products-list');
    Route::post("vendor-purchases-list",[VendorProductController::class,'vendorPurchases'])->name('vendor-purchase-list');
    Route::post("vendor-purchases-product-list",[VendorProductController::class,'vendorPurchaseProducts'])->name('vendor-active-purchase-products-list');

});
//common ajax request link admin/vendor
Route::middleware(['auth'])->group(function (){
    Route::post('/product/authorize/{product}/update',[ProductAuthorizeController::class,'authorizeUpdate'])->name('authorize-update');
    Route::post("vendor-product-color-list",[VendorProductController::class,'productColorName'])->name('vendor-products-color-list');
    Route::post("vendor-product-size-list",[VendorProductController::class,'productSizeName'])->name('vendor-products-size-list');
    Route::post("vendor-product-weight-list",[VendorProductController::class,'productWeightName'])->name('vendor-products-weight-list');
    Route::post("vendor-purchase-products-list",[VendorPurchaseController::class,'vendorPurchaseProduct'])->name('vendor-purchase-products');
    Route::post("vendor-purchase-return-product-list",[VendorProductPurchaseReturnController::class,'vendorPurchaseProduct'])->name('vendor-purchase-return-products-list');
    Route::post("vendor-purchase-return",[VendorProductPurchaseReturnController::class,'vendorPurchaseReturns'])->name('vendor-purchase-return-list');
    Route::post('/purchase-quantity',[PurchaseReturnController::class,'get_purchase_quantity'])->name('get-purchase-quantity');
    Route::post('/purchase-stock-quantity',[PurchaseReturnController::class,'get_purchase_stock'])->name('get-purchase-stock-quantity');
   // Route::post('/purchase-stock-quantity',[PurchaseReturnController::class,'productsPurchaseInfo'])->name('vendor-products-purchase-info');
});


