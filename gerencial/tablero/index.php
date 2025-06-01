<?php
		
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
?>
<style>
.buttonA {
background-color: #4CAF50;
border-radius: 10px;
color: white;
padding: 14px 28px;
text-align: center;
text-decoration: none;
margin: 2px 6px;
cursor: pointer;
font-size:16px;
display: block;
width: 100%;
/* border: none;
 box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);*/

}
.buttonA:hover {
  background-color: #ddd;
  color: black;
/*  box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19); */
}

</style>

<div class="col-lg-12">
    <h1 class="page-header">Tablero de mando integral</h1>
</div>

<div class="modal-body">
    <div class="row">
	<?php
     	  	$query = "select * from indicadores where estareg=1 order by idindicador";
			$items = $objconfig->execute_select($query,1);
			
			$ini = 0;
			foreach($items[1] as $row)
			{
				if($ini==0){echo "<div class='col-md-12'>";}
				$ini++;
     	  ?>
		    
			<div class="col-md-5 btn-group-center">
			<button type="button" id="add_button" data-toggle="modal" onclick="ver_tablero(<?=$row["idindicador"]?>)" data-target="#userModal" class="buttonA"><?=$row["descripcion"]?></button> 
			
            </div>
			<div class="col-md-1"></div>
			
		    	
		    
		  <?php
		  		if($ini==2){echo "</br></div>";$ini=0;}
			}
		  ?>
		  
        
        </div>
	</div>

</div>

<div id="userModal" name="userModal" class="modal fade">
	<div class="modal-dialog">
		<div id="modal-body" name="modal-body"> 
		</div>
	</div>
</div>

