<?php
	include("../../include/main.php");
	
	$valor = isset($_GET["valor"])?strtoupper($_GET["valor"]):"";
	cabecera();
?>
<script src="mantenimiento.js"></script>
<style>
#miVentana{
	position: fixed; 
	width: 450px; 
	height: 250px; 
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
	Registro del catalogo de dimensiones
</div>
<div style="height: 5px"></div>
<input type="button" name="nuevo" id="nuevo" value="Nuevo" class="button white" onclick="cargar_form(1,0);" />
<div style="height: 20px"></div>
Buscar : <input type="text" name="valor" id="valor" size="50" value=<?php echo $valor; ?> >
<img src="../../img/buscar.png" title="Buscar" style="cursor:pointer;" onclick="Buscar(1)" />
<div style="height: 20px"></div>
<div id="content"><?php require('paginacion.php'); ?></div>			
<div id="blokea" style="position:absolute; width:100%; height:100%; top:0; left:0; display:none">
	<div class="ui-overlay">
        <div class="ui-widget-overlay" >
        </div>            	
    </div>
</div>
<div id="miVentana" >
 <div id="div-titulo-ventanas">Mantenimiento del Catalogo de Dimensiones</div>
	<div id="formM">
 	</div>
 <div style="padding: 10px; background-color: #F0F0F0; text-align: right; margin-top: 44px;">
 	<input id="btnAceptar" onclick="validar_form();" name="btnAceptar" class="button white" size="20" type="button" value="Aceptar" />
 	&nbsp;&nbsp;
  	<input id="bntCerrar" onclick="ocultarVentana();" name="bntCerrar" class="button white" size="20" type="button" value="Cerrar" />
 </div>
</div>
<script>
var Pagina = <?php echo $pagina?>;
var nPag = <?php echo $TAMANO_PAGINA?>;
</script>  
</br>
 <footer>
		<?php
		pie();
	?>
    </footer> 