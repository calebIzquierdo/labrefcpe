<?php
	include("../objetos/class.conexion.php");
	
	$objconfig = new conexion();
 	
	$idalmacen 	= $_POST["idalmacen"];
	
	$queryT 		= "select * from personal where estareg=1 ";
	//echo $queryT;
 ?>
<select id="reponsable_almacen" name="reponsable_almacen" class="form-control" <?php echo $onchange; ?> >
    <option value="0">--Seleccione el Responsable--</option>
    <?php
        
       // echo $queryT;
        $itemsT = $objconfig->execute_select($queryT,1);
	    foreach($itemsT[1] as $rowT)
	    {
	?>
	       	 <option value='<?php echo $rowT["idpersonal"]; ?>' ><?php echo strtoupper($rowT["nombres"]); ?></option>
	 <?php    
        }
    ?>
</select>