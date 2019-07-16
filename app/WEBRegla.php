<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WEBRegla extends Model
{
    protected $table = 'WEB.reglas';
    public $timestamps=false;

    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';


    public function reglaproductocliente()
    {
        return $this->hasMany('App\WEBReglaProductoCliente', 'regla_id', 'id');
    }

}
