    <?php
    include("../../../objetos/class.conexion.php");

    $objconfig  = new conexion();


    $idpaciente =  $_POST["idpa"];
    $fnac = $_POST["fnac"];
    $idref = $_POST["idref"];
	
	if ($idref >0){
		$refPac = $objconfig->execute_select("SELECT idpaciente, idseguro from urocultivo where idurocultivo=".$idref) ;
		$seguro = $refPac[1]["idseguro"];
		$queryT = "SELECT idseguro, descripcion from tipo_seguro where idseguro=".$seguro." and idseguro!=2";
		$itemsT = $objconfig->execute_select($queryT,1);
		
		
	}else
		{
		$idseguro = $objconfig->execute_select("SELECT idpaciente, idseguro from paciente where idpaciente=".$idpaciente) ;
		$seguro = $idseguro[1]["idseguro"];
		 $queryT = "SELECT idseguro, descripcion from tipo_seguro where estareg=1 and idseguro!=2";
		$itemsT = $objconfig->execute_select($queryT,1);
		
	}
	
   

    ?>
     
   <select id="idseguro" name="0form_idseguro" class="form-control"  >
   <option value="0"></option>
           <?php

        foreach($itemsT[1] as $rowT)
        {
			$selected="";
            if($rowT["idseguro"]==$seguro){$selected="selected='selected'";}
            echo "<option value='".$rowT["idseguro"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";

        }
        ?>
    </select>
<!-- 
 <input type="hidden" name="0form_idseguro" id="idseguro" readonly value="<?=$itemsT{1}["idseguro"]?>" class="form-control" />
<input type="text" name="seguross" id="seguross" readonly value="<?=$itemsT{1}["descripcion"]?>" class="form-control" />
-->