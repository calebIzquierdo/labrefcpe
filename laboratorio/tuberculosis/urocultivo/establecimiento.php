    <?php
    include("../../../objetos/class.conexion.php");

    $objconfig  = new conexion();
    $micro =  $_POST["idpa"];
    $estable =  $_POST["esta"];

    $queryT = "select idestablecimiento, descripcion 
				from establecimiento
				where idmicrored=".$micro." and idestablecimiento=".$estable."
				";
			//	echo $queryT ;
    $itemsT = $objconfig->execute_select($queryT);
    ?>
	
	<h3 class="modal-title text-primary" align="center"> <?php echo $itemsT[1]["descripcion"]; ?> </h3>