<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->integer('id',3)->change('');
            $table->foreignId('vendor_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('category-id')->constrained('category')->onUpdate('cascade')->onDelete('cascade');
            $table->string('percent')->nullable();
            $table->string('slug')->nullable();// slug for use url encryption
            $table->boolean('vendor_status')->nullable();// all vendor status if all vendor  true else check vendor  false
            $table->boolean('status')->nullable();
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
        Schema::dropIfExists('commissions');
    }
}
