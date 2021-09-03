<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class PredictionController extends Controller{
    
    public function getprediction(Request $request){
        $dataSet = $this->getDataSet($request->type_package);
        return json_encode(["a"=>"hey funciona", "response"=>$dataSet]);
    }

    public function getDataSet($type_package){
        $url = 'https://5v8zqh5iua.execute-api.us-east-1.amazonaws.com/developing/prediction';
        

        return Http::acceptJson()
            ->post($url,[
            'type_package' => 'temperature'
        ])->json();


    }
    public function trainModel(){
        
    }
}