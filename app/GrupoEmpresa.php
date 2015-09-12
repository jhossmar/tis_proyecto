<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class GrupoEmpresa extends Model
{
   public function getIntegrantes($idGrupo)
   {
   	   $consulta = DB::select("select usuario from integrante where grupo_empresa=:idEmpresa",['idEmpresa'=>$idGrupo]);
   	   return $consulta;
   }
   public function getEntregaProducto($idGrupo)
   {
   	    $consulta = DB::select("select id_entrega_producto, descripcion, fecha_inicio, fecha_fin, fecha_real_entrega, pago_establecido, pago_recibido, observacion, enlace_producto, id_responsable
  	                            from entrega_producto
  	                            where grupo_empresa = :idEmpresa",['idEmpresa'=>$idGrupo]);        
   	    return $consulta;    
   }
   public function getNombreEmpresa($idGrupo)
   {
   	    $consulta = DB::select("select nombre_largo
   	    	                    from grupo_empresa
   	    	                    where id_grupo_empresa = :idEmpresa",['idEmpresa'=>$idGrupo]);
   	    return $consulta;
   }
   public function getActividad($idProducto)
   {
   	    $consulta = DB::select("select id_actividad,fecha_inicio,fecha_fin,descripcion,porcentaje_completado,modificado,id_responsable
   	    	                      from actividad_grupo_empresa
   	    	                      where entrega_producto=:idEntrega",['idEntrega'=>$idProducto]);
   	    return $consulta;
   }
   public function getTareas($idActividad)
   {
   	    $consulta = DB::select("select id_tarea,descripcion,fecha_inicio,fecha_fin,resultado_esperado,resultado_obtenido,porcentaje_completado,color_tarea,modificado,responsable
   	    	                    from tarea
   	    	                    where actividad =:idActividad",['idActividad'=>$idActividad]);
   	    return $consulta;
   }
   public function getNumeroIntegrantes($idG)
   {
      $consulta = DB::select('SELECT COUNT(*) as numero
                              FROM  integrante
                              WHERE grupo_empresa=:idGrupo',['idGrupo'=>$idG]);
      return $consulta;
   }
   public function getIdGrupo($idU)
   {
      $consulta = DB::select('select g.id_grupo_empresa
                              from grupo_empresa g, integrante i
                              where i.grupo_empresa=g.id_grupo_empresa and i.usuario=:idUsuario',['idUsuario'=>$idU]);
      return $consulta;
   }
   public function getMetodologias($idG)
   {
      $consulta_carrera = DB::select("select distinct id_rol, nombre
                                      from rol, metodologia, metodologia_grupo_empresa
                                      where (rol.id_metodologia = metodologia.id_metodologia or rol.id_metodologia = 0)
                                      and metodologia.id_metodologia = metodologia_grupo_empresa.id_metodologia
                                      and metodologia_grupo_empresa.id_grupo_empresa = :idG
                                      and rol.id_rol != 1
                                      and id_rol not in ( select distinct id_rol
                                                               from rol, rol_integrante, metodologia_grupo_empresa, integrante
                                                               where rol.rol_unico = 'si'
                                                               and rol.id_rol != 1
                                                               and rol.id_rol = rol_integrante.rol
                                                               and rol_integrante.integrante = integrante.usuario
                                                               and integrante.grupo_empresa = metodologia_grupo_empresa.id_grupo_empresa
                                                               and rol.id_metodologia = metodologia_grupo_empresa.id_metodologia
                                                               and id_grupo_empresa = :id_g )",['idG'=>$idG,'id_g'=>$idG]);
      return $consulta_carrera;
   }
   public function getResponsable($idU)
   {
      $responsable = DB::select('SELECT nombre,apellido
                                 FROM usuario
                                 WHERE id_usuario=:usr',['usr'=>$idU]);
      return $responsable;
   }
   public function setDinero($monto,$idE,$idG)
   {
     DB::update('UPDATE entrega_producto 
                 SET pago_recibido =:monto
                 WHERE id_entrega_producto= :idEntrega AND grupo_empresa= :idGrupo',['monto'=>$monto,'idEntrega'=>$idE,'idGrupo'=>$idG]);
   }
   public function setObservaciones($obs,$idE,$idG)
   {
     DB::update('UPDATE entrega_producto 
                 SET observacion= :obs
                 WHERE id_entrega_producto= :idEntrega AND grupo_empresa= :idGrupo',['obs'=>$obs,'idEntrega'=>$idE,'idGrupo'=>$idG]);
   }
   public function getGrupoEmpresas($idU,$idG)
   {
     $grupos = DB::select('SELECT id_usuario,nombre_largo,nombre_corto,nombre,apellido,u.habilitado, u.nombre_usuario,g.id_grupo_empresa
                               FROM grupo_empresa g, usuario u, integrante i
                               WHERE g.consultor_tis= :id_usuario AND i.grupo_empresa=g.id_grupo_empresa AND
                               i.usuario=u.id_usuario AND u.tipo_usuario=4 AND u.gestion = :id_gestion',['id_usuario'=>$idU,'id_gestion'=>$idG]);
     return $grupos;
   }
   public function getNumeroUsuarios($idGestion,$idConsultor)
   {                
      $c =DB::select("SELECT COUNT(u.id_usuario) as numer
                      FROM grupo_empresa g, usuario u, integrante i
                      WHERE g.consultor_tis=:usuario AND i.grupo_empresa=g.id_grupo_empresa AND 
                      i.usuario=u.id_usuario AND u.tipo_usuario=4 AND u.gestion=:gestion",['gestion'=>$idGestion,'usuario'=>$idConsultor]);
      return $c;
   }
   public function setHabilitado($habilitado,$idU)
   {
      DB::update("UPDATE usuario
                  SET habilitado = :b
                  WHERE id_usuario = :idU",['b'=>$habilitado,'idU'=>$idU]);
   }
   public function getDatoIntegrantes($id_grupo)
   {
    $integrantes =DB::select("SELECT *
                              FROM integrante i, usuario u, carrera c
                              WHERE grupo_empresa= :id_grupo and  u.id_usuario=i.usuario AND i.carrera=c.id_carrera",['id_grupo'=>$id_grupo]);
    return $integrantes;
   }
   public function getHabilitado($idGrupo)
   {
     $consulta= DB::select("SELECT count(*) as numer
                            from integrante i, usuario u, carrera c
                            where grupo_empresa=:u and  u.id_usuario=i.usuario AND i.carrera=c.id_carrera",['u'=>$idGrupo]);
     return $consulta;
   }
   public function getEntregaProductos($idG)
   {
      $consulta= DB::select(" SELECT descripcion, fecha_inicio, fecha_fin, enlace_producto,pago_establecido, pago_recibido, id_responsable
                              FROM entrega_producto
                              WHERE fecha_fin <= CURDATE()
                              AND grupo_empresa = :grupo",['grupo'=>$idG]);      
      return $consulta;
   }
   public function getInformacionIntegrante($idU)
   {
      $consulta=DB::select("SELECT id_usuario,nombre, apellido, telefono, codigo_sis, nombre_carrera, usuario.nombre_usuario, email,habilitado, grupo_empresa 
                            FROM integrante, usuario, carrera 
                            WHERE integrante.usuario = :id_usuario AND  usuario.id_usuario=integrante.usuario AND carrera=carrera.id_carrera",["id_usuario"=>$idU]);
      return  $consulta;
   }
   public function getInformacionGrupo($idG)
   {
    $consulta = DB::select("SELECT nombre_largo, nombre_corto, abreviatura, nombre,apellido, u.habilitado
                            FROM grupo_empresa g,sociedad s, usuario u
                            WHERE g.id_grupo_empresa= :id_grupo_empresa AND g.sociedad=s.id_sociedad AND g.consultor_tis=u.id_usuario",['id_grupo_empresa'=>$idG]);
    return $consulta;
   }
   public function getRolIntegrante($idU)
   {
    $consulta = DB::select("SELECT id_rol,nombre
                            FROM rol_integrante,rol
                            WHERE rol_integrante.integrante = :id_usuario AND rol_integrante.rol=rol.id_rol",['id_usuario'=>$idU]);
    return $consulta;    
   }
   public function getDatosIntegrantes($idG)
   {
     $consulta = DB::select("SELECT *
                             from integrante i, usuario u, carrera c
                             where grupo_empresa= :id_ggrupo and  u.id_usuario=i.usuario AND i.carrera=c.id_carrera",['id_ggrupo'=>$idG]);
     return $consulta;
   }
   public function setRolIntegrante($idU,$rol)
   {
    DB::update("UPDATE rol_integrante
                SET rol = :rol
                WHERE integrante = :idU and rol!=1",['rol'=>$rol,'idU'=>$idU]);
   }
   public function getRoles($idM)
   {
    $consulta = DB::select("SELECT id_rol ,nombre
                           FROM rol
                           WHERE id_metodologia = 0 OR id_metodologia =:id_metodologia",['id_metodologia'=>$idM]);
    return $consulta;
   }
   public function getMetodoGrupo($idG)
   {
    $consulta = DB::select("SELECT id_metodologia
                           FROM  metodologia_grupo_empresa
                           WHERE id_grupo_empresa = :idGrupo",['idGrupo'=>$idG]);
    return $consulta;
   }
   public function insertarIntegrante($idU,$codS,$carrera,$idG)
   {
      DB::insert("INSERT INTO integrante(usuario,codigo_sis,carrera,grupo_empresa)
                  VALUES ( :id_usuario, :cod_sis, :carrera, :id_grupo)",['id_usuario'=>$idU,'cod_sis'=>$codS,'carrera'=>$carrera,'id_grupo'=>$idG]);
   }
}