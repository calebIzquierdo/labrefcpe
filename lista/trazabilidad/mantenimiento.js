var count=0;
var objindex="";
$(document).ready(function() {
	$('.paginate').live('click', function(){
		
		$('#content').html('<div class="loading"><img src="../../img/avance.gif" /></div>');

		var page = $(this).attr('data');		
		var dataString = 'page='+page;
		
		$.ajax({
            type: "GET",
            url: "paginacion.php",
            data: dataString,
            success: function(data) {
				$('#content').fadeIn(1000).html(data);
            }
        });
    });              
});
function BuscarG(Op)
{
	var Valor = document.getElementById('valor').value
	var Op2 = ''
	if (Op!=0)
	{
		Op2 = '&Op=' + Op;
	}
        
	location.href='index.php?valor=' + Valor + '&pagina=' + Pagina + Op2;
}
function Buscar(Op)
{
	BuscarG(Op);
}
function enviar(id,index,peso,item)
{
	window.opener.recibir(id,$("#nombre"+index).val(),peso,item,$("#codtrazabilidad"+index).val())
	window.close()
}


