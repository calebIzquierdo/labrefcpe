<?php
     include("../../../objetos/class.cabecera.php");
	 include("../../../objetos/class.conexion.php");
	
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
		$query = "select * from urocultivo where idurocultivo=".$cod;
		$row = $objconfig->execute_select($query);

        $idorg_micro = $row[1]["idmicrored"];
        $idorg_estable =$row[1]["idestablecimiento"];


		$disable= "disabled";  
		//$readonly="readonly=readonly";
        $qDiag = $objconfig->execute_select("select iddiagnostico, codigo ||' - '||descripcion as diagno from diagnostico where iddiagnostico=".$row[1]["iddiagnostico"]);
        echo $qDiag[1]["iddiagnostico"];

        $pac= "select idpaciente, nrodocumento,apellidos, nombres from paciente where idpaciente=".$row[1]["idpaciente"];
        $rowPaciente = $objconfig->execute_select($pac);
        $nombrepaciente = $rowPaciente[1]["nrodocumento"]." - ".$rowPaciente[1]["apellidos"]."; ".$rowPaciente[1]["nombres"];

        $esta= "select idestablecimiento, eje,red, micro, esta,codrenaes from vista_establecimiento where idestablecimiento=".$row[1]["idestablesolicita"];
        $rowEstable = $objconfig->execute_select($esta);

        //$establecimiento = $rowEstable[1]["codrenaes"]." / ".$rowEstable[1]["esta"]." / ".$rowEstable[1]["micro"]." / ".$rowEstable[1]["red"]." / ".$rowEstable[1]["eje"];
        $establecimiento = $rowEstable[1]["codrenaes"]." - ".$rowEstable[1]["esta"]." / ".$rowEstable[1]["micro"]." / ".$rowEstable[1]["red"];
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

 function CalcularEdad(id)
  {
      if (id == undefined ){
          id = $("#idpaciente").val()
      }
		
      var fecharef = $("#fechatoma").val()
      var codigo = $("#codigo").val()

      $.ajax({
         type: "POST",
         url: carpeta+"edad.php",
         data: "idpa="+id+"&fref="+fecharef+"&cod="+codigo,
         success: function(data) {
             $("#div-edad").html(data)
         }
     });
     seguro(id)
 }

 function seguro(id)
 {
	 var cod = $("#codigo").val()
		$.ajax({
         type: "POST",
         url: carpeta+"seguro.php",
         data: "idpa="+id+"&idref="+cod,
         success: function(data) {
         $("#idseguro").val(data)
         }
     });
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
				<div id="div-estable" name="div-estable"> </div>
				<!--
                <div class="col-md-12">
                    <div class="col-md-3">
					
                            <?php
                            $queryT = "select idmicrored,descripcion 
										from microred  where idred=".$idorg_red." 
										order by descripcion asc";
						//	echo $queryT ;
                            $itemsT = $objconfig->execute_select($queryT);
							  echo "<h4 class='modal-title text-primary' align='center'>MICRORED: ". $itemsT[1]["descripcion"]." </h3>";  
						     
							?> 
                        </div>
                        <div class="col-md-9">
                        <?php echo "<h4 class='modal-title text-primary' align='center'>Ejecutora: ". $nom_estab[1]["ejec"]." </h3>";  ?> 
                    </div>
                </div>
-->
				<input type="hidden" name="0form_idtipo" id="idtipo" value="<?php echo $op; ?>"  />
				<input type="hidden" name="op" id="op" value="<?php echo $op; ?>"  />
				<input type="hidden" name="0form_idusuario" id="idusuario" value="<?=$idusuario[0]?>"  />
				<input type="hidden" name="0form_nombre_usuario" id="nombre_usuario" value="<?=$idusuario[1]?>"  />
				<input type="hidden" name="0form_idusuario" id="idusuario" value="<?php echo $iduser; ?>"  />
				<input type="hidden" name="0form_idejecutora" id="idejecutora" value="<?php echo $nom_estab[1]["idejec"]; ?>"  />
				<input type="hidden" name="0form_idred" id="idred" value="<?php echo $nom_estab[1]["idred"]; ?>"  />
				<input type="hidden" name="0form_idmicrored" id="idmicrored" value="<?php echo $nom_estab[1]["idmicrored"]; ?>"  />
				<input type="hidden" name="0form_idestablecimiento" id="idestablecimiento" value="<?php echo $nom_estab[1]["idestablecimiento"]; ?>"  />
				<input type="hidden" name="0form_idseguro" id="idseguro" value="<?=$row[1]["idseguro"]?>"  />
				<input type="hidden" name="0form_idingresomuestra" id="idingresomuestra" value="<?=$row[1]["idingresomuestra"]?>"  />
				<input type="hidden" name="idresulta" id="idresulta" value="<?=$row[1]["idresultado"]?>"  />
				<input type="hidden" name="rcuento" id="rcuento" value="<?=$row[1]["recuento"]?>"  />
				<input type="hidden" name="idtipo_examen" id="idtipo_examen" value="72"  />
				<h3 class="modal-title text-center">Registro de Examenes Urocultivo</h3>
			</div>
			
			<div class="modal-body">

                <div class="col-md-12">
            <!--    <div class="container">  -->

                    <!-- Nav tabs -->
                   <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="active">
                            <a href="#home" role="tab" data-toggle="pill"  id="pills-home-tab"  aria-controls="pills-home" aria-selected="true" >
                                <i class="fa fa-info" aria-hidden="true"></i> REGISTRAR FICHA
                            </a>
                        </li>
						<li >
                            <a href="#profile" role="tab" data-toggle="tab"  id="pills-profile-tab"  aria-controls="pills-profile" aria-selected="false" >
                                <i class="fa fa-stethoscope" aria-hidden="true"></i> RESULTADOS
                            </a>
                        </li>
                        <li>
                            <a href="#saveall" role="tab" data-toggle="tab" id="pills-saveall-tab"  aria-controls="pills-saveall" aria-selected="false">
                                <i class="fa fa-save"></i> Guardar
                            </a>
                        </li>
			
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content" id="pills-tabContent" >
                        <div class="tab-pane fade active in" id="home">
                        
                            </br>
							<div class="row">
							<div class="col-md-12">
							<input type="hidden" name="1form_idurocultivo" id="codigo" value="<?=$row[1]["idurocultivo"]?>"   <?php echo $readonly; ?>   class="form-control"/>
							
							<div class="col-md-3">
							<label for="atencion" class="control-label">Codigo Barras</label>
							</div>
							<div class="col-md-3">
							<input type="text" name="0form_codbarra" id="codbarra" onkeyup="mayuscula(this);" class="form-control" value="<?=$row[1]["codbarra"]?>" onchange="buscar_renaes();" placeholder="Código de Barra" data-toggle="tooltip" data-placement="top" title="Código de Barra" />
							</div>
							<div class="col-md-3">
								<label>Fecha Recepción.</label>
							</div>
							<div class="col-md-3">
							<div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2" onchange="CalcularEdad(<?php echo $row[1]["idpaciente"];?>);" data-link-format="yyyy-mm-dd">
                            <input class="form-control" type="text" name="0form_fecharecepcion" id="fecharecepcion" value="<?php echo ($row[1]["fecharecepcion"])?$objconfig->FechaDMY2($row[1]["fecharecepcion"]):date("d/m/Y");?>"  >
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
							</div>
							</div>
							</div>
							</br>
							<div class="row">
								<div class="col-md-12">
									<input type="hidden" name="1form_idurocultivo" id="codigo" value="<?=$row[1]["idurocultivo"]?>"   <?php echo $readonly; ?>   class="form-control"/>
								<div class="col-md-3">
									<label for="atencion" class="control-label">Procedencia Estab / Micro Red:  </label>
								</div>

								<div class="col-md-9">
									<input type="hidden" id="idestablesolicita" name="0form_idestablesolicita" value="<?=$est_orig;?>"  />
									<input for="atencion" type="text" name="nombre_establecimiento" id="nombre_establecimiento"  readonly="readonly"  value="<?php echo $establecimiento;?>" placeholder="Ingresa Codigo de Barra para seleccionar Establecimiento" class=" form-control" />
								</div>
						        </div>
							</div>

					 </br>
					  <div class="row">
						<div class="col-md-12">
							<div class="col-md-3">
								<label for="atencion" class="control-label">Nombre Paciente:  </label>
							</div>
							<div class="col-md-9">
								<input type="hidden" id="idpaciente" name="0form_idpaciente" onclick="buscar_paciente();"  value="<?=$rowPaciente[1]["idpaciente"]?>"  />
								<input for="atencion" type="text" name="nombre_paciente" id="nombre_paciente"  readonly="readonly" onclick="buscar_paciente();" value="<?php echo $nombrepaciente;?>" placeholder="Click para seleccionar Paciente" class=" form-control" />
							</div>
						</div>
					</div>
					 </br>
					 
					<div class="row">
						<div class="col-md-12">
							<div class="col-md-3">
								<label for="atencion" class="control-label">Edad Actual Paciente:  </label>
							</div>

							<div class="col-md-3">
								<div id="div-edad" name="div-edad"> </div>
							</div>
							<div class="col-md-1">
								<label for="atencion" class="control-label">Tipo Atención:  </label>
							</div>

							<div class="col-md-2">
								<div id="div-seguro" name="div-seguro"> </div>
							</div>
							<div class="col-md-1">
								<label for="atencion" class="control-label">Número Recibo:  </label>
							</div>
							<div class="col-md-2">
							   <input type="text" id="nrorecibo" class="form-control" name="0form_nrorecibo" value="<?=$row[1]["nrorecibo"]?>"  />
							</div>


						</div>
					</div>
					</br>
					<div id="div-datos" name="div-datos" class="col-md-12"> 
					</div>
					  </br>
					 	
                            <div class="row">
                                <div class="col-md-12">
                                     <div class="col-md-3">
										<label>Fecha Toma Muestra:</label>
									</div>
									<div class="col-md-3">
										<div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy" onchange="CalcularEdad(<?php echo $row[1]["idpaciente"];?>);" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
											<input class="form-control" type="text" name="0form_fechatoma" id="fechatoma" value="<?php echo ($row[1]["fechatoma"])?$objconfig->FechaDMY2($row[1]["fechatoma"]):date("d/m/Y");?>"  >
											<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
									   
										</div>
									</div>
                                    <div class="col-md-2">
                                        <label for="atencion" class="control-label"> Tipo Muestra </label>
                                    </div>
                                    <div class="col-md-4">
                                        <select id="idtipomuestra" name="0form_idtipomuestra" class="form-control combobox"  data-toggle="tooltip" data-placement="top" title="Tipo de Muestra">
                                            <option value="0"></option>
                                            <?php
                                            //select descripcion from departamento where idpais='2' order by descripcion
                                            $queryT = "select idtipomuestra, descripcion   FROM tipo_muestra where estareg=1 order by descripcion";
                                            $itemsT = $objconfig->execute_select($queryT,1);

                                            foreach($itemsT[1] as $rowT)
                                            {
                                                $selected="";
                                                if($rowT["idtipomuestra"]==$row[1]["idtipomuestra"]){$selected="selected='selected'";}
                                                echo "<option value='".$rowT["idtipomuestra"]."' ".$selected." >".strtoupper($rowT["descripcion"] )."</option>";
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
										<label for="atencion" class="control-label">Medico Solicitante:  </label>
									</div>

									<div class="col-md-9">
										<select id="idmedicosolicitante" name="0form_idmedicosolicitante" class="combobox form-control" >
											<option value="0"></option>
											<?php
											$queryT2 = "select idpersonal, nrodocumento, apellidos || '; ' || nombres as nompaciente, idprofesion 
											from personal where estareg=1 and not idprofesion = 0 order by nrodocumento asc";
											$itemsT2 = $objconfig->execute_select($queryT2,1);

											foreach($itemsT2[1] as $rowT2)
											{
												$selected="";
												if($rowT2["idpersonal"]==$row[1]["idmedicosolicitante"]){$selected="selected='selected'";}
												echo "<option value='".$rowT2["idpersonal"]."' ".$selected." >".strtoupper($rowT2["nrodocumento"]." / ".$rowT2["nompaciente"])."</option>";
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
										<label for="atencion" class="control-label">Unidad Destino:  </label>
									</div>

									<div class="col-md-9">
										<select id="idarea" name="0form_idarea" class="combobox form-control" >
											<option value="0"></option>
											<?php
											$queryT2 = "select idarea, descripcion from areas where estareg=1 order by descripcion asc";
											$itemsT2 = $objconfig->execute_select($queryT2,1);

											foreach($itemsT2[1] as $rowT2)
											{
												$selected="";
												if($rowT2["idarea"]==$row[1]["idarea"]){$selected="selected='selected'";}
												echo "<option value='".$rowT2["idarea"]."' ".$selected." >".strtoupper($rowT2["descripcion"])."</option>";
											}
											?>
										</select>
									</div>

								</div>
							</div>
							</div>
							</br>
                                <!-- Termino del Primer tab    </div> </div>       </fieldset>  -->

						<!-- Inicio del Segundo tab-->
                       <div class="tab-pane fade" id="profile">
						<!-- <h2>Profile Content Goes Here</h2>  -->
                            </br>

                            <div class="row">
                                <div class="col-md-12">
								<div class="col-md-3">
										<label>Fecha Resultado:</label>
									</div>
									<div class="col-md-3">
										<div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy"  data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
											<input class="form-control" type="text" name="0form_fecharesultado" id="fecharesultado" value="<?php echo ($row[1]["fecharesultado"])?$objconfig->FechaDMY2($row[1]["fecharesultado"]):date("d/m/Y");?>"   >
											<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
									   
										</div>
									</div>
                                    <div class="col-md-1">
                                        <label for="atencion" class="control-label"> TIpo Resul: </label>
                                    </div>
                                    <div class="col-md-3">
                                        <select id="idtipourocultivo" name="0form_idtipourocultivo" class="form-control" onchange="tipo_resultado(this.value)"  >
                                            <option value="0"></option>
                                            <?php
                                            $queryT = "select idtipourocultivo, descripcion from tipo_urocultivo where estareg=1 order by descripcion asc";
                                            $itemsT = $objconfig->execute_select($queryT,1);

                                            foreach($itemsT[1] as $rowT)
                                            {
                                                $selected="";
                                                if($rowT["idtipourocultivo"]==$row[1]["idtipourocultivo"]){$selected="selected='selected'";}
                                                echo "<option value='".$rowT["idtipourocultivo"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
									<div class="col-md-2">
                                        <input type="text" name="0form_nroingreso" id="nroingreso" value="<?=$row[1]["nroingreso"]?>"  class="form-control" <?php // echo $readonly; ?>  placeholder="N° Ingreso" data-toggle="tooltip" data-placement="top" title="N° Ingreso" />
                                    </div>

                                </div>
                            </div>
                            </br>
						<div class="row">
						<div class="col-md-12">
						<div class="col-md-3">
							<label for="atencion" class="control-label">Observación:</label>
						</div>
					<div class="col-md-9">
						<textarea name="0form_observaciones" id="observaciones" class="form-control " rows="2" cols="70"><?php echo $row[1]["observaciones"]; ?></textarea>
					</div>
					</div>
					</div>
				
					<div id="div-tipo_resultado"> </div>
					 <div id="div-antibiograma"> </div>
					
                            </br>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-3">
                                        <label for="atencion" class="control-label">Realizado Por:</label>
                                    </div>

                                    <div class="col-md-9">
                                        <select id="idatendido" name="0form_idatendido" class="combobox form-control"  >
                                            <option value="0"></option>
                                            <?php
                                            $queryTa = "select idpersonal, nrodocumento, apellidos || '; ' || nombres as nompaciente from personal where estareg=1 and not idprofesion = 0  order by nrodocumento asc";
                                            $itemsTA = $objconfig->execute_select($queryTa,1);

                                            foreach($itemsTA[1] as $rowTA)
                                            {
                                                $selected="";
                                                if($rowTA["idpersonal"]==$row[1]["idatendido"]){$selected="selected='selected'";}
                                                echo "<option value='".$rowTA["idpersonal"]."' ".$selected." >".strtoupper($rowTA["nrodocumento"]." / ".$rowTA["nompaciente"])."</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            </br>
                        </div>
            			
                        <div class="tab-pane fade" id="saveall">
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
						 <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                      <h3>Click en el Check para Confirmar todas la Pruebas Realizadas?: 
									  <input type="checkbox" name="estado" id="estado" onclick="cambiarestado(this,'estareg');" class="checkbox-inline" <?php echo $checked;?> />
										<button type='button' class='<?php echo $class;?>' name="boton01" id="boton01" > <?php echo $mensaje;?> </button>
										<input type="hidden" name="0form_estareg" id="estareg" value="<?=$estareg;?>"  />
										 </h3>
                                    </div>
                                </div>
                            </div>
							
                            <br/>
                            <div class="upload-msg col-md-12"></div><!--Para mostrar la respuesta del archivo llamado via ajax -->
                            <div class="modal-footer">
                                <!--		<input type="hidden" name="user_id" id="user_id" />
                                        <input type="hidden" name="operation" id="operation" /> -->
                                <input type="button" onclick="validar_form();" name="action" id="action" class="btn btn-success"  value="Agregar" />
                                <button type="button" onclick="regresar_index(carpeta);" class="btn btn-default" data-dismiss="modal" data-backdrop="false" > Cerrar </button>
                            </div>

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
    CalcularEdad(<?php echo $row[1]["idpaciente"];?>)
    tipo_atencion(<?php echo $row[1]["idtipoatencion"];?>)
    tipo_exam(<?php echo $row[1]["idingresomuestra"];?>)
	tipo_resultado(<?php echo $row[1]["idtipourocultivo"];?>)
	
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
