<?php
include_once("verificar_gestion.php");
class VerificarActividades extends VerificarGestion
{
	public $activo_1=0;
	public $activo_2=0;
	public $activo_3=0;
	public $activo_4=0;
	public $activo_5=0;
	public $activo_6=0;
	public $activo_7=0;	

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

	public $act_1_espera =false;
	public $act_2_espera =false;
	public $act_3_espera =false;
	public $act_4_espera =false;
	public $act_5_espera =false;
	public $act_6_espera =false;
	public $act_7_espera =false;
	
	private function ActualizarActividad($fase)
	{		
			$consulta_sql="UPDATE fase_convocatoria
					   	   SET activo = 0
					   	   WHERE gestion = $this->id_gestion AND tipo_fase_convocatoria = $fase";

			$consulta = mysql_query($consulta_sql,$this->conexion) or die(mysql_error());
	}
	private function ConsultarActividad($fase)
	{		
	    $consulta = "SELECT activo, fecha_inicio, fecha_fin
					  FROM fase_convocatoria
					  WHERE tipo_fase_convocatoria=$fase AND gestion=$this->id_gestion";

		 $query= mysql_query($consulta,$this->conexion) or die("Could not execute the select query 1");
		 $respuesta = mysql_fetch_assoc($query);
		 return $respuesta;
	}
    public function Actividad1()
	{               
                $res_1 = $this->ConsultarActividad(1);
				$this->activo_1 = (int) $res_1['activo'];
				$this->act_1_espera = false;
				$this->fecha_ini_1 = $res_1['fecha_inicio'];
				$this->fecha_fin_1 = $res_1['fecha_fin'];
				$act_ini_1 = strtotime($this->fecha_ini_1);
				$act_fin_1 = strtotime($this->fecha_fin_1);

				if($this->activo_1 == 1)
				{
				    if($this->fecha_actual <= $act_fin_1 && $this->fecha_actual >= $act_ini_1) 
				    {
				     	$this->activo_1=1;
						$this->act_1_espera=false;											   
					}
					elseif($this->fecha_actual <= $act_fin_1 && $this->fecha_actual < $act_ini_1)
					{
							$this->act_1_espera=true;
							$this->activo_1=0;
					}					
				}
				if($this->fecha_actual > $act_fin_1) 
				{
					    $this->ActualizarActividad(1);
						$this->activo_1=0;
						$this->act_1_espera=false;
				}
	}
	public function Actividad2()
	{					        		
		$res_2 = $this->ConsultarActividad(2);
		$this->activo_2 = (int) $res_2['activo'];
		$this->act_2_espera=false;
		$this->fecha_ini_2=$res_2['fecha_inicio'];
		$this->fecha_fin_2=$res_2['fecha_fin'];
		$act_ini_2=strtotime($this->fecha_ini_2);
		$act_fin_2=strtotime($this->fecha_fin_2);
		if($this->activo_2 == 1) 
		{
			if($this->fecha_actual <= $act_fin_2 && $this->fecha_actual >= $act_ini_2) 
			{
				$this->activo_2=1;
				$this->act_2_espera=false;					
			}
			elseif($this->fecha_actual <= $act_fin_2 && $this->fecha_actual < $act_ini_2)
			{
			    $this->act_2_espera=true;	
			}						
		}
		if($this->fecha_actual > $act_fin_2)
		{
			$this->ActualizarActividad(2);
			$this->activo_2=0;
			$this->act_2_espera=false;
		}
	}				
	public function Actividad3()
	{			    		
		$res_3 = $this->ConsultarActividad(3);
		$this->activo_3 =(int) $res_3['activo'];
		$this->act_3_espera=false;
		$this->fecha_ini_3=$res_3['fecha_inicio'];
		$this->fecha_fin_3=$res_3['fecha_fin'];
		$act_ini_3=strtotime($this->fecha_ini_3);
		$act_fin_3=strtotime($this->fecha_fin_3);
			
			if ($this->activo_3==1)
			{
				if($this->fecha_actual <= $act_fin_3 && $this->fecha_actual >= $act_ini_3) 
				{
					$this->activo_3=1;
					$this->act_3_espera=false;
				}				
				elseif($this->fecha_actual <= $act_fin_3 && $this->fecha_actual < $act_ini_3)
				{
					$this->act_3_espera=true;		
				}								
			}
			if($this->fecha_actual > $act_fin_3)
			{
				$this->ActualizarActividad(3);
				$this->activo_3=0;
				$this->act_3_espera=false;
			}
	}
	public function Actividad4()
	{					  			
		$res_4 = $this->ConsultarActividad(4);
		$this->activo_4= (int) $res_4['activo'];
		$this->act_4_espera=false;
		$this->fecha_ini_4=$res_4['fecha_inicio'];
		$this->fecha_fin_4=$res_4['fecha_fin'];
		$act_ini_4=strtotime($this->fecha_ini_4);
		$act_fin_4=strtotime($this->fecha_fin_4);
		if ($this->activo_4==1) 
		{
			if($this->fecha_actual <= $act_fin_4 && $this->fecha_actual >= $act_ini_4) 
			{
				$activo_4=1;
				$act_4_espera=false;
			}				
			elseif($this->fecha_actual <= $act_fin_4 && $this->fecha_actual < $act_ini_4)
			{
				$this->act_4_espera=true;		
			}								
		}
		if($this->fecha_actual > $act_fin_4)
		{
			$this->ActualizarActividad(4);
			$this->act_4=0;
			$this->act_4_espera=false;
		}
	}
	public function Actividad5()
	{					  				
		$res_5 = $this->ConsultarActividad(5);
		$this->activo_5= (int) $res_5['activo'];
		$this->act_5_espera=false;
		$this->fecha_ini_5=$res_5['fecha_inicio'];
		$this->fecha_fin_5=$res_5['fecha_fin'];
		$act_ini_5=strtotime($this->fecha_ini_5);
		$act_fin_5=strtotime($this->fecha_fin_5);
		if ($this->activo_5==1) 
		{
			if($this->fecha_actual <= $act_fin_5 && $this->fecha_actual >= $act_ini_5) 
			{
				$this->activo_5 = 1;
				$this->act_5_espera=false;
			}				
			elseif($this->fecha_actual <= $act_fin_5 && $this->fecha_actual < $act_ini_5)
			{
				$this->act_5_espera=true;
			}								
		}
		if($this->fecha_actual > $act_fin_5)
		{
			$this->ActualizarActividad(5);
			$this->activo_5=0;
			$this->act_5_espera=false;
		}
	}
	public function Actividad6()
	{					  			
		$res_6 = $this->ConsultarActividad(6);
		$this->activo_6 = (int) $res_6['activo'];
		$this->act_6_espera=false;
		$this->fecha_ini_6=$res_6['fecha_inicio'];
		$this->fecha_fin_6=$res_6['fecha_fin'];
		$act_ini_6=strtotime($this->fecha_ini_6);
		$act_fin_6=strtotime($this->fecha_fin_6);
		if($this->activo_6==1)
		{
			if($this->fecha_actual <= $act_fin_6 && $this->fecha_actual >= $act_ini_6)
			{
				$this->activo_6=1;
				$this->act_6_espera=false;
			}				
			elseif($this->fecha_actual <= $act_fin_6 && $this->fecha_actual < $act_ini_6)
			{
				$this->act_6_espera=true;
			}								
		}
		if($this->fecha_actual > $act_fin_6)
		{
			$this->ActualizarActividad(6);
			$this->activo_6=0;
			$this->act_6_espera=false;
		}
	}
	public function Actividad7()
	{					  			
		$res_7 = $this->ConsultarActividad(7);
		$this->activo_7 = (int) $res_7['activo'];
		$this->act_7_espera=false;
		$this->fecha_ini_7=$res_7['fecha_inicio'];
		$this->fecha_fin_7=$res_7['fecha_fin'];
		$act_ini_7=strtotime($this->fecha_ini_7);
		$act_fin_7=strtotime($this->fecha_fin_7);
		if($this->activo_7==1)
		{
			if($this->fecha_actual <= $act_fin_7 && $this->fecha_actual >= $act_ini_7)
			{
				$this->activo_7=1;
				$this->act_7_espera=false;
			}				
			elseif($this->fecha_actual <= $act_fin_7 && $this->fecha_actual < $act_ini_7)
			{
				$this->act_7_espera=true;
			}								
		}
		if($this->fecha_actual > $act_fin_7)
		{
			$this->ActualizarActividad(7);
			$this->activo_7=0;
			$this->act_7_espera=false;
		}
	}
}					
?>