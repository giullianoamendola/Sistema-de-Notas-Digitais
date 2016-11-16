function comboSelect(field,value,width,module,isADD,preSelected,theForm,firstAll) { // onChange -> dinamic combos entrypoint -> ajaxSelect / ajaxReturn
	// field = campo que chama
	// value = valor do campo
	// width = width do SELECT a ser gerado OU classe
	// module = módulo do banco que tem ambos os campos
	// isADD = true para obrigatório
	// preSelected = ID que deve vir pré-selecionado
	// theForm = o objeto form que tem estes select
	// firstAll = texto que aparece no primeiro campo denotando "tudo"

	//  o resultado vai ser preenchido no "div_[nome dos campos que mudam]"

	try {
		if (!firstAll) firstAll = "";
		if (!isADD || isADD == "false") isADD = "false"; // if it did not came, set as false (weird huh?)
		else isADD = "true";
		if (!preSelected) preSelected = 0; // nothing selected
		if (!width) width = "";
		if (!module) {
			alert("ERROR");
			return;
		}
		if (!theForm)
			frm = document.frmbase;
		else
			frm = theForm;
		try {
		  	len = eval("cc_"+field+".length");
		} catch(e) {
			len = 0;
		}
		if (len >0) {
			myarr = eval("cc_"+field);
			for(c=0;c<len;c++) { // for each I filter
			    query = "/comboinc.html?layout=2&isADD="+isADD+"&width=" + width + "&module="+module+"&field="+myarr[c];
			    if (firstAll != "") query += "&firstAll="+firstAll;
			    if (preSelected != 0) query += "&" + myarr[c] + "=" + preSelected;
				lenr = eval("ccr_"+myarr[c]+".length");
				remarr = eval("ccr_"+myarr[c]);
				for (i=0;i<lenr;i++) { // for each they require
					query = query + "&" + remarr[i] + "=" + eval("frm."+remarr[i]+"?frm."+remarr[i]+".value:0");
				}
				ajaxSelect(myarr[c],query);
			}
		}
	} catch (ee) {
		ajax = new Ajax.Request('/reportjserror.php?name=' + ee.name + '&message=comboSelect ' + ee.message);
	}
}
function ajaxSelect(field,query) { // comboSelect -> loads ONE combo from a parent combo -> ajaxReturn
 	obj = $('ajaxholder_'+field);
 	obj.innerHTML = "Carregando...";
 	ajax = new Ajax.Updater('ajaxholder_'+field, query, {asynchronous:false,
 	                                                     onComplete:ajaxReturn}
 	                       );
	new Effect.Pulsate ('ajaxholder_'+field);

}
function ajaxReturn(data) { // ajaxSelect -> checks for javascript on combo return (nested combo ajax)
 	data = parseajax(data);
 	tratajs(data);
}

function ajaxsearch(field,search,isADD,module,width) {
	new Effect.BlindDown ('ajaxholder_'+field);
	if (!isADD) isADD = "false"; // if it did not came, set as false (weird huh?)
	query = "comboinc.html?layout=2&isADD="+isADD+"&width=" + width + "&module="+module+"&field="+field+"&"+field+"="+$(field).value+"&akrsearch="+search;
	try {
	  	lenr = eval("ccr_"+field+".length");
	} catch(ee) {
		lenr = 0;
	}
	frm = document.frmbase;
	if (lenr>0) {
		remarr = eval("ccr_"+field);
		for (i=0;i<lenr;i++) { // for each they require
			query = query + "&" + remarr[i] + "=" + eval("frm."+remarr[i]+".value");
		}
	}
	ajaxSelect(field,query);
}

var lCEP = 0;
function checkCEP(field) {
	if (field.value == lCEP) return;
	lCEP = field.value;
	query = "ajaxlocation.php?layout=2&cep=" + field.value;
	ajax = new Ajax.Request(query, {asynchronous:true,
	                                    onComplete:ajaxReturn}
	                       );
}

