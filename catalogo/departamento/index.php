<?php

include("../../objetos/class.cabecera.php");

?>
</head>
	<body>
		

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Catálogo Departamento </h1>
		
		<div align="left">
			<button type="button" id="add_button" data-toggle="modal" data-backdrop="static" data-keyboard="false" onclick="cargar_form(1,0)" data-target="#userModal" class="btn btn-info btn-lg">Nuevo</button>
		</div>
	</div>
	
	<!-- /.col-lg-12 -->
</div>


<div class="row">
		<div class="col-lg-12">
			<br/>
			<table id="dataTables-example"  class="table table-striped table-bordered table-hover" width="100%" >
			<thead>
			<tr>
				<th>Codigo</th><!--Estado-->
				<th>Departamento</th>
				<th>Estado</th>
				<th>Accion</th>
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
</div>


