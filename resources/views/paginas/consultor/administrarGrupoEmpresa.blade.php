@extends('header')
@section('contenido')
<div>
	<ul class="breadcrumb">
		<li>
			<a href={{url("index")}}>Inicio</a><span class="divider">/</span>
		</li>
		<li>
			<a href={{url("administrar_grupo")}}>Administrar Grupo Empresas</a>
		</li>
	</ul>
</div>
<center><h3>Administrar Grupo Empresas</h3></center>
<div class="row-fluid">
  <div class="box span12" id="print">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-check"></i> Grupo Empresas registradas con usted</h2>
		</div>
		<div class="box-content">
      <h2></i> Grupo Empresas registradas con usted</h2>
		</div>
		<div class="box-content">
			@if($gestion['gestion_valida'])
        @if($grupos!=null)							
					<form name="form-data" class="form-horizontal cmxform" method="POST" action={{url('administrar_grupo')}} accept-charset="utf-8">
					  <input type="hidden" name="_token" value="{{csrf_token()}}"></input>
						<table class="table table-striped table-bordered  datatable" >
						<thead>
						  <tr>
						 	  <th>Nombre Largo</th>
							  <th>Nombre Corto</th>
						      <th>Representante Legal</th>
							  <th>Nombre de usuario</th>
							  <th style="text-align:center">Habilitado</th>
							  <th style="text-align:center">Reporte</th>
                              <th>Habilitar Integrantes</th>
						  </tr>
						</thead>
						<tbody>						
            @foreach($grupos as $grupo)                               
              <tr>              
    					<td>{{ $grupo->nombre_largo }}</td>
    					<td><input type="hidden" id= {{"a".$contador}} name={{"a".$contador}} value={{$grupo->id_usuario}}></input>{{$grupo->nombre_corto}}</td>
						  <td>{{$grupo->nombre." ".$grupo->apellido}}</td>
    					<td>{{$grupo->nombre_usuario}}</td>
              @if($grupo->habilitado==1)
                <td><center><input type="checkbox" id={{"b".$contador}} name={{"b".$contador}} checked></input></center></td>
              @else
                <td><center><input type="checkbox" id={{"b".$contador}} name={{"b".$contador}}></input></center></td>
              @endif
              <td><center><a class="btn btn-success" href={{url("reporte/".$grupo->id_grupo_empresa)}}>
							<i class="icon-zoom-in icon-white"></i>
							Ver</a></center></td>
              <td><center><a class="btn btn-success" href={{"habilitar_integrantes/".$grupo->id_grupo_empresa}}>
              <i class="icon-check icon-white"></i>
              Revisar</a></center></td>
              </tr>               
              <!--{{$contador++}}-->
            @endforeach
						</tbody>
					  </table>
						<div style="padding-left:10px;">
              <button name="enviar"type="submit" class="btn btn-primary" id="enviar"><i class="icon-ok"></i> Guardar Cambios</button>
              <a href={{url("administrar_grupo")}} rel="activi"><button type="button" class="btn" ><i class="icon-remove"></i> Restablecer</button></a>
 					  </div>
          </form>        
        @else
          <div align="center">
				    <h4><i class="icon-info-sign"></i>No existe ninguna Grupo Empresa registrada con usted.</h4>
				  </div>
        @endif
      @else           
        <div align="center">
				  <h4><i class="icon-info-sign"></i>La gesti&oacute;n no est&aacute; disponible, contacte con el administrador del sistema.</h4>
		    </div>
      @endif            
		</div>
	</div>
</div>
@stop()