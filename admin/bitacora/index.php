<?php 
include("../../objetos/class.cabecera.php");
?>


<style>
    table,  td {
        border: 0px solid black;
     /*   font-family: "Times New Roman", serif; */
        font-size: 12px;
    }
    th{
        /* el tamaño por defecto es 14px
      color:#456789; */
        font-size:12px;
    }
    .card-columns {
    media-breakpoint-only(lg) {
        column-count: 4;
    }
    media-breakpoint-only(xl) {
        column-count: 5;
    }
    }


</style>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Bitácora del Sistema</h1>
        
    </div>
    
    <!-- /.col-lg-12 -->
</div>


<div class="row">
        <div class="col-lg-12">
           <!-- <div class="panel panel-heading">
                        
                         /.panel-heading 
            <div class="panel-body"> -->
            <table id="dataTables-example"  class="table table-striped table-bordered table-hover" width="100%" >
            <thead class="thead-inverse">
            <tr>

                <th>N°</th>
				<th>Usuario</th>
				<th>Ip</th>
				<th>Acciones</th>
				<th>Fecha</th>
				<th>Hora</th>
            </tr>
            </thead>
            
            </table> 
        <!--     </div>
            </div>-->
        </div>
    </div>
   

</div>

