<?php

namespace App\Http\Controllers;

use App\Trayectoria;
use App\TrayectoriaDet;
use App\Clima;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;

class CoordenadasController extends Controller
{

    public function puntos(Request $request)
    {

        $filtro = explode(", ", $request->tipo_filtro);

        $fecha = $request->fecha;

        /*$this->validate($request, [
            $fecha => 'required|datetime-local',
        ]);*/

        if ($fecha == '') {
            $fecha = date("Y-m-d H:i:s");
        } else {
            $fecha = str_replace('T', ' ', $fecha);
            $fecha_fin = $fecha . ':59';
            $fecha = $fecha . ':00';
        }

        /*
        $query = DB::table('inf_trayectorias_det')
        ->select('inf_trayectorias_det.latitud', 'inf_trayectorias_det.longitud',
                        'inf_trayectorias_det.tipo_coordenada', 'inf_trayectorias_det.fecha',
                        'inf_trayectorias_det.temperatura', 'inf_trayectorias_det.porcentaje_humedad', 'inf_trayectorias_det.descripcion_clima',
                        'inf_trayectorias_det.velocidad_viento', 'inf_trayectorias_det.nombre_ciudad')

            ->whereNotNull('inf_trayectorias_det.tipo_coordenada')
            ->whereBetween('inf_trayectorias_det.fecha', [$fecha, $fecha_fin])


            ->where(function ($query) use ($filtro, $fecha) {

                if ($filtro[1] == '1') {
                    $query->orWhere('inf_trayectorias_det.tipo_coordenada', 'O');
                }
                if ($filtro[2] == '1') {
                    $query->orWhere('inf_trayectorias_det.tipo_coordenada', 'B');
                }
                if ($filtro[3] == '1') {
                    $query->orWhere('inf_trayectorias_det.tipo_coordenada', 'M');
                }
                if ($filtro[4] == '1') {
                    $query->orWhere('inf_trayectorias_det.tipo_coordenada', 'V');
                }
                if ($filtro[5] == '1') {
                    $query->orWhere('inf_trayectorias_det.tipo_coordenada', 'C');
                }
                if ($filtro[6] == '1') {
                    $query->orWhere('inf_trayectorias_det.tipo_coordenada', 'E');
                }
                if ($filtro[7] == '1') {
                    $query->orWhere('inf_trayectorias_det.tipo_coordenada', 'R');
                }
                if ($filtro[8] == '1') {
                    $query->orWhere('inf_trayectorias_det.tipo_coordenada', 'T');
                }
                if ($filtro[9] == '1') {
                    $query->orWhere('inf_trayectorias_det.tipo_coordenada', 'G');
                }
            });

        echo $query->get();
        */


        $query = DB::table('inf_trayectorias')

            ->join('inf_trayectorias_det', 'inf_trayectorias.id_trayectoria', '=', 'inf_trayectorias_det.id_trayectoria')
            ->leftJoin('gen_climas', 'inf_trayectorias.id_trayectoria', 'gen_climas.id_trayectoria')

            ->select('inf_trayectorias_det.id_trayectoria', 'inf_trayectorias_det.latitud', 'inf_trayectorias_det.longitud',
                        'inf_trayectorias_det.tipo_coordenada', 'inf_trayectorias_det.fecha',
                        'gen_climas.temperatura', 'gen_climas.porcentaje_humedad', 'gen_climas.descripcion_clima',
                        'gen_climas.velocidad_viento', 'gen_climas.nombre_ciudad')

            ->whereNotNull('inf_trayectorias_det.tipo_coordenada')
            ->whereBetween('inf_trayectorias_det.fecha', [$fecha, $fecha_fin])

            ->where('inf_trayectorias.observacion', '!=', "PRODUCCIÓN - DETECCION")
            ->where('inf_trayectorias_det.orden', '=', 1)
            ->where(function ($query) use ($filtro, $fecha) {

                if ($filtro[1] == '1') {
                    $query->orWhere('inf_trayectorias_det.tipo_coordenada', 'O');
                }
                if ($filtro[2] == '1') {
                    $query->orWhere('inf_trayectorias_det.tipo_coordenada', 'B');
                }
                if ($filtro[3] == '1') {
                    $query->orWhere('inf_trayectorias_det.tipo_coordenada', 'M');
                }
                if ($filtro[4] == '1') {
                    $query->orWhere('inf_trayectorias_det.tipo_coordenada', 'V');
                }
                if ($filtro[5] == '1') {
                    $query->orWhere('inf_trayectorias_det.tipo_coordenada', 'C');
                }
                if ($filtro[6] == '1') {
                    $query->orWhere('inf_trayectorias_det.tipo_coordenada', 'E');
                }
                if ($filtro[7] == '1') {
                    $query->orWhere('inf_trayectorias_det.tipo_coordenada', 'R');
                }
                if ($filtro[8] == '1') {
                    $query->orWhere('inf_trayectorias_det.tipo_coordenada', 'T');
                }
                if ($filtro[9] == '1') {
                    $query->orWhere('inf_trayectorias_det.tipo_coordenada', 'G');
                }
            });


        $query2 = DB::table('inf_trayectorias')

            ->join('inf_trayectorias_det', 'inf_trayectorias.id_trayectoria', '=', 'inf_trayectorias_det.id_trayectoria')
            ->leftJoin('gen_climas', 'inf_trayectorias.id_trayectoria', 'gen_climas.id_trayectoria')

            ->select('inf_trayectorias_det.id_trayectoria', 'inf_trayectorias_det.latitud', 'inf_trayectorias_det.longitud',
                        'inf_trayectorias_det.tipo_coordenada', 'inf_trayectorias_det.fecha',
                        'gen_climas.temperatura', 'gen_climas.porcentaje_humedad', 'gen_climas.descripcion_clima',
                        'gen_climas.velocidad_viento', 'gen_climas.nombre_ciudad')

            ->whereNotNull('inf_trayectorias_det.tipo_coordenada')
            ->whereBetween('inf_trayectorias_det.fecha', [$fecha, $fecha_fin])

            ->where('inf_trayectorias.observacion', '=', "PRODUCCIÓN - DETECCION")
            ->where(function ($query2) use ($filtro, $fecha) {

                if ($filtro[1] == '1') {
                    $query2->orWhere('inf_trayectorias_det.tipo_coordenada', 'O');
                }
                if ($filtro[2] == '1') {
                    $query2->orWhere('inf_trayectorias_det.tipo_coordenada', 'B');
                }
                if ($filtro[3] == '1') {
                    $query2->orWhere('inf_trayectorias_det.tipo_coordenada', 'M');
                }
                if ($filtro[4] == '1') {
                    $query2->orWhere('inf_trayectorias_det.tipo_coordenada', 'V');
                }
                if ($filtro[5] == '1') {
                    $query2->orWhere('inf_trayectorias_det.tipo_coordenada', 'C');
                }
                if ($filtro[6] == '1') {
                    $query2->orWhere('inf_trayectorias_det.tipo_coordenada', 'E');
                }
                if ($filtro[7] == '1') {
                    $query2->orWhere('inf_trayectorias_det.tipo_coordenada', 'R');
                }
                if ($filtro[8] == '1') {
                    $query2->orWhere('inf_trayectorias_det.tipo_coordenada', 'T');
                }
                if ($filtro[9] == '1') {
                    $query2->orWhere('inf_trayectorias_det.tipo_coordenada', 'G');
                }
            });

            $query2 = $query2->union($query);
        echo $query2->get();

    }

    public function algoritmo(Request $request)
    {

        $cluster = $request->num_cluster;
        $fecha = $request->fecha;
        //$query2 = "";
       /* $this->validate($request, [
            $fecha => 'required|datetime-local',
            $cluster => 'required|not_in:0'
        ]);*/

        if ($fecha == '') {
            $fecha = date("Y-m-d H:i:s");
        } else {
            $fecha = str_replace('T', ' ', $fecha);
            $fecha_fin = $fecha . ':59';
            $fecha = $fecha . ':00';
        }

        /*
       $query = DB::table('inf_trayectorias_det')
        ->select('inf_trayectorias_det.latitud', 'inf_trayectorias_det.longitud',
                        'inf_trayectorias_det.tipo_coordenada', 'inf_trayectorias_det.fecha',
                        'inf_trayectorias_det.temperatura', 'inf_trayectorias_det.porcentaje_humedad', 'inf_trayectorias_det.descripcion_clima',
                        'inf_trayectorias_det.velocidad_viento', 'inf_trayectorias_det.nombre_ciudad')

            ->whereNotNull('inf_trayectorias_det.tipo_coordenada')
            ->whereBetween('inf_trayectorias_det.fecha', [$fecha, $fecha_fin])
            ->get()->toArray();
            */

        $query = DB::table('inf_trayectorias')

            ->join('inf_trayectorias_det', 'inf_trayectorias.id_trayectoria', '=', 'inf_trayectorias_det.id_trayectoria')
            ->leftJoin('gen_climas', 'inf_trayectorias.id_trayectoria', 'gen_climas.id_trayectoria')

            ->select('inf_trayectorias_det.id_trayectoria', 'inf_trayectorias_det.latitud', 'inf_trayectorias_det.longitud',
                        'inf_trayectorias_det.tipo_coordenada', 'inf_trayectorias_det.fecha',
                        'gen_climas.temperatura', 'gen_climas.porcentaje_humedad', 'gen_climas.descripcion_clima',
                        'gen_climas.velocidad_viento', 'gen_climas.nombre_ciudad')

            ->whereNotNull('inf_trayectorias_det.tipo_coordenada')
            ->whereBetween('inf_trayectorias_det.fecha', [$fecha, $fecha_fin])

            ->where('inf_trayectorias.observacion', '!=', "PRODUCCIÓN - DETECCION")
            ->where('inf_trayectorias_det.orden', '=', 1);

        $query2 = DB::table('inf_trayectorias')

            ->join('inf_trayectorias_det', 'inf_trayectorias.id_trayectoria', '=', 'inf_trayectorias_det.id_trayectoria')
            ->leftJoin('gen_climas', 'inf_trayectorias.id_trayectoria', 'gen_climas.id_trayectoria')

            ->select('inf_trayectorias_det.id_trayectoria', 'inf_trayectorias_det.latitud', 'inf_trayectorias_det.longitud',
                        'inf_trayectorias_det.tipo_coordenada', 'inf_trayectorias_det.fecha',
                        'gen_climas.temperatura', 'gen_climas.porcentaje_humedad', 'gen_climas.descripcion_clima',
                        'gen_climas.velocidad_viento', 'gen_climas.nombre_ciudad')

            ->whereNotNull('inf_trayectorias_det.tipo_coordenada')
            ->whereBetween('inf_trayectorias_det.fecha', [$fecha, $fecha_fin])

            ->where('inf_trayectorias.observacion', '=', "PRODUCCIÓN - DETECCION")
            ->union($query)
            ->get()->toArray();


            //$query=$query->get()->toArray();
            //$query2=$query2->get()->toArray();
        //dd($query);
        //$query_final= Array();
        //array_merge($query_final,$query);
        //array_merge($query_final,$query2);

        $matriz = [['id', 'latitud', 'longitud']];
        foreach ($query2 as $value) {
            //var_dump($value->latitud);
            array_push($matriz, [
                1,
                $value->latitud,
                $value->longitud
            ]);
        }
        $fecha_csv = date("H:i:s");
        $fecha_csv = str_replace(':', '_', $fecha_csv);

        $parametro1 = storage_path() . '/archivos_kmeans/coordenadas-' . $fecha_csv . '.csv';
        $fp = fopen($parametro1, 'w');

        foreach ($matriz as $campos) {
            fputcsv($fp, $campos);
        }

        fclose($fp);

        $parametro2 = storage_path() . '/archivos_kmeans/datafinal' . $fecha_csv . '.csv';
        $fp1 = fopen($parametro2, 'w');
        fclose($fp1);

        $parametro3 = storage_path() . '/archivos_kmeans/datafinal_centroide' . $fecha_csv . '.csv';
        $fp2 = fopen($parametro3, 'w');
        fclose($fp2);

        $salida = shell_exec('python3 '. env('KMEANS') .' '.  $parametro1 . ' ' . $parametro2 . ' ' . $cluster . ' ' . $parametro3);

        //echo 'python3 '. env('KMEANS') .' '.  $parametro1 . ' ' . $parametro2 . ' ' . $cluster . ' ' . $parametro3;



        $row = 1;
        $handle = fopen($parametro2, "r");
        $matriz_final = [];
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            //dd($data);
            array_push($matriz_final, $data);
        }
        fclose($handle);

        $arc_centroide = fopen($parametro3, "r");
        $centroides = [];
        $contador =0;
        while (($data = fgetcsv($arc_centroide, 1000, ",")) !== FALSE) {

            $contador>0 ? array_push($centroides, $data) : 0;
            $contador++;
        }
        fclose($arc_centroide);

        return [json_encode($matriz_final), json_encode($centroides)];
    }

    public function servicioKmeans()
    {
        $matriz = [['id', 'latitud', 'longitud']];
        $parametro1 = storage_path() . '/archivos_kmeans/coordenadas-23_42_09.csv';
        $fp = fopen($parametro1, 'w');

        foreach ($matriz as $campos) {
            fputcsv($fp, $campos);
        }

        fclose($fp);

        $parametro2 = storage_path() . '/archivos_kmeans/datafinal23_42_09.csv';
        $fp1 = fopen($parametro2, 'w');
        fclose($fp1);

        $parametro3 = storage_path() . '/archivos_kmeans/datafinal_centroide23_42_09.csv';
        $fp2 = fopen($parametro3, 'w');
        fclose($fp2);
        $cluster = 4;
        $salida = shell_exec('python3 '. env('KMEANS') .' '. $parametro1 . ' ' . $parametro2 . ' ' . $cluster . ' ' . $parametro3);
        echo 'python3 '. env('KMEANS') .' '.  $parametro1 . ' ' . $parametro2 . ' ' . $cluster . ' ' . $parametro3;
    }
}
