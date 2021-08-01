<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trayectoria extends Model
{
    protected $table = 'inf_trayectorias';

    public function trayectoria_detalle()
    {
        return $this->hasMany('App\TrayectoriaDet', 'id_trayectoria', 'id_trayectoria');
    }

    public function genera_clima()
    {
        return $this->hasMany('App\Clima', 'id_trayectoria', 'id_trayectoria');
    }
}
