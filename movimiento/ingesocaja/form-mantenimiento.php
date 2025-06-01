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
	/* const idUsuarioSesion= <?php echo $_SESSION['id_user'];?>;
	console.log("idUsuarioSesion",idUsuarioSesion); */
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
				<h3 class="modal-title text-success" align="center"> REGISTRO DE COMPROBANTES</h3>
				
				<!--
                <div class="col-md-12">
                    <div class="col-md-2">
                        <label for="atencion" class="control-label">MICRORED:  </label>
                    </div>
                    <div class="col-md-4">
					
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
				-->
				<input type="hidden" name="0form_idejecutora" id="idejecutora" value="<?php echo $nom_estab[1]["idejec"]; ?>"  />
				<input type="hidden" name="0form_idred" id="idred" value="<?php echo $nom_estab[1]["idred"]; ?>"  />
				<input type="hidden" name="0form_idmicrored" id="idmicrored" value="<?php echo $nom_estab[1]["idmicrored"]; ?>"  />
				<input type="hidden" name="0form_idestablecimiento" id="idestablecimiento" value="<?php echo $nom_estab[1]["idestablecimiento"]; ?>"  />
                <input type="hidden" name="0form_idtipo" id="idtipo" value="<?php echo $op; ?>"  />
				<input type="hidden" name="op" id="op" value="<?php echo $op; ?>"  />
				<input type="hidden" name="0form_idusuario" id="idusuario" value="<?=$idusuario[0]?>"  />
				<input type="hidden" name="0form_idusuario" id="idusuario" value="<?php echo $iduser; ?>"  />
				<input type="hidden" name="0form_nombre_usuario" id="nombre_usuario" value="<?=$idusuario[1]?>"  />
				<input type="hidden" name="1form_idpago" id="idpago" value="<?=$row[1]["idpago"]?>" <?php echo $readonly;?>   class="form-control"/>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
						<div class="col-md-1">
                    		<label>Fecha Emisión</label>
						</div>
                	<div class="col-md-2">
                     	<div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2"  data-link-format="yyyy-mm-dd">
                            <input class="form-control" type="text" name="0form_fechaemision" id="fechaemision" value="<?php echo date("d/m/Y");?>"  >
                         <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                       
                        </div>
                    </div>
					<div class="col-md-2">
						<label for="atencion" class="control-label text-right">Nombre Comprobante:  </label>
						
					</div>
					<div class="col-md-7">
						<select id="idcliente" name="0form_idcliente" class="form-control combobox"  >
						<option value="0"></option>
						   <?php
						   $queryT = "SELECT idcliente, razonsocial, ruc, iddocumento from cliente where estareg=1 order by razonsocial asc";
						$itemsT = $objconfig->execute_select($queryT,1);

						foreach($itemsT[1] as $rowT)
						{
							$selected="";
							if($rowT["idcliente"]==$row[1]["idcliente"]){$selected="selected='selected'";}
							echo "<option value='".$rowT["idcliente"]."' ".$selected." iddocumento='".$rowT["iddocumento"]."'>".strtoupper($rowT["ruc"]." / ".$rowT["razonsocial"])."</option>";

						}
						?>
						</select>
						<script type="text/javascript">
							var clientesArray= <?php echo json_encode($itemsT["1"]);?>;
						</script>
					</div>

				</div>
			</div>
			</br>
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-2">
						<label for="atencion" class="control-label ml-2">Procedencia:  </label>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-2">
					
						<select id="idselect" name="idselect" class="form-control" onchange="cambiosOpcion()" >
							<option value="2">COD BARRA</option>
							<option value="1">Procedencia</option>
						</select>
						
					</div>

					<div class="col-md-9">
						<input type="hidden" id="idestablesolicita" name="0form_idestablesolicita" value="<?=$est_orig;?>"  />
						<input for="atencion" type="text" name="nombre_establecimiento" id="nombre_establecimiento" value="<?php echo $establecimiento;?>" placeholder="Click para seleccionar Establecimiento" class=" form-control" />
					</div>
					<div class="col-md-1">
							<input for="atencion" type="button" name="bca" id="bca" onclick="buscar_establecimiento();" value="Buscar"  class="btn btn-success" />
					</div>
				</div>
			</div>
			</br>
			<div id="div-porcobrar" name="div-porcobrar" >
				<div style="height:280px;  overflow-x:hidden;" >
					<div class="row">
						<div class="col-sm-12">
						<div class="panel panel-info ">
							<div class="panel-heading">EXAMENES PENDIENTES DE COBRO </div>
								<div class="panel-body">
										<table class="table table-striped table-bordered table-hover table-responsive" id="tbdiagnostico" name="tbdiagnostico">
											<thead>

												<tr>
													<td >#</td>
													<td>Cantidad</td>
													<td >Fecha Ing </td>
													<td >Atención </td>
													<td >CodBarra </td>
													<td >Exámen </td>
													<td >Unidad  </td>
													<td >Área  </td>
													<td >Costo S.</td>
													<td ></td>
												</tr>
											<tbody>
													
											
											</tbody>
											</thead>
											
										</table>										
								</div>
							
							</div>
						</div>
					</div>
			</div>
		</div>
		</br>
<div class="row">
	<div class="col-sm-12">
		<div class="col-md-1">
			<label for="atencion" class="control-label text-right">Comprobante:  </label>
			
		</div>
		<div class="col-md-3">
			<select id="idcomprobante" name="0form_idcomprobante" class="form-control" onchange="cargar_exonerar(this.value,this.serie,this.valor,this);" >
			<option value="0--" ></option>
			   <?php
			   $queryT = "select DISTINCT TC.idcomprobante, TC.descripcion from seriedoc_personal SDP 
			   RIGHT JOIN seriedoc SD ON (SDP.idseriedoc = SD.idseriedoc) LEFT JOIN tipo_comprobante TC ON 
			   (SD.idtipocomprobante = TC.idcomprobante) where SDP.idpersonal='".$_SESSION['id_user']."'";
			$itemsT = $objconfig->execute_select($queryT,1);

			foreach($itemsT[1] as $rowT)
			{
				$selected="";
				if($rowT["idcomprobante"]==$row[1]["idcomprobante"]){$selected="selected='selected'";}
				echo "<option value='".$rowT["idcomprobante"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";

			}
			?>
		</select>
		</div>
		<div class="col-md-1">
			<label for="atencion" class="control-label">Serie Doc.:  </label>
		</div>
		<div class="col-md-3">
			<select id="idserie" onchange="cargarn(this)" class="form-control" name="0form_seriedocumento">
				<option value="0" disabled selected>---</option>
			</select>
		</div>
		<div class="col-md-1">
			<label for="atencion" class="control-label">N° Doc.:  </label>
		</div>
		<div class="col-md-3">
			<input type="text" id="nrodocumento" readonly name="0form_nrodocumento" onKeyup="mayuscula(this)" value="" class=" form-control text-right" />
		</div>
	</div>
</div>
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-2">
					<label for="atencion" class="control-label text-right">Descuento S/.  </label>
				</div>
				<div class="col-md-4">
					<input type="text" id="descuento" name="0form_descuento" onKeyPress="solonumeros(event)" onchange="descuentoss();" value="0" class=" form-control text-right" />
				</div>
				<div class="col-md-2">
					<label for="atencion" class="control-label text-right">Total Pagar S/.  </label>
				</div>
				<div class="col-md-4">
					<input type="hidden" id="monto1" name="0form_monto1"  value="<?=$monto;?>" class=" form-control" />
					<input type="text" id="monto" name="0form_monto" readonly value="<?=number_format($monto,2);?>" class=" form-control text-right" />
				</div>
			</div>
		</div>
	</br>		
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-1">
						<label for="atencion" class="control-label">Tipo Pago:  </label>
					</div>

					<div class="col-md-3">
						<select id="idtipopago" name="0form_idtipopago" class="form-control"  >
						<option value="0"></option>
						   <?php
						   $queryT = "SELECT idtipopago, descripcion from tipo_pago where estareg=1 order by descripcion asc";
						$itemsT = $objconfig->execute_select($queryT,1);

						foreach($itemsT[1] as $rowT)
						{
							$selected="";
							if($rowT["idtipopago"]==$row[1]["idtipopago"]){$selected="selected='selected'";}
							echo "<option value='".$rowT["idtipopago"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";

						}
						?>
						</select>
					</div>
					<div class="col-md-1">
						<label for="atencion" class="control-label">Observación:  </label>
					</div>
					<div class="col-md-7">
						<input type="text" name="0form_observacion" id="observacion"  value="" class=" form-control" />
					</div>


				</div>
			</div>
			</br>
			<div id="div-exonerar" name="div-exonerar" > </div>
		
			</br>	
				<div class="upload-msg col-md-12"></div><!--Para mostrar la respuesta del archivo llamado via ajax -->
					<div class="modal-footer">
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
<script src="../movimiento/ingesocaja/numeroALetras.js" type="text/javascript"></script>
<script type="text/javascript">
	//cargar_cobro(0)
	cargar_exonerar(0)
	count_enf=0;
	monto_total=0.00;
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