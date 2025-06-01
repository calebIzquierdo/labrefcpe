<?php
    include("../../objetos/class.conexion.php");
	
    $objconfig = new conexion();
	
    $op     = $_POST["op"];
    $cod    = $_POST["cod"];
	
    if($cod!=0)
    {
	$query = "select * from usuarios where idusuario=".$cod;
	$row = $objconfig->execute_select($query);
    }
?>

<form method="post" enctype="multipart/form-data"  id="user_form"  name="user_form">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times; </button>
                <h4 class="modal-title">Mantimiento de Etapas</h4>
                <input type="hidden" name="op" id="op" value="<?php echo $op; ?>"  />
            </div>

        <div class="modal-body">

            <label>Codigo</label>
            <input type="text"  name="1form_idusuario" id="codigo" value="<?=$row[1]["idusuario"]?>" class="form-control"    />
            <br />
             <label>Nombres</label>
            <input type="text"  name="0form_nombres" readonly style="text-transform: uppercase;" id="nombres" value="<?=$row[1]["nombres"]?>" class="form-control"    />
            <br />
             <label>Password</label>
            <input type="password" name="0form_contra" style="text-transform: uppercase;" id="contra" value="<?=$row[1]["contra"]?>" class="form-control" />
            <br />

        </div>

        <div class="modal-footer">
            <input type="button" onclick="validar_form();" name="action" id="action" class="btn btn-success" value="Aceptar" />
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
</form>
