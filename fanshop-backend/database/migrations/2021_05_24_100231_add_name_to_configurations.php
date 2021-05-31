<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameToConfigurations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {

            $table->string("shipping_name")->nullable();
            $table->string("shipping_last_name")->nullable();
            $table->string("shipping_address")->nullable();
            $table->string("shipping_zip_code")->nullable();
            $table->string("shipping_city")->nullable();
            $table->string("shipping_state")->nullable();
            $table->string("shipping_country")->nullable();
            $table->string("shipping_phone_number")->nullable();

            $table->string("billing_name")->nullable();
            $table->string("billing_last_name")->nullable();
            $table->string("billing_address")->nullable();
            $table->string("billing_zip_code")->nullable();
            $table->string("billing_city")->nullable();
            $table->string("billing_state")->nullable();
            $table->string("billing_country")->nullable();
            $table->string("billing_phone_number")->nullable();

            $table->string("name_on_card")->nullable();
            $table->string("card_number")->nullable();
            $table->string("card_security_code")->nullable();
            $table->string("card_expiration_month")->nullable();
            $table->string("card_expiration_year")->nullable();

            $table->string("amazon_email")->nullable();
            $table->string("amazon_password")->nullable();
            $table->string("amazon_two_factor")->nullable();

            $table->string("walmart_email")->nullable();
            $table->string("walmart_password")->nullable();

 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('configurations', function (Blueprint $table) {
            //
        });
    }
}
