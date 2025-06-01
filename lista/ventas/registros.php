<?php
	include("../../objetos/class.conexion.php");
	include("../../include/utf.php");
	
	$objconfig = new conexion();
		
	$objconfig->table 	= "cabmovimiento as c";
	$objconfig->campoId = "c.nromovimiento";

	
	$objconfig->campos = array("*");
	$query 	= $objconfig->genera_sql($and);
	$row 	= $objconfig->execute_select($query);
	
	
?>
<script type="text/javascript" language="javascript" src="../../js/jslistadopaises.js">

</script>

 <table cellpadding="0" cellspacing="0" border="0" class="display" id="tabla_lista_paises">
		<thead>
			<tr>
				
				<th>Nro. Comprobante</th>
				<th>Fecha</th>
				<th>Cliente</th>
				<th>Hora</th>
				<th>Accion</th>
			
			</tr>
        </thead>
                <tfoot>
                    <tr>
						<th></th>
                        <th></th>
                        <th></th>
						<th></th>
						<th></th>
						
					
					
                    </tr>
                </tfoot>
                <tbody>
 <?
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
		echo "<td width='10%' align='center'><img src='../../img/descargas.png' style='cursor:pointer;' title='Editar Registro' onclick='enviar(".$count.",".$items["nromovimiento"].")' /></td>";
		echo "</tr>";
	}
?>
 <tbody>
</table>

               