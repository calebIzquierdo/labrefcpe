<?php
	include("../../objetos/class.cabecera.php");	
    include("../../objetos/class.conexion.php");
?>
<style>
    table,  td {
        border: 0px solid black;
        font-size: 12px;
    }
</style>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Gestión de Comprobantes Electrónicos</h1>
	</div>
    <div class="col-lg-12">
        <div align="left">
            <!-- <button onclick='excel_ficha()' class='btn btn-outline btn-success'>
                Exportar a Excel
            </button> -->
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
                    <th>Total</th>
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
   

<!-- <div id="userModal" name="userModal" class="modal fade">
	<div class="modal-dialog">
		<div id="modal-body" name="modal-body"> 
		
		</div>
	</div>
</div> -->


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
<div class="modal fade bd-example-modal-xl" id="modalbajas" name="modalbajas"  tabindex="0" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form method="post" enctype="multipart/form-data"  id="formbajas"  name="formbajas" onsubmit="validar_baja();return false">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" onclick="ocultarModalBaja();" class="close" data-dismiss="modal">&times; </button>
			        <h4 class="modal-title text-center" id="myModalLabel">Anular por baja</h4> 
                </div>
                <div class="modal-body">
                    <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-3">
                            <label for="atencion" class="control-label">Observación: </label>
                        </div>
                        <div class="col-md-9">				
                            <input type="text" require name="observacion" id="observacionBajas" onkeyup="mayuscula(this);" class="form-control" data-toggle="tooltip" data-placement="top" title="Código de Barra" />
                        </div>
                        
                    </div>
                </div>
                <div class="upload-msg2 col-md-12"></div>
                <div class="modal-footer">
                    <input type="submit" name="action" id="action22" class="btn btn-success"  value="Enviar" />
						<button type="button" class="btn btn-primary" onclick="ocultarModalBaja()" data-dismiss="modal">Cerrar</button>
                </div>
               
				</div>
            </div>
    </div>
</form>
</div>
<div class="modal fade bd-example-modal-xl" id="modalnotacredito" name="modalnotacredito"  tabindex="0" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form method="post" enctype="multipart/form-data"  id="formmodalnotacredito"  name="formmodalnotacredito" onsubmit="validar_nota_credito();return false">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" onclick="ocultarVentana();" class="close" data-dismiss="modal">&times; </button>
			        <h4 class="modal-title text-center" id="myModalLabel">Anular por nota de credito</h4> 
                </div>
                <div class="modal-body">
                    <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-3">
                            <label for="atencion" class="control-label">Observación: </label>
                        </div>
                        <div class="col-md-9">				
                            <input type="text" require name="observacion" id="observacionnotacredito" onkeyup="mayuscula(this);" class="form-control" data-toggle="tooltip" data-placement="top" title="Código de Barra" />
                        </div>
                        
                    </div>
                </div>
                <div class="upload-msg3 col-md-12"></div>
                <div class="modal-footer">
                    <input type="submit" name="action" id="action3" class="btn btn-success"  value="Enviar" />
						<button type="button" class="btn btn-primary" onclick="ocultarModalNotaCredito()" data-dismiss="modal">Cerrar</button>
                </div>
               
				</div>
            </div>
    </div>
</form>
</div>
