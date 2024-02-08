<?php

namespace App\Http\Controllers;

use App\Models\Spot;
use App\Models\Society;
use App\Models\Vaccination;
use Illuminate\Http\Request;
use App\Http\Resources\SpotResource;
use App\Http\Resources\SpotDetailResource;

class SpotController extends Controller
{
    //
    public function index(Request $request){

        if(!$request->token){
            return \response()->json([
                "message" => "Unauthorized user"
            ]);
        }

        $society = Society::where('login_tokens', $request->token)->get();

        if(!$society || \sizeof($society) == 0){
            return \response()->json([
                "message" => "Unauthorized user"
            ]);
        }

        $spots = Spot::all();


        return response()->json([
            "spots" => SpotResource::collection($spots)
        ]);
    }


    public function show(Request $request, $id){

        if(!$request->token || $request->token == null){
            return response()->json([
                "message" => "Unauthorized user"
            ]);
        }

        $society = Society::where('login_tokens', $request->token)->get();

        if(\sizeof($society) == 0){
            return response()->json([
                "message" => "Unauthorized user"
            ]);
        }

        $spots = Spot::where('id', $id)->first();

        $vaccination = Vaccination::where('spot_id', $id)->get();

        if($request->date){
            $vaccination = Vaccination::where('spot_id', $id)->where('date', $request->date)->get();
            if(!$vaccination || \sizeof($vaccination) == 0){
                return \abort(404);
            }
        }

        $date = $vaccination[0]->date;

        $date = date("F j, Y", strtotime($date));
        $vaccinations_count = \sizeof($vaccination);

        return \response()->json([
            "date" => $date,
            "spot" => new SpotDetailResource($spots),
            "vaccinations_count" =>$vaccinations_count
        ]);
    }

}
