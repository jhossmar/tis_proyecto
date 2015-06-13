<?php
	include('conexion.php');	
		class VerificarIntegrantes 
		{
	        public $numeroIntegrantes;
	        public $idGrupo;
	        public $cantidadFaltante;
	        public $metodo;
			function __construct($user)
			{
				$this->GetIdGrupoEmpresa($user);
				$this->GetCantidadIntegrantes();
				$this->CantidadValida();
				$this->GetMetodo();
			}
			public function GetMetodo()
			{
				global $conn;
                 $consulta_sql="SELECT id_metodologia
				                FROM  metodologia_grupo_empresa
				                WHERE id_grupo_empresa='$this->idGrupo'";
	             $consulta = mysql_query($consulta_sql,$conn)
		        or die("Could not execute the select query.");

	            $resultado = mysql_fetch_assoc($consulta);
	            
		        $idMetodo = (int)$resultado['id_metodologia'];
		        
                  $this->metodo=$idMetodo;		        
			}
			public function GetIdGrupoEmpresa($user)
			{
				global $conn;
				$idUser=0;
				$this->idGrupo=0;
                $consulta_sql="SELECT id_usuario
				                FROM  usuario
				                WHERE nombre_usuario='$user'";
	            $consulta = mysql_query($consulta_sql,$conn)
		        or die("Could not execute the select query.");

	            $resultado = mysql_fetch_assoc($consulta);

	            if(!empty($resultado['id_usuario']))
	            {
		           $idUser = (int)$resultado['id_usuario'];		          
		        }
		        if($idUser!=0)
		        {		           
                   $idGrupo_sql = "SELECT grupo_empresa
				                   FROM  integrante
				                   WHERE usuario=$idUser";
	               $consulta2 = mysql_query($idGrupo_sql,$conn)
		           or die("Could not execute the select query. ");

	               $resultado2 = mysql_fetch_assoc($consulta2);

	               if(!empty($resultado2['grupo_empresa']))
	               {
		              $this->idGrupo = (int) $resultado2['grupo_empresa'];
		           }
		        }		        		    
			}
			public function GetCantidadIntegrantes()
			{				  
			    global $conn; 
	            $consulta_sql="SELECT COUNT(*) as numero
				                FROM  integrante
				                WHERE grupo_empresa=$this->idGrupo";
	            $consulta = mysql_query($consulta_sql,$conn)
		        or die("Could not execute the select query.");

	            $resultado = mysql_fetch_assoc($consulta);

	            if(!empty($resultado['numero']))
	            {
		           $this->numeroIntegrantes = (int) $resultado['numero'];
		        }			              
		    }	
		    public function CantidadValida()
		    {
		    	$respuesta=false;
		    	$this->cantidadFaltante = 0;
		    	if($this->numeroIntegrantes<3)
		    	{
                  $this->cantidadFaltante = 3 - $this->numeroIntegrantes;
                  $respuesta=true;
		    	}
		    	return $respuesta;
		   }

	}		
?>
