<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class funcionLogin extends Model
{
	public function consulta()
	{
	  $results = DB::select('select id_gestion, gestion,fecha_ini_gestion,fecha_fin_gestion
		  		                   from gestion_empresa_tis
				                   where gestion_activa = :id and gestion != :gestion', ['id' => 1,'gestion'=>'permanente']);
      return $results;
	}
    
}
