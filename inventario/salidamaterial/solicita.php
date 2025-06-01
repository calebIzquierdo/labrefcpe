<?php
    include("../../objetos/class.conexion.php");

    $objconfig  = new conexion();
    $idsoli =  $_POST["idsoli"];
    
	if ($idsoli==0){
		$and = " " ;
	}else{
		$and = " and idpersonal='".$idsoli."' ";
	}

   $queryT = "SELECT idpersonal, apellidos ||'; '|| nombres as solicita, nrodocumento 
			from personal where estareg=1 ".$and."  order by apellidos asc";
	$itemsT = $objconfig->execute_select($queryT,1);
							
    ?>
<select id="idsolicita" name="0form_idsolicita" class="combobox form-control" >
    <option value=""> --- Seleccionar Trabajador ---</option>
        <?php
        foreach($itemsT[1] as $rowT)
        {   // echo $rowT["idarea"];
            
            $selected="";
            if($rowT["idpersonal"]==$idsoli && $idsoli!=0){$selected="selected='selected'";}
            echo "<option value='".$rowT["idpersonal"]."' ".$selected." >".strtoupper($rowT["nrodocumento"]." - ".$rowT["solicita"])."</option>";
        }
        ?>
	</select>
	
	<script type="text/javascript">
	
   //<![CDATA[
    $(document).ready(function(){
        $('.combobox').combobox()
    });
    //]]>
	

	
</script>