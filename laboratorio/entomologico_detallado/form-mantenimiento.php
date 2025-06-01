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

        $establecimiento = $rowEstable[1]["codrenaes"]." - ".$rowEstable[1]["esta"]." / ".$rowEstable[1]["micro"]." / ".$rowEstable[1]["red"];
        $red_orig = $rowEstable[1]["idred"];
        $mred_orig = $rowEstable[1]["idmicrored"];
        $est_orig = $rowEstable[1]["idestablecimiento"];

        $Ups = "select  descripcion, provincia, departamento from vista_distrito where iddistrito=".$row[1]["iddistrito"]." ";
        $UpsOrg = $objconfig->execute_select($Ups);
        $nombre_distrito = $UpsOrg[1]["descripcion"]." / ".$UpsOrg[1]["provincia"]." / ".$UpsOrg[1]["departamento"];

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
				
				<h3 class="modal-title text-center">Registro de Ficha Entomológica - Muestras </h3>
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
							
								<div class="col-md-5">
									<input type="hidden" id="iddistrito" name="0form_iddistrito" value="<?=$row[1]["iddistrito"];?>"  />
									<input type="hidden" id="idprovincia" name="0form_idprovincia" value="<?=$row[1]["idprovincia"];?>"  />
									<input type="hidden" id="iddepartamento" name="0form_iddepartamento" value="<?=$row[1]["iddepartamento"];?>"  />
									<input for="atencion" type="text" name="nombre_distrito" id="nombre_distrito" onclick="buscar_distrito();" readonly="readonly"  value="<?php echo $nombre_distrito;?>" placeholder="Ingresa Nombre del Distrito" class=" form-control" />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Localidad:  </label>
								</div>
								<div class="col-md-3">
									<input type="text" id="local" name="0form_local" onkeyup="mayuscula(this);" value="<?php echo $row[1]["local"];?>" class="form-control"  />
								</div>
								
						        </div>
							</div>
								<br/>
						<div class="row">
							<div class="col-md-12">
							
								<div class="col-md-3">
									<label for="atencion" class="control-label">Inspector:  </label>
								</div>
								<div class="col-md-6">
									<input type="text" id="inspec" name="inspec" onkeyup="mayuscula(this);" value="" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Zona / Sector :  </label>
								</div>
								<div class="col-md-2">
									<select id="zon" name="zon" class=" form-control"   >
										<option value="0"></option>
										<?php
										$queryT = "select idzona,descripcion from tipo_zona  where estareg=1
													order by idzona asc";
										$itemsT = $objconfig->execute_select($queryT,1);

										foreach($itemsT[1] as $rowT)
										{
											$selected="";
											echo "<option value='".$rowT["idzona"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
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
									<label for="atencion" class="control-label">Manzana:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="mzn" name="mzn" onkeyup="mayuscula(this);" value="" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Direccion:  </label>
								</div>
								<div class="col-md-4">
									<input type="text" id="direc" name="direc" onkeyup="mayuscula(this);" value="" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Familia:  </label>
								</div>
								<div class="col-md-3">
									<input type="text" id="fam" name="fam" onkeyup="mayuscula(this);" value="" class="form-control"  />
								</div>
								
								
							</div>
						</div>
						<br/>
						<div class="row">
							<div class="col-md-12">
								
								<div class="col-md-1">
									<label for="atencion" class="control-label">Vivien Insp:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="vins" name="vins" onkeyup="mayuscula(this);" value="" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Vivien Prog:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="vprog" name="vprog" onkeyup="mayuscula(this);" value="" class="form-control"  />
								</div>
								<!--
								
								-->
								<div class="col-md-1">
									<label for="atencion" class="control-label">Interv:  </label>
								</div>
								<div class="col-md-3">
									<select id="iterven" name="iterven" class=" form-control"   >
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
									<label for="atencion" class="control-label">Larva:  </label>
								</div>
								<div class="col-md-1">
									<input type="text" id="larvas" name="larvas" value="0" class="form-control"  />
								</div>
												
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								
								<div class="col-md-1">
									<label for="atencion" class="control-label">Pupa:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="pupas" name="pupas" value="0" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Adulto:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" id="adultos" name="adultos" value="0" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Aedes Agipty:</label>
								</div>
								<div class="col-md-2">
									<input type="text" id="aedesag" name="aedesag" value="0" class="form-control"  />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Otros:  </label>
								</div>
								<div class="col-md-1">
									<input type="text" id="otros" name="otros" value="0" class="form-control"  />
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
				
					<div class="panel-heading">Lista de Muestras Recibidas </div>
					
					<div class="panel-body">
						<table class="table table-striped table-bordered table-hover table-responsive" id="tbdiagnostico" name="tbdiagnostico" >
							<thead>

							<tr align ="center">
								<td >#</td>
								<td >INSPECTOR</td>
								<td >ZONA</td>
								<td >DIRECCIÓN</td>
								<td >MANZANA</td>
								<td >FAMILIA  </td>
								<td >V. INSP.  </td>
								<td >V. PROG.  </td>
								<td >TIP. INTER  </td>
								<td >TIPO FOCO  </td>
								<td >LARVA  </td>
								<td >PUPA  </td>
								<td >ADULTO  </td>
								<td >AEDES A.  </td>
								<td >OTROS</td>
								<td >Recp Insp.</td>
								<td >Recp Positivo</td>
								<td ></td>
							</tr>

							</thead>
							<tbody>
							<?php
							$count_enf=0;
			  
							$sqlT = "select m.identomologia,m.inspector,m.manzana,m.direccion, m.familia,m.vinspec,m.idtipofoco,m.vprogam,m.rpositiva,
									m.larva,m.pupa,m.adulto,m.aedes, m.otro, m.idzona, z.descripcion as tzona, m.idtipointervencion, m.idtipofoco,m.rinspeccionado  
									from entomologia_muestra as m
									inner join tipo_zona as z on(z.idzona=m.idzona)
									where m.identomologia=".$cod." order by  m.idzona";
						
							$rowTr = $objconfig->execute_select($sqlT,1);
							foreach($rowTr[1] as $rRt)
							{
								$count_enf++;
								$tp_int = $objconfig->execute_select("select descripcion from tipo_intervencion where idtipointervencion=".$rRt["idtipointervencion"]);
							
								?>
								<tr id='itemdiagnostico<?php echo $count_enf; ?>' name='itemdiagnostico<?php echo $count_enf; ?>' >
									<td >
										<input type='hidden' name='identomologia<?php echo $count_enf; ?>' id='identomologia<?php echo $count_enf; ?>' value='<?php echo $rRt["identomologia"]; ?>' />
										<?php echo $count_enf ; ?>
									</td>
									<td>
										<input type='hidden' name='inspector<?php echo $count_enf; ?>' id='inspector<?php echo $count_enf; ?>' value='<?php echo $rRt["inspector"]; ?>' />
										<?php echo strtoupper($rRt["inspector"] ); ?>
									</td>
									<td>
										<input type='hidden' name='idzona<?php echo $count_enf; ?>' id='idzona<?php echo $count_enf; ?>' value='<?php echo $rRt["idzona"]; ?>' />
										<?php echo strtoupper($rRt["tzona"] ); ?>
									</td>
									<td>
										<input type='hidden' name='direccion<?php echo $count_enf; ?>' id='direccion<?php echo $count_enf; ?>' value='<?php echo $rRt["direccion"]; ?>' />
										<?php echo strtoupper($rRt["direccion"] ); ?>
									</td>
									<td>
										<input type='hidden' name='manzana<?php echo $count_enf; ?>' id='manzana<?php echo $count_enf; ?>' value='<?php echo $rRt["manzana"]; ?>' />
										<?php echo strtoupper($rRt["manzana"] ); ?>
									</td>
									<td>
										<input type='hidden' name='familia<?php echo $count_enf; ?>' id='familia<?php echo $count_enf; ?>' value='<?php echo $rRt["familia"]; ?>' />
										<?php echo strtoupper($rRt["familia"] ); ?>
									</td>
									<td>
										<input type='hidden' name='vinspec<?php echo $count_enf; ?>' id='vinspec<?php echo $count_enf; ?>' value='<?php echo $rRt["vinspec"]; ?>' />
										<?php echo strtoupper($rRt["vinspec"] ); ?>
									</td>
									<td>
										<input type='hidden' name='vprogam<?php echo $count_enf; ?>' id='vprogam<?php echo $count_enf; ?>' value='<?php echo $rRt["vprogam"]; ?>' />
										<?php echo strtoupper($rRt["vprogam"] ); ?>
									</td>
									<td>
										<input type='hidden' name='idtipointervencion<?php echo $count_enf; ?>' id='idtipointervencion<?php echo $count_enf; ?>' value='<?php echo $rRt["idtipointervencion"]; ?>' />
										<?php echo strtoupper($tp_int[1]["descripcion"] ); ?>
									</td>
									
									<td>
										<input type='hidden' name='idtipofoco<?php echo $count_enf; ?>' id='idtipofoco<?php echo $count_enf; ?>' value='<?php echo $rRt["idtipofoco"]; ?>' />
										<!-- <?php echo strtoupper($rRt["tipfoco"] ); ?> -->
										<input type="button" onclick="add_foco(<?php echo $count_enf; ?>);" class="btn btn-success"  value="Agregar" />
									</td>
									
									<td>
										<input type='hidden' name='larva<?php echo $count_enf; ?>' id='larva<?php echo $count_enf; ?>' value='<?php echo $rRt["larva"]; ?>' />
										<?php echo strtoupper($rRt["larva"] ); ?>
									</td>
									<td>
										<input type='hidden' name='pupa<?php echo $count_enf; ?>' id='pupa<?php echo $count_enf; ?>' value='<?php echo $rRt["pupa"]; ?>' />
										<?php echo strtoupper($rRt["pupa"] ); ?>
									</td>
									<td>
										<input type='hidden' name='adulto<?php echo $count_enf; ?>' id='adulto<?php echo $count_enf; ?>' value='<?php echo $rRt["adulto"]; ?>' />
										<?php echo strtoupper($rRt["adulto"] ); ?>
									</td>
									<td>
										<input type='hidden' name='aedes<?php echo $count_enf; ?>' id='aedes<?php echo $count_enf; ?>' value='<?php echo $rRt["aedes"]; ?>' />
										<?php echo strtoupper($rRt["aedes"] ); ?>
									</td>
									<td>
										<input type='hidden' name='otro<?php echo $count_enf; ?>' id='otro<?php echo $count_enf; ?>' value='<?php echo $rRt["otro"]; ?>' />
										<?php echo strtoupper($rRt["otro"] ); ?>
									</td>
									<td>
										<input type='hidden' name='rinspeccionado<?php echo $count_enf; ?>' id='rinspeccionado<?php echo $count_enf; ?>' value='<?php echo $rRt["rinspeccionado"]; ?>' />
										<?php echo strtoupper($rRt["rinspeccionado"] ); ?>
									</td>
									<td>
										<input type='hidden' name='rpositiva<?php echo $count_enf; ?>' id='rpositiva<?php echo $count_enf; ?>' value='<?php echo $rRt["rpositiva"]; ?>' />
										<?php echo strtoupper($rRt["rpositiva"] ); ?>
									</td>
									<td >
									<!--	<img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_diagnostico(<?php echo $count_enf; ?>)' title='Borrar REgistro' />
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
   
   
</script>