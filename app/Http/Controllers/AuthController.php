<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Society;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\SocietyResource;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //

    public function login(Request $request){


        // $validator = Validator::make($request->all(), [
        //         "id_card_number" => "required",
        //         "password" => "required",
        //     ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //             "message" => $validator->errors(),
        //         ], 422);
        // }

        $society = Society::where('id_card_number', $request->id_card_number)->get();

        if(\sizeof($society) == 0){
            return response()->json([
                "message" => "ID Card Number or Password incorrect"
            ], 401);
        }

        $token = md5($society[0]->id_card_number);
        $society[0]->login_tokens = $token;
        $society[0]->save();

        if(!$society || $request->password !== $society[0]->password ){
            return response()->json([
                "message" =>"ID Card Number or Password incorrect"
            ], 401);
        }


        return \response()->json(SocietyResource::collection($society->loadMissing('regional:id,province,district'))
        , 200);

    }

    public function logout(Request $request){
        $society = Society::where('login_tokens', $request->token)->get();


        foreach($society as $social){
            if($social->login_tokens === null){
                return \response()->json([
                    "message" => "Invalid token"
                ], 401);
            }
        }

        if(!$society || $society == \null){
            return \response()->json([
                "message" => "Invalid token"
            ], 401);
        }

        if(sizeof($society) === 0 ){
            return \response()->json([
                "message" => "Invalid token"
            ], 401);
        };

        $society[0]->login_tokens = null;
        $society[0]->save();

        return response()->json([
            "message" => "Logout Success"
        ], 200);
    }


}
