<?php
	include("../../objetos/class.cabecera.php");
	include("../../objetos/class.conexion.php");
?>

<!DOCTYPE html>
<html>

	
	<head>
	<meta charset="utf-8">
	<!-- Bootstrap Core CSS -->
    <link href="<?=$path?>bootstrap/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?=$path?>bootstrap/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?=$path?>bootstrap/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- jQuery -->
    <script src="<?=$path?>bootstrap/vendor/jquery/jquery.min.js"></script>

   	<!-- DataTables JavaScript -->
    <script src="<?=$path?>bootstrap/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="<?=$path?>bootstrap/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="<?=$path?>bootstrap/vendor/datatables-responsive/dataTables.responsive.js"></script>
     <!-- DataTables CSS -->
    <link href="<?=$path?>bootstrap/vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="<?=$path?>bootstrap/vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">


	<script type="text/javascript" language="javascript" >
		
	$(document).ready(function() {
    $('#dataTables-example').DataTable( {
        "responsive": true,
        "destroy":true,
        "processing": true,
        "serverSide": true,
        "ajax": "registros.php"
      } );
    } );

	
	function enviar(id,index)
	{
		window.opener.recibir(id,$("#iddependencia"+index).val(),$("#nombre_equip"+index).val(),$("#codpatrimonio"+index).val())
		window.close()
	}


	</script>

	</head>
	<body>
		
<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-heading">
                        
                        <!-- /.panel-heading -->
			<div class="panel-body">
			<h1 class="page-header">Registro de Equipos </h1>
			<table id="dataTables-example"  class="table table-striped table-bordered table-hover" width="100%" >
			<thead >
			<tr>
				<th>Codigo</th>
				<th>Oficina</th>
				<th>Area</th>
				<th>Marca</th>
				<th>Tipo Equipo</th>
				<th>Nombre</th>
				<th>Ip</th>
				<th>Cod. Patrim</th>
				<th>Enviar</th>
			</tr>

			</thead>
			
			</table> 
            </div>
            </div>
        </div>
    </div>
	</body>
</html>



