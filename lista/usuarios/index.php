<?php

	include("../../objetos/class.cabecera.php");
	include("../../objetos/class.conexion.php");
	
?>
	

<!DOCTYPE html>
<html>

	
	<head>

	<!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="<?=$path?>bootstrap/responsive/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>bootstrap/responsive/css/dataTables.responsive.css">
	<!-- jQuery -->
    <script type="text/javascript" language="javascript" src="<?=$path?>bootstrap/vendor/jquery/jquery.min.js"></script>
    <!-- DataTables JavaScript -->
	<script type="text/javascript" language="javascript" src="<?=$path?>bootstrap/vendor/datatables/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="<?=$path?>bootstrap/vendor/datatables-responsive/dataTables.responsive.js"></script>

	
	<script type="text/javascript" language="javascript" >
		
		$(document).ready(function() {
			   var dataTable =  $('#dataTables-example').DataTable( {
			   	    responsive: {
					details: {
					    renderer: function ( api, rowIdx ) {
						var data = api.cells( rowIdx, ':hidden' ).eq(0).map( function ( cell ) {
						    var header = $( api.column( cell.column ).header() );
						    return  '<p style="color:#00A">'+header.text()+' : '+api.cell( cell ).data()+'</p>';
						} ).toArray().join('');
 
						return data ?    $('<table/>').append( data ) :    false;
					    }
					}
				    },
			   	processing: true,
				serverSide: true,
				ajax: "registros.php", // json datasource
			    } );
		} );

	
function enviar(id,index)
{
	window.opener.recibir(id,$("#nombre"+index).val())
	window.close()
}



	</script>

		<style>
			div.container {
			    max-width: 980px;
			    margin: 0 auto;
			}
			div.header {
			    margin: 0 auto;
			    max-width:980px;
			}
			body {
			    background: #f7f7f7;
			    color: #333;
			}
		</style>
	</head>
	<body>
		<div class="header"><h1>Registro de Usuarios </h1></div>
		<div class="container">
			<table id="dataTables-example"  class="display" cellspacing="0" width="100%">
				<thead>
				<tr>
				<th>N°</th>
				<th>Nombres</th>
				<th>Login</th>
				<th> 
					<img src='../../img/descargas.png' title='Seleccionar Registro' />
				</th>
				</tr>
				</thead>
			</table>
		</div>
	</body>
</html>

