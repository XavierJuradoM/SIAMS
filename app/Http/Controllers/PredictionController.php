<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class PredictionController extends Controller{
    
    public function getprediction(Request $request){
        $dataSet = $this->getDataSet($request->type_package);
   
        $rest = shell_exec("timeout 10s python3 ".storage_path()."/prediction/prediction_neural_network.py '".json_encode($dataSet['body'])."' 02");
        return json_encode(
            [
                "a"=>"hey funciona", 
                "response" => $dataSet['body'],
                // "data"=> "python3 ".storage_path()."/prediction/prediction_neural_network.py '".json_encode($dataSet['body'])."'"
                "python" => $rest
            ]
        );
    }

    public function getDataSet($type_package){
        $url = env('URL_LAMDA_PREDICTION');
        
        return Http::acceptJson()
            ->post($url,[
            'type_package' => 'temperature'
        ])->json();
        

    }
    public function trainModel(){
        
    }
}