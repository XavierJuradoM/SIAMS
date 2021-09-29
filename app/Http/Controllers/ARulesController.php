<?php

namespace App\Http\Controllers;
use App\TrayectoriaDet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ARulesController extends Controller
{
    public function A_rules()
    {
        return view('A_rules');
    }
    public function puntos(Request $request){
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $maxAmount = $request->maxAmount;
        Storage::deleteDirectory('/archivos_apriori');
        Storage::makeDirectory('/archivos_apriori');

        $startDate = str_replace('T', ' ', $startDate);
        $endDate = str_replace('T', ' ', $endDate);
        $endDate = $endDate . ':59';
        $startDate = $startDate . ':00';

        $query = DB::table('inf_trayectorias_det')
        ->select(DB::raw('id_det_tra, id_trayectoria, orden, fecha, longitud, latitud, distancia, duracion, velocidad, coordenadas, tipo_coordenada'))
        ->whereBetween('inf_trayectorias_det.fecha', [$startDate, $endDate])
        ->inRandomOrder()->limit($maxAmount)
        ->get()->toArray();    
        $matrix  = [['id_det_tra', 'id_trayectoria', 'orden', 'fecha', 'longitud', 'latitud', 'distancia', 'duracion', 'velocidad', 'coordenadas', 'tipo_coordenada']];
        foreach ($query as $value) {
            //var_dump($value->latitud);
            array_push($matrix, [
                $value->id_det_tra,
                $value->id_trayectoria,
                $value->orden,
                $value->fecha,
                $value->longitud,
                $value->latitud,
                $value->distancia,
                $value->duracion,
                $value->velocidad,
                $value->coordenadas,
                $value->tipo_coordenada
            ]);
        }
        $fecha_csv = date("dmy_H:m:s");
        $fecha_csv = str_replace(':', '_', $fecha_csv);
        $file = str_replace('\\', '/', storage_path()) . '/archivos_apriori/coordenadas-' . $fecha_csv . '.csv';
        $fp = fopen($file, 'w');
        foreach ($matrix as $campos) {
            fputcsv($fp, $campos);
        }

        $path = str_replace('\\', '/', storage_path()) . '/archivos_apriori';
        $csv = $path . '/coordenadas-' . $fecha_csv . '.csv ';
        fclose($fp);
        $puntos = array_slice($matrix, 1);

        // return [json_encode($puntos)];    
        return json_encode(array(
            "puntos" => $puntos,
            "fecha_csv" => $fecha_csv
        ));
    }

    public function preanalisis(Request $request)
    {
        $fecha = $request->fecha_env;
        $path =str_replace('\\', '/', storage_path()) . '/archivos_apriori';
        $csv = $path . '/coordenadas-' . $fecha . '.csv';
        $cluster = $request->num_cluster;
        $salida = shell_exec('python "'. env('AR_KMEANS') .'" "'. $csv . '" ' . $cluster);
        echo 'python '. env('AR_KMEANS') .' '.  $csv . ' ' . $cluster;
        $ayuda = 'python "'. env('AR_KMEANS') .'" "'. $csv . '" ' . $cluster;
        json_encode($ayuda);
        //return [json_encode($salida)];//, json_encode($centroides)];
        //return json_encode($salida);
    }
    public function algoritmo(Request $request)
    {
        $fecha = $request->fecha_env;
        $path = str_replace('\\', '/', storage_path()) . '/archivos_apriori';
        $csv = $path . '/coordenadas-' . $fecha . '.csv';
        $support = $request->var_support;
        $confidence = $request->var_confidence;
        $lift = $request->var_lift;
        $salida = shell_exec('python "'. env('AR_APRIORI') .'" "'. $csv . '" ' . $support. ' ' .$confidence. ' ' .$lift);
        //echo 'python "'. env('AR_APRIORI') .'" "'. $csv . '" ' . $support. ' ' .$confidence. ' ' .$lift;
       // $Texto = 'python "'. env('AR_APRIORI') .'" "'. $csv . '" ' . $support. ' ' .$confidence. ' ' .$lift;    
        return json_encode($salida);
        //$response = [];
        //return [json_encode($Texto)];

    }

}
