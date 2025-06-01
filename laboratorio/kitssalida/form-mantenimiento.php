<?php
     include("../../objetos/class.cabecera.php");
	 include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
	$op 	= $_POST["op"];
	$cod	= $_POST["cod"];
//	echo json_encode($_POST)."\n";
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
	
	$idare = 0;
	$idaretrab = 0;

    $nombrepaciente ="";
    $est_orig ="";
    $idsbare =0;

	if($cod!=0)
	{
	
	//$query = "SELECT s.*, r.correlativo as correl_req FROM salida AS s JOIN requerimiento AS r ON s.idrequerimiento = r.idrequerimiento where idkit=".$cod;
		$query = "SELECT s.* FROM vista_kitsalida AS s where idkit=".$cod;
	//	echo $query;
		$row = $objconfig->execute_select($query);
		// echo json_encode($row)."\n";
		//exit(); 
      //  $idorg_micro = $row[1]["idmicrored"];
      //  $idorg_estable =$row[1]["idestablecimiento"];
        $idsbare =$row[1]["idsubalimento"];
		if ($row[1]["idrequerimiento"]==0){
			$row[1]["correl_req"]=0;
		} else{
			$quCor = "SELECT s.*, r.correlativo as correl_req 
					FROM salida AS s JOIN requerimiento AS r ON s.idrequerimiento = r.idrequerimiento 
					where idkit=".$cod;
			$rowC = $objconfig->execute_select($quCor);
			$row[1]["correl_req"]=$rowC[1]["correl_req"];
			
		}
		
		
		$disable= "disabled";  
		$idare = $row[1]["idarea"];
		$idaretrab = $row[1]["idareatrabajo"];
	
       

	}
?>

 <meta charset="UTF-8">
 <meta http-equiv="content-type" content="text/html; utf-8">
<link rel="stylesheet" media="screen" href="<?=$path?>bootstrap/fecha/css/bootstrap-datetimepicker.min.css" >
<script type="text/javascript" src="<?=$path?>bootstrap/fecha/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?=$path?>bootstrap/fecha/js/locales/bootstrap-datetimepicker.es.js" charset="UTF-8"></script>


<script type="text/javascript">

 var count=0;

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

 
	function Redtestt(idUnidadEjec,idRed){
	//$("#idmicrored").html("");
	
	//$("#idestablecimiento").html($.parseHTML("<option value="">---</option>"));
	$.ajax({
	 type: "POST",
	 url: carpeta+"red.php",
	 data: "idue="+idUnidadEjec+"&idred="+idRed,
	 success: function(data) {
		 $("#idred").html(data)
	 }
	});
	/* $("#idred").val("");
	$("#idmicrored").val("");
	MicrooRed("",idUnidadEjec,0);
	$("#idestablecimiento").val("");
	Estalecimiento("",0); */
 }
 function MicrooRed(idRed, idUnidadEjec, idMicroRed){
	
	/* $("#idestablecimiento").val("");
	Estalecimiento("",0); */
	
	$.ajax({
	 type: "POST",
	 url: carpeta+"microred.php",
	 data: "idRed="+idRed+"&idMicroRed="+idMicroRed+"&idUnidadEjec="+idUnidadEjec,
	 success: function(data) {
		 //console.log(data);
		 $("#idmicrored").html(data)
	 }
	});
 }

 function Estalecimiento(idMicroRed,idEst)
 {
	$.ajax({
	 type: "POST",
	 url: carpeta+"establecimiento.php",
	 data: "idMicroRed="+idMicroRed+"&idEst="+idEst,
	 success: function(data) {
		 $("#idestablecimiento").html(data)
	 }
	});
 }

 function Redtestt2(idUnidadEjec){
	
	$.ajax({
	 type: "POST",
	 url: carpeta+"red.php",
	 data: "idue="+idUnidadEjec+"&idred="+0,
	 success: function(data) {
		 $("#idred").html(data)
	 }
	});
	$("#idred").val("");
	$("#idmicrored").val("");
	MicrooRed("",idUnidadEjec,0);
	$("#idestablecimiento").val("");
	Estalecimiento("",0);
 }
 function MicrooRed2(idRed, idUnidadEjec){
	$("#idestablecimiento").val("");
	Estalecimiento("",0);
	$.ajax({
	 type: "POST",
	 url: carpeta+"microred.php",
	 data: "idRed="+idRed+"&idMicroRed="+0+"&idUnidadEjec="+idUnidadEjec,
	 success: function(data) {
		 //console.log(data);
		 $("#idmicrored").html(data)
	 }
	});
 }

 function Estalecimiento2(idMicroRed)
 {
	$.ajax({
	 type: "POST",
	 url: carpeta+"establecimiento.php",
	 data: "idMicroRed="+idMicroRed+"&idEst="+0,
	 success: function(data) {
		 $("#idestablecimiento").html(data)
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


Redtestt(<?php echo $idorg_idejec; ?>,<?php echo $idorg_red; ?>);
MicrooRed(<?php echo $idorg_red;?>,<?php echo $idorg_idejec; ?>,<?php echo $idorg_micro;?>);
//Estalecimiento(<?php echo $idorg_micro; ?>, <?php echo $idorg_estable; ?>);
Estalecimiento(<?php echo $idorg_micro; ?>, <?php echo $idorg_estable; ?>);
</script>


<style>
	
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
			<!-- <h3 class="modal-title text-primary" align="center"> <?php echo $nom_estab[1]["ejec"]; ?> </h3> -->
			<h3 class="modal-title text-success" align="center"> REGISTRO DE KITS DISTRIBUIDOS - N°
				<?php
					if($cod==0){
						$correlativo=1;
						$query ="select max(correlativo) as correlativo from kitsalida LIMIT 1;";
						$correlativos = $objconfig->execute_select($query,1);
						//var_dump($correlativos[1][0]["correlativo"]);
						//exit;
						if(count($correlativos[1])>0){
							//echo $correlativos[1]->correlativo."-";
							$correlativo= ((int)$correlativos[1][0]["correlativo"])+1;
						}
						echo substr(str_repeat(0, 7).$correlativo, - 7);
					}else{
						echo substr(str_repeat(0, 7).$row["1"]["correlativo"], - 7);
					}
				?>
			</h3>
			</br>
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-2">
						<label for="idunidadejec" class="control-label">UNIDAD EJECUTORA:  </label>
					</div>
					<div class="col-md-4">
						<!-- <input type="hidden" name="0form_idejecutora" id="idejecutora" value="<?php //echo $nom_estab[1]["idejec"]; ?>"  />
						<input type="hidden" name="0form_idred" id="idred" value="<?php //echo $nom_estab[1]["idred"]; ?>"  /> -->
						<select id="idunidadejec" name="0form_idejecutora" class="form-control" onchange="Redtestt2(this.value, <?php echo $idorg_red ?>)"  >
							<option value=""></option>
							<?php
								$queryT = "select idejecutora,descripcion 
								from ejecutora where idejecutora= ".$nom_estab[1]["idejec"]." order by descripcion asc";
								$itemsT = $objconfig->execute_select($queryT,1);

								foreach($itemsT[1] as $rowT)
								{
									$selected="";
									if($rowT["idejecutora"]==$nom_estab[1]["idejec"]){$selected="selected='selected'";}
									echo "<option value='".$rowT["idejecutora"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
								}
							?>		
						</select>
					</div>
					<div class="col-md-2">
						<label for="idmicrored" class="control-label">RED:  </label>
					</div>
					<div class="col-md-4">
						<!-- <input type="hidden" name="0form_idejecutora" id="idejecutora" value="<?php //echo $nom_estab[1]["idejec"]; ?>"  />
							<input type="hidden" name="0form_idred" id="idred" value="<?php //echo $nom_estab[1]["idred"]; ?>"  /> -->
							<select id="idred" name="0form_idred" class="form-control"  onchange="MicrooRed2(this.value,<?php echo $idorg_idejec;?>, <?php echo $idorg_micro; ?>)">
							</select>
								<!-- <div id="div-red" name="div-red"> </div> -->
								
							<!-- <select id="idmicrored" name="0form_idmicrored" class="form-control" onchange="MicroRed(this.value, <?php echo $idorg_estable; ?>)"  >
							
							<option value=""></option>
								
						</select> -->
					</div>
				</div>
			</div>
			<div class="col-md-12" style="margin-top:2rem;">
				<div class="col-md-2">
					<label for="idmicrored" class="control-label">MICRORED:  </label>
				</div>
				<div class="col-md-4">
					<select id="idmicrored" name="0form_idmicrored" class="form-control"  onchange="Estalecimiento2(this.value, <?php echo $idorg_micro; ?>)">
					</select>
					<!-- <div id="div-microred" name="div-microred"> </div> -->
					<!-- <input type="hidden" name="0form_idejecutora" id="idejecutora" value="<?php //echo $nom_estab[1]["idejec"]; ?>"  />
					<input type="hidden" name="0form_idred" id="idred" value="<?php //echo $nom_estab[1]["idred"]; ?>"  /> -->
					<!-- <select id="idmicrored" name="0form_idmicrored" class="form-control" onchange="Estalecimiento(this.value, <?php echo $idorg_micro; ?>)"  >
							<option value=""></option> -->
							<?php
							/* $queryT = "select idmicrored,descripcion 
										from microred  where idred='".$idorg_red."'
										order by descripcion asc";
							$itemsT = $objconfig->execute_select($queryT,1);

							foreach($itemsT[1] as $rowT)
							{
								$selected="";
								if($rowT["idmicrored"]==$idorg_micro){$selected="selected='selected'";}
								echo "<option value='".$rowT["idmicrored"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
							} */
							?>
					<!-- </select> -->
				</div>
				<div class="col-md-2">
					<label for="atencion" class="control-label">ESTABLECIMIENTO:  </label>
				</div>
				<div class="col-md-4">
					<select id="idestablecimiento" name="0form_idestablecimiento" class="form-control"  >
					</select>
					<!-- <div id="div-estable" name="div-estable"> </div> -->
					
				</div>
				<input type="hidden" name="op" id="op" value="<?php echo $op; ?>"  />
				<input type="hidden" name="0form_idusuario" id="idusuario" value="<?php echo $iduser; ?>"  />
				<input type="hidden" name="0form_nombre_usuario" id="nombre_usuario" value="<?=$idusuario[1]?>"  />
			</div>
		</div>
				
		<div class="modal-body">
			<div class="row">
				<div class="col-md-12">
						
					<input type="text" style="display:none" name="1form_idkit" id="codigo" value="<?=$row[1]["idkit"]?>" <?php echo $readonly;?>   class="form-control"/>
					<input type="text" style="display:none" name="0form_correlativo" id="correlativo" value="<?=substr(str_repeat(0, 7).$correlativo, - 7);?>" <?php echo $readonly;?>   class="form-control"/>
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
						<label for="atencion" class="control-label">Destino:  </label>
					</div>

					<div class="col-md-7">
						<input type="hidden" id="codrenae" name="codrenae" value=""  />
						<input type="hidden" id="idejecutorasolicita" name="0form_idejecutorasolicita" value="<?=$ejejcut_orig;?>"  />
						<input type="hidden" id="idredsolicita" name="0form_idredsolicita" value="<?=$red_orig;?>"  />
						<input type="hidden" id="idmicroredsolicita" name="0form_idmicroredsolicita" value="<?=$micro_orig;?>"  />
						<input type="hidden" id="idestablesolicita" name="0form_idestablesolicita" value="<?=$est_orig;?>"  />
						<input for="atencion" type="text" name="nombre_establecimiento" id="nombre_establecimiento"  readonly="readonly" onclick="buscar_establecimiento();" value="<?php echo $establecimiento;?>" placeholder="Click para seleccionar Establecimiento" class=" form-control" />

					</div>
					
				</div>
	       	</div>
			</br>

			<div class="row">
				<div class="col-md-12">
					<div class="col-md-2">
						<label for="atencion" class="control-label">Observación:</label>
					</div>
					<div class="col-md-10">
						<textarea name="0form_observaciones" id="observaciones" class="form-control" onKeyPress="mayuscula(this)" rows="2" cols="70"><?php echo $row[1]["observaciones"]; ?></textarea>
					</div>
				</div>
			</div>
			</br>

			</br>
			<div class="panel panel-primary ">
				<div class="panel-heading">Materiales</div>
				</br>
				<div class="row">
					<div class="col-md-12">
						<div class="col-md-1">
							<label for="atencion" class="control-label">Tipo Material:  </label>
						</div>
						<div class="col-md-5">
							<input type="hidden" id="material" name="material" value=""  />
							<input type="hidden" id="material_texto" name="material_texto" value=""  />
							<input type="hidden" id="unid" name="unid" value=""  />
							<input type="hidden" id="unid_text" name="unid_text" value=""  />
							<input type="hidden" id="tipmate" name="tipmate" value=""  />
							<input type="hidden" id="tipmate_texto" name="tipmate_texto" value=""  />
							<input for="atencion" type="text" name="nombre_material" id="nombre_material"  readonly="readonly" onclick="buscar_material();" value="" placeholder="Click para Buscar Materiales" class=" form-control" />
						</div>
					
						<div class="col-md-1">
							<label for="atencion" class="control-label">Marca:  </label>
						</div>
						<div class="col-md-2">
							<select id="marca" name="marca" class="form-control combobox"   >
							<option value="0"></option> 
							<?php
								$queryT = "select idmarca,descripcion 
										from marcas  where estareg=1 
										order by descripcion asc";
								$itemsT = $objconfig->execute_select($queryT,1);

								foreach($itemsT[1] as $rowT)
								{
									$selected="";
									//if($rowT["idmicrored"]==$idorg_micro){$selected="selected='selected'";}
									echo "<option value='".$rowT["idmarca"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
								} 
							?>
							</select> 
						</div>
						<div class="col-md-1">
							<label for="atencion" class="control-label">Cantidad:  </label>
						</div>
						<div class="col-md-2">
							<input type="text" name="cantidad" id="cantidad" onKeyPress="solonumeros(event)"  class="form-control" value=""   placeholder="Cantidad" data-toggle="tooltip" data-placement="top" title="Cantidad" />
						</div>
					</div>
				</div>
				</br>
				<div class="row">
					<div class="col-md-12">
						<div class="col-md-1">
							<label for="atencion" class="control-label">Series:  </label>
						</div>
						<div class="col-md-4">
							<input type="text" id="serie" name="serie" value="" onKeyPress="mayuscula(this)" placeholder="Separar con COMA, si es más de una serie" class=" form-control" />
						</div>
						<div class="col-md-1">
							<label for="atencion" class="control-label">Lote:  </label>
						</div>
						<div class="col-md-2">
							<input type="text" id="lotes" name="lotes" value="" onKeyPress="mayuscula(this)" placeholder="Ingresar 1 lote por registro" class=" form-control" />
						</div>
						<div class="col-md-1">
							<label for="atencion" class="control-label">Fecha Vencimiento:  </label>
						</div>
						<div class="col-md-2">
							
							<div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2"  data-link-format="yyyy-mm-dd">
								<input class="form-control" type="text" name="vence" id="vence" value="<?php echo date("d/m/Y");?>"  readonly>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
						
							</div>
						</div>
						<!--
						<div class="col-md-1">
							<label for="atencion" class="control-label">Stock Actual:  </label>
						</div>
						<div class="col-md-1">
							<input type="text" id="stock" name="stock" value="" class=" form-control" />
						</div>
						-->
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
													<td >Unidad  </td>
													<td >Descripción</td>
													<td >Marca  </td>
													<td >Lote  </td>
													<td >Serie  </td>
													<td >Vencimiento  </td>
													<td >Quitar</td>
													
												</tr>
											</thead>
											<tbody>
												<?php
													$count_enf=0;
													$sqlF = "select idkit , cantidad, idmaterial , idmarca , serie ,  fvencimiento, idunidad ,
															idtipomaterial, umedida,   tipmate,    materia,   marc
															from vista_kitsalida_det 
															where idkit=".$cod." ";
													$rowF = $objconfig->execute_select($sqlF,1);
													foreach($rowF[1] as $rF)
													{
														$count_enf++;

												?>
													<tr id='itemdiagnostico<?php echo $count_enf; ?>' name='itemdiagnostico<?php echo $count_enf; ?>' >
														<td >
															<p style="display:none" id="mate<?php echo $count_enf; ?>"><?php echo $rF["idmaterial"]; ?></p>
															<p style="display:none" id="mate_text<?php echo $count_enf; ?>"><?php echo strtoupper($rF["materia"] ); ?></p>
															<p style="display:none" id="unidad<?php echo $count_enf; ?>"><?php echo $rF["idunidad"]; ?></p>
															<p style="display:none" id="unidad_text<?php echo $count_enf; ?>"><?php echo strtoupper($rF["unidad"] ); ?></p>
															<p style="display:none" id="tipmate<?php echo $count_enf; ?>"><?php echo $rF["idtipomaterial"]; ?></p>
															<p style="display:none" id="marca<?php echo $count_enf; ?>"><?php echo $rF["idmarca"]; ?></p>
															<p style="display:none" id="marca_text<?php echo $count_enf; ?>"><?php echo strtoupper($rF["mrcas"] ); ?></p>
															<p style="display:none" id="cant<?php echo $count_enf; ?>"><?php echo $rF["cantidad"]; ?></p>
															<p style="display:none" id="fvence<?php echo $count_enf; ?>"><?php echo $rF["fvencimiento"]; ?></p>
															<p style="display:none" id="series<?php echo $count_enf; ?>"><?php echo $rF["serie"]; ?></p>
															<!-- <p style="display:none" id="stok_act<?php echo $count_enf; ?>"></p> -->
															<input type='hidden' name='lote<?php echo $count_enf; ?>' id='lote<?php echo $count_enf; ?>' value='<?php echo $rF["lote"]; ?>' />
															<?php echo $count_enf ; ?>
														</td>
														<td>
															<input type='hidden' name='cantidad<?php echo $count_enf; ?>' id='cantidad<?php echo $count_enf; ?>' value='<?php echo $rF["cantidad"]; ?>' />
															<?php echo $rF["cantidad"]; ?>
														</td>
														<td>
															<input type='hidden' name='idunidad<?php echo $count_enf; ?>' id='idunidad<?php echo $count_enf; ?>' value='<?php echo $rF["idunidad"]; ?>' />
															<?php echo strtoupper($rF["unidad"] ); ?>
														</td>
														<td>
															<input type='hidden' name='idmaterial<?php echo $count_enf; ?>' id='idmaterial<?php echo $count_enf; ?>' value='<?php echo $rF["idmaterial"]; ?>' />
															<?php echo strtoupper($rF["materia"] ); ?>
														</td>
														<td>
															<input type='hidden' name='idmarca<?php echo $count_enf; ?>' id='idmarca<?php echo $count_enf; ?>' value='<?php echo $rF["idmarca"]; ?>' />
															<?php echo strtoupper($rF["mrcas"] ); ?>
														</td>
														<td>
															<input type='hidden' name='lote<?php echo $count_enf; ?>' id='lote<?php echo $count_enf; ?>' value='<?php echo $rF["lote"]; ?>' />
															<?php echo strtoupper($rF["lote"] ); ?>
														</td>
														<td>
															<input type='hidden' name='serie<?php echo $count_enf; ?>' id='serie<?php echo $count_enf; ?>' value='<?php echo $rF["serie"]; ?>' />
															<?php echo strtoupper($rF["serie"] ); ?>
														</td>
														<td>
															<input type='hidden' name='fvencimiento<?php echo $count_enf; ?>' id='fvencimiento<?php echo $count_enf; ?>' value='<?php echo $rF["fvencimiento"]; ?>' />
															<?php echo strtoupper($rF["fvencimiento"] ); ?>
														</td>
														
														<td >
														</td>
														<td >
															<img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_diagnostico(<?php echo $count_enf; ?>)' title='Quitar Registro' />
														</td>
														<td >
															<img src='../img/edit.png' style='cursor:pointer' onclick='editar_diagnostico(<?php echo $count_enf; ?>)' title='Editar Registro' />
														</td>
													</tr>
												<?php }?>
											</tbody>
										</table>
										<input type="hidden" id="contar_diagnostico" name="contar_diagnostico" value="<?php echo $count_enf; ?>" />
										<input type="hidden" id="contar_diagnostico2" name="contar_diagnostico2" value="<?php echo $count_enf; ?>" />
										<script> 
											var  count_enf=<?php echo $count_enf; ?> 
											var  count_edit=null;
										</script>
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

		<!-- <tr>
			<td colspan="3">&nbsp;</td>
		</tr>
	</table>
</form> -->

<script type="text/javascript">
	
    Redtestt(<?php echo $idorg_idejec; ?>,<?php echo $idorg_red; ?>);
	MicrooRed(<?php echo $idorg_red;?>,<?php echo $idorg_idejec; ?>,<?php echo $idorg_micro;?>);
    Estalecimiento(<?php echo $idorg_micro; ?>, <?php echo $idorg_estable; ?>);
   
    //<![CDATA[
    $(document).ready(function(){
        $('.combobox').combobox()
    });
    //]]>
	

	
</script>