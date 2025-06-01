<?php
	include("../../objetos/class.cabecera.php");	
    include("../../objetos/class.conexion.php");
?>
<style>
    table,  td {
        border: 0px solid black;
     	/* font-family: "Times New Roman", serif; */
        font-size: 12px;
    }
    /* th{
        // el tamaño por defecto es 14px
      	color:#456789;
        font-size:12px;
    }
    .card-columns {
    	media-breakpoint-only(lg) {
        	column-count: 4;
    	}
    	media-breakpoint-only(xl) {
        	column-count: 5;
    	}
    } */


</style>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Lista de Requerimiento</h1>
	</div>
</div>


<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-8">
		<div class="col-md-3">
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="filter_estado" onclick="filtros()" id="filter_estado1" value="0" checked>
				<label class="form-check-label" for="filter_estado1">Todos</label>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="filter_estado" onclick="filtros()" id="filter_estado2" value="1">
				<label class="form-check-label" for="filter_estado2">Solo Pendientes</label>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="filter_estado" onclick="filtros()" id="filter_estado3" value="4">
				<label class="form-check-label" for="filter_estado3">Solo Aprobados</label>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="filter_estado" onclick="filtros()" id="filter_estado4" value="5">
				<label class="form-check-label" for="filter_estado4">Solo Entregados</label>
			</div>
		</div>
	</div>
	<div class="col-lg-12">
		<br/>
		<table id="dataTables-example"  class="table table-striped table-bordered table-hover" width="100%" >
			<thead class="thead-inverse">
				<tr>
					<th> # </th>
					<th>Correlativo</th>
					<th>Fecha</th>
					<th>Area</th>
					<th>Sub Area</th>
					<th>Solicitante</th>				               
					<th>Detales</th>
				<!-- <th></th>	-->
					<th>Accion</th>
					<th>Estado</th>
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
				<h4 class="modal-title text-center" id="myModalLabel">DETALLES DE COMPRAS REALIZADAS - LABORATORIO REFERENCIAS DE SAN MARTIN</h4> 
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
