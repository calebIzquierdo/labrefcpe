<?php
    if(!session_start()){session_start();}
        
	include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();

	$objconfig->table 	= "salida";
	$objconfig->campoId	= "idsalida";

  if($_POST["op"]==1)
  {
    $next 	= $objconfig->setCorrelativos();		
	}else{
		$next 	= $_POST["1form_idsalida"];
	}
	
	$query 	= $objconfig->genera_mantenimiento($_POST["op"],$_POST);
	$objconfig->execute($query);
	
	$del1 = "delete from salida_det where idsalida=".$next;
	$objconfig->execute($del1);

	////////////////////////////****CODIGO MODIFICADO//////////////////////////////////////////////////////////////////

	
	for($i=1;$i<=$_POST["contar_diagnostico"];$i++) ///prod 1 ,prod2  $i (1,2)
	{

		$vence = $objconfig->execute_select("SELECT idvence from materiales where idmaterial='".$_POST["idmaterial".$i]."'");

		$i_lote=0;
							
		if($vence[1]["idvence"]==1){
		}else {
			$and ="";	
		}

			$postcantidad=$_POST["cantidad".$i];///4 1

			$lote= $objconfig->execute_select("SELECT idstock,idmarca,idmodelo,cantidad,serie,fvencimiento,lote,idmaterial,idtipomaterial,idunidad FROM stock_material WHERE idmaterial='".$_POST["idmaterial".$i]."' and cantidad >0 ORDER BY fvencimiento",1);
			//$and = " and lote='".$lote[$i_lote]."'";
			
			
			

			foreach ($lote[1] as $key => $vlote){   ///LTP1, 3, 101,102,103   //// () 121,122   ///() 3   122
				
				if($postcantidad>0){  //1 3>0
			
					$lote=$vlote['lote'];
					$cantlote=$vlote['cantidad'];
					$series=$vlote['serie'];
					$fvenc=$vlote['fvencimiento'];
					$idtpm=$vlote['idtipomaterial'];
					$idunidad=$vlote['idunidad'];
					$idmodelo=$vlote['idmodelo'];
					$idmarca=$vlote['idmarca'];

					if($lote==''){
	    			echo "<br>no tiene lote";

	    			///////////////////////////////////////////////////
	    			if($series!=''){
	      			echo "<br>tiene serie";
	      			$array = explode(",", $series);
      				$cantseries=count($array);			//2 //1
	      			  
      				if($postcantidad>=$cantseries){
      					////////////////////////////*
      					echo "<br>es mayor o igual";
				        $cantseriesdescontadas=$cantseries;  //1

				        $nroseriesmat= $cantseries; ///postcantidad, $cantseries

				        $cadserieselim="";

				        if($nroseriesmat==1){
				          
				          $serierelim=$series; //1
				          $series='()SM';
				          $cadserieselim=1;
				          $postcantidad=$postcantidad-$cantseries;
				        }else{
				          while($nroseriesmat>1)   
				          {      
				            $pos=stripos($series,',');
				            $serierelim=substr($series,0,$pos+1);
				            $cadserieselim=$cadserieselim.$serierelim;
				            $series=substr($series, $pos+1);
				            $c++;
				              
				            $nroseriesmat=$nroseriesmat-1;  
				            if($nroseriesmat<=1){
				              //  echo "<br> cuaando vale 0,".$series;
				              $serierelim=$series.' ';
				              $cadserieselim=$cadserieselim.$serierelim; 
				              $series='()SM';

				              $postcantidad=$postcantidad-1;       
				            }
				            $postcantidad=$postcantidad-1;        
				          }
				        }

      				}else if($postcantidad<$cantseries){  //1<2  //2<6
      					echo "<br>es menor";
				        $cantseriesdescontadas=$postcantidad; //1
				        $cantstkm=$cantseries-$postcantidad;  ///1

				        $nroseriesmat= $postcantidad;  /////1
				        $cadserieselim="";
				        while($nroseriesmat>0)
        				{
        					$pos=stripos($series,',');
			            $serierelim=substr($series,0,$pos+1); //121  ////101,102
			            $cadserieselim=$cadserieselim.$serierelim; ///'121'   ////'101,102'
			            $series=substr($series, $pos+1); //////VALOR PARA VALIDAR VALOR DE VARIBLES FFINALES (CASO 3 ()Sm)

			            $nroseriesmat=$nroseriesmat-1; ////0 1 0
         					$postcantidad=$postcantidad-1; /// 0
        				}	

      				}
	      		}else if($series==''){
				      if($postcantidad>=$cantlote){
				        $series='()()M';
				        $cantseriesdescontadas=$cantlote;
				        $serieselim='';
				        $postcantidad=$postcantidad-$cantlote;
				      }else if($postcantidad<$cantlote){
				        $series='()()m';
				        $cantseriesdescontadas=$postcantidad;
				        $cantstkm=$cantlote-$postcantidad;
				        $serieselim='';
				        $postcantidad=0;
				      }
				    }	

	    		}else if($lote!=''){
	    			echo "<br>si tien lote";
	    			$array = explode(",", $series);
	    			$cantseries=count($array);     //3

	    			if($series==''){
	    				echo "<br>no tiene serie";

				      if($postcantidad>=$cantlote){
				      	echo "<br>(L()M)";
				        //$series='--';
				        $series='L()M';
				        $cantseriesdescontadas=$cantlote;
				        //$serieselim=$cantlote;
				        $serieselim='';
				        $postcantidad=$postcantidad-$cantlote;

				      }else if($postcantidad<$cantlote){
				        echo "<br>(L()m)";

				        //$series='---';
				        $series='L()m';
				        $cantseriesdescontadas=$postcantidad;
				        //$serieselim=$postcantidad;
				        $serieselim='';
				        $cantstkm=$cantlote-$postcantidad;
				        $postcantidad=0;
				      }				      

	    			}else if($series!=''){
	    				echo "<br>tiene serie";
	    				if($postcantidad>=$cantseries){  //4>3
	    					echo "<br>es mayor o igual";
	        			$cantseriesdescontadas=$cantseries; //3
	        			$nroseriesmat= $cantseries;					//3

	        			$cadserieselim="";
	        			if($nroseriesmat==1){
	          
				          $serierelim=$series;
				          $series='LXM';
				          $cadserieselim=1;
				          $postcantidad=$postcantidad-$cantseries;
				        }else{
				        	while($nroseriesmat>1)  //3 2 
	        				{
	        					$pos=stripos($series,',');
					          $serierelim=substr($series,0,$pos+1); 	//// 101 , 102 
					          $cadserieselim=$cadserieselim.$serierelim; 		// '101,102,'
					          $series=substr($series, $pos+1);

					          $nroseriesmat=$nroseriesmat-1; //2 1
					          if($nroseriesmat<=1){
					          	$serierelim=$series.' '; 							////103
					            $cadserieselim=$cadserieselim.$serierelim; //103 
					            $series='LXM';                  //////VALOR PARA VALIDAR VALOR DE VARIBLES FFINALES (CASO 1 LXM) 

					            $postcantidad=$postcantidad-1; /// 1
					          }
					          $postcantidad=$postcantidad-1;  ///3 2
	        				}  
				        }

	    				}else if($postcantidad<$cantseries){

	    					echo "<br>es menor osea LXm";
				        $cantseriesdescontadas=$postcantidad;
				        $cantstkm=$cantseries-$postcantidad;

				        $nroseriesmat= $postcantidad;

				        $c=0;
				        $cadserieselim="";
				        while($nroseriesmat>0)
				        {
				            $pos=stripos($series,',');
				            $serierelim=substr($series,0,$pos+1);
				            $cadserieselim=$cadserieselim.$serierelim;
				            $series=substr($series, $pos+1);
				         $nroseriesmat=$nroseriesmat-1;
				         $postcantidad=$postcantidad-1;                
				        }

	    				}
	    			}

	    		}

	    		//////////////////VALIDACIONES SEGUN CASO////////////////////////////////////////////////
	    		if($lote!=''){
			      echo "<br>Rentra AQUI L";
			      if ($series!='' && $series!='LXM' && $series!='L()M' && $series!='L()m'){
			        // echo "<br>Entra AQUI LXm<br>";  
			       
			        $series; ///lo que actualizara en series de stock_materiales
			        $cantstkm; ///lo que actualizara en series de stock_materiales
			        $serieselim=substr($cadserieselim,0,strlen($cadserieselim)-1);

			      }else if($series!='' && $series=='LXM'){
			        $series='';
			        // echo "<br>Entra AQUI LXM<br>";

			        $series; ///lo que actualizara en series de stock_materiales
			        $cantstkm=0; ///lo que actualizara en series de stock_materiales
			        if($cantseries==1){
			          $serieselim=$serierelim;
			        }else{
			          $serieselim=substr($cadserieselim,0,strlen($cadserieselim)-1);
			        }
			        
			      }else if($series!='' && $series=='L()M'){
			        $series='';
			        // echo "<br>Entra AQUI L()M<br>";
			        $series;
			        $cantstkm=0;
			        $serieselim;

			      }else if($series!='' && $series=='L()m'){
			        $series='';
			        // echo "<br>Entra AQUI L()m<br>";
			        $series;
			        $cantstkm;
			        $serieselim;
			      }

			    }else if($lote==''){
			      if($series!='' && $series=="()SM"){
			        $series='';
			        // echo "<br>Entra aqui ()SM";
			        $series;
			        $cantstkm=0; ///lo que actualizara en series de stock_materiales
			        if($cantseries==1){
			          $serieselim=$serierelim;
			        }else{
			          $serieselim=substr($cadserieselim,0,strlen($cadserieselim)-1);
			        }
			        
			      }else if($series!=''&& $series=='()()M'){
			        echo "<br>Entra aqui ()()M";
			        $series='';
			        echo "<br>SERIES SALDO EN BD:: ".$series;
			        echo "<br>CANT. SALDO EN BD:: ".$cantstkm=0; ///lo que actualizara en series de stock_materiales
			        echo "<br>EGRESA:: ".$serieselim;

			      }else if($series!=''&& $series=='()()m'){
			        echo "<br>Entra aqui ()()m";
			        $series='';
			        echo "<br>SERIES SALDO EN BD:: ".$series;
			        echo "<br>CANT. SALDO EN BD:: ".$cantstkm; ///lo que actualizara en series de stock_materiales
			        echo "<br>EGRESA:: ".$serieselim;

			      }
			      else{
			        // echo "<br>Entra aqui ()Sm";
			        $series;
			        $cantstkm; ///lo que actualizara en series de stock_materiales

			        if($cantseries==1){
			          $serieselim=$serierelim;
			        }else{
			          $serieselim=substr($cadserieselim,0,strlen($cadserieselim)-1);
			        }
			        
			      }
			      
			    }

			    $cantseriesdescontadas;
			    $postcantidad;

	    		////////////////////////////////////////////////////////////////////////////////////////
    			////actualiza (restando todo a 0)
	 				$actu = "update stock_material set cantidad='".$cantstkm."',serie='".$series."' where idmaterial='".$vlote["idmaterial"]."' and idmarca='".$vlote["idmarca"]."' and idtipomovimiento=1 and idmodelo='".$vlote["idmodelo"]."' and serie='".$vlote['serie']."' and fvencimiento='".$vlote['fvencimiento']."'and lote='".$vlote["lote"]."'";

	 				echo "<br>ACTUALIZA:: ".$actu."<br>";
	 				$objconfig->execute($actu);

	 				//$arrimprimir=array("seriessal"=>$serieselim,"lotessal"=>$lote,"cantidad"=>'('.$cantseriesdescontadas.')');
	 				$sql1 = "insert into salida_det(idsalida,cantidad,idmaterial,idmarca,serie,idtiposalida,fvencimiento,idtipomaterial, codpatri ,codpatrilab,idunidad,idmodelo,lote,saldo_stock)values(".$next.",".$cantseriesdescontadas.",".$_POST["idmaterial".$i].",".$idmarca.",'".$serieselim."',".$_POST["0form_idtiposalida"].",'".$fvenc."',".$idtpm.",'".$_POST["codpatri".$i]."','".$_POST["codpatrilab".$i]."','".$idunidad."','".$idmodelo."','".$lote."','".$cantstkm."')";


					echo "<br>INSERTA::  ".$sql1;
					$objconfig->execute($sql1);
				}

				


			}
		
	}	
		
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
		$sql_stock = "insert into stock_x_marcas(idingreso,idejecutora,idred,idmicrored,idestablecimiento,cantidad,idmaterial,idmarca,idtipobien,
				fechacompra, fvencimiento, idunidad, idtipomaterial,idtipoingreso,idcomprobante,nrocomprobante,ajuste,idtipomovimiento, idmodelo)
				select  id.idsalida,i.idejecutora,i.idred,i.idmicrored,i.idestablecimiento, id.cantidad,id.idmaterial,id.idmarca,0,
				i.fechasalida,id.fvencimiento,id.idunidad,id.idtipomaterial,id.idtiposalida,0,i.nrorden,0,2,idmodelo
				from salida_det as id
				inner join salida as i on i.idsalida=id.idsalida
				where id.idsalida=".$next;
				 //echo "StockxMarca: ".$actu;
		$objconfig->execute($sql_stock);

		if($_POST["req_correlativo"] != ""){
			$actual = "UPDATE requerimiento SET estareg = 5 WHERE correlativo = '".$_POST["req_correlativo"]."'";
			// echo $actual;
			$objconfig->execute($actual);
		}
	
	
		$ncorre = $_POST["idcorrelativo"]+1;
		$actualTipoSalidad = "UPDATE tipo_salida SET correlativo = '".$ncorre."' WHERE idtiposalida = '".$_POST["0form_idtiposalida"]."'";
			// echo "Correlativo tipoSalida: ".$actualTipoSalidad;
		$objconfig->execute($actualTipoSalidad);
	
		//PARA REGISTRAR EL LOG DE LA ACCIONES	
	
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

       if($_POST["op"]==1)
        {   
           $objconfig->execute("insert into log(usuario,ip,descripcion,hora,tipo_examen,nombre_usuario,idusuario) 
                                values('".$_SESSION['nombre']."','".$ip."','SE REGISTRO SALIDA DE MATERIALES DEL ALMACEN NUMERO: ".$next." INGRESADO POR: ".strtoupper($_POST["0form_nombre_usuario"])."','".date("h:i:s A")."','SALIDA MATERIAL','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_idusuario"]."')");
        }else{
           $objconfig->execute("insert into log(usuario,ip,descripcion,hora,tipo_examen,nombre_usuario,idusuario) ) 
                                values('".$_SESSION['nombre']."','".$ip."','SE MODIFICACION SALIDA DE MATERIALES DEL ALMACEN CON REG.°: ".$_POST["1form_idsalida"]." DIGITADO POR:  ".strtoupper($_POST["0form_nombre_usuario"])."','".date("h:i:s A")."','SALIDA MATERIAL','".$_POST["0form_nombre_usuario"]."','".$_POST["0form_idusuario"]."')");
        }

?>