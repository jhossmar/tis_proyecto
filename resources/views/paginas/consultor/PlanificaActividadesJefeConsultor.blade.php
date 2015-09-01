@extends('header')
@section('contenido')
<div>
  <ul class="breadcrumb">
		<li>
	  	<a href="index">Inicio</a>
			<span class="divider">/</span>
		</li>
		<li>
			<a href="planificacion_actividades">Planificaci&oacute;n de actividades</a>
		</li>
	</ul>
</div>
<center><h3>Planificar las actividades de la Empresa TIS</h3></center>
@if($gestion['gestion_valida'])
	<div class="row-fluid" id="planificacion">
		<div class="span12">
			<ol>
			  <li><a class="lista" href="#lanzamiento">Lanzamiento Convocatoria P&uacute;blica</a></li>
			  <li><a class="lista" href="#registro">Registro de Grupo Empresas</a></li>
			  <li><a class="lista" href="#documentos">Entrega de Documentos</a></li>
			  <li><a class="lista" href="#contratos">Firma de Contratos</a></li>
			  <li><a class="lista" href="#desarrollo">Proceso de Desarrollo</a></li>
			  <li><a class="lista" href="#productos">Entrega de Productos</a></li>
			  <li><a class="lista" href="#cierre">Cierre de la Convocatoria</a></li>	  
			</ol> 
		</div>
	</div>
	@for ($i = 1; $i <= 7 ; $i++)	
	  <div class="row-fluid" id={{$fase[$i]}}>
		  <div class="box span12">
		    <div class="box-header well">
		      <h2><i class="icon-edit"></i>{{$subtitulo[$i]}}</h2>
		    </div>
		    <form name="form-data" class="form-horizontal cmxform" method="POST" id={{'form_'.$i}} action={{'planificacion_actividades/'.$i}} accept-charset="utf-8">
  		    <input type="hidden" name="_token" value="{{csrf_token()}}"></input>
  		    <div class="control-group">
		        <label class="control-label">Habilitado: </label>
		        <div class="controls">
		          <input type="checkbox" value={{'actividad_'.$i}} class="checkbox" id={{'actividad_'.$i}} name={{'newsletter_'.$i}}></input>
		        </div>
		      </div>
		      <fieldset id={{'actividad_'.$i.'_topics'}}>
		        <div class="control-group">
		          <label class="control-label">Desde:</label>
		          <div class="controls">	    
		            <input type="text" class="datepicker" data-date-format="dd/mm/yyyy" etitable="false" name={{'inicio_'.$i}} id={{'inicio_'.$i}} value="Definir fecha">
		          </div>
		        </div>
		        <div class="control-group">
		          <label class="control-label">Hasta:</label>
		          <div class="controls">
		            <input type="text" class="datepicker" etitable="false" name={{'fin_'.$i}} id={{'fin_'.$i}} value="Definir fecha">
		          </div>
		        </div>
		      </fieldset>
		      <div class="control-group">
		        <div class="controls">
		          <button name={{'enviar_'.$i}} type="submit" class="btn btn-primary" id={{'enviar_'.$i}}><i class="icon-ok"></i> Aceptar</button>
		          <button type="reset" class="btn"><i class="icon-remove"></i> Cancelar</button>
		        </div>
		      </div>
		    </form>
		    <label><b>Nota:</b> Esta actividad no restringe ninguna funcionalidad del sistema, solo se limita a la planificaci&oacute;n de la gesti&oacute;n actual .</label>
		  </div>
		</div>
	@endfor
@endif
@stop