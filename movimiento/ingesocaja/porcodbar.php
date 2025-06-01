<?php 
	
	include("../../objetos/class.cabecera.php");
	include("../../objetos/class.conexion.php");
	$objconfig = new conexion();
	
	//$op 	= $_POST["op"];
	$cod			= $_POST["cod"];
	$count			= $_POST["count_enf"];
	$monto_total	= $_POST["monto_total"];
	
	
	$sqlM = " select m.idingresomuestra, m.idtipo, m.fecharecepcion,  m.idtipoatencion, m.idestablesolicita , m.codbarra,
			descripcion as tipatencion
			 from muestra as m
			 inner join tipo_atencion as ta on (ta.idtipoatencion=m.idtipoatencion)
			 where m.idpago=0 and m.estareg=1 and m.codbarra='".$cod."'";
	//echo $sqlM."\n";		 
	$monto=$monto_total;
	
	
?>


<?php
		
$rowF = $objconfig->execute_select($sqlM,1);

$count_enf=0;

//var_dump($row[1]);
foreach($rowF[1] as $rM)
{
	$sqlF2 = "select m.idmuestradetalle,m.idingresomuestra, m.idtipo_examen, m.idarea,m.idareatrabajo, 
				e.descripcion as tipexamen, a.descripcion as area_destino,sat.descripcion as subarea, ep.valor, 
				ep.idtipoatencion,m.cantidad from muestra_det as m 
				inner join tipo_examen as e on(e.idtipo_examen=m.idtipo_examen)
					inner join areas as a on(a.idarea=m.idarea) 
					inner join area_trabajo as sat on(sat.idareatrabajo=m.idareatrabajo)
					inner join tipo_examen_precio as ep on(ep.idtipo_examen=e.idtipo_examen) 
				where m.idingresomuestra='".$rM["idingresomuestra"]."' and ep.idtipoatencion='".$rM["idtipoatencion"]."'  "; //and ep.idtipoatencion in(4,9)";
	//	echo $sqlF2;
	// echo $rM["idingresomuestra"];
	$rF1 = $objconfig->execute_select($sqlF2,1);
	$count_enf= $count;		
	foreach($rF1[1] as $rF)
	{
		//if ($rF["idtipoatencion"]!=6){
		$count_enf++;
								
		$monto+=floatval($rF["valor"])*floatval($rF["cantidad"]);
	
	?>

	<tr id='itemdiagnostico<?php echo $count_enf; ?>' name='itemdiagnostico<?php echo $count_enf; ?>' >
		<td >
			<input type='hidden' name='idmuestradetalle<?php echo $count_enf; ?>' id='idmuestradetalle<?php echo $count_enf; ?>' value='<?php echo $rF["idmuestradetalle"]; ?>' />
			<input type='hidden' name='idingresomuestra<?php echo $count_enf; ?>' id='idingresomuestra<?php echo $count_enf; ?>' value='<?php echo $rF["idingresomuestra"]; ?>' />
			<?php echo $count_enf ; ?>
		</td>
		<td>
		<input type='hidden' name='cantidad<?php echo $count_enf; ?>' id='cantidad<?php echo $count_enf; ?>' value='<?php echo $rF["cantidad"]; ?>' />
			<?php echo number_format($rF["cantidad"],2 ); ?>
		</td>
		<td >
			<input type='hidden' name='fecharecepcion<?php echo $count_enf; ?>' id='fecharecepcion<?php echo $count_enf; ?>' value='<?php echo $rM["fecharecepcion"]; ?>' />
			<?php echo $objconfig->FechaDMY($rM["fecharecepcion"]) ; ?>
		</td>
		<td >
			<input type='hidden' name='idtipoatencion<?php echo $count_enf; ?>' id='idtipoatencion<?php echo $count_enf; ?>' value='<?php echo $rF["idtipoatencion"]; ?>' />
			<?php echo $rM["tipatencion"] ; ?>
		</td>
		
		<td >
			<input type='hidden' name='codbarra<?php echo $count_enf; ?>' id='codbarra<?php echo $count_enf; ?>' value='<?php echo $rM["codbarra"]; ?>' />
			<?php echo $rM["codbarra"] ; ?>
		</td>
		<td>
			<input type='hidden' name='idtipo_examen<?php echo $count_enf; ?>' id='idtipo_examen<?php echo $count_enf; ?>' value='<?php echo $rF["idtipo_examen"]; ?>' />
			<input type='hidden' name='tipo_examen<?php echo $count_enf; ?>' id='tipo_examen<?php echo $count_enf; ?>' value='<?php echo strtoupper($rF["tipexamen"] ); ?>' />
			<?php echo strtoupper($rF["tipexamen"] ); ?>
		</td>
		<td>
			<input type='hidden' name='idarea<?php echo $count_enf; ?>' id='idarea<?php echo $count_enf; ?>' value='<?php echo $rF["idarea"]; ?>' />
			<?php echo strtoupper($rF["area_destino"] ); ?>
		</td>
		<td>
		<input type='hidden' name='idareatrabajo<?php echo $count_enf; ?>' id='idareatrabajo<?php echo $count_enf; ?>' value='<?php echo $rF["idareatrabajo"]; ?>' />
			<?php echo strtoupper($rF["subarea"] ); ?>
		</td>
		<td >
		<input type='hidden' name='valor<?php echo $count_enf; ?>' id='valor<?php echo $count_enf; ?>' value='<?php echo $rF["valor"]; ?>' />
		<input type='hidden' name='subtotal<?php echo $count_enf; ?>' id='subtotal<?php echo $count_enf; ?>' value='<?php echo number_format(floatval($rF["valor"])*floatval($rF["cantidad"]),2 ); ?>' />
			<?php echo number_format(floatval($rF["valor"])*floatval($rF["cantidad"]),2 ); ?>
		</td>
		<td >
			
			<img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_diagnostico(<?php echo $count_enf; ?>)' title='Borrar REgistro' />
			
		</td>
	</tr>
				
		<?php
			} 
		}
		?>		
<input type="hidden" id="contar_diagnostico" name="contar_diagnostico" value="<?php echo $count_enf; ?>" />
<input type="hidden" id="contar_diagnostico2" name="contar_diagnostico2" value="<?php echo $count_enf; ?>" />

<script type="text/javascript">
	
     $("#idestablesolicita").val(<?=$rM["idestablesolicita"];?>);
	 var count_enf=<?php echo $count_enf; ?>;
	 var monto_total=<?php echo $monto; ?>;
	 
</script>
