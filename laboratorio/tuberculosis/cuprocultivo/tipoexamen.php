<?php
    include("../../../objetos/class.conexion.php");

    $objconfig  = new conexion();

    $idingreso =  $_POST["idcod"];
	
  	$queryT = "select   idtipo_examen, descripcion, idareatrabajo, idarea,estareg 
	FROM tipo_examen where estareg=1 order by descripcion asc";
//	echo $queryT ;
	$itemsT = $objconfig->execute_select($queryT,1);


?>
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-3">
				<label for="atencion" class="control-label"> Tipo Muestra </label>
			</div>
			<div class="col-md-9">
				<select id="idtipo_examen" name="0form_idtipo_examen" class="form-control combobox" placeholder="Seleccionar Codigo de Barra" data-toggle="tooltip" data-placement="top" title="Seleccionar Codigo de Barra">
			<option value="0"></option>
			<?php
			
			foreach($itemsT[1] as $rowT)
			{
				$selected="";
				if($rowT["idtipo_examen"]==$idingreso){$selected="selected='selected'";}
				echo "<option value='".$rowT["idtipo_examen"]."' ".$selected." >".strtoupper($rowT["descripcion"] )."</option>";
			}
			?>
		</select>
			</div>

		</div>
	</div>

<script type="text/javascript">
   
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