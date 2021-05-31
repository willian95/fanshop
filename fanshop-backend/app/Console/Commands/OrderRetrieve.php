<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Purchase;
use App\Models\AdminEmailAccount;

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
        
        $amazonPurchases = Purchase::whereNotNull("zinc_api_request_id")->where("zinc_api_code", "request_processing")->with("purchaseProducts")->get();
        $walmartPurchases = Purchase::whereNotNull("zinc_api_walmart_request_id")->where("zinc_api_walmart_code", "request_processing")->with("purchaseProducts")->get();

        foreach($amazonPurchases as $purchase){

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
            curl_setopt($ch, CURLOPT_URL, "https://api.zinc.io/v1/orders/".$purchase->zinc_api_request_id);
            curl_setopt($ch, CURLOPT_USERPWD, env("ZINCAPI_TOKEN").":");
            
            // SSL important
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $output = curl_exec($ch);
            curl_close($ch);

            $response = json_decode($output);

            $purchase = Purchase::find($purchase->id);
            //dump($purchase->zinc_api_code);
            //dump($response->code);
            if($purchase->zinc_api_code != $response->code){


                $purchase->zinc_api_code = $response->code;
                $purchase->zinc_api_message = $response->message;
                $purchase->update();

                $this->sendAdminEmail($purchase);

            }

        }

        foreach($walmartPurchases as $purchase){

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
            curl_setopt($ch, CURLOPT_URL, "https://api.zinc.io/v1/orders/".$purchase->zinc_api_request_id);
            curl_setopt($ch, CURLOPT_USERPWD, env("ZINCAPI_TOKEN").":");
            
            // SSL important
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $output = curl_exec($ch);
            curl_close($ch);

            $response = json_decode($output);

            $purchase = Purchase::find($purchase->id);
            //dump($purchase->zinc_api_code);
            //dump($response->code);
            if($purchase->zinc_api_code != $response->code){


                $purchase->zinc_api_walmart_code = $response->code;
                $purchase->zinc_api_walmart_message = $response->message;
                $purchase->update();

                $this->sendAdminEmail($purchase);

            }

        }

    }

    function sendAdminEmail($purchase){

        foreach(AdminEmailAccount::all() as $adminEmailAccount){

            $data = ["code" => $purchase->zinc_api_code, "apimessage" => $purchase->zinc_api_message, "purchasedProducts" => $purchase->purchaseProducts, "purchaseProducts", "purchaseIndex" => $purchase->purchase_index];
            $to_name = "Admin";
            $to_email = $adminEmailAccount->email;

            \Mail::send("emails.adminPurchaseNotification", $data, function($message) use ($to_name, $to_email) {

                $message->to($to_email, $to_name)->subject("¡Una compra ha actualizado su estado!");
                $message->from( env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));

            });

        }

    }

}
