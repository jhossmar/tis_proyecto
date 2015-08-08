<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\functionLogin;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Gestion;
use App\funcionLogin;
use App\noticias;
use App\Actividades;
class PrincipalController extends Controller
{
    public function principal()
    {
    	$variable ='hola si controla';
        $p = new funcionLogin;
        $resultado= $p->consulta();


    	return view('hola', ['resultado' => $resultado]);
    	//return view('hola',$variable); solo para arreglos
    	
    	/*return view('hola')->with([
    	'variable'=>'jhon'
    	]);
        return view('hola',compact('variable','variable2'));
    	*/    	
    }
    public function inicio()
    {
        $gestion = new Gestion;
        $resultado=$gestion->ConsultaGestion();        
        $id_gestion=-1;
        $gestion_valida=false;
        $nombre_gestion="no definida";        
        $gestion_espera=false;
        $fecha_actual=0;
        $ini_gestion=0;
        $fin_gestion=0;
        $fecha_ini =0;
        $fecha_fin =0;
        $date = date("Y-m-d");
        $hora=date("H:i:s");
        $fecha_actual=strtotime($date);
        date_default_timezone_set("America/La_Paz");    
        if($resultado!=null)
        {
            $fin_gestion =$resultado[0]->fecha_fin_gestion;
            $ini_gestion =$resultado[0]->fecha_ini_gestion;
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
                $id_gestion=$resultado[0]->id_gestion;
                $nombre_gestion=$resultado[0]->gestion;
                $gestion_valida=true;
                $gestion_espera=false;
            }
            elseif($fecha_actual > $fecha_fin)
            {
                $id_gestion =- 1;
                $nombre_gestion = "no definida";
                $gestion_valida = false;
                $gestion_espera = false;
                $gestion->SetGestion($id_gestion);             
            }
        }
        $noticia = new Noticias;
        $resultado_noticias= $noticia->GetNoticias($id_gestion);
        $num = $noticia->GetNumeroDocumentos($id_gestion);
        $num_consultores= $noticia->GetNumeroConsultores();
        $num_grupo_empresa= $noticia->GetNumeroGrupoEmpresas();        
        
        $actividad = new Actividades;
        $actividad->Actividad1($id_gestion);
        $actividad->Actividad2($id_gestion);
        $actividad->Actividad3($id_gestion);
        $actividad->Actividad4($id_gestion);
        $actividad->Actividad5($id_gestion);
        $actividad->Actividad6($id_gestion);
        $actividad->Actividad7($id_gestion);

        return view('index')->with([
        'titulo' => 'Sistema de Apoyo a la Empresa TIS',
        'sesion_valida' => false,
        'tipo_usuario'=>0,            
        'gestion_valida'=> $gestion_valida,
        'nombre_gestion'=>$nombre_gestion,
        'fecha_ini'=>$fecha_ini,
        'fecha_fin'=>$fecha_fin,
        'resultado' => $resultado_noticias,
        'num' => $num,
        'men'=>0,
        'num_grupo_empresa'=>$num_grupo_empresa,
        'num_consultor'=>$num_consultores,
        'actividad'=>$actividad,
        'id_gestion'=>$id_gestion]);
    }
    public function tabla()
    {
       $condicional=false;
       return view('tabla')->with('condicional',$condicional);
    }
    public function modelo()    
    {
       $modelo = new App\functionLogin;
       $modelo->consulta();
    }
    public function paso()    
    {
        $actividad = new Actividades;
        $actividad->Actividad1(3);
        $actividad->Actividad2(3);
        $actividad->Actividad3(3);
        $actividad->Actividad4(3);
        $actividad->Actividad5(3);
        $actividad->Actividad6(3);
        $actividad->Actividad7(3);
       return view('master')->with('actividad',$actividad);
    }    
    public function mostrar($id)    
    {
       return view('prueba')->with('id',$id);
    }
    public function header()    
    {
       return view('header')->with([
        'titulo' => 'Sistema de Apoyo a la Empresa TIS',
        'sesion_valida' => false,
        'gestion_valida'=>true,
        'nombre_foto' => '',
        'tipo_usuario'=> 0 ]);
    }
    public function padre()
    {
        return view('padre')->with([
        'hola'=>'jhon'
        ]);;
    }
}
