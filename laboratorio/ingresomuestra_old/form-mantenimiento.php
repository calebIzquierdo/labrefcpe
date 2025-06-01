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
		$query = "select * from muestra where idingresomuestra=".$cod;
		$row = $objconfig->execute_select($query);

        $idorg_micro = $row[1]["idmicrored"];
        $idorg_estable =$row[1]["idestablecimiento"];
        $idsbare =$row[1]["idsubalimento"];

		$disable= "disabled";  
	
        $esta= "select idestablecimiento, eje,red, micro, esta,codrenaes from vista_establecimiento where idestablecimiento=".$row[1]["idestablesolicita"];
        $rowEstable = $objconfig->execute_select($esta);

        //$establecimiento = $rowEstable[1]["codrenaes"]." / ".$rowEstable[1]["esta"]." / ".$rowEstable[1]["micro"]." / ".$rowEstable[1]["red"]." / ".$rowEstable[1]["eje"];
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

 
 function sub_alimentos(id,idsb)
 {
	$.ajax({
		type: "POST",
		url: carpeta+"subalimentos.php",
		data: "id="+id+"&idsub="+idsb,
		success: function(data) {
		$("#div-alimentos").html(data)
	 }
	});
 }

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
				<h3 class="modal-title text-success" align="center"> REGISTRO DE RECEPCIÓN DE MUESTRA</h3>
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

				<input type="hidden" name="0form_idtipo" id="idtipo" value="<?php echo $op; ?>"  />
				<input type="hidden" name="op" id="op" value="<?php echo $op; ?>"  />
				<input type="hidden" name="0form_idusuario" id="idusuario" value="<?=$idusuario[0]?>"  />
				<input type="hidden" name="0form_idusuario" id="idusuario" value="<?php echo $iduser; ?>"  />
				<input type="hidden" name="0form_nombre_usuario" id="nombre_usuario" value="<?=$idusuario[1]?>"  />
			</div>
			<div class="modal-body">
			<div class="row">
				<div class="col-md-12">
				 <div class="col-md-2">
						<label for="atencion" class="control-label">N°. Ficha</label>
                    </div>
					 <div class="col-md-2">
						<input type="text" name="1form_idingresomuestra" id="codigo" value="<?=$row[1]["idingresomuestra"]?>" <?php echo $readonly;?>   class="form-control"/>
                    </div>
					<div class="col-md-1">
                        <label>Fecha Rec.</label>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2" onchange="CalcularEdad(<?php echo $row[1]["idpaciente"];?>);" data-link-format="yyyy-mm-dd">
                            <input class="form-control" type="text" name="0form_fecharecepcion" id="fecharecepcion" value="<?php echo ($row[1]["fecharecepcion"])?$objconfig->FechaDMY2($row[1]["fecharecepcion"]):date("d/m/Y");?>"  readonly>
                         <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                       
                        </div>
                    </div>
					<div class="col-md-1">
						<label for="atencion" class="control-label">Tipo Atención</label>
                    </div>
					 <div class="col-md-3">
						<select id="idtipoatencion" name="0form_idtipoatencion" class="form-control"  >
						<option value="0"></option>
						   <?php
						   $queryT = "SELECT idtipoatencion, descripcion from tipo_atencion where estareg=1 order by descripcion asc";
						$itemsT = $objconfig->execute_select($queryT,1);

						foreach($itemsT[1] as $rowT)
						{
							$selected="";
							if($rowT["idtipoatencion"]==$row[1]["idtipoatencion"]){$selected="selected='selected'";}
							echo "<option value='".$rowT["idtipoatencion"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";

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
					<label for="atencion" class="control-label">Cod. Barra</label>
				</div>
                  <div class="col-md-3">				
                <input type="text" name="0form_codbarra" id="codbarra" onkeyup="mayuscula(this);" onkeypress="return ValidaLongitud(this, 12);" class="form-control" value="<?=$row[1]["codbarra"]?>" onchange="buscar_renaes();" placeholder="Código de Barra" data-toggle="tooltip" data-placement="top" title="Código de Barra" />
	       		</div>
				<div class="col-md-1">
					<label for="atencion" class="control-label">F.U.A.:</label>
				</div>
                  <div class="col-md-2">
                <input type="text" name="0form_nrofua" id="nrofua" class="form-control" onkeyup="mayuscula(this);" value="<?=$row[1]["nrofua"]?>"  placeholder="F.U.A" data-toggle="tooltip" data-placement="top" title="F.U.A" />
	       		</div>
				<div class="col-md-1">
					<label for="atencion" class="control-label">Referencia:</label>
				</div>
                  <div class="col-md-3">
                <input type="text" name="0form_referencia" id="referencia" class="form-control" onkeyup="mayuscula(this);" value="<?=$row[1]["referencia"]?>" placeholder="REFERENCIAS" data-toggle="tooltip" data-placement="top" title="REFERENCIA" />
	       		</div>
	       		</div>
			</div>
			</br>
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-2">
						<label for="atencion" class="control-label">Procedencia:  </label>
					</div>

					<div class="col-md-10">
						<input type="hidden" id="idestablesolicita" name="0form_idestablesolicita" value="<?=$est_orig;?>"  />
						<input for="atencion" type="text" name="nombre_establecimiento" id="nombre_establecimiento"  readonly="readonly" onclick="buscar_establecimiento();" value="<?php echo $establecimiento;?>" placeholder="Click para seleccionar Establecimiento" class=" form-control" />

					</div>
				</div>
			</div>
			</br>
			<div class="row" style="border-color: #343a40; border: 1px solid #000; margin: 2rem 2rem;padding: 1rem .5rem; border-radius: 0.5rem;">
				<div class="col-md-8">
					<div class="col-md-2">
						<label for="atencion" class="control-label">Tipo Documento:  </label>
					</div>
					<div class="col-md-2">
						<select id="iddocumento" name="iddocumento"  class="form-control" >
							<option value="0"></option>
							<?php
									
								$queryT = "select iddocumento,descripcion from tipo_documento where estareg=1";
								$itemsT = $objconfig->execute_select($queryT,1);
												
								foreach($itemsT[1] as $rowT)
								{
									$selected="";
									if($rowT["iddocumento"]==$row[1]["iddocumento"]){$selected="selected='selected'";}
									echo "<option value='".$rowT["iddocumento"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
								}
							?>
						</select>
					</div>
					<div class="col-md-8">
						<div class="input-group">							
							<input type="text" id="text-reniec" class="form-control" placeholder="# Documento">
							<span class="input-group-btn">
								<button class="btn btn-success" type="button" id="btn-reniec">Consultar</button>
								<button class="btn btn-primary" type="button" id="btn-registrar">Registrar</button>
							</span>
						</div>
					</div>
					
					<div class="col-md-12">
						<input type="text" id="text-nombre" class="form-control" disabled="disabled" placeholder="Nombre o Razon Social">
					</div>
					<div class="col-md-12" style="margin-top:1.3rem">
						<div class="col-md-2">
							<label for="atencion" class="control-label">Solicitado Por:  </label>
						</div>

						<div class="col-md-10">
							<select id="idcliente" name="0form_idcliente" class="combobox form-control selectpicker">
							<option value="0"></option>
							<?php
							$queryT = "SELECT idcliente, razonsocial,ruc from cliente where estareg=1 order by razonsocial asc";
							$itemsT = $objconfig->execute_select($queryT,1);

							foreach($itemsT[1] as $rowT)
							{
								$selected="";
								if($rowT["idcliente"]==$row[1]["idcliente"]){$selected="selected='selected'";} 
								echo "<option value='".$rowT["idcliente"]."' ".$selected." >".strtoupper($rowT["ruc"]." - ".$rowT["razonsocial"])."</option>";
							}
							?>
							</select>
						</div>
					
					</div>
			</div>
			<div class="col-md-4" style="height:100% !important; display:flex; justify-content:center">
				<img id="img_cliente" style="background:blue; width:50%; height:180px; max-height:180px; object-fit:cover;object-position: center center;" src="https://static.vecteezy.com/system/resources/previews/005/228/939/original/avatar-man-face-silhouette-user-sign-person-profile-picture-male-icon-black-color-illustration-flat-style-image-vector.jpg" />
			</div>		
			</div>	
			</br> 
			
			</br>
			<div class="row">
			<div class="col-md-12">
			<div class="col-md-2">
				<label for="atencion" class="control-label">Alimentos:  </label>
			</div>

			<div class="col-md-4">
				<select id="idalimento" name="0form_idalimento" onchange="sub_alimentos(this.value,<?php echo $idsbare;?>)"  class="form-control"  >
					<option value="0"></option>
					<?php
					$queryT2 = "select idalimento, descripcion from alimento where estareg=1 order by descripcion ASC ";
					$itemsT2 = $objconfig->execute_select($queryT2,1);

					foreach($itemsT2[1] as $rowT2)
					{
						$selected="";
						if($rowT2["idalimento"]==$row[1]["idalimento"]){$selected="selected='selected'";}
						echo "<option value='".$rowT2["idalimento"]."' ".$selected." >".strtoupper($rowT2["descripcion"])."</option>";
					}
					?>
				</select>
			</div>
			<div class="col-md-1">
				<label for="atencion" class="control-label">Sub Grupo:  </label>
			</div>
			<div id="div-alimentos" class="col-md-5"> </div>
			</div>
			</div>
			</br>
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-2">
						<label for="atencion" class="control-label">Examen:  </label>
					</div>
					<div class="col-md-3">
						<select id="tipoexamen" name="tipoexamen" onchange="cargar_subarea(this.value)" data-toggle="tooltip" data-placement="top" title="Tipo de Examen"  class="form-control combobox"  >
						<option value="0"></option>
						   <?php
						   $queryT = "SELECT idtipo_examen, descripcion from tipo_examen where estareg=1 order by descripcion asc";
						$itemsT = $objconfig->execute_select($queryT,1);

						foreach($itemsT[1] as $rowT)
						{
							$selected="";
							if($rowT["idtipo_examen"]==$seguro){$selected="selected='selected'";}
							echo "<option value='".$rowT["idtipo_examen"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";

						}
						?>
						</select>
					</div>
					<div class="col-md-1">
						<label for="atencion" class="control-label">Unidad Destino:  </label>
					</div>
					<div id="div-subarea" name="div-subarea" class="col-md-3"></div>
					<div class="col-md-1">
						<label for="atencion" class="control-label">Cantidad:  </label>
					</div>
					<div class="col-md-1">
						<input type="text" name="cant" id="cant" onkeyup="solonumeros(this);" onkeypress="return ValidaLongitud(this, 12);" class="form-control" value="<?=$row[1]["cantidad"]?>" placeholder="Cantidad" data-toggle="tooltip" data-placement="top" title="Cantidad" />
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
					<div class="panel-heading">LISTADO DE EXAMENES A REALIZAR </div>
					<div class="panel-body">
						<table class="table table-striped table-bordered table-hover table-responsive" id="tbdiagnostico" name="tbdiagnostico" >
							<thead>

							<tr>
								<td >#</td>
								<td>Cantidad</td>
								<td >Exámen </td>
								<td >Unidad  </td>
								<td >Área  </td>
								<td >Opción</td>
							</tr>

							</thead>
							<tbody>
								<?php
								$count_enf=0;
								$sqlF = "select m.idmuestradetalle, m.idingresomuestra, m.idtipo_examen, m.idarea,m.idareatrabajo,  e.descripcion as tipexamen, 
										a.descripcion as area_destino,sat.descripcion as subarea,cantidad
										from muestra_det as m
										inner join tipo_examen as e on(e.idtipo_examen=m.idtipo_examen)
										inner join areas as a on(a.idarea=m.idarea)
										inner join area_trabajo as sat on(sat.idareatrabajo=m.idareatrabajo)
										where m.idingresomuestra=".$cod." ";
								$rowF = $objconfig->execute_select($sqlF,1);
								foreach($rowF[1] as $rF)
								{
									$count_enf++;

									?>
									<tr id='itemdiagnostico<?php echo $count_enf; ?>' name='itemdiagnostico<?php echo $count_enf; ?>' >
										<td >
											<input type='hidden' name='idmuestradetalle<?php echo $count_enf; ?>' id='idmuestradetalle<?php echo $count_enf; ?>' value='<?php echo $rF["idmuestradetalle"]; ?>' />
											<?php echo $count_enf ; ?>
										</td>
										<td>
											<input type='hidden' name='cantidad<?php echo $count_enf; ?>' id='cantidad<?php echo $count_enf; ?>' value='<?php echo $rF["cantidad"]; ?>' />
											<?php echo strtoupper($rF["cantidad"] ); ?>
										</td>
										<td>
											<input type='hidden' name='idtipo_examen<?php echo $count_enf; ?>' id='idtipo_examen<?php echo $count_enf; ?>' value='<?php echo $rF["idtipo_examen"]; ?>' />
											<?php echo strtoupper($rF["tipexamen"] ); ?>
										</td>
										<td>
											<input type='hidden' name='idarea<?php echo $count_enf; ?>' id='idarea<?php echo $count_enf; ?>' value='<?php echo $rF["idarea"]; ?>' />
											<?php echo strtoupper($rF["area_destino"] ); ?>
										</td>
										<td>
										<input type='hidden' name='idareatrabajo<?php echo $count_enf; ?>' id='idareatrabajo<?php echo $count_enf; ?>' value='<?php echo $rF["idareatrabajo"]; ?>' />
											<?php echo strtoupper($rF["subarea"] ); ?>
										</td>
										<td >
										
											<img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_diagnostico(<?php echo $count_enf; ?>)' title='Borrar REgistro' />
										
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

/* <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/js/bootstrap-select.min.js"></script> */
<script type="text/javascript">
	$("#btn-registrar").hide();
	sub_alimentos('<?php echo $row[1]["idalimento"];?>','<?php echo $row[1]["idsubalimento"];?>')
	cargar_subarea(0,0)
    Estalecimiento(<?php echo $idorg_micro; ?>, <?php echo $idorg_estable; ?>)
	<?php  $queryT = "SELECT idcliente, razonsocial,ruc from cliente where estareg=1 order by razonsocial asc";
							$itemsT = $objconfig->execute_select($queryT,1);?>

	/* console.log(JSON.parse('<?php echo json_encode($itemsT[1]);?>')); */
    var listSolicitante= <?php echo json_encode($itemsT[1]);?>;
	//console.log(listSolicitante[0]);
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
	$("#iddocumento").on('change',function(){
		console.log("#iddocumento", $( this ).val())
		if($( this ).val()!=1){
			$("#btn-registrar").hide();
			$("#btn-reniec").show();
		}
	})
	$("#btn-registrar").on('click',function(){
		console.log("test");
		if($('#iddocumento').val()=="0"){
			alert("Seleccione el tipo de documento!!");
			$('#iddocumento').focus();
			return;
		}
		
		if($('#text-nombre').val()==""){
			alert("Ingrese el nombre o razon social!!");
			$('#text-nombre').focus();
			return;
		}
		if($('#text-reniec').val()==""){
			alert("Ingrese el documento!!");
			$('#text-reniec').focus();
			return;
		}
		var params = {
				dni: $('#text-reniec').val(),
				razonsocial: $('#text-nombre').val(),
				direccion:'-',
				tipodoc:$("#iddocumento").val()
			}
			console.log("btn-registrar",params);
			$.ajax({
						type:  "POST",
						url:   carpeta+"register_cliente.php",
						data:  params,
						success:  function (response) {
							var res2=JSON.parse(response);
							$('#idcliente').append($('<option>', {
								value: res2.idcliente,
								text: res2.ruc+" - "+res2.razonsocial
							}));
							$('#idcliente').val(res2.idcliente);							
							$('input.selectpicker').val(res2.ruc+' - '+res2.razonsocial);
							$("input[name='0form_idcliente'").val(res2.idcliente);
							}
						});

	})
	//BTN search reniec
	$('#btn-reniec').on('click', function (e) {
        e.preventDefault()
		var tipoDoc=$("#iddocumento").val();
		if(tipoDoc==0){
			alert("Seleccione el tipo de documento")
        	$("#iddocumento").focus();
			return;
		}
		if($("#text-reniec").val().length<5){
			alert("Ingrese correctamente el documento")
        	$("#text-reniec").focus();
			return;
		}
		/* var resultado = document.getElementById('page-wrapper'); */
		if($('#iddocumento').val()==2 || $('#iddocumento').val()==3 || $('#iddocumento').val()==5 || $('#iddocumento').val()==6 || $('#iddocumento').val()==8){
			if($("#text-nombre").val().length<3){
				alert("Ingrese correctamente el nombre o la razon social")
				$("#text-nombre").focus();
				return;
			}
			var params = {
				dni: $('#text-reniec').val(),
				razonsocial: $('#text-nombre').val(),
				direccion:'-',
				tipodoc:tipoDoc
			}
			$.ajax({
						type:  "POST",
						url:   carpeta+"register_cliente.php",
						data:  params,
						success:  function (response) {
							var res2=JSON.parse(response);
							$('#idcliente').append($('<option>', {
								value: res2.idcliente,
								text: res2.ruc+" - "+res2.razonsocial
							}));
							$('#idcliente').val(res2.idcliente);							
							$('input.selectpicker').val(res2.ruc+' - '+res2.razonsocial);
							$("input[name='0form_idcliente'").val(res2.idcliente);
							}
						});
		}else{
			var ajax = new XMLHttpRequest();
			ajax.open("GET", carpeta+"consultadni.php?id="+$("#text-reniec").val()+"&tipo="+$("#iddocumento").val());
			ajax.onreadystatechange = function() {
				if (ajax.readyState == 4) {				
					var res=JSON.parse(ajax.responseText);
					console.log(res);
					if(!res.status){
						$('#idcliente').val('');							
						$('input.selectpicker').val('');
						$("input[name='0form_idcliente'").val('');
						$("#img_cliente").attr('src', 'https://static.vecteezy.com/system/resources/previews/005/228/939/original/avatar-man-face-silhouette-user-sign-person-profile-picture-male-icon-black-color-illustration-flat-style-image-vector.jpg');
						alert(res.msm)
						if(res.resultado==1){
							$("#text-nombre").prop('disabled', false);
							$("#btn-registrar").show();
							$("#btn-reniec").hide();
							$("#text-nombre").focus();

							//busca img_cliente
							var fSolicitante= listSolicitante.find(s=> s.ruc==res.dni);
							console.log(fSolicitante);
							if(fSolicitante){
								$('#idcliente').val(fSolicitante.idcliente);					
								$('input.selectpicker').val(fSolicitante.ruc+' - '+fSolicitante.razonsocial);
								$("input[name='0form_idcliente'").val(fSolicitante.idcliente);
								if(res.foto){
									$("#img_cliente").attr('src', 'data:image/png;base64,' + res.foto);
								}else{
											$("#img_cliente").attr('src', 'https://static.vecteezy.com/system/resources/previews/005/228/939/original/avatar-man-face-silhouette-user-sign-person-profile-picture-male-icon-black-color-illustration-flat-style-image-vector.jpg');

										}
							}
						}else{
							$("#text-reniec").focus();
						}
						
						return;
					}
					
					var fSolicitante= listSolicitante.find(s=> s.ruc==res.dni);
					/* if (typeof fSolicitante === 'undefined') {
						alert('No existe el DNI');
						$("#text-reniec").focus();
						return;
					} */
					if($("#iddocumento").val()==1){
						res
					}
					if(!fSolicitante){
						var params = {
							dni: res.dni,
							razonsocial: res.razonsocial,
							direccion:'-',
							tipodoc: tipoDoc
						}					
						$.ajax({
							type:  "POST",
							url:   carpeta+"register_cliente.php",
							data:  params,
							success:  function (response) {
								var res2=JSON.parse(response);
								$('#idcliente').append($('<option>', {
									value: res2.idcliente,
									text: res2.ruc+" - "+res2.razonsocial
								}));
								$('#idcliente').val(res2.idcliente);							
								$('input.selectpicker').val(res2.ruc+' - '+res2.razonsocial);
								$("input[name='0form_idcliente'").val(res2.idcliente);
								if(res.foto){
									$("#img_cliente").attr('src', 'data:image/png;base64,' + res.foto);
								}else{
									$("#img_cliente").attr('src', 'https://static.vecteezy.com/system/resources/previews/005/228/939/original/avatar-man-face-silhouette-user-sign-person-profile-picture-male-icon-black-color-illustration-flat-style-image-vector.jpg');

								}
								

							}
							});
					}else{
						$('#idcliente').val(fSolicitante.idcliente);					
						$('input.selectpicker').val(fSolicitante.ruc+' - '+res.razonsocial);
						$("input[name='0form_idcliente'").val(fSolicitante.idcliente);
						if(res.foto){
							$("#img_cliente").attr('src', 'data:image/png;base64,' + res.foto);
						}else{
									$("#img_cliente").attr('src', 'https://static.vecteezy.com/system/resources/previews/005/228/939/original/avatar-man-face-silhouette-user-sign-person-profile-picture-male-icon-black-color-illustration-flat-style-image-vector.jpg');

								}

					}
				}
			}
			ajax.send(null);
		}
		
    })

	$('#iddocumento').change(function(e) {
		if($('#iddocumento').val()==2 || $('#iddocumento').val()==3 || $('#iddocumento').val()==5 || $('#iddocumento').val()==6 || $('#iddocumento').val()==8){
			$('#text-nombre').prop("disabled", false);
			$("#btn-reniec").html('Registrar');
		}else{
			$('#text-nombre').prop("disabled", true);
			$("#btn-reniec").html('Consultar');
		}
	});
	$('#text-reniec').on('input', function (e) {
		if (!/^[ a-z0-9áéíóúüñ]*$/i.test(this.value)) {
			this.value = this.value.replace(/[^ a-z0-9áéíóúüñ]+/ig,"");
		}
	});
</script>
