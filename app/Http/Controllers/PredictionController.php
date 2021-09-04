<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;


class PredictionController extends Controller{
    
    public function getprediction(Request $request){
        $ban = true;
        $rest = [];
        do{
            $dataSet = $this->getDataSet($request->type_package);
            $rest = shell_exec(
                "timeout 5s python3 ".storage_path()."/prediction/prediction_neural_network.py '".json_encode($dataSet['body'])."' ".$request->xForPrediction
            );
            // shell_exec('kill python3');
            if($rest != null){
                $ban = false;
                error_log("Done predictions");
                // error_log(json_decode($rest,true));
            }

        }while($ban);
        // error_log(json_decode($rest)['probability']);
        return json_encode($rest);
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