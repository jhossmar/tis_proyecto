<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Usuario extends Model
{
    public function GetUsuario($nombre,$clave)
    {
        //$salt="$2x$07$./f4af7kJi1jdaxlswE34$"; Marcelo:  borre por que aun no tengo my base de datos cifrada 
       // $pass=crypt($clave, $salt);
    	$consulta_sql = DB::select('select * 
    		                        from usuario
    		                        where nombre_usuario = :nombre and clave = :clave ',['nombre' => $nombre,'clave'=> $clave]);
        return $consulta_sql;
    }
    public function SetBitacora($id)
    {
    	DB::insert("INSERT INTO bitacora_sesion(usuario,fecha_hora,operacion)
                     VALUES (:id,CURRENT_TIMESTAMP,0)",['id'=>$id]);
    }
    public function GetInformacionConsultor($id)
    {
        $consulta_usuario = DB::select("select id_usuario, nombre_usuario,clave,nombre,apellido,telefono,email,habilitado,curriculum
                                        from usuario u, consultor_tis c
                                        where u.id_usuario = c.usuario AND u.id_usuario=:id",['id'=>$id]);
        return $consulta_usuario;
    }
    public function verificarEmail($email,$id_gestion)
    {
        $sql = DB::select("select email
                           from usuario
                           where email= :email AND (gestion=1 OR gestion=:id_gestion)",['email'=>$email,'id_gestion'=>$id_gestion]);
        return $sql;
    }
    public function verificarUsuario($nombre_usuario,$id_gestion)
    {
        $sql_user = DB::select("select nombre_usuario
                                from usuario
                                where nombre_usuario = :nombre AND (gestion=1 OR gestion = :id_gestion)",['nombre'=>$nombre_usuario,'id_gestion'=>$id_gestion]);
        return $sql_user;
    }
    public function verificarCodSis($codSis,$id_gestion)
    {
        $consulta = DB::select("SELECT codigo_sis 
                                FROM usuario, integrante 
                                WHERE integrante.usuario=usuario.id_usuario AND codigo_sis=:cod_sis AND (gestion=1 OR gestion=:id_gestion)",['cod_sis'=>$codSis,'id_gestion'=>$id_gestion]);
        return $consulta;
    }
    public function actualizarDatos($id_usuario, $nombre_usuario, $nombre, $apellido, $telefono, $email)
    {       
        DB::update("update usuario as u
                    set nombre_usuario = :usuario, nombre = :nombre, apellido = :apellido, telefono = :telf, email = :email
                           where u.id_usuario = :id_usuario",['id_usuario'=>$id_usuario,'usuario'=>$nombre_usuario,'nombre'=>$nombre,'apellido'=>$apellido,'telf'=>$telefono,'email'=>$email]);
    }

    public function iniciarSesion($id_usuario)
    {
        DB::statement("CALL iniciar_sesion(:id_usuario)",['id_usuario'=>$id_usuario]);

    }
    public function getInformacionAdministrador($id)
    {
        $consulta_usuario = DB::select("select id_usuario, nombre_usuario,clave,nombre,apellido,telefono,email,habilitado
                                        from usuario u
                                        where u.id_usuario=:id",['id'=>$id]);
        return $consulta_usuario;
    }

      public function actualizarDatosAdmin($id_usuario, $nombre_usuario, $nombre, $apellido, $telefono, $email,$clave)
    {       
        DB::update("update usuario as u
                    set nombre_usuario = :usuario, nombre = :nombre, apellido = :apellido, telefono = :telf, email = :email,clave = :clave
                           where u.id_usuario = :id_usuario",['id_usuario'=>$id_usuario,'usuario'=>$nombre_usuario,'nombre'=>$nombre,'apellido'=>$apellido,'telf'=>$telefono,'email'=>$email,'clave'=>$clave]);
    }

     public function getConsultoresTis()
     {

        $consulta_usuario = DB::select("select id_usuario, nombre_usuario,clave,nombre,apellido,telefono,email,habilitado,curriculum,tipo_usuario
                                        from usuario u, consultor_tis c
                                        where u.id_usuario = c.usuario ");
        return $consulta_usuario;

     }

     public function getListaGrupoEmpresas(){

        $consulta_usuario = DB::select("SELECT u.nombre_usuario,u.habilitado,ge.nombre_corto,ge.nombre_largo,s.descripcion,u.id_usuario,u.clave
                FROM usuario u,integrante i,grupo_empresa ge,sociedad s
                WHERE  u.tipo_usuario = 4 and u.id_usuario=i.usuario and i.grupo_empresa=ge.id_grupo_empresa and ge.sociedad= s.id_sociedad");
           return $consulta_usuario;
     }
  
    public function getBitacorasSesion($condicion){

         $consulta_usuario = DB::select("SELECT id_bitacora_sesion, fecha_hora, operacion, nombre_usuario,g.gestion,descripcion
                                         FROM bitacora_sesion b, usuario u, gestion_empresa_tis g,tipo_usuario
                                         WHERE id_usuario=usuario AND u.gestion=g.id_gestion  AND tipo_usuario=id_tipo_usuario ".$condicion);
         return $consulta_usuario;
    }

    public function getBitacorasBD($condicion){

         $consulta_usuario = DB::select("SELECT id_bitacora,fecha_hora,u.nombre_usuario,viejo,nuevo,g.gestion, t.descripcion,tabla
                                         FROM bitacora_bd b, usuario u, gestion_empresa_tis g, tipo_usuario t
                                         WHERE u.id_usuario=b.usuario AND g.id_gestion=u.gestion AND u.tipo_usuario=t.id_tipo_usuario ".$condicion);
         return $consulta_usuario;                                                                                                                                             
    }
  
    public function getListadeGestiones(){
         $consulta_usuario = DB::select("SELECT id_gestion,gestion FROM gestion_empresa_tis");
         return $consulta_usuario;

    }

    public function getListadeUsuarios(){
         $consulta_usuario = DB::select("SELECT id_tipo_usuario,descripcion from tipo_usuario");
         return $consulta_usuario;

    }

    public function getGrupoEmpresas($id_usuario)
    {
        $consulta = DB::select("select nombre_largo,id_grupo_empresa, habilitado
                                from grupo_empresa           
                                where consultor_tis=:id_consultor",['id_consultor'=>$id_usuario]);
        return $consulta;
    }
    
    public function GetNombreUsuario($id_usuario)
    {
        $consulta = DB::select("select nombre,apellido
                                from usuario
                                where id_usuario=:usr",['usr'=>$id_usuario]);
        return $consulta;
    }
    public function getNumeroNotificaciones($id_usuario,$fin_gestion,$ini_gestion)
    {
        $c=DB::select("SELECT COUNT(*) as numer
                       FROM notificacion
                       WHERE usuario_destino = :usuario AND fecha <= :fin_gestion AND fecha>= :ini_gestion AND leido=0",['usuario'=>$id_usuario,'ini_gestion'=>$ini_gestion,'fin_gestion'=>$fin_gestion]);
        return $c;
    }
    public function getNotificaciones($id_usuario,$fin_gestion,$ini_gestion)
    {
        $consulta = DB::select("SELECT  id_notificacion,usuario, descripcion, enlace, fecha, leido
                                FROM notificacion, tipo_notificacion
                                WHERE (tipo_notificacion = id_tipo_notificacion
                                AND usuario_destino = :usuario) AND fecha <= :fin_gestion AND fecha>=:ini_gestion AND leido=0
                                ORDER BY fecha DESC",['usuario'=>$id_usuario,'ini_gestion'=>$ini_gestion,'fin_gestion'=>$fin_gestion]);
        return $consulta;
    }
    public function getTipoUsuario($id_usuario)
    {
        $consulta = DB::select("SELECT i.descripcion
                                FROM usuario u, tipo_usuario i
                                WHERE u.id_usuario = :id
                                AND u.tipo_usuario = i.id_tipo_usuario",['id'=>$id_usuario]);
        return $consulta;
    }
    public function setNotificaciones($leido,$id_notificacion)
    {
        DB::update("UPDATE notificacion 
                    SET  leido=:c WHERE id_notificacion =:a",['c'=>$leido,'a'=>$id_notificacion]);
    }
    public function setMensaje($mensaje,$id_usuario,$asunto)
    {
        DB::insert("INSERT INTO mensaje(fecha_hora, contenido, leido, de_usuario, asunto, visible)
                    VALUES (NOW(),:mensaje,0,:id_usuario,:asunto,1)",['mensaje'=>$mensaje,'id_usuario'=>$id_usuario,'asunto'=>$asunto]);
    }

    public function insertarUsuario($usuario,$clave,$nombre,$apellido,$telefono,$email,$foto,$habilitado,$tipo,$id_gestion)
    {
        DB::insert("INSERT INTO usuario (nombre_usuario,clave,nombre,apellido,telefono, email,foto, habilitado, tipo_usuario,gestion)
                    VALUES (:usuario,:clave,:nombre_rep,:apellido_rep,:telefono_rep,:eMail,:foto,:habilitado,:tipo,:id_gestion)",['usuario'=>$usuario,'clave'=>$clave,'nombre_rep'=>$nombre,'apellido_rep'=>$apellido,'telefono_rep'=>$telefono,'eMail'=>$email,'foto'=>$foto,'habilitado'=>$habilitado,'tipo'=>$tipo,'id_gestion'=>$id_gestion]);
    }
    public function getIdUsuario($nombre_usuario,$clave)
    {
        $consulta = DB::select("SELECT id_usuario
                                FROM usuario
                                WHERE nombre_usuario = :username and clave = :clave",['username'=>$nombre_usuario,'clave'=>$clave]);
        return $consulta;
    }
    public function insertarRol($idU,$idrol)
    {
        DB::insert("INSERT INTO rol_integrante (integrante,rol)
                    VALUES (:id_usuario,:id_rol)",['id_usuario'=>$idU,'id_rol'=>$idrol]);
    }
    public function cambiarAJefeConsultor($id_consultor)
    {
    DB::update("UPDATE usuario 
                  SET  tipo_usuario= 2 WHERE id_usuario =:id",['id'=>$id_consultor]);

    }
     
    public function cambiarAConsultor($id_consultor)
    {
       DB::update("UPDATE usuario 
                  SET  tipo_usuario= 3 WHERE id_usuario =:id",['id'=>$id_consultor]);

    } 
       
    public function habilitarUsuario($id_usuario)
    {
        DB::update("UPDATE usuario 
                  SET  habilitado= 1 WHERE id_usuario =:id",['id'=>$id_usuario]);

    }
    
    public function deshabilitarUsuario($id_usuario)
    {
       DB::update("UPDATE usuario 
                  SET  habilitado= 0 WHERE id_usuario =:id",['id'=>$id_usuario]);
    }

   public function iniciarNuevaGestion($gestion,$inicio,$fin,$descripcion){
     DB::update("INSERT INTO gestion_empresa_tis(gestion,fecha_ini_gestion,fecha_fin_gestion,gestion_activa,descripcion_gestion)
                        VALUES(:gestion, :inicio, :fin, 1, :descripcion)",['gestion'=>$gestion,'inicio'=>$inicio,'fin'=>$fin,'descripcion'=>$descripcion]);


   }

   public function getMensajes(){

    $consulta = DB::select("SELECT  id_mensaje, fecha_hora, contenido, leido, de_usuario, asunto, visible, nombre, apellido,descripcion
                            FROM mensaje, usuario, tipo_usuario
                            where mensaje.de_usuario=usuario.id_usuario AND usuario.tipo_usuario=tipo_usuario.id_tipo_usuario
                            ORDER BY fecha_hora DESC");
    return $consulta;


   }

  public function  volverVisibleMensaje($id_mensaje){
    DB::update("UPDATE mensaje 
                  SET  visible= 1 WHERE id_mensaje =:id",['id'=>$id_mensaje]);

   }

   public function volverInvisibleMensaje($id_mensaje){
     DB::update("UPDATE mensaje 
                  SET  visible= 0 WHERE id_mensaje =:id",['id'=>$id_mensaje]);

   }
   public function cambiarFoto($id_usuario,$destinio2){
    DB::update("UPDATE usuario  
                  SET   foto = :d WHERE id_usuario = :id",['id'=>$id_usuario,'d'=>$destinio2]);

                    
   }

}
