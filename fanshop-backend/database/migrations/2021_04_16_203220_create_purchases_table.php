<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->float("total");
            $table->string("mercado_pago_status")->nullable();
            $table->string("payment_gateway")->default("mercado_pago");
            $table->string("mercado_pago_id")->nullable();
            $table->string("mercado_pago_status_detail")->nullable();
            $table->timestamps();

            $table->foreign("user_id")->references("id")->on("users");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
