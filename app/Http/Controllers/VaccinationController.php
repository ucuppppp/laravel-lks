<?php

namespace App\Http\Controllers;

use App\Models\Vaccination;
use Illuminate\Http\Request;

class VaccinationController extends Controller
{
    //

    public function register(Request $request){

        $date = $request->date;


        $request['date'] = strtotime($date);

        $vaccination = Vaccination::create($request->all());

        \dd($vaccination);

    }


}
