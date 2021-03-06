@extends('header')

@section('contenido')
<div>
  <ul class="breadcrumb">
    <li>
	  <a href="index">Inicio</a>
	  <span class="divider">/</span>
	</li>
    <li>
	 <a href="administrar_consultor">Administrar Consultores TIS</a>
	</li>
   </ul>
</div>

<center><h3>Administrar Consultores TIS</h3></center>
   <div class="row-fluid">
      <div class="box span12">
      <div class="box-header well" data-original-title>
        <h2><i class="icon-user"></i> Consultores TIS registrados</h2>
      </div>
      <div class="box-content">
 
    @if($num_res>0)
     <form method="post" action="administrar_consultor" accept-charset="utf-8">
		    <input type="hidden" name="_token" value="{{csrf_token()}}"></input>
      <table class="table table-striped table-bordered  datatable">
	    
       <thead >
          <tr>
		    <th>Usuario</th>
		    <th>Contrase&ntilde;a</th>
		    <th>Correo electr&oacute;nico</th>
		    <th>Curr&iacute;culo</th>
		    <th>Jefe Consultor</th>
            <th>Habilitado</th>
		  </tr>
		</thead>
		  <tbody>

		    @foreach ($lista_consultores as $consultor)
             <tr>
                <td>{{$consultor->nombre_usuario}}</td>
             	<td>{{$consultor->clave}}</td>
             	<td>{{$consultor->email}}</td>
              @if(empty($consultor->curriculum))
                <td >No</td>
              @else
                <td><center><a href={{$consultor->curriculum}}> <i class="icon-download-alt"></i> Descargar</a></center></td>
              @endif
             
              @if($consultor->tipo_usuario=="2")
                <td class="center"><center> <input type="checkbox" id={{$consultor->id_usuario}} name={{"tipo".$consultor->id_usuario}} checked="checked"></center></td>
              @else
                <td class="center"><center> <input type="checkbox" id={{$consultor->id_usuario}} name={{"tipo".$consultor->id_usuario}}        ></center></td>
              @endif

              @if($consultor->habilitado=="1")
                <td class="center"><center> <input type="checkbox" id={{$consultor->id_usuario}} name={{"habilitado".$consultor->id_usuario}} checked="checked"></center></td>
              @else
               <td class="center"><center> <input type="checkbox" id={{$consultor->id_usuario}} name={{"habilitado".$consultor->id_usuario}}></center></td>
              @endif
             </tr>      
          @endforeach
      </tbody>
	</table>
    <div class="control-group">
		<div class="controls">
		  <button name="enviar"type="submit" class="btn btn-primary" id="enviar"><i class="icon-ok"></i> Guardar cambios</button>
		    <a href="administrar_consultor" rel="activi"><button type="button" class="btn" ><i class="icon-remove"></i> Restablecer</button></a>
        </div>
     </div>

  </form>

     @else
           <div align="center">
             <h4><i class="icon-info-sign"></i>
               No existe ning&uacute;n Consultor TIS registrado.</h4>
           </div> 
     @endif

   
    </div>
	</div><!--/span-->
</div>
@stop