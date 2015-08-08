@if($sesion_valida)<!-- $sesion_valida,Gestionvalida, $tipos_usuario,$num_grupo_empresa,$num_notificaciones,$num_consultor.$men-->
  <div class="box" style="margin-top:0">
	  <div class="box-header well">
			<h3><i class="icon-check"></i> Notificaciones</h3>
		  <div class="box-icon">
			  <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
		  </div>          
	  </div>
	  <div class="box-content">  
		@if($gestion_valida)
			@if($tipo_usuario==1)
			  @if($num_consultor>0)
					<ul class="dashboard-list">
						<li>{{ "Hay ".$num_consultor." nuevo(s) Consultore(s)" }}</li>
					</ul>
				@endif
				@if($num_grupo_empresa>0)
					<ul class="dashboard-list">
						<li>{{"Hay ".$num_grupo_empresa." nuevo(s) Grupo(s) Empresa"}}</li>
					</ul>
				@endif
				@if($men==1)
					<ul class="dashboard-list">
						<li>No hay notificaciones </li>
					</ul>
				@endif						
		  @elseif(($tipo_usuario==2 || $tipo_usuario==3))
				@if($num_notificaciones>0)
					<ul class="dashboard-list">
						<li>{{ "Consultor TIS tiene ".$num_notificaciones." notificacion(es) no le&iacute;da(s). Puede ver sus notificaciones"}} <b><a href='notificaciones.php'>aqu&iacute;</a></b></li>
					</ul>
				@else
					<ul class="dashboard-list">
						<li>Consultor TIS no tiene ninguna notificaci&oacute;n nueva.</li>
				  </ul>                  
				@endif         
			@elseif($tipo_usuario==4)
				@if($num_notificaciones>0)
					<ul class="dashboard-list">
						<li>Jefe Grupo Empresa tiene ".$num_notificaciones." notificacion(es) no le&iacute;da(s). Puede ver sus notificaciones <b><a href='notificaciones.php'>aqu&iacute;</a></b></li>
					</ul>
				@else
					<ul class="dashboard-list">
						<li>Jefe Grupo Empresa no tiene ninguna notificaci&oacute;n nueva.</li>
					</ul>
				@endif
			@else
				<ul class="dashboard-list">
					<li>Espacio no disponible.</li>
				</ul>
			@endif
		@endif
	  </div>
	</div>
@endif
<div class="box" style="margin-top:0">
	<div class="box-header well">
		<h3><i class="icon-calendar"></i> Fechas</h3>
		<div class="box-icon">
			<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
		</div>            
	</div>
	<div class="box-content">
		<ul class="dashboard-list">
			@if($gestion_valida)
				<li><b>{{"Gesti&oacute;n ".$nombre_gestion." :"}}</b>{{" Del ".strftime("%d/%m/%y",$fecha_ini)." hasta ".strftime("%d/%m/%y",$fecha_fin)}}</li>
				  @if($actividad->activo_1==1)
				    <li><b>Inicio convocatoria:</b>{{"Del ".$actividad->fecha_ini_1." hasta ".$actividad->fecha_fin_1 }}</li>
				  @endif
				  @if($actividad->activo_2==1)
					  <li><b>Registro de Grupo Empresas:</b>{{" Del ".$actividad->fecha_ini_2." hasta ".$actividad->fecha_fin_2 }}</li>
				  @endif
				  @if($actividad->activo_3==1)
					  <li><b>Entrega de Documentos:</b>{{" Del ".$actividad->fecha_ini_3." hasta ".$actividad->fecha_fin_3 }}</li>
				  @endif
				  @if($actividad->activo_4==1)
 					  <li><b>Firma de Contratos:</b>{{" Del ".$actividad->fecha_ini_4." hasta ".$actividad->fecha_fin_4}}</li>
				  @endif
				  @if($actividad->activo_5==1)
					  <li><b>Proceso de Desarrollo:</b>{{" Del ".$actividad->fecha_ini_5." hasta ".$actividad->fecha_fin_5}}</li>
				  @endif
				  @if($actividad->activo_6==1)
					  <li><b>Entrega de Productos:</b>{{" Del ".$actividad->fecha_ini_6." hasta ".$actividad->fecha_fin_6}}</li>
				  @endif
				  @if($actividad->activo_7==1)
  					<li><b>Cierre de la Convocatoria:</b>{{" Del ".$actividad->fecha_ini_7." hasta ".$actividad->fecha_fin_7}}</li>
				  @endif
			@else
				<li><b>No existe ninguna fecha definida</b></li>
			@endif
		</ul>
	</div>
</div>                    
<div class="datepicker"></div> <!--calendario-->             
		@if(!$sesion_valida)
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
												</div>
								 </div><!--/FORMULARIO DE INGRESO-->
				 </form>                
			</div>  <!-- FIN DE BARRA DE NAVEGACION DERECHA-->
			</div>
	@endif
</div>