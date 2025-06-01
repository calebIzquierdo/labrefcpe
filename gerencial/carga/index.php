<?php
	
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
	$query 	= "select date_part('year',fecreferencia) as anio,date_part('month',fecreferencia) as mes from referencia 
			  group by date_part('year',fecreferencia),date_part('month',fecreferencia) order by date_part('month',fecreferencia)"; 
				  
			  
	$query2 	= "select date_part('year',fecreferencia) as anio,date_part('month',fecreferencia) as mes from referencia 
			  group by date_part('year',fecreferencia),date_part('month',fecreferencia) order by date_part('month',fecreferencia)"; 
			  		  
	$row 	= $objconfig->execute_select($query,1);
	$row2 	= $objconfig->execute_select($query2,1);
	
?>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Carga de Datos Operacionales</h1>
	</div>
</div>
<div class="modal-body">
	<fieldset class="scheduler-border">
			<legend class="scheduler-border">PERIODO DE LA REFERENCIA: </legend>
    <div class="row">
        <div class="col-md-12">
		<div class="col-md-2">
			<input type="button" name="cargar" id="cargar" onclick="limpiardata();" value="Limpiar Tablas" class="btn btn-danger" />
        
			 </div>
            <div class="col-md-2">
                <label for="atencion" class="control-label">MES Y AÑO PERIODO:  </label>
            </div>

            <div class="col-md-3">
                <select id="aniomes" name="aniomes"  class="form-control">
				<option value="0">-- Periodo Referencia--</option>
				<?php
					foreach($row[1] as $r1)
					{
				?>
					<option value="<?php echo $r1["mes"]."|".$r1["anio"]; ?>"><?php echo $objconfig->meses[$r1["mes"]]." - ".$r1["anio"]; ?></option>
				<?php
					}
				?>
			</select>
            </div>
			<div class="col-md-3">
			<button type="button" name="cargar" id="cargar" onclick="procesar();" class="btn btn-success">Cargar Datos</button>
          </div>
       
        </div>
	</div>
	</fieldset>
	<!--
	<fieldset class="scheduler-border">
	<legend class="scheduler-border">DIAGNOSTICO POR PERIODO: </legend>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-2">
                <label for="atencion" class="control-label">MES Y AÑO PERIODO:  </label>
            </div>

            <div class="col-md-3">
                <select id="aniomes" name="aniomes" class="form-control">
				<option value="0">--DX Periodo--</option>
				<?php
					foreach($row[1] as $r)
					{
				?>
					<option value="<?php echo $r["mes"]."|".$r["anio"]; ?>"><?php echo $objconfig->meses[$r["mes"]]." - ".$r["anio"]; ?></option>
				<?php
					}
				?>
			</select>
            </div>
			<div class="col-md-3">
			<input type="button" name="cargar" id="cargar" onclick="limpiardata();" value="Limpiar Tablas" class="button white" />
        
			 </div>
       
        </div>
	</div>
	</fieldset>
-->
</div>
<div class="row">
	<div class="col-lg-12">
		<!--Para mostrar la respuesta del archivo llamado via ajax --> 
		<div class="upload-msg col-md-12 text-center"></div> 		
	</div>
</div>

				

