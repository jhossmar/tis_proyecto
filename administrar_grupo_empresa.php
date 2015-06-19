<?php
    $titulo="Administrar Consultores TIS";
    include('conexion/conexion.php');
    $c = new Conexion;
    $c->EstablecerConexion();
    $conn = $c->GetConexion();
    session_start();
    include('header.php');
 ?>
	<div>
		<ul class="breadcrumb">
			<li>
				<a href="index.php">Inicio</a>
				<span class="divider">/</span>
			</li>
			<li>
				<a href="administrar_consultor.php">Administrar grupo empresas</a>
			</li>
		</ul>
	</div>
	<center><h3>Administrar Grupo empresas</h3></center>
	<div class="row-fluid">
        <div class="box span12">
			<div class="box-header well" data-original-title>
				<h2><i class="icon-user"></i> Grupo Empresas registradas</h2>
			</div>
			<div class="box-content">
            <?php 
                 $consulta = "SELECT u.nombre_usuario,u.habilitado,ge.nombre_corto,ge.nombre_largo,s.descripcion,u.id_usuario,u.clave
                              FROM usuario u,integrante i,grupo_empresa ge,sociedad s
                              WHERE  u.tipo_usuario = 4 and u.id_usuario=i.usuario and i.grupo_empresa=ge.id_grupo_empresa and ge.sociedad= s.id_sociedad ";
                 $resultado = mysql_query($consulta,$conn);
                 //$num_res=mysql_num_rows($resultado);
                 if(mysql_num_rows($resultado)>0){
              ?>
            <form method="post" action="conexion/admin_grupo.php" accept-charset="utf-8">
				<table class="table table-striped table-bordered  datatable">
				  <thead >
				    <tr >
					  <th>Usuario</th>
					  <th>Contrase&ntilde;a</th>
					  <th>Nombre corto</th>
					  <th>Nombre largo</th>
					  <th>Sociedad </th>
                      <th>Habilitado</th>
				    </tr>
				   </thead>
				 <tbody>
              <?php
                $identi=0;
                while($row = mysql_fetch_array($resultado))
                {
                    echo "<tr>
    					  <td ><input type=\"hidden\" id=a".$identi." name=a".$identi." value=".$row["id_usuario"]." ></input>".$row['nombre_usuario']."</td>
    					  <td>".$row["clave"]."</td>
    					  <td >".$row["nombre_corto"]."</td>
                          <td >".$row["nombre_largo"]."</td>
                          <td >".$row["descripcion"]."</td>";

                    $aux= $row["habilitado"];
                    if($aux=="1")
                    {
                        echo "<td class=\"center\"><center> <input type=\"checkbox\" id=c".$identi." name=c".$identi." checked></center></td>";
                    }
                    else
                    {
                        echo "<td class=\"center\"><center> <input type=\"checkbox\" id=c".$identi." name=c".$identi."></center></td>";
                    }
                    echo "</tr> ";
                    $identi++;
                }
              ?>
			 </tbody>
			 </table>
                 <?php echo "<input type=\"hidden\" id=count name=count value=".$identi." ></input>"; ?>
                               <div class="control-group">
								<div class="controls">
						         <button name="enviar"type="submit" class="btn btn-primary" id="enviar"><i class="icon-ok"></i> Guardar cambios</button>
								 <button type="reset" class="btn">Restablecer</button>
                                </div>
								 </div>

                    </form>
                   <?php }
                            else{
                              echo "<div align=\"center\">
                                <h4><i class=\"icon-info-sign\"></i>
                                Ninguna Grupo Empresa se ha registrado.</h4>
                                </div>";
                            }

                  ?>
					</div>
				</div><!--/span-->
				</div>
<?php include('footer.php'); ?>