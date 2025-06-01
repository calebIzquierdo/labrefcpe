<?php
	include("../../objetos/class.cabecera.php");	
	include("../../objetos/class.conexion.php");
				
	$objconfig = new conexion();
	 
	// $query  = "select * from anio where estareg=1";
//        echo $query;
		$query  = "select MAX(descripcion) as descripcion from anio where estareg=1";
        $row    = $objconfig->execute_select($query);
?>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Registro Años</h1>
	</div>
	
	<!-- /.col-lg-12 -->
</div>


<form method="post" enctype="multipart/form-data"  id="frmguardar"  name="frmguardar"  action="guardar.php" > 
<br />
	<div class="row">
		<div class="col-md-12">
		 <div class="col-md-3">
		 </div>		 
			<div class="col-md-2  text-right ">	<label class="control-label" >Año Actual</label></div>
	        <div class="col-md-2"> 
				<input type="hidden" name="1form_idanio" id="codigo" value="<?=$row[1]["idanio"]?>" class="form-control"  />			
				<input type="text" name="0form_descripcion" id="descripcion" value="<?=$row[1]["descripcion"]?>" class="form-control" readonly />
			</div>
			 <div class="col-md-3">  
				<input type="button" name="imprimir" id="imprimir" onclick="validar();" value="Generar Año" class="btn btn-success" />
			</div>
		</div>
	</div>		
	<br />

</form>
	
	
