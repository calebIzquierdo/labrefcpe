<?php
include("../../objetos/class.cabecera.php");	
include("../../objetos/class.conexion.php");
	
?>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">MicroRed de Salud</h1>
		
		<div align="left">
			<button type="button" id="add_button" data-toggle="modal" onclick="cargar_form(1,0)" data-target="#userModal" class="btn btn-info btn-lg">Nuevo</button>
		</div>
	</div>
	
	<!-- /.col-lg-12 -->
</div>

<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-heading">
                        
                        <!-- /.panel-heading -->
			<div class="panel-body">
			<table id="dataTables-example"  class="table table-striped table-bordered table-hover" width="100%" >
			<thead>
			<tr align="center">
					<th>N°</th>
					<th>Red de Salud</th>
					<th>Microred</th>
					<th >Direccion </th>
					<th >Representante </th>
					<th >Estado </th>
					<th>Accion</th>
			</tr>
			</thead>
			
			</table> 
            </div>
            </div>
        </div>
    </div>
   

<div id="userModal" name="userModal" class="modal fade">
	<div class="modal-dialog">
		<div id="modal-body" name="modal-body"> 
		
		</div>

		</div>
	</div>
</div>

