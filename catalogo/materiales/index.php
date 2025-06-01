<?php
	include("../../objetos/class.cabecera.php");	
	include("../../objetos/class.conexion.php");
?>


<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Catálogo de Materiales</h1>
		<div class="col-lg-6">
		<div align="left">
			<button type="button" id="add_button" data-toggle="modal" onclick="cargar_form(1,0)" data-target="#userModal" class="btn btn-info btn-lg">Nuevo</button>
		</div>

		</div>
	
	<!-- /.col-lg-12 -->
</div>

<div class="row">
		<div class="col-lg-12">
		              <!-- /.panel-heading -->
			<div class="panel-body">
			<table id="dataTables-example"  class="table table-striped table-bordered table-hover" width="100%" >
			<thead>
			<tr align="center">
				<th>Item </th><!--Estado-->
				<th>Clase Bien</th>
				<th>Descripcion</th>
				<th>Unid. Medi</th>
				<th>Vencimiento</th>
				<th>Estado</th>
				<th>EspTec.</th>
				<th>Acciones.</th>
			
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


<!-- Modal 
	Pagina para la carga de los repore pdf
	-->
	<div class="modal fade bd-example-modal-xl" id="impresiones" name="impresiones"  tabindex="0" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

	  <div class="modal-dialog modal-xl">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" onclick="regresar_index(carpeta)" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 class="modal-title text-center" id="myModalLabel">CARACTERISTICAS TÉCNICAS DEL MATERIAL - LABORATORIO REFERENCIAS DE SAN MARTIN</h4> 
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




