<?php
if(!session_start()){session_start();}
include("../objetos/class.conexion.php");

$objconfig = new conexion();

 // php_uname();
 	if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') 
	{
		echo "SERVER ".strtoupper(substr(PHP_OS, 0, 3))."\n ";
		$ultima_linea = system('backup.bat',$retval);

	} else {
		echo "Server ".strtoupper(substr(PHP_OS, 0, 3))." ";
		$ultima_linea = system('sh backup_linux.sh',$retval)."\n";

	}
		
	  if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"),"unknown"))
           $ip = getenv("HTTP_CLIENT_IP");
        else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
           $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
           $ip = getenv("REMOTE_ADDR");
        else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
           $ip = $_SERVER['REMOTE_ADDR'];
        else
           $ip = "IP desconocida";

	   $objconfig->execute("insert into log(usuario,ip,descripcion,hora) 
                                values('".$_SESSION['nombre']."','".$ip."','$ultima_linea','".date("h:i:s A")."')");
	
?>

