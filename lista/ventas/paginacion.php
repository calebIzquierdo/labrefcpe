<?php
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
		
	$objconfig->table 	= "cabmovimiento as c";
	$objconfig->campoId = "c.nromovimiento";

	
	$objconfig->campos = array("*");
	$query 	= $objconfig->genera_sql($and);
//        echo $query;
	$row 	= $objconfig->execute_select($query);
	
	echo "<table width='100%'  border='1' style='border: 1px #000000 solid;' bgcolor='#FFFFFF'  >";
	echo "<tr class='PieIndex' align='center'>";
	echo "<td>Nro. Comprobante</td>";
	echo "<td>Fecha</td>";	
	echo "<td>cliente</td>";
	echo "<td>Hora</td>";
	echo "<td colspan='2'>Acciones</td>";
	echo "</tr>";
	
	$num_total_registros = $row[2];
	$total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);
	
	$queryP	= "select c.nromovimiento,c.serie,c.nrocomprobante,c.fecha_movimiento,cl.nombres,c.hora
			   from cabmovimiento as c
			   inner join clientes as cl on(c.idcliente=cl.idcliente)
			   where c.idtipomovimiento=5 and c.estareg=1 ".$and." order by c.nromovimiento limit 10 offset 0";
//	echo $queryP;
	$rowP 	= $objconfig->execute_select($queryP,1);
	$count=0;
	foreach($rowP[1] as $items)
	{
		$count++;
		$estareg="ACTIVO";
		if($items["estareg"]==0){$estareg="INACTIVO";}
		
		echo "<tr class='texto_tb'>";
		echo "<td align='center' width='10%'><input type='hidden' id='nrocomprobante".$count."' value='".($items["serie"]."-".$items["nrocomprobante"])."' />".($items["serie"]."-".$items["nrocomprobante"])."</td>";
		echo "<td align='center' width='10%'>".$items["fecha_movimiento"]."</td>";	
		echo "<td width='10%'><input type='hidden' id='nombre".$count."' value='".strtoupper($items["nombres"])."' />".strtoupper($items["nombres"])."&nbsp;</td>";
		echo "<td width='10%' align='center'>".substr($items["hora"],10)."&nbsp;</td>";
		echo "<td width='10%' align='center'><img src='../../img/descargas.png' style='cursor:pointer;' title='Agregar Registro' onclick='enviar(".$count.",".$items["nromovimiento"].")' /></td>";
		echo "</tr>";
	}
	
	echo "<tr>";
    echo "<td colspan='13' class='PieIndex'>";
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