<?php

	ini_set("memory_limit","64M");
	
	include_once($_SERVER['DOCUMENT_ROOT']."/labrefcpe/objetos/pdf/fpdf.php");

	set_time_limit(0);
	
	header ('Content-type: text/html; charset=utf-8');
		
	class clsReporte extends FPDF
	{
            function __construct() {
                parent::__construct();
            }
		var $widths;
		var $aligns;
		
            function Header()
            {
                    global $codsuc;

                    //$this->Image("../../img/head_Horizontal.jpg",6,2,285,20,'JPG',"http://hospitaltarapoto.gob.pe/");
                    $this->Image("../../../img/head_Vertical.jpg",10,1,195,15,'JPG',"http://hospitaltarapoto.gob.pe/");

                    //$fecha = date("d/m/Y h:i:s a ");
                    $fecha = date("d/m/Y ");
                    $hora = date("h:i:s a ");
            $this->SetXY(182,5);
            $this->SetFont('Arial','',8); 
            $this->Cell(85, 3,"F.I: ".$fecha,0,1,'L');
			$this->SetXY(182,8);
            $this->Cell(85, 3,"H.I: ".$hora,0,1,'L');

            $idusuario = explode("|",$_SESSION['nombre']);
            $iduser = $idusuario[0];
            $entidad =  $this->execute_select("select idusuario, est.ruc, est.descripcion as estable, direccion
                                              from usuarios as u  inner join establecimiento as est on est.idestablecimiento= u.idestablecimiento where idusuario=".$iduser);
            //echo $entidad;
			$tit1=strtoupper($entidad[1]["estable"]);
			$tit2=strtoupper($entidad[1]["ruc"]);
			$tit3=$entidad[1]["direccion"];

			$x 	= 10;
            $y 	= 5;
			$h	= 3;
			
            $this->SetXY($x,$y);
			$this->SetFont('Arial','',6);
			$this->Cell(85, $h,utf8_decode($tit1),0,1,'L');
			$this->SetX($x);
			$this->Cell(85, $h,utf8_decode($tit2),0,1,'L');
			$this->SetX($x);
			$this->Cell(150, $h,utf8_decode($tit3),0,0,'L');
			
			$this->SetY(17);
			$this->SetLineWidth(.1);
		//	$this->Cell(0,.1,"",1,1,'C',true);
			
            $this->Ln(5); 
			
			$this->cabecera();     

		}
		
		function SetWidths($w)
		{
			$this->widths=$w;
		}
		function SetAligns($a)
		{
			$this->aligns=$a;		
		}
		function fill($f)
		{
			$this->fill=$f;	
		}
		function Row($data)
		{
			$nb=0;
	
			for($i=0;$i<count($data);$i++)
				$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));

			$h=6*$nb;

           // echo " Item => ".$i." NB => ".$nb." h =>".$h."; " ;

			$this->CheckPageBreak($h);
		
			for($i=0;$i<count($data);$i++)
			{
				$w=$this->widths[$i];				
				$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
				$x=$this->GetX();
				$y=$this->GetY();
				$this->Rect($x,$y,$w,$h,$style);
				$this->MultiCell($w,5,$data[$i],'RML',$a,$fill);
				$this->SetXY($x+$w,$y);
			}
			$this->Ln($h);
		
		}
		function CheckPageBreak($h)
		{
			if($this->GetY()+$h>$this->PageBreakTrigger)
				$this->AddPage($this->CurOrientation);
		
		}
		function NbLines($w,$txt)
		{
			$cw=&$this->CurrentFont['cw'];
			if($w==0)
			$w=$this->w-$this->rMargin-$this->x;
			$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		
			$s=str_replace('\r','',$txt);
		
			$nb=strlen($s);
		
			if($nb>0 and $s[$nb-1]=='\n')
			
			$nb–;
			
			$sep=-1;
			
			$i=0;
			
			$j=0;
			
			$l=0;
			
			$nl=1;
		
			while($i<$nb)
			{
			$c=$s[$i];
		
			if($c=='\n')
			{
			$i++;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
		
			continue;
			}
			if($c=='')
				$sep=$i;
				$l+=$cw[$c];
				if($l>$wmax)
				{

					if($sep==-1)
					{
		
						if($i==$j)
		
							$i++;
						}
						else
							$i=$sep+1;
							$sep=-1;
							$j=$i;
							$l=0;
							$nl++;
		
					}
					else
						$i++;
					}
		
					return $nl;

		}
		function Footer()
		{		
			$this->SetY(-10);
			$this->SetFont('Arial','I',6);
			$this->SetTextColor(0);
			$this->SetLineWidth(.1);
			$this->Cell(0,.1,"",1,1,'C',true);
			$this->Ln(1);
			$this->Cell(0,4,'',0,0,'L');
			$this->Cell(0,4,'Pag. '.$this->PageNo().' de {nb}',0,0,'R');
			 
		}
		var $angle=0;

	//GIRAR IMAGEN http://www.fpdf.org/en/script/script2.php
		function Rotate($angle,$x=-1,$y=-1)
		{
			if($x==-1)
				$x=$this->x;
			if($y==-1)
				$y=$this->y;
			if($this->angle!=0)
				$this->_out('Q');
			$this->angle=$angle;
			if($angle!=0)
			{
				$angle*=M_PI/180;
				$c=cos($angle);
				$s=sin($angle);
				$cx=$x*$this->k;
				$cy=($this->h-$y)*$this->k;
				$this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
			}
		}

		function _endpage()
		{
			if($this->angle!=0)
			{
				$this->angle=0;
				$this->_out('Q');
			}
			parent::_endpage();
		}
		function RotatedText($x,$y,$txt,$angle)
		{
			//Text rotated around its origin
			$this->Rotate($angle,$x,$y);
			$this->Text($x,$y,$txt);
			$this->Rotate(0);
		}

		function RotatedImage($file,$x,$y,$w,$h,$angle)
		{
			//Image rotated around its upper-left corner
			$this->Rotate($angle,$x,$y);
			$this->Image($file,$x,$y,$w,$h);
			$this->Rotate(0);
		}
		
	}
	
?>
