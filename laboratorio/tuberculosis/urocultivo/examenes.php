    <?php
    include("../../../objetos/class.conexion.php");

    $objconfig  = new conexion();

    $op	=  $_POST["op"];
    $cod =  $_POST["idtpate"];
	
    
    ?>
   
   <div style="height:280px;  overflow-x:hidden;" >
				<div class="row">
				<div class="col-sm-12">
				<div class="panel panel-info ">
					<div class="panel-heading">LISTADO DE EXAMENES A SOLICITADO </div>
					<div class="panel-body">
						<table class="table table-striped table-bordered table-hover table-responsive" id="tbexamenes" name="tbexamenes" >
							<thead>

							<tr>
								<td >#</td>
								<td >Exámen </td>
								<td >Unidad  </td>
								<td >Área  </td>
								<td ></td>
							</tr>

							</thead>
							<tbody>
							<?php
							$count_exam=0;
							$sqlF = "select m.idmuestradetalle, m.idingresomuestra, m.idtipo_examen, m.idarea,  e.descripcion as tipexamen, 
									a.descripcion as area_destino,sat.descripcion as subarea
									from muestra_det as m
									inner join tipo_examen as e on(e.idtipo_examen=m.idtipo_examen)
									inner join areas as a on(a.idarea=m.idarea)
									inner join area_trabajo as sat on(sat.idareatrabajo=m.idareatrabajo)
									where m.idingresomuestra=".$cod." ";
							$rowF = $objconfig->execute_select($sqlF,1);
							foreach($rowF[1] as $rF)
							{
								$count_exam++;

								?>
								<tr id='itemdexamen<?php echo $count_exam; ?>' name='itemdexamen<?php echo $count_exam; ?>' >
									<td >
										<input type='hidden' name='idmuestradetalle<?php echo $count_exam; ?>' id='idmuestradetalle<?php echo $count_exam; ?>' value='<?php echo $rF["idmuestradetalle"]; ?>' />
										<?php echo $count_exam ; ?>
									</td>
									<td>
										<input type='hidden' name='idtipo_examen<?php echo $count_exam; ?>' id='idtipo_examen<?php echo $count_exam; ?>' value='<?php echo $rF["idtipo_examen"]; ?>' />
										<?php echo strtoupper($rF["tipexamen"] ); ?>
									</td>
									<td>
										<input type='hidden' name='idareatrabajo<?php echo $count_exam; ?>' id='idareatrabajo<?php echo $count_exam; ?>' value='<?php echo $rF["idareatrabajo"]; ?>' />
										<input type='hidden' name='idarea<?php echo $count_exam; ?>' id='idarea<?php echo $count_exam; ?>' value='<?php echo $rF["idarea"]; ?>' />
										<?php echo strtoupper($rF["area_destino"] ); ?>
									</td>
									<td>
										<?php echo strtoupper($rF["subarea"] ); ?>
									</td>
									<td >
									<!--
										<img src='../img/cancel.png' style='cursor:pointer' onclick='quitar_diagnostico(<?php echo $count_exam; ?>)' title='Borrar REgistro' />
									-->
									</td>
								</tr>
							<?php }?>
							</tbody>
						</table>
						<input type="hidden" id="contar_examen" name="contar_examen" value="<?php echo $count_exam; ?>" />
						<input type="hidden" id="contar_examen2" name="contar_examen2" value="<?php echo $count_exam; ?>" />
						<script> var  count_exam=<?php echo $count_exam; ?> </script>
						</div>
						</div>
						</div>
					</div>
				</div>