var count=0;
var objindex="";

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
function enviar(index,nromovimiento)
{
	window.opener.recibir($("#nrocomprobante"+index).val(),nromovimiento)
	window.close()
}


