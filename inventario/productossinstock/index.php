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
		<h1 class="page-header">Lista de Productos sin Stock</h1>
	</div>
    <div class="col-lg-12">
        <div align="left">
            <button onclick='excel_ficha()' class='btn btn-outline btn-success'>
                Exportar a Excel <img src='../img/xls.png' alt='Exportar Excel' width='20' height='20'>
            </button>
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
                    <th>Requerimiento</th>
                    <th>Fecha Registro</th>
                    <th>Area Solicitante</th>
                    <th>Tipo Material</th>
                    <th>Material</th>
                    <th>Cant. Requerida</th>
                    <th>Cant. Aprobada</th>
                    <th>Stock Almacen</th>
                    <!-- <th><img src="../img/xls.png" alt="Exportar Excel" width="25" height="25"> </th> -->
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


<div class="modal fade bd-example-modal-xl" id="impresiones" name="impresiones"  tabindex="0" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-xl">
		<div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="regresar_index(carpeta)" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="myModalLabel">Listado de Productos sin Stock</h4> 
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
