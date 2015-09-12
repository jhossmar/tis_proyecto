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
        <a href={{url("administrar_integrante")}}>Administrar Integrantes</a>
     </li>
  </ul>
</div>
<div style="text-align: center;"><h3>Administrar Integrantes</h3></div>
<div class="row-fluid">
  <div class="box span12" id="print">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-check"></i> Habilitar Integrantes</h2>
    </div>
    <div class="box-content">
      @if($gestion['gestion_valida'])
        @if(count($integrantes)>0)
          <form name="form-data" class="form-horizontal cmxform" method="POST" action="administrar_integrante" accept-charset="utf-8">
            <input type="hidden" name="_token" value="{{csrf_token()}}"></input>
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Nombre de Usuario</th>
                  <th>Nombre</th>
                  <th>Apellido</th>
                  <th>Tel&eacute;fono</th>
                  <th>Correo Electr&oacute;nico</th>
                  <th><center>Habilitado</center></th>
                  <th><center>Roles</center></th>
                </tr>
              </thead>
              <tbody>
              @foreach($integrantes as $integrante)
              <tr>
    					  <td><input type="hidden" id={{"a".$contador}} name={{"a".$contador}} value={{$integrante->id_usuario}} ></input> {{$integrante->nombre_usuario}}</td>
    						<td>{{$integrante->nombre}}</td>
    						<td>{{$integrante->apellido}}</td>
    						<td>{{$integrante->telefono}}</td>
    						<td>{{$integrante->email}}</td>
                @if($integrante->habilitado==1)
                <td ><center> <input type="checkbox" id={{"b".$contador}} name={{"b".$contador}} checked='checked' ></center></td>
                @else
                <td class="center"><center><input type="checkbox" id={{"b".$contador}} name={{"b".$contador}}></center></td>
                @endif                
                <td>
                  @if($rolesIntegrantes[$contador]->id_rol==1)                  
                  <label align="center">{{$rolesIntegrantes[$contador]->nombre}}</label>                  
                  @else
                  <select name={{"rol".$contador}} class="selectpicker">                 
                    <option value={{$rolesIntegrantes[$contador]->id_rol}}>{{$rolesIntegrantes[$contador]->nombre}}</option>
                    @foreach($roles as $rol)
                    @if($rolesIntegrantes[$contador]->nombre!=$rol->nombre)
                    <option value={{$rol->id_rol}}>{{$rol->nombre}}</option>                    
                    @endif
                  @endforeach
                  </select>
                  @endif
                </td>
              </tr>
              <!--{{$contador++}}-->
              @endforeach
              <input type="hidden" name="numIntegrantes" value={{$contador}}></input>
              </tbody>
            </table>
            <div class="control-group">
              <button name="enviar" type="submit" class="btn btn-primary" id="enviar"><i class="icon-ok"></i> Guardar Cambios</button>
              <a href="agregar_integrante" class="btn"><i class="icon-user"></i> Agregar Integrantes</a>
              <button type="button" class="btn" onclick="imprimir();"><i class="icon-print"></i> Imprimir</button>
            </div>
          </form>
        @else
          <div align="center">
				    <h4><i class="icon-info-sign"></i>La Grupo Empresa no tiene registrado m&aacute;s integrantes.</h4>
				  </div>
        @endif
      @else
        <div align="center">
			    <h4><i class="icon-info-sign"></i>La gesti&oacute;n no est&aacute; disponible, contacte con el administrador del sistema.</h4>
       	</div>
      @endif
      </div>
    </div><!--/span-->
  </div>   
@stop