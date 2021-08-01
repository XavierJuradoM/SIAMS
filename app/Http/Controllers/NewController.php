<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class NewController extends Controller
{
    public function nuevo(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string',
            'apellido' => 'required|string',
            
            'nombre' => 'required|string',            
            'cedula' => 'required|numeric',
        ]);

        $tipo = "Desarrollador";

        $client = new Client();
        $url = 'https://v3bc7qfwya.execute-api.us-east-1.amazonaws.com/PRODUCCION/signup';
        
        $headers = [
            'x-api-key' => 'LMkLjl3mELIdVmKcpoRG95pxetk5Zgg461YOytTg'
        ];

        $params = [
            'correo' => $request->email,
            'password' => $request->password,
            'apellidoPersona' => $request->apellido,
            'nombrePersona' => $request->nombre,
            'tipoUsuario' => $tipo,
            'cedulaPersona' => $request->cedula,

        ];

        $response = $client->request('POST', $url, [
            'headers' => $headers,
            'json' => $params
        ]);

        $responseBody = json_decode($response->getBody());
        //dd($responseBody);
        if($responseBody->resultCode == 200)
        {
            return  view('create')->with('message', $responseBody->resultMessage);
        }
        
            //dd($responseBody);
        if($responseBody->resultCode == 401){
            return  view('create')->with('message', $responseBody->resultMessage);
        }
        
        if($responseBody->statusCode == 400){
            return view('create')->with('message', $responseBody->body);
        }
            
        

    }
}
