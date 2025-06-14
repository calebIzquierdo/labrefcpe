<?php
global $path;
$path = "/";
function cabecera()
{
    $path;
    $idperfil;
}
// error_reporting(0);
session_start();
// $idperfil = $_SESSION['idperfil'];

if (!isset($_SESSION['id_user'])) {
    header('Location: ' . $path . 'index.php');
} else {
    include("../objetos/class.conexion.php");
    $objconfig = new conexion();
    $usuario = explode("|", $_SESSION['nombre']);

    $idperf = $objconfig->execute_select("select idperfil,idvencimiento, idusuario from usuarios 
                  where idusuario= " . $_SESSION['id_user']);
    $idperfil = $idperf[1]["idperfil"];

    $query = "select men.idpadre_primario, men.descripcion as menuprinc 
              from accesos as a
              inner join modulos as m on(a.idmodulo=m.idmodulo)
              inner join menu as men on(men.idpadre_primario=m.idpadre_primario)
              where a.idperfil=" . $idperfil . " and m.idpadre=0 group by menuprinc, men.idpadre_primario order by menuprinc asc ";

    $row = $objconfig->execute_select($query, 1);

    $canti = "select count(idpadre_primario) from menu ";
    $rowCant = $objconfig->execute_select($canti);
    $count = $rowCant[1]["count"];

    $query2 = "select men.idpadre_primario,m.idpadre, men.descripcion as menuprinc 
              from accesos as a
              inner join modulos as m on(a.idmodulo=m.idmodulo)
              inner join menu as men on(men.idpadre_primario=m.idpadre_primario)
              where  men.estareg=1 and  a.idperfil=" . $idperfil . " and m.idpadre=0 group by menuprinc, men.idpadre_primario,m.idpadre order by menuprinc desc ";

    $row2 = $objconfig->execute_select($query2, 1);

    $vence = $idperf[1]["idvencimiento"];
    $urlvene = $path . "vencimiento/vencimiento.php";

    $proc = $objconfig->execute_select("select ejecut, red,  micro, est from vista_user 
                  where idusuario= " . $_SESSION['id_user']);
    $lug = $proc[1]["red"] . " " . $proc[1]["mic"] . " " . $proc[1]["est"];

    //////////////////////////////////////////////////////////////////////////////////

    $sqlp="SELECT stkm.idstock, stkm.idejecutora, stkm.idred, stkm.idmicrored, tpm.descripcion AS tipomat, mr.descripcion AS marca, md.descripcion AS modelo,
      ud.descripcion AS udm, m.descripcion AS material, stkm.lote, stkm.serie, stkm.cantidad, tpb.descripcion AS tipobien, TO_CHAR (stkm.fvencimiento:: DATE, 'dd/mm/yyyy') as fvencimientoo,(stkm.fvencimiento-current_date) as dvencimiento

      FROM
      stock_material AS stkm
      INNER JOIN materiales AS m ON m.idmaterial = stkm.idmaterial
      INNER JOIN marcas AS mr ON mr.idmarca = stkm.idmarca
      INNER JOIN tipo_bien AS tpb ON tpb.idtipobien = stkm.idtipobien
      INNER JOIN tipo_material AS tpm ON tpm.idtipomaterial = stkm.idtipomaterial
      INNER JOIN modelo AS md ON md.idmodelo = stkm.idmodelo
      INNER JOIN unidad_medida AS ud ON ud.idunidad = stkm.idunidad 
      where ((stkm.fvencimiento-current_date)<20 and (stkm.fvencimiento-current_date)>=0 and stkm.cantidad>0) ORDER BY fvencimiento";

      $rowprodxvenc = $objconfig->execute_select($sqlp, 1);

      //print_r($rowprodxvenc[1]);
      ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>

        <!-- <link rel="icon" type="image/png" href="<?= $path ?>img/logo-acopagro.ico"> 	-->
        <link rel='shortcut icon' type='image/x-icon' href='<?= $path ?>img/favicon.ico'>
        <meta charset="utf-8">
        <meta charset="ISO-8859-1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Trazabilidad, Laboratorio, Referencial">
        <meta name="author" content="root">

        <title>Laboratorio Referencial | Hospital-II-2-Tarapoto</title>
        <link rel="shortcut icon" type="image/png" href="<?= $path ?>img/logo-acopagro.png" sizes="16x16 24x24 36x36 48x48">
        <!-- Bootstrap Core CSS 		-->
        <link href="<?= $path ?>bootstrap/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="<?= $path ?>bootstrap/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

        <!-- DataTables CSS -->
        <link href="<?= $path ?>bootstrap/vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

        <!-- DataTables Responsive CSS -->
        <link href="<?= $path ?>bootstrap/vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="<?= $path ?>bootstrap/dist/css/sb-admin-2.css" rel="stylesheet">

        <!-- Morris Charts CSS 
    <link href="<?= $path ?>bootstrap/vendor/morrisjs/morris.css" rel="stylesheet">
	-->

        <!-- Custom Fonts -->
        <link href="<?= $path ?>bootstrap/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		
    <![endif]-->
        <script>
            function popUp() {
                var venc = $('#idvence').val()
                if (venc == 1) {
                    var ventana = window.open('<?php echo $urlvene; ?>', 'Productor a Vencer', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=980,height=700,left = 990,top = 50');
                    ventana.focus();
                }
            }
        </script>
        <style type="text/css">
            /* Lineas Agregadas */
            .control2 {
                display: block;
                width: 25%;
                height: 34px;
                padding: 6px 12px;
                font-size: 14px;
                line-height: 1.42857143;
                color: #555;
                background-color: #fff;
                background-image: none;
                border: 1px solid #ccc;
                border-radius: 4px;
                -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
                box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
                -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
                -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
                transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            }


            .combox {
                display: block;
                width: 35%;
                height: 34px;
                padding: 6px 12px;
                font-size: 14px;
                line-height: 1.42857143;
                color: #555;
                background-color: #fff;
                background-image: none;
                border: 1px solid #ccc;
                border-radius: 4px;
                -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
                box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
                -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
                -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
                transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            }



            .items {
                display: block;
                width: 10%;
                height: 34px;
                padding: 6px 12px;
                font-size: 14px;
                line-height: 1.42857143;
                color: #555;
                background-color: #fff;
                background-image: none;
                border: 1px solid #ccc;
                border-radius: 4px;
                -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
                box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
                -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
                -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
                transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            }

            fieldset.scheduler-border {
                border: 2px groove #ddd !important;
                padding: 0 1.4em 1.4em 1.4em !important;
                margin: 0 0 1.5em 0 !important;
                -webkit-box-shadow: 0px 0px 0px 0px #000;
                box-shadow: 0px 0px 0px 0px #000;
            }

            legend.scheduler-border {
                width: inherit;
                /* Or auto */
                padding: 0 10px;
                /* To give a bit of padding on the left and right */
                border-bottom: none;
            }

            /*
legend.scheduler-border {
    font-size: 1.2em !important;
    font-weight: bold !important;
    text-align: left !important;

}
*/


            /* Fin de la Lineas Agregadas */
        </style>

    </head>

    <body onload="popUp()">

        <!-- Inicio del Encabezado de Página  -->

        <div>
            <img src="../img/cabecera.png" height="140px" width="100%" class="responsive " />
        </div>
        <!-- Fin del Encabezado de Página  -->
        <input type="hidden" name="idvence" id="idvence" value="<?php echo $vence; ?>" />
        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?= $path ?>include/main.php">LabRef V1.2</a>
                </div>

                <!-- /.navbar-header -->

                <ul class="nav navbar-top-links navbar-right">
                    <li><a href="#"><?php echo $lug; ?></a></li>

                    <li class="dropdown">
                        <!--       <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                             <i class="fa fa-envelope fa-fw"></i>Mails <i class="fa fa-caret-down"></i>
                         </a>
                         <ul class="dropdown-menu dropdown-messages">
                             <li>
                                 <a href="#">
                                     <div>
                                         <strong>John Smith</strong>
                                         <span class="pull-right text-muted">
                                             <em>Yesterday</em>
                                         </span>
                                     </div>
                                     <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                                 </a>
                             </li>
                             <li class="divider"></li>
                             <li>
                                 <a href="#">
                                     <div>
                                         <strong>John Smith</strong>
                                         <span class="pull-right text-muted">
                                             <em>Yesterday</em>
                                         </span>
                                     </div>
                                     <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                                 </a>
                             </li>
                             <li class="divider"></li>
                             <li>
                                 <a href="#">
                                     <div>
                                         <strong>John Smith</strong>
                                         <span class="pull-right text-muted">
                                             <em>Yesterday</em>
                                         </span>
                                     </div>
                                     <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                                 </a>
                             </li>
                             <li class="divider"></li>
                             <li>
                                 <a class="text-center" href="#">
                                     <strong>Read All Messages</strong>
                                     <i class="fa fa-angle-right"></i>
                                 </a>
                             </li>
                         </ul>-->
                        <!-- /.dropdown-messages
                </li> -->
                        <!-- /.dropdown -->
                        <!--       <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i>Avance <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Taréa 1</strong>
                                        <span class="pull-right text-muted">40% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Taréa 2</strong>
                                        <span class="pull-right text-muted">20% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Taréa 3</strong>
                                        <span class="pull-right text-muted">60% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                            <span class="sr-only">60% Complete (warning)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Taréa 4</strong>
                                        <span class="pull-right text-muted">80% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                            <span class="sr-only">80% Complete (danger)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Mostrar Todo </strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    -->
                        <!-- /.dropdown-tasks
                </li>  -->
                        <!-- /.dropdown -->
                        <!--    <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i>Alertas <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> New Comment
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-tasks fa-fw"></i> New Task
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul> -->
                        <!-- /.dropdown-alerts
                </li> -->
                        <!-- /.dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <input type="hidden" name="especie" id="especie" value="<?php echo $respecie[1]["idespecialidad"]; ?>" />
                            <i class="fa fa-user fa-fw"></i> <?php echo $usuario[1]; ?><i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#"><i class="fa fa-user fa-fw"></i> Detalles</a>
                            </li>
                            <li><a href="#"><i class="fa fa-gear fa-fw"></i> Herramientas</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="<?php echo $path; ?>index.php"><i class="fa fa-sign-out fa-fw"></i> Salir</a>
                            </li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
                <!-- /.navbar-top-links -->
                <!-- /input-group -->

                <!--  Insertacion del archivo para la creacion del Menu de navegacion    -->
                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <?php include("menu.php"); ?>
                        </ul>
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>

                <!--  Fin del archivo para la creacion del Menu de navegacion    -->


                <!-- /.navbar-static-side -->
            </nav>
            <!-- Inicio del escritorio donde se muestra el contenido de los Menus -->
            <div id="page-wrapper">
                
<?php 

?>

            <!-- <div class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  ...
                </div>
              </div>
            </div> -->

            <!-- <div class="modal fade bs-example-modal-lg" id="modalprodavencer" tabindex="-1" role="dialog" aria-labelledby="largeModal" > -->
              <div class="modal fade bs-example-modal-lg" id="modalprodavencer" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><center>LISTA DE MATERIALES</center></h4>
                  </div>
                  <div class="modal-body">
                    <!-- <h5></h5> -->
                    <div role="tabpanel">
                        <ul class="nav nav-tabs">
                            <li role="presentation" class="active">
                                <a href="#home" aria-controls="home" role="tab" data-toggle="tab">Próximos a vencer</a>
                            </li>
                        </ul>
                        <br>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="home">
                              <table id="dataTables-example"  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" role="grid" width="100%" >
                                <thead class="thead-inverse">
                                <tr>
                                  <th>Item</th>
                                  <!-- <th>Clasificación</th>
                                  <th>Marca</th>
                                  <th>Modelo</th>
                                  <th>Medida</th> -->
                                  <th><small>Detalle</small></th>
                                  <th><small>Lote</small></th>
                                  <th><small>Serie</small></th>
                                  <th><small>Stock</small></th>
                                  <th><small>F. Vencimiento</small></th>
                                  <th><small>Dias para Caducidad</small></th>
                                  <!-- <th>Editar</th>-->
                                </tr>

                                </thead>
                                <tbody>
                                <?php foreach ($rowprodxvenc[1] as $key => $prod): ?>
                                  <tr>
                                    <td><small><?php echo  $key ?></small></td>
                                    <!-- <td><?php //echo  $prod['tipomat']?></td>
                                    <td><?php //echo  $prod['marca']?></td>
                                    <td><?php //echo  $prod['modelo']?></td>
                                    <td><?php //echo  $prod['udm']?></td> -->
                                    <td><small><?php echo  $prod['material']?></small></td>
                                    <td><small><?php echo  $prod['lote']?></small></td>
                                    <td><small><?php echo  $prod['serie']?></small></td>
                                    <td><small><?php echo  intval($prod['cantidad'])?></small></td>
                                    <td><small><?php echo  $prod['fvencimientoo']?></small></td>
                                    <td class="text-right"><small><?php echo $prod['dvencimiento']?></small></td>
                                  </tr>
                                <?php endforeach ?>  
                                </tbody>
                                
                              </table>
                            </div>
                            <!-- <div role="tabpanel" class="tab-pane" id="profile">cont2...</div>
                            <div role="tabpanel" class="tab-pane" id="messages">cont3...</div> -->
                        </div>
                    </div>
                    <br/>
                    
                  </div>
                  <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                  </div> -->
                </div>
              </div>
            </div>



                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Bienvenidos "<b>LaboratorioReferencial" </b>v2.0 CPE </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row ">
                    <div class="col-lg-12">
                        <section>
                            <!--   <p>Bienvenido a <b>LabRef </b> un Sistema de Registro de Examenes Clinicos y de Labboratorio.</p> -->
                            <h4> Análisis, Desarrollo e Implementación: </h4>
                            <ul>
                                <li>Ing. Sistemas, Ronald Shuña Pérez.</li>
                                <li>C.I.P : 191619.</li>
                                <li>942.670.097</li>
                                <li>ronaldsp2008@gmail.com</li>
                            </ul>
                            <h4> Modulos: </h4>
                            <ul>
                                <li>Regitro Examenes Torch</li>
                                <li>Regitro Urocultivo</li>
                                <li>Regitro Entomológico</li>
                                <li>Reporte Examenes por Tipo.</li>
                                <li>Reporte Examenes por Procedencia.</li>
                                <li>Reporte Exportado a Excel.</li>
                                <li>Buscador avanzado por : Palabra clave, Numero de Documento, Nombre del Paciente, Codigo de Barra, etc.</li>
                            </ul>

                        </section>
                    </div>
                </div>

            </div>

        </div>
        <!-- /#wrapper -->
        <?php
        $ip_user = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        ?>
        <!-- Inicio del Pie de Página  -->
        <div class="panel-footer" align="center">
            <div>
                <p class="link"><span>© Todos los derechos reservados | Desarrollado por<a target="_blank" href=" #"> Soporte Técnico</a> - Hostname: <?php echo $ip_user; ?></span></p>
            </div>
        </div>
        <!-- Fin del pie de Página -->


        <!-- jQuery -->
        <script src="<?= $path ?>bootstrap/vendor/jquery/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="<?= $path ?>bootstrap/vendor/bootstrap/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="<?= $path ?>bootstrap/vendor/metisMenu/metisMenu.min.js"></script>
        <script type="text/javascript">

        $(document).ready(function() {
          $('#dataTables-example').DataTable( {
            "responsive": true,
            // "destroy":true,
            // "processing": true,
            // "serverSide": true,
            //"ajax": "registros.php"
          });
        });
          window.addEventListener('load', function(){
            let validperfil= <?php echo $idperf[1]["idperfil"]; ?>;
            if(validperfil==12){
              fntModalInicial();
                // ftnDelRol();
                // ftnPermisos();
            }
          }, false);

          function fntModalInicial(){
            $('#modalprodavencer').modal('show');
          }
        </script>

        <!-- Morris Charts JavaScript 
    <script src="<?= $path ?>bootstrap/vendor/raphael/raphael.min.js"></script>
    <script src="<?= $path ?>bootstrap/vendor/morrisjs/morris.min.js"></script>
    <script src="<?= $path ?>bootstrap/data/morris-data.js"></script>
	-->

        <!-- High Charts JavaScript 
	
	<script src="<?= $path ?>bootstrap/js/highcharts.js"></script>
	<script src="<?= $path ?>bootstrap/js/exporting.js"></script>
		
	<?= $path ?>bootstrap/highcharts
	<script src="<?= $path ?>bootstrap/highcharts/highcharts.js"></script>
	<script src="<?= $path ?>bootstrap/highcharts/modules/series-label.js"></script>
	<script src="<?= $path ?>bootstrap/highcharts/modules/exporting.js"></script>
	<script src="<?= $path ?>bootstrap/highcharts/modules/export-data.js"></script>
	
	-->
        <script src="<?= $path ?>bootstrap/highcharts/highcharts.js"> </script>
        <script src="<?= $path ?>bootstrap/highcharts/modules/exporting.js"> </script>
        <script src="<?= $path ?>bootstrap/highcharts/modules/offline-exporting.js"> </script>
        <script src="<?= $path ?>bootstrap/highcharts/modules/export-data.js"></script>


        <!-- Script para cargar los index -->
        <script src="<?= $path ?>bootstrap/dist/js/listar.js"></script>

        <!-- DataTables JavaScript -->
        <script src="<?= $path ?>bootstrap/vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="<?= $path ?>bootstrap/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="<?= $path ?>bootstrap/vendor/datatables-responsive/dataTables.responsive.js"></script>
        <script src="<?= $path ?>datatable/Buttons-2.2.2/js/dataTables.buttons.min.js"></script>
        <script src="<?= $path ?>datatable/Buttons-2.2.2/js/buttons.bootstrap.min.js"></script>
        <script src="<?= $path ?>datatable/Buttons-2.2.2/js/buttons.html5.min.js"></script>
        <script src="<?= $path ?>datatable/JSZip-2.5.0/jszip.min.js"></script>
        <script src="<?= $path ?>datatable/pdfmake-0.1.36/pdfmake.min.js"></script>
        <script src="<?= $path ?>datatable/pdfmake-0.1.36/vfs_fonts.js"></script>
        <!-- Custom Theme JavaScript -->
        <script src="<?= $path ?>bootstrap/dist/js/sb-admin-2.js"></script>


        <!--  Scripts - Para Combox -->
        <link rel="stylesheet" href="<?= $path ?>bootstrap/bootstrap-combobox/css/bootstrap-combobox.css" type="text/css">

        <script src="<?= $path ?>bootstrap/bootstrap-combobox/js/bootstrap-combobox.js" type="text/javascript"></script>



        <!-- Page-Level Demo Scripts - Tables - Use for reference -->
        <script>
            /*
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    */
        </script>


    </body>

    </html>
<?php } ?>