<?php 
	
	include("../../objetos/class.cabecera.php");
	include("../../objetos/class.conexion.php");
	$objconfig = new conexion();
	
	$op 	= $_POST["op"];
	$cod	= $_POST["cod"];
	
	$sqlM = " select m.idingresomuestra, m.idtipo, m.fecharecepcion,  m.idtipoatencion, m.idestablesolicita , m.codbarra,
			descripcion as tipatencion
			 from muestra as m
			 inner join tipo_atencion as ta on (ta.idtipoatencion=m.idtipoatencion)
			 where m.idpago=0 and m.estareg=1 and m.idestablesolicita=".$cod;
			 
	$monto=0;
	
	
?>

<div style="height:280px;  overflow-x:hidden;" >
	<div class="row">
	<div class="col-sm-12">
	<div class="panel panel-info ">
		<div class="panel-heading">EXAMENES PENDIENTES DE COBRO </div>
		<div class="panel-body">
			<table class="table table-striped table-bordered table-hover table-responsive" id="tbdiagnostico" name="tbdiagnostico"  >
				<thead>

				<tr>
					<td >#</td>
					<td>Cantidad</td>
					<td >Fecha Ing </td>
					<td >Atención </td>
					<td >CodBarra </td>
					<td >Exámen </td>
					<td >Unidad  </td>
					<td >Área  </td>
					<td >Costo S.</td>
					<td ></td>
				</tr>
				<tbody>
				<?php
							
				$rowF = $objconfig->execute_select($sqlM,1);
				
				$count_enf=0;
				
				
				foreach($rowF[1] as $rM)
				{
					$sqlF2 = "select m.idmuestradetalle,m.idingresomuestra,  m.idtipo_examen, m.idarea,m.idareatrabajo,  e.descripcion as tipexamen, 
					a.descripcion as area_destino,sat.descripcion as subarea, ep.valor, ep.idtipoatencion
					from muestra_det as m
					inner join tipo_examen as e on(e.idtipo_examen=m.idtipo_examen)
					inner join areas as a on(a.idarea=m.idarea)
					inner join area_trabajo as sat on(sat.idareatrabajo=m.idareatrabajo)
					inner join tipo_examen_precio as ep on(ep.idtipo_examen=e.idtipo_examen)
					
					where m.idingresomuestra=".$rM["idingresomuestra"]." and ep.idtipoatencion=".$rM["idtipoatencion"]."  ";
					
					$rF1 = $objconfig->execute_select($sqlF2,1);	
					
					foreach($rF1[1] as $rF)
					{
						if ($rF["idtipoatencion"]!=6){
						$count_enf++;
												
						//$monto+=$rF["valor"];
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
							<?php echo number_format($rF["valor"],2 ); ?>
						</td>
						<td >
							
							<img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_diagnostico(<?php echo $count_enf; ?>)' title='Borrar Registro' />
							
						</td>
					</tr>
				<?php 
						}
					}
			}?>
				</tbody>
				</thead>
				
			</table>
			<input type="hidden" id="contar_diagnostico" name="contar_diagnostico" value="<?php echo $count_enf; ?>" />
			<input type="hidden" id="contar_diagnostico2" name="contar_diagnostico2" value="<?php echo $count_enf; ?>" />
			<script> var  count_enf=<?php echo $count_enf; ?> </script>
		</div>
			
	</div>
	</div>
	</div>
</div>
</br>
<script type="text/javascript">
	
     $("#idestablesolicita").val(<?=$rM["idestablesolicita"];?>);
	 var count_enf=<?php echo $count_enf; ?>;
	 var monto_total=<?php echo $monto; ?>;
	 
</script>



<!--
<div class="row">
	<div class="col-sm-12">
		<div class="col-md-1">
			<label for="atencion" class="control-label text-right">Comprobante:  </label>
		</div>
		<div class="col-md-3">
			<select id="idcomprobante" name="0form_idcomprobante" class="form-control" onchange="cargar_exonerar(this.value,this.serie,this.valor,this);" >
				<option value="0" selected>---</option>
			   <?php
			   $queryT = "select DISTINCT TC.idcomprobante, TC.descripcion from seriedoc_personal SDP 
			   RIGHT JOIN seriedoc SD ON (SDP.idseriedoc = SD.idseriedoc) LEFT JOIN tipo_comprobante TC ON 
			   (SD.idtipocomprobante = TC.idcomprobante) where SDP.idpersonal='".$_SESSION['id_user']."'";
			$itemsT = $objconfig->execute_select($queryT,1);

			foreach($itemsT[1] as $rowT)
			{
				$selected="";
				if($rowT["idcomprobante"]==$row[1]["idcomprobante"]){$selected="selected='selected'";}
				echo "<option value='".$rowT["idcomprobante"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";

			}
			?>
		</select>
		</div>
		<div class="col-md-1">
			<label for="atencion" class="control-label">Serie Doc.:  </label>
		</div>
		<div class="col-md-3">
			<select id="idserie" onchange="cargarn(this)" class="form-control" name="0form_seriedocumento">
				<option value="0" disabled selected>---</option>
			</select>
		</div>
		<div class="col-md-1">
			<label for="atencion" class="control-label">N° Doc.:  </label>
		</div>
		<div class="col-md-3">
			<input type="text" id="nrodocumento" readonly name="0form_nrodocumento" onKeyup="mayuscula(this)" value="" class=" form-control text-right" />
		</div>
	</div>
</div>
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-2">
					<label for="atencion" class="control-label text-right">Descuento S/.  </label>
				</div>
				<div class="col-md-4">
					<input type="text" id="descuento" name="0form_descuento" onKeyPress="solonumeros(event)" onchange="descuentoss();" value="0" class=" form-control text-right" />
				</div>
				<div class="col-md-2">
					<label for="atencion" class="control-label text-right">Total Pagar S/.  </label>
				</div>
				<div class="col-md-4">
					<input type="hidden" id="monto1" name="0form_monto1"  value="<?=$monto;?>" class=" form-control" />
					<input type="text" id="monto" name="0form_monto" readonly value="<?=number_format($monto,2);?>" class=" form-control text-right" />
				</div>
			</div>
		</div>
	</br>		
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-1">
						<label for="atencion" class="control-label">Tipo Pago:  </label>
					</div>

					<div class="col-md-3">
						<select id="idtipopago" name="0form_idtipopago" class="form-control"  >
						<option value="0"></option>
						   <?php
						   $queryT = "SELECT idtipopago, descripcion from tipo_pago where estareg=1 order by descripcion asc";
						$itemsT = $objconfig->execute_select($queryT,1);

						foreach($itemsT[1] as $rowT)
						{
							$selected="";
							if($rowT["idtipopago"]==$row[1]["idtipopago"]){$selected="selected='selected'";}
							echo "<option value='".$rowT["idtipopago"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";

						}
						?>
						</select>
					</div>
					<div class="col-md-1">
						<label for="atencion" class="control-label">Observación:  </label>
					</div>
					<div class="col-md-7">
						<input type="text" name="0form_observacion" id="observacion"  value="" class=" form-control" />
					</div>


				</div>
			</div>
--!>