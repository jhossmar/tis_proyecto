<?php
$control=0;   
   class Conexion
   {
   	private $conexion;

   	public function EstablecerConexion()
   	{
   	   $this->conexion = mysql_connect("localhost","munisoft","WSVBtmXg") or die("Error en conexion");
   	   
	   mysql_select_db("tis_munisoft", $this->conexion) or die("Error en base de datos");
	   mysql_query("SET NAMES 'utf8'");		   
   	}
   	public function GetConexion()
   	{
   		return $this->conexion;
   	}
   }
	
?>
