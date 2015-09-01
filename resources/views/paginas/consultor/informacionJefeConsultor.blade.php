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
			<a href="index">Inicio</a><span class="divider">/</span>
		</li>
		<li>
				<a href='informacion_jefe_consultor'> Informaci&oacute;n del usuario </a>
		</li>				
	</ul>
</div>
<center><h3>Informaci&oacute;n Consultor TIS</h3></center>
<div class="row-fluid">
	<div class="box span12 center" id="print">
		<div class="box-header well">
			<h2><i class="icon-info-sign"></i> Informaci&oacute;n del usuario: {{$nombre_usuario}}</h2>					
		</div>
		<div class="box-content padding-in" style="text-align:left;" >
		@if(empty($infUser))
			<h4>No se Encontro ning&uacute;n registro</h4>
		@else
		  <table class="table table-bordered">
			  <thead>
					<tr>
						<th>Atributo</th>
						<th>Valor</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Nombre de Usuario: </td>
						<td class="center">{{$nombre_usuario}}</td>                                      
					</tr>
					<tr>
					  <td>Nombre: </td>
						<td class="center">{{ $infUser[0]->nombre }}</td>                                       
					</tr>
					<tr>
						<td>Apellido: </td>
						<td class="center"> {{$infUser[0]->apellido }}</td>                                      
					</tr>
					<tr>
						<td>Tel&eacute;fono: </td>
						<td class="center">{{ $infUser[0]->telefono }}</td>                                     
					</tr>
					<tr>
						<td>Correo electr&oacute;nico: </td>
						<td class="center">{{ $infUser[0]->email }}</td>                          
					</tr>
					<tr>
						<td>Curr&iacute;culo:</td>
						<td class="center">
						  @if(isset($infUser[0]->ruta_curriculum))
							  <a href={{asset($infUser[0]->ruta_curriculum)}}> <i class="icon-download-alt"></i> Ver Curr&iacute;culo</a>
							@else
							  No disponible
							@endif
						</td>                          
					</tr>
					<tr>
						<td>Habilitado: </td>
						<td class="center">
							@if($infUser[0]->habilitado==1)
							si
							@else
							no
							@endif
						</td>                          
					</tr>
					<tr>
					  <td>Tipo de usuario: </td>
						<td class="center"> jefe consultor </td>                          
					</tr>                                    
				</tbody>
			</table>
		</div>
		<div class="row-fluid">
		  <div class="span12" style="padding:10px;">  
			 	<button type="button" class="btn btn-primary" onclick="imprimir()"><i class="icon-print"></i> Imprimir</button>
			  <a href="modificar_registro_jefe_consultor" type="button" class="btn"><i class="icon-edit"></i> Modificar Registro</a>
			</div>
		</div>
  </div>
</div>
@endif
@stop