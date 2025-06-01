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
		$query = "select * from inventario_cabecera where idinventario=".$cod;
		$row = $objconfig->execute_select($query);
        $idorg_idejec= $row[1]["idejecutora"];
        $idorg_red=$row[1]["idred"];
        $idorg_micro = $row[1]["idmicrored"];
        $idorg_estable =$row[1]["idestablecimiento"];

		$disable= "disabled";  
	
        /* $esta= "select idproveedor, nrodocumento,razonsocial from proveedor where idproveedor=".$row[1]["idproveedor"];
		
        $rowEstable = $objconfig->execute_select($esta); */

        //$establecimiento = $rowEstable[1]["codrenaes"]." / ".$rowEstable[1]["esta"]." / ".$rowEstable[1]["micro"]." / ".$rowEstable[1]["red"]." / ".$rowEstable[1]["eje"];
        /* $establecimiento = $rowEstable[1]["nrodocumento"]." - ".$rowEstable[1]["razonsocial"];
        $est_orig = $rowEstable[1]["idproveedor"]; */

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
        <h3 class="modal-title text-success" align="center"> INVENTARIO DE BIENES MUEBLES N°
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
										$query = "select * from inventario_cabecera where idinventario=".$cod;
		                                $row = $objconfig->execute_select($query);
										echo $row[1]['nroinventario'];
									}
                                ?>
        </h3>
        </br>
        <form id="formHeader" name="formHeader" method="post" onsubmit="validarHeader(); return false;">
            <input type="text" name="Hcorrelativo" style="display:none" id="correlativo"
                value="<?php
                if($op==1){
                    echo date("Y").substr(str_repeat(0, 2).$correlativo, - 2);
                
                }else{
                    echo $row[1]['nroinventario'];
                }
                ?>" <?php echo $readonly;?>
                class="form-control" />
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <label for="idunidadejec" class="control-label">UNIDAD EJECUTORA: </label>
                    </div>
                    <div class="col-md-4">
                        <!-- <input type="hidden" name="0form_idejecutora" id="idejecutora" value="<?php //echo $nom_estab[1]["idejec"]; ?>"  />
							<input type="hidden" name="0form_idred" id="idred" value="<?php //echo $nom_estab[1]["idred"]; ?>"  /> -->
                        <select id="idunidadejec" name="Hidejecutora" class="form-control"
                            onchange="Redtestt2(this.value, <?php echo $idorg_red ?>)" required>
                            <option value="">---</option>
                            <?php
									$queryT = "select idejecutora,descripcion 
									from ejecutora where estareg=1 order by descripcion asc";
									$itemsT = $objconfig->execute_select($queryT,1);

									foreach($itemsT[1] as $rowT)
									{
										$selected="";
										if($rowT["idejecutora"]==$nom_estab[1]["idejec"]){$selected="selected='selected'";}
										echo "<option value='".$rowT["idejecutora"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
									}
								?>

                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="idred" class="control-label">RED: </label>
                    </div>
                    <div class="col-md-4">
                        <!-- <input type="hidden" name="0form_idejecutora" id="idejecutora" value="<?php //echo $nom_estab[1]["idejec"]; ?>"  />
								<input type="hidden" name="0form_idred" id="idred" value="<?php //echo $nom_estab[1]["idred"]; ?>"  /> -->
                        <select id="idred" name="Hidred" class="form-control"
                            onchange="MicrooRed2(this.value,<?php echo $idorg_idejec;?>, <?php echo $idorg_micro; ?>)"
                            required>
                        </select>
 
                    </div>
                </div>

            </div>
            <div class="col-md-12" style="margin-top:2rem;">
                <div class="col-md-2">
                    <label for="idmicrored" class="control-label">MICRORED: </label>
                </div>
                <div class="col-md-4">
                    <select id="idmicrored" name="Hidmicrored" class="form-control"
                        onchange="Estalecimiento2(this.value, <?php echo $idorg_micro; ?>)" required>
                    </select>
                   
                </div>
                <div class="col-md-2">
                    <label for="atencion" class="control-label">ESTABLECIMIENTO: </label>
                </div>
                <div class="col-md-4">
                    <select id="idestablecimiento" name="Hidestablecimiento" class="form-control" required>
                    </select>
                    <!-- <div id="div-estable" name="div-estable"> </div> -->

                </div>
                <input type="hidden" name="op" id="op" value="<?php echo $op; ?>" />
                <input type="hidden" name="cod" id="cod" value="<?php echo $_POST["cod"]; ?>" />

                <input type="hidden" name="Hidusuario" id="idusuario" value="<?=$idusuario[0]?>" />
                <input type="hidden" name="Hidusuario" id="idusuario" value="<?php echo $iduser; ?>" />
                <input type="hidden" name="Hnombre_usuario" id="nombre_usuario" value="<?=$idusuario[1]?>" />
            </div>
            <div class="col-md-12" style="margin-top:2rem;">

                <input type="text" name="Hidingreso" style="display:none" id="codigo" value="<?=$row[1]["idingreso"]?>"
                    <?php echo $readonly;?> class="form-control" />


                <div class="col-md-2">
                    <label>Fecha Inventario:</label>
                </div>
                <div class="col-md-4">
                    <div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy"
                        data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                        <input class="form-control" type="text" name="Hfecharecepcion" id="fecharecepcion"
                            value="<?php echo ($row[1]["fechainventario"])?$objconfig->FechaDMY2($row[1]["fechainventario"]):date("d/m/Y");?>"
                            readonly required>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>

                    </div>
                </div>
                <div class="col-md-6">
                    <button type="submit" form="formHeader" name="action" id="action" class="btn btn-success"><?php if($op==1 ){ echo "Generar Inventario";}else{echo "Actualizar";}?></button>                                
                </div>
            </div>

        </form>

    </div>

    


    <div class="upload-msg col-md-12"></div>
    <!--Para mostrar la respuesta del archivo llamado via ajax -->
    <div class="modal-footer">
    <button type="button" onclick="regresar_index(carpeta);" class="btn btn-default" data-dismiss="modal"
            data-backdrop="false"> Cerrar </button>
        
    </div>

    <!-- Termino del Primer tab    </div> </div>       </fieldset>  -->
</div>
</div>

</div>


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
$(document).on('change', '#idareatrabajo', function(event) {
    $('#nombreareatrabajo').val($("#idareatrabajo option:selected").text());
});
</script>