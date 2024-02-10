<?php

namespace App\Http\Controllers;

use App\Models\Society;
use App\Models\Consultation;
use Illuminate\Http\Request;
use App\Http\Resources\ConsultationResource;
use GuzzleHttp\Promise\Create;
use Illuminate\Validation\ValidationException;

class ConsultationController extends Controller
{
    //


    public function store(Request $request)
    {
        try {
            $request->validate([
                "disease_history" => "required",
                "current_symptoms" => "required",
            ]);

            if ($request->token === null) {
                return \response()->json([
                    "message" => "Unauthorized user"
                ]);
            }

            $society = Society::where('login_tokens', $request->token)->get();


            if ($society->isEmpty()) {
                return \response()->json([
                    "message" => "Unauthorized user"
                ]);
            }

            $request['society_id'] = $society[0]->id;

            Consultation::create($request->all());

            return \response()->json([
                "message" => "Request consultation sent successful"
            ], 200);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        }
    }



    public function show(Request $request){

        $society = Society::where('login_tokens', $request->token)->first();

        if(!$society){
            return \response()->json([
                "message" => "Unauthorized token"
            ], 401);
        }


        $consultation = Consultation::where('society_id', $society->id)->get();

        if(\sizeof($consultation) > 1){
            return \response()->json([
                "consultations" => ConsultationResource::collection($consultation)
            ]);
        }

        if(!\sizeof($consultation)){
            return \response()->json([
                "message" => "Unauthorized token"
            ], 401);
        }

        return response()->json([
            "consultation" => ConsultationResource::collection($consultation)
        ]);

    }

}
