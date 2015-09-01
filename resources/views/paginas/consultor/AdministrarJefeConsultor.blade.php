@extends('header')
@section('contenido')
<div>
	<ul class="breadcrumb">
    <li>
		  <a href="index">Inicio</a>
			<span class="divider">/</span>
		</li>
		<li>
			<a href="administrar_archivos">Administrar Archivos</a>
		</li>
	</ul>
</div>
<center><h3>Administrar Archivos</h3></center>
<div class="row-fluid">
  <div class="box span12" id="print">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-check"></i> Mis Archivos</h2>
		</div>
		<div class="box-content">
		@if($gestion['gestion_valida'])                                                            
      @if(count($archivos)>0)						
			  <form name="form-data" class="form-horizontal cmxform" method="POST" action="administrar_archivos" accept-charset="utf-8">					
					<input type="hidden" name="_token" value="{{csrf_token()}}"></input>
					<table class="table table-striped table-bordered  datatable" >
					  <thead>
							<tr >
							  <th>Archivo</th>
							  <th>Descripci&oacute;n</th>
							  <th>Fecha de creaci&oacute;n</th>
							  <th>Gesti&oacute;n</th>
							  <th style="text-align:center">Visible</th>
							</tr>
						</thead>
						<tbody>              
              @foreach($archivos as $archivo)   
                <tr>

                  <td>{{$identi}}</td>
    						  <td ><a href={{asset($archivo->ruta_documento)}}>{{$archivo->nombre_documento}}<a></td>
    							<td>{{$archivo->descripsion_documento}}<input type="hidden" id={{"a".$identi}} name={{"a".$identi}} value={{$archivo->id_documento_consultor}}></input></td>
  								<td>{{$archivo->fecha_documento}}</td>
    							<td>{{$archivo->gestion}}</td>                                 
                  @if($archivo->habilitado == 1)
                    <td class="center"><center> <input type="checkbox" id={{"b".$identi }} name={{"b".$identi}} checked></input>{{"b".$identi}}</center></td>
                  @else
                    <td class="center"><center> <input type="checkbox" id={{"b".$identi }} name={{"b".$identi}}></input>{{"b".$identi}}</center></td>
                  @endif
                </tr>
              <!--{{$identi++}}-->           
              @endforeach
						</tbody>
					</table>					    
          <button name="enviar"type="submit" class="btn btn-primary" id="enviar"><i class="icon-ok"></i> Guardar Cambios</button>
          <a href="administrar_archivos" rel="activi"><button type="button" class="btn"><i class="icon-remove"></i> Restablecer</button></a>
        </form>      
      @else
        <div align="center">
				  <h4><i class="icon-info-sign"></i>
				  Usted no tiene ning&uacute;n archivo.</h4>
				</div>
      @endif            
    @else
      <div align="center">
				<h4><i class="icon-info-sign"></i>
				La gesti&oacute;n no est&aacute; disponible, contacte con el administrador del sistema.</h4>
			</div>
    @endif
	  </div>
  </div>
</div>

@stop