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

	if($cod!=0)
	{
		$query = "select * from aedes where idaedes=".$cod;
		$row = $objconfig->execute_select($query);

        $idorg_micro = $row[1]["idmicrored"];
        $idorg_estable =$row[1]["idestablecimiento"];


		$disable= "disabled";  
		
        $pac= "select idpaciente, nrodocumento,apellidos, nombres from paciente where idpaciente=".$row[1]["idpaciente"];
        $rowPaciente = $objconfig->execute_select($pac);
        $nombrepaciente = $rowPaciente[1]["nrodocumento"]." - ".$rowPaciente[1]["apellidos"]."; ".$rowPaciente[1]["nombres"];

        $esta= "select idestablecimiento, eje,red, micro, esta,codrenaes, idred, idmicrored from vista_establecimiento where idestablecimiento=".$row[1]["idestablesolicita"];
        $rowEstable = $objconfig->execute_select($esta);

        //$establecimiento = $rowEstable[1]["codrenaes"]." / ".$rowEstable[1]["esta"]." / ".$rowEstable[1]["micro"]." / ".$rowEstable[1]["red"]." / ".$rowEstable[1]["eje"];
        $establecimiento = $rowEstable[1]["codrenaes"]." - ".$rowEstable[1]["esta"]." / ".$rowEstable[1]["micro"]." / ".$rowEstable[1]["red"];
        $red_orig = $rowEstable[1]["idred"];
        $mred_orig = $rowEstable[1]["idmicrored"];
        $est_orig = $rowEstable[1]["idestablecimiento"];

        $Ups = "select idups, descripcion, codups from ups where idups=".$row[1]["idespecialidad"]." order by descripcion asc";
        $UpsOrg = $objconfig->execute_select($Ups);
        $UpsOrigen = $UpsOrg[1]["codups"]." - ".$UpsOrg[1]["descripcion"];
		
		$dist= "select iddistrito, descripcion, provincia, departamento from vista_distrito where iddistrito=".$row[1]["iddistrito"];
        $rowD = $objconfig->execute_select($dist);
		 $rowDistri = $rowD[1]["descripcion"]." / ".$rowD[1]["provincia"]." / ".$rowD[1]["departamento"];

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


function ValidaLongitud(campo, longitudMaxima) 
{
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
				<button type="button" class="close" data-dismiss="modal">&times; </button>
				<input type="hidden" name="op" id="op" value="<?php echo $op; ?>"  />
				<input type="hidden" name="0form_idusuario" id="idusuario" value="<?=$idusuario[0]?>"  />
				<input type="hidden" name="0form_nombre_usuario" id="nombre_usuario" value="<?=$idusuario[1]?>"  />
				<input type="hidden" name="0form_idusuario" id="idusuario" value="<?php echo $iduser; ?>"  />
				<input type="hidden" name="0form_idejecutora" id="idejecutora" value="<?php echo $nom_estab[1]["idejec"]; ?>"  />
				<input type="hidden" name="0form_idred" id="idred" value="<?php echo $nom_estab[1]["idred"]; ?>"  />
				<input type="hidden" name="0form_idmicrored" id="idmicrored" value="<?php echo $nom_estab[1]["idmicrored"]; ?>"  />
				<input type="hidden" name="0form_idestablecimiento" id="idestablecimiento" value="<?php echo $nom_estab[1]["idestablecimiento"]; ?>"  />
				<input type="hidden" name="0form_idingresomuestra" id="idingresomuestra" value="<?=$row[1]["idingresomuestra"]?>"  />
				<input type="hidden" name="0form_idtipo_examen" id="idtipo_examen" value="4"  />
				<input type="hidden" name="0form_itemvar" id="itemvar" value="0"  />
				
				<h3 class="modal-title text-center">Registro de la Calida Técnica de Gota Gruesa y Frotis de Láminas Evaluadas de  Malária</h3>
			</div>
			<div class="modal-body">
                <div class="col-md-12">

							<div class="row">
							<div class="col-md-12">
							<input type="hidden" name="1form_idaedes" id="codigo" value="<?=$row[1]["idaedes"]?>"   <?php echo $readonly; ?>   class="form-control"/>
							
							<div class="col-md-3">
							<label for="atencion" class="control-label">Codigo Barras</label>
							</div>
							<div class="col-md-3">
							<input type="text" name="0form_codbarra" id="codbarra" onkeyup="mayuscula(this);" onkeypress="return ValidaLongitud(this, 12);" class="form-control" value="<?=$row[1]["codbarra"]?>" onchange="buscar_renaes();" placeholder="Código de Barra" data-toggle="tooltip" data-placement="top" title=" Ingrese Código de Barra" />
							</div>
							<div class="col-md-3">
								<label>Fecha Recepción.</label>
							</div>
							<div class="col-md-3">
							<div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2"  data-link-format="yyyy-mm-dd">
                            <input class="form-control" type="text" name="0form_fecharecepcion" id="fecharecepcion" value="<?php echo ($row[1]["fecharecepcion"])?$objconfig->FechaDMY2($row[1]["fecharecepcion"]):date("d/m/Y");?>"  >
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
							</div>
							
							</div>
							</div>
							</br>
							<div class="row">
								<div class="col-md-12">
								<div class="col-md-3">
									<label for="atencion" class="control-label">RED / MICRO RED / E.E. S.S :  </label>
								</div>
					
								<div class="col-md-9">
									<input type="hidden" id="codred" name="0form_codred" value="<?=$red_orig;?>"  />
									<input type="hidden" id="codmred" name="0form_codmred" value="<?=$mred_orig;?>"  />
									<input type="hidden" id="idestablesolicita" name="0form_idestablesolicita" value="<?=$est_orig;?>"  />
									<input for="atencion" type="text" name="nombre_establecimiento" id="nombre_establecimiento"  readonly="readonly"  value="<?php echo $establecimiento;?>" placeholder="Ingresa Codigo de Barra para seleccionar Establecimiento" class=" form-control" />
								</div>
								
						        </div>
							</div>
							</br>
							<div class="row">
							<div class="col-md-12">
							<div class="col-md-3">
							<label for="atencion" class="control-label">Fecha Ingreso</label>
							</div>
							<div class="col-md-2">
							<div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2"  data-link-format="yyyy-mm-dd">
                            <input class="form-control" type="text" name="0form_fechainicio" id="fechainicio" value="<?php echo ($row[1]["fechainicio"])?$objconfig->FechaDMY2($row[1]["fechainicio"]):date("d/m/Y");?>"  >
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
							</div>
							<div class="col-md-1">
								<label>Fecha Emisión</label>
							</div>
							<div class="col-md-2">
							<div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2"   data-link-format="yyyy-mm-dd">
                            <input class="form-control" type="text" name="0form_fechatermino" id="fechatermino" value="<?php echo ($row[1]["fechatermino"])?$objconfig->FechaDMY2($row[1]["fechatermino"]):date("d/m/Y");?>"  >
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
							</div>
							<div class="col-md-1">
								<label>Lab Interm:</label>
							</div>
							<div class="col-md-3">
							<select id="idintermedio" name="0form_idintermedio" class=" form-control combobox"   >
										<option value="0"></option>
										<?php
										$queryT = "select idintermedio,descripcion 
													from lab_intermedio  where estareg=1
													order by descripcion asc";
										$itemsT = $objconfig->execute_select($queryT,1);

										foreach($itemsT[1] as $rowT)
										{
											$selected="";
											if($rowT["idintermedio"]==$row[1]["idintermedio"]){$selected="selected='selected'";}
											echo "<option value='".$rowT["idintermedio"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
										}
										?>
									</select>
							</div>
							</div>
							</div>
							</br>
							<div class="row">
							<div class="col-md-12">
							<div class="col-md-3">
								<label for="atencion" class="control-label">Doc. Referencia:  </label>
							</div>
							<div class="col-md-3">
								<input type="text" id="local" name="local" onkeyup="mayuscula(this);" class=" form-control"  value=""  />
							</div>
						<div class="col-md-1">
								<label>Trimestre:</label>
							</div>
							<div class="col-md-2">
							<select id="idtrimestre" name="0form_idtrimestre" class=" form-control"   >
										<option value="0"></option>
										<?php
										$queryT = "select idtrimestre,descripcion 
													from trimestre  where estareg=1
													order by idtrimestre asc";
										$itemsT = $objconfig->execute_select($queryT,1);

										foreach($itemsT[1] as $rowT)
										{
											$selected="";
											if($rowT["idtrimestre"]==$row[1]["idtrimestre"]){$selected="selected='selected'";}
											echo "<option value='".$rowT["idtrimestre"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
										}
										?>
									</select>
							</div>
							<div class="col-md-1">
								<label>Mes:</label>
							</div>
							<div class="col-md-2">
							<select id="idmes" name="0form_idmes" class=" form-control"   >
								<option value="0"></option>
								<?php
								$queryT = "select idmes,descripcion 
											from mess  where estareg=1
											order by idmes asc";
								$itemsT = $objconfig->execute_select($queryT,1);

								foreach($itemsT[1] as $rowT)
								{
									$selected="";
									if($rowT["idmes"]==$row[1]["idmes"]){$selected="selected='selected'";}
									echo "<option value='".$rowT["idmes"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
								}
								?>
							</select>
							</div>
							</div>
							</div>
							</br>
							
							<div class="jumbotron jumbotron-fluid">
							<div class="row">
								<div class="col-md-12">
								<div class="col-md-2">
								<label for="atencion" class="control-label">Fecha Eval</label>
								</div>
								<div class="col-md-2">
								<div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2"  data-link-format="yyyy-mm-dd">
								<input class="form-control" type="text" name="feval" id="feval" value=""  >
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
								</div>
								<div class="col-md-2">
								<label for="atencion" class="control-label">Cod Lab Evaluado:  </label>
								</div>
								<div class="col-md-3">
									<select id="labeva" name="labeva" class=" form-control combobox"   >
										<option value="0"></option>
										<?php
										$queryT = "select idlaboratorio,codlab,labmalaria 
													from vista_labmalaria  where estareg=1
													order by labmalaria asc";
										$itemsT = $objconfig->execute_select($queryT,1);

										foreach($itemsT[1] as $rowT)
										{
											$selected="";
											if($rowT["idlaboratorio"]==$row[1]["idlaboratorio"]){$selected="selected='selected'";}
											echo "<option value='".$rowT["idlaboratorio"]."' ".$selected." >".strtoupper($rowT["codlab"]." - ".$rowT["labmalaria"])."</option>";
										}
										?>
									</select>
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Cod Lamina:  </label>
								</div>
								<div class="col-md-2">
								<input type="text" id="clami" name="clami" onkeyup="mayuscula(this);" class=" form-control"  value=""  />
								</div>
								</div>
							</div>
							</br>
							
								<div class="row">
								<div class="col-md-12">
								
								<div class="col-md-1">
									<label for="atencion" class="control-label">Muestra / Tam :  </label>
								</div>
								<div class="col-md-1">
								<select id="mtam" name="mtam" class="form-control"   >
										<option value="0"></option>
										<?php
										$queryT = "select idcondicion,descripcion 
													from tipo_condicion  where idcondicion IN (1,2,7) AND estareg=1
													order by descripcion desc";
										$itemsT = $objconfig->execute_select($queryT,1);

										foreach($itemsT[1] as $rowT)
										{
											echo "<option value='".$rowT["idcondicion"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
										}
										?>
									</select>
								</div>
								<div class="col-md-1">
								<label for="atencion" class="control-label">Muestra / Ubica </label>
								</div>
								<div class="col-md-1">
								<select id="mubic" name="mubic" class="form-control"   >
										<option value="0"></option>
										<?php
										$queryT = "select idcondicion,descripcion 
													from tipo_condicion  where idcondicion IN (1,2,7) AND estareg=1
													order by descripcion desc";
										$itemsT = $objconfig->execute_select($queryT,1);

										foreach($itemsT[1] as $rowT)
										{
											echo "<option value='".$rowT["idcondicion"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
										}
										?>
									</select>
								</div>
								<div class="col-md-1">
								<label for="atencion" class="control-label">Muestra / Calidad </label>
								</div>
								<div class="col-md-1">
								<select id="mcali" name="mcali" class="form-control"   >
										<option value="0"></option>
										<?php
										$queryT = "select idcondicion,descripcion 
													from tipo_condicion  where idcondicion IN (1,2,7) AND estareg=1
													order by descripcion desc";
										$itemsT = $objconfig->execute_select($queryT,1);

										foreach($itemsT[1] as $rowT)
										{
											echo "<option value='".$rowT["idcondicion"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
										}
										?>
									</select>
								</div>
								<div class="col-md-1">
								<label for="atencion" class="control-label">Coloración / Desh </label>
								</div>
								<div class="col-md-1">
								<select id="cdesh" name="cdesh" class="form-control"   >
										<option value="0"></option>
										<?php
										$queryT = "select idcondicion,descripcion 
													from tipo_condicion  where idcondicion IN (1,2,7) AND estareg=1
													order by descripcion desc";
										$itemsT = $objconfig->execute_select($queryT,1);

										foreach($itemsT[1] as $rowT)
										{
											echo "<option value='".$rowT["idcondicion"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
										}
										?>
									</select>
								</div>
								<div class="col-md-1">
								<label for="atencion" class="control-label">Coloración / Ton </label>
								</div>
								<div class="col-md-1">
								<select id="cton" name="cton" class="form-control"   >
										<option value="0"></option>
										<?php
										$queryT = "select idcondicion,descripcion 
													from tipo_condicion  where idcondicion IN (1,2,7) AND estareg=1
													order by descripcion desc";
										$itemsT = $objconfig->execute_select($queryT,1);

										foreach($itemsT[1] as $rowT)
										{
											echo "<option value='".$rowT["idcondicion"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
										}
										?>
									</select>
								</div>
								<div class="col-md-1">
								<label for="atencion" class="control-label">Coloración / PP </label>
								</div>
								<div class="col-md-1">
								<select id="cpp" name="cpp" class="form-control"   >
										<option value="0"></option>
										<?php
										$queryT = "select idcondicion,descripcion 
													from tipo_condicion  where idcondicion IN (1,2,7) AND estareg=1
													order by descripcion desc";
										$itemsT = $objconfig->execute_select($queryT,1);

										foreach($itemsT[1] as $rowT)
										{
											echo "<option value='".$rowT["idcondicion"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
										}
										?>
									</select>
								</div>
								</div>
							</div>
							</br>
							<div class="row">
							<div class="col-md-12">
								<div class="col-md-1">
								<label for="atencion" class="control-label">FROTIS / TAM </label>
								</div>
								<div class="col-md-1">
								<select id="ftam" name="ftam" class="form-control"   >
										<option value="0"></option>
										<?php
										$queryT = "select idcondicion,descripcion 
													from tipo_condicion  where idcondicion IN (1,2,7) AND estareg=1
													order by descripcion desc";
										$itemsT = $objconfig->execute_select($queryT,1);

										foreach($itemsT[1] as $rowT)
										{
											echo "<option value='".$rowT["idcondicion"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
										}
										?>
									</select>
								</div>
								<div class="col-md-1">
								<label for="atencion" class="control-label">FROTIS / UBIC </label>
								</div>
								<div class="col-md-1">
								<select id="fubi" name="fubi" class="form-control"   >
										<option value="0"></option>
										<?php
										$queryT = "select idcondicion,descripcion 
													from tipo_condicion  where idcondicion IN (1,2,7) AND estareg=1
													order by descripcion desc";
										$itemsT = $objconfig->execute_select($queryT,1);

										foreach($itemsT[1] as $rowT)
										{
											echo "<option value='".$rowT["idcondicion"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
										}
										?>
									</select>
								</div>
								<div class="col-md-1">
								<label for="atencion" class="control-label">FROTIS / EXTEN </label>
								</div>
								<div class="col-md-1">
								<select id="fext" name="fext" class="form-control"   >
										<option value="0"></option>
										<?php
										$queryT = "select idcondicion,descripcion 
													from tipo_condicion  where idcondicion IN (1,2,7) AND estareg=1
													order by descripcion desc";
										$itemsT = $objconfig->execute_select($queryT,1);

										foreach($itemsT[1] as $rowT)
										{
											echo "<option value='".$rowT["idcondicion"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
										}
										?>
									</select>
								</div>
								<div class="col-md-1">
								<label for="atencion" class="control-label">Resultado</label>
								</div>
								<div class="col-md-2">
								<select id="resu" name="resu" class="form-control"   >
										<option value="0"></option>
										<?php
										$queryT = "select idresultado,descripcion 
													from tipo_resultado  where idresultado IN (29,28,69) AND estareg=1
													order by descripcion desc";
										$itemsT = $objconfig->execute_select($queryT,1);

										foreach($itemsT[1] as $rowT)
										{
											echo "<option value='".$rowT["idresultado"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
										}
										?>
									</select>
								</div>
								<div class="col-md-1">
								<label for="atencion" class="control-label">Especie</label>
								</div>
								<div class="col-md-2">
								<select id="espe" name="espe" class="form-control"   >
										<option value="0"></option>
										<?php
										$queryT = "select idespecie,descripcion 
													from tipo_especie  where  estareg=1
													order by descripcion desc";
										$itemsT = $objconfig->execute_select($queryT,1);

										foreach($itemsT[1] as $rowT)
										{
											echo "<option value='".$rowT["idespecie"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
										}
										?>
									</select>
								</div>
							</div>
						</div>
							</br>
							<div class="row">
							<div class="col-md-12">
								<div class="col-md-1">
								<label for="atencion" class="control-label">Densidad</label>
								</div>
								<div class="col-md-1">
								<select id="dens" name="dens" class="form-control"   >
										<option value="0"></option>
										<?php
										$queryT = "select iddensidad,descripcion 
													from densidad  where  estareg=1
													order by iddensidad asc";
										$itemsT = $objconfig->execute_select($queryT,1);

										foreach($itemsT[1] as $rowT)
										{
											echo "<option value='".$rowT["iddensidad"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
										}
										?>
									</select>
								</div>
								<div class="col-md-1">
								<label for="atencion" class="control-label">Concord</label>
								</div>
								<div class="col-md-2">
								<select id="conc" name="conc" class="form-control"   >
										<option value="0"></option>
										<?php
										$queryT = "select idresultado,descripcion 
													from tipo_resultado  where idresultado IN (29,28,69) AND estareg=1
													order by descripcion desc";
										$itemsT = $objconfig->execute_select($queryT,1);

										foreach($itemsT[1] as $rowT)
										{
											echo "<option value='".$rowT["idresultado"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
										}
										?>
									</select>
								</div>
								<div class="col-md-1">
								<label for="atencion" class="control-label">DesCord</label>
								</div>
								<div class="col-md-2">
								<select id="desco" name="desco" class="form-control"   >
										<option value="0"></option>
										<?php
										$queryT = "select idresultado,descripcion 
													from tipo_resultado  where idresultado IN (29,28,69) AND estareg=1
													order by descripcion desc";
										$itemsT = $objconfig->execute_select($queryT,1);

										foreach($itemsT[1] as $rowT)
										{
											echo "<option value='".$rowT["idresultado"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
										}
										?>
									</select>
									</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Especie:  </label>
								</div>
								<div class="col-md-2">
									<select id="dcespe" name="dcespe" class="form-control"   >
										<option value="0"></option>
										<?php
										$queryT = "select idespecie,descripcion 
													from tipo_especie  where  estareg=1
													order by descripcion desc";
										$itemsT = $objconfig->execute_select($queryT,1);

										foreach($itemsT[1] as $rowT)
										{
											echo "<option value='".$rowT["idespecie"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
										}
										?>
									</select>
								</div>
								<div class="col-md-1">
									<input type="button" onclick="agregar_aedes();" class="btn btn-info"  value="Agregar" />
								</div>
							</div>
						</div>
						</br>
						
						</div>
					
										
				<div style="height:280px;  overflow-x:hidden;" >
				<div class="row">

				<div class="col-sm-12">
				<div class="panel panel-info class ">
				
					<div class="panel-heading">Lista de Muestras Procesadas</div>
					
					<div class="panel-body table-responsive">
						<table class="table table-striped table-hover table-active table-condensed" id="tbmuestras" name="tbmuestras" >
							 <thead class="thead-light">

							<tr align ="center" class="bg-success">
								<td >#</td>
								<td >F. Eval</td>
								<td >Cod.Lab.</td>
								<td >Cod.Lam</td>
								<td >Tam.M.</td>
								<td >Ubc.M.</td>
								<td >Cal.M.</td>
								<td >DeshColor</td>
								<td >TonColor</td>
								<td >PP.Color</td>
								<td >Frot.Tam</td>
								<td >Frot.Ubc.</td>
								<td >Frot.Ext.</td>
								<td >Resultado</td>
								<td >Especie</td>
								<td >Densidad</td>
								<td >Concord</td>
								<td >DesCond.</td>
								<td >Especie</td>
								<td ></td>
							</tr>

							</thead>
							<tbody>
							<?php
							$count_enf=0;
			  
							$sqlT = "select m.fechaevalua,m.codlab,m.codlam,m.mtama,m.mubica,m.mcalid, m.cdesh, 
										m.ctono,m.cpp,m.ftam,m.fubi,m.fext,m.resu, m.espe,m.dens,m.idpupa,m.idadulto, 
										m.idaedes_a,m.idotros,z.descripcion as tzona, m.idtipointervencion, i.descripcion AS tinterven,
										p.nrodocumento ||' - '|| p.apellidos ||' '|| p.nombres as inspe_text, tf.codigo as tipfoco, m.localidad,
										m.totalviviendas, m.viviprogramadas,m.viviinspeccion,m.latitud,m.longitud ,m.direccion
										from aedes_muestra as m
										inner join tipo_zona as z on(z.idzona=m.idzona)
										inner join tipo_intervencion as i ON (i.idtipointervencion = m.idtipointervencion)
										inner join inspector as p ON (p.idinspector = m.idinspector)
										inner join tipo_foco as tf ON (tf.idfoco = m.idfoco)
										where m.idaedes=".$cod." order by  m.idzona asc";
						
							$rowTr = $objconfig->execute_select($sqlT,1);
							foreach($rowTr[1] as $rRt)
							{
								$count_enf++;
							//	$tp_int = $objconfig->execute_select("select descripcion from tipo_intervencion where idtipointervencion=".$rRt["idtipointervencion"]);
							
								?>
								<tr id='itemmuestra<?=$count_enf;?>' name='itemmuestra<?=$count_enf;?>' align ="center"  >
									<td >
										<input type='hidden' name='idaedes<?=$count_enf;?>' id='idaedes<?=$count_enf;?>' value='<?php echo $rRt["idaedes"]; ?>' />
										<?php echo $count_enf ; ?>
									</td>
									<td>
										<input type='hidden' name='fechaevalua<?=$count_enf;?>' id='fechaevalua<?=$count_enf;?>' value='<?php echo $rRt["fechaevalua"]; ?>' />
										<?php echo strtoupper($rRt["localidad"] ); ?>
									</td>
									<td>
										<input type='hidden' name='codlab<?=$count_enf;?>' id='codlab<?=$count_enf;?>' value='<?php echo $rRt["codlab"]; ?>' />
										<?php echo strtoupper($rRt["codlab_text"] ); ?>
									</td>
									<td>
										<input type='hidden' name='codlam<?=$count_enf;?>' id='codlam<?=$count_enf;?>' value='<?php echo $rRt["codlam"]; ?>' />
										<?php echo strtoupper($rRt["viviprogramadas"] ); ?>
									</td>
									<td>
										<input type='hidden' name='mtama<?=$count_enf;?>' id='mtama<?=$count_enf;?>' value='<?php echo $rRt["mtama"]; ?>' />
										<?php echo strtoupper($rRt["viviinspeccion"] ); ?>
									</td>
									<td>
										<input type='hidden' name='mubica<?=$count_enf;?>' id='mubica<?=$count_enf;?>' value='<?php echo $rRt["mubica"]; ?>' />
										<?php echo strtoupper($rRt["tzona"] ); ?>
									</td>
									<td>
										<input type='hidden' name='mcalid<?=$count_enf;?>' id='mcalid<?=$count_enf;?>' value='<?php echo $rRt["mcalid"]; ?>' />
										<?php echo $objconfig->FechaDMY2($rRt["fechrecojo"] ); ?>
									</td>
									<td>
										<input type='hidden' name='cdesh<?=$count_enf;?>' id='cdesh<?=$count_enf;?>' value='<?php echo $rRt["cdesh"]; ?>' />
										<?php echo strtoupper($rRt["idmanzana"] ); ?>
									</td>
									<td>
										<input type='hidden' name='ctono<?=$count_enf;?>' id='ctono<?=$count_enf;?>' value='<?php echo $rRt["ctono"]; ?>' />
										<?php echo strtoupper($rRt["familia"] ); ?>
									</td>
									<td>
										<input type='hidden' name='cpp<?=$count_enf;?>' id='cpp<?=$count_enf;?>' value='<?php echo $rRt["cpp"]; ?>' />
										<?php echo strtoupper($rRt["direccion"] ); ?>
									</td>
									<td>
										<input type='hidden' name='ftam<?=$count_enf;?>' id='ftam<?=$count_enf;?>' value='<?php echo $rRt["ftam"]; ?>' />
										<?php echo strtoupper($rRt["latitud"] ); ?>
									</td>
									<td>
										<input type='hidden' name='fubi<?=$count_enf;?>' id='fubi<?=$count_enf;?>' value='<?php echo $rRt["fubi"]; ?>' />
										<?php echo strtoupper($rRt["longitud"] ); ?>
									</td>
									<td>
										<input type='hidden' name='fext<?=$count_enf;?>' id='fext<?=$count_enf;?>' value='<?php echo $rRt["fext"]; ?>' />
										<?php echo strtoupper($rRt["inspe_text"] ); ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='resu<?=$count_enf;?>' id='resu<?=$count_enf;?>' value='<?php echo $rRt["resu"]; ?>' />
										<?php echo strtoupper($rRt["tipfoco"] ); ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='espe<?=$count_enf;?>' id='espe<?=$count_enf;?>' value='<?php echo $rRt["espe"]; ?>' />
										<?php echo strtoupper($rRt["idlarva"] ); ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='dens<?=$count_enf;?>' id='dens<?=$count_enf;?>' value='<?php echo $rRt["dens"]; ?>' />
										<?php echo strtoupper($rRt["idpupa"] ); ?>
									</td>
									<td class="bg-info" >
										<input type='hidden' name='idadulto<?=$count_enf;?>' id='idadulto<?=$count_enf;?>' value='<?php echo $rRt["idadulto"]; ?>' />
										<?php echo strtoupper($rRt["idadulto"] ); ?>
									</td>
									<td class="bg-danger" >
										<input type='hidden' name='idaedes_a<?=$count_enf;?>' id='idaedes_a<?=$count_enf;?>' value='<?php echo $rRt["idaedes_a"]; ?>' />
										<?php echo strtoupper($rRt["idaedes_a"] ); ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='idotros<?=$count_enf;?>' id='idotros<?=$count_enf;?>' value='<?php echo $rRt["idotros"]; ?>' />
										<?php echo strtoupper($rRt["idotros"] ); ?>
									</td>
									<td >
										<img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_aedes(<?=$count_enf;?>)' title='Borrar REgistro' />
									</td>
								</tr>
								
							<?php }?>
							</tbody>
							<tfoot class="">
							
							<tr align ="center" class="bg-success thead-light">
								<td >#</td>
								<td >F. Eval</td>
								<td >Cod.Lab.</td>
								<td >Cod.Lam</td>
								<td >Tam.M.</td>
								<td >Ubc.M.</td>
								<td >Cal.M.</td>
								<td >DeshColor</td>
								<td >TonColor</td>
								<td >PP.Color</td>
								<td >Frot.Tam</td>
								<td >Frot.Ubc.</td>
								<td >Frot.Ext.</td>
								<td >Resultado</td>
								<td >Especie</td>
								<td >Densidad</td>
								<td >Concord</td>
								<td >DesCond.</td>
								<td >Especie</td>
								<td ></td>
							</tr>
						  </tfoot>
						</table>
						<input type="hidden" id="contar_muestra" name="contar_muestra" value="<?=$count_enf;?>" />
						<input type="hidden" id="contar_muestra2" name="contar_muestra2" value="<?=$count_enf;?>" />
						<script> var  count_enf=<?=$count_enf;?> </script>
						</div>
						</div>
						</div>
					</div>
				</div>
				<br/>
				<!--- Consolidado de Aedes Aegipti -->
					
					<div class="row">
						<div class="col-md-12">
						<div class="col-md-2">
									<label for="atencion" class="control-label">Estado Muestras :  </label>
								</div>
								<div class="col-md-2">
								<select id="idestadomuestra" name="0form_idestadomuestra" class="form-control"   >
										<option value="0"></option>
										<?php
										$queryT = "select idestadomuestra,descripcion 
													from estadomuestra  where estareg=1
													order by descripcion asc";
										$itemsT = $objconfig->execute_select($queryT,1);

										foreach($itemsT[1] as $rowT)
										{
											$selected="";
											if($rowT["idestadomuestra"]==$row[1]["idestadomuestra"]){$selected="selected='selected'";}
											echo "<option value='".$rowT["idestadomuestra"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
										}
										?>
									</select>
								</div>
							<div class="col-md-2">
								<label for="atencion" class="control-label">N° Documento:</label>
							</div>
							<div class="col-md-6">
								<input type="text" id="nroreporte" name="0form_nroreporte" class="form-control" value="<?=$row[1]["nroreporte"]?>" />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<label for="atencion" class="control-label">Observaciones:</label>
							<textarea name="0form_observacion" id="observacion" class="form-control " onkeyup="mayuscula(this);" rows="7" cols="120"><?=$row[1]["observacion"]?></textarea>
						</div>

					</div>
				
				
				</div>
							
				<!-- Fin del Consolidado -->		
				</br>
						<div class="row">
							<div class="col-md-12">
								
							</div>
						</div>
      
						<?php
							if($op==1){
								$checked = "";
									 $mensaje = "Cerrar Ficha";
									 $class = "btn btn-danger"; 
									 $estareg=1;
							}else {
							
							$checked = "checked='checked'";
							$checked1 = "checked='checked'";
							$mensaje = "Exámen Completo";
							$class = "btn btn-success"; 
							
							$estareg = 2;
							if(isset($row[1]["estareg"]))
							{
								$estareg = $row[1]["estareg"];
								if($estareg==1)
								{
									$checked = "";
									 $mensaje = "Examen Pendientes";
									 $class = "btn btn-danger"; 
								}
							}
							}
						?>

                          
							
                            <br/>
                            <div class="upload-msg col-md-12"></div><!--Para mostrar la respuesta del archivo llamado via ajax -->
                            <div class="modal-footer">
                                <!--		<input type="hidden" name="user_id" id="user_id" />
                                        <input type="hidden" name="operation" id="operation" /> -->
                                <input type="button" onclick="contarArray();" name="action" id="action" class="btn btn-success"  value="Guardar" />
                                <button type="button" onclick="regresar_index(carpeta);" class="btn btn-default" data-dismiss="modal" data-backdrop="false" > Cerrar </button>
                            </div>
  </div>

	</form>

		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
	</table>
</form>

<script type="text/javascript">
  


   $(document).ready(function(){
        $('.combobox').combobox()
    });
   
</script>