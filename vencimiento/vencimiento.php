<?php 
	include("../objetos/class.cabecera.php");
	include("../objetos/class.conexion.php");
 
	$objconfig = new conexion();
   

?>


<!DOCTYPE html>
<html>

	
	<head>
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
        "ajax": "registros.php",
			"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
			 if ( aData[3] < 0 )
			{
				$('td', nRow).css('color', 'GREEN');
			} else  {
				$('td', nRow).css('color', 'red');
			}
        }
      } );
	  $('#dataTables-examplee').DataTable( {
        "responsive": true,
        "destroy":true,
        "processing": true,
        "serverSide": true,
        "ajax": "registros-vencidos.php",
			"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
			 if ( aData[3] < 0 )
			{
				$('td', nRow).css('color', 'GREEN');
			} else  {
				$('td', nRow).css('color', 'red');
			}
        }
      } );
    } );

	</script>

	</head>
	<body>
		
<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-heading">
			<div class="panel-body">
			<h1 class="page-header">Materiales Proximo su Vencimiento</h1>
			</div>
			<table id="dataTables-example"  class="table table-striped table-bordered table-hover" width="100%" >
			<thead class="thead-inverse">
			<tr>
				<th>Material</th>
				<th>Marca</th>
				<th>Fecha de Vencimiento</th>
				<th>Dias de Vencimiento</th>
			</tr>

			</thead>
			
			</table> 
           
            </div>
       
		</div>
		<div class="col-lg-12">
			<div class="panel panel-heading">
			<div class="panel-body">
			<h1 class="page-header">Materiales Vencidos</h1>
			</div>
			<table id="dataTables-examplee"  class="table table-striped table-bordered table-hover" width="100%" >
			<thead class="thead-inverse">
			<tr>
				<th>Material</th>
				<th>Marca</th>
				<th>Fecha de Vencimiento</th>
				<th>Dias de Vencimiento</th>
			</tr>

			</thead>
			
			</table> 
           
            </div>
       
		</div>
</div>
	</body>
</html>




