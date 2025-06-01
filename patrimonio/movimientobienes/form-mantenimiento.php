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

	$nom_estab = $objconfig->execute_select($esta); //

    $qesp = "select idespecialidad from usuarios where idusuario=".$idusuario[0] ;
    $respecie = $objconfig->execute_select($qesp);//
    $idespe = $respecie[1]["idespecialidad"];


    $idorg_idejec = $nom_estab[1]["idejec"];
    $idorg_red = $nom_estab[1]["idred"];
    $idorg_micro = $nom_estab[1]["idmicrored"];
    $idorg_estable = $nom_estab[1]["idestablecimiento"];

	$idare = 0;
	$idaretrab = 0;

    $nombrepaciente ="";
    $est_orig ="";
    $idsbare =0;

	if($cod!=0)
	{
		$query = "select * from ingreso where idingreso=".$cod;
		$row = $objconfig->execute_select($query);

        $idorg_micro = $row[1]["idmicrored"];
        $idorg_estable =$row[1]["idestablecimiento"];
        $idsbare =$row[1]["idsubalimento"];

		$disable= "disabled";  
	
        $esta= "select idproveedor, nrodocumento,razonsocial from proveedor where idproveedor=".$row[1]["idproveedor"];
		
        $rowEstable = $objconfig->execute_select($esta);

        //$establecimiento = $rowEstable[1]["codrenaes"]." / ".$rowEstable[1]["esta"]." / ".$rowEstable[1]["micro"]." / ".$rowEstable[1]["red"]." / ".$rowEstable[1]["eje"];
        $establecimiento = $rowEstable[1]["nrodocumento"]." - ".$rowEstable[1]["razonsocial"];
        $est_orig = $rowEstable[1]["idproveedor"];

	}
?>

<meta charset="UTF-8">
<meta http-equiv="content-type" content="text/html; utf-8">
<link rel="stylesheet" media="screen" href="<?=$path?>bootstrap/fecha/css/bootstrap-datetimepicker.min.css">
<script type="text/javascript" src="<?=$path?>bootstrap/fecha/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?=$path?>bootstrap/fecha/js/locales/bootstrap-datetimepicker.es.js"
    charset="UTF-8"></script>
<script type="text/javascript" src="<?=$path?>js/tooltip.js" charset="UTF-8"></script>

<script type="text/javascript">
var count = 0;

$('.form_datetime').datetimepicker({
    // language:  'fr',
    language: 'es',
    weekStart: 1,
    todayBtn: 1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    forceParse: 0,
    showMeridian: 1
});
$('.form_date').datetimepicker({
    language: 'es',
    weekStart: 1,
    todayBtn: 1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    minView: 2,
    forceParse: 1
});
$('.form_time').datetimepicker({
    language: 'es',
    weekStart: 1,
    todayBtn: 1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 1,
    minView: 0,
    maxView: 1,
    forceParse: 0
});


function Redtestt(idUnidadEjec, idRed) {
    //$("#idmicrored").html("");

    //$("#idestablecimiento").html($.parseHTML("<option value="">---</option>"));
    $.ajax({
        type: "POST",
        url: carpeta + "red.php",
        data: "idue=" + idUnidadEjec + "&idred=" + idRed,
        success: function(data) {
            $("#idred").html(data)
        }
    });
    /* $("#idred").val("");
    $("#idmicrored").val("");
    MicrooRed("",idUnidadEjec,0);
    $("#idestablecimiento").val("");
    Estalecimiento("",0); */
}

function MicrooRed(idRed, idUnidadEjec, idMicroRed) {

    /* $("#idestablecimiento").val("");
    Estalecimiento("",0); */

    $.ajax({
        type: "POST",
        url: carpeta + "microred.php",
        data: "idRed=" + idRed + "&idMicroRed=" + idMicroRed + "&idUnidadEjec=" + idUnidadEjec,
        success: function(data) {
            //console.log(data);
            $("#idmicrored").html(data)
        }
    });
}

function Estalecimiento(idMicroRed, idEst) {
    $.ajax({
        type: "POST",
        url: carpeta + "establecimiento.php",
        data: "idMicroRed=" + idMicroRed + "&idEst=" + idEst,
        success: function(data) {
            $("#idestablecimiento").html(data)
        }
    });
}

function Redtestt2(idUnidadEjec) {

    $.ajax({
        type: "POST",
        url: carpeta + "red.php",
        data: "idue=" + idUnidadEjec + "&idred=" + 0,
        success: function(data) {
            $("#idred").html(data)
        }
    });
    $("#idred").val("");
    $("#idmicrored").val("");
    MicrooRed("", idUnidadEjec, 0);
    $("#idestablecimiento").val("");
    Estalecimiento("", 0);
}

function MicrooRed2(idRed, idUnidadEjec) {
    $("#idestablecimiento").val("");
    Estalecimiento("", 0);
    $.ajax({
        type: "POST",
        url: carpeta + "microred.php",
        data: "idRed=" + idRed + "&idMicroRed=" + 0 + "&idUnidadEjec=" + idUnidadEjec,
        success: function(data) {
            //console.log(data);
            $("#idmicrored").html(data)
        }
    });
}

function Estalecimiento2(idMicroRed) {
    $.ajax({
        type: "POST",
        url: carpeta + "establecimiento.php",
        data: "idMicroRed=" + idMicroRed + "&idEst=" + 0,
        success: function(data) {
            $("#idestablecimiento").html(data)
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
Redtestt(<?php echo $idorg_idejec; ?>, <?php echo $idorg_red; ?>);
MicrooRed(<?php echo $idorg_red;?>, <?php echo $idorg_idejec; ?>, <?php echo $idorg_micro;?>);
Estalecimiento(<?php echo $idorg_micro; ?>, <?php echo $idorg_estable; ?>);
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
        width: 1200px;
        /* control width here */
        height: auto;
        /* control height here */
        margin-left: -300px;
        padding-top: 10px;

    }
}
</style>


<!-- <form method="post" enctype="multipart/form-data"  id="user_form"  name="user_form"> -->
<div class="modal-content modal-lg">
    <div class="modal-header">
        <button type="button" onclick="regresar_index(carpeta);" class="close" data-dismiss="modal">&times; </button>
        <!--	<h3 class="modal-title text-primary" align="center"> <?php echo $nom_estab[1]["ejec"]; ?> </h3> -->
        <h3 class="modal-title text-success" align="center"> MOVIMIENTO DE BIENES MUEBLES N°
            <?php					
									if($op==1){
										$correlativo=1;
										$query ="select max(nroinventario) as correlativo from inventario_cabecera LIMIT 1;";
										$correlativos = $objconfig->execute_select($query,1);
										//var_dump($correlativos[1][0]["correlativo"]);
										//exit;
										if(count($correlativos[1])>0){
											//echo $correlativos[1]->correlativo."-";
											$correlativo= ((int)substr($correlativos[1][0]["correlativo"],-1))+1;
										}
										echo date("Y").substr(str_repeat(0, 2).$correlativo, - 2);
									}else{
										
										echo date("Y").substr(str_repeat(0, 2).$row["1"]["correlativo"], - 2);
									}
                                ?>
        </h3>
        </br>
        <form id="formHeader" name="formHeader" method="post" onsubmit="validarHeader(); return false;">
        <input type="text" name="Hcorrelativo" style="display:none" id="correlativo"
                    value="<?=date("Y").substr(str_repeat(0, 2).$correlativo, - 2);?>" <?php echo $readonly;?>
                    class="form-control" />    
		<div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label for="iddesplaza" class="control-label">Tipo de Desplazamiento: </label>
                    </div>
                    <div class="col-md-4">
                        <!-- <input type="hidden" name="0form_idejecutora" id="idejecutora" value="<?php //echo $nom_estab[1]["idejec"]; ?>"  />
							<input type="hidden" name="0form_idred" id="idred" value="<?php //echo $nom_estab[1]["idred"]; ?>"  /> -->
                            <select id="iddezplaza" name="Hidejecutora" class="form-control"
                            onchange="Redtestt2(this.value, <?php echo $idorg_red ?>)" required>
                            <option value="">---</option> -->
                            <?php /*
                                $queryT = "select idejecutora,descripcion 
                                from ejecutora where estareg=1 order by descripcion asc";
                                $itemsT = $objconfig->execute_select($queryT,1);

                                foreach($itemsT[1] as $rowT)
                                {
                                    $selected="";
                                    if($rowT["idejecutora"]==$nom_estab[1]["idejec"]){$selected="selected='selected'";}
                                    echo "<option value='".$rowT["idejecutora"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
                                }
                            */?>

                        </select> 
                    </div>

                    <div class="col-md-2">
                        <label>Fecha Inventario:</label>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy"
                            data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                            <input class="form-control" type="text" name="Hfecharecepcion" id="fecharecepcion"
                                value="<?php echo ($row[1]["fecharecepcion"])?$objconfig->FechaDMY2($row[1]["fecharecepcion"]):date("d/m/Y");?>"
                                readonly required>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>

                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-12" style="margin-top:2rem;">
                <div class="col-md-2">
                    <label for="idmicrored" class="control-label">Datos del Usuario del Bien: </label>
                </div>
                <div class="col-md-4">
                    <select id="idmicrored" name="Hidmicrored" class="form-control"
                        onchange="Estalecimiento2(this.value, <?php echo $idorg_micro; ?>)" required>
                    </select>
                    <!-- <div id="div-microred" name="div-microred"> </div> -->
                    <!-- <input type="hidden" name="0form_idejecutora" id="idejecutora" value="<?php //echo $nom_estab[1]["idejec"]; ?>"  />
						<input type="hidden" name="0form_idred" id="idred" value="<?php //echo $nom_estab[1]["idred"]; ?>"  /> -->
                    <!-- <select id="idmicrored" name="0form_idmicrored" class="form-control" onchange="Estalecimiento(this.value, <?php echo $idorg_micro; ?>)"  >
								<option value=""></option> -->
                    <?php
								/* $queryT = "select idmicrored,descripcion 
											from microred  where idred='".$idorg_red."'
											order by descripcion asc";
								$itemsT = $objconfig->execute_select($queryT,1);

								foreach($itemsT[1] as $rowT)
								{
									$selected="";
									if($rowT["idmicrored"]==$idorg_micro){$selected="selected='selected'";}
									echo "<option value='".$rowT["idmicrored"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
								} */
								?>
                    <!-- </select> -->
                </div>
                <div class="col-md-2">
                    <label for="atencion" class="control-label">Datos del usuario Receptor del Bien: </label>
                </div>
                <div class="col-md-4">
                    <select id="idestablecimiento" name="Hidestablecimiento" class="form-control" required>
                    </select>
                    <!-- <div id="div-estable" name="div-estable"> </div> -->

                </div>
                <input type="hidden" name="op" id="op" value="<?php echo $op; ?>" />

                <input type="hidden" name="Hidusuario" id="idusuario" value="<?=$idusuario[0]?>" />
                <input type="hidden" name="Hidusuario" id="idusuario" value="<?php echo $iduser; ?>" />
                <input type="hidden" name="Hnombre_usuario" id="nombre_usuario" value="<?=$idusuario[1]?>" />
            </div>
            <div class="col-md-12" style="margin-top:2rem;">

                <input type="text" name="Hidingreso" style="display:none" id="codigo" value="<?=$row[1]["idingreso"]?>"
                    <?php echo $readonly;?> class="form-control" />
                
                <div class="col-md-2">
                    <label for="idred" class="control-label">Área y/o Oficina del Usuario del Bien: </label>
                </div>
                <div class="col-md-4">
                    <!-- <input type="hidden" name="0form_idejecutora" id="idejecutora" value="<?php //echo $nom_estab[1]["idejec"]; ?>"  />
                            <input type="hidden" name="0form_idred" id="idred" value="<?php //echo $nom_estab[1]["idred"]; ?>"  /> -->
                    <select id="idred" name="Hidred" class="form-control"
                        onchange="MicrooRed2(this.value,<?php echo $idorg_idejec;?>, <?php echo $idorg_micro; ?>)"
                        required>
                    </select>
                    <!-- <div id="div-red" name="div-red"> </div> -->

                    <!-- <select id="idmicrored" name="0form_idmicrored" class="form-control" onchange="MicroRed(this.value, <?php echo $idorg_estable; ?>)"  >
                            
                            <option value=""></option>
                                
                        </select> -->
                </div>

                <div class="col-md-2">
                    <label for="atencion" class="control-label">Área y/o Oficina del Receptor del Bien: </label>
                </div>

                <div class="col-md-4">
                    <select id="idarea" name="idarea" class="form-control" onchange="cargar_subarea(this.value);"
                        required>
                        <option value=""></option>
                        <?php
						   		$queryT = "SELECT idarea, descripcion from areas where estareg=1 order by descripcion asc";
								$itemsT = $objconfig->execute_select($queryT,1);

								foreach($itemsT[1] as $rowT)
								{
									$selected="";
									if($rowT["idarea"]==$row[1]["idarea"]){$selected="selected='selected'";}
									echo "<option value='".$rowT["idarea"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";

								}
							?>
                    </select>
                </div>

            </div>

            
		</form>
    </div>

    <div class="modal-body">


        </br>
        <div class="panel panel-primary ">
            <div class="panel-heading">Relación de Bienes Muebles</div>
            </br>
            <form id="formDetalle" method="post" onsubmit="validarDetalle(); return false;">
                
                <div class="row">
                    <div class="col-md-12" style="margin-top:2rem;">
                        <div class="col-md-2" style="display:flex; justify-content:end;">
                            <label for="atencion" class="control-label">Unidad: </label>
                        </div>
                        <div class="col-md-4">
                        <select id="idarea" name="idarea" class="form-control" onchange="cargar_subarea(this.value);"
                                required>
                                <option value=""></option>
                                <?php
                                        $queryT = "SELECT idarea, descripcion from areas where estareg=1 order by descripcion asc";
                                        $itemsT = $objconfig->execute_select($queryT,1);

                                        foreach($itemsT[1] as $rowT)
                                        {
                                            $selected="";
                                            if($rowT["idarea"]==$row[1]["idarea"]){$selected="selected='selected'";}
                                            echo "<option value='".$rowT["idarea"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";

                                        }
                                    ?>
                            </select>
                        </div>
                        
                        <div class="col-md-1" style="display:flex; justify-content:center;">
                            <label for="atencion" class="control-label">Área Trabajo: </label>
                        </div>
                        <div id="div-subarea" class="col-md-4">
                            <select id="idareatrabajo" name="idareatrabajo" class="form-control">
                                <option value="0"></option>
                            </select>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-2" style="display:flex; justify-content:end;">
                            <label for="atencion" class="control-label">Responsable: </label>
                        </div>

                        <div class="col-md-9">
                            <input type="hidden" id="idpersonal" name="idpersonal" value="<?=$est_orig;?>" />
                            <input for="atencion" type="text" name="nombre_personal" id="nombre_personal"
                                readonly="readonly" onclick="buscar_personal();" value="<?php echo $establecimiento;?>"
                                placeholder="Click para Buscar Personal" class=" form-control" required />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12" style="margin-top:2rem;">
                        <div class="col-md-2" style="display:flex; justify-content:end;">
                            <label for="atencion" class="control-label">N° de Item: </label>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="nroitem" id="nroitem" class="form-control" 
                            value="" placeholder="N° de Item" data-toggle="tooltip" data-placement="top" 
                            title="N° de Item" required />
                        </div>

                        <div class="col-md-1" style="display:flex; justify-content:end;">
                            <label for="atencion" class="control-label">Marca: </label>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="nombre_marca" style="display:none" id="nombre_marca" value="0"
                                <?php //echo $readonly;?> class="form-control" />
                            <input type="text" name="marca" style="display:none" id="marca" value="0"
                                <?php //echo $readonly;?> class="form-control" />

                            <select class="form-control" onchange="cargar_marca(this.value);" required>
                                <option value=""></option>
                                <?php
						$queryT2 = "select idmarca, descripcion from marcas where estareg=1 order by descripcion ASC ";
						$itemsT2 = $objconfig->execute_select($queryT2,1);

						foreach($itemsT2[1] as $rowT2)
						{
							$selected="";
							echo "<option value='".$rowT2["idmarca"]."-".$rowT2["descripcion"]."' ".$selected." >".strtoupper($rowT2["descripcion"])."</option>";
						}

						?>
                            </select>
                        </div>
                        <div class="col-md-1" style="display:flex; justify-content:end;">
                            <label>Modelo: </label>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="modelo" id="modelo" onkeyup="mayuscula(this);" class="form-control" value=""  placeholder="Modelo del Material" data-toggle="tooltip" data-placement="top" title="Modelo del Material" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12" style="margin-top:2rem;">
                        <div class="col-md-2" style="display:flex; justify-content:end;">
                            <label for="atencion" class="control-label">Tipo Material: </label>
                        </div>
                        <div class="col-md-5">
                            <input type="hidden" id="unid" name="unid" value="" />
                            <input type="hidden" id="tipmate" name="tipmate" value="" />
                            <input type="hidden" id="material" name="material" value="" />
                            <input for="atencion" type="text" name="nombre_material" id="nombre_material"
                                readonly="readonly" onclick="buscar_material();" value=""
                                placeholder="Click para Buscar Materiales" class=" form-control" required />
                        </div>

                        <div class="col-md-1" style="display:flex; justify-content:end;">
                            <label for="atencion" class="control-label">Estado: </label>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="nombre_estado" style="display:none" id="nombre_estado" value="0"
                                <?php echo $readonly;?> class="form-control" />
                            <input type="text" name="estado" style="display:none" id="estado" value="0"
                                <?php echo $readonly;?> class="form-control" />

                            <select class="form-control" onchange="cargar_estado(this.value);" required>
                                <option value=""></option>
                                <?php
							$queryT2 = "select idtipobien, descripcion from tipo_bien where estareg=1 order by descripcion ASC ";
							$itemsT2 = $objconfig->execute_select($queryT2,1);

							foreach($itemsT2[1] as $rowT2)
							{
								$selected="";
								echo "<option value='".$rowT2["idtipobien"]."-".$rowT2["descripcion"]."' ".$selected." >".strtoupper($rowT2["descripcion"])."</option>";
							}
							?>
                            </select>
                        </div>
                    </div>
                </div>
                
                </br>

                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-2" style="display:flex; justify-content:end;">
                            <label for="atencion" class="control-label">Cod. Patrimonial:</label>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="codpatri" id="codpatri" onkeyup="mayuscula(this);"
                                class="form-control" value="" placeholder="Codigo Patrimonial" data-toggle="tooltip"
                                data-placement="top" title="Codigo Patrimonial" required />
                        </div>

                        <div class="col-md-2" style="display:flex; justify-content:center;">
                            <label for="atencion" class="control-label">Cod. Patrimonial Lab:</label>
                        </div>

                        <div class="col-md-2">
                            <input type="text" name="codpatrilab" id="codpatrilab" onkeyup="mayuscula(this);"
                                class="form-control" value="" placeholder="Codigo Patrimonial" data-toggle="tooltip"
                                data-placement="top" title="Codigo Patrimonial" required />
                        </div>

                        <div class="col-md-1" style="display:flex; justify-content:end;">
                            <label for="atencion" class="control-label">N° Serie: </label>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="serie" id="serie" class="form-control" onkeyup="mayuscula(this);"
                                value=""
                                placeholder="Para Ingresar mas de un Numero de Serie, use como separador el caracter ','"
                                data-toggle="tooltip" data-placement="top"
                                title="Para Ingresar mas de un Numero de Serie, use como separador el caracter ','"
                                required />
                        </div>
                    </div>
                </div>
                </br>
                <div class="row">
                    <div class="col-md-12">
                        
                        <div class="col-md-2" style="display:flex; justify-content:end;">
                            <label for="atencion" class="control-label">Observaciones: </label>
                        </div>

                        <div class="col-md-7">
                            <input required type="text" name="observacion" id="observacion" class="form-control"
                                onkeyup="mayuscula(this);" value="<?=$row[1]["observacion"]?>"
                                placeholder="Observaciones" data-toggle="tooltip" data-placement="top"
                                title="Observaciones" />
                        </div>
                        <div class="col-md-2" style="display:flex; justify-content:end;">
                            <input type="submit" name="action" class="btn btn-info mx-2" value="Agregar" />
                        </div>
                    </div>
                </div>
            
                </br>

                <div style="height:280px;  overflow-x:hidden;">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-info ">
                                <div class="panel-heading">DETALLES DEL DOCUMENTO </div>
                                <div class="panel-body">
                                    <table class="table table-striped table-bordered table-hover table-responsive"
                                        id="tbdiagnostico" name="tbdiagnostico">
                                        <thead>

                                            <tr>
                                                <td>#</td>
                                                <td>Responsable</td>
                                                <td>Area trabajo</td>
                                                <td>N° de Item</td>
                                                <td>Marca</td>
                                                <td>Modelo</td>
                                                <td>Cod. Patrimonial</td>
                                                <td></td>
                                                <td>Estado</td>
                                                <td>N° Serie</td>
                                                <td>Anular</td>
                                                <td>Editar</td>

                                            </tr>

                                        </thead>
                                        <tbody id="table-detalle">
                                <?php
							$count_enf=0;
							$sqlF = "select i.idingreso , i.cantidad, i.idmaterial , i.idmarca , i.serie , i.idtipobien, i.fvencimiento,
							md.descripcion as modelo, i.idmodelo, i.pcompra , i.pventa , i.codpatri,i.codpatrilab , i.idunidad , i.idtipomaterial, b.descripcion as tipbien,
							u.descripcion as unidad, m.descripcion as tpmate, mc.descripcion as mrcas, i.lote
							
									from ingreso_det as i
									inner join tipo_bien as b on(b.idtipobien=i.idtipobien)
									inner join unidad_medida as u on(u.idunidad=i.idunidad)
									inner join materiales as m on(m.idmaterial=i.idmaterial)
									inner join marcas as mc on(mc.idmarca=i.idmarca)
									inner join modelo as md on(md.idmodelo=i.idmodelo)
									where i.idingreso=".$cod." ";
							$rowF = $objconfig->execute_select($sqlF,1); 
							foreach($rowF[1] as $rF)
							{ 
								$count_enf++;

								?>
                                            <tr id='itemdiagnostico<?php echo $count_enf; ?>'
                                                name='itemdiagnostico<?php echo $count_enf; ?>'>

                                                <td>
                                                    <p style='display:none' id='mate<?php echo $count_enf; ?>'>
                                                        <?php echo $rF["idmaterial"]; ?></p>
                                                    <input type='hidden' name='idtipomaterial<?php echo $count_enf; ?>'
                                                        id='idtipomaterial<?php echo $count_enf; ?>'
                                                        value='<?php echo $rF["idtipomaterial"]; ?>' />
                                                    <input type='hidden' name='idunidad<?php echo $count_enf; ?>'
                                                        id='idunidad<?php echo $count_enf; ?>'
                                                        value='<?php echo $rF["idunidad"]; ?>' />
                                                    <input type='hidden' name='idingreso<?php echo $count_enf; ?>'
                                                        id='idingreso<?php echo $count_enf; ?>'
                                                        value='<?php echo $rF["idingreso"]; ?>' />
                                                    <?php echo $count_enf ; ?>
                                                </td>
                                                <td>
                                                    <input type='hidden' name='cantidad<?php echo $count_enf; ?>'
                                                        id='cantidad<?php echo $count_enf; ?>'
                                                        value='<?php echo $rF["cantidad"]; ?>' />
                                                    <?php echo intval($rF["cantidad"] ); ?>
                                                </td>
                                                <td>
                                                    <input type='hidden' name='idmaterial<?php echo $count_enf; ?>'
                                                         id='idmaterial<?php echo $count_enf; ?>'
                                                        value='<?php echo $rF["idmaterial"]; ?>' />
                                                    <?php echo strtoupper($rF["unidad"]." - ".$rF["tpmate"] ); ?>
                                                    */
                                                </td>
                                                <td>
                                                    <input type='hidden' name='idmarca<?php echo $count_enf; ?>'
                                                        id='idmarca<?php echo $count_enf; ?>'
                                                        value='<?php echo $rF["idmarca"]; ?>' />
                                                    <?php echo strtoupper($rF["mrcas"] ); ?>
                                                </td>
                                                <td>
                                                    <input type='hidden' name='serie<?php echo $count_enf; ?>'
                                                        id='serie<?php echo $count_enf; ?>'
                                                        value='<?php echo $rF["serie"]; ?>' />
                                                    <?php echo strtoupper($rF["serie"] ); ?>
                                                </td>
                                                <td>
                                                    <input type='hidden' name='idtipobien<?php echo $count_enf; ?>'
                                                        id='idtipobien<?php echo $count_enf; ?>'
                                                        value='<?php echo $rF["idtipobien"]; ?>' />
                                                    <?php echo strtoupper($rF["tipbien"] ); ?>
                                                </td>
                                                <td>
                                                    <input type='hidden' name='fvencimiento<?php echo $count_enf; ?>'
                                                        id='fvencimiento<?php echo $count_enf; ?>'
                                                        value='<?php echo $rF["fvencimiento"]; ?>' />
                                                    <?php echo strtoupper($rF["fvencimiento"] ); ?>
                                                </td>
                                                <td>
                                                    <input type='hidden' name='idmodelo<?php echo $count_enf; ?>'
                                                        id='idmodelo<?php echo $count_enf; ?>'
                                                        value='<?php echo $rF["idmodelo"]; ?>' />
                                                    <?php echo strtoupper($rF["modelo"] ); ?>
                                                </td>
                                                <td>
                                                    <input type='hidden' name='pcompra<?php echo $count_enf; ?>'
                                                        id='pcompra<?php echo $count_enf; ?>'
                                                        value='<?php echo $rF["pcompra"]; ?>' />
                                                    <?php echo number_format($rF["pcompra"],2 ); ?>
                                                </td>
                                                <td>
                                                    <input type='hidden' name='pventa<?php echo $count_enf; ?>'
                                                        id='pventa<?php echo $count_enf; ?>'
                                                        value='<?php echo $rF["pventa"]; ?>' />
                                                    <?php echo number_format($rF["pventa"],2 ); ?>
                                                </td>
                                                <td>
                                                    <input type='hidden' name='lote<?php echo $count_enf; ?>'
                                                        id='lote<?php echo $count_enf; ?>'
                                                        value='<?php echo $rF["lote"]; ?>' />
                                                    <?php echo $rF["lote"]; ?>
                                                </td>
                                                <td>
                                                    <input type='hidden' name='codpatri<?php echo $count_enf; ?>'
                                                        id='codpatri<?php echo $count_enf; ?>'
                                                        value='<?php echo $rF["codpatri"]; ?>' />
                                                    <?php echo strtoupper($rF["codpatri"] ); ?>
                                                </td>
                                                <td>
                                                    <input type='hidden' name='codpatrilab<?php echo $count_enf; ?>'
                                                        id='codpatrilab<?php echo $count_enf; ?>'
                                                        value='<?php echo $rF["codpatrilab"]; ?>' />
                                                    <?php echo strtoupper($rF["codpatrilab"] ); ?>
                                                </td>
   
                                                <td>

                                                    <img src='../img/cancel.png' style='cursor:pointer'
                                                        onclick='quitar_diagnostico(<?php echo $count_enf; ?>)'
                                                        title='Borrar Registro' />

                                                </td>
                                                <td>
                                                    <img src='../img/edit.png' style='cursor:pointer'
                                                        onclick='editar_diagnostico(<?php echo $count_enf; ?>)'
                                                        title='Editar Registro' />
                                                </td>

                                            </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                    <input type="hidden" id="contar_diagnostico" name="contar_diagnostico"
                                        value="<?php echo $count_enf; ?>" />
                                    <input type="hidden" id="contar_diagnostico2" name="contar_diagnostico2"
                                        value="<?php echo $count_enf; ?>" />
                                    <script>
                                    var count_enf = <?php echo $count_enf; ?>;
                                    var count_edit = null;
                                    TablaDetalleArray.map(row => addTable(row));
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>


    <div class="upload-msg col-md-12"></div>
    <!--Para mostrar la respuesta del archivo llamado via ajax -->
    <div class="modal-footer">
        <!--		<input type="hidden" name="user_id" id="user_id" />
								<input type="hidden" name="operation" id="operation" /> -->
        <button type="submit" form="formHeader" name="action" id="action" class="btn btn-success">Guardar</button>
        <button type="button" onclick="regresar_index(carpeta);" class="btn btn-default" data-dismiss="modal"
            data-backdrop="false"> Cerrar </button>
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

<script type="text/javascript">
Redtestt(<?php echo $idorg_idejec; ?>, <?php echo $idorg_red; ?>);
MicrooRed(<?php echo $idorg_red;?>, <?php echo $idorg_idejec; ?>, <?php echo $idorg_micro;?>);
Estalecimiento(<?php echo $idorg_micro; ?>, <?php echo $idorg_estable; ?>);
cargar_subarea(<?php echo $idare;?>)
cargar_marca("0")

//<![CDATA[
$(document).ready(function() {
    $('.combobox').combobox()
});
//]]>

$('#myTab a').on('click', function(e) {
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
$(function() {
    $('[data-toggle="tooltip"]').tooltip()
})
</script>