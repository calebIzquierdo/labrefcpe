
function Buscar(Op)
{
	BuscarG(Op);
}
function enviar(id,index)
{
	window.opener.recibir(id,$("#nombre"+index).val())
	window.close()
}
