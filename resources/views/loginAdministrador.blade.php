
@include('header')
@section('contenido')
<div class="row-fluid">
	<div class="well span5 center login-box">
		<div class="alert alert-info">
			Por favor ingrese su nombre de usuario y contrase&ntilde;a asociada, caso contrario puede volver al <strong><a href="index">Inicio</a></strong>
		</div>
		<form class="form-horizontal" action="login" method="post"accept-charset="utf-8">
			<fieldset>
				<div class="input-prepend">
					<span class="add-on"><i class="icon-user"></i></span><input autofocus placeholder="Usuario" class="input-large span10" name="username" id="username" type="text">
				</div>
				<div class="clearfix"></div>
				    <div class="input-prepend">
						<span class="add-on"><i class="icon-lock"></i></span><input placeholder="Contrase&ntilde;a" class="input-large span10" name="password" id="password" type="password">
					</div>
				</div>
				<div class="clearfix"></div>
					<p class="center span5">
					<button type="submit" class="btn btn-primary">Ingresar</button>
					</p>
				</div>	
		    </fieldset>
		</form>
	</div><!--/span-->
</div><!--/row-->
@stop