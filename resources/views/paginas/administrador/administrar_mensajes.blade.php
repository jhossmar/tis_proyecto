@extends('header')

@section('contenido')
<div>
  <ul class="breadcrumb">
	<li>
	  <a href="index">Inicio</a>
      <span class="divider">/</span>
	</li>
	<li>
	  <a href="administrar_mensajes">Administrar Espacio de Discuci&oacute;n</a>
	</li>
  </ul>
</div>
<center><h3>Administrar Espacio de Discuci&oacute;n</h3></center>
<div class="row-fluid">
  <div class="box span12">
   <div class="box-header well" data-original-title>
   <h2><i class="icon-user"></i> Administrar Espacio de Discuci&oacute;n</h2>
   </div>
  <div class="box-content">
  @if($num_mensajes>0)
     <form method="post" action="administrar_mensajes" accept-charset="utf-8">
	     <input type="hidden" name="_token" value="{{csrf_token()}}"></input>
       <table class="table table-striped table-bordered  datatable">
        <thead>
           <tr>
           <th><center>Comentarios Disponibles</center></th>
           </tr>
        </thead> 
		    <tbody>
        @foreach($listaMensages as $mensaje)
        <tr>
          <td>
             <div class="alert alert-info"><span style="float: right;" >Visible: 
               <input type="hidden" id={{$mensaje->id_mensaje}}  name={{$mensaje->id_mensaje}} value={{$mensaje->id_mensaje}}>
                @if($mensaje->visible==1)                             
                 <input type="checkbox" id={{"visible".$mensaje->id_mensaje}} name={{"visible".$mensaje->id_mensaje}} checked>                                 
                @else
                  <input type="checkbox" id={{"visible".$mensaje->id_mensaje}} name={{"visible".$mensaje->id_mensaje}}>                
                @endif
                </span>
                    <h4>Asunto: {{$mensaje->asunto }}</h4>
                    <h4>Por : {{$mensaje->nombre }} </h4>
                    <div class="letra_aviso">{{$mensaje->contenido}} <br></div>
                      <div class="pie_aviso">
                        <span style=" text-align:left;">{{$mensaje->descripcion }}</span>                                 
                        <span style="float:right;">Publicado el {{$mensaje->fecha_hora }} </span> 
                      </div>
               </div>
             </div>
           </td>
          </tr>
      @endforeach
      </tbody>
     </table>
     <div style="padding-left:10px;">
      <button name="enviar"type="submit" class="btn btn-primary" id="enviar"><i class="icon-ok"></i> Guardar cambios</button>
     </div>
   </form>
 @else
     <div align="center">
       <h4><i class="icon-info-sign"></i>
        No existe ninguna Publicacion</h4>
     </div>
  @endif
   </div>
  </div><!--/span-->
</div>

@stop