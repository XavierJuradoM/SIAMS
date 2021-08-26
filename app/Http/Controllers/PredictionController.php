<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PredeccionController extends Controller{
    
    public function getpredict(Request $request){
        print_r($request);

        $query = DB::table('GEN_CLIMAS');
    }
}