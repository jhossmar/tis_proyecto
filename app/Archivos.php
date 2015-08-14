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
    public function getArchivos($id_usuario)
    {
        $integrantes = DB::select("select id_documento_consultor, nombre_documento,descripsion_documento,fecha_documento,g.gestion,habilitado,ruta_documento
                                   from documento_consultor d, gestion_empresa_tis g
                                   where g.id_gestion=d.gestion AND consultor_tis = :id_usuario AND d.documento_jefe=0",['id_usuario'=>$id_usuario]);
        return $integrantes;                               
    }
    public function getNumDocumentos($id_usuario)
    {
       $consulta = DB::select("select count(id_documento_consultor) as numer
                               from documento_consultor d, gestion_empresa_tis g
                               where g.id_gestion = d.gestion AND consultor_tis= :usuario and d.documento_jefe = 0",['usuario'=>$id_usuario]);
       return $consulta;
    }
    public function actualizarDocumentos($habilitado,$id_documento)
    {
      DB::update("update documento_consultor
                  set habilitado=:habilitado
                  where id_documento_consultor = :id_documento",['habilitado'=>$habilitado,'id_documento'=>$id_documento]);
    }
}
