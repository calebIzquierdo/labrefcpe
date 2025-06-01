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

	$idare = 0;
	$idaretrab = 0;

    $nombrepaciente ="";
    $est_orig ="";
    $idsbare =0;


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

        <h3 class="modal-title text-primary" align="center">INVENTARIO N° :
                <?php                                       
                        $query = "select * from inventario_cabecera where idinventario=".$cod;
                        $row = $objconfig->execute_select($query);
                        echo $row[1]['nroinventario'];
                    
                ?>
            </h3>
    </div>

    <div class="modal-body">

        </br>
        <div class="panel panel-primary ">
            <div class="panel-heading">Ingreso de Bienes Muebles</div>
            </br>
            <form id="formDetalle" method="post" onsubmit="validarDetalle(); return false;">
                <div class="row">
                    <div class="col-md-12 style=" margin-top:2rem;">
                        <div class="col-md-2" style="display:flex; justify-content:end;">
                            <label for="atencion" class="control-label">Unidad: </label>
                        </div>

                        <div class="col-md-4">
                            <select id="idarea" name="idarea" class="form-control"
                                onchange="cargar_subarea(this.value);" required>
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

                        <div class="col-md-1">
                            <label for="atencion" class="control-label">Área Trabajo: </label>
                        </div>
                        <div id="div-subarea" class="col-md-4">

                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="margin-top:2rem;">
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

                        <div class="col-md-1">
                            <label for="atencion" class="control-label">Marca: </label>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="nombre_marca" style="display:none" id="nombre_marca" value="0"
                                <?php echo $readonly;?> class="form-control" />
                            <input type="text" name="marca" style="display:none" id="marca" value="0"
                                <?php echo $readonly;?> class="form-control" />

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
                    </div>
                </div>

                <br>

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

                        <div class="col-md-1" style="display:flex; justify-content:center;">
                            <label>Modelo: </label>
                        </div>
                        <div id="div-modelo" class="col-md-2">
                        </div>
                    </div>
                </div>
                </br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-2" style="display:flex; justify-content:end;">
                            <label for="atencion" class="control-label">Color: </label>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="color" id="color" class="form-control" onkeyup="mayuscula(this);"
                                value="" placeholder="Para Ingresar el color el bien" required />
                        </div>
                        <div class="col-md-2" style="display:flex; justify-content:center;">
                            <label for="atencion" class="control-label">Estado: </label>
                        </div>
                        <div class="col-md-2">
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

                        <div class="col-md-1" style="display:flex; justify-content:center;">
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
                            <button type="submit" form="formDetalle" name="action" class="btn btn-info mx-2">Agregar </button>
                           
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
                                                <td>Tipo material</td>
                                                <td>Marca</td>
                                                <td>Modelo</td>
                                                <td>Cod. Patrimonial</td>
                                                <td>Cod. Patrimonial Lab.</td>
                                                <td>Color</td>
                                                <td>Estado</td>
                                                <td>N° Serie</td>
                                                <td>Accion</td>

                                            </tr>

                                        </thead>
                                        <tbody id="table-detalle">
                                            <?php
                                            $count_enf=0;
                                            $sqlF = "select i.idinventariodetalle,i.idarea, a.descripcion as a_nombre, at.descripcion as at_nombre, at.idareatrabajo,
                                                    i.idpersonal, p.nombres as p_nombre, i.idmaterial, mt.mate as mt_nombre, mt.umedida as mt_umedida,
                                                    i.idmarca, m.descripcion as m_nombre, i.codpatrimonial, i.codpatrimoniallab, mo.descripcion as mo_nombre,
                                                    i.idmodelo, i.color, i.estado, i.nroserie, i.observacion
                                                    from inventario_detalle as i
                                                    inner join areas as a on(a.idarea=i.idarea)
                                                    inner join area_trabajo as at on(at.idareatrabajo=i.idareatrabajo)
                                                    inner join personal as p on(p.idpersonal=i.idpersonal)
                                                    inner join vista_materiales as mt on(mt.idmaterial=i.idmaterial)
                                                    inner join marcas as m on(m.idmarca=i.idmarca)
                                                    inner join modelo as mo on (mo.idmodelo=i.idmodelo)
                                                    where i.idinventario=".$cod." ";
                                            $rowF = $objconfig->execute_select($sqlF,1); 
        
                                            foreach($rowF[1] as $rF)
                                            { $count_enf++; ?>
                                                <tr id="itemdiagnostico<?php echo $count_enf ?>"> 
                                                    <td><?php echo $count_enf ?></td>
                                                    <td><?php echo $rF["p_nombre"]?></td>
                                                    <td><?php echo $rF["a_nombre"].' - '.$rF["at_nombre"]?></td>
                                                    <td><?php echo $rF["mt_umedida"].' - '.$rF["mt_nombre"]?></td>
                                                    <td><?php echo $rF["m_nombre"] ?></td>
                                                    <td><?php echo $rF["mo_nombre"]?></td>
                                                    <td><?php echo $rF["codpatrimonial"]?></td>
                                                    <td><?php echo $rF["codpatrimoniallab"]?></td>
                                                    <td><?php echo $rF["color"]?></td>
                                                    <td><?php echo $rF["estado"]?></td>
                                                    <td><?php echo $rF["nroserie"]?></td>                                                
                                                    <td>
                                                        <button type="button"  data-backdrop="static" data-keyboard="false" onclick="eliminar_item(<?php echo $rF['idinventariodetalle'] ?>,<?php echo $count_enf ?>)" class="btn btn-outline btn-danger btn-primary btn-xs">Quitar</button>
                                                    </td>
                                                </tr>
                                            <?php 

                                            } ?>
                                        </tbody>
                                    </table>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="op" id="op" value="<?php echo $op; ?>" />
                <input type="hidden" name="cod" id="cod" value="<?php echo $_POST["cod"]; ?>" />
                <script> 
					var  count_enf=<?php echo $count_enf; ?>;							
				</script>
            </form>
        </div>
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