<?php
include("../../objetos/class.cabecera.php");	
include("../../objetos/class.conexion.php");
	
?>
<style>

.enlace {
  display:inline;
  border:0;
  padding:0;
  margin:0;
  text-decoration:underline;
  background:none;
  color:#000088;
  font-family: arial, sans-serif;
  font-size: 1em;
  line-height:1em;
}

.enlace:hover {
  text-decoration:none;
  color:#0000cc;
  cursor:pointer;
}

</style>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Establecimiento de Salud</h1>
		
		<div class="col-lg-6">
			<div align="left">
				<button type="button" id="add_button" data-toggle="modal" onclick="cargar_form(1,0)" data-target="#userModal" class="btn btn-info btn-lg">Nuevo</button>
			</div>
		</div>
		<div class="col-lg-6">
			<div align="right">
			<a href="http://app20.susalud.gob.pe:8080/registro-renipress-webapp/listadoEstablecimientosRegistrados.htm?action=mostrarBuscar#no-back-button" target="_blank">
				<button class="btn btn-success btn-lg">Buscar Renaes</button>
			</a>
		</div>
		</div>
</div>

<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-heading">
                        
                        <!-- /.panel-heading -->
			
			<table id="dataTables-example"  class="table table-striped table-bordered table-hover" width="100%" >
			<thead>
			<tr align="center">
					<th>N°</th>
					
					<th>Ejecutora</th>
					<th>Red de Salud</th>
					<th>Microred</th>
					<th>Establecimiento</th>
					<th >COD RENAES </th>
					<th >CATEGORIA </th>
					<th >Tipo </th>
					<th>Ruc</th>
					<th>Accion</th>
			</tr>
			</thead>
			
			</table> 
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

