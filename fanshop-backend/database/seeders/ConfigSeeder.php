<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Configuration;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        if(Configuration::count() == 0){

            $config = new Configuration;
            $config->id = 1;
            $config->max_price_without_tax = 200;
            $config->price_tax_percent = 0.22;
            $config->price_per_pound = 8;
            $config->dolar_price = 4;
            $config->earn_percentage = 0.30;
            $config->save();
            
        }
        

    }
}
