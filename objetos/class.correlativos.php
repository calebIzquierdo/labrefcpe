<?php
	include_once ("class.conexion.php");
	
	class correlativo extends conexion
	{				
//		function __construct()
//		{
//			parent::__construct();
//		}
		function setCorrelativos($where_str=false)
		{
			global $conn;
			
			$where = $where_str ? "where $where_str" : "";
			
			$sql = "select max(cast({$this->campoId} as INT)) from {$this->table} ".$where;
		echo $sql;
			$consulta = $conn->prepare($sql);
			$consulta->execute();
			$items = $consulta->fetch();
			
			$correlativo = $items[0];
			if(!isset($items[0])){$correlativo = 0;}
			
			return $correlativo + 1;
		}
	}

?>