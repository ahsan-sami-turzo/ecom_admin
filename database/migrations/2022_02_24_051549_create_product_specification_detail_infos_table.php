<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSpecificationDetailInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_specification_detail_infos', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('specification_detail_name')->nullable();
            $table->string('entry_user_type')->nullable();
            $table->integer('category_id');
            $table->integer('user_id');
            $table->string('status')->nullable();
            $table->boolean('softDel')->default(0);
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
        Schema::dropIfExists('product_specification_detail_infos');
    }
}
