<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class PredeccionController extends Controller{
    
    public function getprediction(Request $request){
        $dataSet = $this->getDataSet("");
    }

    public function getDataSet($type_package){
        $url = 'https://5v8zqh5iua.execute-api.us-east-1.amazonaws.com/developing/prediction';
        $client = new Client();
        $params = [
            'type_package' => $type_package
        ];
        $headers = array(
            
        );

        $respose = $client->request('POST', $url, [
            'params'     => $params,
            'headers'    => $headers
        ]);

        $resposeBody = json_decode($respose->getBody());
    }
    public function trainModel(){
        
    }
}