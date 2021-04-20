<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Str;
use Auth;
use Carbon\Carbon;

class RegisterController extends Controller
{
    
    function register(RegisterRequest $request){

        try{

            $registerHash = Str::random(40);

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->lastname = $request->lastname;
            $user->password = bcrypt($request->password);
            $user->registerHash = $registerHash;
            $user->role_id = 2;
            $user->save();

            $this->sendRegisterEmail($user);

            return response()->json(["success" => true, "msg" => "Usuario registrado exitosamente"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Hubo un problema", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function sendRegisterEmail($user){

        $data = ["messageMail" => "Hola ".$user->name.", haz click en el siguiente enlace para validar tu cuenta", "registerHash" => $user->registerHash];
        $to_name = $user->name;
        $to_email = $user->email;

        \Mail::send("emails.register", $data, function($message) use ($to_name, $to_email) {

            $message->to($to_email, $to_name)->subject("¡Valida tu correo!");
            $message->from( env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));

        });

    }

    function resendEmail(Request $request){

        $auth = Auth::guard('api')->user() ? Auth::guard('api')->user() : Auth::user();
        $user = User::find($auth->id);

        if($user->register_hash == null){
            $this->sendRegisterEmail($user);
            return response()->json(["success" => true, "msg" => "Email reenviado"]);
        }else{
            return response()->json(["success" => false, "msg" => "Email validado anteriormente"]);
        }

    }

    function verify(Request $request){

        try{

            $user = User::where("registerHash", $request->hash)->firstOrFail();
            $user->registerHash = null;
            $user->email_verified_at = Carbon::now();
            $user->update();
            
            return redirect()->away(env('FRONTEND_URL').'/login');

        }catch(\Exception $e){
            
            dd($e);
        }

    }

}
