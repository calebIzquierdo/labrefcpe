<?php
	include("../objetos/class.conexion.php");
	
	$objconfig = new conexion();
 	
	$idproductor 	= $_POST["idproductor"];
	$onchange	= "";
	 $onchange	= "onchange='cargar_hectarea(this.value,$idproductor);'";
            $name2		= "B";
	
	$queryT 		= "select p.idterreno, p.referencia as referencia,
					   (select descripcion from pais where idpais=p.idpais) as pai,
					   (select descripcion from departamento where iddepartamento=p.iddepartamento) as depa,
					   (select descripcion from provincia where idprovincia=p.idprovincia) as prov,
					   (select descripcion from distrito where iddistrito=p.iddistrito) as distr,
					   (select descripcion from sector where idsector=p.idsector) as sect
					   from productores_terreno as p 
					   where idproductor=".$idproductor." and estado=0";
 ?>
 				
<select id="idterreno" name="idterreno" class="form-control" <?php echo $onchange; ?> >
    <option value="0">--Seleccione el Terreno--</option>
    <?php
        
       // echo $queryT;
        $itemsT = $objconfig->execute_select($queryT,1);
		$t="";
		if($idproductor!=0)
		{
	        foreach($itemsT[1] as $rowT)
	        {
	    ?>
	       	 <option value='<?php echo $rowT["idterreno"]; ?>' ><?php echo strtoupper($rowT["pai"]."-".$rowT["depa"]."-".$rowT["prov"]."-".$rowT["distr"]."-".$rowT["sect"]."-".$rowT["referencia"]); ?></option>
	    <?php 
	        }   
        }
    ?>
</select>
