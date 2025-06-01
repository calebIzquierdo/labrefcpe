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
		$query = "select * from baciloscopia where idbaciloscopia=".$cod;
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
				
				<h3 class="modal-title text-center">Registro Baciloscópico </h3>
			</div>
			<div class="modal-body">
                <div class="col-md-12">

							<div class="row">
							<div class="col-md-12">
							<input type="hidden" name="1form_idbaciloscopia" id="codigo" value="<?=$row[1]["idbaciloscopia"]?>"   <?php echo $readonly; ?>   class="form-control"/>
							
							<div class="col-md-3">
							<label for="atencion" class="control-label">Codigo Barras</label>
							</div>
							<div class="col-md-3">
							<input type="text" name="0form_codbarra" id="codbarra" onkeyup="mayuscula(this);" onkeypress="return ValidaLongitud(this, 12);" class="form-control" value="<?=$row[1]["codbarra"]?>" onchange="buscar_renaes();" placeholder="Código de Barra" data-toggle="tooltip" data-placement="top" title=" Ingrese Código de Barra" />
							</div>
							<div class="col-md-3">
								<label>Fecha.</label>
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
							<div class="col-lg-6">
							 <!-- general form elements -->
							 <div class="panel panel-warning class ">
							<div class="card card-primary ">
							  <div class="card-header">
								<h3 class="card-title">N° Total de Laminas por Resultados</h3>
							  </div>
							  <!-- /.card-header -->
							  <!-- form start -->
							 <form class="form-horizontal">
								<div class="card-body">
								 <div class="form-group row">
									<label for="inputEmail3" class="col-sm-3 col-form-label">Laminas(+):</label>
									<div class="col-sm-7">
									  <input type="input" class="form-control" id="exampleInputEmail1" placeholder="Laminas Positivas">
									</div>
								  </div>
								  <div class="form-group row">
									<label for="inputPassword3" class="col-sm-3 col-form-label">Laminas(-)</label>
									<div class="col-sm-7">
									 <input type="input" class="form-control" id="exampleInputEmail1" placeholder="Laminas Negativas">
									</div>
								  </div>
								</div>
								<!-- /.card-body -->
							  </form>
							</div>
							</div>
			
			
			  	
							</div>
							  <div class="card">
							  <div class="card-header border-0">
								<div class="d-flex justify-content-between">
								  <h3 class="card-title">Calidad de Extendido de Lámina</h3>
								 </div>
							  </div>
							   <form class="form-horizontal">
								<div class="card-body">
								 <div class="form-group row">
									<label for="inputEmail3" class="col-sm-1 col-form-label">Bueno:</label>
									<div class="col-sm-2">
									  <input type="input" class="form-control" id="exampleInputEmail1" placeholder="Laminas Positivas">
									</div>
									<label for="inputPassword3" class="col-sm-1 col-form-label">Grueso</label>
									<div class="col-sm-2">
									 <input type="input" class="form-control" id="exampleInputEmail1" placeholder="Laminas Negativas">
									</div>
								  </div>
								  <div class="form-group row">
									<label for="inputPassword3" class="col-sm-2 col-form-label">Gruesodddd</label>
									<div class="col-sm-2">
									 <input type="input" class="form-control" id="exampleInputEmail1" placeholder="Laminas Negativas">
									</div>
								  </div>
								</div>
								<!-- /.card-body -->
							  </form>
							  
							  
								
              </div>
				<div class="col-sm-12">
				<div class="panel panel-warning class ">
					<div class="panel-heading">Nro Total de Laminas por Resultados</div>
				<div class="jumbotron jumbotron-fluid">
				
						
						<br/>
						
						
							<!--   -->
						</div>
						</div>
						</div>
						<br/>
						
							<div class="jumbotron jumbotron-fluid">
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
									<input type="text" name="lati" id="lati"   value=""  class=" form-control" data-toggle="tooltip" placeholder="Eje: -6.4841559334" data-placement="top" title="Eje: -6.484155933400012" />
								</div>
								<div class="col-md-1">
									<label for="atencion" class="control-label">Longitud:  </label>
								</div>
								<div class="col-md-2">
									<input type="text" name="longi" id="longi"   value=""  class=" form-control" placeholder="Eje: -76.382643169" data-toggle="tooltip" data-placement="top" title="Eje: -76.38264316911315" />
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
						<table class="table table-striped table-hover table-active table-condensed" id="tbdiagnostico" name="tbdiagnostico" >
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
			  
							$sqlT = "select m.idbaciloscopia,m.idingresomuestra,m.codbarra,m.poblacion,m.fecharecepcion,m.fechainicio, m.fechatermino, 
										m.fechrecojo,m.idzona,m.poblacion,m.idmanzana,m.familia,m.idinspector, m.idfoco,m.idlarva,m.idpupa,m.idadulto, 
										m.idbaciloscopia_a,m.idotros,z.descripcion as tzona, m.idtipointervencion, i.descripcion AS tinterven,
										p.nrodocumento ||' - '|| p.apellidos ||' '|| p.nombres as inspe_text, tf.codigo as tipfoco, m.localidad,
										m.totalviviendas, m.viviprogramadas,m.viviinspeccion,m.latitud,m.longitud ,m.direccion
										from aedes_muestra as m
										inner join tipo_zona as z on(z.idzona=m.idzona)
										inner join tipo_intervencion as i ON (i.idtipointervencion = m.idtipointervencion)
										inner join inspector as p ON (p.idinspector = m.idinspector)
										inner join tipo_foco as tf ON (tf.idfoco = m.idfoco)
										where m.idbaciloscopia=".$cod." order by  m.idzona";
						
							$rowTr = $objconfig->execute_select($sqlT,1);
							foreach($rowTr[1] as $rRt)
							{
								$count_enf++;
							//	$tp_int = $objconfig->execute_select("select descripcion from tipo_intervencion where idtipointervencion=".$rRt["idtipointervencion"]);
							
								?>
								<tr id='itemdiagnostico<?php echo $count_enf; ?>' name='itemdiagnostico<?php echo $count_enf; ?>' align ="center"  >
									<td >
										<input type='hidden' name='idbaciloscopia<?php echo $count_enf; ?>' id='idbaciloscopia<?php echo $count_enf; ?>' value='<?php echo $rRt["idbaciloscopia"]; ?>' />
										<?php echo $count_enf ; ?>
									</td>
									<td>
										<input type='hidden' name='localidad<?php echo $count_enf; ?>' id='localidad<?php echo $count_enf; ?>' value='<?php echo $rRt["localidad"]; ?>' />
										<?php echo strtoupper($rRt["localidad"] ); ?>
									</td>
									<td>
										<input type='hidden' name='totalviviendas<?php echo $count_enf; ?>' id='totalviviendas<?php echo $count_enf; ?>' value='<?php echo $rRt["totalviviendas"]; ?>' />
										<?php echo strtoupper($rRt["totalviviendas"] ); ?>
									</td>
									<td>
										<input type='hidden' name='viviprogramadas<?php echo $count_enf; ?>' id='viviprogramadas<?php echo $count_enf; ?>' value='<?php echo $rRt["viviprogramadas"]; ?>' />
										<?php echo strtoupper($rRt["viviprogramadas"] ); ?>
									</td>
									<td>
										<input type='hidden' name='viviinspeccion<?php echo $count_enf; ?>' id='viviinspeccion<?php echo $count_enf; ?>' value='<?php echo $rRt["viviinspeccion"]; ?>' />
										<?php echo strtoupper($rRt["viviinspeccion"] ); ?>
									</td>
									<td>
										<input type='hidden' name='idzona<?php echo $count_enf; ?>' id='idzona<?php echo $count_enf; ?>' value='<?php echo $rRt["idzona"]; ?>' />
										<?php echo strtoupper($rRt["tzona"] ); ?>
									</td>
									<td>
										<input type='hidden' name='fechrecojo<?php echo $count_enf; ?>' id='fechrecojo<?php echo $count_enf; ?>' value='<?php echo $rRt["fechrecojo"]; ?>' />
										<?php echo strtoupper($rRt["fechrecojo"] ); ?>
									</td>
									<td>
										<input type='hidden' name='idmanzana<?php echo $count_enf; ?>' id='idmanzana<?php echo $count_enf; ?>' value='<?php echo $rRt["idmanzana"]; ?>' />
										<?php echo strtoupper($rRt["idmanzana"] ); ?>
									</td>
									<td>
										<input type='hidden' name='familia<?php echo $count_enf; ?>' id='familia<?php echo $count_enf; ?>' value='<?php echo $rRt["familia"]; ?>' />
										<?php echo strtoupper($rRt["familia"] ); ?>
									</td>
									<td>
										<input type='hidden' name='direccion<?php echo $count_enf; ?>' id='direccion<?php echo $count_enf; ?>' value='<?php echo $rRt["direccion"]; ?>' />
										<?php echo strtoupper($rRt["direccion"] ); ?>
									</td>
									<td>
										<input type='hidden' name='latitud<?php echo $count_enf; ?>' id='latitud<?php echo $count_enf; ?>' value='<?php echo $rRt["latitud"]; ?>' />
										<?php echo strtoupper($rRt["latitud"] ); ?>
									</td>
									<td>
										<input type='hidden' name='longitud<?php echo $count_enf; ?>' id='longitud<?php echo $count_enf; ?>' value='<?php echo $rRt["longitud"]; ?>' />
										<?php echo strtoupper($rRt["longitud"] ); ?>
									</td>
									<td>
										<input type='hidden' name='idinspector<?php echo $count_enf; ?>' id='idinspector<?php echo $count_enf; ?>' value='<?php echo $rRt["idinspector"]; ?>' />
										<?php echo strtoupper($rRt["inspe_text"] ); ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='idfoco<?php echo $count_enf; ?>' id='idfoco<?php echo $count_enf; ?>' value='<?php echo $rRt["idfoco"]; ?>' />
										<?php echo strtoupper($rRt["tipfoco"] ); ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='idlarva<?php echo $count_enf; ?>' id='idlarva<?php echo $count_enf; ?>' value='<?php echo $rRt["idlarva"]; ?>' />
										<?php echo strtoupper($rRt["idlarva"] ); ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='idpupa<?php echo $count_enf; ?>' id='idpupa<?php echo $count_enf; ?>' value='<?php echo $rRt["idpupa"]; ?>' />
										<?php echo strtoupper($rRt["idpupa"] ); ?>
									</td>
									<td class="bg-info" >
										<input type='hidden' name='idadulto<?php echo $count_enf; ?>' id='idadulto<?php echo $count_enf; ?>' value='<?php echo $rRt["idadulto"]; ?>' />
										<?php echo strtoupper($rRt["idadulto"] ); ?>
									</td>
									<td class="bg-danger" >
										<input type='hidden' name='idbaciloscopia_a<?php echo $count_enf; ?>' id='idbaciloscopia_a<?php echo $count_enf; ?>' value='<?php echo $rRt["idbaciloscopia_a"]; ?>' />
										<?php echo strtoupper($rRt["idbaciloscopia_a"] ); ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='idotros<?php echo $count_enf; ?>' id='idotros<?php echo $count_enf; ?>' value='<?php echo $rRt["idotros"]; ?>' />
										<?php echo strtoupper($rRt["idotros"] ); ?>
									</td>

									<td >
									
										<img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_aedes(<?php echo $count_enf; ?>)' title='Borrar REgistro' />
									
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
						<input type="hidden" id="contar_diagnostico" name="contar_diagnostico" value="<?php echo $count_enf; ?>" />
						<input type="hidden" id="contar_diagnostico2" name="contar_diagnostico2" value="<?php echo $count_enf; ?>" />
						<script> var  count_enf=<?php echo $count_enf; ?> </script>
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
											if($rowT["idzona"]==$row[1]["idzona"]){$selected="selected='selected'";}
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
						
							<div class="panel-heading">Listado de Resipientes Inspeccionados</div>
							
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
					  
									$sqlR = "select m.idbaciloscopia,m.poblacion,m.localidad,m.totalviviendas, m.viviprogramadas,m.viviinspeccion,
											 m.idejecutora,m.idingresomuestra,m.codbarra,m.idzonainsp,m.fechrecojo,m.idtipointervencion,
											 m.c1insp,m.c2insp,m.c3insp,m.c4insp,m.c5insp,m.c6insp,m.c7insp,m.c8insp,z.descripcion as tzona, 
											 m.idtipointervencion, i.descripcion AS tinterven
											 from aedes_resipiente as m
											 inner join tipo_zona as z on(z.idzona=m.idzonainsp)
											 inner join tipo_intervencion as i ON (i.idtipointervencion = m.idtipointervencion)
											 where m.idbaciloscopia=".$cod." order by  m.idzonainsp";
							
									$rowR = $objconfig->execute_select($sqlR,1);
									foreach($rowR[1] as $rRt)
									{
										$count_resip++;
									//	$tp_int = $objconfig->execute_select("select descripcion from tipo_intervencion where idtipointervencion=".$rRt["idtipointervencion"]);
									
										?>
										<tr id='itemresipientes<?php echo $count_resip; ?>' name='itemresipientes<?php echo $count_resip; ?>' align ="center"  >
											<td >
												<input type='hidden' name='idbaciloscopia<?php echo $count_resip; ?>' id='idbaciloscopia<?php echo $count_resip; ?>' value='<?php echo $rRt["idbaciloscopia"]; ?>' />
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
							$count_enfC=0;
							$Vivinsp =0;
							$Vivinsp =0;
							
							$sqlC = " select m.idbaciloscopia,m.poblacion,m.localidad,m.totalviviendas, m.viviprogramadas AS vprogram,m.viviinspeccion as vinspec,
											 m.idejecutora,m.idingresomuestra,m.codbarra,m.idzonainsp,m.fechrecojo,m.idtipointervencion,
											 m.c1insp,m.c2insp,m.c3insp,m.c4insp,m.c5insp,m.c6insp,m.c7insp,m.c8insp,z.descripcion as tzona, 
											 m.idtipointervencion, i.descripcion AS tinterven
											 from aedes_resipiente as m
											 inner join tipo_zona as z on(z.idzona=m.idzonainsp)
											 inner join tipo_intervencion as i ON (i.idtipointervencion = m.idtipointervencion)
											 where m.idbaciloscopia=".$cod." order by  m.idzonainsp";
							
							$rowTC = $objconfig->execute_select($sqlC,1);
							foreach($rowTC[1] as $rRC)
							{
								$count_enfC++;
								//$vp = $objconfig->execute_select("select count(idbaciloscopia_a) as vpositiva from aedes_muestra where idbaciloscopia=".$rRC["idbaciloscopia"]);
								$vp = $objconfig->execute_select("select count(idbaciloscopia_a) as vpositiva from aedes_muestra where idbaciloscopia=".$rRC["idbaciloscopia"]." and idzona=".$rRC["idzonainsp"]." and idbaciloscopia_a>0" );
								$mr = $objconfig->execute_select("select count(idzona) as mrecibida from aedes_muestra where idbaciloscopia=".$rRC["idbaciloscopia"]."  and idzona=".$rRC["idzonainsp"]);
								$c1p = $objconfig->execute_select("select count(DISTINCT idmanzana) as c1positivo from aedes_muestra where idbaciloscopia=".$rRC["idbaciloscopia"]." and idfoco=1 and idzona=".$rRC["idzonainsp"]." and idbaciloscopia_a>0" );
								$c2p = $objconfig->execute_select("select count(DISTINCT idmanzana) as c2positivo from aedes_muestra where idbaciloscopia=".$rRC["idbaciloscopia"]." and idfoco=2 and idzona=".$rRC["idzonainsp"]." and idbaciloscopia_a>0" );
								$c3p = $objconfig->execute_select("select count(DISTINCT idmanzana) as c3positivo from aedes_muestra where idbaciloscopia=".$rRC["idbaciloscopia"]." and idfoco=3 and idzona=".$rRC["idzonainsp"]." and idbaciloscopia_a>0" );
								$c4p = $objconfig->execute_select("select count(DISTINCT idmanzana) as c4positivo from aedes_muestra where idbaciloscopia=".$rRC["idbaciloscopia"]." and idfoco=4 and idzona=".$rRC["idzonainsp"]." and idbaciloscopia_a>0" );
								$c5p = $objconfig->execute_select("select count(DISTINCT idmanzana) as c5positivo from aedes_muestra where idbaciloscopia=".$rRC["idbaciloscopia"]." and idfoco=5 and idzona=".$rRC["idzonainsp"]." and idbaciloscopia_a>0" );
								$c6p = $objconfig->execute_select("select count(DISTINCT idmanzana) as c6positivo from aedes_muestra where idbaciloscopia=".$rRC["idbaciloscopia"]." and idfoco=6 and idzona=".$rRC["idzonainsp"]." and idbaciloscopia_a>0" );
								$c7p = $objconfig->execute_select("select count(DISTINCT idmanzana) as c7positivo from aedes_muestra where idbaciloscopia=".$rRC["idbaciloscopia"]." and idfoco=7 and idzona=".$rRC["idzonainsp"]." and idbaciloscopia_a>0" );
								$c8p = $objconfig->execute_select("select count(DISTINCT idmanzana) as c8positivo from aedes_muestra where idbaciloscopia=".$rRC["idbaciloscopia"]." and idfoco=8 and idzona=".$rRC["idzonainsp"]." and idbaciloscopia_a>0" );
								$tipint = $objconfig->execute_select("select descripcion as tinterven from tipo_intervencion where idtipointervencion=(select idtipointervencion from aedes where idbaciloscopia=".$rRC["idbaciloscopia"].") " );
								$ttpos  = $c1p[1]["c1positivo"]+$c2p[1]["c2positivo"]+$c3p[1]["c3positivo"]+$c4p[1]["c4positivo"]+$c5p[1]["c5positivo"]+$c6p[1]["c6positivo"]+$c7p[1]["c7positivo"]+$c8p[1]["c8positivo"];
								
								$tRinsp  = $rRC["c1insp"]+$rRC["c2insp"]+$rRC["c3insp"]+$rRC["c4insp"]+$rRC["c5insp"]+$rRC["c6insp"]+$rRC["c7insp"]+$rRC["c8insp"];
								$indAed  = ($ttpos *100) / $rRC["vinspec"];
							
								?>
								<tr id='itemConsolidado<?php echo $count_enfC; ?>' name='itemdiagnosticoC<?php echo $count_enfC; ?>' align ="center"  >
									<td >
										<input type='hidden' name='idbaciloscopia<?php echo $count_enfC; ?>' id='idbaciloscopia<?php echo $count_enfC; ?>' value='<?php echo $rRC["idbaciloscopia"]; ?>' />
										<?php echo $count_enfC ; ?>
									</td>
									<td>
										<input type='hidden' name='idzona<?php echo $count_enfC; ?>' id='idzona<?php echo $count_enfC; ?>' value='<?php echo $rRC["idzonainsp"]; ?>' />
										<?php echo strtoupper($rRC["tzona"] ); ?>
									</td>
									<td>
										<input type='hidden' name='localidad<?php echo $count_enfC; ?>' id='localidad<?php echo $count_enfC; ?>' value='<?php echo $rRC["localidad"]; ?>' />
										<?php echo strtoupper($rRC["localidad"] ); ?>
									</td>
									<td>
										<input type='hidden' name='vprogram<?php echo $count_enfC; ?>' id='vprogram<?php echo $count_enfC; ?>' value='<?php echo $rRC["vprogram"]; ?>' />
										<?php echo strtoupper($rRC["vprogram"] ); ?>
									</td>
									<td>
										<input type='hidden' name='vinspec<?php echo $count_enfC; ?>' id='vinspec<?php echo $count_enfC; ?>' value='<?php echo $rRC["vinspec"]; ?>' />
										<?php echo strtoupper($rRC["vinspec"] ); ?>
									</td>
									
									<td class="bg-danger">
										<input type='hidden' name='vpositiva<?php echo $count_enfC; ?>' id='vpositiva<?php echo $count_enfC; ?>' value='<?php echo $vp[1]["vpositiva"]; ?>' />
										<?php echo $vp[1]["vpositiva"]; ?>
									</td>
									<td>
										<input type='hidden' name='mrecibida<?php echo $count_enfC; ?>' id='mrecibida<?php echo $count_enfC; ?>' value='<?php echo $mr[1]["mrecibida"]; ?>' />
										<?php echo strtoupper($mr[1]["mrecibida"] ); ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='indiceaedico<?php echo $count_enfC; ?>' id='indiceaedico<?php echo $count_enfC; ?>' value='<?php echo $indAed; ?>' class="form-control"/>
										<?php echo number_format($indAed,4) ; ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='c1<?php echo $count_enfC; ?>' id='c1<?php echo $count_enfC; ?>' value='<?php echo $rRC["c1insp"]; ?>' onkeyup="suma(<?=$count_enfC?>)" class="form-control"/>
										<?php echo $rRC["c1insp"]; ?>
									</td>
									<td class="bg-danger" >
										<input type='hidden' name='c1positivo<?php echo $count_enfC; ?>' id='c1positivo<?php echo $count_enfC; ?>' value='<?php echo $c1p[1]["c1positivo"]; ?>' />
										<?php echo $c1p[1]["c1positivo"]; ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='c2<?php echo $count_enfC; ?>' id='c2<?php echo $count_enfC; ?>' value='<?php echo $rRC["c2insp"]; ?>' onkeyup="suma(<?=$count_enfC?>)" class="form-control" />
										<?php echo $rRC["c2insp"]; ?>
									</td>
									<td class="bg-danger">
										<input type='hidden' name='c2positivo<?php echo $count_enfC; ?>' id='c2positivo<?php echo $count_enfC; ?>' value='<?php echo $rRC["c2positivo"]; ?>' />
										<?php echo $c2p[1]["c2positivo"]; ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='c3<?php echo $count_enfC; ?>' id='c3<?php echo $count_enfC; ?>' value='<?php echo $rRC["c3insp"]; ?>' onkeyup="suma(<?=$count_enfC?>)" class="form-control" />
										<?php echo $rRC["c3insp"]; ?>
									</td>
									<td class="bg-danger">
										<input type='hidden' name='c3positivo<?php echo $count_enfC; ?>' id='c3positivo<?php echo $count_enfC; ?>' value='<?php echo $rRC["c3positivo"]; ?>' />
										<?php echo $c3p[1]["c3positivo"]; ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='c4<?php echo $count_enfC; ?>' id='c4<?php echo $count_enfC; ?>' value='<?php echo $rRC["c4insp"]; ?>' onkeyup="suma(<?=$count_enfC?>)" class="form-control" />
										<?php echo $rRC["c4insp"]; ?>
									</td>
									<td class="bg-danger">
										<input type='hidden' name='c4positivo<?php echo $count_enfC; ?>' id='c4positivo<?php echo $count_enfC; ?>' value='<?php echo $rRC["c4positivo"]; ?>' />
										<?php echo $c4p[1]["c4positivo"]; ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='c5<?php echo $count_enfC; ?>' id='c5<?php echo $count_enfC; ?>' value='<?php echo $rRC["c5insp"]; ?>' onkeyup="suma(<?=$count_enfC?>)" class="form-control" />
										<?php echo $rRC["c5insp"]; ?>
									</td>
									<td class="bg-danger">
										<input type='hidden' name='c5positivo<?php echo $count_enfC; ?>' id='c5positivo<?php echo $count_enfC; ?>' value='<?php echo $rRC["c5positivo"]; ?>' />
										<?php echo $c5p[1]["c5positivo"]; ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='c6<?php echo $count_enfC; ?>' id='c6<?php echo $count_enfC; ?>' value='<?php echo $rRC["c6insp"]; ?>' onkeyup="suma(<?=$count_enfC?>)" class="form-control" />
										<?php echo $rRC["c6insp"]; ?>
									</td>
									<td class="bg-danger">
										<input type='hidden' name='c6positivo<?php echo $count_enfC; ?>' id='c6positivo<?php echo $count_enfC; ?>' value='<?php echo $rRC["c6positivo"]; ?>' />
										<?php echo $c6p[1]["c6positivo"]; ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='c7<?php echo $count_enfC; ?>' id='c7<?php echo $count_enfC; ?>' value='<?php echo $rRC["c7insp"]; ?>' onkeyup="suma(<?=$count_enfC?>)" class="form-control" />
										<?php echo $rRC["c7insp"]; ?>
									</td>
									<td class="bg-danger">
										<input type='hidden' name='c7positivo<?php echo $count_enfC; ?>' id='c7positivo<?php echo $count_enfC; ?>' value='<?php echo $rRC["c7positivo"]; ?>' />
										<?php echo $c7p[1]["c7positivo"]; ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='c8<?php echo $count_enfC; ?>' id='c8<?php echo $count_enfC; ?>' value='<?php echo $rRC["c8insp"]; ?>' onkeyup="suma(<?=$count_enfC?>)" class="form-control" />
										<?php echo $rRC["c8insp"]; ?>
									</td>
									<td class="bg-danger">
										<input type='hidden' name='c8positivo<?php echo $count_enfC; ?>' id='c8positivo<?php echo $count_enfC; ?>' value='<?php echo $rRC["c8positivo"]; ?>' />
										<?php echo $c8p[1]["c8positivo"]; ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='idtipointervencion<?php echo $count_enfC; ?>' id='idtipointervencion<?php echo $count_enfC; ?>' value='<?php echo $tipint[1]["tinterven"]; ?>' />
										<?php echo strtoupper($tipint[1]["tinterven"] ) ; ?>
									</td>
									<td class="bg-info">
										<input type='hidden' name='rinspeccionado<?php echo $count_enfC; ?>' id='rinspeccionado<?php echo $count_enfC; ?>' value='<?php echo $tRinsp; ?>' class="form-control"/>
										<?php echo $tRinsp ; ?>
									</td>
									<td class="bg-danger">
									
										<input type='hidden' name='rpositiva<?php echo $count_enfC; ?>' id='rpositiva<?php echo $count_enfC; ?>' value='<?php echo $ttpos; ?>' class="form-control" />
										<?php echo $ttpos; ?>
										
									</td>
									<td >
									<!--
										<img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_diagnostico(<?php echo $count_enfC; ?>)' title='Borrar REgistro' />
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
						<input type="hidden" id="contar_consolidado" name="contar_consolidado" value="<?php echo $count_enfC; ?>" />
						<input type="hidden" id="contar_consolidado2" name="contar_consolidado2" value="<?php echo $count_enfC; ?>" />
						<script> var  count_enfC=<?php echo $count_enfC; ?> </script>
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
                                <!--		<input type="hidden" name="user_id" id="user_id" />
                                        <input type="hidden" name="operation" id="operation" /> -->
                                <input type="button" onclick="validar_form();" name="action" id="action" class="btn btn-success"  value="Guardar" />
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