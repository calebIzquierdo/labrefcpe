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
	
	$observacion = "FUENTE: LABORATORIO REFERENCIAL REGIONAL DE SALUD PUBLICA - SAN MARTIN.";
	
	if($cod!=0)
	{
		$query = "select * from consolidado where idconsolidado=".$cod;
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

        $Ups = "select  descripcion, provincia, departamento from vista_distrito where iddistrito=".$row[1]["iddistrito"]." ";
        $UpsOrg = $objconfig->execute_select($Ups);
        $nombre_distrito = $UpsOrg[1]["descripcion"]." / ".$UpsOrg[1]["provincia"]." / ".$UpsOrg[1]["departamento"];
		
		$observacion = $row[1]["observacion"];
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
				
				<h3 class="modal-title text-center">Consolidado de Vigilancia Entomológica de Aedes Aegypti </h3>
			</div>
			<div class="modal-body">
                <div class="col-md-12">
							<div class="row">
								<div class="col-md-12">
								<div class="col-md-3">
									<label for="atencion" class="control-label">N° Documento:  </label>
								</div>
					
								<div class="col-md-9">
									<input type="text" id="nroreporte" name="0form_nroreporte" value="<?=$row[1]["nroreporte"]?>" onkeyup="mayuscula(this);" class=" form-control" placeholder="Ingresa N° de documento"  />
									
								</div>
						        </div>
							</div>
							</br>
							<div class="row">
							<div class="col-md-12">
							<input type="hidden" name="1form_idconsolidado" id="codigo" value="<?=$row[1]["idconsolidado"]?>"   <?php echo $readonly; ?>   class="form-control"/>
							
							<div class="col-md-3">
							<label for="atencion" class="control-label">Codigo Barras</label>
							</div>
							<div class="col-md-3">
							<input type="text" name="0form_codbarra" id="codbarra" onkeyup="mayuscula(this);" onkeypress="return ValidaLongitud(this, 12);" onchange="buscar_renaes();"  class="form-control" value="<?=$row[1]["codbarra"]?>"  placeholder="Código de Barra" data-toggle="tooltip" data-placement="top" title="Código de Barra" />
							
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
                            <input class="form-control" type="text" name="0form_fechainicio" id="fechainicio" value="<?php echo ($row[1]["fechainicio"])?$objconfig->FechaDMY2($row[1]["fechainicio"]):date("d/m/Y");?>"  >
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
							</div>
							<div class="col-md-3">
								<label>Termino Trabajo.</label>
							</div>
							<div class="col-md-3">
							<div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2"   data-link-format="yyyy-mm-dd">
                            <input class="form-control" type="text" name="0form_fechatermino" id="fechatermino" value="<?php echo ($row[1]["fechatermino"])?$objconfig->FechaDMY2($row[1]["fechatermino"]):date("d/m/Y");?>"  >
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
									<input for="atencion" type="text" name="nombre_distrito" id="nombre_distrito" onclick="buscar_distrito();" readonly="readonly"  value="<?php echo $nombre_distrito;?>" placeholder="Ingresa Nombre del Distrito" class=" form-control" />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Localidad Jurisdicción:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="local" name="0form_localidad" onkeyup="mayuscula(this);" value="<?php echo $row[1]["localidad"];?>" class="form-control"  />
								</div>
								
						        </div>
							</div>
							</br>
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-2">
									<select id="zona" name="zona" class=" form-control combobox"   >
										<option value="0"> - </option>
										<?php
										$queryT = "select idzona,descripcion 
													from tipo_zona  where estareg=1 	";
										$itemsT = $objconfig->execute_select($queryT,1);

										foreach($itemsT[1] as $rowT)
										{
											$selected="";
											echo "<option value='".$rowT["idzona"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
										}
										?>
									</select>
								</div>
								
								<div class="col-md-1">
									<label for="atencion" class="control-label">Viviendas Program:  </label>
								</div>
								<div class="col-md-1">
									<input type="text" id="vprog" name="vprog" value="0" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Viviendas Inspec:  </label>
								</div>
								<div class="col-md-1">
									<input type="text" id="vinspec" name="vinspec"  value="0" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Viviendas (+):  </label>
								</div>
								<div class="col-md-1">
									<input type="text" id="vipos" name="vipos"  value="0" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">M. Recib:  </label>
								</div>
								<div class="col-md-1">
									<input type="text" id="mrecbd" name="mrecbd" value="0" class="form-control"  />
								</div>
								
								<div class="col-md-1">
									<label for="atencion" class="control-label">C1 Insp:  </label>
								</div>
								<div class="col-md-1">
									<input type="text" id="c1insp" name="c1insp" onkeyup="suma()"  value="0" class="form-control"  />
								</div>
							</div>
						</div>
												 
						
							
						<div class="row">
							<div class="col-md-12">
								
								<div class="col-md-1">
									<label for="atencion" class="control-label">C1 (+):  </label>
								</div>
								<div class="col-md-1">
									<input type="text" id="c1pos" name="c1pos" onkeyup="suma()" value="0" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">C2 Insp:  </label>
								</div>
								<div class="col-md-1">
									<input type="text" id="c2insp" name="c2insp" onkeyup="suma()" value="0" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">C2 (+):  </label>
								</div>
								<div class="col-md-1">
									<input type="text" id="c2pos" name="c2pos" onkeyup="suma()" value="0" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">C3 Insp:  </label>
								</div>
								<div class="col-md-1">
									<input type="text" id="c3insp" name="c3insp" onkeyup="suma()" value="0" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">C3 (+):  </label>
								</div>
								<div class="col-md-1">
									<input type="text" id="c3pos" name="c3pos" onkeyup="suma()" value="0" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">C4 Insp:  </label>
								</div>
								<div class="col-md-1">
									<input type="text" id="c4insp" name="c4insp" onkeyup="suma()" value="0" class="form-control"  />
								</div>
								</div>
						</div>
						<br/>
						<div class="row">
							<div class="col-md-12">
								
								<div class="col-md-1">
									<label for="atencion" class="control-label">C4 (+):  </label>
								</div>
								<div class="col-md-1">
									<input type="text" id="c4pos" name="c4pos" onkeyup="suma()" value="0" class="form-control"  />
								</div>						
								<div class="col-md-1">
									<label for="atencion" class="control-label">C5 Insp:  </label>
								</div>
								<div class="col-md-1">
									<input type="text" id="c5insp" name="c5insp" onkeyup="suma()" value="0" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">C5 (+):  </label>
								</div>
								<div class="col-md-1">
									<input type="text" id="c5pos" name="c5pos" onkeyup="suma()" value="0" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">C6 Insp:  </label>
								</div>
								<div class="col-md-1">
									<input type="text" id="c6insp" name="c6insp" onkeyup="suma()" value="0" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">C6 (+):  </label>
								</div>
								<div class="col-md-1">
									<input type="text" id="c6pos" name="c6pos" onkeyup="suma()" value="0" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">C7 Insp:  </label>
								</div>
								<div class="col-md-1">
									<input type="text" id="c7insp" name="c7insp" onkeyup="suma()" value="0" class="form-control"  />
								</div>
								
								</div>
						</div>
						<br/>
						<div class="row">
							<div class="col-md-12">
								
								<div class="col-md-1">
									<label for="atencion" class="control-label">C7 (+):  </label>
								</div>
								<div class="col-md-1">
									<input type="text" id="c7pos" name="c7pos" onkeyup="suma()" value="0" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">C8 Insp:  </label>
								</div>
								<div class="col-md-1">
									<input type="text" id="c8insp" name="c8insp" onkeyup="suma()" value="0" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">C8 (+):  </label>
								</div>
								<div class="col-md-1">
									<input type="text" id="c8pos" name="c8pos" onkeyup="suma()" value="0" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Total Recipientes:  </label>
								</div>
								<div class="col-md-1">
									<input type="text" id="trecip" name="trecip" value="0" readonly class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Total Positivos:  </label>
								</div>
								<div class="col-md-1">
									<input type="text" id="tposit" name="tposit" value="0" readonly class="form-control"  />
								</div>
								<div class="col-md-1">
									<select id="trata" name="trata" class=" form-control"   >
										<option value="0"></option>
										<?php
										$queryT = "select idtipointervencion,descripcion 
													from tipo_intervencion  where estareg=1 	";
										$itemsT = $objconfig->execute_select($queryT,1);

										foreach($itemsT[1] as $rowT)
										{
											$selected="";
											echo "<option value='".$rowT["idtipointervencion"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
										}
										?>
									</select>
								</div>
								<div class="col-md-1">
									<input type="button" onclick="agregar_antigrama();" class="btn btn-info"  value="Agregar" />
								</div>
							</div>
						</div>
					<br/>
					<div style="height:280px;  overflow-x:hidden;" >
				<div class="row">

				<div class="col-sm-12">
				<div class="panel panel-info ">
				
					<div class="panel-heading">Listado de Muestras Procesadas </div>
					
					<div class="panel-body table-responsive">
						<table class="table table-striped table-hover table-active table-condensed" id="tbdiagnostico" name="tbdiagnostico" >
							 <thead class="thead-light">

							<tr align ="center" class="bg-success">
								<td >#</td>
								<td >Zona</td>
								<td >Localidad.  </td>
								<td >V. INSP.  </td>
								<td >V. PROG.  </td>
								<td >Viviendas + </td>
								<td >M. Recib </td>
								<td  >C1</td>
								<td  >C1 +</td>
								<td  >C2</td>
								<td >C2 +</td>
								<td  >C3</td>
								<td  >C3 +</td>
								<td  >C4</td>
								<td >C4 +</td>
								<td >C5</td>
								<td >C5 +</td>
								<td  >C6</td>
								<td >C6 +</td>
								<td >C7</td>
								<td >C7 +</td>
								<td >C8</td>
								<td >C8 +</td>
								<td >Tipo Intervención</td>
								<td >Total Recip</td>
								<td >Total Positivos</td>
								<td ></td>
							</tr>

							</thead>
							<tbody>
							<?php
							$count_enf=0;
			  
							$sqlT = "select m.idconsolidado,m.idingresomuestra,m.codbarra,m.fecharecepcion,m.fechainicio, m.fechatermino, m.vprogram,
									m.idzona,m.localidad,m.vprogram,m.vinspec,m.c1, m.c1positivo,m.c2,m.c2positivo,m.c3, m.c3positivo,m.c4, m.mrecibida,
									m.c4positivo, m.c5,m.c5positivo,m.c6,m.c6positivo,m.c7, m.c7positivo,m.c8,m.c8positivo,m.rinspeccionado,
									m.rpositiva,m.vpositiva,z.descripcion as tzona, m.idtipointervencion, i.descripcion AS tinterven, m.vpositiva
						
									from consolidado_muestra as m
									inner join tipo_zona as z on(z.idzona=m.idzona)
									inner join tipo_intervencion as i ON (i.idtipointervencion = m.idtipointervencion)
									where m.idconsolidado=".$cod." order by  m.idzona";
						
							$rowTr = $objconfig->execute_select($sqlT,1);
							foreach($rowTr[1] as $rRt)
							{
								$count_enf++;
							//	$tp_int = $objconfig->execute_select("select descripcion from tipo_intervencion where idtipointervencion=".$rRt["idtipointervencion"]);
							
								?>
								<tr id='itemdiagnostico<?php echo $count_enf; ?>' name='itemdiagnostico<?php echo $count_enf; ?>' align ="center"  >
									<td >
										<input type='hidden' name='idconsolidado<?php echo $count_enf; ?>' id='idconsolidado<?php echo $count_enf; ?>' value='<?php echo $rRt["idconsolidado"]; ?>' />
										<?php echo $count_enf ; ?>
									</td>
									<td>
										<input type='hidden' name='idzona<?php echo $count_enf; ?>' id='idzona<?php echo $count_enf; ?>' value='<?php echo $rRt["idzona"]; ?>' />
										<?php echo strtoupper($rRt["tzona"] ); ?>
									</td>
									<td>
										<input type='hidden' name='localidad<?php echo $count_enf; ?>' id='localidad<?php echo $count_enf; ?>' value='<?php echo $rRt["localidad"]; ?>' />
										<?php echo strtoupper($rRt["localidad"] ); ?>
									</td>
									<td>
										<input type='hidden' name='vinspec<?php echo $count_enf; ?>' id='vinspec<?php echo $count_enf; ?>' value='<?php echo $rRt["vinspec"]; ?>' />
										<?php echo strtoupper($rRt["vinspec"] ); ?>
									</td>
									<td>
										<input type='hidden' name='vprogram<?php echo $count_enf; ?>' id='vprogram<?php echo $count_enf; ?>' value='<?php echo $rRt["vprogram"]; ?>' />
										<?php echo strtoupper($rRt["vprogram"] ); ?>
									</td>
									<td class="bg-danger">
										<input type='hidden' name='vpositiva<?php echo $count_enf; ?>' id='vpositiva<?php echo $count_enf; ?>' value='<?php echo $rRt["vpositiva"]; ?>' />
										<?php echo strtoupper($rRt["vpositiva"] ); ?>
									</td>
									<td>
										<input type='hidden' name='mrecibida<?php echo $count_enf; ?>' id='mrecibida<?php echo $count_enf; ?>' value='<?php echo $rRt["mrecibida"]; ?>' />
										<?php echo strtoupper($rRt["mrecibida"] ); ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='c1<?php echo $count_enf; ?>' id='c1<?php echo $count_enf; ?>' value='<?php echo $rRt["c1"]; ?>' />
										<?php echo strtoupper($rRt["c1"] ); ?>
									</td>
									<td class="bg-danger" >
										<input type='hidden' name='c1positivo<?php echo $count_enf; ?>' id='c1positivo<?php echo $count_enf; ?>' value='<?php echo $rRt["c1positivo"]; ?>' />
										<?php echo strtoupper($rRt["c1positivo"] ); ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='c2<?php echo $count_enf; ?>' id='c2<?php echo $count_enf; ?>' value='<?php echo $rRt["c2"]; ?>' />
										<?php echo strtoupper($rRt["c2"] ); ?>
									</td>
									<td class="bg-danger">
										<input type='hidden' name='c2positivo<?php echo $count_enf; ?>' id='c2positivo<?php echo $count_enf; ?>' value='<?php echo $rRt["c2positivo"]; ?>' />
										<?php echo strtoupper($rRt["c2positivo"] ); ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='c3<?php echo $count_enf; ?>' id='c3<?php echo $count_enf; ?>' value='<?php echo $rRt["c3"]; ?>' />
										<?php echo strtoupper($rRt["c3"] ); ?>
									</td>
									<td class="bg-danger">
										<input type='hidden' name='c3positivo<?php echo $count_enf; ?>' id='c3positivo<?php echo $count_enf; ?>' value='<?php echo $rRt["c3positivo"]; ?>' />
										<?php echo strtoupper($rRt["c3positivo"] ); ?> 
									</td>
									<td class="bg-info">
										<input type='hidden' name='c4<?php echo $count_enf; ?>' id='c4<?php echo $count_enf; ?>' value='<?php echo $rRt["c4"]; ?>' />
										<?php echo strtoupper($rRt["c4"] ); ?>
									</td>
									<td class="bg-danger">
										<input type='hidden' name='c4positivo<?php echo $count_enf; ?>' id='c4positivo<?php echo $count_enf; ?>' value='<?php echo $rRt["c4positivo"]; ?>' />
										<?php echo strtoupper($rRt["c4positivo"] ); ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='c5<?php echo $count_enf; ?>' id='c5<?php echo $count_enf; ?>' value='<?php echo $rRt["c5"]; ?>' />
										<?php echo strtoupper($rRt["c5"] ); ?>
									</td>
									<td class="bg-danger">
										<input type='hidden' name='c5positivo<?php echo $count_enf; ?>' id='c5positivo<?php echo $count_enf; ?>' value='<?php echo $rRt["c5positivo"]; ?>' />
										<?php echo strtoupper($rRt["c5positivo"] ); ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='c6<?php echo $count_enf; ?>' id='c6<?php echo $count_enf; ?>' value='<?php echo $rRt["c6"]; ?>' />
										<?php echo strtoupper($rRt["c6"] ); ?>
									</td>
									<td class="bg-danger">
										<input type='hidden' name='c6positivo<?php echo $count_enf; ?>' id='c6positivo<?php echo $count_enf; ?>' value='<?php echo $rRt["c6positivo"]; ?>' />
										<?php echo strtoupper($rRt["c6positivo"] ); ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='c7<?php echo $count_enf; ?>' id='c7<?php echo $count_enf; ?>' value='<?php echo $rRt["c7"]; ?>' />
										<?php echo strtoupper($rRt["c7"] ); ?>
									</td>
									<td class="bg-danger">
										<input type='hidden' name='c7positivo<?php echo $count_enf; ?>' id='c7positivo<?php echo $count_enf; ?>' value='<?php echo $rRt["c7positivo"]; ?>' />
										<?php echo strtoupper($rRt["c7positivo"] ); ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='c8<?php echo $count_enf; ?>' id='c8<?php echo $count_enf; ?>' value='<?php echo $rRt["c8"]; ?>' />
										<?php echo strtoupper($rRt["c8"] ); ?>
									</td>
									<td class="bg-danger">
										<input type='hidden' name='c8positivo<?php echo $count_enf; ?>' id='c8positivo<?php echo $count_enf; ?>' value='<?php echo $rRt["c8positivo"]; ?>' />
										<?php echo strtoupper($rRt["c8positivo"] ); ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='idtipointervencion<?php echo $count_enf; ?>' id='idtipointervencion<?php echo $count_enf; ?>' value='<?php echo $rRt["idtipointervencion"]; ?>' />
										<?php echo strtoupper($rRt["tinterven"] ); ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='rinspeccionado<?php echo $count_enf; ?>' id='rinspeccionado<?php echo $count_enf; ?>' value='<?php echo $rRt["rinspeccionado"]; ?>' />
										<?php echo strtoupper($rRt["rinspeccionado"] ); ?>
									</td>
									<td class="bg-danger">
										<input type='hidden' name='rpositiva<?php echo $count_enf; ?>' id='rpositiva<?php echo $count_enf; ?>' value='<?php echo $rRt["rpositiva"]; ?>' />
										<?php echo strtoupper($rRt["rpositiva"] ); ?>
									</td>
									<td >
									
										<img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_diagnostico(<?php echo $count_enf; ?>)' title='Borrar REgistro' />
									
									</td>
								</tr>
								
							<?php }?>
							</tbody>
							<tfoot class="">
							<tr align ="center" class="bg-success thead-light">
								<td >#</td>
								<td >Zona</td>
								<td >Localidad.  </td>
								<td >V. INSP.  </td>
								<td >V. PROG.  </td>
								<td >+ Viviendas</td>
								<td >M. Recib </td>
								<td  >C1</td>
								<td  >+ C1</td>
								<td  >C2</td>
								<td >+ C2</td>
								<td  >C3</td>
								<td  >+ C3</td>
								<td  >C4</td>
								<td >+ C4</td>
								<td >C5</td>
								<td >+ C5</td>
								<td  >C6</td>
								<td >+ C6</td>
								<td >C7</td>
								<td >+ C7</td>
								<td >C8</td>
								<td >+ C8</td>
								<td >Tipo Intervención</td>
								<td >Total Recip</td>
								<td >Total Positivos</td>
								<td ></td>
							</tr>
						  </tfoot>
						</table>
						<input type="hidden" id="contar_diagnostico" name="contar_diagnostico" value="<?php echo $count_enf; ?>" />
						<input type="hidden" id="contar_diagnostico2" name="contar_diagnostico2" value="<?php echo $count_enf; ?>" />
						<script> var  count_enf=<?php echo $count_enf; ?> </script>
						</div>
						</div>
						</div>
					</div>
				</div>
					<!--	<div class="row">
							<div class="col-md-12">
								
							</div>
						</div>
					-->
						<div class="row">
								<div class="col-md-12">
									<label for="atencion" class="control-label">Observaciones:  </label>
									<textarea name="0form_observacion" id="observacion" class="form-control " onkeyup="mayuscula(this);" rows="7" cols="120"><?php echo  $observacion;?></textarea>
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
   
function suma()
{
	var c1			=   $("#c1insp").val()
	var c1pos		=   $("#c1pos").val()
	var c2			=   $("#c2insp").val()
	var c2pos		=   $("#c2pos").val()
	var c3			=   $("#c3insp").val()
	var c3pos		=   $("#c3pos").val()
	var c4			=   $("#c4insp").val()
	var c4pos		=   $("#c4pos").val()
	var c5			=   $("#c5insp").val()
	var c5pos		=   $("#c5pos").val()
	var c6			=   $("#c6insp").val()
	var c6pos		=   $("#c6pos").val()
	var c7			=   $("#c7insp").val()
	var c7pos		=   $("#c7pos").val()
	var c8			=   $("#c8insp").val()
	var c8pos		=   $("#c8pos").val()
	var totainsp	=   parseInt(c1)+parseInt(c2)+parseInt(c3)+parseInt(c4)+parseInt(c5)+parseInt(c6)+parseInt(c7)+parseInt(c8)
	var totalposit	=   parseInt(c1pos)+parseInt(c2pos)+parseInt(c3pos)+parseInt(c4pos)+parseInt(c5pos)+parseInt(c6pos)+parseInt(c7pos)+parseInt(c8pos)
	
	//		document.getElementById(acumu).value = r;

	$("#trecip").val(totainsp)
	$("#tposit").val(totalposit)
	
}

 //<![CDATA[
    $(document).ready(function(){
        $('.combobox').combobox()
    });
    //]]>
	
</script>