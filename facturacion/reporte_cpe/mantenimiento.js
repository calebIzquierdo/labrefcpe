var carpeta = "../facturacion/reporte_cpe/";
var aja2 =  "../ajax/";
//$("#btn_click").click();
function recarga2(dir){
    /*if($("#fInicio").val()!=""&&$("#fFin").val()!="" &&$("#fInicio").val()==$("#fFin").val()){
        alert("las fechas deben ser distintas");
        $("#fInicio").focus();
        return;
    }

    const fInicio= ($("#fInicio").val().replace('-',''));
    const fFin= ($("#fFin").val().replace('-',''));
    if(fFin<fInicio){
        alert("La fecha inicial debe ser mayor a la final");
        $("#fInicio").focus();
        return;
    }*/
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
        "ajax": dir+"registros.php?fInicio="+$("#fInicio").val()+"&fFin="+$("#fFin").val()
    	} );
	} );
}
