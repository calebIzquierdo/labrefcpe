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
    <h1 class="page-header">Reporte de datos de Alimentos y aguas</h1>

</div>
<div class="modal-body">

	
<fieldset class="scheduler-border">
			<legend class="scheduler-border">Exportar a Excel: </legend>		
    <div class="row">
        <div class="col-md-12">
			
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