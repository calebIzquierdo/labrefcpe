<?php
	include("../../objetos/class.cabecera.php");	
    include("../../objetos/class.conexion.php");
?>

<style>
    table,  td {
        border: 0px solid black;
        font-size: 12px;
    }

</style>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Registro Distribución de Kits para Diagnósticos</h1>
		
		<div align="left">
            <button type="button" id="add_button" name="add_button" data-toggle="modal" data-backdrop="static" data-keyboard="false" onclick="cargar_form(1,0)" data-target="#userModal" class="btn btn-info btn-lg">Nuevo</button>
		</div>
		<div class="custom-control custom-switch" align="right">
		<!--
			<input type="checkbox" class="custom-control-input" id="anuladosswitch"/>
			<label class="custom-control-label" for="customSwitches">Mostar anulados</label>
			-->
		</div>
	</div>
</div>


<div class="row">
	<div class="col-lg-12">
		<br/>
		<table id="dataTables-example"  class="table table-striped table-bordered table-hover" width="100%" >
			<thead class="thead-inverse">
				<tr>
					<th> # </th>
					<th>Recepción</th>
					<th>Solicitado</th>
					<th>UndMed </th>
					<th>Tipo</th>
					<th>Descripción</th>
					<th>Marca</th>
					<th>Saldos.</th>
					<th>Lote.</th>
					<th>Editar.</th>
					<th>Reporte.</th> 
					<th>Digitado por:</th> 
				</tr>
			</thead>
		</table> 
	</div>
</div>
   

<div id="userModal" name="userModal" class="modal fade">
	<div class="modal-dialog">
		<div id="modal-body" name="modal-body"> 

		</div>
	</div>
</div>

<!-- Modal 
	Pagina para la carga de los repore pdf
-->
<div class="modal fade bd-example-modal-xl" id="impresiones" name="impresiones"  tabindex="0" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" onclick="regresar_index(carpeta)" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title text-center" id="myModalLabel">NOTA DE SALIDA - LABORATORIO REFERENCIAS DE SAN MARTIN</h4> 
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
<script>
var carpeta = "../laboratorio/kitssalida/";

</script>