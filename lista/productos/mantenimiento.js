$(document).ready(function() {	
	$('.paginate').live('click', function(){
		
		$('#content').html('<div class="loading"><img src="../../img/avance.gif" /></div>');

		var page = $(this).attr('data');		
		var dataString = 'page='+page;
		
		$.ajax({
            type: "GET",
            url: "registros.php",
            data: dataString,
            success: function(data) {
				$('#content').fadeIn(1000).html(data);
            }
        });
    });              
});
function BuscarG(Op)
{
	var Valor = "";//document.getElementById('valor').value
	var Op2 = ''
	if (Op!=0)
	{
		Op2 = '&Op=' + Op;
	}
	
	var url 	= parent.location.href
	var pos		= url.indexOf("?")
	if(pos!=-1){url = url.substring(pos-1,0)}

	location.href=url+"?valor="+$("#valor").val()+ '&pagina=' + Pagina + Op2;
}
function Buscar(Op)
{
	BuscarG(Op);
}
function enviar(id,index,idprod)
{
	/* alert(id)
	alert(index)
	alert(idprod) */
	window.opener.recibir(id,$("#nombre"+index).val(),idprod)
	window.close()
}
