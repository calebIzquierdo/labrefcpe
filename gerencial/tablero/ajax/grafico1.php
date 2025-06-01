<?php   
	/* CAT:Line chart */
	include("../../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
	$idindicador 	= $_GET["id"];
	$idsector		= $_GET["idsector"];
	$anio			= $_GET["anio"];
	//$idsubunidad	= $_GET["idsubunidad"];
	
	if($idindicador==1)
	{
		$queryT = "select * from tablero 
				   where idindicador=".$idindicador." and anio='".$anio."'";		
	}
	if($idindicador==3 || $idindicador==7)
	{
		$queryT = "select * from tablero_sector 
			   	   where idindicador=".$idindicador." and idsector=".$idsector." and anio='".$anio."'";
	}
	if($idindicador==8)
	{
		$queryT = "select * from tablero_productor
		where idindicador=".$idindicador." and idproductor=".$idsector." and anio='".$anio."'";
	}
	if($idindicador==4)
	{
		$queryT = "select * from tablero_productos
		where idindicador=".$idindicador." and idtipoproducto=".$idsector." and anio='".$anio."'";
	}
	if($idindicador==2 || $idindicador==9 || $idindicador==10)
	{
		$queryT = "select * from tablero_certificados
		where idindicador=".$idindicador." and idcertificado=".$idsector." and anio='".$anio."'";
	}
	
	$rowT = $objconfig->execute_select($queryT,1);
	
	foreach($rowT[1] as $r)
	{
		$enero 		= number_format($r["Enero"],2);
		$febrero 	= number_format($r["Febrero"],2);
		$marzo 		= number_format($r["Marzo"],2);
		$abril 		= number_format($r["Abrilbril"],2);
		$mayo 		= number_format($r["Mayo"],2);
		$junio 		= number_format($r["Junio"],2);
		$julio 		= number_format($r["Julio"],2);
		$agosto		= number_format($r["Agosto"],2);
		$setiembre	= number_format($r["Setiembre"],2);
		$octubre	= number_format($r["Octubre"],2);
		$noviembre	= number_format($r["Noviembre"],2);
		$diciembre	= number_format($r["Diciembre"],2);
	}
 /* pChart library inclusions */
 include("../../../objetos/class/pData.class.php");
 include("../../../objetos/class/pDraw.class.php");
 include("../../../objetos/class/pImage.class.php");

 /* Create and populate the pData object */
 $MyData = new pData();  
 $MyData->addPoints(array($enero,$febrero,$marzo,$abril,$mayo,$junio,$julio,$agosto,$setiembre,$octubre,$noviembre,$diciembre),"Meses");
 //$MyData->addPoints(array(2,7,5,18,19,22),"Probe 2");
 //$MyData->setSerieWeight("Probe 1",2);
 //$MyData->setSerieTicks("Probe 2",4);
 $MyData->setAxisName(0,"");
 $MyData->addPoints(array("Ene.","Feb.","Mar","Abr.","May.","Jun.","Jul.","Ago.","Set.","Oct.","Nov.","Dic."),"Labels");
 $MyData->setSerieDescription("Labels","Months");
 $MyData->setAbscissa("Labels");

 /* Create the pChart object */
 $myPicture = new pImage(700,230,$MyData);

 /* Turn of Antialiasing */
 $myPicture->Antialias = FALSE;

 /* Draw the background */
 $Settings = array("R"=>170, "G"=>183, "B"=>87, "Dash"=>1, "DashR"=>190, "DashG"=>203, "DashB"=>107);
 $myPicture->drawFilledRectangle(0,0,700,230,$Settings);

 /* Overlay with a gradient */
 $Settings = array("StartR"=>219, "StartG"=>231, "StartB"=>139, "EndR"=>1, "EndG"=>138, "EndB"=>68, "Alpha"=>50);
 $myPicture->drawGradientArea(0,0,700,230,DIRECTION_VERTICAL,$Settings);
 $myPicture->drawGradientArea(0,0,700,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>80));

 /* Add a border to the picture */
 $myPicture->drawRectangle(0,0,699,229,array("R"=>0,"G"=>0,"B"=>0));
 
 /* Write the chart title */ 
 $myPicture->setFontProperties(array("FontName"=>"../../../objetos/fonts/Forgotte.ttf","FontSize"=>8,"R"=>255,"G"=>255,"B"=>255));
 $myPicture->drawText(10,16,"",array("FontSize"=>11,"Align"=>TEXT_ALIGN_BOTTOMLEFT));

 /* Set the default font */
 $myPicture->setFontProperties(array("FontName"=>"../../../objetos/fonts/pf_arma_five.ttf","FontSize"=>6,"R"=>0,"G"=>0,"B"=>0));

 /* Define the chart area */
 $myPicture->setGraphArea(60,40,650,200);

 /* Draw the scale */
 $scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
 $myPicture->drawScale($scaleSettings);

 /* Turn on Antialiasing */
 $myPicture->Antialias = TRUE;

 /* Enable shadow computing */
 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

 /* Draw the line chart */
 $myPicture->drawLineChart();
 $myPicture->drawPlotChart(array("DisplayValues"=>TRUE,"PlotBorder"=>TRUE,"BorderSize"=>2,"Surrounding"=>-60,"BorderAlpha"=>80));

 /* Write the chart legend */
 $myPicture->drawLegend(590,9,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL,"FontR"=>255,"FontG"=>255,"FontB"=>255));

 /* Render the picture (choose the best way) */
 $myPicture->autoOutput("../../../objetos/picture/example.drawLineChart.plots.png");
?>
