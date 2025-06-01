<?php
	include("../../include/main2.php");
	include("../../objetos/class.conexion.php");
	$objconfig = new conexion();
	$valor = isset($_GET["valor"])?strtoupper($_GET["valor"]):"";
	cabecera();
?>
	

<script src="mantenimiento.js"></script>
<!--    Estilo generar para la paginacion del registro   -->
		<link type="text/css" href="<?=$path?>css/style_2.css" rel="stylesheet" />
       <!--    JQUERY  -->
        <script type="text/javascript" src="<?=$path?>/js/jquery.js"></script>  
        <script type="text/javascript" language="javascript" src="<?=$path?>js/funciones.js"></script>
        <!--    JQUERY    -->
        <!--    FORMATO DE TABLAS    -->
        <link type="text/css" href="<?=$path?>/css/demo_table.css" rel="stylesheet" />
		<!--    FORMATO DE TABLAS    -->
        <script type="text/javascript" language="javascript" src="<?=$path?>/js/jquery.dataTables.js"></script>
		
<!--    Fin del Estilo generar para la paginacion del registro   -->
		
<style>
#miVentana{
	position: fixed; 
	width: 450px; 
	height: 387px; 
	top: 0; 
	left: 0; 
	font-family:Verdana, Arial, Helvetica, sans-serif; 
	font-size: 12px; 
	font-weight: normal; 
	border: #333333 3px solid; 
	background-color: #FAFAFA; 
	color: #000000; 
	display:none;
}
#div-titulo-ventanas{
	font-weight: bold; 
	text-align: left; 
	color: #FFFFFF; 
	padding: 5px; 
	/*background-color:#006394;*/
	background-color:#327E04
}
.texto-input{
	 text-transform:uppercase;
	 font-family:"Arial Narrow";
	 font-size:12px;
}
</style>

<div class="Titulo">
REGISTRO DE PRODUCTOS GENERADOS

</div>
  <!--  <header id="titulo">

        <h3>Registro del catalogo de paises</h3>
    </header> -->
    <article id="contenido"></article>
     <footer>
		<?php
			pie();
		?>
    </footer> 


<div id="blokea" style="position:fixed; width:100%; height:100%; top:0; left:0; display:none">
	<div class="ui-overlay">
        <div class="ui-widget-overlay" >
        </div>            	
    </div>
</div>

