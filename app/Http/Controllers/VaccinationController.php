<?php

namespace App\Http\Controllers;

use App\Http\Resources\SpotDetailResource;
use App\Models\Spot;
use App\Models\Society;
use App\Models\Vaccination;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VaccinationController extends Controller
{
    //

    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            "date" => "required|date_format:Y-m-d",
            "spot_id" => "required",
        ]);

        if($validator->fails()) {
            return response()->json([
                "error" => "Validation failed",
                "messages" => $validator->errors(),
            ], 422);
        }

        if(!$request->token){
            return response()->json([
                "message" => "Unauthorized user"
            ], 401);
        }

        $society = Society::where('login_tokens', $request->token)->first();

        $request['society_id'] = $society->id;

        if(!$society){
            return response()->json([
                "message" => "Unauthorized user"
            ], 401);
        }

        $consultation = Consultation::where('society_id', $society->id)->first();

        if($consultation->status !== 'accepted'){
            return \response()->json([
                "message" => "Your consultation must be accepted by doctor before"
            ], 401);
        }

        $vaccination = Vaccination::where('society_id', $society->id)->get();

        if(\sizeof($vaccination) >= 2){
            return \response()->json([
                "message" => "Society has been 2x vaccinated"
            ], 401);
        }

        if(\sizeof($vaccination) == 1) {
        $date = date_create_from_format('Y-m-d', $request->date);

        $firstVaccinationDate = date_create_from_format('Y-m-d', $vaccination[0]->date);

        $daysSinceFirstVaccination = date_diff($date, $firstVaccinationDate)->days;

        if ($daysSinceFirstVaccination < 30) {
            return response()->json([
                "message" => "Wait at least +30 days from 1st Vaccination"
            ], 401);
        }

        Vaccination::create($request->all());

        return response()->json([
            "message" => "Second vaccination registered successful"
        ], 200);
    }


        if(\sizeof($vaccination) == 0) {
            Vaccination::create($request->all());

            return response()->json([
                "message" => "First vaccination registered successful"
            ], 200);
        }

    }

    public function index(Request $request){
        if (!$request->token) {
            return response()->json([
                "message" => "Unauthorized user"
            ], 401);
        }

        $society = Society::where('login_tokens', $request->token)->first();

        if (!$society) {
            return response()->json([
                "message" => "Unauthorized user"
            ], 401);
        }

        $vaccination = Vaccination::where('society_id', $society->id)->get();

        $spots1 = Spot::where('id', $vaccination[0]->spot_id)->first();
        if(\sizeof($vaccination) >= 2){
            $spots2 = Spot::where('id', $vaccination[1]->spot_id)->first();
        }

    return \response()->json([
        "vaccinations" => [
            "first" => [
                "queue" => $vaccination[0]->id,
                "dose" => $vaccination[0]->dose,
                "vaccination_date" => $vaccination[0]->date,
                "spot" => new SpotDetailResource($spots1->loadMissing('regional'))
            ],
            "second" => (\sizeof($vaccination) >= 2) ? [
                    "queue" => $vaccination[1]->id,
                    "dose" => $vaccination[1]->dose,
                    "vaccination_date" => $vaccination[1]->date,
                    "spot" => new SpotDetailResource($spots2->loadMissing('regional'))
                ] : Null
        ]
    ]);

    }


}
