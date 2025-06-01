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
    <form class="form-inline">
        <div class="form-group">
            <label for="exampleInputEmail2">Seleccione la clase:</label>
            <select id="tipomaterial" name="tipomaterial" class="form-control" >
            <option value="-1">Todos</option>
                <?php
                $queryT = "select idtipomaterial, descripcion  from tipo_material where estareg=1 order by descripcion asc";
                $itemsT = $objconfig->execute_select($queryT,1);

                foreach($itemsT[1] as $rowT)
                {
                    $selected="";
                    echo "<option value='".$rowT["idtipomaterial"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
                }
                ?>
            </select>
        </div>                                              
        <button type="button" onclick="listar_matriales()" class="btn btn-success btn-sm waves-effect waves-light">Visualizar&nbsp;&nbsp;<i class="glyphicon glyphicon-signal"></i></button>
                
    </form>  
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
                                    <th>Codigo</th>
				    <th>Tipo</th>
                                    <th>Material</th>
                                    <th>Unidad Medida</th>
                                    <th>Cantidad</th>                                            
                                </tr>
                            </thead>
                            <tbody id="cuerpo-reporte"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.card-content -->
        </div>
        <!-- /.box-content -->
    </div>
</div>

