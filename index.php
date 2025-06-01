<?php
	error_reporting(0);
	// phpinfo();
	error_reporting(E_ALL);
	session_start(); 
	$path = "http://".$_SERVER['HTTP_HOST']."/labrefcpe/";
		
	global $n; $idespe;
	if(!isset($_GET['key'])) { $n=rand(1000,9999); } else { $n = base64_decode($_GET['key']); }
	
	
?>

<script type="text/javascript" language="javascript">
 
	$("#results").hide();
		codvali = 0;
		function valdiar_form()
		{
                    
		//	var opciones="toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=650px,height=775px,top=85,left=140";
		//	var namepage="Registro de Precios del día"
			var user=$("#usu").val()
			var pass=$("#pass").val()
			
			if(user=="")
			{
				//$("#results").html("<div class='alert alert-danger alert-dismissible text-center' >Ingrese Usuario</div>")
				$("#usu").focus()
				return
			}
			if(pass=="")
			{
				//$("#results").html("<div class='alert alert-danger alert-dismissible text-center' >Ingrese Contraseña</div>")
				$("#pass").focus()
				return
			} 
			if($("#codvali").val()!=<?=$n?>)
			{
			$("#results").html("<div class='alert alert-danger alert-dismissible text-center' >Codigo Incorrecto</div>")
			$("#codvali").focus();
			return false;
			}
			var parametros = {
				"user" : user,
				"pass" : pass
			};
			
			$.ajax({
	                data:  parametros,
	                url:   'objetos/class.validar_usuario.php',
	                type:  'post',
	                success:  function (response) {                            
						if(response!=1)
						{  
							console.log(response);
							$("#results").html("<div class='alert alert-danger alert-dismissible text-center' >Error de Usuario y/o Contraseña</div>"); 
						}else{
						  location.href="include/main.php";
							
							
						}
	                }
	
	        });
		}
		
	</script>
<style>

body{
        background-image: url('img/fondo2.png') ;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
      /*  height:100%;*/

    }

/*
.results {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
  /*  background: url('../img/avance.gif') 50% 50% no-repeat rgb(249,249,249); 
    background: 50% 50% no-repeat rgb(249,249,249);
    opacity: .8;
    }
    */

/*
body
{
    background: url(https://www.google.hu/images/srpr/logo4w.png);
    background-size: cover;
}
*/
</style>

<!DOCTYPE html>

<html>

  <head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title> .:: Laboratorio Referencias de San Martin | Iniciar Sessión ::.</title>

    <!-- Tell the browser to be responsive to screen width -->

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Bootstrap 3.3.5 -->

    <link rel="stylesheet" href="<?=$path?>bootstrap/app/bootstrap/css/bootstrap.min.css">

    <!-- Font Awesome -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

  
    <!-- Theme style -->

    <link rel="stylesheet" href="<?=$path?>bootstrap/app/dist/css/AdminLTE.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!-- 
	<body class="hold-transition login-page"> 
	-->

  </head>

  <body  >

    <div class="login-box">
<!--
      <div class="login-logo">

        <a href="#">Laboratorio<b>Referencial</b> SanMartin</a>

      </div><!-- /.login-logo -->

      <div class="login-box-body">
	
        <h3 class="login-box-msg ">INICIAR SESIÓN</h3> 
        <form id="loginform" name="loginform" >     

            <div class="form-group has-feedback">
              <input type="text" class="form-control" style="text-transform: uppercase;"  placeholder="Usuario" name="usu" id="usu" required>
              <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback">
              <input type="password" class="form-control" style="text-transform: uppercase;"  placeholder="Contraseña" name="pass" id="pass" required>
              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
        
            <div class="form-group has-feedback">
                <label for="password" accesskey="v">&nbsp; Ingrese Código: <?=$n;?></label>
                <input type="text" class="form-control" placeholder="Validar Codigo Validación" name="codvali" id="codvali" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>          
            <div class="row">
              <div>
                    <button id="conectar" type="submit" onclick="valdiar_form();" class="btn btn-success btn-lg btn-block btn-flat">Acceder</button>
                    <button type="button" class="btn btn-primary btn-sm btn-block btn-flat" data-toggle="modal" data-target="#exampleModalCenter">Descarga de formatos</button>
              </div>
            </div>
          
          </form>
     
		
        <div id="results">
		
        </div>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">LISTADO DE FORMATOS</h5>            
             
          </div>
          <div class="modal-body">
            <div id="accordion">
              <div class="card">
                <div class="card-header" id="headingOne">
                  <h5 class="mb-0">
                    <button class="btn btn-primary btn-block collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseTwo">
                      Formatos y Solicitudes
                    </button>
                  </h5>
                </div>
                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                  <div class="card-body">
                    <div class="list-group">
                      <a href="<?=$path?>formatos/redes/Ficha_HPV2019.pdf" target="_blank" class="list-group-item list-group-item-action">Ficha de Registro de PAP</a>
                      <a href="<?=$path?>formatos/redes/Ficha_PSA.pdf" target="_blank" class="list-group-item list-group-item-action">Ficha de Registro de PSA</a>
                      <a href="<?=$path?>formatos/redes/Ficha_PAP2019.pdf" target="_blank" class="list-group-item list-group-item-action">Ficha de Registro de Muestras para Determinacion de Hormonas y/o Marcadores Tumorales</a>
                      <a href="<?=$path?>formatos/redes/Torch.pdf" target="_blank" class="list-group-item list-group-item-action">Ficha de Registro de Torch</a>
                      <a href="<?=$path?>formatos/redes/ficha_hormonas.pdf" target="_blank" class="list-group-item list-group-item-action">Ficha de Registro de Captura Hibrida - HPV</a>
                      <a href="#" class="list-group-item list-group-item-action">Formulario de Solicitud de Creacion de Usuarios</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header" id="headingTwo">
                  <h5 class="mb-0">
                    <button class="btn btn-primary btn-block collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      Formatos Control de Calidad
                    </button>
                  </h5>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                  <div class="card-body">
                    <div class="list-group">
                      <a href="<?=$path?>formatos/controlcalidad/070.pdf" class="list-group-item list-group-item-action" target="_blank">070 CONTROL DE PREPARACIÓN DE AGUA ÁCIDA Y AMONIACAL PARA COLORACION  EN CITOPATOLOGÍA</a>
                      <a href="<?=$path?>formatos/controlcalidad/071.pdf" class="list-group-item list-group-item-action" target="_blank">071 CONTROL DE USO DE SUSTANCIAS CONTROLADAS ( Xilol –Alcohol Absoluto) EN CITOPATOLOGÍA</a>
                      <a href="<?=$path?>formatos/controlcalidad/072.pdf" class="list-group-item list-group-item-action" target="_blank">072 CONTROL DEL USO DE COLORANTES  EN CITOPATOLOGÍA</a>
                      <a href="<?=$path?>formatos/controlcalidad/073.pdf" class="list-group-item list-group-item-action" target="_blank">073 RECIPIENTES PREFERIDOS PARA LA CRIA DE Aedes aegypti</a>
                      <a href="<?=$path?>formatos/controlcalidad/074.pdf" class="list-group-item list-group-item-action" target="_blank">074 IDENTIFICACIÓN TAXONÓMICA DE LARVAS DE ANOPHELES</a>
                      <a href="<?=$path?>formatos/controlcalidad/075.pdf" class="list-group-item list-group-item-action" target="_blank">075 REPORTE DE INDICE AEDICO  REGIONAL Y NACIONAL</a>
                      <a href="<?=$path?>formatos/controlcalidad/076.pdf" class="list-group-item list-group-item-action" target="_blank">076 LECTURA DE MUESTRAS DE Aedes aegypti</a>
                      <a href="<?=$path?>formatos/controlcalidad/077.pdf" class="list-group-item list-group-item-action" target="_blank">077 RESIDUOSA GENERADOS EN LABORATORIO REFERENCIAL REGIONAL</a>
                      <a href="<?=$path?>formatos/controlcalidad/078.pdf" class="list-group-item list-group-item-action" target="_blank">078 RECEPCION DE MUESTRA PARA MONITOREO DE PVVIH SIDA</a>
                      <a href="<?=$path?>formatos/controlcalidad/079.pdf" class="list-group-item list-group-item-action" target="_blank">079 PROTOCOLO PARA PRUEBAS INMUNOENZIMATICAS (ELISA)</a>
                      <a href="<?=$path?>formatos/controlcalidad/080.pdf" class="list-group-item list-group-item-action" target="_blank">080 REGISTRO DE CAJAS PORTAVIALES</a>
                      <a href="<?=$path?>formatos/controlcalidad/081.pdf" class="list-group-item list-group-item-action" target="_blank">081 REGISTRO DE REUNIONES</a>
                      <a href="<?=$path?>formatos/controlcalidad/082.pdf" class="list-group-item list-group-item-action" target="_blank">082 CONSOLIDADO CC BK</a>
                      <a href="<?=$path?>formatos/controlcalidad/083.pdf" class="list-group-item list-group-item-action" target="_blank">083 CONSTANCIA DE PERMANENCIA DEL PERSONAL</a>
                      <a href="<?=$path?>formatos/controlcalidad/084.pdf" class="list-group-item list-group-item-action" target="_blank">084 PROGRAMA EVALUACIÓN INTERLABORATORIOS DX PARÁSITOS INTESTINALES</a>
                      <a href="<?=$path?>formatos/controlcalidad/085.pdf" class="list-group-item list-group-item-action" target="_blank">085 EVALUACION DE RELUCTURA DOBLE CIEGO  BK</a>
                      <a href="<?=$path?>formatos/controlcalidad/086.pdf" class="list-group-item list-group-item-action" target="_blank">086 CONTROL DE CALIDAD INTERNO DE PATRONES DE REFERENCIA</a>
                      <a href="<?=$path?>formatos/controlcalidad/087.pdf" class="list-group-item list-group-item-action" target="_blank">087 CONTROL DE CALIDAD DE BACILOSCOPÍA</a>
                      <a href="<?=$path?>formatos/controlcalidad/088.pdf" class="list-group-item list-group-item-action" target="_blank">088 INFORME COMPLEMENTARIO DE LABORATORIOS LOCALES</a>
                      <a href="<?=$path?>formatos/controlcalidad/089.pdf" class="list-group-item list-group-item-action" target="_blank">089 INFORME DE CONTROL DE CALIDAD TÉCNICA DE BACILOSCOPÍA</a>
                      <a href="<?=$path?>formatos/controlcalidad/090.pdf" class="list-group-item list-group-item-action" target="_blank">090 RESULTADOS DE RELECTURA DE DOBLE CIEGO DE BK</a>
                      <a href="<?=$path?>formatos/controlcalidad/091.pdf" class="list-group-item list-group-item-action" target="_blank">091 CALIDAD TÉCNICA DE GOTA GRUESA Y FROTIS DE LAMINAS ENVIADAS</a>
                      <a href="<?=$path?>formatos/controlcalidad/092.pdf" class="list-group-item list-group-item-action" target="_blank">092 FICHA EPIDEMIOLÓGICA DE LEISHMANIA</a>
                      <a href="<?=$path?>formatos/controlcalidad/093.pdf" class="list-group-item list-group-item-action" target="_blank">093  LÁMINAS ENVIADAS PARA CC DEL DX MICROSCOPICO DE LEISHMANIA</a>
                      <a href="<?=$path?>formatos/controlcalidad/094.pdf" class="list-group-item list-group-item-action" target="_blank">094 SOLICITUD PARA INVESTIGACIÓN DE LEISHMANIASIS POR PARATSITOLOGÍA</a>
                      <a href="<?=$path?>formatos/controlcalidad/095.pdf" class="list-group-item list-group-item-action" target="_blank">095 SOLICITUD PARA INVESTIGACIÓN DE MALARIA POR GOTA GRUESA</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header" id="headingThree">
                  <h5 class="mb-0">
                    <button class="btn btn-primary btn-block collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                      Formatos administrativos
                    </button>
                  </h5>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                  <div class="card-body">
                    <div class="list-group">
                      <a href="<?=$path?>formatos/administrativos/01.pdf" class="list-group-item list-group-item-action" target="_blank">Papeleta de Salida en Horario Normal de trabajo</a>
                      <a href="<?=$path?>formatos/administrativos/02.pdf" class="list-group-item list-group-item-action" target="_blank">Control Asistencia Capacitación</a>
                      <a href="<?=$path?>formatos/administrativos/03.pdf" class="list-group-item list-group-item-action" target="_blank">Control refrigerios</a>
                      <a href="<?=$path?>formatos/administrativos/04.pdf" class="list-group-item list-group-item-action" target="_blank">Formato de Ingreso del personcal locador</a>
                      <a href="<?=$path?>formatos/administrativos/05.pdf" class="list-group-item list-group-item-action" target="_blank">Papeleta de horas extras</a>
                      <a href="<?=$path?>formatos/administrativos/06.pdf" class="list-group-item list-group-item-action" target="_blank">Solicitud de Licencia</a>                                            
                    </div>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header" id="headingFour">
                  <h5 class="mb-0">
                    <button class="btn btn-primary btn-block collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                      Formatos de Control Petrimonial
                    </button>
                  </h5>
                </div>
                <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                  <div class="card-body">
                    <div class="list-group">
                      <a href="<?=$path?>formatos/patrimonio/01.pdf" class="list-group-item list-group-item-action" target="_blank">Acta de Control de bienes particulares</a>
                      <a href="<?=$path?>formatos/patrimonio/02.pdf" class="list-group-item list-group-item-action" target="_blank">Acta de Control de movimiento interno de bienes</a>
                      <a href="<?=$path?>formatos/patrimonio/03.pdf" class="list-group-item list-group-item-action" target="_blank">Acta de Control de salida de bienes</a>
                     
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>            
          </div>
        </div>
      </div>
    </div>
    <!-- jQuery 2.1.4 -->
    <script src="<?=$path?>bootstrap/app/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?=$path?>bootstrap/app/bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->

<script type="text/javascript">
$(function(){
  $('#loginform').submit(function(e){
    return false;
  });
});
</script>  
</body>
</html>

