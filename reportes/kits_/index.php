<?php
    include("../../objetos/class.cabecera.php");
    include("../../objetos/class.conexion.php");

    $objconfig = new conexion();

?>
<style>
    table th{
	background-color: #337ab7 !important;
	color: white;
    }

    table>tbody>tr>td {
        vertical-align: middle !important;
    }

    .btn-group, .btn-group-vertical{
        position: absolute !important;
    }
    .panel{
        margin-top: 10px;
    }

</style>

<div class="panel panel-default">
 
  <div class="panel-body">
  <!--
  <fieldset class="scheduler-border">
	<legend class="scheduler-border">Por Tipo de Kits Distribuidos </legend>
    <div class="row">
	<div class="col-md-12">
		    <div class="col-md-1">
                <label for="atencion" class="control-label">Kits: </label>
            </div>
            <div class="col-md-8">
               <select id="kits" name="kits"  class="form-control" >
                    <option value="0">Todos</option>
                    <?php
                    $queryT = "select  idmaterial, materia  from vista_kitsalida_det  group by idmaterial ,materia order by materia asc";
                    $itemsT = $objconfig->execute_select($queryT,1);

                    foreach($itemsT[1] as $rowT)
                    {
                        $selected="";
                        echo "<option value='".$rowT["idmaterial"]."' ".$selected." >".strtoupper($rowT["materia"])."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-1">
				<button type="button" onclick="listar_matriales()" class="btn btn-success btn-sm waves-effect waves-light">Visualizar&nbsp;&nbsp;<i class="glyphicon glyphicon-signal"></i></button>
            </div>
          </div>
        </div>

		</fieldset>
		-->
		<fieldset class="scheduler-border">
	<legend class="scheduler-border">Por Establecimiento </legend>
    <div class="row">
	<div class="col-md-12">
		    <div class="col-md-1">
                <label for="atencion" class="control-label">Laboratorio </label>
            </div>
            <div class="col-md-4">
               <select id="estable" name="estable"  class="form-control" >
                    <option value="0">Todos</option>
                    <?php
                    $queryT = "select  idestablesolicita, estab_solicita  from vista_kitsalida_det  group by idestablesolicita ,estab_solicita order by estab_solicita asc";
                    $itemsT = $objconfig->execute_select($queryT,1);

                    foreach($itemsT[1] as $rowT)
                    {
                        $selected="";
                        echo "<option value='".$rowT["idestablesolicita"]."' ".$selected." >".strtoupper($rowT["estab_solicita"])."</option>";
                    }
                    ?>
                </select>
            </div>
			<div class="col-md-1">
                <label for="atencion" class="control-label">Kits: </label>
            </div>
			<div class="col-md-4">
               <select id="kits" name="kits"  class="form-control" >
                    <option value="0">Todos</option>
                    <?php
                    $queryT = "select  idmaterial, materia  from vista_kitsalida_det  group by idmaterial ,materia order by materia asc";
                    $itemsT = $objconfig->execute_select($queryT,1);

                    foreach($itemsT[1] as $rowT)
                    {
                        $selected="";
                        echo "<option value='".$rowT["idmaterial"]."' ".$selected." >".strtoupper($rowT["materia"])."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-1">
				<button type="button" onclick="listar_matriales()" class="btn btn-primary btn-md waves-effect waves-light"><i class="glyphicon glyphicon-eye-open"></i></button>
			</div>
			 <div class="col-md-1">
				<button class="btn btn-success btn-md center-block" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target='#impresiones' onclick="imprimir_ficha(1)"><span class="glyphicon glyphicon-download-alt"></span> </button>
            </div>
          </div>
        </div>

		</fieldset>

	
  </div>
</div>						
 
 
<div class="row small-spacing" id="tabla-reporte" style="display: none;">
    <div class="col-lg-12 col-md-12">
        <div class="box-content card white">
            <!-- /<h4 class="box-title">Ventas registradas</h4>
            .box-title -->
            <div class="card-content">                        
                <div class="row">
                    <div class="col-md-12 table-responsive" id="reporte-generado">
                        <table class="table table-striped table-bordered display" style="width:100%" id="reporte-ventas">
                            <thead>
                                <tr style="background-color: #ccc;">
                                    <th>Item</th>
                                    <th>Establecimiento</th>
									<th>Material</th>
                                    <th>Marca</th>
                                    <th>Lote</th>
                                    <th>Saldo Determinaciones</th>                                            
                                </tr>
                            </thead>
                            <tbody id="cuerpo-reporte"></tbody>
							<!--
							<tfoot>
							  <td class="bg-grays-active color-palette"><b>Total </b></td>
							  <td class="bg-teals-active color-palette text-center">
								<strong id="abiertoEnTiempo"></strong>
							  </td>
							  <td class="bg-teals-active color-palette text-center">
								<strong></strong>
							  </td>
							  <td class="bg-teals-active color-palette text-center">
								<strong></strong>
							  </td>
							  <td class="bg-teals-active color-palette text-center">
								<strong></strong>
							  </td>
							  <td class="bg-teals-active color-palette text-center">
								<strong id="SaldoDeterminantes">0</strong>
							  </td>
							</tfoot>
							-->
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.card-content -->
        </div>
        <!-- /.box-content -->
    </div>
</div>

	
<div class="modal fade bd-example-modal-xl" id="impresiones" name="impresiones"  tabindex="0" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

	  <div class="modal-dialog modal-xl">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close"  data-dismiss="modal" aria-hidden="true">×</button>
			<h4 class="modal-title text-center" id="myModalLabel">REPORTE DE MUESTRAS ENTOMOLÓGICA - LABORATORIO REFERENCIAS DE SAN MARTIN</h4> 
		  </div>
			<div class="modal-body">
			<div style="text-align: center;">
			<iframe name="mostrarpdf" id="mostrarpdf" src="" src=""  width="100%" height="800" frameborder="0"> </iframe>
			Derechos Reservados - Soporte Técnico.
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-primary" onclick="regresar_index(carpeta)" data-dismiss="modal">Cerrar</button>
			
		  </div>
		</div>
	  </div>
	</div>
	