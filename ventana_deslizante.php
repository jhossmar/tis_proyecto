

<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="ventana modal, css, css3, modal" />
<meta name="description" content="Ejemplo que muestra ventanas modales animadas solo con css y su selector target. No solo CSS" lang="ES" />

<title>Crear ventanas modales usando solo css y su selector target</title>
<style type="text/css">

body{font-family: Arial,sans-serif;color:#333;}
.center{
	position:absolute;
	width:700px;
	height:600px;
	top:50%;
	left:50%;
	margin-left:-350px;
	margin-top:-250px;	

}
h1{
	font-size:20px;
}
.modalmask {
	position: fixed;
	font-family: Arial, sans-serif;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
	background: rgba(0,0,0,0.8);
	z-index: 99999;
	opacity:0;
	-webkit-transition: opacity 400ms ease-in;
	-moz-transition: opacity 400ms ease-in;
	transition: opacity 400ms ease-in;
	pointer-events: none;
}
.modalmask:target {
	opacity:1;
	pointer-events: auto;
}
.modalbox{
	width: 800px;
	position: relative;
	padding: 5px 20px 13px 20px;
	background: #fff;
	border-radius:3px;
	-webkit-transition: all 500ms ease-in;
	-moz-transition: all 500ms ease-in;
	transition: all 500ms ease-in;
	
}

.movedown {
	margin: 0 auto;
}
.rotate {
	margin: 10% auto;
	-webkit-transform: scale(-5,-5); 
	transform: scale(-5,-5);
}
.resize {
	margin: 10% auto;
	width:0;
	height:0;

}
.modalmask:target .movedown{		
	margin:10% auto;
}
.modalmask:target .rotate{		
	transform: rotate(360deg) scale(1,1);
    -webkit-transform: rotate(360deg) scale(1,1);
}

.modalmask:target .resize{
	width:400px;
	height:200px;
}



.close {
	background: #606061;
	color: #FFFFFF;
	line-height: 25px;
	position: absolute;
	right: 1px;
	text-align: center;
	top: 1px;
	width: 24px;
	text-decoration: none;
	font-weight: bold;
	border-radius:3px;
	font-size:16px;
}

.close:hover { 
	background: #FAAC58; 
	color:#222;
}

ul{
	width:500px;
	margin:20% auto;
	list-style:none;
}
ul li{

	float:left;
	margin-right:35px;

}
ul li a{
	font-family: Arial, sans-serif;
	font-size:16px;
	text-decoration:none;
	background:#222;
	padding:20px;
	color:#fff;
	font-weight:bold;
	border-radius:3px;
	-webkit-transition: all 200ms ease-in;
	-moz-transition: all 200ms ease-in;
	transition: all 200ms ease-in;
}
ul li a:hover{
	background:#FAAC58;
	color:#222;

}

a{
	text-decoration:none;
	font-family: 'Black Ops One', cursive;
	font-size:25px;
	color:#222;

}
a:hover{

	color:#DF7401;
	
}
.nsc{
	position:absolute;
	bottom:40%;
	right:0;
}
</style>
</head>
<body>

<div class="center">
	 
	 
		
	<h1 align="center"><p style="background:#222;color:#fff;padding:4px;">Pulsa los botones para ver las ventanas modales</p></h1>
	<ul>
		<li><a href="#modal1">DESLIZAR</a></li>
		<li><a href="#modal2">ROTAR</a></li>
		<li><a href="#modal3">REDIMENSIONAR</a></li>
	</ul>
	<div id="modal1" class="modalmask">
		<div class="modalbox movedown">
			<a href="#close" title="Close" class="close">X</a>
			<h2>DESLIZAR</h2>
			<embed src='archivos/004.pdf' width=800 height=500 />
		 </div>
	</div>
	<div id="modal2" class="modalmask">
		<div class="modalbox rotate">
			<a href="#close" title="Close" class="close">X</a>
			<h2>ROTAR</h2>
			<p>Usando la propiedad transform de CSS3, podemos hacer que las ventanas aparezcan rotando.</p>
			<p>No hay nada de Javascript, solo unas pocas lineas de CSS.</p>
		</div>
	</div>
		<div id="modal3" class="modalmask">
		<div class="modalbox resize">
			<a href="#close" title="Close" class="close">X</a>
			<h2>REDIMENSIONAR</h2>
			<p>También puedes redimensionar la ventana hasta hacerla desaparecer.</p>
			<p>Las posibilidades que ofrece CSS3 son múltiples, tan solo hace falta un poco de imaginación para crear efectos realmente llamativos.</p>
		</div>
	</div>
		


</body>
</html>
