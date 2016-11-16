function trocaCinema(id,qtd){
	jQuery(".btnCinema").removeClass("ativo");
	$('btncinema_'+id).addClassName("ativo");

	$('cinema_list').innerHTML = '<img src="/pages/donin/images/images/loading.gif" alt="loading" style="margin:120px auto" />';
	new Ajax.Updater('cinema_list','/ajax/filmes.ajax?nocache=true&id='+id+'&qtd='+qtd,{
					 evalScripts: true,
					 onComplete: function(response){
					 return false;
				}
	});
}