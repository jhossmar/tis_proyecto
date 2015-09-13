@extends('header')
@section('contenido')
<div>
	<ul class="breadcrumb">
	  <li>
			<a href={{url("index")}}>Inicio</a>
			<span class="divider">/</span>
		</li>					
		<li>
			<a href={{url("formulario_entrega_producto")}}>Entrega Producto</a>
		</li>
	</ul>
</div>
<center><h3>Entrega Producto: @if(($entregas!=null)){{$entregas[0]->descripcion}}@endif</h3></center>
<div class="row-fluid">
	<div class="box span12">		
		<div class="box-content">	
			@if($gestion['gestion_valida'])
				@if($numIntegrantes>=3)
					@if($datos['actividad']->activo_5==1 && !$datos['actividad']->act_5_espera)
						@if(!empty($entregas))
							@foreach($entregas as $entrega)
							<div class="box-header well">
			          <h2><i class="icon-edit"></i> Formulario de Entrega de Producto</h2>
		          </div>
							<br>							
							<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" enctype="multipart/form-data" action="formulario_entrega_producto.php" accept-charset="utf-8">
								<fieldset>
								  <input type="hidden" name="_token" value="{{csrf_token()}}"></input>
									<div class="control-group">
								  	<label class="control-label">Descripci&oacute;n: </label>								  	
								  	<div class="controls">	
											<input class="disabled" type="text" name="descripcion" value={{$entrega->descripcion}} disabled=""/>
										</div>
									</div>
									<div class="control-group">
								  	<label class="control-label">Fecha Inicio: </label>
								  	<div class="controls">	
											<input class="disabled" type="text" name="fecha_ini" value={{$entrega->fecha_inicio}} disabled=""/>
										</div>
									</div>
									<div class="control-group">
								  	<label class="control-label">Fecha Fin: </label>
								  	<div class="controls">	
											<input class="disabled" type="text" name="fecha_fin" value={{$entrega->fecha_fin}} disabled=""/>
										</div>
									</div>
									<div class="control-group">
								  	<label class="control-label">Pago establecido: </label>
								  	<div class="controls">	
											<input class="disabled" type="text" value={{$entrega->pago_establecido}} disabled=""/> Pago recibido: 
											<input class="disabled" type="text" value={{$entrega->pago_recibido}} disabled=""/>
										</div>
									</div>									
									<div class="control-group">
								  	<label class="control-label">Responsable: </label>
								  	<div class="controls">	
								  	<input type="text" value={{$responsables[0]}} disabled=""/>											
										</div>
									</div>
									<div class="control-group">
								  	<label class="control-label">Enlace Producto: </label>
								  	<div class="controls">
								  	@if($entregas[0]->fecha_fin==date('y-m-d'))
											<input id="co_url" class="required defaultInvalid url" name="co_url" type="text" @if($entrega->enlace_producto!=null))value={{$entrega->enlace_producto}} @else value='http://' @endif/>
										@else
										<input id="co_url" class="disabled" name="co_url" type="text" @if($entrega->enlace_producto!=null))value={{$entrega->enlace_producto}} @else value='http://' @endif disabled=""/><spam> solo podra entregar el producto en la fecha final establecida </spam><i class="icon-time"></i>
										@endif
										</div>
									</div>
									@if($entregas[0]->fecha_fin==date('y-m-d'))
								  <div class="control-group">
								    <div class="controls">	
						          <button name="enviar"type="submit" class="btn btn-primary" id="enviar"><i class="icon-ok"></i> Enviar</button>
								      <button type="reset" class="btn"><i class="icon-remove"></i> Cancelar</button>
								    </div>
								  </div>
								  @endif								  
						    </fieldset>
						    @if(!is_null($entregas[0]->enlace_producto))
								  <b>Nota: </b>Ya fue registrada una entrega para este Subsistema, si desea puede actualizar el enlace de su producto en el transcurso del d&iacute;a de hoy.</br>
								@endif						
							</form>
							@endforeach
						@else
				      <div align="center">
				        <h4><i class="icon-info-sign"></i>
				          No se encontr&oacute; ning&uacute;na Entrega de Producto para hoy.</h4>
				      </div>
						@endif
					@else
						<div align="center">
				      <h4><i class=\"icon-info-sign\"></i>
				        La entrega de Subsistemas no est&aacute; disponible, contacte con el Jefe Consultor TIS.</h4>
				    </div>
					@endif						
				@else
					<div align="center">
				    <h4><i class="icon-info-sign"></i>
				      No puede enviar sus archivos, faltan integrantes.</h4>
				  </div>
				@endif
			@else
				<div align="center">
				  <h4><i class="icon-info-sign"></i>
				    La gesti&oacute;n no est&aacute; disponible, contacte con el administrador del sistema.</h4>
				</div>
			@endif							
		</div>	
	</div><!--/span-->  
</div><!-- fin row -->
@stop