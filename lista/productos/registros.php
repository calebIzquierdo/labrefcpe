<?php
include("../../objetos/class.conexion.php");	
		
	$objconfig = new conexion();
	
	$objconfig->table 	= "productos as p";
	$objconfig->campoId = "p.idproducto";
	
	$objconfig->campos = array("p.idproducto","p.descripcion","p.idtipoproducto",
								"(select t.descripcion from tipo_producto as t 
								where t.idtipoproducto=p.idtipoproducto) as categoria","p.estareg");
	
	$query = $objconfig->genera_sql(" estareg=1 ".$and);
	$row = $objconfig->execute_select($query);

	// $inner	= "inner join tipo_producto as t on(p.idtipoproducto=t.idtipoproducto)";
	// $objconfig->campos = array("p.idproducto","p.descripcion","t.descripcion as categoria","p.estareg");
	// $query = $objconfig->genera_sql(" (p.estareg=1) ".$and,"",$inner);

	
?>
<script type="text/javascript" language="javascript" src="../../js/jslistadopaises.js">

</script>

 <table cellpadding="0" cellspacing="0" border="0" class="display" id="tabla_lista_paises">
		<thead>
			<tr>
				
				<th>Codigo</th>
				<th>Producto</th>
				<th>Categoria</th>
				<th>Estado</th>
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
	
	$queryP = $objconfig->genera_sql(" estareg=1 ");
	$rowP 	= $objconfig->execute_select($queryP,1);	
	$count=0;
	foreach($rowP[1] as $items)
	{
		$count++;
		$estareg="ACTIVO";
		if($items["estareg"]==0){$estareg="INACTIVO";}
		
		echo "<tr class='texto_tb'>";
		echo "<td align='center' width='10%'>".$items["idproducto"]."</td>";
		echo "<td align='left' width='40%'><input type='hidden' id='nombre".$count."' value='".strtoupper($items["descripcion"])."' />".strtoupper($items["descripcion"])."</td>";
		echo "<td align='center' width='15%'>".strtoupper($items["categoria"])."</td>";
		echo "<td align='center' width='10%'>".$estareg."</td>";
		echo "<td width='10%' align='center'><img src='../../img/descargas.png' style='cursor:pointer;' title='Editar Registro' onclick='enviar(".$items["idproducto"].",".$count."," .$items["idtipoproducto"].")' /></td>";
		echo "</tr>";
	}
	
?>
 <tbody>
</table>

               