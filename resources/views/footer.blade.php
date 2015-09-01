   {!! Html::script('js/jquery-1.7.2.min.js')!!}
	{!! Html::script('js/script.js')!!}
	<!-- jQuery UI -->
	{!! Html::script('js/jquery-ui-1.8.21.custom.min.js')!!}
	<!-- transition / effect library -->
	{!! Html::script('js/bootstrap-transition.js')!!}
	<!-- alert enhancer library -->
	{!! Html::script('js/bootstrap-alert.js')!!}
	<!-- modal / dialog library -->
	{!! Html::script('js/bootstrap-modal.js')!!}
	<!-- custom dropdown library -->
	{!! Html::script('js/bootstrap-dropdown.js')!!}
	<!-- scrolspy library -->
	{!! Html::script('js/bootstrap-scrollspy.js')!!}
	<!-- library for creating tabs -->
	{!! Html::script('js/bootstrap-tab.js')!!}
	<!-- library for advanced tooltip -->
	{!! Html::script('js/bootstrap-tooltip.js')!!}
	<!-- popover effect library -->
	{!! Html::script('js/bootstrap-popover.js')!!}
	<!-- button enhancer library -->
	{!! Html::script('js/bootstrap-button.js')!!}
	<!-- accordion library (optional, not used in demo) -->
	{!! Html::script('js/bootstrap-collapse.js')!!}
	<!-- carousel slideshow library (optional, not used in demo) -->
	{!! Html::script('js/bootstrap-carousel.js')!!}
	<!-- autocomplete library -->
	{!! Html::script('js/bootstrap-typeahead.js')!!}
	<!-- tour library -->
	{!! Html::script('js/bootstrap-tour.js')!!}
	<!-- library for cookie management -->
	{!! Html::script('js/jquery.cookie.js')!!}
	<!-- calander plugin -->
	{!! Html::script('js/fullcalendar.min.js')!!}
	<!-- data table plugin -->
	{!! Html::script('js/jquery.dataTables.min.js')!!}
	<!-- validation plugin -->	
	{!! Html::script('js/jquery.validate.js')!!}
	<script>

$(document).ready(function() {
	// validate the comment form when it is submitted
	$("#commentForm").validate();

	// validate signup form on keyup and submit
	$("#signupForm").validate({
		rules: {
			firstname: {
				required: true,
				minlength: 2,
				maxlength : 32
			},
			lastname: {
				required: true,
				minlength: 2,
				maxlength : 32
			},
			username: {
				required: true,
				minlength: 8,
				maxlength : 20
			},
			telf: {
				required: true,
				minlength: 7,
				maxlength: 8
			},
			password: {
				required: true,
				minlength: 8,
				maxlength: 20
			},
			confirm_password: {
				required: true,
				minlength: 8,
				equalTo: "#password"
			},
			email: {
				required: true,
				email: true
			},
			topic: {
				required: "#newsletter:checked",
				minlength: 2
			},
			agree: "required",
			descripcion: {
				required: true,
				minlength: 10,
				maxlength: 300
			},
			titulo: {
				required: true,
				minlength: 10,
				maxlength: 32
			},
            //DESCRIPCION A, DESCRIPCION B, DESCRIPCION G  Y DESCRIPCION LO EXTENDI A 300 CARACTERES COMO LIMITE
			descripcionA: {
				required: true,
				minlength: 32,
				maxlength: 300
			},
			descripcionB: {
				required: true,
				minlength: 32,
				maxlength: 300
			},
			tituloD: {
				required: true,
				minlength: 10,
				maxlength: 32
			},
			lname: {
				required: true,
				minlength: 10,
				maxlength: 64
			},
			descripcionG: {
				required: true,
				minlength: 10,
				maxlength: 300
			},
			sname: {
				required: true,
				minlength: 5,
				maxlength: 20
			},
			codSIS: {
				required: true,
				minlength: 9
			},
            pagos: {
                required: true,
				maxlength: 3
            },
            mensaje:{
            	required:true,
            	minlength:5,
            	maxlength:160
            },
            observacion:{
            	required:true,
            	minlength:5,
            	maxlength:60
            }
		},
		messages: {
			firstname:{
				required: "Ingrese su nombre",
				minlength: "El nombre debe consistir de 2 caracteres m&iacute;nimo",
				maxlength: "El nombre debe consistir de 32 caracteres m&aacute;ximo"
			},
			lastname: {
				required: "Ingrese su apellido",
				minlength: "El apellido debe consistir de 3 caracteres m&iacute;nimo",
				maxlength: "El apellido debe consistir de 32 caracteres m&aacute;ximo"
			},
			username: {
				required: "Ingrese nombre de usuario",
				minlength: "El nombre de usuario debe consistir de 8 caracteres minimo",
				maxlength: "El nombre de usuario debe consistir de 20 caracteres maximo"
			},
			telf: {
				required: "Ingrese tel&eacute;fono",
				minlength: "El telefono debe consistir de 7 n&uacute;meros"
			},
			password: {
				required: "Ingrese contrase&ntilde;a",
				minlength: "La contrase&ntilde;a debe consistir de 8 caracteres minimo",
				maxlength: "La contrase&ntilde;a debe consistir de 20 caracteres maximo"
			},
			confirm_password: {
				required: "Ingrese contrase&ntilde;a",
				minlength: "La contrase&ntilde;a debe consistir de 5 caracteres minimo",
				maxlength: "La contrase&ntilde;a debe consistir de 20 caracteres maximo",
				equalTo: "Las contrase&ntilde;as no coinciden"
			},
			email: "Ingrese un correo valido",
			agree: "Debe aceptar nuestros terminos",
			descripcion: {
				required: "Ingrese una descripci&oacute;n",
				minlength: "La descripci&oacute;n debe consistir de 10 caracteres m&iacute;nimo",
				maxlength: "La descripci&oacute;n debe consistir de 300 caracteres m&aacute;ximo"
			},
			descripcionG: {
				required: "Ingrese una descripci&oacute;n",
				minlength: "La descripci&oacute;n debe consistir de 10 caracteres m&iacute;nimo",
				maxlength: "La descripci&oacute;n debe consistir de 300 caracteres m&aacute;ximo"
			},
			titulo: {
				required: "Ingrese un t&iacute;tulo",
				minlength: "El titulo debe consistir de 10 caracteres m&iacute;nimo",
				maxlength: "El titulo debe consistir de 32 caracteres maximo"
			},
			descripcionA: {
				required: "Ingrese descripci&oacute;n",
				minlength: "La descripci&oacute;n debe consistir de 32 caracteres minimo",
				maxlength: "La descripci&oacute;n debe consistir de 300 caracteres maximo"
			},
			descripcionB: {
				required: "Ingrese descripci&oacute;n",
				minlength: "La descripci&oacute;n debe consistir de 32 caracteres minimo",
				maxlength: "La descripci&oacute;n debe consistir de 300 caracteres maximo"
			},
			tituloD: {
				required: "Ingrese un t&iacute;tulo",
				minlength: "El titulo debe consistir de 10 caracteres m&iacute;nimo",
				maxlength: "El titulo debe consistir de 32 caracteres m&aacute;ximo"
			},
			lname: {
				required: "Ingrese el nombre largo de la Grupo-Empresa",
				minlength: "El nombre debe consistir de 10 caracteres m&iacute;nimo",
				maxlength: "El nombre debe consistir de 64 caracteres m&aacute;ximo"
			},
			sname: {
				required: "Ingrese el nombre corto de la Grupo-Empresa",
				minlength: "El nombre debe consistir de 5 caracteres m&iacute;nimo",
				maxlength: "El nombre debe consistir de 20 caracteres m&aacute;ximo"
			},
			codSIS: {
				required: "Ingrese su c&oacute;digo SIS correspondiente",
				minlength: "El nombre debe consistir de 9 caracteres "
			},
            pagos: {
                required: "Ingrese Pago",
				maxlength: "El pago debe consistir de 3 digitos"
            },
            mensaje:{
            	required:"Ingrese el contenido de su comentario",
            	minlength:"El comentario debe ser de 5 caracteres m&iacute;nimo",
            	maxlength:"El comentario debe ser de 160 caracteres m&aacute;ximo"
            },
            observacion:{
            	required:"Ingrese el contenido de su observaci&oacute;",
            	minlength:"La observaci&oacute;n debe ser de 5 caracteres m&iacute;nimo",
            	maxlength:"La observaci&oacute;n debe ser de 60 caracteres m&aacute;ximo"
            }
		}
	});

	
	// propose username by combining first- and lastname
	$("#username").focus(function() {
		var firstname = $("#firstname").val();
		var lastname = $("#lastname").val();
		if(firstname && lastname && !this.value) {
			this.value = firstname + "." + lastname;
		}
	});
	//unisoft
	jQuery.validator.addMethod("firstnames", function( value, element ) {
		var result = this.optional(element) || value.length >= 3 && /[a-z]/i.test(value) && !/\d/.test(value) && !/-/.test(value) && !/[\!\@\#\$\%\^\&\*\(\)\_\+\-\=\`\~\[\]\{\}\;\'\:\"\,\.\/\<\>\?\*\-\+\\\|]/.test(value);

		return result;
	}, "El nombre debe tener mínimo 3 caracteres y contener solo caracteres alfabéticos");
	//unisoft
	jQuery.validator.addMethod("lastnames", function( value, element ) {
		var result = this.optional(element) || value.length >= 2 && /[a-z]/i.test(value) && !/\d/.test(value) && !/[\!\@\#\$\%\^\&\*\(\)\_\+\-\=\`\~\[\]\{\}\;\'\:\"\,\.\/\<\>\?\*\-\+\\\|]/.test(value);

		return result;
	}, "El apellido debe tener mínimo 2 caracteres y contener solo caracteres alfabéticos");
	//unisoft
	jQuery.validator.addMethod("telefonos", function( value, element ) {
		var result = this.optional(element) || value.length >= 7 && value.length < 9 && ((value>=2000000&& value<5000000 ) || (value>=60000000 && value<80000000))&& /\d/.test(value) && !/[a-z]/i.test(value) && !/[\!\@\#\$\%\^\&\*\(\)\_\+\-\=\`\~\[\]\{\}\;\'\:\"\.\/\<\>\?\*\-\+\\\|]/.test(value);

		return result;
	}, "El telefono debe tener entre 7 y 8 caracteres y contener solo números");
	//unisoft
    jQuery.validator.addMethod("pagos", function( value, element ) {
		var result = this.optional(element) || value.length < 4 && /\d/.test(value) && !/[a-z]/i.test(value) && !/[\!\@\#\$\%\^\&\*\(\)\_\+\-\=\`\~\[\]\{\}\;\'\:\"\,\.\/\<\>\?\*\-\+\\\|\ ]/.test(value);

		return result;
	}, "El pago debe tener menos de 4 digitos y contener solo números");
	//unisoft
    jQuery.validator.addMethod("codigos", function( value, element ) {
		var result = this.optional(element) || value.length == 9  && /\d/.test(value) && !/[a-z]/i.test(value) && !/[\!\@\#\$\%\^\&\*\(\)\_\+\-\=\`\~\[\]\{\}\;\'\:\"\,\.\/\<\>\?\*\-\+\\\|]/.test(value);

		return result;
	}, "El c&oacute;digo SIS debe consistir de 9 digitos y contener solo números");


   	jQuery.validator.addMethod("password", function( value, element ) {
		var result = this.optional(element) || value.length >= 8 && /\d/.test(value) && /[a-z]/i.test(value) ;
		
		return result;
	}, "Contraseña de 8 caracteres mínimo con al menos un literal y un número.");
	//code to hide topic selection, disable for demo
	var newsletter_2 = $("#newsletter");
	// newsletter topics are optional, hide at first
	var inital_2 = newsletter_2.is(":checked");
	var topics_2 = $("#newsletter_topics")[inital_2 ? "removeClass" : "addClass"]("gray");
	var topicInputs_2 = topics_2.find("input").attr("disabled", !inital_2);
	// show when newsletter is checked
	newsletter_2.click(function() {
		topics_2[this.checked ? "removeClass" : "addClass"]("gray");
		topicInputs_2.attr("disabled", !this.checked);
	});
});
</script>
	
	<!-- chart libraries start -->
	{!! Html::script('js/excanvas.js')!!}
	{!! Html::script('js/jquery.flot.min.js')!!}
	{!! Html::script('js/jquery.flot.pie.min.js')!!}
	{!! Html::script('js/jquery.flot.stack.js')!!}
	{!! Html::script('js/jquery.flot.resize.min.js')!!}
	<!-- subir archivo -->
	{!! Html::script('js/jquery.uploadify.min.js')!!}
	<!-- select or dropdown enhancer -->
	{!! Html::script('js/jquery.chosen.min.js')!!}
	<!-- checkbox, radio, and file input styler -->
	{!! Html::script('js/jquery.uniform.min.js')!!}
	<!-- plugin for gallery image view -->
	{!! Html::script('js/jquery.colorbox.min.js')!!}
	<!-- rich text editor library -->
	{!! Html::script('js/jquery.cleditor.min.js')!!}
	<!-- notification plugin -->
	{!! Html::script('js/jquery.noty.js')!!}
	<!-- file manager library -->
	{!! Html::script('js/jquery.elfinder.min.js')!!}
	<!-- star rating plugin -->
	{!! Html::script('js/jquery.raty.min.js')!!}
	<!-- for iOS style toggle switch -->
	{!! Html::script('js/jquery.iphone.toggle.js')!!}
	<!-- autogrowing textarea plugin -->
	{!! Html::script('js/jquery.autogrow-textarea.js')!!}
	<!-- multiple file upload plugin -->
	{!! Html::script('js/jquery.uploadify-3.1.min.js')!!}
	<!-- history.js for cross-browser state change on ajax -->
	{!! Html::script('js/jquery.history.js')!!}
	<!-- application script for Charisma demo -->
	{!! Html::script('js/charisma.js')!!}
	{!! Html::script('js/noticias.js')!!}
          
    @if($gestion['gestion_valida'] && (strcmp($titulo,"Sistema de Apoyo a la Empresa TIS")==0))       
        @if($datos['numdoc']>3)
            <script language="JavaScript" type="text/javascript">
			    var nume={{$datos['numdoc']}}
				setTamAviso( 130 );
				 setNumAvisos( nume );
				 timerID = setTimeout("moverAvisos()", 1000);
		    </script>
        @endif
    @endif
        <!-- Inicio Calendario de tareas -->
{!! Html::script('js/colorpicker/colorpicker.js')!!}
{!! Html::script('js/jquery-qtip-1.0.0-rc3140944/jquery.qtip-1.0.js')!!}
{!! Html::script('js/lib/jshashtable-2.1.js')!!}
{!! Html::script('js/frontierCalendar/jquery-frontier-cal-1.3.2.min.js')!!}
{!! Html::script('js/manipulacion.js')!!}
 @if(strcmp($titulo,"Planificar Tareas Grupo Empresa")==0)
 	@include(asset("jsr/calendarfooter.php"))
 @endif
<!--  fin Calendario de tareas -->