@extends('header')
@section('contenido')
<div>
  <ul class="breadcrumb">
		<li>
			<a href={{url("index")}}>Inicio</a><span class="divider">/</span>
		</li>	
		<li>
			<a href={{url("subir_grupo_empresa")}}>Documentos</a>
		</li>
	</ul>
</div>
<center><h3>Documentos</h3></center>
<div class="row-fluid">
	<div class="box span12">
		<div class="box-header well">
			<h2><i class="icon-edit"></i> Formulario de env&iacute;o de Documentos</h2>
  	</div>
		<div class="box-content">
			@if($gestion['gestion_valida'])				      
				@if($numintegrantes>=3)						
					@if($datos['actividad']->act_3_espera == false && $datos['actividad']->activo_3==1)								
						@if(is_null($sobre->sobre_a) && is_null($sobre->sobre_b))								
							@if(!is_null($sobre->observacion))								
								<div class="alert alert-info">
									<button type="button" class="close" data-dismiss="alert">×</button>
									<strong>Documentos no aceptados: </strong>{{$sobre->observacion}}
								</div> 
								<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" enctype="multipart/form-data" action={{url("subir_grupo_empresa")}} accept-charset="utf-8">
									<fieldset>
									  <input type="hidden" name="_token" value="{{csrf_token()}}"></input>
									  <div class="control-group">
									    <label class="control-label" for="fileInput">Sobre A:</label>
									    <div class="controls">
										    <input class="input-file uniform_on" name="documentoA" id="documento"  type="file"/>
										    <label class="error">@if(isset($error_docA)){{$error_docA}}@endif</label>
									    </div>
									  </div>
									  <div class="control-group">
									    <label class="control-label" for="fileInput">Sobre B:</label>
									    <div class="controls">
										    <input class="input-file uniform_on" name="documentoB" id="documento"  type="file" />
										    <label class="error">@if(isset($error_docB)){{$error_docB}}@endif</label>
									    </div>
									  </div>
									  <div class="control-group">
										  <div class="controls">
							          <button name="enviar"type="submit" class="btn btn-primary" id="enviar"><i class="icon-ok"></i> Enviar</button>
									      <button type="reset" class="btn"><i class="icon-remove"></i> Cancelar</button>
									    </div>
									  </div>
							    </fieldset>
							    <b>Nota: </b>Las extensiones permitidas son: pdf, doc, docx, xls, xlsx, ppt, pptx, zip, rar.
								</form>	
							@else							
								<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" enctype="multipart/form-data" action={{url("subir_grupo_empresa")}} accept-charset="utf-8">
								  <fieldset>
								    <input type="hidden" name="_token" value="{{csrf_token()}}"></input>
								    <div class="control-group">
								      <label class="control-label" for="fileInput">Sobre A:</label>
								      <div class="controls">
									      <input class="input-file uniform_on" name="documentoA" id="documento"  type="file" />
									      <label class="error">@if(isset($error_docA)){{$error_docA}}@endif</label>
								      </div>
								    </div>
								    <div class="control-group">
								      <label class="control-label" for="fileInput">Sobre B:</label>
								      <div class="controls">
									      <input class="input-file uniform_on" name="documentoB" id="documento"  type="file" />
									      <label class="error">@if(isset($error_docB)){{$error_docB}}@endif</label>
								      </div>
								    </div>
								    <div class="control-group">
									    <div class="controls">
						            <button name="enviar"type="submit" class="btn btn-primary" id="enviar"><i class="icon-ok"></i> Enviar</button>
								        <button type="reset" class="btn"><i class="icon-remove"></i> Cancelar</button>
								      </div>
								    </div>
					        </fieldset>
					        <b>Nota: </b>Las extensiones permitidas son: pdf, doc, docx, xls, xlsx, ppt, pptx, zip, rar.
     						</form>
							@endif
						@elseif(is_null($sobre->observacion) && !is_null($sobre->sobre_a) && !is_null($sobre->sobre_b) && $sobre->habilitado==0)
							<div align="center">
					      <h4><i class="icon-info-sign"></i>
					        Usted ya envi&oacute; sus documentos, debe esperar la validaci&oacute;n del Consultor TIS asignado</h4>
					    </div>					    
						@elseif($sobre->habilitado==1)										
							<div class="alert alert-success">
								<button type="button" class="close" data-dismiss="alert">×</button>
								<strong>Documentos aceptados: </strong>Su Consultor TIS asignado ha aceptados sus documentos
							</div>
							<form name="form-data" class="form-horizontal cmxform" method="POST" id="signupForm" enctype="multipart/form-data" action={{url("subir_grupo_empresa")}} accept-charset="utf-8">
							  <input type="hidden" name="_token" value="{{csrf_token()}}"></input>
								<div class="control-group">
                  <label class="control-label">Sobre A: </label>
							    <div class="controls">
							      <label class="control-label2"><a href={{url($sobre->sobre_a)}}><i class="icon-download-alt"></i> Descargar</a> </label>
							    </div>
							  </div>
							  <div class="control-group">
							    <label class="control-label">Sobre B: </label>
							    <div class="controls">
 							      <label class="control-label2"><a href={{url($sobre->sobre_b)}}><i class="icon-download-alt"></i> Descargar</a></label>
							    </div>
							  </div>
							</form>
						@endif							
					@else
						<div align="center">
				      <h4><i class="icon-info-sign"></i>
				        El env&iacute;o de documentos no est&aacute; disponible, contacte con el Jefe Consultor TIS.</h4>
				    </div>
					@endif							
				@else
					<div align="center">
				    <h4><i class="icon-info-sign"></i>
				      No puede enviar sus archivos, faltan integrantes.</h4>
				  </div>
				@endif												
			@else
				<div align="center">
				  <h4><i class="icon-info-sign"></i>
				    La gesti&oacute;n no est&aacute; disponible, contacte con el administrador del sistema.</h4>
				</div>
			@endif			
		</div>	
	</div><!--/span-->  
</div><!-- fin row -->
<div class="row-fluid">
	<div class="box span12" id="print">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-check"></i> Documentos Compartidos por el Consultor TIS</h2>
		</div>
		<div class="box-content">
		  @if($gestion['gestion_valida'])            
        @if(isset($documentos))							
				  <table class="table table-striped table-bordered  datatable" >
					  <thead>
						  <tr >
					 	    <th>Archivo</th>
						    <th>Descripci&oacute;n</th>
						    <th>Fecha de creaci&oacute;n</th>										 
						  </tr>
						</thead>
						<tbody>                            
            @foreach($documentos as $documento)                               
              <tr>
    						<td><a href="{{url('download?path='.$documento->ruta_documento)}}">{{$documento->nombre_documento}}</a></td>
    						<td>{{$documento->descripsion_documento}}</td>
    						<td>{{$documento->fecha_documento}}</td>                                
              </tr>
            @endforeach                      
						</tbody>
					</table>                    
        @else
          <div align="center">
				    <h4><i class="icon-info-sign"></i>
				      No existe ning&uacute;n archivo disponible.</h4>
				  </div>
        @endif
      @else
        <div align="center">
				  <h4><i class="icon-info-sign"></i>
				    La gesti&oacute;n no est&aacute; disponible, contacte con el administrador del sistema.</h4>
				</div>
      @endif                    
		</div>
	</div><!--/span-->
</div>
@stop