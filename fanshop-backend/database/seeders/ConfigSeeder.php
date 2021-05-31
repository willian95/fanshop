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

            $config->shipping_name = "Darío";
            $config->shipping_last_name = "Olivera";
            $config->shipping_address = "8301 NW 66TH ST";
            $config->shipping_zip_code = "33166";
            $config->shipping_city = "MIAMI";
            $config->shipping_state = "FL";
            $config->shipping_country = "US";
            $config->shipping_phone_number = "5168374845‬";

            $config->billing_name = "Darío";
            $config->billing_last_name = "Olivera";
            $config->billing_address = "8301 NW 66TH ST";
            $config->billing_zip_code = "33166";
            $config->billing_city = "MIAMI";
            $config->billing_state = "FL";
            $config->billing_country = "US";
            $config->billing_phone_number = "5168374845‬";

            $config->name_on_card = "Dario Olivera";
            $config->card_number = "503185573445866";
            $config->card_security_code = "123";
            $config->card_expiration_month = "5";
            $config->card_expiration_year = "2025";

            $config->amazon_email = "rodriguezwillian95@gmail.com";
            $config->amazon_password = "1010Willdev*_";
            $config->amazon_two_factor = "NFUO QOFD NXEW CY4A Z2E5 FHCB GMGL CWKN JAXE 6ZZQ 2VP5 3ECQ G63A";

            $config->walmart_email = "rodriguezwillian95@gmail.com";
            $config->walmart_password = "1010Will*_";

            $config->save();
            
        }
        

    }
}
