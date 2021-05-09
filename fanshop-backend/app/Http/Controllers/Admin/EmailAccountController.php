<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminEmailAccount;
use App\Http\Requests\AdminEmailAccountRequest;

class EmailAccountController extends Controller
{
    
    function fetch(){

        return response()->json(["adminEmailAccounts" => AdminEmailAccount::all()]);

    }

    function store(AdminEmailAccountRequest $request){

        try{

            $emailAccount = new AdminEmailAccount;
            $emailAccount->email = $request->email;
            $emailAccount->save();

            return response()->json(["success" => true, "msg" => "Email administrativo creado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Algo salió mal", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function update(AdminEmailAccountRequest $request){

        try{

            $emailAccount = AdminEmailAccount::find($request->id);
            $emailAccount->email = $request->email;
            $emailAccount->update();

            return response()->json(["success" => true, "msg" => "Email administrativo actualizado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Algo salió mal", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function delete(Request $request){

        try{

            $emailAccount = AdminEmailAccount::find($request->id);
            $emailAccount->delete();

            return response()->json(["success" => true, "msg" => "Email administrativo eliminado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Algo salió mal", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

}
