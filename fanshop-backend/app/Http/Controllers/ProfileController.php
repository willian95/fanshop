<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Auth;

class ProfileController extends Controller
{
    
    function update(ProfileUpdateRequest $request){

        try{

            $auth = Auth::guard('api')->user() ? Auth::guard('api')->user() : Auth::user();

            if(User::where("email", $request->email)->where("id", "<>", $auth->id)->count() > 0){
                return response()->json(["success" => false, "msg" => "Éste email ya está en uso"]);
            }

            $user = User::find($auth->id);
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->name = $request->name;
            $user->lastname = $request->lastname;

            if(isset($request->password)){

                $user->password = bcrypt($request->password);

            }

            $user->update();

            return response()->json(["success" => true, "msg" => "Perfil actualizado"]);

        }catch(\Exception $e){

        }

    }

}
