@extends('header')
@section('contenido')
<div>
	<ul class="breadcrumb">
		<li>
			<a href={{url("index")}}>Inicio</a><span class="divider">/</span>
		</li>
		<li>
			<a href={{url("entrega_producto")}}>Entrega De Subsistemas </a>
		</li>
	</ul>
</div>
<center><h3>Cronograma de entrega de Subsistemas </h3></center>
@if($gestion['gestion_valida'])
  @if($numIntegrantes>=3)
    @if($datos['actividad']->activo_5==1 && !$datos['actividad']->act_5_espera)               
			<div class="row-fluid">
				<div class="box span12 center" id="print">
					<div class="box-header well">
						<h2><i class="icon-calendar"></i> Cronograma en entrega de subsistema</h2>
					</div>
					<div class="box-content padding-in" style="text-align:left;" >						
            @if(count($subsistemas)>0)                        
              <form name="activi" class="form-horizontal cmxform" method="POST" id="activi" action={{url("entrega_producto")}} accept-charset="utf-8">
                <input type="hidden" name="_token" value="{{csrf_token()}}"></input>
                <table id="dataTable" name="dataTable pagos" class="table table-striped table-bordered">
                  <thead>
                    <TR>
                      <TH>Descripci&oacute;n</TH>
											<TH>Responsable</TH>
                      <TH>Fecha Inicio</th>
                      <TH>Fecha Conclusi&oacute;n </th>
                      <TH>Pago Asociado </th>
                      <TH style="text-align:center;">Eliminar</TH>
                    </TR>
                  </thead>
                  <tbody>                  
                    @foreach($subsistemas as $subsistema)
                      <tr>                          
                        <td>{{$subsistema->descripcion}}</td>
												<td>{{$subsistema->nombre." ".$subsistema->apellido}}</td>
                        <td>{{$subsistema->fecha_inicio}}</td>
                        <td>{{$subsistema->fecha_fin}}</td>
                        <td>{{$subsistema->pago_establecido}}</td>                        
                        <td style="text-align:center;"><input type="checkbox" id={{"A1".$contador}} name={{"A1".$contador}} value="Eliminar" class="btn btn-primary" onclick="roly"/></td> 
                        <input type="hidden" id={{"A0".$contador}}  name={{"A0".$contador}}  value={{$subsistema->id_entrega_producto}} />
                      </tr>
                      <!--{{$contador++}}-->
                    @endforeach
                    <input  type="hidden" id="CEP"  name="CEP"  value={{$contador}} />
                    @if($contador==0)
                      <center><h4>No existe Entrega De Producto Programada.</h4></center>
                    @endif
                  </tbody>
                </table>								
                <button type="submit" id="guardar" name="guardar" value="Guardar Cambios" class="btn btn-primary"  ><i class="icon-ok"></i> Guardar Cambios</button>
                <a href={{url("entrega_producto")}} rel="activi"><button type="button" class="btn" ><i class="icon-remove"></i> Restablecer</button></a>
           	  </form>		          
		        @else
		          <div align="center">
				        <h4><i class="icon-info-sign"></i>No se ha programado ninguna entrega de subsistema.</h4>
				      </div>
				    @endif
          </div>
				</div>
			</div>
      <br>
      <center><h3> Agregar nueva entrega de subsistema </h3></center>
      <div class="row-fluid">
				<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-plus-sign"></i> Agregar nueva entrega de subsistema</h2>
					</div>
					<div class="box-content alerts">
            <br>
					  <form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" action={{url("entrega_producto")}} accept-charset="utf-8">
              <input type="hidden" name="_token" value="{{csrf_token()}}"></input>
					 	  <div class="control-group">
							  <label class="control-label" >Descripci&oacute;n: </label>
							  <div class="controls">
								  <input type="text" name="descripcionG" id="descripcionG" placeholder="Ingrese una descripci&oacute;n"/>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" >Responsable: </label>
							  <div class="controls">
								  <select id="responsable" name="responsable" data-rel="chosen">
                    @foreach($integrantes as $integrante)
                      <option value={{$integrante->id_usuario}}>{{$integrante->nombre_usuario}}</option>
                    @endforeach
                  </select>                             
							  </div>
							</div>
              <div class="control-group">
							  <label class="control-label" for="tituloD">Pago ($us): </label>
							  <div class="controls">
								  <input type="text" class ="pagos" name="pagos" id="pagos" placeholder="Ingresar pago"/>
							  </div>
							</div>
							<div class="control-group">
								<label class="control-label" >Fecha inicio:</label>
								<div class="controls">
							  	<input type="text" class="datepicker" etitable='false' name="inicio" id="inicio">
									<label class="error">@if($errores[1]!=''){{ $errores[1] }}@endif</label>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="descripcion">Fecha conclusi&oacute;n:</label>
								<div class="controls">
									<input type="text" class="datepicker" name="fin" id="fin">
									<label class="error">@if($errores[0]!=''){{$errores[0]}}@endif</label>
								</div>
							</div>
							<div class="control-group">
								<div class="controls">
						      <button name="enviar"type="submit" class="btn btn-primary" id="enviar"><i class="icon-ok"></i> Aceptar</button>
							    <button type="reset" class="btn"><i class="icon-remove"></i> Cancelar</button>
							  </div>
							</div>
						</form>
					</div>
				</div><!--/span-->
			</div><!-- fin row -->
    @else
      <div class="row-fluid">
        <div class="box span12">
          <div class="box-header well">
            <h2><i class="icon-calendar"></i> Cronograma en entrega de subsistema</h2>
          </div>
          <div class="box-content alerts">
            <center><h4><i class="icon-info-sign"></i> El Cronograma de Pagos y de Subsistemas no est&aacute; disponible, contacte con el Jefe Consultor TIS. </h4></center>
          </div>
        </div><!--/span-->
      </div><!-- fin row -->
    @endif
  @else
    <div class="row-fluid">
			<div class="box span12">
				<div class="box-header well">
					<h2><i class="icon-calendar"></i> Cronograma en entrega de subsistema</h2>
				</div>
				<div class="box-content alerts">
				  <center><h4><i class="icon-info-sign"></i> Debe habilitar m&aacute;s integrantes. </h4></center>
				</div>
			</div>
		</div>
  @endif
@else
  <div class="row-fluid">
    <div class="box span12">
      <div class="box-header well">
        <h2><i class="icon-calendar"></i> Cronograma en entrega de subsistema</h2>
      </div>
      <div class="box-content alerts">
        <center><h4><i class="icon-info-sign"></i> La gesti&oacute;n no est&aacute; disponible, contacte con el administrador del sistema.</h4></center>
      </div>
    </div><!--/span-->
  </div><!-- fin row -->
@endif
@stop