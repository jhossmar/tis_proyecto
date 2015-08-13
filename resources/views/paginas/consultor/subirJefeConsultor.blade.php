@extends('header')
@section('contenido')
<div>
	<ul class="breadcrumb">
		<li>
			<a href="index">Inicio</a>
			<span class="divider">/</span>
		</li>
		<li>
		  <a href="subir_consultor_jefe">Publicar avisos</a>
		</li>
	</ul>
</div>
<center><h3>Publicar Avisos</h3></center>
<div class="row-fluid">
	<div class="box span12">
		<div class="box-header well">
			<h2><i class="icon-edit"></i> Formulario de publicaci&oacute;n de avisos</h2>
		</div>
		<div class="box-content">
		@if($gestion['gestion_valida'])						
		  <form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" enctype="multipart/form-data" action="subir_consultor_jefe" accept-charset="utf-8">
				<fieldset>
				<input type="hidden" name="_token" value="{{csrf_token()}}">
				<div class="control-group">
				  <label class="control-label" for="tituloD">T&iacute;tulo: </label>
				  <div class="controls">
   					<input type="text" placeholder="T&iacute;tulo del aviso" name="tituloD" id="tituloD">
				  </div>
				</div>
				<div class="control-group">
					<label class="control-label" for="descripcion">Descripci&oacute;n:</label>
					<div class="controls">
						<textarea id="descripcion" placeholder="Descripci&oacute;n del aviso" name="descripcion"></textarea>
					</div>
				</div>
        <label class="ayudas"> El archivo a subir debe ser de 1 Mb maximo :</label>
				<div class="control-group">
				  <label class="control-label" for="fileInput">Documento:</label>
				  <div class="controls">
						<input class="input-file uniform_on" name="documento" id="documento"  type="file" />
						<label class="error">@if(isset($error_doc)){{$error_doc}} @endif</label>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
				    <button name="enviar"type="submit" class="btn btn-primary" id="enviar">Publicar</button>
				 	  <button type="reset" class="btn">Cancelar</button>
					</div>
				</div>
			  </fieldset>
			</form>
		@else		
			<div align="center">
				<h4><i class="icon-info-sign"></i>
				La gesti&oacute;n no est&aacute; disponible, contacte con el administrador del sistema.</h4>
			</div>
		@endif
	  </div>
	</div>
</div>
@stop