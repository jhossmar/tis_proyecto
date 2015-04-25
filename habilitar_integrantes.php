<?php
    $titulo="Habilitar Integrantes";
    include('conexion/verificar_gestion.php');
    session_start();
/*--------------------VERIFICAR QUE SEA EL CONSULTOR TIS------------------------*/
if(isset($_SESSION['nombre_usuario']) && ($_SESSION['tipo']!=2 && $_SESSION['tipo']!=3))
{/*SI EL QUE INGRESO A NUESTRA PAGINA ES CONSULTOR DE CUALQUIER TIPO*/
		$home="";
		switch  ($_SESSION['tipo']){
				case (5) :
	                	$home="home_integrante.php";
	                    break;
	            case (4) :
	                	$home="home_grupo.php";
	                    break;
	            case (2) :
	                	$home="home_consultor_jefe.php";
	                    break;
	            case (3) :
	                	$home="home_consultor.php";
	                    break;
	            case (1) :
	                    $home="home_admin.php";
	                    break;
	          }
		header("Location: ".$home);
}
elseif(!isset($_SESSION['nombre_usuario'])){
	header("Location: index.php");
}
/*----------------------FIN VERIFICACION------------------------------------*/
include('header.php');
$id_grupoem = $_GET['value'];
?>

    <div>
        <ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a>
						<span class="divider">/</span>
					</li>
					<li>
						<a href="administrar_grupo.php">Administrar Grupo Empresas</a>
                        <span class="divider">/</span>
					</li>
                    <li>
                        <a href="habilitar_integrantes.php?value=<?php echo $id_grupoem?>">Habilitar Integrantes</a>
                    </li>
				</ul>
    </div>
    <center><h3>Habilitar Integrantes</h3></center>
    <div class="row-fluid">
	    <div class="box span12" id="print">
		    <div class="box-header well" data-original-title>
                <h2><i class="icon-check"></i> Integrantes de la Empresa <?php /*AQUI FALTA : NOMBRE DE LA EMPRESA CUYOS INTEGRANTES QUEREMOS ADMINISTRAR*/?></h2>
            </div>
            <div class="box-content">
                <?php
                    if($gestion_valida){

                    /*de esta consulta, salen todos los trabajadores de la empresa, la cual pertenece a la empresa que a su vez
                    pertenece al usuario de la sesion actual*/
                    $integrantes ="SELECT *
                               from integrante i, usuario u, carrera c
                               where grupo_empresa='$id_grupoem' and  u.id_usuario=i.usuario AND i.carrera=c.id_carrera and u.tipo_usuario=5";
                    $resultado = mysql_query($integrantes);
                    $cantidad = mysql_num_rows($resultado);
                        if($cantidad > 0){
                ?>
                <form name="form-data" class="form-horizontal cmxform" method="POST" action="conexion/validar_habilitar_integrante.php" accept-charset="utf-8">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>

								<th>Nombre</th>
								<th>Apellido</th>
							    <th>Tel&eacute;fono</th>
								<th>Correo Electr&oacute;nico</th>
								<th>C&oacute;digo SIS</th>
							    <th><center>Habilitado</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $identi=0;
                                while($row = mysql_fetch_array($resultado)){
                                    echo "
                                    <tr>

                                        <td><input type=\"hidden\" id=a".$identi." name=a".$identi." value=\"".$row["id_usuario"]."\" >".$row["nombre"]."</td>
    								    <td>".$row["apellido"]."</td>
    								    <td>".$row["telefono"]."</td>
    								    <td>".$row["email"]."</td>
    								    <td>".$row["codigo_sis"]."</td> ";
                                    $aux = $row['habilitado'];
                                    if($aux=="1"){
                                        echo "<td ><center> <input type=\"checkbox\" id=b".$identi." name=b".$identi."  checked ></center></td>";
                                    }
                                    else{
                                        echo "<td class=\"center\"><center> <input type=\"checkbox\" id=b".$identi." name=b".$identi."></center></td>";
                                    }
                                    echo "</tr>";
                                    //echo $identi;
                                    $identi++;
                                }
                            ?>
                            <input type="hidden" id="grupo" name="grupo" value=<?php echo $id_grupoem ?> ></input>
                        </tbody>
                    </table>
                    <div class = "control-group">
                        <button name="enviar"type="submit" class="btn btn-primary" id="enviar"><i class="icon-ok"></i> Guardar Cambios</button>
                        <a href="habilitar_integrantes.php?value=<?php echo $id_grupoem;?>" rel="activi"><button type="button" class="btn" ><i class="icon-remove"></i> Restablecer</button></a>
                    </div>
                </form>
                <?php
                        }else{
                            echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        La Grupo Empresa no tiene registrado m&aacute;s integrantes.</h4>
				                      	</div>";
                        }
                    }else{
                        echo "<div align=\"center\">
				                        <h4><i class=\"icon-info-sign\"></i>
				                        La gesti&oacute;n no est&aacute; disponible, contacte con el administrador del sistema.</h4>
				                      	</div>";
                    }
                ?>
            </div>
        </div>
    </div>

<?php include('footer.php'); ?>