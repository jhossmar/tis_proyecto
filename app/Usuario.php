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

     public function getGrupoEmpresas(){

        $consulta_usuario = DB::select("SELECT u.nombre_usuario,u.habilitado,ge.nombre_corto,ge.nombre_largo,s.descripcion,u.id_usuario,u.clave
                FROM usuario u,integrante i,grupo_empresa ge,sociedad s
                WHERE  u.tipo_usuario = 4 and u.id_usuario=i.usuario and i.grupo_empresa=ge.id_grupo_empresa and ge.sociedad= s.id_sociedad");
           return $consulta_usuario;
     }
  
    public function getBitacorasSesion(){

         $consulta_usuario = DB::select("SELECT id_bitacora_sesion, fecha_hora, operacion, nombre_usuario,g.gestion,descripcion
                                         FROM bitacora_sesion b, usuario u, gestion_empresa_tis g,tipo_usuario
                                         WHERE id_usuario=usuario AND u.gestion=g.id_gestion  AND tipo_usuario=id_tipo_usuario");
         return $consulta_usuario;
    }

    public function getBitacorasBD(){

         $consulta_usuario = DB::select("SELECT id_bitacora,fecha_hora,u.nombre_usuario,viejo,nuevo,g.gestion, t.descripcion,tabla
                                         FROM bitacora_bd b, usuario u, gestion_empresa_tis g, tipo_usuario t
                                         WHERE u.id_usuario=b.usuario AND g.id_gestion=u.gestion AND u.tipo_usuario=t.id_tipo_usuario");
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
    }


}
