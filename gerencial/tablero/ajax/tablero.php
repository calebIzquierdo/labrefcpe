<?php
	include("../../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
	$idindicador = $_POST["idindicador"];
?>


<style type="text/css">
table{font:Tahoma;font-size: 10px;}

	
	.datos_indicador{
		color:#000000;
		font-weight:bold;
		background:#FFFF99;
		padding:4px;
		
		border-radius: 25px 10px / 10px 25px;
		border:3px solid #CCC;
	}
	/*	
	.modal-xxl {
	max-width:1200px;
	// margin-right: 100px; 
	margin-left: -300px;
	}
	*/

    @media screen {
    #user_form {
        float:left;
        clear:both;
        width:90%;
        height:90%;
		 margin: 0  0 auto;
       /* margin-left: auto;
		background-color:#00FF00; 
	  */
    }
     
     
    }
    @media screen and (min-width: 1200px) {
        #user_form {
            width:970px;
         //   background-color:#0000FF;
        }
            
    }
    @media screen and (min-width: 1700px) {
        #user_form {
            width:970px;
          //  background-color:#F00;
        }
            
    }

</style>


<form method="post" enctype="multipart/form-data" id="user_form" name="user_form">
		 <div class="modal-content"  >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times; </button>
                <h4 class="modal-title">Tablero de Diagnostico Situacional</h4>
            </div>
            <div class="modal-body">
			<div class="row">
				<div class="col-md-12">
					<? include("datos_indicador.php"); ?>
				</div>
				<div class="col-md-12">
					<div id="div-grafico-tendencia"></div>
				</div>
			<div class="col-xl-12" >
			<div class="row col-md-12">
			<div class="col-md-2">
			<label class="control-label"> Tipo Grafico</label>
			</div>
			<div class="row col-md-2">
					<select name="idgrafico" id="idgrafico" class="form-control" onchange="actualizar_datos_grafico(<?php echo $idindicador; ?>);">
					<option value="">Lineas</option>
					<option value="bar">Barra</option>
					<option value="area">Area</option>
				<!--	<option value="pie">Torta</option>  -->
					<option value="column">Columnas</option>
				
					</select>
			</div>
			</div>
				<ul class="nav nav-tabs" role="tablist">
                        <li class="active">
                            <a href="#home" role="tab" data-toggle="tab">
                                <icon class="fa fa-line-chart"></icon> Grafico
                            </a>
                        </li>
                        <li><a href="#profile" role="tab" data-toggle="tab">
                                <i class="fa fa-bar-chart"></i> Tabla
                            </a>
                        </li>


				</ul>
				<div class="row">
				<div class="col-md-12">
					 <!-- Tab panes -->
					<div class="tab-content">
                        <div class="tab-pane fade active in" id="home">
							<div class="row">
								<div class="col-md-12">
									<div id="div-tablero-grafico" style="min-width: 310px; height: 400px; margin: 0 auto" ></div> 
								
								</div>
							</div>
                        </div>
					<!-- Termino del Primer tab  -->
					
					<!-- Inicio del Segundo tab-->
						<div class="tab-pane fade" id="profile">
					<!--	 <div style="height:580px;  overflow-x:hidden;" > -->
							<div class="row">
								<div class="col-md-12">
								   <div id="div-tabla-grafico" class="table-responsive"></div>
								</div>
							</div>
					<!--	</div> -->
						</div>
					</div>
				
				</div>
				</div>
			</div>
            </div>
			<br/>
			 <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

            </div>
		</div>
	</div>
</form>
	
<script>
	actualizar_datos_grafico(<?php echo $idindicador; ?>)
	actualizar_datos_tabla(<?php echo $idindicador; ?>)
	
	var ancho = screen.availWidth;
	var alto = screen.availHeight;
	// alert(ancho)
	// alert(alto)
	
	
	
</script>



	

    
   
    
   
    
    
    
    
    

