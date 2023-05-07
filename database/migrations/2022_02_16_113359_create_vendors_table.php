<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('mobile')->unique();
            $table->string('nid')->unique();
            $table->string('dob');
            $table->text('present_address')->nullable();
            $table->string('vendorImage')->nullable();
            $table->string('brandImage')->nullable();
            $table->string('shop_language')->nullable();
            $table->string('shop_country')->nullable();
            $table->string('shop_currency')->nullable();
            $table->text('your_description')->nullable();
            $table->string('shop_name')->nullable();
            $table->string('trade_licence')->nullable();
            $table->string('business_start_date')->nullable();
            $table->string('tin')->nullable();
            $table->string('vat_registration')->nullable();
            $table->string('business_address')->nullable();
            $table->string('web_address')->nullable();
            $table->string('transaction_information')->nullable();
            $table->string('bankName')->nullable();
            $table->string('account_name')->nullable();
            $table->string('ac_no')->nullable();
            $table->string('branch')->nullable();
            $table->string('routing_no')->nullable();
            $table->string('vendor_category')->nullable();
            $table->string('product_category')->nullable();
            $table->string('product_sub_category')->nullable();
            $table->string('step_completed')->nullable();
            $table->string('logo')->nullable();
            $table->string('cover_photo')->nullable();
            $table->string('slug')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('softDel')->default(0);
            //vendor_id are users table id because of every users table id is a user.
            // user_id => vendor_id just name change
            $table->foreignId('vendor_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendors');
    }
}
