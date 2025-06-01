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
		$query = "select * from correlativo_patrimonio_estable where idcorrelativo=".$cod;
		$row = $objconfig->execute_select($query);

        $idorg_micro = $row[1]["idmicrored"];
        $idorg_estable =$row[1]["idestablecimiento"];
        $idsbare =$row[1]["idsubalimento"];

		$disable= "disabled";  
	
        $esta= "select idestablecimiento, eje,red, micro, esta,codrenaes,ruc, idred from vista_establecimiento where idestablecimiento=".$row[1]["idestablesolicita"];
        $rowEstable = $objconfig->execute_select($esta);

       if ($rowEstable[1]["idred"]!=8){
        $establecimiento = $rowEstable[1]["codrenaes"]." - ".$rowEstable[1]["esta"]." / ".$rowEstable[1]["micro"]." / ".$rowEstable[1]["red"];
	   }else {
		 $establecimiento = $rowEstable[1]["ruc"]." - ".$rowEstable[1]["esta"]." / ".$rowEstable[1]["micro"]." / ".$rowEstable[1]["red"];  
	   }
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
/*	@media (min-width: 768px) {
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
	*/
</style>

<form method="post" enctype="multipart/form-data"  id="user_form"  name="user_form">
		<div class="modal-content modal-lg">
			<div class="modal-header">
				<button type="button" onclick="regresar_index(carpeta);" class="close" data-dismiss="modal">&times; </button>
			<!--	<h3 class="modal-title text-primary" align="center"> <?php echo $nom_estab[1]["ejec"]; ?> </h3> -->
				<h3 class="modal-title text-success" align="center"> Registro de Correlativo Patrimonial Por establecimiento</h3>
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

				<input type="hidden" name="0form_codrenae" id="codrenae" value="<?=$row[1]["codrenae"]?>"  />
				<input type="hidden" name="op" id="op" value="<?php echo $op; ?>"  />
				<input type="hidden" name="0form_idusuario" id="idusuario" value="<?=$idusuario[0]?>"  />
				<input type="hidden" name="0form_idusuario" id="idusuario" value="<?php echo $iduser; ?>"  />
				<input type="hidden" name="0form_nombre_usuario" id="nombre_usuario" value="<?=$idusuario[1]?>"  />
				<input type="hidden" name="1form_idcorrelativo" id="codigo" value="<?=$row[1]["idcorrelativo"]?>" />
			</div>
			<div class="modal-body">

			<div class="row">
				<div class="col-md-12">
					<div class="col-md-2">
						<label for="atencion" class="control-label">Procedencia:  </label>
					</div>

					<div class="col-md-10">
						<input type="hidden" id="idpriva" name="0form_idpriva" value="<?=$row[1]["idpriva"]?>"  />
						<input type="hidden" id="idestablesolicita" name="0form_idestablesolicita" value="<?=$est_orig;?>"  />
						<input for="atencion" type="text" name="nombre_establecimiento" id="nombre_establecimiento"  readonly="readonly" onclick="buscar_establecimiento();" value="<?php echo $establecimiento;?>" placeholder="Click para seleccionar Establecimiento" class=" form-control" />

					</div>
				</div>
			</div>
			</br>
			<div class="row">
			<div class="col-md-12">
			<div class="col-md-2">
				<label for="atencion" class="control-label">Periodo:  </label>
			</div>

			<div class="col-md-2">
				<select id="idanio" name="0form_idanio" onchange="genera_correlativo()"  class="form-control"  >
					<option value="0"></option>
					<?php
					$queryT2 = "select idanio, descripcion from anio where estareg=1 order by descripcion ASC ";
					$itemsT2 = $objconfig->execute_select($queryT2,1);

					foreach($itemsT2[1] as $rowT2)
					{
						$selected="";
						if($rowT2["idanio"]==$row[1]["idanio"]){$selected="selected='selected'";}
						echo "<option value='".$rowT2["idanio"]."' ".$selected." >".strtoupper($rowT2["descripcion"])."</option>";
					}
					?>
				</select>
			</div>
			<div class="col-md-2">
				<label for="atencion" class="control-label">Correolativo:  </label>
			</div>
			<div class="col-md-3"> 
			<input type="text" id="correlativo" name="0form_correlativo" onKeyPress="solonumeros(event)" onkeyup="genera_correlativo()" value="<?=$row[1]["correlativo"];?>" class="form-control"   />
			</div>
			<div class="col-md-3"> 
			<input for="atencion" type="text" name="nombre_correlativo" id="nombre_correlativo"  readonly="readonly"  class=" form-control" />
			</div>
			</div>
			</div>
			</br>
			
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

<script type="text/javascript">
	genera_correlativo()
    Estalecimiento(<?php echo $idorg_micro; ?>, <?php echo $idorg_estable; ?>)

   
	// Para usar un tooltip sin especificar tag en especial
	$(function () {
	$('[data-toggle="tooltip"]').tooltip()
	})
	
</script>