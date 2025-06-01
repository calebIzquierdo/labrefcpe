<?php
include("../../objetos/class.cabecera.php");

?>

<style>
    table,  td {
        border: 0px solid black;
     /*   font-family: "Times New Roman", serif; */
        font-size: 12px;
    }
    th{
        /* el tamaño por defecto es 14px
      color:#456789; */
        font-size:12px;
    }
    .card-columns {
    media-breakpoint-only(lg) {
        column-count: 4;
    }
    media-breakpoint-only(xl) {
        column-count: 5;
    }
    }


</style>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Catálogo de Usuarios</h1>
		
		<div align="left">
			<button type="button" id="add_button" data-toggle="modal" onclick="cargar_form(1,0)" data-target="#userModal" class="btn btn-info btn-lg">Nuevo</button>
		</div>
	</div>
	
	<!-- /.col-lg-12 -->
</div>


<div class="row">
		<div class="col-lg-12">
			
			<!-- <div class="panel panel-heading"> /.panel-heading -->
			<div class="panel-body">
			<table id="dataTables-example"  class="table table-striped table-bordered table-hover" width="100%" >
			<thead>
			<tr>
				<th>N°</th> 
            	<th>Nombres</th>
            	<th>Usuario</th>
            	<th>Clave</th>
            	<th>Nivel</th>
            	<th>Establecimiento Salud</th>
				<th>Red</th>
            	<th>Estado</th>
            	<th>Accion </th>
			</tr>
			
			</thead>
			
			</table> 
            </div>
			<!-- 
            </div> -->
        </div>
    </div>
   

<div id="userModal" name="userModal" class="modal fade">
	<div class="modal-dialog">
		<div id="modal-body" name="modal-body"> 
		
		</div>

		</div>
	</div>
</div>
