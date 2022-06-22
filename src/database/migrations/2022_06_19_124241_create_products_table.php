<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->unsignedBigInteger('unique_id')->nullable();

            $table->string('slug')->nullable();
            $table->string('name');

            $table->text('description')->nullable();

            $table->text('delivery_area')->nullable();

            $table->string('featured_image')->nullable();



            $table->string('price')->nullable();

            $table->integer('quantity')->nullable();
            $table->string('unit')->nullable();
            //text_percent changed to sold_amount.
            $table->integer( 'sold_amount')->nullable();
            $table->integer('vat_percent')->nullable();
            $table->integer('discount')->nullable();
            $table->boolean('is_sold_out')->default(0);
            $table->boolean('is_featured')->default(0);
            $table->boolean('is_active')->default(1);
            $table->boolean('is_deleted')->default(0);

            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            //$table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');


            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('products');
    }
};
