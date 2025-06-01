<?php
include("../../objetos/class.cabecera.php");
include("../../objetos/class.conexion.php");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<!-- Bootstrap Core CSS -->
	<link href="<?= $path ?>bootstrap/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<!-- Custom CSS -->
	<link href="<?= $path ?>bootstrap/dist/css/sb-admin-2.css" rel="stylesheet">
	<!-- Custom Fonts -->
	<link href="<?= $path ?>bootstrap/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<!-- jQuery -->
	<script src="<?= $path ?>bootstrap/vendor/jquery/jquery.min.js"></script>
	<!-- DataTables JavaScript -->
	<script src="<?= $path ?>bootstrap/vendor/datatables/js/jquery.dataTables.min.js"></script>
	<script src="<?= $path ?>bootstrap/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
	<script src="<?= $path ?>bootstrap/vendor/datatables-responsive/dataTables.responsive.js"></script>
	<!-- DataTables CSS -->
	<link href="<?= $path ?>bootstrap/vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
	<!-- DataTables Responsive CSS -->
	<link href="<?= $path ?>bootstrap/vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

	<script type="text/javascript" language="javascript">
		$(document).ready(function() {
			$('#dataTables-example').DataTable({
				"responsive": true,
				"destroy": true,
				"processing": true,
				"serverSide": true,
				"ajax": "registros.php"
			});
		});


		function enviar(nro, index) { ///0000030,4
			//window.opener.recibir(nro,index,0,0)
			var area =  $("#area" + index).val();
			var subarea = $("#subarea" + index).val();
			var soli = $("#soli" + index).val();
			window.opener.recibir(nro,area,subarea,soli) ////000030,#area4, #subabrea4,#idsoliciate4
			window.close()
		}
	</script>

</head>

<body>

	<div class="row">
		<input type='hidden' name='idm' id='idm' value='<?php echo $_GET["idm"]; ?>' />
		<div class="col-lg-12">
			<div class="panel panel-heading">

				<!-- /.panel-heading -->
				<div class="panel-body">
					<h1 class="page-header">Requerimientos Pendiente de entrega</h1>
					<table id="dataTables-example" class="table table-striped table-bordered table-hover" width="100%">
						<thead class="thead-inverse">
							<tr>
								<th>Item</th>
								<th>N°</th>
								<th>Fecha</th>
								<th>Area.</th>
								<th>Subärea</th>
								<th>Solicitante</th>
								<th>Seleccionar</th>
							</tr>

						</thead>

					</table>
				</div>
			</div>
		</div>
	</div>
</body>

</html>