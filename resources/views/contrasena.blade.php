@extends('header')
@section('contenido')

<div>
  <ul class="breadcrumb">
	 <li>
	   <a href="index">Inicio</a>
	   <span class="divider">/</span>
	 </li>
     <li>
		<a href="contrasena">recuperar contrasenia</a>
	 </li>
  </ul>
</div>
<center><h3>Recuperar contrasenia Sistema de apoyo TIS</h3></center>

<div class="row-fluid">
		   <div class="box span12">
			  <div class="box-header well">
			  	 <h2><i class="icon-lock"></i> Ayuda recuperar contrasenia</h2>
			  </div>
			<div class="box-content">
				<div class="alert alert-success">							
							ingrese su correo electronico al que le enviaremos su contraseña!
					</div>
					<form action='contrasena' method='post'>
                        <input type="hidden" name="_token" value="{{csrf_token()}}"></input>
                        <legend>correo electronico: </legend>
                        <div class="input-prepend">
                        	
                        	<input type="text" placeholder="E-mail" name="direccion"  id="direccion">
							<label id="error_email" class="error">{{$error_email}}</label>	
                        </div>                        
                        <br>
                        <input type="submit" name="aceptar" class="btn" value="enviar">
                    </form>

					</div>
		    </div><!--/span-->
			</div><!-- fin row -->



@stop