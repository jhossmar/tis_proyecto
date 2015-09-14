@extends('header')
@section('contenido')
<div>
	<ul class="breadcrumb">					
		<li>
			<a href="index">Inicio</a><span class="divider">/</span>
		</li>
		<li>
			<a href='informacion_jefe_consultor'> Informaci&oacute;n del usuario </a><span class="divider">/</span>
		</li>
		<li>
			<a href='modificar_registro_jefe_consultor'> Modificar registro </a>
		</li>				
	</ul>
</div>
<center><h3>Modificar registro Consultor TIS</h3></center>
<div class="row-fluid">
	<div class="box span12 center">
		<div class="box-header well">
			<h2><i class="icon-edit"></i> Formulario de modificaci&oacute;n de datos</h2>					
		</div>
		<div class="box-content" id="formulario">
			<br>
     	<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" enctype="multipart/form-data" action="modificar_registro_consultor" accept-charset="utf-8">
			<fieldset>
			<input type="hidden" name="_token" value="{{csrf_token()}}"></input>
			<div class="control-group">
			  <label class="control-label" for="pass">Nombre: </label>
				  <div class="controls">
						<input type="text" placeholder="Nombre" name="firstname" class="firstnames" id="firstname" value={{$infUser[0]->nombre}}>
				  </div>
			</div>
			<div class="control-group">
			  <label class="control-label" for="pass">Apellido: </label>
			  <div class="controls">
					<input type="text" placeholder="Apellido" name="lastname" class="lastnames" id="lastname" value={{$infUser[0]->apellido}}>
			  </div>
			</div>
      <div class="control-group">
        <label class="control-label" for="pass">Nombre de Usuario: </label>
        <div class="controls">
          <input type="text" placeholder="Usuario" name="username" id="username" value={{$infUser[0]->nombre_usuario}}>
          <label id="error_usuario" class="error">@if(isset($error_usuario)){{$error_usuario}}@endif</label>
        </div>
      </div>     			
			<div class="control-group">
			  <label class="control-label" for="pass">Tel&eacute;fono: </label>
			  <div class="controls">
					<input type="text" placeholder="Tel&eacute;fono fijo" name="telf" class="telefonos" id="telf" value={{$infUser[0]->telefono}}>
				</div>
			</div>
			<div class="control-group">
			  <label class="control-label" for="pass">Correo Electr&oacute;nico:</label>
			  <div class="controls">
				  <input type="text" placeholder="E-mail" name="email"  id="email" value={{$infUser[0]->email}}>
				  <label id="error_email" class="error"><?php if(isset($error_email)){ echo $error_email; } ?></label>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
			    <button name="enviar"type="submit" class="btn btn-primary" id="enviar"><i class="icon-ok"></i> Guardar Cambios</button>
   			  <a href="javascript:history.back();" class="btn"><i class="icon-remove"></i> Cancelar</a>
			</div>
			</fieldset>
			</form>
	  </div>
  </div>
</div><!--/FORMULARIO DE INGRESO-->	
@stop