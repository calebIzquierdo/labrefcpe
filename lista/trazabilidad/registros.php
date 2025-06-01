<script type="text/javascript" language="javascript" src="../../js/jslistadopaises.js"> </script>

<!--    Estilo generar para la paginacion del registro   -->
		<link type="text/css" href="<?=$path?>css/style_2.css" rel="stylesheet" />
       <!--    JQUERY  -->
        <script type="text/javascript" src="../../js/jquery.js"></script>  
        <script type="text/javascript" language="javascript" src="../../js/funciones.js"></script>
        <!--    JQUERY    -->
        <!--    FORMATO DE TABLAS    -->
        <link type="text/css" href="../../css/demo_table.css" rel="stylesheet" />
		<!--    FORMATO DE TABLAS    -->
        <script type="text/javascript" language="javascript" src="../../js/jquery.dataTables.js"></script>
		
<!--    Fin del Estilo generar para la paginacion del registro   -->

<?php
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
		
	$objconfig->table   = "cabmovimiento as c";
	$objconfig->campoId = "c.nromovimiento";

	$objconfig->campos = array("*");
	$query 	= $objconfig->genera_sql($and);
	$row 	= $objconfig->execute_select($query);
?>
 <table cellpadding="0" cellspacing="0" border="0" class="display" id="tabla_lista_paises">
		<thead>
			<tr>
				<th>Item</th><!--Estado-->
				<th>Cod. Trazabilidad</th>
				<th>Ubicacion / Fase</th>
				<th>Fecha</th>
				<th>Producto</th>
				<th>Empresa Cert.</th>
				<th>Tipo Cert.</th>
				<th>Peso Neto</th>
				<th>Acciones</th>
			
			</tr>
        </thead>
                <tfoot>
                    <tr>
						<th></th>
                        <th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
					
                    </tr>
                </tfoot>
                <tbody>
 <?

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
                                                     not d.valor_fase='undefined'",1);
                foreach($rows6[1] as $r6)
                {
                    $fase.=$r6["fase"]."=".$r6["valor_fase"]."|";
                }
                    
		echo "<tr class='texto_tb'>";
		echo "<td align='center' >".$items["codtrazabilidad"]."</td>";
        echo "<td align='center' >".strtoupper(($rowsF[1]["descripcion"]))."/".substr($fase,0,strlen($fase)-1)."</td>";
		echo "<td align='center' >".$items["fecha_movimiento"]."</td>";	
		echo "<td ><input type='hidden' id='nombre".$count."' value='".strtoupper($items["prod"])."' />".strtoupper($items["prod"])."&nbsp;</td>";
		echo "<td ><input type='hidden' id='codtrazabilidad".$count."' value='".$items["codtrazabilidad"]."' />".substr($empresa,0,strlen($empresa) - 1)."&nbsp;</td>";
		echo "<td >".substr($certificado,0,strlen($certificado) - 1)."&nbsp;</td>";
		echo "<td align='right'>".number_format($peso_neto,2)."&nbsp;</td>";
		echo "<td align='center'><img src='../../img/descargas.png' style='cursor:pointer;' title='Editar Registro' onclick='enviar(".$items["idproductor"].",".$count.",".$peso_neto.",".$items["item_detmovimiento"].")' /></td>";
		echo "</tr>";
	}
?>
 <tbody>
</table>

               