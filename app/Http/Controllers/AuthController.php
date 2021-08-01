<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $client = new Client();
        $url = 'https://gmb157pk4i.execute-api.us-east-1.amazonaws.com/PRODUCCION/login';
        
        $headers = [
            'x-api-key' => 'LMkLjl3mELIdVmKcpoRG95pxetk5Zgg461YOytTg'
        ];

        $params = [
            'correo' => $request->email,
            'password' => $request->password
        ];

        $response = $client->request('POST', $url, [
            'headers' => $headers,
            'json' => $params
        ]);

        $responseBody = json_decode($response->getBody());
        if($responseBody->resultCode == 200)
        {
            $request->session()->put('authenticated', time());
            return redirect()->intended('analisis');
        }
        else{
            return view('login')->with('message', '<h1>Correo o Contraseña incorrectos</h1>');
        }

    }

    public function logout(Request $request)
    {
        //remove authenticated from session and redirect to login
        $request->session()->forget('authenticated');
        $request->session()->forget('user');
        return redirect('/');
    }
}
