<!-- INICIO DE BARRA DERECHA-->
<?php
		if(!isset($titulo))
		{
			header('Location: index.php');
		}		 
		require_once("conexion/verificar_actividades.php");

		$VerificarA = new VerificarActividades();
        $GestionValida = $VerificarA->GetGestionValida();
        $VerificarA->Actividad1();
        $VerificarA->Actividad2();
        $VerificarA->Actividad3();
        $VerificarA->Actividad4();
        $VerificarA->Actividad5();
        $VerificarA->Actividad6();
        $VerificarA->Actividad7();  
        
        $c = new Conexion;
        $c->EstablecerConexion();
        $conn = $c->GetConexion();       
?>
			<div class="span2">
				<?php if($sesion_valida) /*SI LA SESION EL VALIDA MOSTRAR*/
				{ ?>
					<div class="box" style="margin-top:0;">
						<div class="box-header well">
							<h3><i class="icon-check"></i> Notificaciones</h3>
							<div class="box-icon">
								<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							</div>					
						</div>
						<div class="box-content">
                        <?php
                        	if ($GestionValida){
                        		
                        	$usuario=$_SESSION['id'];
                        	$c = "SELECT COUNT(*) as numer
                     		FROM notificacion
                     		WHERE usuario_destino = '$usuario' AND fecha <= '$VerificarA->fin_gestion 23:59:59' AND fecha>='$VerificarA->ini_gestion 00:00:01' AND leido=0";
	               			$r = mysql_query($c,$conn);
	               			$res = mysql_fetch_array( $r);
	               			$num=  $res['numer'];
                          if($_SESSION['tipo']==1) 
                          {
                                include("./conexion/notificaciones_admin.php");
                          }
                         elseif (($_SESSION['tipo']==2 || $_SESSION['tipo']==3)) {
                         	if ($num>0) {
                         		echo "<ul class=\"dashboard-list\">
	                  				<li>Consultor TIS tiene ".$num." notificacion(es) no le&iacute;da(s). Puede ver sus notificaciones <b><a href='notificaciones.php'>aqu&iacute;</a></b></li>
	                  			</ul>";
                         	}else{
                         		echo "<ul class=\"dashboard-list\">
	                  				<li>Consultor TIS no tiene ninguna notificaci&oacute;n nueva.</li>
	                  			</ul>";
                         	}
                         	
                         }elseif ($_SESSION['tipo']==4 ) {
                         	if ($num>0) {
                         		echo "<ul class=\"dashboard-list\">
	                  				<li>Jefe Grupo Empresa tiene ".$num." notificacion(es) no le&iacute;da(s). Puede ver sus notificaciones <b><a href='notificaciones.php'>aqu&iacute;</a></b></li>
	                  			</ul>";
                         	}else{
                         		echo "<ul class=\"dashboard-list\">
	                  				<li>Jefe Grupo Empresa no tiene ninguna notificaci&oacute;n nueva.</li>
	                  			</ul>";
                         	}
                         }else{?>
	                  		<ul class="dashboard-list">
	                  			<li>Espacio no disponible.</li>
	                  		</ul>
                          <?php } 
                          }else{
                          	echo "<ul class=\"dashboard-list\">
	                  				<li>Espacio no disponible.</li>
	                  			</ul>";
                          } ?>
		                 </div>
				</div>
				<div class="box" style="">
						<div class="box-header well">
							<h3><i class="icon-calendar"></i> Fechas</h3>
							<div class="box-icon">
								<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							</div>						
						</div>
						<div class="box-content">
						<ul class="dashboard-list">
						  
						<?php if ($GestionValida){
							echo "<li><b>Gesti&oacute;n ".$VerificarA->nombre_gestion.":</b> Del ".strftime("%d/%m/%y",$VerificarA->fecha_ini)." hasta ".strftime("%d/%m/%y",$VerificarA->fecha_fin)."</li>";
							if ($VerificarA->activo_1==1) {
								echo "<li><b>Inicio convocatoria:</b> Del ".$VerificarA->fecha_ini_1." hasta ".$VerificarA->fecha_fin_1."</li>";
							}
							if ($VerificarA->activo_2==1) {
								echo "<li><b>Registro de Grupo Empresas:</b> Del ".$VerificarA->fecha_ini_2." hasta ".$VerificarA->fecha_fin_2."</li>";
							}
							if ($VerificarA->activo_3==1) {
								echo "<li><b>Entrega de Documentos:</b> Del ".$VerificarA->fecha_ini_3." hasta ".$VerificarA->fecha_fin_3."</li>";
							}
							if ($VerificarA->activo_4==1) {
								echo "<li><b>Firma de Contratos:</b> Del ".$VerificarA->fecha_ini_4." hasta ".$VerificarA->fecha_fin_4."</li>";
							}
							if ($VerificarA->activo_5==1) {
								echo "<li><b>Proceso de Desarrollo:</b> Del ".$VerificarA->fecha_ini_5." hasta ".$VerificarA->fecha_fin_5."</li>";
							}
							if ($VerificarA->activo_6==1) {
								echo "<li><b>Entrega de Productos:</b> Del ".$VerificarA->fecha_ini_6." hasta ".$VerificarA->fecha_fin_6."</li>";
							}
							if ($VerificarA->activo_7==1) {
								echo "<li><b>Cierre de la Convocatoria:</b> Del ".$VerificarA->fecha_ini_7." hasta ".$VerificarA->fecha_fin_7."</li>";
						    }					
						}else{
							echo "No existe ninguna fecha definida.";
						}?>
						</ul>
			                  		     
				        </div>
				</div>	
				<?php } ?>
						                 		
	             <div class="datepicker"></div>                
	                  
				<!--/span2-->
				<?php if(!$sesion_valida){ ?>
				<div class="box" style="">
						<div class="box-header well">
							<h2><i class="icon-check"></i> Nota</h2>
												
						</div>
						<div class="box-content">
	                  		Para ingresar al sistema su Grupo Empresa debe estar previamente <a href="registro_grupo.php">registrada</a> en el Sistema.	        
		                 </div>
				</div>
				<div class="box navegacion-derecha">
						<div class="box-header well">
							<h2><i class="icon-edit"></i> Grupo Empresa</h2>					
						</div>
						<div class="box-content">
	                  		<form class="form" action="conexion/verificar.php" method="post">
									<input name="tipo" value=4 type="hidden"><!-- CAMPO HIDDEN PARA GRUPO CAMBIAR¡¡-->						
									<div class="input-prepend">
										<span class="add-on"><i class="icon-user"></i></span><input placeholder="Grupo Empresa" class="input-large span10" name="username" id="username" type="text"  />
									</div>
									<div class="clearfix"></div>

									<div class="input-prepend">								
										<span class="add-on"><i class="icon-lock"></i></span><input placeholder="Contrase&ntilde;a" class="input-large span10" name="password" id="password" type="password"/>
									</div>
									
									<div class="clearfix"></div>									
									<p class="center">
									<button type="submit" class="btn btn-primary">Ingresar</button>
									</p>
								
							</form>            
		                  </div>
				</div><!--/FORMULARIO DE INGRESO-->
				<?php } ?>
			</div>	<!-- FIN DE BARRA DE NAVEGACION DERECHA-->