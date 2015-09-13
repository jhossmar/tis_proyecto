@extends('header')
@section('contenido')
<div>
	<ul class="breadcrumb">
		<li>
			<a href={{url("index")}}>Inicio</a>
			<span class="divider">/</span>
		</li>
		<li>
		  <a href={{url("mensajes")}}>Espacio de Discuci&oacute;n</a>
		</li>
	</ul>
</div>
<center><h3>Espacio de Discuci&oacute;n</h3></center>
@if($gestion['gestion_valida'])
	<div class="row-fluid">
		<div class="box span12">
			<div class="box-header well">
				<h2><i class="icon-check"></i> Publicar Comentario </h2>
			</div>
			<div class="box-content">
				<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" enctype="multipart/form-data" action="insert" accept-charset="utf-8">
				  <input type="hidden" name="_token" value="{{csrf_token()}}"></input>
					<fieldset>
					  <div class="control-group">
						  <label class="control-label" for="tituloD">T&iacute;tulo </label>
						  <div class="controls">
								<input type="text" placeholder="Titulo del comentario" name="tituloD" id="tituloD">
						  </div>
						</div>
						<div class="control-group">
						  <label class="control-label" for="fileInput">Comentario:</label>
						  <div class="controls">
								<textarea id="mensaje" name="mensaje" placeholder="Escribir el comentario"></textarea>
						  </div>
						</div>							
						<div class="control-group">
							<div class="controls">
						    <button name="enviar"type="submit" class="btn btn-primary" id="enviar"><i class="icon-ok"></i> Enviar</button>
 							  <button type="reset" class="btn"><i class="icon-remove"></i> Cancelar</button>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="box span12">
			<div class="box-header well">
				<h2><i class="icon-check"></i> Comentarios</h2>
				<div class="box-icon">
					<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
				</div>	
			</div>		
			<div class="box-content" id="ventanachat">
			</div>				
		</div><!--/span-->
	</div><!-- fin row -->
<script stype="text/javascript">
	function ventanachat()
	{
		var xmlHttp;
		if (window.XMLHttpRequest)
	  {
		  xmlHttp=new XMLHttpRequest();
	  }
	  else
		{
		  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}				 
		xmlHttp.onreadystatechange=function()
		{
			if(xmlHttp.readyState==4)
			{
				document.getElementById("ventanachat").innerHTML=xmlHttp.responseText;
				setTimeout('ventanachat()', 1000);
			}					
		}
			xmlHttp.open("POST","mensajes",true);						
			
			var data = "_token="+{{csrf_token()}};
      xmlhttp.send(data);			
		  xmlHttp.send(null);
	}
	window.onload = function startrefresh()
	{
		setTimeout('ventanachat()',1000);
	}
</script>		
@else
	<div class="row-fluid">
		<div class="box span12">
			<div class="box-header well">
				<h2><i class="icon-check"></i> Comentarios</h2>
			</div>	
			<div class="box-content">
				<div align="center">
			    <h4><i class="icon-info-sign"></i>
			    La gesti&oacute;n no est&aacute; disponible, contacte con el administrador del sistema.</h4>
			  </div>
			</div>	
		</div>
	</div>
@endif
@stop