<?php 
namespace App\Http\Controllers;
use Session;
use App\Gestion;
use App\noticias;
use App\Actividades;

class VerificadorDeSesiones 
{
  private $gestion;
  private $datos;

  function __construct()
  {   
    $this->controlGestion();
    $this->controlActividades();
  }

 /**
  * funcion que verifica si se ha iniciado session
  * si es asi retorna true y si no retorna false
  */
 public function sesionIniciado()
 {
     
   if(Session::get('id')==NULL)
   {
     	return false;
   }
   else
   {
     	return true;
   }
 }
//////////////PARTE DEL PrincipalControll solo para obtener gestion y datos////////
private function controlGestion()
{   
  $id_gestion=-1;
  $nombre_gestion='no definida';
  $gestion_valida=false;        
  $fecha_ini=0;//numero
  $fecha_fin=0;
  $resultado;
  $gestion_espera=false;
  $fecha_actual=0;
  $ini_gestion=0;//fecha
  $fin_gestion=0;

  $gest = new Gestion;
  $resultado=$gest->ConsultaGestion();
            
  $date = date("Y-m-d");
  $hora=date("H:i:s");
  $fecha_actual=strtotime($date);
  date_default_timezone_set("America/La_Paz");    
  if($resultado!=null)
  {
    $fin_gestion = $resultado[0]->fecha_fin_gestion;
    $ini_gestion = $resultado[0]->fecha_ini_gestion;
    $id_gestion = (int) $resultado[0]->id_gestion;
    $fecha_fin = strtotime($fin_gestion);
    $fecha_ini = strtotime($ini_gestion);        
        
    if($fecha_actual <= $fecha_fin  && $fecha_actual < $fecha_ini) 
    {
      $id_gestion = -1;
      $nombre_gestion = " inicia el ".$ini_gestion;
      $gestion_valida = false;
      $gestion_espera = true;
    }
    elseif($fecha_actual <= $fecha_fin  && $fecha_actual >= $fecha_ini)
    {
      $id_gestion = $resultado[0]->id_gestion;
      $nombre_gestion = $resultado[0]->gestion;
      $gestion_valida = true;
      $gestion_espera = false;
    }
    elseif($fecha_actual > $fecha_fin)
    {
      $id_gestion =- 1;
      $nombre_gestion = "no definida";
      $gestion_valida = false;
      $gestion_espera = false;
    //  $gestion= new Gestion;
      $gestion->SetGestion($id_gestion);             
    }
  }
  
  $this->gestion = array('id_gestion' => $id_gestion,
                         'nombre_gestion'=> $nombre_gestion,
                         'gestion_valida'=> $gestion_valida,
                         'fecha_ini' => $fecha_ini,
                         'fecha_fin' => $fecha_fin);
  }              
  private function controlActividades()
  {
    $numdoc=0;        
    $num_grupo_empresa=0;
    $num_consultor=0;
    $num_notificaciones=0;
    $noticia = new Noticias;
    $resultado_noticias= $noticia->GetNoticias($this->gestion['id_gestion']);
    $numdoc = $noticia->GetNumeroDocumentos($this->gestion['id_gestion']);
    $num_consultores= $noticia->GetNumeroConsultores();
    $num_grupo_empresa= $noticia->GetNumeroGrupoEmpresas(); 
    if(Session::get('id') != null)
    {
      $num_notificaciones = (int) $noticia->GetNotificaciones(Session::get('id'),$this->gestion['fecha_fin'],$this->gestion['fecha_ini']);
    }
    $actividad = new Actividades;
    $actividad->Actividad1($this->gestion['id_gestion']);
    $actividad->Actividad2($this->gestion['id_gestion']);
    $actividad->Actividad3($this->gestion['id_gestion']);
    $actividad->Actividad4($this->gestion['id_gestion']);
    $actividad->Actividad5($this->gestion['id_gestion']);
    $actividad->Actividad6($this->gestion['id_gestion']);
    $actividad->Actividad7($this->gestion['id_gestion']);

    $this->datos = array('resultado_noticias' => $resultado_noticias,
                         'numdoc' => $numdoc,
                         'num_consultores'=>$num_consultores,
                         'num_grupo_empresa'=>$num_grupo_empresa,
                         'men'=>0,
                         'actividad' => $actividad,
                         'num_notificaciones'=>$num_notificaciones);
  }
  public function getGestion()
  {
    return $this->gestion;
  }
  public function getDatos()
  {
    return $this->datos;
  }
}//fin de la clase




