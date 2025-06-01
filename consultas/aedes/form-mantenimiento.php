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
				
				<h3 class="modal-title text-center">Registro de Aedes Aegypti</h3>
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
									<input for="atencion" type="text" name="nombre_distrito" id="nombre_distrito" onclick="buscar_distrito();" readonly="readonly"  value="<?php echo $rowDistri;?>" placeholder="Ingresa Nombre del Distrito" class=" form-control" />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Pobl:  </label>
								</div>
								<div class="col-md-2">
								<input type="text" id="poblacion" name="0form_poblacion" class=" form-control" onkeypress="return solonumeros(event);" value="<?=$row[1]["poblacion"];?>"  />
								</div>
								 </div>
								 </div>
									<br>
							<div class="jumbotron jumbotron-fluid">
							<div class="row">
								<div class="col-md-12">
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
								<div class="col-md-1">
									<label for="atencion" class="control-label">Localidad:  </label>
								</div>
								<div class="col-md-2">
								<input type="text" id="local" name="local" onkeyup="mayuscula(this);" class=" form-control"  value=""  />
								</div>
								<div class="col-md-1">
								<label for="atencion" class="control-label">Total Viviendas</label>
								</div>
								<div class="col-md-1">
									<input class="form-control" type="text" onkeypress="return solonumeros(event);" name="tvivi" id="tvivi" value="0"  >
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Viviendas Programad:</label>
								</div>
								<div class="col-md-1">
								<input type="text" id="viviprog" name="viviprog" onkeypress="return solonumeros(event);" class=" form-control"  value="0"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Viviendas Inspeccion:  </label>
								</div>
								<div class="col-md-1">
								<input type="text" id="vivinsp" name="vivinsp" onkeypress="return solonumeros(event);" class=" form-control"  value="0"  />
								</div>
								
								</div>
							</div>
							</br>
								<div class="row">
								<div class="col-md-12">
								
								<div class="col-md-1">
									<label for="atencion" class="control-label">Zona / Sector :  </label>
								</div>
								<div class="col-md-1">
								<select id="zona" name="zona" class="form-control"   >
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
								<input type="text" id="manz" name="manz" onkeyup="mayuscula(this);" class=" form-control"  value=""  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Familia:  </label>
								</div>
								<div class="col-md-4">
								<input type="text" id="fami" name="fami" class=" form-control" onkeyup="mayuscula(this);" value="" placeholder="Familia Inspeccionada" data-toggle="tooltip" data-placement="top" title="Familia Inspeccionada"  />
								</div>
								
								
								
								</div>
							</div>
							</br>
							<div class="row">
							<div class="col-md-12">
								<div class="col-md-1">
									<label for="atencion" class="control-label">Dirección:  </label>
								</div>
								<div class="col-md-5">
								<input type="text" name="direcc" id="direcc" onkeyup="mayuscula(this);" class="form-control" value="" placeholder="Direccion de la Vicienda" data-toggle="tooltip" data-placement="top" title="Dirección de la Vivienda" />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Latitud:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" name="lati" id="lati"   value="0"  class=" form-control" data-toggle="tooltip" placeholder="Eje: -6.4841559334" data-placement="top" title="Eje: -6.484155933400012" />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Longitud:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" name="longi" id="longi"   value="0"  class=" form-control" placeholder="Eje: -76.382643169" data-toggle="tooltip" data-placement="top" title="Eje: -76.38264316911315" />
								</div>
								
							</div>
						</div>
							</br>
							<div class="row">
							<div class="col-md-12">
								
								<div class="col-md-1">
									<label for="atencion" class="control-label">Inspector:  </label>
								</div>
								<div class="col-md-5">
									<input type="hidden" id="inspector" name="inspector" value="0"  />
									<input type="text" name="nombre_inspector" id="nombre_inspector" onclick="buscar_inspector();" readonly="readonly"  value="" placeholder="Click para Seleccionar Inspector" class=" form-control" />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Foco:  </label>
								</div>
								<div class="col-sm-2">
									<select id="foco" name="foco" class="form-control"   >
										<option value="0"></option>
										<?php
										$queryT = "select idfoco,codigo 
													from tipo_foco  where estareg=1
													order by codigo asc";
										$itemsT = $objconfig->execute_select($queryT,1);

										foreach($itemsT[1] as $rowT)
										{
											echo "<option value='".$rowT["idfoco"]."' ".$selected." >".strtoupper($rowT["codigo"])."</option>";
										}
										?>
									</select>
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Larvas:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="larva" name="larva" value="0" onkeypress="return solonumeros(event);" class="form-control"  />
								</div>
								
							</div>
						</div></br>
						<div class="row">
							<div class="col-md-12">
							<div class="col-md-1">
									<label for="atencion" class="control-label">Pupas:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="pupa" name="pupa" value="0" onkeypress="return solonumeros(event);" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Adultos:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="adulto" name="adulto" value="0" onkeypress="return solonumeros(event);" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Aedes:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="aedes" name="aedes" value="0" onkeypress="return solonumeros(event);" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Otros:  </label>
								</div>
								<div class="col-md-1">
									<input type="text" id="otros" name="otros" value="0" onkeypress="return solonumeros(event);" class="form-control"  />
								</div>		
								<div class="col-md-1">
									<input type="button" onclick="agregar_aedes();" class="btn btn-info"  value="Agregar" />
								</div>
							</div>
						</div>
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
								<td >LOCALIDAD</td>
								<td >T. V.</td>
								<td >V. PROG</td>
								<td >V. INSP.</td>
								<td >ZONA</td>
								<td >FECHA RECOJO</td>
								<td >MZ</td>
								<td >FAMILIA</td>
								<td >DIRECCIÓN</td>
								<td >LAT</td>
								<td >LON</td>
								<td >INSPECTOR</td>
								<td >FOCO</td>
								<td >LARVAS</td>
								<td >PUPAS</td>
								<td >ADULTOS</td>
								<td >AEDES</td>
								<td >OTROS</td>
								<td ></td>
							</tr>

							</thead>
							<tbody>
							<?php
							$count_enf=0;
			  
							$sqlT = "select m.idaedes,m.idingresomuestra,m.codbarra,m.poblacion,m.fecharecepcion,m.fechainicio, m.fechatermino, 
										m.fechrecojo,m.idzona,m.poblacion,m.idmanzana,m.familia,m.idinspector, m.idfoco,m.idlarva,m.idpupa,m.idadulto, 
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
										<input type='hidden' name='localidad<?=$count_enf;?>' id='localidad<?=$count_enf;?>' value='<?php echo $rRt["localidad"]; ?>' />
										<?php echo strtoupper($rRt["localidad"] ); ?>
									</td>
									<td>
										<input type='hidden' name='totalviviendas<?=$count_enf;?>' id='totalviviendas<?=$count_enf;?>' value='<?php echo $rRt["totalviviendas"]; ?>' />
										<?php echo strtoupper($rRt["totalviviendas"] ); ?>
									</td>
									<td>
										<input type='hidden' name='viviprogramadas<?=$count_enf;?>' id='viviprogramadas<?=$count_enf;?>' value='<?php echo $rRt["viviprogramadas"]; ?>' />
										<?php echo strtoupper($rRt["viviprogramadas"] ); ?>
									</td>
									<td>
										<input type='hidden' name='viviinspeccion<?=$count_enf;?>' id='viviinspeccion<?=$count_enf;?>' value='<?php echo $rRt["viviinspeccion"]; ?>' />
										<?php echo strtoupper($rRt["viviinspeccion"] ); ?>
									</td>
									<td>
										<input type='hidden' name='idzona<?=$count_enf;?>' id='idzona<?=$count_enf;?>' value='<?php echo $rRt["idzona"]; ?>' />
										<?php echo strtoupper($rRt["tzona"] ); ?>
									</td>
									<td>
										<input type='hidden' name='fechrecojo<?=$count_enf;?>' id='fechrecojo<?=$count_enf;?>' value='<?php echo $rRt["fechrecojo"]; ?>' />
										<?php echo strtoupper($rRt["fechrecojo"] ); ?>
									</td>
									<td>
										<input type='hidden' name='idmanzana<?=$count_enf;?>' id='idmanzana<?=$count_enf;?>' value='<?php echo $rRt["idmanzana"]; ?>' />
										<?php echo strtoupper($rRt["idmanzana"] ); ?>
									</td>
									<td>
										<input type='hidden' name='familia<?=$count_enf;?>' id='familia<?=$count_enf;?>' value='<?php echo $rRt["familia"]; ?>' />
										<?php echo strtoupper($rRt["familia"] ); ?>
									</td>
									<td>
										<input type='hidden' name='direccion<?=$count_enf;?>' id='direccion<?=$count_enf;?>' value='<?php echo $rRt["direccion"]; ?>' />
										<?php echo strtoupper($rRt["direccion"] ); ?>
									</td>
									<td>
										<input type='hidden' name='latitud<?=$count_enf;?>' id='latitud<?=$count_enf;?>' value='<?php echo $rRt["latitud"]; ?>' />
										<?php echo strtoupper($rRt["latitud"] ); ?>
									</td>
									<td>
										<input type='hidden' name='longitud<?=$count_enf;?>' id='longitud<?=$count_enf;?>' value='<?php echo $rRt["longitud"]; ?>' />
										<?php echo strtoupper($rRt["longitud"] ); ?>
									</td>
									<td>
										<input type='hidden' name='idinspector<?=$count_enf;?>' id='idinspector<?=$count_enf;?>' value='<?php echo $rRt["idinspector"]; ?>' />
										<?php echo strtoupper($rRt["inspe_text"] ); ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='idfoco<?=$count_enf;?>' id='idfoco<?=$count_enf;?>' value='<?php echo $rRt["idfoco"]; ?>' />
										<?php echo strtoupper($rRt["tipfoco"] ); ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='idlarva<?=$count_enf;?>' id='idlarva<?=$count_enf;?>' value='<?php echo $rRt["idlarva"]; ?>' />
										<?php echo strtoupper($rRt["idlarva"] ); ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='idpupa<?=$count_enf;?>' id='idpupa<?=$count_enf;?>' value='<?php echo $rRt["idpupa"]; ?>' />
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
								<td >LOCALIDAD</td>
								<td >T. V.</td>
								<td >V. PROG</td>
								<td >V. INSP.</td>
								<td >ZONA</td>
								<td >FECHA RECOJO</td>
								<td >MZ</td>
								<td >FAMILIA</td>
								<td >DIRECCIÓN</td>
								<td >LATITUD</td>
								<td >LONGITUD</td>
								<td >INSPECTOR</td>
								<td >FOCO</td>
								<td >LARVAS</td>
								<td >PUPAS</td>
								<td >ADULTOS</td>
								<td >AEDES</td>
								<td >OTROS</td>
								
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
								
				<div class="col-sm-12">
				<div class="panel panel-warning class ">
					<div class="panel-heading">Total de Recipientes Inspeccionados por Zona</div>
				<div class="jumbotron jumbotron-fluid">
				
						<div class="row">
							<div class="col-md-12">
							<div class="col-md-1">
									<label for="atencion" class="control-label">Zona / Sector :  </label>
								</div>
								<div class="col-md-1">
								<select id="zonains" name="zonains" class="form-control"   >
										<option value="0"></option>
										<?php
										$queryT = "select idzona,descripcion 
													from tipo_zona  where estareg=1
													order by descripcion asc";
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
									<label for="atencion" class="control-label">Insp C1:  </label>
								</div>
								<div class="col-md-1">
									<input type="text" id="c1ins" name="c1ins" onkeypress="return solonumeros(event);" value="0" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Insp C2:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="c2ins" name="c2ins" onkeypress="return solonumeros(event);" value="0" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Insp C3:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="c3ins" name="c3ins" onkeypress="return solonumeros(event);" value="0" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Insp C4:  </label>
								</div>
								<div class="col-md-1">
									<input type="text" id="c4ins" name="c4ins" onkeypress="return solonumeros(event);" value="0" class="form-control"  />
								</div>
									
								
							</div>
						</div>
						<br/>
						<div class="row">
							<div class="col-md-12">
							<div class="col-md-1">
									<label for="atencion" class="control-label">Insp C5:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="c5ins" name="c5ins" onkeypress="return solonumeros(event);" value="0" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Insp C6:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="c6ins" name="c6ins" onkeypress="return solonumeros(event);" value="0" class="form-control"  />
								</div>	
								<div class="col-md-1">
									<label for="atencion" class="control-label">Insp C7:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="c7ins" name="c7ins" onkeypress="return solonumeros(event);" value="0" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Insp C8:  </label>
								</div>
								<div class="col-md-1">
									<input type="text" id="c8ins" name="c8ins" onkeypress="return solonumeros(event);" value="0" class="form-control"  />
								</div>
								<div class="col-md-1">
									<input type="button" onclick="agregar_recipientes();" class="btn btn-info"  value="Agregar" />
								</div>
								
								
							</div>
						</div>
						<div style="height:280px;  overflow-x:hidden;" >
						<div class="row">

						<div class="col-sm-12">
						<div class="panel panel-warning class ">
						
							<div class="panel-heading">Listado de Recipientes Inspeccionados</div>
							
							<div class="panel-body table-responsive">
								<table class="table table-striped table-hover table-active table-condensed" id="tbresipientes" name="tbresipientes" >
									 <thead class="thead-light">

									<tr align ="center" class="bg-success">
										<td >#</td>
										<td >ZONA</td>
									<!--	<td >C0</td>  -->
										<td >C1</td>
										<td >C2</td>
										<td >C3</td>
										<td >C4</td>
										<td >C5</td>
										<td >C6</td>
										<td >C7</td>
										<td >C8</td>
										<td ></td>
									</tr>

									</thead>
									<tbody>
									<?php
									$count_resip=0;
					  
									$sqlR = "select m.idaedes,m.poblacion,m.localidad,m.totalviviendas, m.viviprogramadas,m.viviinspeccion,
											 m.idejecutora,m.idingresomuestra,m.codbarra,m.idzonainsp,m.fechrecojo,m.idtipointervencion,
											 m.c1insp,m.c2insp,m.c3insp,m.c4insp,m.c5insp,m.c6insp,m.c7insp,m.c8insp,z.descripcion as tzona, 
											 m.idtipointervencion, i.descripcion AS tinterven
											 from aedes_resipiente as m
											 inner join tipo_zona as z on(z.idzona=m.idzonainsp)
											 inner join tipo_intervencion as i ON (i.idtipointervencion = m.idtipointervencion)
											 where m.idaedes=".$cod." order by  m.idzonainsp";
							
									$rowR = $objconfig->execute_select($sqlR,1);
									foreach($rowR[1] as $rRt)
									{
										$count_resip++;
									//	$tp_int = $objconfig->execute_select("select descripcion from tipo_intervencion where idtipointervencion=".$rRt["idtipointervencion"]);
									
										?>
										<tr id='itemresipientes<?php echo $count_resip; ?>' name='itemresipientes<?php echo $count_resip; ?>' align ="center"  >
											<td >
												<input type='hidden' name='idaedes<?php echo $count_resip; ?>' id='idaedes<?php echo $count_resip; ?>' value='<?php echo $rRt["idaedes"]; ?>' />
												<?php echo $count_resip ; ?>
											</td>
											
											<td>
												<input type='hidden' name='idzonainsp<?php echo $count_resip; ?>' id='idzonainsp<?php echo $count_resip; ?>' value='<?php echo $rRt["idzonainsp"]; ?>' />
												<?php echo strtoupper($rRt["tzona"] ); ?>
											</td>
											<td>
												<input type='hidden' name='c1insp<?php echo $count_resip; ?>' id='c1insp<?php echo $count_resip; ?>' value='<?php echo $rRt["c1insp"]; ?>' />
												<?php echo strtoupper($rRt["c1insp"] ); ?>
											</td>
											<td>
												<input type='hidden' name='c2insp<?php echo $count_resip; ?>' id='c2insp<?php echo $count_resip; ?>' value='<?php echo $rRt["c2insp"]; ?>' />
												<?php echo strtoupper($rRt["c2insp"] ); ?>
											</td>
											<td>
												<input type='hidden' name='c3insp<?php echo $count_resip; ?>' id='c3insp<?php echo $count_resip; ?>' value='<?php echo $rRt["c3insp"]; ?>' />
												<?php echo strtoupper($rRt["c3insp"] ); ?>
											</td>
											<td>
												<input type='hidden' name='c4insp<?php echo $count_resip; ?>' id='c4insp<?php echo $count_resip; ?>' value='<?php echo $rRt["c4insp"]; ?>' />
												<?php echo strtoupper($rRt["c4insp"] ); ?>
											</td>
											<td>
												<input type='hidden' name='c5insp<?php echo $count_resip; ?>' id='c5insp<?php echo $count_resip; ?>' value='<?php echo $rRt["c5insp"]; ?>' />
												<?php echo strtoupper($rRt["c5insp"] ); ?>
											</td>
											<td >
												<input type='hidden' name='c6insp<?php echo $count_resip; ?>' id='c6insp<?php echo $count_resip; ?>' value='<?php echo $rRt["c6insp"]; ?>' />
												<?php echo strtoupper($rRt["c6insp"] ); ?>
											</td>
											<td>
												<input type='hidden' name='c7insp<?php echo $count_resip; ?>' id='c7insp<?php echo $count_resip; ?>' value='<?php echo $rRt["c7insp"]; ?>' />
												<?php echo strtoupper($rRt["c7insp"] ); ?>
											</td>
											<td >
												<input type='hidden' name='c8insp<?php echo $count_resip; ?>' id='c8insp<?php echo $count_resip; ?>' value='<?php echo $rRt["c8insp"]; ?>' />
												<?php echo strtoupper($rRt["c8insp"] ); ?>
											</td>
											<td >
											
												<img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_recipiente(<?php echo $count_resip; ?>)' title='Borrar REgistro' />
											
											</td>
										</tr>
										
									<?php }?>
									</tbody>
									<tfoot class="">
									<tr align ="center" class="bg-success thead-light">
										<td >#</td>
										<td >ZONA</td>
									<!--	<td >C0</td> -->
										<td >C1</td>
										<td >C2</td>
										<td >C3</td>
										<td >C4</td>
										<td >C5</td>
										<td >C6</td>
										<td >C7</td>
										<td >C8</td>
										<td ></td>
									</tr>
								  </tfoot>
								</table>
								<input type="hidden" id="contar_recipiente" name="contar_recipiente" value="<?php echo $count_resip; ?>" />
								<input type="hidden" id="contar_recipiente2" name="contar_recipiente2" value="<?php echo $count_resip; ?>" />
								<script> var  count_resip=<?php echo $count_resip; ?> </script>
								</div>
								</div>
								</div>
							</div>
							</div>
							<!--   -->
						</div>
						</div>
						</div>
						<br/>
				<!--- Consolidado de Aedes Aegipti -->
				
				
				<div class="col-sm-12">
				<div class="panel panel-primary  class ">
				<div class="panel-heading">Consolidado de Muestras Procesadas</div>
				<br/>						
				<div style="height:280px;  overflow-x:hidden;" >
				<div class="row">
				<div class="col-sm-12">
				<div class="panel panel-class ">
				<div class="panel-body table-responsive">
						<table class="table table-striped table-hover table-active table-condensed" id="tbConsolidado" name="tbConsolidado" >
							 <thead class="thead-light">

							<tr align ="center" class="bg-success">
								<td >#</td>
								<td >Zona</td>
								<td >Localidad.  </td>
								<td >V. PROG.  </td>
								<td >V. INSP.  </td>
								<td >Viviendas + </td>
								<td >M. Recib </td>
								<td  >I. AED.</td>
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
							$count_Consolidado=0;
							$Vivinsp =0;
							$Vivinsp =0;
							
							$sqlC = " select m.idaedes,m.poblacion,m.localidad,m.totalviviendas, m.viviprogramadas AS vprogram,m.viviinspeccion as vinspec,
											 m.idejecutora,m.idingresomuestra,m.codbarra,m.idzonainsp,m.fechrecojo,m.idtipointervencion,
											 m.c1insp,m.c2insp,m.c3insp,m.c4insp,m.c5insp,m.c6insp,m.c7insp,m.c8insp,z.descripcion as tzona, 
											 m.idtipointervencion, i.descripcion AS tinterven
											 from aedes_resipiente as m
											 inner join tipo_zona as z on(z.idzona=m.idzonainsp)
											 inner join tipo_intervencion as i ON (i.idtipointervencion = m.idtipointervencion)
											 where m.idaedes=".$cod." order by  m.idzonainsp";
							
							$rowTC = $objconfig->execute_select($sqlC,1);
							foreach($rowTC[1] as $rRC)
							{
								$count_Consolidado++;
								//$vp = $objconfig->execute_select("select count(idaedes_a) as vpositiva from aedes_muestra where idaedes=".$rRC["idaedes"]);
								$vp = $objconfig->execute_select("select COUNT( DISTINCT ( idmanzana,familia,direccion)) as vpositiva from aedes_muestra where idaedes=".$rRC["idaedes"]." and idzona=".$rRC["idzonainsp"]." and idaedes_a!=0" );
								$mr = $objconfig->execute_select("select count(*) as mrecibida from aedes_muestra where idaedes=".$rRC["idaedes"]." and idfoco !=9 and idzona=".$rRC["idzonainsp"]);
								$c1p = $objconfig->execute_select("select COUNT( DISTINCT (idmanzana,familia,direccion)) as c1positivo from aedes_muestra where idaedes=".$rRC["idaedes"]." and idfoco=1 and idzona=".$rRC["idzonainsp"]." and idaedes_a!=0 " );
								$c2p = $objconfig->execute_select("select COUNT( DISTINCT (idmanzana,familia,direccion)) as c2positivo from aedes_muestra where idaedes=".$rRC["idaedes"]." and idfoco=2 and idzona=".$rRC["idzonainsp"]." and idaedes_a!=0 " );
								$c3p = $objconfig->execute_select("select COUNT( DISTINCT (idmanzana,familia,direccion)) as c3positivo from aedes_muestra where idaedes=".$rRC["idaedes"]." and idfoco=3 and idzona=".$rRC["idzonainsp"]." and idaedes_a!=0 " );
								$c4p = $objconfig->execute_select("select COUNT( DISTINCT (idmanzana,familia,direccion)) as c4positivo from aedes_muestra where idaedes=".$rRC["idaedes"]." and idfoco=4 and idzona=".$rRC["idzonainsp"]." and idaedes_a!=0 " );
								$c5p = $objconfig->execute_select("select COUNT( DISTINCT (idmanzana,familia,direccion)) as c5positivo from aedes_muestra where idaedes=".$rRC["idaedes"]." and idfoco=5 and idzona=".$rRC["idzonainsp"]." and idaedes_a!=0 " );
								$c6p = $objconfig->execute_select("select COUNT( DISTINCT (idmanzana,familia,direccion)) as c6positivo from aedes_muestra where idaedes=".$rRC["idaedes"]." and idfoco=6 and idzona=".$rRC["idzonainsp"]." and idaedes_a!=0 " );
								$c7p = $objconfig->execute_select("select COUNT( DISTINCT (idmanzana,familia,direccion)) as c7positivo from aedes_muestra where idaedes=".$rRC["idaedes"]." and idfoco=7 and idzona=".$rRC["idzonainsp"]." and idaedes_a!=0 " );
								$c8p = $objconfig->execute_select("select COUNT( DISTINCT (idmanzana,familia,direccion)) as c8positivo from aedes_muestra where idaedes=".$rRC["idaedes"]." and idfoco=8 and idzona=".$rRC["idzonainsp"]." and idaedes_a!=0 " );
								$tipint = $objconfig->execute_select("select descripcion as tinterven from tipo_intervencion where idtipointervencion=(select idtipointervencion from aedes where idaedes=".$rRC["idaedes"].") " );
								$ttpos  = $c1p[1]["c1positivo"]+$c2p[1]["c2positivo"]+$c3p[1]["c3positivo"]+$c4p[1]["c4positivo"]+$c5p[1]["c5positivo"]+$c6p[1]["c6positivo"]+$c7p[1]["c7positivo"]+$c8p[1]["c8positivo"];
								
								$tRinsp  = $rRC["c1insp"]+$rRC["c2insp"]+$rRC["c3insp"]+$rRC["c4insp"]+$rRC["c5insp"]+$rRC["c6insp"]+$rRC["c7insp"]+$rRC["c8insp"];
								$indAed  = ($ttpos *100) / $rRC["vinspec"];
							
								?>
								<tr id='itemConsolidado<?php echo $count_Consolidado; ?>' name='itemdiagnosticoC<?php echo $count_Consolidado; ?>' align ="center"  >
									<td >
										<input type='hidden' name='idaedes<?php echo $count_Consolidado; ?>' id='idaedes<?php echo $count_Consolidado; ?>' value='<?php echo $rRC["idaedes"]; ?>' />
										<?php echo $count_Consolidado ; ?>
									</td>
									<td>
										<input type='hidden' name='idzonaCons<?php echo $count_Consolidado; ?>' id='idzonaCons<?php echo $count_Consolidado; ?>' value='<?php echo $rRC["idzonainsp"]; ?>' />
										<?php echo strtoupper($rRC["tzona"] ); ?>
									</td>
									<td>
										<input type='hidden' name='localidadCons<?php echo $count_Consolidado; ?>' id='localidadCons<?php echo $count_Consolidado; ?>' value='<?php echo $rRC["localidad"]; ?>' />
										<?php echo strtoupper($rRC["localidad"] ); ?>
									</td>
									<td>
										<input type='hidden' name='vprogramCons<?php echo $count_Consolidado; ?>' id='vprogramCons<?php echo $count_Consolidado; ?>' value='<?php echo $rRC["vprogram"]; ?>' />
										<?php echo strtoupper($rRC["vprogram"] ); ?>
									</td>
									<td>
										<input type='hidden' name='vinspecCons<?php echo $count_Consolidado; ?>' id='vinspecCons<?php echo $count_Consolidado; ?>' value='<?php echo $rRC["vinspec"]; ?>' />
										<?php echo strtoupper($rRC["vinspec"] ); ?>
									</td>
									
									<td class="bg-danger">
										<input type='hidden' name='vpositivaCons<?php echo $count_Consolidado; ?>' id='vpositivaCons<?php echo $count_Consolidado; ?>' value='<?php echo $vp[1]["vpositiva"]; ?>' />
										<?php echo $vp[1]["vpositiva"]; ?>
									</td>
									<td>
										<input type='hidden' name='mrecibidaCons<?php echo $count_Consolidado; ?>' id='mrecibidaCons<?php echo $count_Consolidado; ?>' value='<?php echo $mr[1]["mrecibida"]; ?>' />
										<?php echo strtoupper($mr[1]["mrecibida"] ); ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='indiceaedicoCons<?php echo $count_Consolidado; ?>' id='indiceaedicoCons<?php echo $count_Consolidado; ?>' value='<?php echo $indAed; ?>' class="form-control"/>
										<?php echo number_format($indAed,4) ; ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='c1Cons<?php echo $count_Consolidado; ?>' id='c1Cons<?php echo $count_Consolidado; ?>' value='<?php echo $rRC["c1insp"]; ?>' onkeyup="suma(<?=$count_Consolidado?>)" class="form-control"/>
										<?php echo $rRC["c1insp"]; ?>
									</td>
									<td class="bg-danger" >
										<input type='hidden' name='c1positivoCons<?php echo $count_Consolidado; ?>' id='c1positivoCons<?php echo $count_Consolidado; ?>' value='<?php echo $c1p[1]["c1positivo"]; ?>' />
										<?php echo $c1p[1]["c1positivo"]; ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='c2Cons<?php echo $count_Consolidado; ?>' id='c2Cons<?php echo $count_Consolidado; ?>' value='<?php echo $rRC["c2insp"]; ?>' onkeyup="suma(<?=$count_Consolidado?>)" class="form-control" />
										<?php echo $rRC["c2insp"]; ?>
									</td>
									<td class="bg-danger">
										<input type='hidden' name='c2positivoCons<?php echo $count_Consolidado; ?>' id='c2positivoCons<?php echo $count_Consolidado; ?>' value='<?php echo $rRC["c2positivo"]; ?>' />
										<?php echo $c2p[1]["c2positivo"]; ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='c3Cons<?php echo $count_Consolidado; ?>' id='c3Cons<?php echo $count_Consolidado; ?>' value='<?php echo $rRC["c3insp"]; ?>' onkeyup="suma(<?=$count_Consolidado?>)" class="form-control" />
										<?php echo $rRC["c3insp"]; ?>
									</td>
									<td class="bg-danger">
										<input type='hidden' name='c3positivoCons<?php echo $count_Consolidado; ?>' id='c3positivoCons<?php echo $count_Consolidado; ?>' value='<?php echo $rRC["c3positivo"]; ?>' />
										<?php echo $c3p[1]["c3positivo"]; ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='c4Cons<?php echo $count_Consolidado; ?>' id='c4Cons<?php echo $count_Consolidado; ?>' value='<?php echo $rRC["c4insp"]; ?>' onkeyup="suma(<?=$count_Consolidado?>)" class="form-control" />
										<?php echo $rRC["c4insp"]; ?>
									</td>
									<td class="bg-danger">
										<input type='hidden' name='c4positivoCons<?php echo $count_Consolidado; ?>' id='c4positivoCons<?php echo $count_Consolidado; ?>' value='<?php echo $rRC["c4positivo"]; ?>' />
										<?php echo $c4p[1]["c4positivo"]; ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='c5Cons<?php echo $count_Consolidado; ?>' id='c5Cons<?php echo $count_Consolidado; ?>' value='<?php echo $rRC["c5insp"]; ?>' onkeyup="suma(<?=$count_Consolidado?>)" class="form-control" />
										<?php echo $rRC["c5insp"]; ?>
									</td>
									<td class="bg-danger">
										<input type='hidden' name='c5positivoCons<?php echo $count_Consolidado; ?>' id='c5positivoCons<?php echo $count_Consolidado; ?>' value='<?php echo $rRC["c5positivo"]; ?>' />
										<?php echo $c5p[1]["c5positivo"]; ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='c6Cons<?php echo $count_Consolidado; ?>' id='c6Cons<?php echo $count_Consolidado; ?>' value='<?php echo $rRC["c6insp"]; ?>' onkeyup="suma(<?=$count_Consolidado?>)" class="form-control" />
										<?php echo $rRC["c6insp"]; ?>
									</td>
									<td class="bg-danger">
										<input type='hidden' name='c6positivoCons<?php echo $count_Consolidado; ?>' id='c6positivoCons<?php echo $count_Consolidado; ?>' value='<?php echo $rRC["c6positivo"]; ?>' />
										<?php echo $c6p[1]["c6positivo"]; ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='c7Cons<?php echo $count_Consolidado; ?>' id='c7Cons<?php echo $count_Consolidado; ?>' value='<?php echo $rRC["c7insp"]; ?>' onkeyup="suma(<?=$count_Consolidado?>)" class="form-control" />
										<?php echo $rRC["c7insp"]; ?>
									</td>
									<td class="bg-danger">
										<input type='hidden' name='c7positivoCons<?php echo $count_Consolidado; ?>' id='c7positivoCons<?php echo $count_Consolidado; ?>' value='<?php echo $rRC["c7positivo"]; ?>' />
										<?php echo $c7p[1]["c7positivo"]; ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='c8Cons<?php echo $count_Consolidado; ?>' id='c8Cons<?php echo $count_Consolidado; ?>' value='<?php echo $rRC["c8insp"]; ?>' onkeyup="suma(<?=$count_Consolidado?>)" class="form-control" />
										<?php echo $rRC["c8insp"]; ?>
									</td>
									<td class="bg-danger">
										<input type='hidden' name='c8positivoCons<?php echo $count_Consolidado; ?>' id='c8positivoCons<?php echo $count_Consolidado; ?>' value='<?php echo $rRC["c8positivo"]; ?>' />
										<?php echo $c8p[1]["c8positivo"]; ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='idtipointervencionCons<?php echo $count_Consolidado; ?>' id='idtipointervencionCons<?php echo $count_Consolidado; ?>' value='<?php echo $tipint[1]["tinterven"]; ?>' />
										<?php echo strtoupper($tipint[1]["tinterven"] ) ; ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='rinspeccionadoCons<?php echo $count_Consolidado; ?>' id='rinspeccionadoCons<?php echo $count_Consolidado; ?>' value='<?php echo $tRinsp; ?>' class="form-control"/>
										<?php echo $tRinsp ; ?>
									</td>
									<td class="bg-danger">
									
										<input type='hidden' name='rpositivaCons<?php echo $count_Consolidado; ?>' id='rpositivaCons<?php echo $count_Consolidado; ?>' value='<?php echo $ttpos; ?>' class="form-control" />
										<?php echo $ttpos; ?>
										
									</td>
									<td >
									<!--
										<img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_diagnostico(<?php echo $count_Consolidado; ?>)' title='Borrar REgistro' />
									-->
									</td>
								</tr>
								
							<?php 
								
							}?>
							</tbody>
							<tfoot class="">
							
							<tr align ="center" class="bg-success thead-light">
								<td >#</td>
								<td >Zona</td>
								<td >Localidad.  </td>
								<td >V. PROG.  </td>
								<td >V. INSP.  </td>
								<td >+ Viviendas</td>
								<td >M. Recib </td>
								<td  >I. AED.</td>
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
						<input type="hidden" id="contar_consolidado" name="contar_consolidado" value="<?php echo $count_Consolidado; ?>" />
						<input type="hidden" id="contar_consolidado2" name="contar_consolidado2" value="<?php echo $count_Consolidado; ?>" />
						<script> var  count_Consolidado=<?php echo $count_Consolidado; ?> </script>
						</div>
						
						</div>
					</div>
				</div>
					<!--	<div class="row">
							<div class="col-md-12">
								
							</div>
						</div>
					-->
					</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="col-md-2">
								<label for="atencion" class="control-label">N° Documento:</label>
							</div>
							<div class="col-md-4">
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