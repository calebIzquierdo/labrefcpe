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
		$query = "select * from entomologia where identomologia=".$cod;
		$row = $objconfig->execute_select($query);

        $idorg_micro = $row[1]["idmicrored"];
        $idorg_estable =$row[1]["idestablecimiento"];


		$disable= "disabled";  
		
        $qDiag = $objconfig->execute_select("select iddiagnostico, codigo ||' - '||descripcion as diagno from diagnostico where iddiagnostico=".$row[1]["iddiagnostico"]);
        echo $qDiag[1]["iddiagnostico"];

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
				<input type="hidden" name="0form_idtipo_examen" id="idtipo_examen" value="2"  />
				
				<h3 class="modal-title text-center">Registro de Ficha Entomológico </h3>
			</div>
			<div class="modal-body">
                <div class="col-md-12">

							<div class="row">
							<div class="col-md-12">
							<input type="hidden" name="1form_identomologia" id="codigo" value="<?=$row[1]["identomologia"]?>"   <?php echo $readonly; ?>   class="form-control"/>
							
							<div class="col-md-3">
							<label for="atencion" class="control-label">Codigo Barras</label>
							</div>
							<div class="col-md-3">
							<input type="text" name="0form_codbarra" id="codbarra" onkeyup="mayuscula(this);" onkeypress="return ValidaLongitud(this, 12);" class="form-control" value="<?=$row[1]["codbarra"]?>" onchange="buscar_renaes();" placeholder="Código de Barra" data-toggle="tooltip" data-placement="top" title="Código de Barra" />
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
							<label for="atencion" class="control-label">Inicio Trabajo</label>
							</div>
							<div class="col-md-3">
							<div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2"  data-link-format="yyyy-mm-dd">
                            <input class="form-control" type="text" name="0form_fechainicio" id="fechainicio" value="<?php echo ($row[1]["fechainicio"])?$objconfig->FechaDMY2($row[1]["fecharecepcion"]):date("d/m/Y");?>"  >
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
							</div>
							<div class="col-md-3">
								<label>Termino Trabajo.</label>
							</div>
							<div class="col-md-3">
							<div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2"   data-link-format="yyyy-mm-dd">
                            <input class="form-control" type="text" name="0form_fechatermino" id="fechatermino" value="<?php echo ($row[1]["fechatermino"])?$objconfig->FechaDMY2($row[1]["fecharecepcion"]):date("d/m/Y");?>"  >
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
							</div>
							</div>
							</div>
							</br>
							<div class="row">
								<div class="col-md-12">
								<div class="col-md-3">
									<label for="atencion" class="control-label">Distrito / Província / Departamento :  </label>
								</div>
							
								<div class="col-md-6">
									<input type="hidden" id="iddistrito" name="0form_iddistrito" value="<?=$row[1]["iddistrito"];?>"  />
									<input type="hidden" id="idprovincia" name="0form_idprovincia" value="<?=$row[1]["idprovincia"];?>"  />
									<input type="hidden" id="iddepartamento" name="0form_iddepartamento" value="<?=$row[1]["iddepartamento"];?>"  />
									<input for="atencion" type="text" name="nombre_distrito" id="nombre_distrito" onclick="buscar_distrito();" readonly="readonly"  value="<?php echo $establecimiento;?>" placeholder="Ingresa Nombre del Distrito" class=" form-control" />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Pobl:  </label>
								</div>
								<div class="col-md-2">
								<input type="text" id="idpoblacion" name="0form_idpoblacion" class=" form-control"  value="<?=$row[1]["iddistrito"];?>"  />
								</div>
								 </div>
								 </div>
								 <br>
								<div class="row">
								<div class="col-md-12">
								<div class="col-md-1">
									<label for="atencion" class="control-label">Zona / Sector :  </label>
								</div>
								<div class="col-md-2">
								<select id="idzona" name="idzona" class="combobox form-control"   >
										<option value="0"></option>
										<?php
										$queryT = "select idzona,descripcion 
													from tipo_zona  where estareg=1
													order by descripcion asc";
										$itemsT = $objconfig->execute_select($queryT,1);

										foreach($itemsT[1] as $rowT)
										{
											$selected="";
											if($rowT["idzona"]==$row[1]["idzona"]){$selected="selected='selected'";}
											echo "<option value='".$rowT["idzona"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
										}
										?>
									</select>
								</div>
								<div class="col-md-1">
								<label for="atencion" class="control-label">Fecha Recojo</label>
								</div>
								<div class="col-md-2">
								<div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2"  data-link-format="yyyy-mm-dd">
								<input class="form-control" type="text" name="fecharecojo" id="fecharecojo" value="<?php echo ($row[1]["fecharecojo"])?$objconfig->FechaDMY2($row[1]["fecharecojo"]):date("d/m/Y");?>"  >
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Mza:  </label>
								</div>
								<div class="col-md-1">
								<input type="text" id="manzana" name="manzana" class=" form-control"  value=""  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Familia:  </label>
								</div>
								<div class="col-md-3">
								<input type="text" id="fami" name="manzana" class=" form-control"  value=""  />
								</div>
								
						        </div>
							</div>
							</br>
							<div class="row">
							<div class="col-md-12">
								
								<div class="col-md-1">
									<label for="atencion" class="control-label">Inspector:  </label>
								</div>
								<div class="col-md-4">
									<input type="hidden" id="idinspector" name="idinspector" value="0"  />
									<input type="text" name="nombre_inspector" id="nombre_inspector" onclick="buscar_inspector();" readonly="readonly"  value="" placeholder="Click para Seleccionar Inspector" class=" form-control" />
								</div>
								
								<div class="col-md-1">
									<label for="atencion" class="control-label">Viviendas Inspec:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="vinspec" name="0form_vinspec" value="<?php echo $row[1]["vinspec"]?$row[1]["vinspec"]:0;?>" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Viviendas Positivo:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="vpositiva" name="0form_vpositiva" value="<?php echo $row[1]["vpositiva"]?$row[1]["vpositiva"]:0;?>" class="form-control"  />
								</div>
								
							</div>
						</div>
							</br>
						<div class="row">
							<div class="col-md-12">
								
								<div class="col-md-1">
									<label for="atencion" class="control-label">Localidad Jurisdicción:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="local" name="0form_local" onkeyup="mayuscula(this);" value="<?php echo $row[1]["local"]?$row[1]["local"]:0;?>" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Viviendas Program:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="vprogram" name="0form_vprogram" value="<?php echo $row[1]["vprogram"]?$row[1]["vprogram"]:0;?>" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Viviendas Inspec:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="vinspec" name="0form_vinspec" value="<?php echo $row[1]["vinspec"]?$row[1]["vinspec"]:0;?>" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Viviendas Positivo:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="vpositiva" name="0form_vpositiva" value="<?php echo $row[1]["vpositiva"]?$row[1]["vpositiva"]:0;?>" class="form-control"  />
								</div>
								
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-12">
								
								<div class="col-md-1">
									<label for="atencion" class="control-label">Recipientes Positivo:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="rpositiva" name="0form_rpositiva" value="<?php echo $row[1]["rpositiva"]?$row[1]["rpositiva"]:0;?>" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Muestras Recibida:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="mrecibida" name="0form_mrecibida" value="<?php echo $row[1]["mrecibida"]?$row[1]["mrecibida"]:0;?>" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Recipientes Inspec:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="rinspeccionado" name="0form_rinspeccionado" value="<?php echo $row[1]["rinspeccionado"]?$row[1]["rinspeccionado"]:0;?>" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Tipo Interv:  </label>
								</div>
								<div class="col-md-2">
									<select id="idtipointervencion" name="0form_idtipointervencion" class=" form-control"   >
										<option value="0"></option>
										<?php
										$queryT = "select idtipointervencion,descripcion 
													from tipo_intervencion  where estareg=1
													order by descripcion asc";
										$itemsT = $objconfig->execute_select($queryT,1);

										foreach($itemsT[1] as $rowT)
										{
											$selected="";
											if($rowT["idtipointervencion"]==$row[1]["idtipointervencion"]){$selected="selected='selected'";}
											echo "<option value='".$rowT["idtipointervencion"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
										}
										?>
									</select>
								</div>
							</div>
						</div>
						 
						
						<div class="row">
							<div class="col-md-12">
								
								<div class="col-md-1">
									<label for="atencion" class="control-label">Tanq,Alto, Pozos:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="tanque" name="0form_tanque" value="<?php echo $row[1]["tanque"]?$row[1]["tanque"]:0;?>" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Barril, Sans, Cil:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="barril" name="0form_barril" value="<?php echo $row[1]["barril"]?$row[1]["barril"]:0;?>" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Balde,Batea, Tina:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="baldes" name="0form_baldes" value="<?php echo $row[1]["baldes"]?$row[1]["baldes"]:0;?>" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Ollas,Cant, Barro:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="ollas" name="0form_ollas" value="<?php echo $row[1]["ollas"]?$row[1]["ollas"]:0;?>" class="form-control"  />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								
								<div class="col-md-1">
									<label for="atencion" class="control-label">Florero, Macetero:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="floreros" name="0form_floreros" value="<?php echo $row[1]["floreros"]?$row[1]["floreros"]:0;?>" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Llantas:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="llantas" name="0form_llantas" value="<?php echo $row[1]["llantas"]?$row[1]["llantas"]:0;?>" class="form-control"  />
								</div>
								
								<div class="col-md-1">
									<label for="atencion" class="control-label">Inserv Desuso:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="inservibles" name="0form_inservibles" value="<?php echo $row[1]["inservibles"]?$row[1]["inservibles"]:0;?>" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Otros Recipientes:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="orecipientes" name="0form_orecipientes" value="<?php echo $row[1]["orecipientes"]?$row[1]["orecipientes"]:0;?>" class="form-control"  />
								</div>



							</div>
						</div>
					
							
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-1">
									<label for="atencion" class="control-label">C1:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="c1" name="0form_c1" value="<?php echo $row[1]["c1"]?$row[1]["c1"]:0;?>" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">C2:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="c2" name="0form_c2" value="<?php echo $row[1]["c2"]?$row[1]["c2"]:0;?>" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">C3:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="c3" name="0form_c3" value="<?php echo $row[1]["c3"]?$row[1]["c3"]:0;?>" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">C4:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="c4" name="0form_c4" value="<?php echo $row[1]["c4"]?$row[1]["c4"]:0;?>" class="form-control"  />
								</div>
							</div>
						</div>
						<br/>
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-1">
									<label for="atencion" class="control-label">C5:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="c5" name="0form_c5" value="<?php echo $row[1]["c5"]?$row[1]["c5"]:0;?>" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">C6:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="c6" name="0form_c6" value="<?php echo $row[1]["c6"]?$row[1]["c6"]:0;?>" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">C7:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="c7" name="0form_c7" value="<?php echo $row[1]["c7"]?$row[1]["c7"]:0;?>" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">C8:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="c8" name="0form_c8" value="<?php echo $row[1]["c8"]?$row[1]["c8"]:0;?>" class="form-control"  />
								</div>
							</div>
						</div>
					<br/>
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
                                <input type="button" onclick="validar_form();" name="action" id="action" class="btn btn-success"  value="Agregar" />
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