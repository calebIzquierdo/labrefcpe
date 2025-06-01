<?php
     include("../../objetos/class.cabecera.php");
	 include("../../objetos/class.conexion.php");
	
	$objconfig = new conexion();
	
	$op 	= $_POST["op"];
	$cod	= $_POST["cod"];
	$disable= "";
	//$readonly="";
	$readonly="readonly=readonly";

	$idusuario = explode("|",$_SESSION['nombre']);
	$iduser = $idusuario[0];

	$esta = "select idred, micro, idmicrored, idejec, ejec, idestablecimiento from user_microred where idusuario=".$iduser;

	$nom_estab = $objconfig->execute_select($esta); //

    $qesp = "select idespecialidad from usuarios where idusuario=".$idusuario[0] ;
    $respecie = $objconfig->execute_select($qesp);//
    $idespe = $respecie[1]["idespecialidad"];
    $idorg_idejec = $nom_estab[1]["idejec"];
    $idorg_red = $nom_estab[1]["idred"];
    $idorg_micro = $nom_estab[1]["idmicrored"];

    $idorg_estable = $nom_estab[1]["idestablecimiento"];

    $nombrepaciente ="";
    $idarea =0;
    $idareatrabajo =0;
	if($cod!=0)
	{
		$query = "select * from vista_requerimiento where idrequerimiento=".$cod;
		$row = $objconfig->execute_select($query);
  
  		$disable= "disabled";
        //DATOS DE FORMULARIO A CARGAR AL MOMENTO DE EDITAR
        $glosa =    $row[1]["glosa"];
        $idarea =   $row[1]["idarea"];
        $area   =   $row[1]["area"];
        $idareatrabajo = $row[1]["idareatrabajo"];
        $subarea = $row[1]["subarea"];
        $fecha =    $row[1]["fecharequerimiento"];
        $idpersonal = $row[1]["idpersonal"];  
        $nompersona = $row[1]["solicitante"]; 
        $observacion = $row[1]["observacion"]; 
         

	}
?>

<meta charset="UTF-8">
<meta http-equiv="content-type" content="text/html; utf-8">
<link rel="stylesheet" media="screen" href="<?=$path?>bootstrap/fecha/css/bootstrap-datetimepicker.min.css" >
<script type="text/javascript" src="<?=$path?>bootstrap/fecha/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?=$path?>bootstrap/fecha/js/locales/bootstrap-datetimepicker.es.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?=$path?>js/tooltip.js" charset="UTF-8"></script>

<script type="text/javascript">

    var count=0;

    $('.form_datetime').datetimepicker({
        // language:  'fr',
        language:  'es',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });
	$('.form_date').datetimepicker({
        language:  'es',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 1
    });
	$('.form_time').datetimepicker({
        language:  'es',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 1,
		minView: 0,
		maxView: 1,
		forceParse: 0
    });

 


    function Estalecimiento(idMicroRed,idEst)
    {
        $.ajax({
            type: "POST",
            url: carpeta+"establecimiento.php",
            data: "idMicroRed="+idMicroRed+"&idEst="+idEst,
            success: function(data) {
                $("#idestablecimiento").html(data)
            }
        });
    }

    function Area(idEst,ar,sar)
    {     

        $("#idareatrabajo").val("");
        AreaTrabajo(ar,sar);
        $.ajax({
            type: "POST",
            url: carpeta+"area.php",
            data: "idEst="+idEst+"&idar="+ar,
            success: function(data) {
                $("#idarea").html(data)         
            }
        });	
    }

    function AreaTrabajo(idArea,idsarea)
    {
        $.ajax({
            type: "POST",
            url: carpeta+"subarea.php",
            data: "idArea="+idArea+"&idsarea="+idsarea,
            success: function(data) {
                $("#idareatrabajo").html(data)
            }
        });
    }

    function Redtestt2(idUnidadEjec)
    {
        $.ajax({
            type: "POST",
            url: carpeta+"red.php",
            data: "idue="+idUnidadEjec+"&idred="+0,
            success: function(data) {
                $("#idred").html(data)
            }
        });
        $("#idred").val("");
        $("#idmicrored").val("");
        MicrooRed("",idUnidadEjec,0);
        $("#idestablecimiento").val("");
        Estalecimiento("",0);
    }

    function Redtestt(idUnidadEjec,idRed){
        //$("#idmicrored").html("");
        
        //$("#idestablecimiento").html($.parseHTML("<option value="">---</option>"));
        $.ajax({
            type: "POST",
            url: carpeta+"red.php",
            data: "idue="+idUnidadEjec+"&idred="+idRed,
            success: function(data) {
                $("#idred").html(data)
            }
        });
    }

    function MicrooRed2(idRed, idUnidadEjec){
        $("#idestablecimiento").val("");
        Estalecimiento("",0);
        $.ajax({
            type: "POST",
            url: carpeta+"microred.php",
            data: "idRed="+idRed+"&idMicroRed="+0+"&idUnidadEjec="+idUnidadEjec,
            success: function(data) {
                //console.log(data);
                $("#idmicrored").html(data)
            }
        });
    }
    function MicrooRed(idRed, idUnidadEjec, idMicroRed){
        /* $("#idestablecimiento").val("");
        Estalecimiento("",0); */
        
        $.ajax({
            type: "POST",
            url: carpeta+"microred.php",
            data: "idRed="+idRed+"&idMicroRed="+idMicroRed+"&idUnidadEjec="+idUnidadEjec,
            success: function(data) {
                //console.log(data);
                $("#idmicrored").html(data)
            }
        });
    }

    function Estalecimiento2(idMicroRed)
    {
        $.ajax({
            type: "POST",
            url: carpeta+"establecimiento.php",
            data: "idMicroRed="+idMicroRed+"&idEst="+0,
            success: function(data) {
                $("#idestablecimiento").html(data)
            }
        });
    }
    function ValidaLongitud(campo, longitudMaxima) 
    {
        try {
            if (campo.value.length > (longitudMaxima - 1))
                return false;
            else
                return true;             
        } catch (e) {
            return false;
        }
    }

    Redtestt(<?php echo $idorg_idejec; ?>,<?php echo $idorg_red; ?>);
    MicrooRed(<?php echo $idorg_red;?>,<?php echo $idorg_idejec; ?>,<?php echo $idorg_micro;?>);
    Estalecimiento(<?php echo $idorg_micro; ?>, <?php echo $idorg_estable; ?>);

</script>


<style>
	@media (min-width: 768px) {
        .container {
            width: 750px;
        }
    }
    @media (min-width: 892px) {
        .modal-lg {
            width: 900px; /* control width here */
            height: auto; /* control height here */
            margin-left: -100px;
            padding-top: 10px;

        }
    }
</style>

<form method="post" enctype="multipart/form-data"  id="user_form"  name="user_form" class="form-horizontal">
    <div class="modal-content modal-lg">
        <div class="modal-header">
            <button type="button" onclick="regresar_index(carpeta);" class="close" data-dismiss="modal">&times; </button>
            <!--	<h3 class="modal-title text-primary" align="center"> <?php echo $nom_estab[1]["ejec"]; ?> </h3> -->
            <h3 class="modal-title text-success" align="center"> ATENDER REQUERIMIENTO N°  
            
                <?php
                    $nrorequerimiento="";
                    if($cod==0){
                        $correlativo=1;
                        $query ="select max(correlativo) as correlativo from requerimiento LIMIT 1;";
                        $correlativos = $objconfig->execute_select($query,1);

                        if(count($correlativos[1])>0){											
                            $correlativo= ((int)$correlativos[1][0]["correlativo"])+1;
                        }
                        $nrorequerimiento = substr(str_repeat(0, 7).$correlativo, - 7);
                        echo $nrorequerimiento ;
                    }else{
                        $nrorequerimiento  = substr(str_repeat(0, 7).$row["1"]["correlativo"], - 7);
                        echo $nrorequerimiento;
                    }
                ?>
            
            </h3>
            <input type="hidden" id="correlativo" name="correlativo" value="<?php echo $nrorequerimiento; ?>" />
            <input type="hidden" id="idrequerimiento" name="idrequerimiento" value="<?=$row[1]["idrequerimiento"]?>" />
        </div>  
                                
        <div class="modal-body">
            <div class="row">  
                <div class="col-md-12">                                  
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Fecha Requerimiento</label>                            
                            <div class="input-group" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2"  data-link-format="yyyy-mm-dd">
                                <input class="form-control" type="text" name="0form_fecharecepcion" id="fecharecepcion" value="<?php echo ($fecha)?$objconfig->FechaDMY2($fecha):date("d/m/Y");?>"  readonly>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>                       
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-md-offset-1">
                        <div class="form-group">
                            <label for="atencion" class="control-label">Establecimiento:  </label>                       
                            <select id="idestablecimiento" name="0form_idestablecimiento" class="form-control" disabled="disabled" >
                                
                            </select>
                        </div>
                    </div>                                              
                </div>                                        
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="atencion" class="control-label">Unidad Trabajo</label>
                            <select id="idarea" name="0form_idarea" class="form-control osSelect" onchange="AreaTrabajo(this.value,<?php echo $idareatrabajo; ?>)" disabled="disabled">           
                            </select>
                        </div>                            
                    </div> 
                    
                    <div class="col-md-6 col-md-offset-1">
                        <div class="form-group">
                            <label for="atencion" class="control-label">Area de Trabajo:  </label>                            
                            <select id="idareatrabajo" name="0form_idareatrabajo" class="form-control" disabled="disabled">                                    
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="atencion" class="control-label">Solicita:  </label>                                
                            <input type="hidden" id="idpersonal" name="idpersonal" value="<?= $idpersonal?>"  />
                            <input for="atencion" type="text" name="nombre_personal" id="nombre_personal" readonly="readonly" value="<?php echo $nompersona;?>" placeholder="Click para Buscar Solicitante" class=" form-control">
                        </div>                            
                    </div>
                    <div class="col-md-6 col-md-offset-1">
                        <div class="form-group">
                            <label for="atencion" class="control-label">Glosa:  </label>                  
                            <textarea for="atencion" id="glosa" name="glosa" class="form-control" rows="2" sentences="true" readonly="readonly"><?php echo $glosa?></textarea> 
                        </div>                                                                              
                    </div>
                </div>
            </div>
            
            <div class="panel panel-primary " style="height:300px;">
                <div class="panel-heading">Materiales</div>
                <div class="panel-body">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div style="height:200px;  overflow-x:hidden;" >
                                <table class="table table-striped table-bordered table-hover table-responsive" id="tbvalidarequ" name="tbvalidarequ" >
                                    <thead>

                                    <tr>
                                        <td>#</td>
                                        <td>Requerido</td>
                                        <td>Aprobado</td>
                                        <td>Stock</td>                                        
                                     <!--   <td>vencimiento</td>
                                        <td>Marca</td> -->
                                        <td>Descripción</td>
                                        <td>Especificaciones</td>                                        
                                        <td align="center"> <span class="glyphicon">&#xe020;</span> </td>                                        
                                        <td></td>                                        
                                        
                                    </tr>

                                    </thead>
                                    <tbody >
                                    <?php
                                        $count_enf=0;
                                      /*
										$sqlF ="select rd.cantidad,coalesce(sm.cantidad,0.000) as stock,coalesce(rd.cant_aprobada,0) as cantaprobada, 
										m.idunidad,sm.idmarca, rd.idmaterial ,m.descripcion as material,m.idvence,
										rd.especificaciones ,coalesce(sm.idmodelo,0)as idmodelo,coalesce(sm.idtipobien,0) as idtipobien,
										coalesce(sm.idtipomaterial,0) as idtipomaterial			
 										from requerimiento_detalle as rd 
										inner join materiales as m on(m.idmaterial=rd.idmaterial) 
										left join stock_material sm on sm.idmaterial=rd.idmaterial 
										where rd.idrequerimiento=".$cod." ";
										*/
										$sqlF =" select  rd.cantidad, coalesce(rd.cant_aprobada,0) as cantaprobada, 
										m.idunidad, rd.idmaterial ,m.descripcion as material,m.idvence,
										rd.especificaciones
										from requerimiento_detalle as rd 
										inner join materiales as m on(m.idmaterial=rd.idmaterial) 
										where rd.idrequerimiento=".$cod." ";
									//	echo  $sqlF;
									
                                        $rowF = $objconfig->execute_select($sqlF,1);
                                        foreach($rowF[1] as $rF)
                                        {
                                            $count_enf++;
											 if ($rF["idvence"]==1){
											 $fvence = $objconfig->execute_select("SELECT fvencimiento FROM ingreso_det WHERE idmaterial=".$rF["idmaterial"]." AND idmodelo=".$rF["idmodelo"]."  GROUP BY fvencimiento") ;
											 $vence = $objconfig->FechaDMY($fvence[1]["fvencimiento"]);
											 $vence1 = $vence;
											 }else{
												 $vence = "0000-00-00";
												 $vence1 = " ";
											 }
											 if ($rF["idmarca"]>=1){
											 $marc = $objconfig->execute_select("SELECT descripcion  as marca,idmarca FROM marcas WHERE idmarca=".$rF["idmarca"]."  ") ;
												$idmarc= $marc[1]["idmarca"];
												$marcs = $marc[1]["marca"];
											 }else {
												$marc = $objconfig->execute_select("SELECT descripcion  as marca,idmarca FROM marcas WHERE idmarca=429 ") ;
												$idmarc= $marc[1]["idmarca"];
												$marcs= $marc[1]["marca"];
											 }
											 $sto = "select  coalesce(sum(cantidad),0) as stock
														from stock_material
														where idmaterial='".$rF["idmaterial"]."' 				 
											 ";
											// echo  $sto;
											 $stk = $objconfig->execute_select($sto);
											 
                                            ?>
                                            <tr id='itemrequerimiento<?php echo $count_enf; ?>' name='itemrequerimiento<?php echo $count_enf; ?>' >
                                                <td >                                                      
                                                   <input type='hidden' name='idmaterial<?php echo $count_enf; ?>' id='idmaterial<?php echo $count_enf; ?>' value='<?php echo $rF["idmaterial"]; ?>' />
                                                   <input type='hidden' name='idunidad<?php echo $count_enf; ?>' id='idunidad<?php echo $count_enf; ?>' value='<?php echo $rF["idunidad"]; ?>' />
                                                   <input type='hidden' name='idmodelo<?php echo $count_enf; ?>' id='idmodelo<?php echo $count_enf; ?>' value='<?php echo $rF["idmodelo"]; ?>' />
                                                   <input type='hidden' name='idtipobien<?php echo $count_enf; ?>' id='idtipobien<?php echo $count_enf; ?>' value='<?php echo $rF["idtipobien"]; ?>' />
                                                   <input type='hidden' name='idtipomaterial<?php echo $count_enf; ?>' id='idtipomaterial<?php echo $count_enf; ?>' value='<?php echo $rF["idtipomaterial"]; ?>' />
                                                    <?php echo $count_enf ; ?>
                                                </td>
                                                <td>
                                                    <input type='hidden' name='cantidad<?php echo $count_enf; ?>' id='cantidad<?php echo $count_enf; ?>' value='<?php echo $rF["cantidad"]; ?>' />
                                                    <?php echo strtoupper($rF["cantidad"] ); ?>                                                       
                                                </td>
                                                <td>
                                                    <input type='text' name='cantidad_a<?php echo $count_enf; ?>' id='cantidad_a<?php echo $count_enf; ?>' onkeyup="validaStock(<?=$count_enf;?>);" class="form-control" value='<?php echo $rF["cantaprobada"]; ?>' />                                                     
                                                </td>
                                                <td>
                                                    <input type='hidden' name='stock<?php echo $count_enf; ?>' id='stock<?php echo $count_enf; ?>' value='<?php echo $stk[1]["stock"]; ?>' />
                                                    <button type="button" class="btn btn-sm" onclick='buscar_stock(<?=$rF["idmaterial"]?>)' <p class="font-weight-bold"><?php echo $stk[1]["stock"];?></p> 
                                                </td>
												<!--
												  <td>
                                                    <input type='hidden' name='fvencimiento<?php echo $count_enf; ?>' id='fvencimiento<?php echo $count_enf; ?>' value='<?php echo $vence; ?>' />
                                                    <?php echo $vence1; ?> 
                                                </td>
												<td>
                                                    <input type='hidden' name='idmarca<?php echo $count_enf; ?>' id='idmarca<?php echo $count_enf; ?>' value='<?php echo $idmarc; ?>' />
                                                    <?php echo $marcs; ?>
                                                </td>
												-->
                                                <td>
                                                    <input type='hidden' name='idmaterial<?php echo $count_enf; ?>' id='idmaterial<?php echo $count_enf; ?>' value='<?php echo $rF["idmaterial"]; ?>' />
                                                    <?php echo $rF["material"]; ?>
                                                </td>
												
                                                <td>
                                                    <input type='hidden' name='especificaciones<?php echo $count_enf; ?>' id='especificaciones<?php echo $count_enf; ?>' value='<?php echo $rF["especificaciones"]; ?>' />
                                                    <?php echo strtoupper($rF["especificaciones"] ); ?>
                                                </td>  
												 <td >
												 <button type="button" class="btn btn-danger btn-sm" onclick='quitar_diagnostico(<?php echo $count_enf; ?>)'> <span class="glyphicon glyphicon-trash"></span>
												</td>
                                                    
                                            </tr>
                                    <?php }?>
                                    </tbody>
                                </table>
                                <input type="hidden" id="contar_detalle_reque" name="contar_detalle_reque" value="<?php echo $count_enf; ?>" />						    
                                <input type="hidden" id="contar_detalle_reque2" name="contar_detalle_reque2" value="<?php echo $count_enf; ?>" />						    
                                <script> 
                                    var  count_enf=<?php echo $count_enf; ?> 
                                    var  count_edit=null;
                                </script>
                            </div>
                        </div>
                    </div>
                </div>                    
            </div>                
        </div>
        <div class="modal-footer"> 
            <div class="col-md-6">
                <div class="form-group">                                          
                    <textarea for="atencion" id="observacion" name="observacion" class="form-control" rows="2" sentences="sentences" placeholder="Observaciones"><?php echo $observacion?></textarea> 
                </div>                                                                              
            </div>              
            <div class="upload-msg col-md-6"></div><!--Para mostrar la respuesta del archivo llamado via ajax -->
                    <input type="hidden" name="op" id="op" value="<?php echo $op; ?>"  />
                    <input type="hidden" name="codigo" id="codigo" value="<?php echo $cod; ?>"  />
                    <input type="hidden" name="0form_idusuario" id="idusuario" value="<?=$idusuario[0]?>"  />	
                    <input type="hidden" name="0form_nombre_usuario" id="nombre_usuario" value="<?=$idusuario[1]?>"  />
                    <input type="button" onclick="validar_form();" name="action" id="action" class="btn btn-success"  value="Guardar" />
                    <button type="button" onclick="regresar_index(carpeta);" class="btn btn-default" data-dismiss="modal" data-backdrop="false" > Cerrar </button>                                         
            </div>     
        </div>
    </div>
</form>

<script type="text/javascript">
	Redtestt(<?php echo $idorg_idejec; ?>,<?php echo $idorg_red; ?>);
	MicrooRed(<?php echo $idorg_red;?>,<?php echo $idorg_idejec; ?>,<?php echo $idorg_micro;?>);
    Estalecimiento(<?php echo $idorg_micro; ?>, <?php echo $idorg_estable; ?>);
	Area(<?php echo $idorg_estable; ?>,<?php echo $idarea; ?>,<?php echo $idareatrabajo; ?>);
    

    //<![CDATA[
    $(document).ready(function(){
        $('.combobox').combobox()
    });
    //]]>

    $('#myTab a').on('click', function (e) {
        e.preventDefault()
        $(this).tab('show')
    })
	
	// Para usar un tooltip sin especificar tag en especial
	$(function () {
	    $('[data-toggle="tooltip"]').tooltip()
	})
	
</script>