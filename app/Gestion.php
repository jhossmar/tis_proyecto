<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Gestion extends Model
{
	private $gestion;
	function __construct()
	{			
	}
	public function ConsultaGestion()
	{	   					    
	    $consulta_sql = DB::select('select id_gestion, gestion,fecha_ini_gestion,fecha_fin_gestion
		  		                   from gestion_empresa_tis
				                   where gestion_activa = :id and gestion != :gestion', ['id' => 1,'gestion'=>'permanente']);	    
	    if(!empty($consulta_sql))
	    {
	    	$this->gestion=$consulta_sql;
	    }
	    else
	    {
	        $this->gestion=null;
	    }
	    return $this->gestion;
    }	
	public function SetGestion($id_gestion)
	{
		DB::update('UPDATE gestion_empresa_tis
                             SET gestion_activa=0
                             WHERE id_gestion= :id ',['id'=>$id_gestion]);
	}
}