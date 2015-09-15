@extends('header')
@section('contenido')

<div>
  <ul class="breadcrumb">
   <li>
	 <a href="ayuda">Ayuda</a>
   </li>
   </ul>
</div>
<center><h3>Ayuda del Sistema de Apoyo a la Empresa TIS</h3></center>
<div class="row-fluid">
  <div class="box span12">
     <div class="box-header well">
		 <h2><i class="icon-info-sign"></i> Ayuda</h2>
	 </div>
	 <div class="box-content">
	 <div id = "menu">
	   <ul>
			<li><a href="ayuda?nom_arch=002#modal1">INTRODUCCION</a></li>
			<li><a href="ayuda?nom_arch=003#modal1">VISTA PRINCIPAL</a></li>
			<li><a href="ayuda?nom_arch=004#modal1">FUNCIONES DEL ADMINISTRADOR</a></li>
			<li><a href="ayuda?nom_arch=005#modal1">FUNCIONES DEL CONSULTOR TIS</a></li>
		    <li><a href="ayuda?nom_arch=007#modal1">FUNCIONES DEL GRUPO EMPRESA E INTEGRANTES </a></li>		
		    <li><a href="ayuda?nom_arch=008#modal1">FUNCIONES DE LOS INTEGRANTES</a></li>
		    <li><a href="ayuda?nom_arch=009#modal1">FUNCIONES ADICIONALES</a></li>
		</ul>
	 </div>

    <!--VISOR DE PDF  -->
    @if(isset($numpdf))
	 <div class="center">
	   <div id="modal1" class="modalmask">
		 <div class="modalbox movedown">
		   <a href="#close" title="Close" class="close">X</a>
          
           <embed src={{"archivos/".$numpdf.".pdf"}} width=900 height=500 />
          </div>
	   </div>
	 </div>
	 @endif
   
    </div>
  </div><!--/span-->
</div><!-- fin row -->	


<div class="row-fluid">
			<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-info-sign"></i> Ayuda</h2>
					</div>
					<div class="box-content">
					
					<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert">×</button>
							Si necesita ayuda, o tiene problemas con el uso del sistema puede contactarse con el <b>Administrador</b>, sus datos se encuentran a continuaci&oacute;n.
						</div>
					
						@if(is_array($resultado) && !empty($resultado))
						  <table class="table table-bordered">
								<tbody>
									<tr>
									  <td><b>Nombre: </b></td>
									  <td class="center">{{$resultado[0]->nombre." ".$resultado[0]->apellido}}</td>                                       
											</tr>
											<tr>
												<td><b>Tel&eacute;fono: </b></td>
												<td class="center">{{$resultado[0]->telefono}}</td>                                     
											</tr>
											<tr>
												<td><b>Correo electr&oacute;nico: </b></td>
												<td class="center">{{$resultado[0]->email}}</td>                          
											</tr>
											                                    
										  </tbody>
								 		</table>
								
						@else
						  <h4>No se Encontro ning&uacute;n registro</h4>
								
                       @endif
					</div>
				</div><!--/span-->
			</div><!-- fin row -->





@stop