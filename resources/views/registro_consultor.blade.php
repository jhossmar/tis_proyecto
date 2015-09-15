@extends('header')
@section('contenido')
<div>
	<ul class="breadcrumb">					
	<li>
	  <a href="index">Inicio</a><span class="divider">/</span>
	</li>
	<li>
	<a href="registro_consultor">Registro {{$quien_ingresa}}</a>
	</li>				
	</ul>
	</div>
	  <center><h3>{{$titulo}}</h3></center>
		<div class="row-fluid">
		  <div class="box span12 center">
						<div class="box-header well">
							<h2><i class="icon-edit"></i> Formulario de registro: Consultor TIS</h2>					
						</div>
						<div class="box-content" id="formulario">
							@if($gestion['gestion_valida']) 
						</br>
		                  	<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" enctype="multipart/form-data" accept-charset="utf-8" action="registro_consultor">
								<input type="hidden" name="_token" value="{{csrf_token()}}"></input>
								<fieldset>
								<div class="control-group">
								  <label class="control-label" for="pass">Nombre: </label>
								  <div class="controls">
									<input type="text" placeholder="Nombre" class="firstnames" name="firstname" id="firstname" value={{$nombre}} >
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="pass">Apellido: </label>
								  <div class="controls">
									<input type="text" placeholder="Apellido" name="lastname" class="lastnames" id="lastname" value={{$apellido}}>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="name">Nombre de Usuario: </label>
								  <div class="controls">
									<input placeholder="Usuario" name="username" type="text" id="username" value={{$usuario}}>
									<label id="error_user" class="error">{{$error_user}}</label>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="pass">Contrase&ntilde;a: </label>
								  <div class="controls">
									<input type="password" placeholder="Contrase&ntilde;a" name="password" id="password">
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="pass">Confirmar Contrase&ntilde;a: </label>
								  <div class="controls">
									<input type="password" placeholder="Confirmar Contrase&ntilde;a" name="confirm_password" id="confirm_password">
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="pass">Tel&eacute;fono: </label>
								  <div class="controls">
									<input type="text" placeholder="Tel&eacute;fono fijo" name="telf" class="telefonos" id="telf" value={{$telf}}>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="pass">Correo Electr&oacute;nico:</label>
								  <div class="controls">
									<input type="text" placeholder="E-mail" name="email"  id="email" value={{$eMail}}>
									<label id="error_email" class="error">{{$error_email}}</label>
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="fileInput">Curr&iacute;culo:</label>
								  <div class="controls">
									<input class="" name="pdf" id="pdf"  type="file" />
									<label id="error_curriculum" class="error">{{$error_curriculum}}</label>
								  </div>
								</div>
								<div class="control-group">
									<div class="controls">
						         <button name="enviar"type="submit" class="btn btn-primary" id="enviar"><i class="icon-ok"></i> Registrar</button>
								 <button type="reset" class="btn"><i class="icon-remove"></i> Restablecer</button>
								 </div>
								 </div>
						        </fieldset>
								</form>
								 
							@else
							<div align="center">
				                        <h4><i class="icon-info-sign"></i>
				                        No existe ninguna actividad para esta gesti&oacute;n.</h4>
				                      	</div>
				            @endif						
							 
		                </div>
				</div><!--/FORMULARIO DE INGRESO-->	
			</div>


@stop