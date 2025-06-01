<?php
	include("../../../objetos/class.cabecera.php");	
    include("../../../objetos/class.conexion.php");
    $objconfig = new conexion();
?>
<style>
    table,  td {
        border: 0px solid black;
        font-size: 12px;
    }
</style>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Reporte Consolidado de Bienes y Muebles</h1>
	</div>
    <div class="col-lg-12">
        <div class="row" style="display:flex;align-items: end;">
            <div class="col-lg-4">
                <label for="atencion">Red</label>
                <select class="form-control" id="idred" onchange="cargar_microred(this.value);">
                    <option value="-1">Todos</option>
                    <?php
                        $queryT = "select idred, descripcion  from red where estareg=1 order by descripcion asc";
                        $itemsT = $objconfig->execute_select($queryT,1);

                        foreach($itemsT[1] as $rowT)
                        {
                            $selected="";
                            echo "<option value='".$rowT["idred"]."' ".$selected." >".strtoupper($rowT["descripcion"])."</option>";
                        }
                    ?>
                </select>
            </div>   
            <div class="col-lg-4">
                <label for="atencion">Micro Red:</label>
                <div id="div-microred"></div>
               
            </div> 
            <div class="col-lg-4">
                <label for="atencion">Establecimiento Salud:</label>
                <div id="div-establecimiento"></div>
            </div>                      
            
        </div>
        <!-- <div align="left">
            <button class='btn btn-outline btn-success'>
                Nuevo
            </button>
        </div> -->
    </div>   
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="row" style="display:flex;align-items: end;">
            <div class="col-lg-4">
                <label for="atencion">Area:</label>
                <div id="div-area"></div>
               
            </div> 
            <div class="col-lg-4">
                <label for="atencion">Sub Area:</label>
                <div id="div-subarea"></div>
            </div>                      
            <div class="col-lg-2">
                <button class='btn btn-success' id="btn_click"onclick="recarga2(carpeta)">
                    Buscar
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <br/>
        <table id="dataTables-exampl"  class="table table-striped table-bordered table-hover" width="100%" >
            <thead class="thead-inverse">
                <tr>
                    <th>Area</th>
                    <th>Responsable</th>
                    <th>bien</th>
                    <th>Cod. Patrimonial</th>
                    <th>Cod. Patrimonial Lab</th>
                    <th># Serie</th>
                    <th>Modelo</th>
                    <th>Marca</th>
                    <th>Color</th>
                    <th>Estado</th>

                    <!-- <th><img src="../img/xls.png" alt="Exportar Excel" width="25" height="25"> </th> -->
                </tr>
            </thead>
        </table> 
    </div>
</div>
   

<script type="text/javascript">
    cargar_microred(<?php echo 0; ?>);
    cargar_estable(<?php echo 0; ?>;
	
	//<![CDATA[
    $(document).ready(function(){
        $('.combobox').combobox()
    });
    //]]>
</script>
