<?php
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
	$TAMANO_PAGINA = 10;
	
	//capturas la pagina en la q estas
	if (isset($_GET['pagina']))
	{ 
	  	$pagina	= $_GET["pagina"]; 
	}
	else 
	{ 
	  	$pagina	= ''; 
	} 

//si estas en la primera pagin ale asignas los valores iniciales
	if (!$pagina) 
	{
		$inicio	= 0;
		$pagina	= 1;
	}
	else 
	{
		$inicio = ($pagina - 1) * $TAMANO_PAGINA;
	} 
	$where=false;
	if($valor!="")
	{
		$where = " where upper(i.descripcion) ilike '%".$valor."%'";
	}
	
	$objconfig->table 	= "indicadores as i";
	$objconfig->campoId = "i.idindicador";
	
	$objconfig->campos = array("*");
	$query = $objconfig->genera_sql($where);

	$row = $objconfig->execute_select($query);
	
	echo "<table width='100%'  border='1' style='border: 1px #000000 solid;' bgcolor='#FFFFFF'  >";
	echo "<tr class='PieIndex' align='center'>";
	echo "<td>Codigo</td>";
	echo "<td>Tipo</td>";
	echo "<td>Descripcion</td>";
	echo "<td>Estado</td>";
	echo "<td>Acciones</td>";
	echo "</tr>";
	
	$num_total_registros = $row[2];
	$total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);
	
	$objconfig->campos = array("i.idindicador","d.descripcion as dimen","i.descripcion","i.estareg");
	$inner = "inner join dimensiones as d on(i.iddimension=d.iddimension)";
	$queryP = $objconfig->genera_sql($where,$objconfig->campoId,$inner," limit $TAMANO_PAGINA offset $inicio");
	$rowP 	= $objconfig->execute_select($queryP,1);
	
	foreach($rowP[1] as $items)
	{
		$estareg="ACTIVO";
		if($items["estareg"]==0){$estareg="INACTIVO";}
		
		echo "<tr class='texto_tb'>";
		echo "<td align='center' width='20%'>".$items["idindicador"]."</td>";
		echo "<td align='center' width='20%'>".strtoupper($items["dimen"])."</td>";
		echo "<td width='40%'>".strtoupper($items["descripcion"])."</td>";
		echo "<td align='center' width='10%'>".$estareg."</td>";
		echo "<td width='10%' align='center'><img src='../../img/edit.png' style='cursor:pointer;' title='Editar Registro' onclick='cargar_form(2,".$items["idindicador"].")' /></td>";
		echo "</tr>";
	}
	
	echo "<tr>";
    echo "<td colspan='5' class='PieIndex'>";
	echo "<div id='Pagination' align='center'></div>";
    echo "</td>";
	echo "</tr>";
	echo "</table>";
	
?>
<script>
	//Paginación
	function pageselectCallback(page_index, jq){
		// Get number of elements per pagionation page from form
		var max_elem = Math.min((page_index+1) * <?=isset($TAMANO_PAGINA)?$TAMANO_PAGINA:0?>, <?=isset($num_total_registros)?$num_total_registros:0?>);
		// Prevent click event propagation
		return false;
	}
		
	function getOptionsFromForm(){
		var opt = {callback: pageselectCallback};
		// Collect options from the text fields - the fields are named like their option counterparts
		opt['items_per_page'] = <?=isset($TAMANO_PAGINA)?$TAMANO_PAGINA:0?>;
		opt['num_display_entries'] = 5;
		opt['num_edge_entries'] = 1;
		opt['prev_text'] = "<< ";
		opt['next_text'] = " >>";
		opt['current_page'] = <?=isset($pagina)?$pagina:0?>;
//		opt['op'] = 1;
		opt['op'] = <?=isset($Op)?$Op:0?>;
		// Avoid html injections in this demo
		
		return opt;
	}
	
	$(document).ready(function(){
		var optInit = getOptionsFromForm();
		$("#Pagination").pagination(<?=isset($num_total_registros)?$num_total_registros:0?>, optInit);
		
	});
</script>
