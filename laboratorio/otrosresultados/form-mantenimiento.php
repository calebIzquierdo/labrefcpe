}<?php
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
		$query = "select * from muestra where idingresomuestra=".$cod;
		$row = $objconfig->execute_select($query);

        $idorg_micro = $row[1]["idmicrored"];
        $idorg_estable =$row[1]["idestablecimiento"];
        $idsbare =$row[1]["idsubalimento"];

		$disable= "disabled";  
	
        $esta= "select idestablecimiento, eje,red, micro, esta,codrenaes from vista_establecimiento where idestablecimiento=".$row[1]["idestablesolicita"];
        $rowEstable = $objconfig->execute_select($esta);

        // $establecimiento = $rowEstable[1]["codrenaes"]." / ".$rowEstable[1]["esta"]." / ".$rowEstable[1]["micro"]." / ".$rowEstable[1]["red"]." / ".$rowEstable[1]["eje"];
        $establecimiento = $rowEstable[1]["codrenaes"]." - ".$rowEstable[1]["esta"]." / ".$rowEstable[1]["micro"]." / ".$rowEstable[1]["red"];
        $est_orig = $rowEstable[1]["idestablecimiento"];

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

	function Muestra(id, type)
	{
		$.ajax({
			type: "POST",
			url: carpeta+"consulta_muestra.php",
			data: "cod_barras="+id+"&type="+type,
			success: function(data) {
				var datos = JSON.parse(data);

				if(datos.idingresomuestra == null){
					$(".error-msg").html("</br><div class='alert alert-danger' role='alert'>Error... No se encontro registro de la muestra...</div>");
				} else {
					$(".error-msg").html("");
					$( "#action" ).prop( "disabled", false);

					$("#op").val(datos.op);
					$("#opcion").val(datos.opcion);
					$("#text-muestra").val(datos.codbarra);

					$("#idingresomuestra_view").val(datos.idingresomuestra);
					$("#nombre_usuario_view").val(datos.nombre_usuario);
					$("#idusuario_view").val(datos.idusuario);
					
					$("#idusuario_view").val(datos.idusuario);
					$("#nombre_usuario_view").val(datos.nombre_usuario);

					$("#idestablecimiento_view").val(datos.idestablecimiento);
					$("#establecimiento_view").val(datos.descripcion);
					
					$("#idcliente_view").val(datos.idcliente);
					$("#cliente_view").val(datos.ruc +' - '+datos.razonsocial);
					$("#edad_view").val(datos.edad);
					$("#sexo_view").val(datos.sexo);
					
					$("#medico_view").val(datos.medico);
					$("#idpersonal_view").val(datos.idpersonal);
					
					$("#enfermedad_view").val(datos.enfermedad);
					
					$("#fechareg_view").val(datos.fechareg);
					$("#fecha_recepcion_view").val(datos.fecharecepcion);

					$("#observacion_examen_view").val(datos.observaciones);

					var option = '<option value="0"></option>';
					$.each(datos.examenes, function(index, value) {
						var opt = '<option class="remove_option_view" value="'+value.idtipo_examen+'">'+value.examen+'</option>';
						option += opt;
					});
					$(".remove_option_view").remove();
					$("#idtipo_examen_view").html(option);

					$("#idtipo_examen_view").prop('disabled', false);
					$("#fecharegistro_view").prop('disabled', false);
					// $("#calender_view").prop('disabled', false);
					$("#valores_examen_view").prop('disabled', false);
					$("#resultado_examen_view").prop('disabled', false);
					$("#add_resultado").prop('disabled', false);

					if(datos.op == '1'){
						Resultados(datos.idingresomuestra);
					}
				}
			}
		});
	}

	function Resultados(id) {
		$.ajax({
			type: "POST",
			url: carpeta+"resultados.php",
			data: "muestra="+id,
			success: function(data) {
				$(".remove_view_resultado").remove();
				$("#tbresultados").html(data)

				$("#cancel_edit").hide();
				$("#add_resultado").prop('disabled', false);
				$("#idtipo_examen_view").prop('disabled', false);
			}
		});
	}

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
			<h3 class="modal-title text-success" align="center"> INFORME DE RESULTADO</h3>
		</div>
		<div class="error-msg col-md-12 content-center"></div>

		</br>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-7">
						<div class="form-group">
							<label for="idtipo_examen_view">Buscar Muestra:</label>
							<div class="input-group">
								<input type="hidden" id="op" name="op" class="form-control" />
								<input type="hidden" id="idingresomuestra_view" name="0form_idingresomuestra" class="form-control" />
								<input type="text" id="text-muestra" name="0form_codbarra" class="form-control" placeholder="Codigo barras">
								<span class="input-group-btn">
									<button class="btn btn-success" type="button" id="btn-muestra">Consultar</button>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="col-md-12">
						<div class="form-group">
							<label for="idtipo_examen_view">Establecimiento Solicitante:</label>
							<input type="hidden" id="idusuario_view" name="0form_idusuario" class="form-control" />
							<input type="hidden" id="nombre_usuario_view" name="0form_nombre_usuario" class="form-control" />
							<input type="hidden" id="idestablecimiento_view" name="0form_idestablecimiento" class="form-control" />
							<input type="text" id="establecimiento_view" readonly="readonly" class="form-control" />
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="col-md-7">
						<div class="form-group">
							<label for="cliente_view">Solicitane: </label>
							<input type="hidden" id="idcliente_view" name="0form_idcliente" class="form-control" />
							<input type="text" id="cliente_view" readonly="readonly" class="form-control" />
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label for="edad_view">Edad:</label>
							<input type="text" id="edad_view" name="0form_edad" class="form-control" />
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="sexo_view">Sexo: </label>
							<select id="sexo_view" name="0form_sexo" class="form-control" >
								<option value="F" selected>Femenino</option>
								<option value="M">Masculino</option>
							</select>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="col-md-12">
						<div class="form-group">
							<label for="medico_view">Médico:</label>
							<input type="hidden" id="idpersonal_view" name="0form_idpersonal" class="form-control" />
							<input type="text" id="medico_view" class="form-control"  readonly="readonly" onclick="buscar_medico();" />
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="col-md-12">
						<div class="form-group">
							<label for="enfermedad_view">Enfermedad: </label>
							<input type="text" id="enfermedad_view" name="0form_enfermdad" class="form-control" />
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="col-md-6">
						<div class="form-group">
							<label for="fechareg_view">Fecha Toma Muestra: </label>
							<div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
								<input class="form-control" type="text" id="fechareg_view" name="0form_fechareg">
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="fecha_recepcion_view">Fecha Recepcion Muestra: </label>
							<div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
								<input class="form-control" type="text" id="fecha_recepcion_view" name="0form_fecharecepcion">
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
					</div>
				</div>
			</div>

			
			
			</br>
			<hr>
			<div class="panel panel-success">
				<div class="panel-heading">Agregar resultados</div>
				<div class="row">
					</br>
					<div class="col-md-12">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-10 p-0 m-0">
									<div class="row">
										<div class="col-md-12">
											<div class="col-md-4">
												<div class="form-group">
													<input type="hidden" class="form-control" id="opcion" disabled>
													<input type="hidden" class="form-control" id="idotrosresultadosdet_view" disabled>
													<label for="idtipo_examen_view">Seleccionar exámen</label>
													<select id="idtipo_examen_view"  class="form-control" disabled >
													</select>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="fecharegistro_view">Fecha registro</label>
													<div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
														<input class="form-control" type="text" id="fecharegistro_view" disabled>
														<span class="input-group-addon" id="calender_view" disabled><span class="glyphicon glyphicon-calendar"></span></span>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="valores_examen_view">Valores</label>
													<input type="text" class="form-control" id="valores_examen_view" disabled>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="col-md-12">
												<div class="form-group">
													<label for="resultado_examen_view">Resultados</label>
													<textarea class="form-control" id="resultado_examen_view" rows="3" disabled></textarea>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-2 pt-1">
									<button type="button" onclick="validar_resultado();" id="add_resultado" class="btn btn-info btn-block" disabled>Agregar</button>
									<button type="button" onclick="cancelar();" id="cancel_edit" class="btn btn-danger btn-block">Cancelar</button>
								</div>
							</div>
						</div>
					</div>
				</div>	
			</div>

			</br>
			<div class="row">
				<div class="col-md-12">
					<div style="height:280px;  overflow-x:hidden;" >
						<div class="panel panel-info ">
							<div class="panel-heading">RESULTADOS DE EXAMENES </div>
							<div class="panel-body">
								<table class="table table-striped table-bordered table-hover table-responsive" id="tablaresultados">
									<thead>
										<tr>
											<td>Exámen</td>
											<td>F. Registro</td>
											<td>Valores</td>
											<td>Resultado</td>
											<td width="10%">Opción</td>
										</tr>
									</thead>
									<tbody id="tbresultados">
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
				<div class="col-md-12">
					<div class="col-md-12">
						<div class="form-group">
							<label for="fecha_recepcion_view">Observaciones: </label>
							<textarea class="form-control" id="observacion_examen_view" name="0form_observaciones" rows="5"></textarea>
						</div>
					</div>
				</div>
			</div>
		</br>
		<div class="upload-msg col-md-12"></div>

		<div class="modal-footer">
			<input type="button" onclick="validar_form();" name="action" id="action" class="btn btn-success"  value="Guardar" />
			<button type="button" onclick="regresar_index(carpeta);" class="btn btn-default" data-dismiss="modal" data-backdrop="false" > Cerrar </button>
		</div>
	</div>
</form>

<script type="text/javascript">

	$("#cancel_edit").hide();
	
	$('#btn-muestra').on('click', function (e) {
		Muestra($("#text-muestra").val(), 0);
	});

	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	});

</script>
