<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class PredeccionController extends Controller{
    
    public function getpredict(Request $request){
       $url = 'https://b28uq9h3hd.execute-api.us-east-1.amazonaws.com/default/predictionForCode';
       $client = new Client();
       $params = [

       ];
       $headers = array(
           'predictionForCode-API' => 'lh9ZIWLa238oCve8HLQrX5ACs9LFEUWSad8um0X0'
       );

       $respose = $client->request('POST', $url, [
           'params'     => $params,
           'headers'    => $headers
       ]);

       $resposeBody = json_decode($respose->getBody());
    }
}