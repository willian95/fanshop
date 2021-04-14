<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Http\Requests\PasswordRestoreRequest;
use App\Http\Requests\PasswordUpdateRequest;

class PasswordRestoreController extends Controller
{
    
    function restore(PasswordRestoreRequest $request){

        try{

            $recoveryHash = Str::random(40);
            $user = User::where("email", $request->email)->first();
            $user->recoveryHash = $recoveryHash;
            $user->update();

            $this->sendRecoveryEmail($user);

            return response()->json(["success" => true, "msg" => "Mensaje enviado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Hubo un problema", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function sendRecoveryEmail($user){

        $data = ["messageMail" => "Hola ".$user->name.", haz click en el siguiente enlace para restaurar tu clave", "recoveryHash" => $user->recoveryHash];
        $to_name = $user->name;
        $to_email = $user->email;

        \Mail::send("emails.recoveryPassword", $data, function($message) use ($to_name, $to_email) {

            $message->to($to_email, $to_name)->subject("Restaura tu contraseña!");
            $message->from( env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));

        });

    }

    function verify(Request $request){

        try{

            $user = User::where("recoveryHash", $request->hash)->firstOrFail();
            
            return redirect()->away(env('FRONTEND_URL').'/password-restore?hash='.$request->hash);

        }catch(\Exception $e){
            
            dd($e);
        }

    }

    function updatePassword(PasswordUpdateRequest $request){

        $user = User::where("recoveryHash", $request->hash)->firstOrFail();
        $user->password = bcrypt($request->password);
        $user->update();

        return response()->json(["msg" => "Clave reestablecida con éxito", "success" => true]);

    }

}
