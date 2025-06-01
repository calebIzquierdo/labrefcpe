<?php
	include("../objetos/class.conexion.php");
	
	$objconfig = new conexion();
 	
	$idalmacen 	= $_POST["idalmacen"];
	
	$queryT 		= "select au.idusuario,u.nombres
					   from almacen_usuario as au 
					   inner join usuarios as u on(au.idusuario=u.idusuario)
					   where au.idalmacen=".$idalmacen." and not idpersonal=0";
	//echo $queryT;
 ?>
<select id="reponsable_almacen" name="reponsable_almacen"  class="form-control"<?php echo $onchange; ?> >
    <option value="0">--Seleccione el Responsable--</option>
    <?php
        
       // echo $queryT;
        $itemsT = $objconfig->execute_select($queryT,1);
	    foreach($itemsT[1] as $rowT)
	    {
	?>
	       	 <option value='<?php echo $rowT["idusuario"]; ?>' ><?php echo strtoupper($rowT["nombres"]); ?></option>
	 <?php    
        }
    ?>
</select>