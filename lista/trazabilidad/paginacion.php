<?php
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
		
	$objconfig->table   = "cabmovimiento as c";
	$objconfig->campoId = "c.nromovimiento";

	
	$objconfig->campos = array("*");
	$query 	= $objconfig->genera_sql($and);
	$row 	= $objconfig->execute_select($query);
	
	echo "<table width='100%'  border='1' style='border: 1px #000000 solid;' bgcolor='#FFFFFF'  >";
	echo "<tr class='PieIndex' align='center'>";
	echo "<td>Cod. Trazabilidad</td>";
    echo "<td>Ubicacion / Fase</td>";	
	echo "<td>Fecha</td>";	
	echo "<td>Producto</td>";
	echo "<td>Empresa Cert.</td>";
	echo "<td>Tipo Cert.</td>";
	echo "<td>Peso Neto</td>";
	echo "<td colspan='2'>Acciones</td>";
	echo "</tr>";
	
	$num_total_registros    = 1;//$row[2];
	$total_paginas          = ceil($num_total_registros / $TAMANO_PAGINA);
	
//        echo $num_total_registros;
	$queryP = "select d.codtrazabilidad,c.nromovimiento,c.fecha_movimiento,c.productor,
			   c.idproductor,c.peso_ultimo ,d.item_detmovimiento,
			   p.descripcion as prod,c.idetapa
			   from cabmovimiento as c 
			   inner join detmovimiento as d on(c.nromovimiento=d.nromovimiento and c.idtipomovimiento=d.idtipomovimiento)
			   inner join productos as p on(d.idproducto=p.idproducto)
			   where c.idtipomovimiento=1 and c.estareg=1 ".$and." order by c.nromovimiento";
//        echo $queryP;
	$rowP 	= $objconfig->execute_select($queryP,1);
	$count=0;
	foreach($rowP[1] as $items)
	{
		$count++;
		$estareg="ACTIVO";
		if($items["estareg"]==0){$estareg="INACTIVO";}
		
		$rows1 = $objconfig->execute_select("select empresa,certificados,peso,precio,descuento_total,precio_total 
						     from detmovimiento_detalle 
						     where itemdetmovimiento=".$items["item_detmovimiento"]." group by 
						     empresa,certificados,peso,precio,descuento_total,precio_total");
		
		$precio = $rows1[1]["precio"];  
	
		$emp 	= explode("|",$rows1[1]["empresa"]);
		$cert	= explode("|",$rows1[1]["certificados"]);
		
		$empresa="";
		for($i=0;$i<count($emp);$i++)
		{
			if($emp[$i] != 0)
			{
				$rows2 = $objconfig->execute_select("select * from empresa_certificadora where idempresa=".$emp[$i]);
				$empresa .=  strtoupper($rows2[1]["descripcion"]).",";
			}
		}		
		
		$certificado="";
		for($i=0;$i<count($cert);$i++)
		{
			if($cert[$i] != 0)
			{
				$rows3 		 = $objconfig->execute_select("select * from certificados where idcertificados=".$cert[$i]);
				$certificado .=  strtoupper($rows3[1]["descripcion"]).",";
			}
		}
		
		if($items["peso_ultimo"]==0)
		{
			$peso_neto	= $rows1[1]["peso"] - $rows1[1]["descuento_total"];
		}else{
			$peso_neto	= $items["peso_ultimo"];
		}
		
		$precio_total 	= ($rows1[1]["peso"] * $rows1[1]["precio"]) - $rows1[1]["descuento_total"];
		$rowsF          = $objconfig->execute_select("select * from etapas where idetapa=".$items["idetapa"]);
                
						
                $fase="";

                $rows6 = $objconfig->execute_select("select d.fase,d.valor_fase from cabmovimiento as c
                                                     inner join detmovimiento as d on(c.nromovimiento=d.nromovimiento 
                                                     and c.idtipomovimiento=d.idtipomovimiento)
                                                     where c.nromovimiento_padre=".$items["nromovimiento"]." and c.idtipomovimiento=3 and 
                                                     not d.valor_fase='undefined'and d.nromovimiento=(select max(nromovimiento )
													from cabmovimiento where nromovimiento_padre=".$items["nromovimiento"].")",1);
                foreach($rows6[1] as $r6)
                {
                    $fase.=$r6["fase"]."=".$r6["valor_fase"]."|";
                }
                
		echo "<tr class='texto_tb'>";
		echo "<td align='center' width='20%'>".$items["codtrazabilidad"]."</td>";
        echo "<td align='center' width='15%'>".strtoupper(utf8_decode($rowsF[1]["descripcion"]))." --> ".substr($fase,0,strlen($fase)-1)."</td>";
		echo "<td align='center' width='7%'>".$items["fecha_movimiento"]."</td>";	
		echo "<td align='center' width='12%'><input type='hidden' id='nombre".$count."' value='".strtoupper($items["prod"])."' />".strtoupper($items["prod"])."</td>";
		echo "<td align='center' align='center' width='15%'><input type='hidden' id='codtrazabilidad".$count."' value='".$items["codtrazabilidad"]."' />".substr($empresa,0,strlen($empresa) - 1)."&nbsp;</td>";
		echo "<td align='center' width='10%'>".substr($certificado,0,strlen($certificado) - 1)."&nbsp;</td>";
		echo "<td width='5%' align='right'>".number_format($precio,2)."&nbsp;</td>";
		echo "<td align='center' width='10%'>".number_format($peso_neto,2)."&nbsp;</td>";
		
		echo "<td width='5%' align='center'><img src='../../img/descargas.png' style='cursor:pointer;' title='Editar Registro' onclick='enviar(".$items["idproductor"].",".$count.",".$peso_neto.",".$items["item_detmovimiento"].",".$precio.")' /></td>";
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