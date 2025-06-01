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
    <div class="col-md-1"></div> 
        <div class="form-group">
            <label for="exampleInputEmail2">Tipo Comprobante:</label>
            <select id="idcomprobante" name="idcomprobante" class="combobox form-control" >
                    <option value="0"> Todos </option>
                    <?php
                    $queryT = "select idcomprobante, descripcion  from tipo_comprobante where idcomprobante in(2,3)
							order by descripcion asc";
                    $itemsT = $objconfig->execute_select($queryT,1);

                    foreach($itemsT[1] as $rowT)
                    {
                        $selected="";
                        echo "<option value='".$rowT["idcomprobante"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
                    }
                    ?>
            </select>
        </div>
        
        <div class="form-group">
        <div class="col-md-1"></div> 
            <label for="exampleInputEmail2">Desde:</label>
            <input class="form-control" type="date" name="finicioA" id="finicioA" value="<?php echo date("d/m/Y");?>"  >
        </div>  
        <div class="form-group">
            <label for="exampleInputEmail2">Hasta:</label>
            <input class="form-control" type="date" name="ffinalA" id="ffinalA" value="<?php echo date("d/m/Y");?>"  >
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
                                    <th>N° documento</th>
                                    <th>Fecha Emision</th>
                                    <th>Comprobante</th>
                                    <th>Tipo Pago</th>
                                    <th>Descuento</th>  
                                    <th>Monto1</th>
                                    <th>Monto</th>
                                    <th>Valor</th>
                                    <th>Cliente</th>     
                                    <th>Fecha Recepcion</th>
                                    <th>Fecha Reg</th>
                                    <th>Hora Reg</th>
                                    <th>Tipo Atencion</th>     
                                    <th>Estado Examen</th>
                                    <th>Tipo Examen</th>
                                    <th>Procedencia</th>
                                    <th>Usuario</th>
                                    <th>Tipo Documento</th>                                                     
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

