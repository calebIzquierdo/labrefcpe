<?php
	//Desactivar todo tipo de erros
	error_reporting(1);
	
	//Configuración de zona horaria 
	date_default_timezone_set('America/Lima');

	// Servidor Local;
	define('DB_USER', 'postgres');		// Your PostgreSql username
	define('DB_PASSWORD', '123456');	// Password User	Huayane83
	define('DB_DSN', 'pgsql:host=db;port=5432;dbname=labreferencial_cpe');	// Server DataBase
	define('RUCSOL','20494013453');
	define('USUARIOSOL','VTRIGOSO');
	define('CLAVESOL','Abc123456');
	define('PASSCER','T4r4202207');
	define('URLGENFAC','http://10.10.10.10/accorddosuno/api/GenerarFactura');
	define('URLGENFIR','http://10.10.10.10/accorddosuno/api/Firmar');
	define('URLGENENV','http://10.10.10.10/accorddosuno/api/EnviarDocumento');
	define('URLGENCON','http://10.10.10.10/accorddosuno/api/ConsultarConstancia');
	$conn = null;

	class conexion
	{
		public $table;
		public $campos;
		public $value;
		public $campoId;
		public $path;
		public $meses;

		function __construct()
		{
			global $conn;

			$this->campos 	= array();
			$this->value 	= array();
			$this->campoId 	= "";
			$this->path     = "http://".$_SERVER['HTTP_HOST']."/labrefcpe/";
			$this->meses	= array("1"=>"ENERO","2"=>"FEBRERO","3"=>"MARZO","4"=>"ABRIL","5"=>"MAYO","6"=>"JUNIO",
									"7"=>"JULIO","8"=>"AGOSTO","9"=>"SETIEMBRE","10"=>"OCTUBRE","11"=>"NOVIEMBRE","12"=>"DICIEMBRE");

			$conn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);
			if(!$conn)
			{
				die("Error al Realizar la Conexion la Base de Datos");
			}
		}
		function str_replace_first($search,$replace,$string)
		{
			$w=strpos($s,$this);
			if($w===false)return $s;
			return substr($s,0,$w).$that.substr($s,$w+strlen($this));
		}
		function str_replace_limit($search, $replace, $string, $limit = 1) {
			$pos = strpos($string, $search);
		
			if ($pos === false) {
				return $string;
			}
		
			$searchLen = strlen($search);
		
			for ($i = 0; $i < $limit; $i++) {
				$string = substr_replace($string, $replace, $pos, $searchLen);
		
				$pos = strpos($string, $search);
		
				if ($pos === false) {
					break;
				}
			}
		
			return $string;
		}
		function genera_sql($where_str=false,$order_str=false,$inner_str="",$limit="")
		{
			$where 	= $where_str ? " where $where_str" : "";
			$order	= $order_str ? " order by $order_str" : "";

			$sql = "select ".implode(",",$this->campos)." from {$this->table} ".$inner_str.$where.$order.$limit;

			return $sql;
		}
		function genera_sql_order($where_str=false,$order_str=false,$inner_str="",$limit="")
		{
			$where 	= $where_str ? " where $where_str" : "";
			$order	= $order_str ? " order by $order_str ASC" : "";
			$group	= $group_str ? " group by $group_str " : "";
			$sql = "select ".implode(",",$this->campos)." from {$this->table} ".$inner_str.$where.$order.$group.$limit;

			return $sql;
		}
		function genera_sql_orderDesc($where_str=false,$order_str=false,$inner_str="",$limit="")
		{
			$where 	= $where_str ? " where $where_str" : "";
			$order	= $order_str ? " order by $order_str DESC" : "";
			$group	= $group_str ? " group by $group_str " : "";
			$sql = "select ".implode(",",$this->campos)." from {$this->table} ".$inner_str.$where.$order.$group.$limit;

			return $sql;
		}
		function genera_mantenimiento($op,$post)
		{
			if($op==1)
			{
				$sql = $this->genera_insert($post);
			}else{
				$sql = $this->genera_update($post);
			}

			return $sql;
		}
		function genera_mantenimiento2($op,$post)
		{
			if($op==1)
			{
				$sql = $this->genera_insert2($post);
			}else{
				$sql = $this->genera_update($post);
			}

			return $sql;
		}
		function genera_insert($post)
		{
			//$sql = "insert into {$this->table} (".implode(",",$this->campos).") values(".implode(",",$this->value).")";
			$campos	= "";
			$value 	= "";
			foreach($post as $nombre_campo => $valor)
			{
				$pos 	= strpos($nombre_campo,"_");
				$form	= substr($nombre_campo,1,$pos);

				if($form=="form_")
				{
					$tipo 			= substr($nombre_campo,0,1);
					$nombre_campo 	= substr($nombre_campo,$pos+1);

					if($tipo==1)
					{
						$this->campoId = $nombre_campo;
						$maximo  = $this->setCorrelativos();

						$campos  .= $nombre_campo.",";
						$value   .= "'".$maximo."',";
						
					}else{
						$campos  .= $nombre_campo.",";
						$value   .= "'".$valor."',";
					}
				}
			}
			return "insert into {$this->table}(".substr($campos,0,strlen($campos) - 1).") values(".substr($value,0,strlen($value) - 1).")";
		}
		function genera_insert2($post)
		{
			//$sql = "insert into {$this->table} (".implode(",",$this->campos).") values(".implode(",",$this->value).")";
			$campos	= "";
			$value 	= "";
			foreach($post as $nombre_campo => $valor)
			{
				$pos 	= strpos($nombre_campo,"_");
				$form	= substr($nombre_campo,1,$pos);

				if($form=="form_")
				{
					$tipo 			= substr($nombre_campo,0,1);
					$nombre_campo 	= substr($nombre_campo,$pos+1);

					if($tipo==1)
					{
						$this->campoId = $nombre_campo;
						$maximo  = $this->setCorrelativos();

						$campos  .= $nombre_campo.",";
						if($valor!="" || $valor!=null){
							$value   .= "'".$valor."',";
						}else{
							$value   .= "'".$maximo."',";
						}
					}else{
						$campos  .= $nombre_campo.",";
						$value   .= "'".$valor."',";
					}
				}
			}
			return "insert into {$this->table}(".substr($campos,0,strlen($campos) - 1).") values(".substr($value,0,strlen($value) - 1).")";
		}
		
		function genera_update($post)
		{
			$cadena = "";
			$where	= "";

			foreach($post as $nombre_campo => $valor)
			{
				$pos 	= strpos($nombre_campo,"_");
				$form	= substr($nombre_campo,1,$pos);
			//	echo substr($nombre_campo,$pos+1)."=";
				if($form=="form_")
				{
					$tipo 			= substr($nombre_campo,0,1);
					$nombre_campo 	= substr($nombre_campo,$pos+1);
				//	echo $tipo ."\n";
					if($tipo==0)
					{
						$cadena .= $nombre_campo."='".$valor."',";
					}else{
						$where = " where ".$nombre_campo."='".$valor."'";
					}
				}
			}

			return "update {$this->table} set ".substr($cadena,0,strlen($cadena)-1).$where;
		}
		function genera_onlyupdate($post)
		{
			$cadena = "";
			$where	= "";

			foreach($post as $nombre_campo => $valor)
			{
				$pos 	= strpos($nombre_campo,"_");
				$form	= substr($nombre_campo,1,$pos);

				if($form=="form_")
				{

					$tipo 			= substr($nombre_campo,0,1);
					$nombre_campo 	= substr($nombre_campo,$pos+1);

					if($tipo!=1)
					{
						$cadena .= $nombre_campo."='".$valor."',";
					}
				}
				if ($form=="form2_"){
					$tipo 			= substr($nombre_campo,0,1);
					$nombre_campo 	= substr($nombre_campo,$pos+1);
					if($tipo==2){
						$where = " where ".$nombre_campo."=".$valor;
					}
				}
			}

			return "update {$this->table} set ".substr($cadena,0,strlen($cadena)-1).$where;
		}
		function execute($sql)
		{
			global $conn;

			$conn->beginTransaction();

			$result = $conn->prepare($sql);
			$result->execute();
 
			if(!$result)
			{
				$conn->rollBack();
				echo $result->errorInfo();
				$res=0;
				die("Error al Realizar la Transaccion con la Base de Datos ");
			}else{
				$conn->commit();
				$res=1;
			}

			return $res;
		}
		function execute_select($query,$op=0)
		{
			global $conn;
                           //echo "Cosulta";
			$consulta = $conn->prepare($query);
			$consulta->execute();
			$n = $consulta->rowCount();

			if($op==0)
			{
				$items = $consulta->fetch();
			}else{
				$items = $consulta->fetchAll();
			}

			return array(1=>$items,2=>$n);
		}

		function execute_select_object($query)
		{
			global $conn;
                           //echo "Cosulta";
			$consulta = $conn->prepare($query);
			$consulta->execute();
			$n = $consulta->rowCount();

			if($op==0)
			{
				$items = $consulta->fetch();
			}else{
				$items = $consulta->fetchAll();
			}

			return $items;
		}

		function setCorrelativos($where_str=false)
		{
			global $conn;

			$where = $where_str ? "where $where_str" : "";

			$sql = "select max(cast({$this->campoId} as INT)) from {$this->table} ".$where;
			$consulta = $conn->prepare($sql);
			$consulta->execute();
			$items = $consulta->fetch();

			$correlativo = $items[0];
			if(!isset($items[0])){$correlativo = 0;}

			return $correlativo + 1;
		}

		function _destruct()
		{
			$this->conn = null;
		}

		function redondeo($numero,$decimales)
		{
			/* $exp=pow(10, $decimales);
			$n=floor($numero*$exp);
			return $n/$exp; */
			 $factor = pow(10, $decimales);
			return (round($numero*$factor)/$factor);
		}

		function Truncar($numero, $decimales)
		{
			$multiplo = 10;
			for($i=1;$i<$decimales;$i=$i+1)
			{
			$multiplo = $multiplo*10;
			}

			$numero = $numero*$multiplo;
			$entero = parseInt($numero);
			$numero = $entero/$multiplo;

			return $numero;
		}

		function FechaDMY($fec)
		{
		$fecha_format =  date("d-m-Y",strtotime($fec) );
		return $fecha_format ;
		}

        function FechaDMY2($fec)
        {
            $fecha_format =  date("d/m/Y",strtotime($fec) );
            return $fecha_format ;
        }


		function CantidadFilas($query)
		{
			global $conn;

			$consulta = $conn->prepare($query);
			$consulta->execute();
			$n = $consulta->rowCount();
			return $n;
		}

		function execute_filas($query)
		{
			global $conn;

			$consulta = $conn->prepare($query);
			$consulta->execute();
			$n = $consulta->rowCount($consulta);

			return "Total ".$n;
		}

		function EdadActual($fechaNace,$fechaActual){
			$fecha_nacimiento = $fechaNace;
			$dia_actual =  $fechaActual;
			$edad_diff = date_diff(date_create($fecha_nacimiento), date_create($dia_actual));
			$anios = $edad_diff->format('%y');
			$mes = $edad_diff->format('%m');
			$dias = $edad_diff->format('%d');
			$edadActual = $anios. "-a ".$mes."-m ".$dias. "-d. ";
			return $edadActual;
		}
		
		function cargar_ficha_entomologica($finicio,$ffinal,$depa,$prov,$dist,$local,$cade)
		{
			global $conn;
        
			$query  = "insert into tmp_ficha_entomologica (iddepartamento,idprovincia,iddistrito,zona,fechainicio,fechatermino,fecharecepcion,vinspec,";
			$query .= "mrecibida,vpositiva, rinspeccionado,rpositiva,idtipointervencion,local,orden,idestablesolicita,longitud,latitud,tintervencion,  ";
			$query .= "estable_solicita,departamento,provincia , distrito ) ";
			$query .= "select f.iddepartamento, f.idprovincia, f.iddistrito, z.descripcion as zona , f.fechainicio , f.fechatermino , f.fecharecepcion, ";
			$query .= "sum(cm.vinspec) as vinspec, sum(cm.mrecibida) as mrecibida, sum(cm.vpositiva) as vpositiva, sum(cm.rinspeccionado) as rinspeccionado, sum(cm.rpositiva) as rpositiva, cm.idtipointervencion, ";
			$query .= "f.localidad as local,cm.idzona, f.idestablesolicita, e.longitud, e.latitud, t.descripcion as tintervencion , ";
			$query .= "e.descripcion as estable_solicita, d.descripcion as departamento , p.descripcion as provincia, ds.descripcion as distrito ";
			$query .= "from consolidado as f ";
			$query .= "inner join consolidado_muestra as cm on (cm.idconsolidado=f.idconsolidado) ";
			$query .= "inner join establecimiento as e on (e.idestablecimiento=f.idestablesolicita) ";
			$query .= "inner join tipo_intervencion as t on (t.idtipointervencion=cm.idtipointervencion) ";
			$query .= "inner join departamento as d on (d.iddepartamento=f.iddepartamento) ";
			$query .= "inner join provincia as p on (p.idprovincia=f.idprovincia) ";
			$query .= "inner join distrito as ds on (ds.iddistrito=f.iddistrito) ";
			$query .= "inner join tipo_zona as z on (z.idzona=cm.idzona) ";
			$query .= "where f.estareg=1 and f.fechainicio between '".$finicio."' and '".$ffinal."'  ".$cade." ";
			$query .= "group by f.iddepartamento,f.idprovincia,f.iddistrito,z.descripcion,f.fechainicio,f.fechatermino, ";
			$query .= "cm.idtipointervencion,f.localidad,cm.idzona, f.fecharecepcion,z.descripcion, idestablesolicita, e.latitud, e.longitud, tintervencion, ";
			$query .= "estable_solicita,departamento,provincia , distrito";
			
			$consulta = $conn->prepare($query);
			$consulta->execute();
			
		}
		
		function cargar_ficha_entomologicaAedico($finicio,$ffinal,$depa,$prov,$dist,$local,$cade)
		{
			global $conn;
        
			$query  = "insert into tmp_ficha_entomologica_aedes (iddepartamento,idprovincia,iddistrito,zona,fechainicio,fechatermino,";
			$query .= "fecharecepcion,vinspec,mrecibida,vpositiva, rinspeccionado,rpositiva,idtintervencion,local,orden, ";
			$query .= "idestablesolicita,longitud,latitud,idtipointervencion, tintervencion, estable_solicita,departamento,provincia , distrito ) "; 
			$query .= "select f.iddepartamento, f.idprovincia, f.iddistrito, f.zona , f.fechainicio , f.fechatermino , ";
			$query .= "f.fecharecepcion, sum(f.vinspec) as vinspec, sum(f.mrecibida) as mrecibida,sum(f.vpositiva) as vpositiva, "; 
			$query .= "sum(f.rinspeccionado) as rinspeccionado, ";
			$query .= "sum(f.c1positivo+f.c2positivo+f.c3positivo+f.c4positivo+f.c5positivo+f.c6positivo+f.c7positivo+f.c8positivo) as rpositiva, ";
			$query .= "f.idtipointervencion as idtintervencion, f.localidad as local,f.idzona, ";
			$query .= "f.idestablesolicita, am.longitud, am.latitud,f.idtipointervencion, f.tinterven as tintervencion , f.estable_solicita, d.descripcion as departamento , ";
			$query .= "p.descripcion as provincia, ds.descripcion as distrito ";
			$query .= "from vista_aedes_consolidado as f ";
			
			$query .= "inner join departamento as d on (d.iddepartamento=f.iddepartamento)  ";
			$query .= "inner join provincia as p on (p.idprovincia=f.idprovincia) ";
			$query .= "inner join distrito as ds on (ds.iddistrito=f.iddistrito) ";
			$query .= "inner join aedes_muestra as am on (am.idaedes=f.idaedes) ";
			
			$query .= "where f.estareg=1 and f.idestadomuestra!=2 and f.fechainicio between '".$finicio."' and '".$ffinal."'  ".$cade." ";
			$query .= "group by f.iddepartamento,f.idprovincia,f.iddistrito,f.zona,f.fechainicio,f.fechatermino, ";
			$query .= "f.idtipointervencion,f.localidad,f.idzona, f.fecharecepcion,f.zona, f.idestablesolicita, ";
			$query .= "am.latitud, am.longitud, f.tinterven, estable_solicita,departamento,provincia , distrito";
			
			//echo "Copiado a la tabla temporal: ".$query;
			$consulta = $conn->prepare($query);
			$consulta->execute();
			
		}
		
		function generar_factura($data){
			$url= URLGENFAC;
			$opts = array('http' => array('method' => 'POST', 'header' => 'Content-type: application/json', 'content' => json_encode($data)));
			$context = stream_context_create($opts);
			return json_decode(file_get_contents($url, false, $context));
		}
		function generar_nota_credito($data){
			
			$url= "http://10.10.10.10/accorddosuno/api/GenerarNotaCredito";
			$opts = array('http' => array('method' => 'POST', 'header' => 'Content-type: application/json', 'content' => json_encode($data)));
			$context = stream_context_create($opts);
			return json_decode(file_get_contents($url, false, $context));
		}
		function generar_firma($data){
			$url= URLGENFIR;
			$opts = array('http' => array('method' => 'POST', 'header' => 'Content-type: application/json', 'content' => json_encode($data)));
			$context = stream_context_create($opts);
			return json_decode(file_get_contents($url, false, $context));
		}
		function generar_enviar($data){
			$url= URLGENENV;
			$opts = array('http' => array('method' => 'POST', 'header' => 'Content-type: application/json', 'content' => json_encode($data)));
			$context = stream_context_create($opts);
			return json_decode(file_get_contents($url, false, $context));
		}
		function consulta_comprobante($data){
			$url= URLGENCON;
			$opts = array('http' => array('method' => 'POST', 'header' => 'Content-type: application/json', 'content' => json_encode($data)));
			$context = stream_context_create($opts);
			return json_decode(file_get_contents($url, false, $context));
		}
	}


?>
