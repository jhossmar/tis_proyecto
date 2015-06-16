<?php
require_once("conexion.php");
class VerificarGestion
{
	public $gestion_valida=false;
	public $nombre_gestion="no definida";
	public $id_gestion=-1;
	public $gestion_espera=false;
    private $date=0;
	private $hora=0;
	public $fecha_actual=0;
	public $ini_gestion=0;
	public $fin_gestion=0;
	public $fecha_ini =0;
	public $fecha_fin =0;
	protected $conexion;
	private $con;
	function __construct()
	{			
	    $this->VerificarFechasGestion();	    	    
	}
	public function VerificarFechasGestion()
	{	
		$this->date = date("Y-m-d");
	    $this->hora=date("H:i:s");
	    $this->fecha_actual=strtotime($this->date);
	    date_default_timezone_set("America/La_Paz");	    
		$this->con = new Conexion;
	    $this->con->EstablecerConexion();	    	    
	    $this->conexion = $this->con->GetConexion();
	    
	    $consulta_sql="SELECT id_gestion, gestion,fecha_ini_gestion,fecha_fin_gestion
		  		       FROM gestion_empresa_tis
				       WHERE gestion_activa=1 AND gestion!='Permanente'";
				       
	    $respuesta = mysql_query($consulta_sql ,$this->conexion)or die("Could not execute the select query");
	    
	    $resultado = mysql_fetch_assoc($respuesta);	    

	    if(!empty($resultado['id_gestion']))
     	{ 		
		  $this->fin_gestion = $resultado['fecha_fin_gestion'];
		  $this->ini_gestion = $resultado['fecha_ini_gestion'];
		  $this->id_gestion = (int)$resultado['id_gestion'];
		  $this->fecha_fin = strtotime($this->fin_gestion);
		  $this->fecha_ini = strtotime($this->ini_gestion);
		 
		  if($this->fecha_actual <= $this->fecha_fin  && $this->fecha_actual < $this->fecha_ini) 
		  {
				$this->id_gestion = -1;
				$this->nombre_gestion = " inicia el ".$this->ini_gestion;
				$this->gestion_valida = false;
				$this->gestion_espera = true;
		  }
		  elseif($this->fecha_actual <= $this->fecha_fin  && $this->fecha_actual >= $this->fecha_ini)
		  {
		  	    $this->id_gestion=$resultado['id_gestion'];
				$this->nombre_gestion=$resultado['gestion'];
				$this->gestion_valida=true;
		        $this->gestion_espera=false;
		  }
		  elseif($this->fecha_actual > $this->fecha_fin)
		  {
		  	$this->id_gestion =- 1;
			$this->nombre_gestion = "no definida";
			$this->gestion_valida = false;
			$this->gestion_espera = false;
			$cerrar_gestion="UPDATE gestion_empresa_tis
							 SET gestion_activa=0
							 WHERE id_gestion=$this->id_gestion";
			$consulta_cerrar = mysql_query($cerrar_gestion,$this->conexion)
			or die("Could not execute the select query 15.");			
		  }
		}		
	}
	public function GetGestionValida()
	{
	   return $this->gestion_valida;
	}	
}
?>