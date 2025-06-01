<?php
     include("../../objetos/class.cabecera.php");
	 include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
	$op 	= $_POST["op"];
	$cod	= $_POST["cod"];
	$disable= "";
	//$readonly="";
	$readonly="readonly=readonly";

	$idusuario = explode("|",$_SESSION['nombre']);
	$iduser = $idusuario[0];

	$esta = "select idred, micro, idmicrored, idejec, ejec, idestablecimiento from user_microred where idusuario=".$iduser;

	$nom_estab = $objconfig->execute_select($esta);

    $qesp = "select idespecialidad from usuarios where idusuario=".$idusuario[0] ;
    $respecie = $objconfig->execute_select($qesp);
    $idespe = $respecie[1]["idespecialidad"];


    $idorg_idejec = $nom_estab[1]["idejec"];
    $idorg_red = $nom_estab[1]["idred"];
    $idorg_micro = $nom_estab[1]["idmicrored"];
    $idorg_estable = $nom_estab[1]["idestablecimiento"];

    $nombrepaciente ="";
    $est_orig ="";
    $idsbare =0;

	if($cod!=0)
	{
		$query = "select * from ingreso where idingreso=".$cod;
		$row = $objconfig->execute_select($query);

        $idorg_micro = $row[1]["idmicrored"];
        $idorg_estable =$row[1]["idestablecimiento"];
        $idsbare =$row[1]["idsubalimento"];

		$disable= "disabled";  
	
        $esta= "select idproveedor, nrodocumento,razonsocial from proveedor where idproveedor=".$row[1]["idproveedor"];
		
        $rowEstable = $objconfig->execute_select($esta);

        //$establecimiento = $rowEstable[1]["codrenaes"]." / ".$rowEstable[1]["esta"]." / ".$rowEstable[1]["micro"]." / ".$rowEstable[1]["red"]." / ".$rowEstable[1]["eje"];
        $establecimiento = $rowEstable[1]["nrodocumento"]." - ".$rowEstable[1]["razonsocial"];
        $est_orig = $rowEstable[1]["idproveedor"];

	}
?>

 <meta charset="UTF-8">
 <meta http-equiv="content-type" content="text/html; utf-8">
<link rel="stylesheet" media="screen" href="<?=$path?>bootstrap/fecha/css/bootstrap-datetimepicker.min.css" >
<script type="text/javascript" src="<?=$path?>bootstrap/fecha/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?=$path?>bootstrap/fecha/js/locales/bootstrap-datetimepicker.es.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?=$path?>js/tooltip.js" charset="UTF-8"></script>

<script type="text/javascript">

 var count=0;

    $('.form_datetime').datetimepicker({
       // language:  'fr',
        language:  'es',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });
	$('.form_date').datetimepicker({
        language:  'es',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 1
    });
	$('.form_time').datetimepicker({
        language:  'es',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 1,
		minView: 0,
		maxView: 1,
		forceParse: 0
    });

 
 function Estalecimiento(id,est)
 {
	$.ajax({
	 type: "POST",
	 url: carpeta+"establecimiento.php",
	 data: "idpa="+id+"&esta="+est,
	 success: function(data) {
		 $("#div-estable").html(data)
	 }
	});
 }
 
 function ValidaLongitud(campo, longitudMaxima) {
            try {
                if (campo.value.length > (longitudMaxima - 1))
                    return false;
                else
                    return true;             
            } catch (e) {
                return false;
            }
        }

</script>


<style>
	/* 
	table, th, td {
        border: 0px solid black;
        font-family: "Times New Roman", serif;
        font-size: 11px;
    }
	*/
	@media (min-width: 768px) {
        .container {
            width: 750px;
        }
    }
    @media (min-width: 992px) {
        .modal-lg {
            width: 1200px; /* control width here */
            height: auto; /* control height here */
            margin-left: -300px;
            padding-top: 10px;

        }
    }
</style>

<form method="post" enctype="multipart/form-data"  id="user_form"  name="user_form">
		<div class="modal-content modal-lg">
			<div class="modal-header">
				<button type="button" onclick="regresar_index(carpeta);" class="close" data-dismiss="modal">&times; </button>
			<!--	<h3 class="modal-title text-primary" align="center"> <?php echo $nom_estab[1]["ejec"]; ?> </h3> -->
				<h3 class="modal-title text-success" align="center"> INGRESO DE MATERIALES</h3>
				</br>
                <div class="col-md-12">
                    <div class="col-md-2">
                        <label for="atencion" class="control-label">MICRORED:  </label>
                    </div>
                    <div class="col-md-4">
					
					<input type="hidden" name="0form_idejecutora" id="idejecutora" value="<?php echo $nom_estab[1]["idejec"]; ?>"  />
					<input type="hidden" name="0form_idred" id="idred" value="<?php echo $nom_estab[1]["idred"]; ?>"  />
                     <select id="idmicrored" name="0form_idmicrored" class="combobox form-control" onchange="Estalecimiento(this.value, <?php echo $idorg_estable; ?>)"  >
                            <option value=""></option>
                            <?php
                            $queryT = "select idmicrored,descripcion 
										from microred  where idred=".$idorg_red."
										order by descripcion asc";
                            $itemsT = $objconfig->execute_select($queryT,1);

                            foreach($itemsT[1] as $rowT)
                            {
                                $selected="";
                                if($rowT["idmicrored"]==$idorg_micro){$selected="selected='selected'";}
                                echo "<option value='".$rowT["idmicrored"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
                            }
                            ?>
                        </select>
                        </div>
                        <div class="col-md-2">
                        <label for="atencion" class="control-label">ESTABLECIMIENTO:  </label>
                    </div>
                    <div class="col-md-4">
                        <div id="div-estable" name="div-estable"> </div>
						
                    </div>
                </div>
				<input type="hidden" name="op" id="op" value="<?php echo $op; ?>"  />
				<?php 
				if ($op==3){
				
				}
				?>
				<input type="hidden" name="0form_idusuario" id="idusuario" value="<?=$idusuario[0]?>"  />
				<input type="hidden" name="0form_idusuario" id="idusuario" value="<?php echo $iduser; ?>"  />
				<input type="hidden" name="0form_nombre_usuario" id="nombre_usuario" value="<?=$idusuario[1]?>"  />
			</div>
			<div class="modal-body">
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-2">
						<input type="text" name="1form_idingreso" id="codigo" value="<?=$row[1]["idingreso"]?>" <?php echo $readonly;?>   class="form-control"/>
                    </div>
                   	<div class="col-md-2">
                        <label>Fecha Recepción</label>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2"  data-link-format="yyyy-mm-dd">
                            <input class="form-control" type="text" name="0form_fecharecepcion" id="fecharecepcion" value="<?php echo ($row[1]["fecharecepcion"])?$objconfig->FechaDMY2($row[1]["fecharecepcion"]):date("d/m/Y");?>"  readonly>
                         <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                       
                        </div>
                    </div>
					
					<div class="col-md-1">
						<label for="atencion" class="control-label">Tipo Ingreso</label>
                    </div>
					 <div class="col-md-2">
						<select id="idtipoingreso" name="0form_idtipoingreso" class="form-control"  >
						<option value="0"></option>
						   <?php
						   $queryT = "SELECT idtipoingreso, descripcion from tipo_ingreso where estareg=1 order by descripcion asc";
						$itemsT = $objconfig->execute_select($queryT,1);

						foreach($itemsT[1] as $rowT)
						{
							$selected="";
							if($rowT["idtipoingreso"]==$row[1]["idtipoingreso"]){$selected="selected='selected'";}
							echo "<option value='".$rowT["idtipoingreso"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";

						}
						?>
					</select>
                    </div>
					<div class="col-md-1">
					<label for="atencion" class="control-label">N° Orden</label>
					</div>
					<div class="col-md-2">
						<input type="text" name="0form_nrorden" id="nrorden" onkeyup="mayuscula(this);" class="form-control" value="<?=$row[1]["nrorden"]?>" placeholder="N° Orden" data-toggle="tooltip" data-placement="top" title="N° Orden" />
					</div>
                   
	       	</div>
	       	</div>
			</br>
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-2">
						<label for="atencion" class="control-label">Proveedor:  </label>
					</div>

					<div class="col-md-10">
						<input type="hidden" id="idproveedor" name="0form_idproveedor" value="<?=$est_orig;?>"  />
						<input for="atencion" type="text" name="nombre_proveedor" id="nombre_proveedor"  readonly="readonly" onclick="buscar_proveedor();" value="<?php echo $establecimiento;?>" placeholder="Click para Buscar Proveedor" class=" form-control" />

					</div>
						
				</div>
			</div>
			</br>
				<div class="row">
				<div class="col-md-12">
				<div class="col-md-2">
                        <label>Fecha Comprob.</label>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2"  data-link-format="yyyy-mm-dd">
                            <input class="form-control" type="text" name="0form_fechacompra" id="fechacompra" value="<?php echo ($row[1]["fechacompra"])?$objconfig->FechaDMY2($row[1]["fechacompra"]):date("d/m/Y");?>"  readonly>
                         <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                       
                        </div>
                    </div>
				<div class="col-md-2">
						<label for="atencion" class="control-label">Tipo Comprobante</label>
                    </div>
					 <div class="col-md-2">
						<select id="idcomprobante" name="0form_idcomprobante" class="form-control"  >
						<option value="0"></option>
						   <?php
						   $queryT = "SELECT idcomprobante, descripcion from tipo_comprobante where estareg=1 order by descripcion asc";
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
				<div class="col-md-2">
					<label for="atencion" class="control-label">Numero Comprobante</label>
				</div>
				<div class="col-md-2">
					<input type="text" name="0form_nrocomprobante" id="nrocomprobante" class="form-control" onkeyup="mayuscula(this);" value="<?=$row[1]["nrocomprobante"]?>"  placeholder="N° Comprobante" data-toggle="tooltip" data-placement="top" title="N° Comprobante" />
	       		</div>
			
	       		</div>
			</div>
			</br>
			<div class="panel panel-primary ">
			<div class="panel-heading">Materiales</div>
				</br>
			<div class="row">
			<div class="col-md-12">
			<div class="col-md-2">
					<label for="atencion" class="control-label">Tipo Material:  </label>
				</div>
			<div class="col-md-6">
				<input type="hidden" id="unid" name="unid" value=""  />
				<input type="hidden" id="tipmate" name="tipmate" value=""  />
				<input type="hidden" id="material" name="material" value=""  />
				<input for="atencion" type="text" name="nombre_material" id="nombre_material"  readonly="readonly" onclick="buscar_material();" value="" placeholder="Click para Buscar Materiales" class=" form-control" />
			</div>
			<!--		
			<div class="col-md-3">
				<select id="material" name="material" class="form-control"  >
					<option value="0"></option>
					<?php
					$queryT2 = "select idmaterial, descripcion from materiales where estareg=1 order by descripcion ASC ";
					$itemsT2 = $objconfig->execute_select($queryT2,1);

					foreach($itemsT2[1] as $rowT2)
					{
						$selected="";
						echo "<option value='".$rowT2["idmaterial"]."' ".$selected." >".strtoupper($rowT2["descripcion"])."</option>";
					}
					?>
				</select>
			</div>
			-->
			<div class="col-md-1">
				<label for="atencion" class="control-label">Marca:  </label>
			</div>
			<div class="col-md-3">
				<select id="marca" name="marca"  class="form-control"  >
					<option value="0"></option>
					<?php
					$queryT2 = "select idmarca, descripcion from marcas where estareg=1 order by descripcion ASC ";
					$itemsT2 = $objconfig->execute_select($queryT2,1);

					foreach($itemsT2[1] as $rowT2)
					{
						$selected="";
						echo "<option value='".$rowT2["idmarca"]."' ".$selected." >".strtoupper($rowT2["descripcion"])."</option>";
					}
					?>
				</select>
			</div>
			
			
			</div>
			</div>
			</br>
			
			
			<div class="row">
				<div class="col-md-12">
				<div class="col-md-2">
				<label for="atencion" class="control-label">Cantidad:  </label>
			</div>
			<div class="col-md-2">
				<input type="text" name="cantidad" id="cantidad" onKeyPress="solonumeros(event)"  class="form-control" value=""   placeholder="Cantidad" data-toggle="tooltip" data-placement="top" title="Cantidad" />
			</div>
				
				<div class="col-md-2">
					<label for="atencion" class="control-label">Precio Compra</label>
				</div>
				<div class="col-md-2">
				<input type="text"  name="pcompra" onKeyPress="solonumeros(event)" id="pcompra" class="form-control" value=""  placeholder="P. Compra" data-toggle="tooltip" data-placement="top" title="Precio Compra" />
	       	</div>
			<div class="col-md-2">
					<label for="atencion" class="control-label">Precio Venta</label>
				</div>
			<div class="col-md-2">
				<input type="text"  name="pventa" id="pventa" onKeyPress="solonumeros(event)" class="form-control" value=""  placeholder="P. Venta" data-toggle="tooltip" data-placement="top" title="Precio Venta" />
	       	</div>
				
			
				</div>
			</div>
			</br>
			<div class="row">
				<div class="col-md-12">
				<div class="col-md-2">
                        <label>Modelos</label>
                    </div>
                    <div class="col-md-3">
                       <input type="text" name="modelo" id="modelo" onkeyup="mayuscula(this);" class="form-control" value=""  placeholder="Modelo del Material" data-toggle="tooltip" data-placement="top" title="Modelo del Material" />
                    </div>
					
					<div class="col-md-1">
						<label for="atencion" class="control-label">Cod. Patrimonial:</label>
					</div>
					<div class="col-md-3">
						<input type="text" name="codpatri" id="codpatri" onkeyup="mayuscula(this);" class="form-control" value=""  placeholder="Codigo Patrimonial" data-toggle="tooltip" data-placement="top" title="Codigo Patrimonial" />
					</div>
				<div class="col-md-1">
					<label for="atencion" class="control-label">Codigo Pat. Lab: </label>
				</div>
				<div class="col-md-2">
					<input type="text" name="codpatrilab" id="codpatrilab" onkeyup="mayuscula(this);" class="form-control" value=""  placeholder="CodPat. Lab Ref." data-toggle="tooltip" data-placement="top" title="Codigo Patrimonial Lab Ref." />
				</div>
				</div>
			</div>
			</br>
			<div class="row">
				<div class="col-md-12">
				<div class="col-md-2">
                        <label>Fecha Vencimiento</label>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2"  data-link-format="yyyy-mm-dd">
                            <input class="form-control" type="text" name="vence" id="vence" value="<?php echo date("d/m/Y");?>"  readonly>
                         <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                       
                        </div>
                    </div>
					
					<div class="col-md-1">
						<label for="atencion" class="control-label">Estado:  </label>
					</div>
					  <div class="col-md-2">
					  <select id="estado" name="estado"  class="form-control"  >
					<option value="0"></option>
					<?php
					$queryT2 = "select idtipobien, descripcion from tipo_bien where estareg=1 order by descripcion ASC ";
					$itemsT2 = $objconfig->execute_select($queryT2,1);

					foreach($itemsT2[1] as $rowT2)
					{
						$selected="";
						echo "<option value='".$rowT2["idtipobien"]."' ".$selected." >".strtoupper($rowT2["descripcion"])."</option>";
					}
					?>
				</select>
				</div>
				
			<div class="col-md-1">
					<label for="atencion" class="control-label">N° Series:  </label>
				</div>
				<div class="col-md-3">
					<input type="text" name="serie" id="serie" class="form-control" onkeyup="mayuscula(this);" value=""  placeholder="Para Ingresar mas de un Numero de Serie, use como separador el caracter ','" data-toggle="tooltip" data-placement="top" title="Para Ingresar mas de un Numero de Serie, use como separador el caracter ','" />
				</div>
				<div class="col-md-1">
					<input type="button" onclick="agregar_antigrama();" name="action" id="action" class="btn btn-info"  value="Agregar" />
				</div>
				</div>
			</div>
				</br>	
			<div style="height:280px;  overflow-x:hidden;" >
				<div class="row">
				<div class="col-sm-12">
				<div class="panel panel-info ">
					<div class="panel-heading">DETALLES DEL DOCUMENTO </div>
					<div class="panel-body">
						<table class="table table-striped table-bordered table-hover table-responsive" id="tbdiagnostico" name="tbdiagnostico" >
							<thead>

							<tr>
								<td >#</td>
								<td >Cantidad  </td>
								<td >Descripción</td>
								<td >Marca  </td>
								<td >Serie  </td>
								<td >Condición  </td>
								<td >Vencimiento  </td>
								<td >Modelos  </td>
								<td >P. Compra  </td>
								<td >P. Venta </td>
								<td >Cod. Patr.  </td>
								<td >Cod. Patr. LabRef  </td>
								<td ></td>
							</tr>

							</thead>
							<tbody>
							<?php
							$count_enf=0;
							$sqlF = "select i.idingreso , i.cantidad, i.idmaterial , i.idmarca , i.serie , i.idtipobien, i.fvencimiento,
							i.modelo, i.pcompra , i.pventa , i.codpatri,i.codpatrilab , i.idunidad , i.idtipomaterial, b.descripcion as tipbien,
							u.descripcion as unidad, m.descripcion as tpmate, mc.descripcion as mrcas
							
									from ingreso_det as i
									inner join tipo_bien as b on(b.idtipobien=i.idtipobien)
									inner join unidad_medida as u on(u.idunidad=i.idunidad)
									inner join materiales as m on(m.idmaterial=i.idmaterial)
									inner join marcas as mc on(mc.idmarca=i.idmarca)
									where i.idingreso=".$cod." ";
							$rowF = $objconfig->execute_select($sqlF,1);
							foreach($rowF[1] as $rF)
							{
								$count_enf++;

								?>
								<tr id='itemdiagnostico<?php echo $count_enf; ?>' name='itemdiagnostico<?php echo $count_enf; ?>' >
									<td >
										<input type='hidden' name='idtipomaterial<?php echo $count_enf; ?>' id='idtipomaterial<?php echo $count_enf; ?>' value='<?php echo $rF["idtipomaterial"]; ?>' />
										<input type='hidden' name='idunidad<?php echo $count_enf; ?>' id='idunidad<?php echo $count_enf; ?>' value='<?php echo $rF["idunidad"]; ?>' />
										<input type='hidden' name='idingreso<?php echo $count_enf; ?>' id='idingreso<?php echo $count_enf; ?>' value='<?php echo $rF["idingreso"]; ?>' />
										<?php echo $count_enf ; ?>
									</td>
									<td>
										<input type='hidden' name='cantidad<?php echo $count_enf; ?>' id='cantidad<?php echo $count_enf; ?>' value='<?php echo $rF["cantidad"]; ?>' />
										<?php echo strtoupper($rF["cantidad"] ); ?>
									</td>
									<td>
										<input type='hidden' name='idmaterial<?php echo $count_enf; ?>' id='idmaterial<?php echo $count_enf; ?>' value='<?php echo $rF["idmaterial"]; ?>' />
										<?php echo strtoupper($rF["unidad"]." - ".$rF["tpmate"] ); ?>
									</td>
									<td>
									<input type='hidden' name='idmarca<?php echo $count_enf; ?>' id='idmarca<?php echo $count_enf; ?>' value='<?php echo $rF["idmarca"]; ?>' />
										<?php echo strtoupper($rF["mrcas"] ); ?>
									</td>
									<td>
									<input type='hidden' name='serie<?php echo $count_enf; ?>' id='serie<?php echo $count_enf; ?>' value='<?php echo $rF["serie"]; ?>' />
										<?php echo strtoupper($rF["serie"] ); ?>
									</td>
									<td>
									<input type='hidden' name='idtipobien<?php echo $count_enf; ?>' id='idtipobien<?php echo $count_enf; ?>' value='<?php echo $rF["idtipobien"]; ?>' />
										<?php echo strtoupper($rF["tipbien"] ); ?>
									</td>
									<td>
									<input type='hidden' name='fvencimiento<?php echo $count_enf; ?>' id='fvencimiento<?php echo $count_enf; ?>' value='<?php echo $rF["fvencimiento"]; ?>' />
										<?php echo strtoupper($rF["fvencimiento"] ); ?>
									</td>
									<td>
									<input type='hidden' name='modelo<?php echo $count_enf; ?>' id='modelo<?php echo $count_enf; ?>' value='<?php echo $rF["modelo"]; ?>' />
										<?php echo strtoupper($rF["modelo"] ); ?>
									</td>
									<td>
									<input type='hidden' name='pcompra<?php echo $count_enf; ?>' id='pcompra<?php echo $count_enf; ?>' value='<?php echo $rF["pcompra"]; ?>' />
										<?php echo number_format($rF["pcompra"],2 ); ?>
									</td>
									<td>
									<input type='hidden' name='pventa<?php echo $count_enf; ?>' id='pventa<?php echo $count_enf; ?>' value='<?php echo $rF["pventa"]; ?>' />
										<?php echo number_format($rF["pventa"],2 ); ?>
									</td>
									<td>
									<input type='hidden' name='codpatri<?php echo $count_enf; ?>' id='codpatri<?php echo $count_enf; ?>' value='<?php echo $rF["codpatri"]; ?>' />
										<?php echo strtoupper($rF["codpatri"] ); ?>
									</td>
									<td>
									<input type='hidden' name='codpatrilab<?php echo $count_enf; ?>' id='codpatrilab<?php echo $count_enf; ?>' value='<?php echo $rF["codpatrilab"]; ?>' />
										<?php echo strtoupper($rF["codpatrilab"] ); ?>
									</td>
									
									
									
									<td >
									<!--
										<img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_diagnostico(<?php echo $count_enf; ?>)' title='Borrar REgistro' />
									-->
									</td>
								</tr>
							<?php }?>
							</tbody>
						</table>
						<input type="hidden" id="contar_diagnostico" name="contar_diagnostico" value="<?php echo $count_enf; ?>" />
						<input type="hidden" id="contar_diagnostico2" name="contar_diagnostico2" value="<?php echo $count_enf; ?>" />
						<script> var  count_enf=<?php echo $count_enf; ?> </script>
						</div>
						</div>
						</div>
					</div>
				</div>
					</div>
				</div>
				
				
				<div class="upload-msg col-md-12"></div><!--Para mostrar la respuesta del archivo llamado via ajax -->
					<div class="modal-footer">
						<!--		<input type="hidden" name="user_id" id="user_id" />
								<input type="hidden" name="operation" id="operation" /> -->
						<input type="button" onclick="validar_form();" name="action" id="action" class="btn btn-success"  value="Guardar" />
						<button type="button" onclick="regresar_index(carpeta);" class="btn btn-default" data-dismiss="modal" data-backdrop="false" > Cerrar </button>
					</div>
					
				 <!-- Termino del Primer tab    </div> </div>       </fieldset>  -->
				</div>
				</div>

		</div>
	</form>

		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
	</table>
</form>

<script type="text/javascript">
	
    Estalecimiento(<?php echo $idorg_micro; ?>, <?php echo $idorg_estable; ?>)

    //<![CDATA[
    $(document).ready(function(){
        $('.combobox').combobox()
    });
    //]]>

    $('#myTab a').on('click', function (e) {
        e.preventDefault()
        $(this).tab('show')
    })
	/*
	// Para usar un tooltip especifico hacer de la siguiente manera
	// <input type="text" rel="txtTooltip" title="**Escribir el mensaje a mostrar**" data-toggle="tooltip" data-placement="bottom">
	
	$(document).ready(function() {
	$('input[rel="txtTooltip"]').tooltip();
	});
	*/
	// Para usar un tooltip sin especificar tag en especial
	$(function () {
	$('[data-toggle="tooltip"]').tooltip()
	})
	
</script>