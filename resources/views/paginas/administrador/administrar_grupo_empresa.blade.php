@extends('header')

@section('contenido')
  <div>
    <ul class="breadcrumb">
	  <li>
		  <a href="index">Inicio</a>
		  <span class="divider">/</span>
	  </li>
	  <li>
		  <a href="administrar_grupo_empresa">Administrar grupo empresas</a>
	  </li>
		  </ul>
   </div>
      <center><h3>Administrar Grupo empresas</h3></center>
     
      <div class="row-fluid">
         <div class="box span12">
			<div class="box-header well" data-original-title>
				<h2><i class="icon-user"></i> Grupo Empresas registradas</h2>
			</div>
		  <div class="box-content">
     @if($num_res>0)
         <form method="post" action="administrar_grupo_empresa" accept-charset="utf-8">
				 <input type="hidden" name="_token" value="{{csrf_token()}}"></input>
        <table class="table table-striped table-bordered  datatable">
				  <thead >
				    <tr >
					  <th>Usuario</th>
					  <th>Contrase&ntilde;a</th>
					  <th>Nombre corto</th>
					  <th>Nombre largo</th>
					  <th>Sociedad </th>
                      <th>Habilitado</th>
				    </tr>
				   </thead>
				 <tbody>  
	    @foreach ($lista_grupo_empresas as $grupo)
                  <tr>
                  	 <td>{{$grupo->nombre_usuario}}</td>
                     <td>{{$grupo->clave}}</td>
    			     <td>{{$grupo->nombre_corto}}</td>
                     <td>{{$grupo->nombre_largo}}</td>
                     <td>{{$grupo->descripcion}}</td>
                 @if($grupo->habilitado=="1")
                        <td class="center"><center> <input type="checkbox" id={{$grupo->id_usuario}} name={{$grupo->id_usuario}} checked="checked"></center></td>
                 @else 
                        <td class="center"><center> <input type="checkbox" id={{$grupo->id_usuario}} name={{$grupo->id_usuario}}></center></td>
                 @endif
                 </tr>
               @endforeach
              </tbody>
			 </table>
                  <div class="control-group">
					<div class="controls">
					   <button name="enviar"type="submit" class="btn btn-primary" id="enviar"><i class="icon-ok"></i> Guardar cambios</button>
					   <button type="reset" class="btn">Restablecer</button>
                     </div>
				  </div>
		     </form>
    @else
       <div align=\"center\">
           <h4><i class=\"icon-info-sign\"></i>
           Ninguna Grupo Empresa se ha registrado.</h4>
       </div> 
    @endif
    </div>
 </div><!--/span-->
</div>
@stop