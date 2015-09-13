@extends('header')
@section('contenido')
<script type="text/javascript">
	function imprimir()
	{
    var objeto=document.getElementById('print');  //obtenemos el objeto a imprimir
    var ventana=window.open('','_blank');  //abrimos una ventana vacía nueva
    ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
    ventana.document.close();  //cerramos el documento

  	var css = ventana.document.createElement("link");
	  css.setAttribute("href", "css/style.css");
	  css.setAttribute("rel", "stylesheet");
	  css.setAttribute("type", "text/css");
	  ventana.document.head.appendChild(css);

    ventana.print();  //imprimimos la ventana
    ventana.close();  //cerramos la ventana
  }
</script>
<div>
  <ul class="breadcrumb">					
		<li>
			<a href={{url("index")}}>Inicio</a><span class="divider">/</span>
		</li>
		<li>
			<a href={{url('info_grupo')}}> Informaci&oacute;n de usuario </a>
		</li>
	</ul>
</div>
<center><h3>Informaci&oacute;n de la Grupo Empresa</h3></center>
<div class="row-fluid">
	<div class="box span12 " id="print">
		@if($tipo_usuario==5)
		
		@elseif($tipo_usuario==4)
		  <div class="box-header well">
				<h2><i class="icon-info-sign"></i> Informaci&oacute;n de la Grupo Empresa</h2>					
			</div>
			<div class="box-content padding-in">
				@if($representante!=null && $inf_grupo!=null)
					<table class="table table-bordered">
						<thead>
							<th>
								<h4>Grupo Empresa</h4>
							</th>
						</thead>
						<tbody>
							<tr>
								<td><strong>Nombre largo: </strong></td>
								<td class="center">{{$inf_grupo[0]->nombre_largo." ".$inf_grupo[0]->abreviatura}}</td>
							</tr>
							<tr>
								<td><strong>Nombre corto: </strong></td>
								<td class="center">{{$inf_grupo[0]->nombre_corto." ".$inf_grupo[0]->abreviatura}}</td>
							</tr>									
							<tr>
								<td><strong>Consultor TIS: </strong></td>
								<td class="center">{{$inf_grupo[0]->nombre." ".$inf_grupo[0]->apellido}}</td>
							</tr>
							<tr>
								<td><strong>Habilitado: </strong></td>
								<td class="center">@if($inf_grupo[0]->habilitado==1)si @else no @endif</td>
							</tr>
							<tr>
								<td colspan="2"><h4>Representante Legal:</h4></td>								
							</tr>
							<tr>
								<td><strong>Nombre de Usuario: </strong></td>
								<td class="center">{{$nombre_usuario}}</td>
							</tr>
							<tr>
								<td><strong>Nombre: </strong></td>
								<td class="center">{{$representante[0]->nombre}}</td>
							</tr>
							<tr>
								<td><strong>Apellido: </strong></td>
								<td class="center">{{$representante[0]->apellido}}</td>
							</tr>
							<tr>
								<td><strong>Tel&eacute;fono: </strong></td>
								<td class="center">{{$representante[0]->telefono}}</td>
							</tr>
							<tr>
								<td><strong>Correo electr&oacute;nico: </strong></td>
								<td class="center">{{$representante[0]->email}}</td>
							</tr>
							<tr>
								<td><strong>C&oacute;digo SIS: </strong></td>
								<td class="center">{{$representante[0]->codigo_sis}}</td>
							</tr>
							<tr>
								<td><strong>Carrera: </strong></td>
								<td class="center">{{$representante[0]->nombre_carrera}}</td>
							</tr>
							<tr>
								<td><strong>Habilitado: </strong></td>
								<td class="center">{{$representante[0]->habilitado}}</td>               
							</tr>
							<tr>
								<td><strong>Rol(es): </strong></td>
								<td class="center">
								  @foreach($roles as $rol)			                   
			              <p>{{$rol->nombre}}</p>
			            @endforeach
							  </td>                          
							</tr>                                     
					  </tbody>
					</table>
				@else
					<center><h4>No se Encontro ning&uacute;n registro</h4></center>
				@endif								
				<div class="row-fluid">
				  <div class="span12" style="padding:10px;">  
					 	<button type="button" class="btn btn-primary" onclick="imprimir();"><i class="icon-print"></i> Imprimir</button>								
					</div>
				</div>
		  </div>
		@endif
	</div>
</div>
@stop