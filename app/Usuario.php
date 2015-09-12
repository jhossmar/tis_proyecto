<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Usuario extends Model
{
    public function GetUsuario($nombre,$clave)
    {
        $salt="$2x$07$./f4af7kJi1jdaxlswE34$";
        $pass=crypt($clave, $salt);
    	$consulta_sql = DB::select('select * 
    		                        from usuario
    		                        where nombre_usuario = :nombre and clave = :clave ',['nombre' => $nombre,'clave'=> $pass]);
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
}
