<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Purchase;

class OrderRetrieve extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:retrieve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        $purchases = Purchase::whereNotNull("zinc_api_request_id")->get();

        foreach($purchases as $purchase){

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
            curl_setopt($ch, CURLOPT_URL, "https://api.zinc.io/v1/orders/".$purchase->zinc_api_request_id);
            curl_setopt($ch, CURLOPT_USERPWD, "client_token:".env("ZINCAPI_TOKEN"));
            
            // SSL important
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $output = curl_exec($ch);
            curl_close($ch);
            
            dump(env("ZINCAPI_TOKEN"));

            dump($output);

        }

    }
}
