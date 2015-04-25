<?php
$titulo="P&aacute;gina de inicio Integrante Grupo Empresa";
include("conexion/verificar_gestion.php");
session_start();
/*------------------VERIFICAR QUE SEAL EL CONSULTOR------------------------*/
if(isset($_SESSION['nombre_usuario']) && $_SESSION['tipo']!=5)
{/*SI EL QUE INGRESO A NUESTRA PAGINA ES CONSULTOR DE CUALQUIER TIPO*/
		$home="";
		switch  ($_SESSION['tipo']){
	            case (4) :
	                	$home="home_grupo.php";
	                    break;
	            case (3) :
	                	$home="home_consultor.php";
	                    break;
	            case (2) :
	                	$home="home_consultor_jefe.php";
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
 ?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="home_consultor.php">Inicio</a>
						<span class="divider">/</span>
					</li>
					<li>
						<a href="home_consultor.php">Espacio de discusi&oacute;n </a>
					</li>
				</ul>
			</div>
			<center><h3>Espacio de discusi&oacute;n</h3></center>
			<br>



            <div class="row-fluid">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-bullhorn"></i> Espacio de discusi&oacute;n global</h2>
                        <div class="box-icon">
								<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>


					<div class="box-content alerts box-content">

                                    <div id="ventanachat">

                              <script type="text/javascript">
                                    ventanachat();
                              </script>
                             </div>

					</div>
				</div><!--/span-->
			</div><!-- fin row -->




             <div class="row-fluid">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-bullhorn"></i> Publicar</h2>
					</div>
					<div class="box-content alerts box-content">

                                <form name="form-data" class="form-horizontal cmxform"  id="signupForm" enctype="multipart/form-data"    action="insert.php" method="GET" accept-charset="utf-8">
								<fieldset>



                                   <br>
                                    <?php
                                        $sql=mysql_query("SELECT i.grupo_empresa
                                              FROM integrante i
                                              WHERE i.usuario=".$_SESSION['id']  );
                                        $res= mysql_fetch_assoc($sql);
                                        $id_grupo=(int)$res['grupo_empresa'];

                                          $sql2=mysql_query("SELECT u.nombre,u.apellido,u.id_usuario
                                                            FROM integrante i,usuario u
                                                            WHERE i.grupo_empresa=$id_grupo and i.usuario=u.id_usuario and i.usuario !=".$_SESSION['id']);

                                     ?>
                              <!--       <label class="control-label">  Para: &emsp;</label>

                                    <div class="controls">
                                                  <?php    echo "     <select id=\"para\" name=\"para\" data-rel=\"chosen\">   ";
                                                                                  while($row = mysql_fetch_array($sql2)) {
                                                                                            echo "<option value=\"".$row['id_usuario']."\">".$row['nombre']." ".$row['apellido']."</option>";
                                                                                  }
                                                                         echo "	</select>  ";
                                                  ?>
                                        	</div> -->


								<div class="control-group">
									<div class="controls">
										<textarea name="mensaje" id="enviachat" placeholder="Mensaje" style="width:80%; height: 125px; !important" ></textarea>
									</div>
								</div>

								<div class="control-group">
									<div class="controls">
						         <button name="enviar"type="submit" class="btn btn-primary" id="enviar">Publicar </button>
								 <button type="reset" class="btn">Cancelar</button>
								 </div>
								 </div>
						        </fieldset>
                                <input type="hidden" id="usua" name="usua" value="<?php echo $_SESSION['id']; ?>" />
							</form>



					</div>
				</div><!--/span-->
			</div><!-- fin row -->

























<?php include('footer.php'); ?>