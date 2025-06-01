var carpeta = "../patrimonio/reportebienes/consolidado/";
var aja2 =  "../ajax/";
//$("#btn_click").click();
function recarga2(dir){

	$(document).ready(function() {
    $('#dataTables-exampl').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            { extend: 'excel', className: 'btn-primary' },
        ],
    	"responsive":true, // enable responsive
    	"destroy":true,
        "processing": true,
        "serverSide": true,
        "ajax": dir+"registros.php?red="+$("#idred").val()+"&mred="+$("#idmicrored").val()+"&eess="+$("#idestablecimiento").val()+"&area="+$("#idarea").val()+"&sarea="+$("#idareatrabajo").val()
    	} );
	} );
}

function cargar_microred(cod)
{
	$.ajax({
            type: "POST",
            url: aja2+"microredA.php",
            data: "codi="+cod,
            success: function(data) {
            $("#div-microred").html(data)
            }
       });
}

function cargar_estable(cod)
{
	$.ajax({
            type: "POST",
            url: aja2+"establecimientoA.php",
            data: "microred="+cod,
            success: function(data) {
            $("#div-establecimiento").html(data)
            }
       });
}
function cargar_area(cod)
{
	$.ajax({
            type: "POST",
            url: aja2+"area.php",
            data: "idestable="+cod,
            success: function(data) {
            $("#div-area").html(data)
            }
       });
}
function cargar_subarea(cod)
{
	$.ajax({
            type: "POST",
            url: aja2+"subarea.php",
            data: "idarea="+cod,
            success: function(data) {
            $("#div-subarea").html(data)
            }
       });
}
