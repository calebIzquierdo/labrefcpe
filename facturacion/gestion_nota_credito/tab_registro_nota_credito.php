<?php
    include("../../objetos/class.cabecera.php");	
    include("../../objetos/class.conexion.php");
    $objconfig = new conexion();
?>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Registrar nota de credito</h1>
		<div class="row">
            <div class="col-lg-7">
                <h3>Datos Comprobante</h3>
            </div>
            <div class="col-lg-1">
                <label for="">Tipo:</label>
            </div>
            <div class="col-lg-4">
                <select class="form-control" id="">
                    <option value="" disabled></option>
                    <?php
                        $sql="select codigo, descripcioncompleta from tipodiscrepancias where estado=1 and Codigo='01' and idtipocomprobante='07' order by DescripcionCompleta desc;";
                        $ress=$objconfig->execute_select($sql,1) ;
                        foreach($ress[1] as $tipoDisc){
                            echo '<option value="'.$tipoDisc['codigo'].'" '.(($tipoDisc['codigo']=="01")?"selected":"").'>'.$tipoDisc['descripcioncompleta'].'</option>';
                        }
                    ?>
                </select>
               
            </div>
        </div>
		
	</div>
	
	<!-- /.col-lg-12 -->
</div>
<div class="row" style="margin-top:1.5rem; display:flex; justify-content:space-between">
    <form method="POST" id="registrar_nota" onsubmit="registrar_nota(); return false">
    
    <div class="col-lg-7">
        <div class="row">
           
            <div class="col-lg-3">
                <label for="">Comprobante</label>
                <input class="form-control" type="text" id="tipo_comprobante" placeholder="- - - - " readonly/>
            </div>
            <div class="col-lg-3">
                <label for="">Documento:</label>
                <input class="form-control" type="text" id="comprobante" placeholder="0000-000000" readonly/>
            </div>
            <div class="col-lg-3">
                <label for="">Fecha Emision:</label>
                <input class="form-control" type="date" id="fecha_emision" readonly/>
            </div>
            <div class="col-lg-3">
                <label for="">RUC/DNI:</label>
                <input class="form-control" type="text" id="ruc_cliente" placeholder="0000000" readonly/>
            </div>
        </div>
        <div class="row" style="margin-top:1.5rem">
            <div class="col-lg-2">
                <label for="">Cliente:</label>    
            </div>
            <div class="col-lg-10">
                <input class="form-control" id="cliente" type="text" readonly/>
                <!-- <select id="idclientes" class="form-control">
                    <option value="" disabled selected></option>;
                    <?php
                        /* $sql="select idcliente, razonsocial, direccion from cliente where estareg=1;";
                        $res=$objconfig->execute_select($sql,1) ;
                        foreach($res[1] as $pago){
                            echo '<option value="'.$pago['idcliente'].'" direc="'.$pago['direccion'].'">'.$pago['razonsocial'].'</option>';
                        } */
                    ?>
                </select> -->
            </div>
        </div>
        <div class="row" style="margin-top:1.5rem">
            <div class="col-lg-2">
                <label for="">Dirección:</label>    
            </div>
            <div class="col-lg-10">
                <input class="form-control" type="text" id="direccion_cliente" placeholder="" readonly/>
                <input style="display:none" type="text" name="comprobante_select" id="comprobante_select" readonly value="0"/>
            </div>
        </div>
    </div>
    <div class="col-lg-4" style="border-color: #343a40; border: 1px solid #000; margin: 2rem 2rem;padding: 1rem .5rem; border-radius: 0.5rem;">
        
        <label class="my-2" style="margin-top:.3rem">Observación:</label>
        <div class="row" style="display:flex; align-items:center">
            <div class="col-lg-8" >
                <div class="row" style="padding: .2rem 1.3rem">
                    <textarea class="form-control" name="observacion" rows="4" cols="50" required></textarea>
                </div>
                
            </div>
            <div class="col-lg-4">
                <div class="row">
                    <button type="button" class="btn btn-primary" data-toggle='modal' data-backdrop='static' data-keyboard='false' data-target='#modalcomprobante'>Buscar<br/>Comprobante</Button>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12" style="display: flex; justify-content:end">
                <button type="submit" class="btn btn-success" >GENERAR</Button>
            </div>
        </div>
    </div>
    </form>
</div>
<div class="row">
	<div class="col-lg-12">

                        <!-- /.panel-heading -->
		<br/>
		<table id="dataTables-example"  class="table table-striped table-bordered table-hover" width="100%">
			<thead class="thead-inverse">
                <tr>
                    <th> # </th><!--Estado-->
                    <th>Descripcion</th>
                    <th>U.M</th>
                    <th>Cantidad</th>
                    <th>Prec. Unitario</th>
                    <th>Descuento</th>
                    <th>Igv</th>
                    <th>S. Total</th>
                </tr>
			</thead>
			
		</table> 
    </div>
</div>
<div class="row">
    <div class="col-lg-2">
        <label for="">Importe Bruto:</label>
        <input class="form-control" id="imp_bruto" type="number" placeholder="0.00" value="0" readonly/>
    </div>
    <div class="col-lg-2">
        <label for="">Descuento:</label>
        <input class="form-control" id="id_desc" type="number" placeholder="0.00" value="0" readonly/>
    </div>
    <div class="col-lg-2">
        <label for="">Sub Total:</label>
        <input class="form-control" id="imp_bruto1" type="number" placeholder="0.00" value="0" readonly/>
    </div>
    <div class="col-lg-2">
        <label for="">Importe Total</label>
        <input class="form-control" id="imp_bruto2" type="number" placeholder="0.00" value="0" readonly/>
    </div>
</div>

<div class="modal fade bd-example-modal-xl" id="modalcomprobante" name="modalcomprobante"  tabindex="0" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form method="post" enctype="multipart/form-data"  id="formmodalnotacredito"  name="formmodalnotacredito" onsubmit="validar_nota_credito();return false">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button"  class="close" data-dismiss="modal">&times; </button>
			        <h4 class="modal-title text-center" id="myModalLabel">Buscar comprobante</h4> 
                </div>
                <div class="modal-body">
                    <div class="row">
                    <div class="col-md-12">
                        
                        <div class="col-md-12" style="display:flex;justify-content:center; margin:0 0 2rem 0;">				
                            <select class="form-control" name="" id="comprobantes" style="width: 80%">
                                    <option value="" disabled selected></option>

                                    <?php
                                        $sql="select P.nrodocumento, P.idpago, TC.descripcion, P.fecharecepcion, C.ruc, C.razonsocial, C.direccion from pago P inner join tipo_comprobante TC on (P.idtipopago=TC.idcomprobante) inner join cliente C on (P.idcliente=C.idcliente) where P.estareg=1 order by P.fechareg desc;";
                                        $res=$objconfig->execute_select($sql,1) ;
                                        foreach($res[1] as $pago){
                                            echo '<option value="'.$pago['idpago'].'" nrodoc="'.$pago['nrodocumento'].'" tpcomprobante="'.$pago['descripcion'].'" fecha="'.$pago['fecharecepcion'].'" ruc="'.$pago['ruc'].'" rz="'.$pago['razonsocial'].'" direccion="'.$pago['direccion'].'">'.$pago['nrodocumento'].'</option>';
                                        }
                                    ?>
                            </select>    
                        </div>
                        
                    </div>
                </div>
                <div class="upload-msg3 col-md-12"></div>
				</div>
            </div>
    </div>
</form>
</div>
<script src="../facturacion/gestion_nota_credito/tab_registro_nota_credito.js"></script>