<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ContraseñaController extends Controller
{
    public function contra(Request $request)
    {

        $client = new Client();
        $url = 'https://v6n75m4588.execute-api.us-east-1.amazonaws.com/PRODUCCION/forgotpassword';
        
        $headers = [
            'x-api-key' => 'LMkLjl3mELIdVmKcpoRG95pxetk5Zgg461YOytTg'
        ];

        $params = [
            'correo' => $request->email,            
        ];

        $response = $client->request('POST', $url, [
            'headers' => $headers,
            'json' => $params
        ]);

        $responseBody = json_decode($response->getBody());
        //dd($responseBody);
        if($responseBody->resultCode == 200)
        {
            return  view('nueva_contrasena');
        }
        else{
            if(!empty($responseBody->resultCode)){
                return view('contrasena')->with('message', 'Asegurese de ingresar correo institucional');
            }
            else{
            //dd($responseBody);
            return  view('contrasena')->with('message', $responseBody->body);
            }
        }
        
    }

    public function nuevaContra(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string',
            'codigo' => 'required|string',
            
        ]);

        $client = new Client();
        $url = 'https://nb67p86xh9.execute-api.us-east-1.amazonaws.com/PRODUCCION/confirmforgotpassword';
        
        $headers = [
            'x-api-key' => 'LMkLjl3mELIdVmKcpoRG95pxetk5Zgg461YOytTg'
        ];

        $params = [
            'correo' => $request->email,      
            'codigoconfirmacion'=> $request->codigo,
            'nuevopassword'=> $request->password,
        ];

        $response = $client->request('POST', $url, [
            'headers' => $headers,
            'json' => $params
        ]);

        $responseBody = json_decode($response->getBody());
        //dd($responseBody);
        if($responseBody->resultCode == 200)
        {
            return  view('mensaje');
        }
        else{
            //dd($responseBody);
            return  view('nueva_contrasena')->with('message', $responseBody->body);
        }

        
    }
}
