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
            // error_log($dataSet);
            $rest = shell_exec(
                "timeout 10s python3 ".storage_path()."/prediction/prediction_neural_network.py '".json_encode($dataSet['body'])."' ".$request->xForPrediction. " ".$request->type_package
            );
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
    public function getDataSet($type_package){
        $url = env('URL_LAMDA_PREDICTION');
        error_log($type_package);
        return Http::acceptJson()
            ->post(
                $url,
                [
                'type_package' => $type_package
                ]
            )->json();
    }

    public function getDataCoordinates($valuePrediction = 0, $type_package){
        $url = "";
        return Http::acceptJson()
            ->post(
                $url,
                [
                    "value" => $valuePrediction,
                    "type_package" => $type_package
                ]
        )->json();
    }
}