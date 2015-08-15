<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Usuario extends Model
{
    public function GetUsuario($nombre,$clave)
    {
        //$salt="$2x$07$./f4af7kJi1jdaxlswE34$";
        //$pass=crypt($clave, $salt);
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
}
