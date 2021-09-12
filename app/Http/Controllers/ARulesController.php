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
        //$support = $request->support;
        Storage::deleteDirectory('/archivos_apriori');
        Storage::makeDirectory('/archivos_apriori');

        $startDate = str_replace('T', ' ', $startDate);
        $endDate = str_replace('T', ' ', $endDate);
        $endDate = $endDate . ':59';
        $startDate = $startDate . ':00';

        $query = DB::table('inf_trayectorias_det')
        ->select(DB::raw('id_det_tra, id_trayectoria, orden, fecha, longitud, latitud, distancia, duracion, velocidad, coordenadas, tipo_coordenada'))
        //->select(DB::raw('CONCAT((cast(longitud as varchar), cast(latitud as varchar))) as coordenadas'), DB::raw('cast(id_trayectoria as varchar)'))
        // , to_char(fecha, 'DDMMYYYYHH24') as Fecha_24H
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
        return [json_encode($puntos)];
    }

    public function algoritmo(Request $request)
    {
        $algorith = storage_path() . '/eclat/algoritmo.R';
        $path = str_replace('\\', '/', storage_path()) . '/archivos_apriori';
        $csv = $path . '/coordenadas-' . $fecha_csv . '.csv ';
        $graphic = $path . '/graphic.png ';
        $scatterplot = $path . '/scatterplot.png';
        fclose($fp);
        shell_exec('Rscript '. $algorith  .' '. $file . ' ' . $support . ' ' . $csv. ' ' . $graphic . ' ' . $scatterplot);
        $handle = fopen($csv, "r");
        $response = [];
        $row = 0;
         while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
             $num = count($data);

             if($row != 0){
                for ($c=1; $c < $num; $c+=2) {
                    $data[$c] = str_replace("{", "", $data[$c]);
                        $data[$c] = str_replace("}", "", $data[$c]);
                        $data[$c] = str_replace("(", "", $data[$c]);
                        $data[$c] = str_replace(")", "", $data[$c]);
                        $coord = explode(",", $data[$c]);
                        $json = [
                            'longitud' => $coord[0],
                            'latitud' => $coord[1]
                        ] ;
                        array_push($response, $json);

                    }
                }
                $row++;
             }

             fclose($handle);

             return [json_encode($response)];

    }

}
