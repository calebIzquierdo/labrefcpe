<?php
	$valor = isset($_GET["valor"])?strtoupper($_GET["valor"]):"";
	$and="";
	if($valor!=""){$and = " and (upper(p.descripcion) like '%".$valor."%' or d.codtrazabilidad like '%".$valor."%') and c.estareg=1 and c.idtipomovimiento=1";}
	
	$TAMANO_PAGINA = 10;
	
	//capturas la pagina en la q estas
	if (isset($_GET['pagina'])){$pagina=$_GET["pagina"];}else{$pagina='';} 

//si estas en la primera pagin ale asignas los valores iniciales
	if (!$pagina){$inicio=0;$pagina=1;}else{$inicio = ($pagina - 1) * $TAMANO_PAGINA;} 

?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="../../css/stilo_button.css"/>	
<link href="../../css/pagination.css" rel="stylesheet" />
<script language="JavaScript" src="../../js/jquery-1.4.2.min.js"></script>
<script language="javascript" src="../../js/jquery.pagination.js"></script>
<script src="mantenimiento.js"></script>
<script>
	var Pagina = <?=$pagina?>;
	var nPag = <?=$TAMANO_PAGINA?>;
</script>
<div class="Titulo">
	productos acopiados
</div>
<div style="height: 5px"></div>
<div class="Contenedor">
    <div id="tab1" class="Contenido">
    		Buscar Por&nbsp;&nbsp;:&nbsp;&nbsp;<input type="text" name="valor" id="valor" value="<?=$valor?>" size="60" >&nbsp;&nbsp;
    		<input type="button" name="btnbuscar" id="btnbuscar" value="Buscar" class="button white" onclick="Buscar(0);" />
    		<div style="height: 5px"></div>
    		<div id="content">
                    <?php 
                        require('paginacion.php'); 
                    ?>
                </div>			
		</div>
    </div>
</div>