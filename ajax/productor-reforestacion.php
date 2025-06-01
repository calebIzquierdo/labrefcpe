<?php
	
	include("../objetos/class.cabecera.php");	
	include("../objetos/class.conexion.php");
	
	$objconfig = new conexion();
 	
	$idproductor 	= $_POST["idproductor"];
	
	$onchange	= "onchange='cargar_hectarea(this.value,".$idproductor .");'";
					   
 ?>
<select id="idterreno" name="idterreno" class="form-control" <?php echo $onchange; ?>  >
 
    <option value="0">--Seleccione el Terreno--</option>
    <?php
	

      $queryT 		= "select p.idterreno, p.referencia , p.idproduccion,
					   (select descripcion from pais where idpais=p.idpais) as pai,
					   (select descripcion from departamento where iddepartamento=p.iddepartamento) as depa,
					   (select descripcion from provincia where idprovincia=p.idprovincia) as prov,
					   (select descripcion from distrito where iddistrito=p.iddistrito) as distr,
					   (select descripcion from sector where idsector=p.idsector) as sect, 
					   (select produccion from terreno_produccion where idproduccion=p.idproduccion ) as prodanual
					   from productores_terreno as p 
					   where p.idproductor=".$idproductor." and p.idola=0 and estado=0 ";
		echo $queryT ;
						   
        $itemsT = $objconfig->execute_select($queryT,1);

		foreach($itemsT[1] as $rowT)
	        {
			// $parcela = strtoupper($rowT["pai"]." - ".$rowT["depa"]." - ".$rowT["prov"]." - ".$rowT["distr"]." - ".$rowT["sect"]." => ".$rowT["referencia"]);
			// $parcela = strtoupper($rowT["depa"]." - ".$rowT["prov"]." - ".$rowT["distr"]." - ".$rowT["sect"]." => ".$rowT["referencia"]);
			$parcela = strtoupper($rowT["referencia"]);
	    ?>
		<option value='<?php echo $rowT["idterreno"]; ?>' > <?php echo $parcela; ?> </option>
		
	    <?php 
        } 
	  
    ?>
	
</select>