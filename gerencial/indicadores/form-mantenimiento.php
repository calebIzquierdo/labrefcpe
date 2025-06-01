<?php
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
	$op 	= $_POST["op"];
	$cod	= $_POST["cod"];
	
	if($cod!=0)
	{
		$query = "select * from indicadores where idindicador=".$cod;
		$row = $objconfig->execute_select($query);
	}
?>
<form method="post" enctype="multipart/form-data" id="frmmantenimiento" name="frmmantenimiento">
	<table width="100%" border="0" class="texto-input">
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
		<tr>
			<td width="20%">&nbsp;&nbsp;Codigo</td>
			<td width="5%" align="center">:</td>
			<td width="75%">
				<input type="text" name="1form_idindicador" id="codigo" value="<?=$row[1]["idindicador"]?>" size="20" />
			</td>
		</tr>
		<tr>
			<td width="20%">&nbsp;&nbsp;Dimension</td>
			<td width="5%" align="center">:</td>
			<td width="75%">
				<select id="dimension" name="0form_iddimension" style="width:260px" class="select">
					<option value="0">--Seleccione la Dimension--</option>
					<?php
						$queryT = "select * from dimensiones where estareg=1";
						$itemsT = $objconfig->execute_select($queryT,1);
						
						foreach($itemsT[1] as $rowT)
						{
							$selected="";
							if($rowT["iddimension"]==$row[1]["iddimension"]){$selected="selected='selected'";}
							echo "<option value='".$rowT["iddimension"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>&nbsp;&nbsp;Descripcion</td>
			<td align="center">:</td>
			<td>
				<input type="text" name="0form_descripcion" id="descripcion" value="<?=$row[1]["descripcion"]?>" size="40" />
			</td>
		</tr>
		<tr valign="top">
			<td>&nbsp;&nbsp;Comentario</td>
			<td align="center">:</td>
			<td colspan="4">
				<textarea name="0form_comentario" id="comentario" rows="2" class="select" cols="30"><?=$row[1]["comentario"]?></textarea>
			</td>
		</tr>
		<tr valign="top">
			<td>&nbsp;&nbsp;Formula</td>
			<td align="center">:</td>
			<td colspan="4">
				<textarea name="0form_formula" id="formula" rows="2" class="select" cols="30"><?=$row[1]["formula"]?></textarea>
			</td>
		</tr>
		<tr valign="top">
			<td>&nbsp;&nbsp;Formula &nbsp;&nbsp;Texto</td>
			<td align="center">:</td>
			<td colspan="4">
				<textarea name="0form_formula_texto" id="formula_texto" rows="2" class="select" cols="30"><?=$row[1]["formula_texto"]?></textarea>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>
				<?php
					$checked = "checked='checked'";
					$estareg = 1;
					if(isset($row[1]["estareg"]))
					{
						$estareg = $row[1]["estareg"];
						if($estareg==0)
						{
							$checked = "";
						}
					}
				?>
				<input type="checkbox" name="estado" id="estado" onclick="cambiarestado(this,'estareg');"  <?=$checked?> />
				<input type="hidden" name="0form_estareg" id="estareg" value="<?=$estareg?>"  />
				<input type="hidden" name="op" id="op" value="<?=$op?>"  />
				&nbsp;
				&nbsp;
				Estado de Registro
			</td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
	</table>
</form>