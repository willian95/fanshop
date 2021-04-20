<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MercadoPagoDetailedStatusMessage as Status;

class MercadoPagoDetailedStatusMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!$this->checkIfIdExists(1)){
            $status = new Status;
            $status->id = 1;
            $status->status = "accredited";
            $status->description  = "¡Listo! Se acreditó tu pago. En tu resumen verás el cargo de /amount/";
            $status->save();
        }

        if(!$this->checkIfIdExists(2)){
            $status = new Status;
            $status->id = 2;
            $status->status = "pending_contingency";
            $status->description  = "Estamos procesando tu pago. No te preocupes, menos de 2 días hábiles te avisaremos por e-mail si se acreditó.";
            $status->save();
        }

        if(!$this->checkIfIdExists(3)){
            $status = new Status;
            $status->id = 3;
            $status->status = "pending_review_manual";
            $status->description  = "Estamos procesando tu pago. No te preocupes, menos de 2 días hábiles te avisaremos por e-mail si se acreditó o si necesitamos más información.";
            $status->save();
        }

        if(!$this->checkIfIdExists(4)){
            $status = new Status;
            $status->id = 4;
            $status->status = "cc_rejected_bad_filled_card_number";
            $status->description  = "Revisa el número de tarjeta.";
            $status->save();
        }

        if(!$this->checkIfIdExists(5)){
            $status = new Status;
            $status->id = 5;
            $status->status = "cc_rejected_bad_filled_date";
            $status->description  = "Revisa la fecha de vencimiento.";
            $status->save();
        }

        if(!$this->checkIfIdExists(6)){
            $status = new Status;
            $status->id = 6;
            $status->status = "cc_rejected_bad_filled_other";
            $status->description  = "Revisa los datos.";
            $status->save();
        }

        if(!$this->checkIfIdExists(7)){
            $status = new Status;
            $status->id = 7;
            $status->status = "cc_rejected_bad_filled_security_code";
            $status->description  = "Revisa el código de seguridad de la tarjeta.";
            $status->save();
        }

        if(!$this->checkIfIdExists(8)){
            $status = new Status;
            $status->id = 8;
            $status->status = "cc_rejected_blacklist";
            $status->description  = "No pudimos procesar tu pago.";
            $status->save();
        }

        if(!$this->checkIfIdExists(9)){
            $status = new Status;
            $status->id = 9;
            $status->status = "cc_rejected_call_for_authorize";
            $status->description  = "Debes autorizar ante /payment_method_id/ el pago de /amount/.";
            $status->save();
        }

        if(!$this->checkIfIdExists(10)){
            $status = new Status;
            $status->id = 10;
            $status->status = "cc_rejected_card_disabled";
            $status->description  = "Llama a /payment_method_id/ para activar tu tarjeta o usa otro medio de pago. El teléfono está al dorso de tu tarjeta.";
            $status->save();
        }

        if(!$this->checkIfIdExists(11)){
            $status = new Status;
            $status->id = 11;
            $status->status = "cc_rejected_card_error";
            $status->description  = "No pudimos procesar tu pago.";
            $status->save();
        }

        if(!$this->checkIfIdExists(12)){
            $status = new Status;
            $status->id = 12;
            $status->status = "cc_rejected_duplicated_payment";
            $status->description  = "Ya hiciste un pago por ese valor. Si necesitas volver a pagar usa otra tarjeta u otro medio de pago.";
            $status->save();
        }

        if(!$this->checkIfIdExists(13)){
            $status = new Status;
            $status->id = 13;
            $status->status = "cc_rejected_high_risk";
            $status->description  = "Tu pago fue rechazado. Elige otro de los medios de pago.";
            $status->save();
        }

        if(!$this->checkIfIdExists(14)){
            $status = new Status;
            $status->id = 14;
            $status->status = "cc_rejected_insufficient_amount";
            $status->description  = "Tu /payment_method_id/ no tiene fondos suficientes.";
            $status->save();
        }

        if(!$this->checkIfIdExists(15)){
            $status = new Status;
            $status->id = 15;
            $status->status = "cc_rejected_invalid_installments";
            $status->description  = "/payment_method_id/ no procesa pagos en /installments/ cuotas.";
            $status->save();
        }

        if(!$this->checkIfIdExists(16)){
            $status = new Status;
            $status->id = 16;
            $status->status = "cc_rejected_max_attempts";
            $status->description  = "Llegaste al límite de intentos permitidos. Elige otra tarjeta u otro medio de pago.";
            $status->save();
        }

        if(!$this->checkIfIdExists(17)){
            $status = new Status;
            $status->id = 17;
            $status->status = "cc_rejected_other_reason";
            $status->description  = "/payment_method_id/ no procesó el pago.";
            $status->save();
        }
        

    }

    function checkIfIdExists($id){

        if(Status::where("id", $id)->exists()){
            return true;
        }

        return false;

    }
}
