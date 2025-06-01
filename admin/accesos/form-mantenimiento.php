<?php
    include("../../objetos/class.conexion.php");
	
    $objconfig = new conexion();
	
    $op     = $_POST["op"];
    $cod    = $_POST["cod"];
	
    if($cod!=0)
    {
	$query = "select * from perfiles where idperfil=".$cod;
	$row = $objconfig->execute_select($query);
    }
?>

<form method="post" enctype="multipart/form-data"  id="user_form"  name="user_form">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times; </button>
                <h4 class="modal-title">Mantimiento de Accesos</h4>
                <input type="hidden" name="op" id="op" value="<?php echo $op; ?>"  />
            </div>
            <div class="modal-body">
                <label>Item</label>
                <input type="text" name="1form_idperfil" id="codigo" value="<?=$row[1]["idperfil"]?>"  readonly class="form-control"    />
                <br />
                <label>Descripcion</label>
                <input type="text" name="0form_descripcion" id="descripcion" value="<?=$row[1]["descripcion"]?>" readonly class="form-control"    />
                 <input type="hidden" name="idmodulos" id="idmodulos" value=""  readonly="readonly" />
                <h4 align="center" >.:: Opciones Asignadas al Perfil ::. </h4>
                    <div class="col-md-12">
                       <div class="col-md-3">
                            <button type='button' onclick='buscar_modulos()' style="cursor: pointer;" class='btn-success btn-xs'>Buscar Modulo</button>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="modulos" id="modulos" onclick='buscar_modulos()' value="" class="form-control" readonly="readonly" />
                        </div>
                    </div>


                <br />
                <br />
                <div class="col-md-12">
                <div style="height:180px ; overflow: auto">
                <table width="100%" border="2" class="table table-striped table-bordered table-hover" id="tbmodulos">
                    <tr align="center" >
                       <td >Item</td>
                       <td >Modulo</td>
                        <td >&nbsp;</td>
                    </tr>
                    <?php
                        $count=0;
                        if($cod!=0)
                        {
                            
                            $queryB = "select a.idmodulo,m.descripcion
                                      from accesos as a
                                      inner join modulos as m on(a.idmodulo=m.idmodulo)
                                      where a.idperfil=".$cod." order by  a.idmodulo asc";
                            $rowB = $objconfig->execute_select($queryB,1);
                            
                            foreach($rowB[1] as $r)
                            {
                                $count++;
                         ?>
            			 <tr id='itemM<?php echo $count; ?>' >
            			   <td><input type='hidden' name='idmodulo<?php echo $count; ?>' id='idmodulo<?php echo $count; ?>' value='<?php echo $r["idmodulo"]; ?>' /><?php echo $r["idmodulo"]; ?>
            			   <td>
            			   <input type='hidden' name='modulo<?php echo $count; ?>' id='modulo<?php echo $count; ?>' value='<?php echo $r["descripcion"]; ?>' /><?php echo $r["descripcion"]; ?></td>
            			   <td align='center'  > <img src='../img/cancel.png' onclick="eliminar_row(<?php echo $count; ?>);" title='Eliminar Registro' style='cursor:pointer' /></td>
            			 </tr>
                         <?php
                            }
                        }
                    ?>
                </table>
                </div>
           	<input type="hidden" name="contador_mod" id="contador_mod" value="<?php echo $count; ?>"  />
            <script>
                count=<?php echo $count; ?>
            </script>
                </div>
                <div class="upload-msg col-md-12"></div><!--Para mostrar la respuesta del archivo llamado via ajax -->

            <br/> <br />
            <div class="modal-footer">
        <!--        <input type="hidden" name="user_id" id="user_id" />
                <input type="hidden" name="operation" id="operation" /> -->
                 <input type="button" onclick="validar_form();" name="action" id="action" class="btn btn-success"  value="Agregar" />
				<button type="button" class="btn btn-default" onclick="regresar_index(carpeta)" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
        </div>
    </form>
