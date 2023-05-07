<?php
// vendor Routes
use App\Http\Controllers\Admin\ApprovedPurchaseController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VendorProductAddedController;
use App\Http\Controllers\Admin\VendorProductPurchaseController;
use App\Http\Controllers\Admin\VendorPurchaseReturnController;
use App\Http\Controllers\Vendor\VendorController;
use App\Http\Controllers\Vendor\VendorDiscountCampaignController;
use Illuminate\Support\Facades\Route;

//VENDOR PENDING_INFO_ENTRY
Route::prefix('vendor')->middleware(['auth'])->group(function(){
    Route::get('/dashboard',DashboardController::class)->name('dash');
    Route::resource('/products',VendorProductAddedController::class);
    Route::resource('/purchases',VendorProductPurchaseController::class);
    Route::post('/approved-purchases',[ApprovedPurchaseController::class,'index'])->name('purchases-approved');

    Route::resource('/purchase-returns',VendorPurchaseReturnController::class);

    Route::get('personal-information/',[VendorController::class,'create'])->name('vendor-information');
    Route::post('personal-information/',[VendorController::class,'store'])->name('vendor-information.store');
    Route::post('category-specification', [CategoryController::class,'specification'])->name('is-specification');

    Route::get('/discount-campaign-offer',[VendorDiscountCampaignController::class,'index'])->name('campaign-offer.index');
    Route::get('/discount-campaign-offer/{discountCampaign}/view',[VendorDiscountCampaignController::class,'create'])->name('campaign-offer.view');
    Route::post('/discount-campaign-offer/{discountCampaign}/view',[VendorDiscountCampaignController::class,'store'])->name('campaign-offer.store');
    Route::get('/discount-campaign/vendor-campaign-list',[VendorDiscountCampaignController::class,'myDiscountCampaign'])->name('vendor-campaign-list.all');
    Route::get('/discount-campaign-offer/{discountCampaign}/view/{vendorDiscountCampaign}/edit',[VendorDiscountCampaignController::class,'edit'])->name('campaign-offer.edit');
    Route::post('/discount-campaign-offer/{discountCampaign}/view/{vendorDiscountCampaign}/edit',[VendorDiscountCampaignController::class,'update'])->name('campaign-offer.update');

//common ajax request link vendor
    Route::post("vendor-categories-products-list",[VendorDiscountCampaignController::class,'categoriesProducts'])->name('vendor-categories-products');
});
