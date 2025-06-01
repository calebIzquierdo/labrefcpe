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

 function Redtestt2(idUnidadEjec){
	
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
 
 function ValidaLongitud(campo, longitudMaxima) {
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
	/* 
	table, th, td {
        border: 0px solid black;
        font-family: "Times New Roman", serif;
        font-size: 11px;
    }
	*/
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
				<h3 class="modal-title text-success" align="center"> REQUERIMIENTO N°  
                
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
                <input type="hidden" id="correlativo" name="0form_correlativo" value="<?php echo $nrorequerimiento; ?>" />
                <input type="hidden" id="idrequerimiento" name="1form_idrequerimiento" value="<?=$row[1]["idrequerimiento"]?>" />
            </div>  
                                 
			<div class="modal-body">
                <div class="row">  
                    <div class="col-md-12">                                  
                        <div class="col-md-3">
						
    <!-- $idorg_estable = $nom_estab[1]["idestablecimiento"]; -->
						<input type='hidden' name="0form_idejecutora" id='idejecutora' value='<?php echo $idorg_idejec; ?>' />
						<input type='hidden' name="0form_idred" id='idred' value='<?php echo $idorg_red; ?>' />
						<input type='hidden' name="0form_idmicrored" id='idmicrored' value='<?php echo $idorg_micro; ?>' />
                            <div class="form-group">
                                <label class="control-label">Fecha Requerimiento</label>                            
                                <div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2"  data-link-format="yyyy-mm-dd">
                                    <input class="form-control" type="text" name="0form_fecharequerimiento" id="fecharequerimiento" value="<?php echo ($fecha)?$objconfig->FechaDMY2($fecha):date("d/m/Y");?>"  readonly>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>                       
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 col-md-offset-1">
                            <div class="form-group">
                                <label for="atencion" class="control-label">Establecimiento:  </label>                       
                                <select id="idestablecimiento" name="0form_idestablecimiento" class="form-control"  >
                                    
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
                                <select id="idarea" name="0form_idarea" class="form-control osSelect" onchange="AreaTrabajo(this.value,<?php echo $idareatrabajo; ?>)" >           
                                </select>
                            </div>                            
                        </div> 
                        
                        <div class="col-md-6 col-md-offset-1">
                            <div class="form-group">
                                <label for="atencion" class="control-label">Area de Trabajo:  </label>                            
                                <select id="idareatrabajo" name="0form_idareatrabajo" class="form-control">                                    
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
                                <input type="hidden" id="idpersonal" name="0form_idpersonal" value="<?= $idpersonal?>"  />
                                <input for="atencion" type="text" name="nombre_personal" id="nombre_personal"  readonly="readonly" onclick="buscar_personal();" value="<?php echo $nompersona;?>" placeholder="Click para Buscar Solicitante" class=" form-control">
                            </div>                            
                        </div>
                        <div class="col-md-6 col-md-offset-1">
                            <div class="form-group">
                                <label for="atencion" class="control-label">Glosa:  </label>                  
                                <textarea for="atencion" id="glosa" name="0form_glosa" class="form-control" onkeyup="mayuscula(this);" rows="2" sentences="true"><?php echo $glosa?></textarea> 
                            </div>                                                                              
                        </div>
                    </div>
                </div>
                
                <div class="panel panel-primary " style="height:400px;">
                    <div class="panel-heading">Materiales</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="atencion" class="control-label">Tipo Material:  </label>                           
                                        <input type="hidden" id="unid" name="unid" value=""  />                                        
                                        <input type="hidden" id="material" name="material" value=""  />
                                        <input for="atencion" type="text" name="nombre_material" id="nombre_material"  readonly="readonly" onclick="buscar_material();" value="" placeholder="Click para Buscar Materiales" class=" form-control" />
                                    </div>                                                   
                                </div>
                                <div class="col-md-3 col-md-offset-1">
                                    <div class="form-group">
                                        <label for="atencion" class="control-label">Cantidad:</label> 
                                        <div class="input-group"> 
                                            <input type="text" name="cantidad" id="cantidad" onKeyPress="solonumeros(event)"  class="form-control" value=""   placeholder="Cantidad" data-toggle="tooltip" data-placement="top" title="Cantidad" />
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary" type="button" onclick="agregar_antigrama();" name="action" id="action">Agregar</button>
                                            </span>
                                        </div>   
                                    </div>                                    
                                </div>
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-md-12">        
								<textarea name="especificaciones" id="especificaciones" class="form-control" placeholder="Especificaciones Técnicas" data-toggle="tooltip" data-placement="top" title="Especificaciones Técnicas" onkeyup="mayuscula(this);" rows="3" cols="120"></textarea>							
                                <!-- <input type="text" name="especificaciones" id="especificaciones" class="form-control" value="" placeholder="Especificaciones" data-toggle="tooltip" data-placement="top" title="Especificaciones" />  -->                          
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div style="height:250px;  overflow-x:hidden;" >
                                    <table class="table table-striped table-bordered table-hover table-responsive" id="tbdiagnostico" name="tbdiagnostico" >
                                        <thead>

                                        <tr>
                                            <td>#</td>
                                            <td>Cantidad</td>                                        
                                            <td>Descripción</td>
                                            <td>Especificaciones</td>                                        
                                            <td>Acción</td>
                                        </tr>

                                        </thead>
                                        <tbody id="detalleRequerimiento">
                                        <?php
                                            $count_enf=0;
                                            $sqlF = "select  rd.cantidad, rd.idmaterial ,m.descripcion as material,rd.especificaciones
                                            from requerimiento_detalle as rd
                                            inner join materiales as m on(m.idmaterial=rd.idmaterial)
                                            where rd.idrequerimiento=".$cod." ";
                                            $rowF = $objconfig->execute_select($sqlF,1);
                                            foreach($rowF[1] as $rF)
                                            {
                                                $count_enf++;

                                                ?>
                                                <tr id='itemrequerimiento<?php echo $count_enf; ?>' name='itemrequerimiento<?php echo $count_enf; ?>' >
                                                    <td > 
                                                        <p style="display:none" id="cantidad<?php echo $count_enf; ?>"><?php echo $rF["cantidad"]; ?></p>
                                                        <p style="display:none" id="material<?php echo $count_enf; ?>"><?php echo strtoupper($rF["material"] ); ?></p>
                                                        <p style="display:none" id="especificaciones<?php echo $count_enf; ?>"><?php echo strtoupper($rF["especificaciones"] ); ?></p>                                                       
                                                        
                                                        <input type='hidden' name='idmaterial<?php echo $count_enf; ?>' id='idmaterial<?php echo $count_enf; ?>' value='<?php echo $rF["idmaterial"]; ?>' />

                                                        <?php echo $count_enf ; ?>
                                                    </td>
                                                    <td>
                                                        <input type='hidden' name='cantidad<?php echo $count_enf; ?>' id='cantidad<?php echo $count_enf; ?>' value='<?php echo $rF["cantidad"]; ?>' />
                                                        <?php echo strtoupper($rF["cantidad"] ); ?>                                                       
                                                    </td>
                                                    <td>

                                                        <input type='hidden' name='idmaterial<?php echo $count_enf; ?>' id='idmaterial<?php echo $count_enf; ?>' value='<?php echo $rF["idmaterial"]; ?>' />
                                                        <?php echo $rF["material"]; ?>
                                                    </td>
                                                    <td>
                                                        <input type='hidden' name='especificaciones<?php echo $count_enf; ?>' id='especificaciones<?php echo $count_enf; ?>' value='<?php echo $rF["especificaciones"]; ?>' />
                                                        <?php echo strtoupper($rF["especificaciones"] ); ?>
                                                    </td>                                               
                                                     <td >
                                                    
                                                        <img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_diagnostico(<?php echo $count_enf; ?>)' title='Borrar Registro' />
                                                    
                                                    </td>
                                                </tr>
							            <?php }?>
                                        </tbody>
                                    </table>
                                    <input type="hidden" id="contar_detalle_reque" name="contar_detalle_reque" value="<?php echo $count_enf; ?>" />						    
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
                <div class="upload-msg col-md-12"></div><!--Para mostrar la respuesta del archivo llamado via ajax -->
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