<?php
@session_start();

    $query = "select men.idpadre_primario, men.descripcion as menuprinc 
              from accesos as a
              inner join modulos as m on(a.idmodulo=m.idmodulo)
              inner join menu as men on(men.idpadre_primario=m.idpadre_primario)
              where a.idperfil=".$idperfil." and m.idpadre=0 group by menuprinc, men.idpadre_primario order by menuprinc asc " ;

	$row = $objconfig->execute_select($query,1);
	
	$canti = "select count(idpadre_primario) from menu "; 
	$rowCant = $objconfig->execute_select($canti);
	$count = $rowCant[1]["count"];
	 
	$query2 = "select men.idpadre_primario,m.idpadre, men.descripcion as menuprinc 
              from accesos as a
              inner join modulos as m on(a.idmodulo=m.idmodulo)
              inner join menu as men on(men.idpadre_primario=m.idpadre_primario)
              where  men.estareg=1 and  a.idperfil=".$idperfil." and m.idpadre=0 
			  group by menuprinc, men.idpadre_primario,m.idpadre order by men.descripcion asc ";
			  
	$row2 = $objconfig->execute_select($query2,1);	  
	foreach($row2[1] as $r2)
	{
      	echo "<li> <a href='#'> <i class='fa fa-folder-open'> </i> ".$r2["menuprinc"]."<span class='fa arrow'></span></a>";  

			$query3 = "select a.idmodulo,m.descripcion,m.url from accesos as a inner join modulos as m on(a.idmodulo=m.idmodulo)
          	where a.idperfil=".$idperfil." and m.idpadre=0 and m.idpadre_primario=".$r2['idpadre_primario']." order by m.descripcion asc";
			$row3 = $objconfig->execute_select($query3,1);

			echo "<ul class='nav nav-second-level'>";
			foreach($row3[1] as $r3)
			    {
			        $query13 = "select a.idmodulo,m.descripcion,m.url from accesos as a inner join modulos as m on(a.idmodulo=m.idmodulo)
				                    where a.idperfil=".$idperfil." and m.idpadre=".$r3["idmodulo"]." and m.idpadre_primario=".$r2['idpadre_primario']." order by m.descripcion asc";
				    $row13 = $objconfig->execute_select($query13,1);
				        
					$ul_inicio	=	"";
				    $ul_final	=	"";
					$flecha		=	"";
				//	$dibujo		=	"";
					$dibujo		=	"<i class='fa fa-check '></i>  ";
					$dibujo2	=	"<i class='fa fa-check '></i>  ";
						
				    if($row13[2]>0)
				        {
				            $ul_inicio	=	" <ul class='nav nav-third-level' > ";
				            $ul_final	=	"</ul>";
					        $dibujo		=	"<i class='fa fa-sitemap fa-fw'></i>  ";
					        $flecha		=	"<span class='fa arrow'> </span> ";
				        } 
						
						echo "<li>";  ?>
						<a href="#" onclick="listar_registros('<?php echo $r3["url"]; ?>');" > <?php echo $dibujo; ?> <?php echo $flecha; ?> <?php echo $r3["descripcion"]; ?></a>
						<?php
						echo $ul_inicio;
        				foreach($row13[1] as $r13)
        				{ ?>
							<li> <a href="#" onclick="listar_registros('<?php echo $r13["url"]; ?>');" > <?php echo $dibujo2; ?> <?php echo $r13["descripcion"]; ?>   </a>  </li>
							<?php
               			}
			            echo $ul_final;
			           	echo "</li>";
		        }
			    echo "</ul>";
			    echo "</li>";
	}
	

?>   
        
