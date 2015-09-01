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
			<a href="home_admin">Inicio</a><span class="divider">/</span>
		</li>
	    <li>
			 <a href='info_admin'> Informaci&oacute;n del usuario Administrador </a>
		</li>				
	</ul>
</div>
<center><h3>Informaci&oacute;n del ADMINISTRADOR TIS</h3></center>

<div class="row-fluid">
  <div class="box span12 center" id="print">
	 <div class="box-header well">
       <h2><i class="icon-info-sign"></i> Informaci&oacute;n del usuario: {{$nombre_usuario}}</h2>
     </div>
     <div class="box-content padding-in" style="text-align:left;" >
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
				<td class="center">{{$nombre}}></td>                                       
			</tr>
			<tr>
				<td>Apellido: </td>
				<td class="center">{{$apellido}}</td>                                      
			</tr>
			<tr>
				<td>Tel&eacute;fono: </td>
				<td class="center">{{$telefono}}</td>                                     
			</tr>
			<tr>
				<td>Correo electr&oacute;nico: </td>
				<td class="center">{{$email}}</td>                          
			</tr>
			<tr>
				<td>Habilitado: </td>
				<td class="center">{{$habilitado}}</td>                          
			</tr>
			<tr>
				<td>Tipo de usuario: </td>
				<td class="center">{{$quien_ingresa}}</td>                          
			</tr>                                    
		</tbody>
	   </table>
		  <div class="row-fluid">
			<div class="span12" style="padding:10px;">  
				<button type="button" class="btn btn-primary" onclick="imprimir();"><i class="icon-print"></i> Imprimir</button>
					<a href="modificar_registro_admin"	 type="button" class="btn"><i class="icon-edit"></i> Modificar Registro</a>
				</div>
		  </div>
     </div>
   </div>
</div>	

@stop
