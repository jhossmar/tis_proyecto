@extends('header')
@section('contenido')
   <div>
	  <ul class="breadcrumb">
			<li>
			  <a href="index.php">Inicio</a><span class="divider">/</span>
			</li>
		    <li>
			   <a href="iniciar_sesion_consultor.php">Iniciar sesi&oacute;n </a>
			</li>
			</ul>
	</div>

   <center><h3>Iniciar sesi&oacute;n:</h3></center>
      <div class="row-fluid">
	     <div class="box span12 center">
			 <div class="box-header well">
				  <h2><i class="icon-edit"></i> Formulario de inicio de sesi&oacute;n:</h2>
		     </div>
		 <div class="box-content">
		 <br>
	        <form class="form-horizontal" id="signupForm" style="text-align:left;" action="iniciar_sesion" method="post" accept-charset="utf-8">
							  <fieldset>
							  	 <input type="hidden" name="_token" value="{{csrf_token()}}">
								<div class="control-group">
								  <label class="control-label" for="name">Nombre de Usuario: </label>
								  <div class="controls">
									  <input placeholder="Usuario" name="username" type="text" id="username">
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="pass">Contrase&ntilde;a: </label>
								  <div class="controls">
									  <input type="password" placeholder="Contrase&ntilde;a" name="password" id="password">
								  </div>				
								<div class="control-group">
								  <div class="controls">
						            <button name="aceptar" type="submit" class="btn btn-primary" id="enviar">Ingresar</button>
								    <button type="reset" class="btn">Restablecer</button>
								 <label class="error">{{$error_sesion}}</label>
								  </div>
								</div>
							  </fieldset>
							</form>
		                </div>
				</div>
			</div>
@stop