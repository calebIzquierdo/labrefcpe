<?php
    if(!session_start()){session_start();}
        
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();

	$objconfig->table 	= "inventario_cabecera";
	$objconfig->campoId	= "idinventario";

	//$codd=$_POST["cod"];
	echo json_encode($_POST)."\n";

	//optiene el correlativo
    if($_POST["op"]==1)
    {
		//crear
        $next 	= $objconfig->setCorrelativos();
		
	} else {
		//actualizar
		 $next 	= $_POST["Hcorrelativo"];

	}
	
//parseo la data para aprovechar la funcion mantenimiento de la clase conexion
//el cual retorna un string con la consulta de registro
if($_POST["op"]==1){
	//registro
	$dataHeader["1form_nroinventario"]=$_POST["Hcorrelativo"];
}else{
	//actualizacion
	$dataHeader["1form_idinventario"]=$_POST["cod"];
	$dataHeader["0form_nroinventario"]=$_POST["Hcorrelativo"];

	//elimino el detalle del registro
	$sql1 = "DELETE FROM inventario_detalle where idinventario='".$_POST["cod"]."'";
	$objconfig->execute($sql1); 
}


$dataHeader["0form_idejecutora"]=$_POST["Hidejecutora"];
$dataHeader["0form_idred"]=$_POST["Hidred"];
$dataHeader["0form_idmicrored"]=$_POST["Hidmicrored"];
$dataHeader["0form_idestablecimiento"]=$_POST["Hidestablecimiento"];
$dataHeader["0form_idusuario"]=$_POST["Hidusuario"];
$dataHeader["0form_fechainventario"]=$_POST["Hfecharecepcion"];
$dataHeader["0form_estado"]="1";
$query 	= $objconfig->genera_mantenimiento2($_POST["op"],$dataHeader);
echo "\n".$query."\n";

$objconfig->execute($query);
?>