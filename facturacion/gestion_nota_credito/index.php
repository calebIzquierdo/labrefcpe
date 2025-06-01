<?php
include("../../objetos/class.cabecera.php");	
include("../../objetos/class.conexion.php");
$objconfig = new conexion();
	
?>
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Gestión de Nota de Credito</h1>
	</div>
    <div class="col-lg-12">
        <div align="left">
            <button data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#userModal"  onclick="cargar_form(1,0)" class='btn btn-outline btn-primary'>
                Registrar
            </button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <br/>
        <table id="dataTables-example"  class="table table-striped table-bordered table-hover" width="100%" >
            <thead class="thead-inverse">
                <tr>
                    <th>Procedencia</th>
                    <th>Cliente</th>
                    <th>RUC</th>
                    <th>Fecha Emision</th>
                    <th>Tipo Comprobante</th>
                    <th>Nro. Documento</th>
                    <th>Tipo Pago</th>
                    <!-- <th>Total</th> -->
                    <th>Firmas</th>
					<th>Envios</th>
					<th>Consultas</th>
					<th>Imprimir</th>
					<th>Enviar Correo</th>
                    <!-- <th><img src="../img/xls.png" alt="Exportar Excel" width="25" height="25"> </th> -->
                </tr>
            </thead>
        </table> 
    </div>
</div>
<div id="userModal" name="userModal" class="modal fade bd-example-modal-xl"  tabindex="0" >
	<div class="modal-dialog">
		<div id="modal-body" name="modal-body"> 
		
		</div>

		</div>
	</div>
</div>
<div class="modal fade bd-example-modal-xl" id="impresiones" name="impresiones"  tabindex="0" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-xl">
		<div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="regresar_index(carpeta)" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="myModalLabel">Comprobante generada</h4> 
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
<div class="modal fade bd-example-modal-xl" id="sendCorror" name="sendCorror"  tabindex="0" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form method="post" enctype="multipart/form-data"  id="send_pdfp"  name="send_pdfp" onsubmit="validar_correo();return false">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" onclick="ocultarVentanaSendEmail();" class="close" data-dismiss="modal">&times; </button>
			        <h4 class="modal-title text-center" id="myModalLabel">Enviar correo comprobante</h4> 
                </div>
                <div class="modal-body">
                    <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-3">
                            <label for="atencion" class="control-label">Correo Electronico: </label>
                        </div>
                        <div class="col-md-9">				
                            <input type="email" require name="email" id="email" onkeyup="mayuscula(this);" class="form-control" placeholder="example@mail.com" data-toggle="tooltip" data-placement="top" title="Código de Barra" />
                        </div>
                        
                    </div>
                </div>
                <div class="upload-msg col-md-12"></div>
                <div class="modal-footer">
                    <input type="submit" name="action" id="action2" class="btn btn-success"  value="Enviar" />
						<button type="button" class="btn btn-primary" onclick="ocultarVentanaSendEmail()" data-dismiss="modal">Cerrar</button>
                </div>
               
				</div>
            </div>
    </div>
</form>
</div>