<?php

namespace App\Http\Controllers;
use App\TrayectoriaDet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EclatController extends Controller
{
    public function eclat()
    {
        return view('eclat');
    }

    public function puntos(Request $request){
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $maxAmount = $request->maxAmount;
        $support = $request->support;
        Storage::deleteDirectory('/archivos_eclat');
        Storage::makeDirectory('/archivos_eclat');

        $startDate = str_replace('T', ' ', $startDate);
        $endDate = str_replace('T', ' ', $endDate);
        $endDate = $endDate . ':59';
        $startDate = $startDate . ':00';

        $query = DB::table('inf_trayectorias_det')
        ->select(DB::raw('CONCAT((cast(longitud as varchar), cast(latitud as varchar))) as coordenadas'), DB::raw('cast(id_trayectoria as varchar)'))
        ->whereBetween('inf_trayectorias_det.fecha', [$startDate, $endDate])
        ->inRandomOrder()->limit($maxAmount)
        ->get()->toArray();

        $matrix  = [['coordenadas', 'id_trayectoria']];
        foreach ($query as $value) {
            //var_dump($value->latitud);
            array_push($matrix, [
                $value->coordenadas,
                $value->id_trayectoria
            ]);
        }

        $fecha_csv = date("H:i:s");
        $fecha_csv = str_replace(':', '_', $fecha_csv);

        $file = str_replace('\\', '/', storage_path()) . '/archivos_eclat/datainicial' . $fecha_csv . '.csv';
        $fp = fopen($file, 'w');


        foreach ($matrix as $campos) {
            fputcsv($fp, $campos);
        }
        $algorith = storage_path() . '/eclat/algoritmo.R';
        $path = str_replace('\\', '/', storage_path()) . '/archivos_eclat';
        $csv = $path . '/coordenadas-' . $fecha_csv . '.csv ';
        $graphic = $path . '/graphic.png ';
        $scatterplot = $path . '/scatterplot.png';
        fclose($fp);
        shell_exec('Rscript '. $algorith  .' '. $file . ' ' . $support . ' ' . $csv. ' ' . $graphic . ' ' . $scatterplot);
        $response = [];
        try {
            //code...
            $handle = fopen($csv, "r");
            $row = 0;
             while ($data = fgetcsv($handle)) {
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

        } catch (\Throwable $th) {
            //throw $th;
        }


        return [json_encode($response)];
    }




}
