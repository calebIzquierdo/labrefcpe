<?php
    include("../../objetos/class.cabecera.php");
    include("../../objetos/class.conexion.php");

    $objconfig = new conexion();

?>
<style >
    fieldset 
	{
		border: 1px solid #ddd !important;
		margin: 0;
		xmin-width: 0;
		padding: 10px;       
		position: relative;
		border-radius:20px;
		background-color:#f5f5f5;
		padding-left:10px!important;
	}

	legend
		{
			font-size:28px;
		/*	font-weight:bold;*/
			margin-bottom: 40px; 
			width: 35%; 
			border: 5px solid #ddd;
			border-radius: 18px; 
			padding: 10px 5px 5px 2px; 
			background-color: #28a0f8 ;
		}
</style>


<div class="col-lg-12">
    <h1 class="page-header">Reporte de Muestras Recibidas</h1>

</div>
<div class="modal-body">
<fieldset class="scheduler-border">
			<legend class="scheduler-border">Por Unidad Trabajo: </legend>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-1">
                <label for="atencion" class="control-label">UNIDAD:  </label>
            </div>

            <div class="col-md-3">
                <select id="area" name="area" class="combobox form-control" >
                    <option value="0"> Todos </option>
                    <?php
                    $queryT = "select idareatrabajo, descripcion  from area_trabajo 
							order by descripcion asc";
                    $itemsT = $objconfig->execute_select($queryT,1);

                    foreach($itemsT[1] as $rowT)
                    {
                        $selected="";
                        echo "<option value='".$rowT["idareatrabajo"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-1">
                <label for="atencion" class="control-label">Desde: </label>
            </div>
            <div class="col-md-2">
               <input class="form-control" type="date" name="finicioA" id="finicioA" value="<?php echo date("d/m/Y");?>"  >
            </div>
            <div class="col-md-1">
                <label for="atencion" class="control-label">Hasta: </label>
            </div>
            <div class="col-md-2">
                    <input class="form-control" type="date" name="ffinalA" id="ffinalA" value="<?php echo date("d/m/Y");?>"  >
            </div>
            <div class="col-md-2">
			<button class="btn btn-success btn-lg center-block" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target='#impresiones' onclick="imprimir_fichaA()"><span class="glyphicon glyphicon-print"></span> Imprimir Pdf</button>
            <!--     <input type="image" id="image" onclick="imprimir_ficha()" height="42" width="42" alt="Exportar Pdf" src="../img/pdf.png" /> -->
            </div>

        </div>
		</div>
		</fieldset>
		
	<fieldset class="scheduler-border">
			<legend class="scheduler-border">Por Exámen: </legend>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-1">
                <label for="atencion" class="control-label">Tipo:  </label>
            </div>

            <div class="col-md-3">
                <select id="idtiporeferencia" name="idtiporeferencia" class="combobox form-control" >
                    <option value="0"> Todos </option>
                    <?php
                    $queryT = "select idtipo_examen, descripcion  from tipo_examen 
					where idtipo_examen in (Select idtipo_examen from muestra_det group by idtipo_examen)
					order by descripcion asc";
                    $itemsT = $objconfig->execute_select($queryT,1);

                    foreach($itemsT[1] as $rowT)
                    {
                        $selected="";
                        if($rowT["idtipo_examen"]==$row[1]["idtipo_examen"]){$selected="selected='selected'";}
                        echo "<option value='".$rowT["idtipo_examen"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-1">
                <label for="atencion" class="control-label">Desde: </label>
            </div>
            <div class="col-md-2">
               <input class="form-control" type="date" name="finicio" id="finicio" value="<?php echo date("d/m/Y");?>"  >
            </div>
            <div class="col-md-1">
                <label for="atencion" class="control-label">Hasta: </label>
            </div>
            <div class="col-md-2">
                    <input class="form-control" type="date" name="ffinal" id="ffinal" value="<?php echo date("d/m/Y");?>"  >
            </div>
            <div class="col-md-2">
			<button class="btn btn-success btn-lg center-block" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target='#impresiones' onclick="imprimir_ficha()"><span class="glyphicon glyphicon-print"></span> Imprimir Pdf</button>
            <!--     <input type="image" id="image" onclick="imprimir_ficha()" height="42" width="42" alt="Exportar Pdf" src="../img/pdf.png" /> -->
            </div>

        </div>
		</div>
		</fieldset>
		<fieldset class="scheduler-border">
			<legend class="scheduler-border">Por Establecimiento: </legend>
			<div class="row">
					<div class="col-md-12">
						<div class="col-md-2">
							<label for="atencion" class="control-label">NOMBRE DE IPRESS:  </label>
						</div>
						<div class="col-md-8">
							<input type="hidden" id="idestablecimiento1" name="idestablecimiento1" value=""  />
							<input for="atencion" type="text" name="nombre_establecimiento" id="nombre_establecimiento"  readonly="readonly" onclick="buscar_establecimiento();" value="" placeholder="Click para seleccionar Establecimiento" class=" form-control" />

						</div>
					</div>
			</div>
			<br/>
			<div class="row">
			<div class="col-md-12">
			<div class="col-md-2">
                <label for="atencion" class="control-label">Desde: </label>
            </div>
            <div class="col-md-3">
                <input class="form-control" type="date" name="finicio21" id="finicio21" value="<?php echo date("d/m/Y");?>"  >
            </div>
            <div class="col-md-2">
                <label for="atencion" class="control-label">Hasta: </label>
            </div>
            <div class="col-md-3">

                <input class="form-control" type="date" name="ffinal21" id="ffinal21" value="<?php echo date("d/m/Y");?>"  >

            </div>
            <div class="col-md-2">
			<button class="btn btn-success btn-lg center-block" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target='#impresiones' onclick="imprimir_origen(1)">  <span class="glyphicon glyphicon-print"></span> Imprimir Pdf </button>
            <!--    <input type="image" id="image" onclick="imprimir_origen(1)" height="42" width="42" alt="Exportar Pdf" src="../img/pdf.png" /> <img src="../img/pdf.png" height="25px" weight="25px" alt="Pdf" />
			-->
            </div>
        </div>
    </div>
	</fieldset>
	
<fieldset class="scheduler-border">
			<legend class="scheduler-border">Exportar a Excel: </legend>
    <div class="row">
	<div class="col-md-12">
		    <div class="col-md-1">
                <label for="atencion" class="control-label">Red: </label>
            </div>
            <div class="col-md-3">
               <select id="red" name="red" onchange="cargar_microred(this.value);" class="form-control" >
                    <option value="0">Todos</option>
                    <?php
                    $queryT = "select idred, descripcion  from red where estareg=1 order by descripcion asc";
                    $itemsT = $objconfig->execute_select($queryT,1);

                    foreach($itemsT[1] as $rowT)
                    {
                        $selected="";
                        echo "<option value='".$rowT["idred"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-1">
                <label for="atencion" class="control-label">MicroRed: </label>
            </div>
            <div class="col-md-3">
             <div id="div-microred"> </div>
            </div>
			 <div class="col-md-1">
                <label for="atencion" class="control-label">E.E.S.S: </label>
            </div>
            <div class="col-md-3">
                    <div id="div-establecimiento"> </div>
            </div>
        </div>
        </div>
		</br>
    <div class="row">
        <div class="col-md-12">
		 <div class="col-md-1">
                <label for="atencion" class="control-label">Exam:  </label>
            </div>

            <div class="col-md-3">
                <select id="idexamen" name="idexamen" class="combobox form-control" >
                    <option value="0"> Todos </option>
                    <?php
                    $queryT = "select idtipo_examen, descripcion  from tipo_examen 
					where idtipo_examen in (Select idtipo_examen from muestra_det group by idtipo_examen)
					order by descripcion asc";
                    $itemsT = $objconfig->execute_select($queryT,1);

                    foreach($itemsT[1] as $rowT)
                    {
                        $selected="";
                        if($rowT["idtipo_examen"]==$row[1]["idtipo_examen"]){$selected="selected='selected'";}
                        echo "<option value='".$rowT["idtipo_examen"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
                    }
                    ?>
                </select>
            </div>
			
            <div class="col-md-1">
                <label for="atencion" class="control-label">Desde: </label>
            </div>
            <div class="col-md-3">
                <input class="form-control" type="date" name="finicioe" id="finicioe" value="<?php echo date("d/m/Y");?>"  >
            </div>
            <div class="col-md-1">
                <label for="atencion" class="control-label">Hasta: </label>
            </div>
            <div class="col-md-3">
                <input class="form-control" type="date" name="ffinale" id="ffinale" value="<?php echo date("d/m/Y");?>"  >
            </div>
            <div class="col-md-1">
               <input type="image" id="image" onclick="excel_ficha()" height="42" width="42" alt="Exportar Excel" src="../img/excel.jpg" />
            </div>

        </div>
    </div>
	</fieldset>
</div>

<div class="modal fade bd-example-modal-xl" id="impresiones" name="impresiones"  tabindex="0" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

	  <div class="modal-dialog modal-xl">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" onclick="regresar_index(carpeta)" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 class="modal-title text-center" id="myModalLabel">REPORTE DE MUESTRAS SOLICITADAS - LABORATORIO REFERENCIAS DE SAN MARTIN</h4> 
		  </div>
			<div class="modal-body">
			<div style="text-align: center;">
			<iframe name="mostrarpdf" id="mostrarpdf" src="" src=""  width="100%" height="800" frameborder="0"> </iframe>
			Derechos Reservados - Soporte Técnico.
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-primary" onclick="regresar_index(carpeta)" data-dismiss="modal">Cerrar</button>
		  </div>
		</div>
	  </div>
	</div>
	
<script type="text/javascript">
    //<![CDATA[
    $(document).ready(function(){
        $('.combobox').combobox()
    });
    //]]>
</script>