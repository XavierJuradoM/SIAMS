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
        $timeout = 25;
        switch($request->type_package){
            case 'temperature':
                $timeout = 120;
                break;
            case 'distance':
                $timeout = 20;
                break;
            case 'hour': 
                $timeout = 80;
                break;
        }
        error_log($request->xForPrediction);
        do{

            $dataSet = $this->getDataSet(
                $request->type_package,
                $request->start_date,
                $request->end_date
            );
            // error_log($timeout);
            if(count($dataSet['body']) === 0 || count($dataSet['body']) <= 2000){
                return json_encode(array(
                    "insufficient" => true,
                    "size" => count($dataSet['body'])
                ));
            }
            // error_log($dataSet);
            $rest = shell_exec(
                "timeout ".$timeout."s python3 ".storage_path()."/prediction/prediction_neural_network.py '".json_encode($dataSet['body'])."' ".$request->xForPrediction. " ".$request->type_package
            );
            error_log($rest);
            if($rest != null){
                $ban = false;
                error_log("Done predictions");
                // error_log(json_decode($rest,true));
            }

        }while($ban);
        // error_log(json_decode($rest)['probability']);
        return json_encode($rest);
    }

    public function getCoordinates(Request $request){
        $response = $this->getDataCoordinates($request->valPrediction,$request->type_package);
        return $response['body'];
    }
    public function getDataSet($type_package, $start_date, $end_date){
        $url = env('URL_LAMBDA_PREDICTION');
        
        return Http::acceptJson()
            ->post(
                $url,
                [
                'type_package' => $type_package,
                'start_date' => $start_date,
                'end_date' => $end_date
                ]
            )->json();
    }

    public function getDataCoordinates(Request $request){
        $url = env('URL_LAMBDA_GET_COORDINATES');
        $response = Http::acceptJson()
            ->post(
                $url,
                [
                    "value_prediction" => $request->predictionValue,
                ]
            )->json();
        return $response;
    }
}