<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Archivos extends Model
{
    public function setArchivo($tituloD,$descripcion,$documento,$id_usuario,$id_gestion)
    {
      DB::insert("insert into documento_consultor (nombre_documento, descripsion_documento, ruta_documento, fecha_documento, documento_jefe, consultor_tis, gestion)
                  values (:tituloD,:descripcion,:documento,NOW(),1,:id_usuario,:id_gestion)",['tituloD'=>$tituloD,'descripcion'=>$descripcion,'documento'=>$documento,'id_usuario'=>$id_usuario,'id_gestion'=>$id_gestion]);
    }
    public function setContrato($tituloD,$descripcionA,$contrato,$id_usuario,$id_gestion)
    {
    	DB::insert("insert into documento_consultor(nombre_documento, descripsion_documento, ruta_documento, fecha_documento, documento_jefe, consultor_tis, gestion)
                    values (:tituloD, :descripcionA, :contrato, NOW(), 0, :usuario, :id_gestion)",['tituloD'=>$tituloD,'descripcionA'=>$descripcionA,'contrato'=>$contrato,'usuario'=>$id_usuario,'id_gestion'=>$id_gestion]);
    }
}
