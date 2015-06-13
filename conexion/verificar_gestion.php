<?php
include('conexion.php');
class VerificarGestion
{
	public $gestion_valida=false;
	public $nombre_gestion="no definida";
	public $id_gestion=-1;
	public $gestion_espera=false;
	public $act_1=0;
	public $act_2=0;
	public $act_3=0;
	public $act_4=0;
	public $act_5=0;
	public $act_6=0;
	public $act_7=0;	
	public $date=0;
	public $hora=0;
	public $fecha_actual=0;
	public $ini_gestion=0;
	public $fin_gestion=0;
	public $fecha_ini =0;
	public $fecha_fin =0;
	public $fecha_ini_1 =0;
	public $fecha_ini_2 =0;
	public $fecha_ini_3 =0;
	public $fecha_ini_4 =0;
	public $fecha_ini_5 =0;
	public $fecha_ini_6 =0;
	public $fecha_ini_7 =0;
	public $fecha_fin_1 =0;
	public $fecha_fin_2 =0;
	public $fecha_fin_3 =0;
	public $fecha_fin_4 =0;
	public $fecha_fin_5 =0;
	public $fecha_fin_6 =0;
	public $fecha_fin_7 =0;
	function __construct()
	{		
		$this->date = date("Y-m-d");
	    $this->hora=date("H:i:s");
	    $this->fecha_actual=strtotime($this->date);
	    date_default_timezone_set("America/La_Paz");
	}
	public function GetConexion()
	{
		global $conn;
		return $conn;
	}
	private function ActualizarActividad($fase)
	{
		global $conn;
			$consulta_sql="UPDATE fase_convocatoria
					   	   SET activo = 0
					   	   WHERE gestion = $this->id_gestion AND tipo_fase_convocatoria = $fase";

			$consulta = mysql_query($consulta_sql,$conn) or die(mysql_error());
	}
	private function ConsultarActividad($fase)
	{
		global $conn;
	    $consulta = "SELECT activo, fecha_inicio, fecha_fin
					  FROM fase_convocatoria
					  WHERE tipo_fase_convocatoria=$fase AND gestion=$this->id_gestion";

		 $query= mysql_query($consulta,$conn) or die("Could not execute the select query 1");
		 $respuesta = mysql_fetch_assoc($query);
		 return $respuesta;
	}
	public function VerificarFechasGestion()
	{			
	    global $conn;   
	    $consulta_sql="SELECT id_gestion, gestion,fecha_ini_gestion,fecha_fin_gestion
		  		       FROM gestion_empresa_tis
				       WHERE gestion_activa=1 AND gestion!='Permanente'";
				       
	    $consulta = mysql_query($consulta_sql,$conn)or die("Could not execute the select query");
	    
	    $resultado = mysql_fetch_assoc($consulta);	    

	    if(!empty($resultado['id_gestion']))
     	{ 		
		  $this->fin_gestion=$resultado['fecha_fin_gestion'];
		  $this->ini_gestion=$resultado['fecha_ini_gestion'];
		  $this->id_gestion=(int)$resultado['id_gestion'];
		  $this->fecha_fin=strtotime($this->fin_gestion);
		  $this->fecha_ini=strtotime($this->ini_gestion);
		 
		  if($this->fecha_actual <= $this->fecha_fin  && $this->fecha_actual < $this->fecha_ini) 
		  {
				$this->id_gestion=-1;
				$this->nombre_gestion="inicia el ".$this->ini_gestion;
				$this->gestion_valida=false;
				$this->gestion_espera=true;
		  }
		  elseif($this->fecha_actual <= $this->fecha_fin  && $this->fecha_actual > $this->fecha_ini)
		  {
				$this->nombre_gestion=$resultado['gestion'];
				$this->gestion_valida=true;
		        $this->gestion_espera=false;
		  }
		  elseif($this->fecha_actual > $this->fecha_fin)
		  {
			$cerrar_gestion="UPDATE gestion_empresa_tis
							set gestion_activa=0
							WHERE id_gestion=$id_gestion";
			$consulta_cerrar = mysql_query($cerrar_gestion,$conn)
			or die("Could not execute the select query 15.");
			$this->id_gestion=-1;
			$this->nombre_gestion="no definida";
			$this->gestion_valida=false;
			$this->gestion_espera=false;
		  }
		}
		return $this->gestion_valida;
	}
	public function Actividad1()
	{               
                $res_1 = $this->ConsultarActividad(1);
				$this->act_1 = $res_1['activo'];
				$this->act_1_espera = false;
				$this->act_ini_1 = $res_1['fecha_inicio'];
				$this->act_fin_1 = $res_1['fecha_fin'];
				$this->fecha_ini_1 = strtotime($this->act_ini_1);
				$this->fecha_fin_1 = strtotime($this->act_fin_1);

				if($this->act_1==1)
				{
				    if($this->fecha_actual<=$this->fecha_fin_1 && $this->fecha_actual >= $this->fecha_ini_1) 
				    {
				     	$this->act_1=1;
						$this->act_1_espera=false;											   
					}
					elseif($this->fecha_actual<=$this->fecha_fin_1 && $this->this->fecha_actual < $this->fecha_ini_1)
					{
							$this->act_1_espera=true;
					}					
				}
				if($this->fecha_actual > $this->fecha_fin_1) 
				{
					    $this->ActualizarActividad(1);
						$this->act_1=0;
						$this->act_1_espera=false;
				}
	}
	public function Actividad2()
	{					        		
		$res_2 = $this->ConsultarActividad(2);
		$this->act_2=$res_2['activo'];
		$this->act_2_espera=false;
		$this->act_ini_2=$res_2['fecha_inicio'];
		$this->act_fin_2=$res_2['fecha_fin'];
		$this->fecha_ini_2=strtotime($this->act_ini_2);
		$this->fecha_fin_2=strtotime($this->act_fin_2);
		if($this->act_2 == 1) 
		{
			if($this->fecha_actual <= $this->fecha_fin_2 && $this->fecha_actual >= $this->fecha_ini_2) 
			{
				$this->act_2=1;
				$this->act_2_espera=false;					
			}
			elseif($this->fecha_actual <= $this->fecha_fin_2 && $this->fecha_actual < $this->fecha_ini_2)
			{
			    $this->act_2_espera=true;	
			}						
		}
		if($this->fecha_actual > $this->fecha_fin_2)
		{
			$this->ActualizarActividad(2);
			$this->act_2=0;
			$this->act_2_espera=false;
		}
	}				
	public function Actividad3()
	{			    		
		$res_3 = $this->ConsultarActividad(3);
		$this->act_3 = $res_3['activo'];
		$this->act_3_espera=false;
		$this->act_ini_3=$res_3['fecha_inicio'];
		$this->act_fin_3=$res_3['fecha_fin'];
		$this->fecha_ini_3=strtotime($this->act_ini_3);
		$this->fecha_fin_3=strtotime($this->act_fin_3);
			
			if ($this->act_3==1)
			{
				if($this->fecha_actual <= $this->fecha_fin_3 && $this->fecha_actual >= $this->fecha_ini_3) 
				{
					$this->act_3=1;
					$this->act_3_espera=false;
				}				
				elseif($this->fecha_actual <= $this->fecha_fin_3 && $this->fecha_actual < $this->fecha_ini_3)
				{
					$this->act_3_espera=true;		
				}								
			}
			if($this->fecha_actual > $this->fecha_fin_3)
			{
				$this->ActualizarActividad(3);
				$this->act_3=0;
				$this->act_3_espera=false;
			}
	}
	public function Actividad4()
	{					  			
		$res_4 = $this->ConsultarActividad(4);
		$this->act_4=$res_4['activo'];
		$this->act_4_espera=false;
		$this->act_ini_4=$res_4['fecha_inicio'];
		$this->act_fin_4=$res_4['fecha_fin'];
		$this->fecha_ini_4=strtotime($this->act_ini_4);
		$this->fecha_fin_4=strtotime($this->act_fin_4);
		if ($this->act_4==1) 
		{
			if($this->fecha_actual <= $this->fecha_fin_4 && $this->fecha_actual >= $this->fecha_ini_4) 
			{
				$act_4=1;
				$act_4_espera=false;
			}				
			elseif($this->fecha_actual <= $this->fecha_fin_4 && $this->fecha_actual < $this->fecha_ini_4)
			{
				$this->act_4_espera=true;		
			}								
		}
		if($this->fecha_actual > $this->fecha_fin_4)
		{
			$this->ActualizarActividad(4);
			$this->act_4=0;
			$this->act_4_espera=false;
		}
	}
	public function Actividad5()
	{					  				
		$res_5 = $this->ConsultarActividad(5);
		$this->act_5=$res_5['activo'];
		$this->act_5_espera=false;
		$this->act_ini_5=$res_5['fecha_inicio'];
		$this->act_fin_5=$res_5['fecha_fin'];
		$this->fecha_ini_5=strtotime($this->act_ini_5);
		$this->fecha_fin_5=strtotime($this->act_fin_5);
		if ($this->act_5==1) 
		{
			if($this->fecha_actual <= $this->fecha_fin_5 && $this->fecha_actual >= $this->fecha_ini_5) 
			{
				$this->act_5=1;
				$this->act_5_espera=false;
			}				
			elseif($this->fecha_actual <= $this->fecha_fin_5 && $this->fecha_actual < $this->fecha_ini_5)
			{
				$this->act_5_espera=true;
			}								
		}
		if($this->fecha_actual > $this->fecha_fin_5)
		{
			$this->ActualizarActividad(5);
			$this->act_5=0;
			$this->act_5_espera=false;
		}
	}
	public function Actividad6()
	{					  			
		$res_6 = $this->ConsultarActividad(6);
		$this->act_6=$res_6['activo'];
		$this->act_6_espera=false;
		$this->act_ini_6=$res_6['fecha_inicio'];
		$this->act_fin_6=$res_6['fecha_fin'];
		$this->fecha_ini_6=strtotime($this->act_ini_6);
		$this->fecha_fin_6=strtotime($this->act_fin_6);
		if($this->act_6==1)
		{
			if($this->fecha_actual <= $this->fecha_fin_6 && $this->fecha_actual >= $this->fecha_ini_6)
			{
				$this->act_6=1;
				$this->act_6_espera=false;
			}				
			elseif($this->fecha_actual <= $this->fecha_fin_6 && $this->fecha_actual < $this->fecha_ini_6)
			{
				$this->act_6_espera=true;
			}								
		}
		if($this->fecha_actual > $this->fecha_fin_6)
		{
			$this->ActualizarActividad(6);
			$this->act_6=0;
			$this->act_6_espera=false;
		}
	}
	public function Actividad7()
	{					  			
		$res_7 = $this->ConsultarActividad(7);
		$this->act_7=$res_7['activo'];
		$this->act_7_espera=false;
		$this->act_ini_7=$res_7['fecha_inicio'];
		$this->act_fin_7=$res_7['fecha_fin'];
		$this->fecha_ini_7=strtotime($this->act_ini_7);
		$this->fecha_fin_7=strtotime($this->act_fin_7);
		if($this->act_7==1)
		{
			if($this->fecha_actual <= $this->fecha_fin_7 && $this->fecha_actual >= $this->fecha_ini_7)
			{
				$this->act_7=1;
				$this->act_7_espera=false;
			}				
			elseif($this->fecha_actual <= $this->fecha_fin_7 && $this->fecha_actual < $this->fecha_ini_7)
			{
				$this->act_7_espera=true;
			}								
		}
		if($this->fecha_actual > $this->fecha_fin_7)
		{
			$this->ActualizarActividad(7);
			$this->act_7=0;
			$this->act_7_espera=false;
		}
	}					
}
?>