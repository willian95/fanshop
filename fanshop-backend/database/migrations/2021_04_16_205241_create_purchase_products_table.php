<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("product_id");
            $table->float("unit_price");
            $table->integer("amount");
            $table->boolean("destination_payment")->default(0);
            $table->unsignedBigInteger("purchase_id");
            $table->timestamps();

            $table->foreign("product_id")->references("id")->on("products");
            $table->foreign("purchase_id")->references("id")->on("purchases");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_products');
    }
}
