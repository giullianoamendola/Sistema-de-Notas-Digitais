var agt=navigator.userAgent.toLowerCase();
var is_major = parseInt(navigator.appVersion);
var is_minor = parseFloat(navigator.appVersion);
var is_moz = ((agt.indexOf('mozilla')!=-1) && (agt.indexOf('spoofer')==-1) && (agt.indexOf('compatible') == -1) && (agt.indexOf('opera')==-1) && (agt.indexOf('webtv')==-1) && (agt.indexOf('hotjava')==-1));
var is_gecko = (agt.indexOf('gecko') != -1);
var is_ie = ((agt.indexOf("msie") != -1) && (agt.indexOf("opera") == -1)) && (document.all);
var is_ie6 = (is_ie && ((agt.indexOf("msie 6.")!=-1) || (agt.indexOf("msie 7.")!=-1)) );
var is_op = ((agt.indexOf("msie") == -1) && (document.all) && (agt.indexOf("opera") != -1)) && !is_ie;
var is_safari = (agt.indexOf("safari") != -1);


var fieldcolor = "#ffffff"; // checkfields
var invalidcolor = "#FFC0C0"; // checkfields
// ------------------------------------------
function addEvent(o,n,f) {
	Event.observe(o,n,f);
}
function nop() {
}
function selectall(frm,para,filter) {
  for (var i=0;i<frm.elements.length;i++) {
    if ((!filter && frm.elements[i].id.substring(0,2) == "id") || (filter && frm.elements[i].id.indexOf(filter) != -1)) {
      if (!frm.elements[i].disabled) frm.elements[i].checked = para;
    }
  }
}
function showstats(divid,page,id,color) {
	$('asp_'+divid).innerHTML = "Carregando ...";
	new Ajax.Updater('asp_'+divid,'/ajaxstatpush.ajax?page='+page+'&id='+id+'&height=100&color='+color,{asynchronous:true});
}
function checkboxsystem_check(field) {
  var output = '';
  c = 0;
  while ($(field+c)) {
  	output += $(field+c).checked?"1":"0";
  	c++;
  }
  $(field).value = output;
}
function ismail( oMail ) {
	return ereg(oMail,"^[A-Za-z0-9]+(([_\.\-]?[a-zA-Z0-9]+(_)?)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$");
}
function islogin(oValor,allowSpace) {
	return ereg(oValor,allowSpace?"^([ A-Za-z0-9_\-]){4,20}$":"^([A-Za-z0-9_\-]){4,20}$");
}
function isnumber( oValor , accept_commas ) {
if (!accept_commas)
  MyRegExp = new RegExp("^(\-)?([0-9]*)$");
else
  MyRegExp = new RegExp("^(\-)?([0-9]*)(([,\.])([0-9]{3}))*(([,\.]{1})([0-9]*))?$");
return MyRegExp.test(oValor);;
}
function str_replace(what,to,into,maxreplaces) {
var antiloop = 0;
if (!maxreplaces) maxreplaces = 100;
while (into.indexOf(what)!=-1 && antiloop++<=maxreplaces) {
into = into.substring(0,into.indexOf(what)) + to + into.substring(into.indexOf(what) + what.length);
}
return into;
}
function cleanamps (texto) { // para W3C validator não amolar
  return str_replace("&amp;","&",texto,10);
}
function ereg(texto,mascara) {
	MyRegExp = new RegExp(mascara);
	return MyRegExp.test(texto);
}
function limpaString(S,modo){
  var Digitos = " 0123456789" + (modo?".,-":"");
  var temp = "";
  var digito = "";
  for (var i=0; i<S.length; i++)	{
    digito = S.charAt(i);
    if (Digitos.indexOf(digito) >= 0)	{
      temp=temp+digito;
    }
  }
  return temp;
}
function validaCGC(s) {
  var i;
  var s = limpaString(s);
  if (s.length < 14) return false;
  var c = s.substr(0,12);
  var dv = s.substr(12,2);
  var d1 = 0;
  for (i = 0; i < 12; i++) {
    d1 += c.charAt(11-i)*(2+(i % 8));
  }
  if (d1 == 0) return false;
    d1 = 11 - (d1 % 11);
  if (d1 > 9) d1 = 0;
  if (dv.charAt(0) != d1) {
    return false;
  }
  d1 *= 2;
  for (i = 0; i < 12; i++) {
    d1 += c.charAt(11-i)*(2+((i+1) % 8));
  }
  d1 = 11 - (d1 % 11);
  if (d1 > 9) d1 = 0;
  if (dv.charAt(1) != d1) {
    return false;
  }
  return true;
}
function validaCPF(cpf) {
  var i;
  var s = cpf;
  if (s.length < 11) return false;
  var c = s.substr(0,9);
  var dv = s.substr(9,2);
  var d1 = 0;
  for (i = 0; i < 9; i++) {
    d1 += c.charAt(i)*(10-i);
  }
  if (d1 == 0) {
    return false;
  }
  d1 = 11 - (d1 % 11);
  if (d1 > 9) d1 = 0;
  if (dv.charAt(0) != d1) {
    return false;
  }
  d1 *= 2;
  for (i = 0; i < 9; i++) {
    d1 += c.charAt(i)*(11-i);
  }
  d1 = 11 - (d1 % 11);
  if (d1 > 9) d1 = 0;
  if (dv.charAt(1) != d1) {
    return false;
  }
  return true;
}
function checkmailfield(campo,bgc) {
  if (!bgc || bgc=="") bgc = fieldcolor;
  if (!ismail(campo.value)) {
    campo.style.background= invalidcolor;
    return false;
  } else {
    campo.style.background= bgc;
    return true;
  }
}
function checknbrfield(campo,ponto,bgc) {
  if (!bgc || bgc=="") bgc = fieldcolor;
  if (!isnumber(campo.value,ponto)) {
    campo.style.background= invalidcolor;
    return false;
  } else {
    campo.style.background=bgc;
    return true;
  }
}
var lastlogin = "";
freelogin = true;
function checklogin(campo,bgc,imgField,allowSpace) {
	campo = $(campo);
	if (!bgc || bgc=="") {
		bgc = fieldcolor;
	}
	if ( islogin(campo.value,allowSpace) ) {
	    campo.style.background=bgc;
	    if (imgField && imgField != "") {
	    	if (campo.value != lastlogin) {
	    		if (freelogin) {
	    			freelogin = false;
			    	new Ajax.Updater($(imgField),'/ajaxlogin.ajax?layout=2&login='+campo.value, {asynchronous:true, onComplete:resetChecklogin} );
	    			lastlogin = campo.value;
	    		} else {
	    			setTimeout("function() { checklogin('"+campo.id+"','"+bgc+"','"+imgField+"','"+(allowSpace?"true":"false")+"')}",1000);
	    		}
	    	}
	    }
	    return true;
	} else {
		campo.style.background=invalidcolor;
		return false;
	}
}

// valida pass necessario para o campo password - login site
function checkpass(campo,bgc,imgField,allowSpace) {
	campo = $(campo);
	if (!bgc || bgc=="") {
		bgc = fieldcolorpass;
	}
	if ( islogin(campo.value,allowSpace) ) {
	    campo.style.background=bgc;
	    if (imgField && imgField != "") {
	    	if (campo.value != lastlogin) {
	    		if (freelogin) {
	    			freelogin = false;
			    	new Ajax.Updater($(imgField),'/ajaxlogin.ajax?layout=2&login='+campo.value, {asynchronous:true, onComplete:resetChecklogin} );
	    			lastlogin = campo.value;
	    		} else {
	    			setTimeout("function() { checklogin('"+campo.id+"','"+bgc+"','"+imgField+"','"+(allowSpace?"true":"false")+"')}",1000);
	    		}
	    	}
	    }
	    return true;
	} else {
		campo.style.background=invalidcolorpass;
		return false;
	}
}

function resetChecklogin(data) {
  freelogin = true;
}
function checkdatetime(campo,canDate,canTime,bgc,mandatory) {
	if (!bgc || bgc=="") bgc = fieldcolor;
	if (canDate) {
		if (canTime)
			ok = ereg(campo.value,"^( )*(([0-9]{1,2})([^0-9])){4,5}([0-9]{2,4})( )*$"); // s is optional
		else
			ok = ereg(campo.value,"^( )*(([0-9]{1,2})([^0-9])){2}([0-9]{2,4})( )*$");
	} else {
		ok = ereg(campo.value,"^( )*(([0-9]{1,2})([^0-9])){1,2}([0-9]{2})( )*$"); // s is optional
	}
	ok = ok || (!mandatory && campo.value == '');
	if (ok) {
		campo.style.background=bgc;
		return true;
	} else {
    	campo.style.background= invalidcolor;
	    return false;
  	}
}
function checkid(campo,accept_cpf,accept_cnpj,bgc) {
  if (!bgc || bgc=="") bgc = fieldcolor;
  campo.value = limpaString(campo.value,false);
  if ( (accept_cpf && validaCPF(campo.value)) ||
       (accept_cnpj && validaCGC(campo.value))
      ) {
    campo.style.background=bgc;
    return true;
  } else {
    campo.style.background= invalidcolor;
    return false;
  }
}
function parseajax(ajaxobj) {
  try {
	  if (ajaxobj.responseText)
	  	  var dados=ajaxobj.responseText;
	  else
		  dados=ajaxobj;
	
	  dados = dados.replace(/\+/g," ");
	  dados = " " + dados;
	  posa = dados.indexOf("<SCRIPT>");
	  posb = dados.indexOf("</SCRIPT>");
	  if (posa>0 && posb>0) {
	    js = dados.substring(posa+8,posb);
	    if (js != "") {
	      eval(js);
		  return dados.substring(1,posa) + "" + dados.substring(posb+9,dados.length);
	    }
	  } else {
		  posa = dados.indexOf("<script type=\"text/javascript\">");
		  posb = dados.indexOf("</script>");
		  if (posa>0 && posb>0) {
			js = dados.substring(posa+31,posb);
	    	if (js != "") {
		    	eval(js);
				return dados.substring(1,posa) + "" + dados.substring(posb+9,dados.length);
			}
		  }
	  }
	  return dados.substring(1,dados.length);
  } catch (ee) {
    alert("Erro obtendo dados via AJAX: " + ee);
    return ajaxobj;
  }
}
function str_count(what,where) {
	var temp = where;
	localizados = 0;
	while (temp.indexOf(what) != -1 && localizados++<100) {
		temp = temp.substring(temp.indexOf(what) + what.length);
	}
	return localizados;
}
function findPosX(obj) {
   	var curleft = 0;
   	if(obj.offsetParent) {
       	while(obj.nodeType < 6) {
       		curleft += obj.offsetLeft;
     		if(!obj.offsetParent)
       	   		break;
   			obj = obj.offsetParent;
       	}
   	} else if(obj.offsetLeft)
       	curleft += obj.offsetLeft;
   	return curleft;
}
function findPosY (obj) {
   	var curtop = 0;
   	if(obj.offsetParent) {
       	while(obj.nodeType < 6) {
       		curtop += obj.offsetTop;
       		if(!obj.offsetParent)
   	       		break;
       		obj = obj.offsetParent;     		
      	}
   	} else if(obj.offsetTop)
       	curtop += obj.offsetTop;
   	return curtop;
}


function ToggleHidden(obj,imgfield,imgon,imgoff) {
  	obj = $(obj);
  	if (obj.style.display == "none") {
  		try {
  			new Effect.BlindDown(obj);
  		} catch (ee) {
  			obj.style.display = '';
  		}
  		if (imgfield) {
  			$(imgfield).src = imgoff;
  		}
  	} else {
  		try {
	  		new Effect.BlindUp(obj);
	  	} catch (ee) {
	  		obj.style.display = 'none';
	  	}
	  	if (imgfield) {
  			$(imgfield).src = imgon;
  		}
  	}
}

menuMarkOpacity = 1; // change to make the dropdown transparent
menuSmooth = false; // change to true to make use of scriptaculous blind function
menuHideTime = 500; // ms
menuMarkhover = new Array(); // hover menu system
menuHoverID = 0; // which menu am I over?
menuOverCallback = ''; // callback when the menu shows up (can be used to set zIndex)
menuAutoHide = 0; // fill this with a possible already on menu to auto-hide it on the first pass
// hoverbtn => onmouseover="hovermenu([i],true)" onmouseout="hovermenu([i],false,true)"
// hoverdiv => id="divm[i]" onmouseover="hovermenu([i],true)" onmouseout="hovermenu([i],false,true)"
// NOTE: display:none at the divs must be in the STYLE not in the CLASS
function hovermenu(id,mode,timed,auto) {
	// mode = true/false 		Wants to show or hide
	// timed = true/fase		This was a timed event (wait a while to perform)
	// auto = true/fase			Triggered by the script and not an event

	if (menuAutoHide != 0) {
		menuMarkhover[menuAutoHide] = "0";
		$('divm'+menuAutoHide).style.display = 'none';
		menuAutoHide = 0;
	}

	var action = "";
	if (!menuMarkhover[id])
		menuMarkhover[id] = "0"; // default not shown
	var visible = menuMarkhover[id] == "1";

	if (mode) menuHoverID = id;

	if (mode && !visible) { // want to show, and its hidden
		action = "S"; // show
	}
	if (!mode && visible) { // want to hide, but its still shown
		if (!auto) { // not automatic
			menuHoverID = 0; // Im off any menu
			if (timed) setTimeout("hovermenu("+id+",false,false,true)",menuHideTime);
			else action = "H";
		} else if (id != menuHoverID) // timed hide and I am no longer at this menu
			action = "H";
	}
	if (mode && menuMarkOpacity < 1) {
		Element.setOpacity($('divm'+id), menuMarkOpacity);
	}
	if (action != "") {
		if (!visible && action == "S") {
			if (menuSmooth) {
				new Effect.BlindDown('divm'+id);
			} else {
				$('divm'+id).style.display = '';
			}
			if (menuOverCallback) menuOverCallback($('divm'+id));
			menuMarkhover[id] = "1";
		} else if (visible) {
			$('divm'+id).style.display = 'none';
			menuMarkhover[id] = "0";
		}
	}
}
function explode(separator,items) {
	var output = new Array();
	var size = items.length;
	var outputpos = 0;
	var buffer = '';
	for (var c=0;c<size;c++) {
		if (items.charAt(c) == separator) {
			output[outputpos] = buffer;
			outputpos++;
			buffer = '';
		} else
			buffer += items.charAt(c);
	}
	if (buffer != '') {
		output[outputpos] = buffer;
	}
	return output;
}
function getNumber(pv) {
	temPonto = pv.indexOf('.')>-1;
	temVirgula = pv.indexOf(',')>-1;
	if (temPonto || temVirgula) {
		pv = str_replace(",",".",pv);
		pv = explode(".",pv);
		decimal = pv.pop();
		valor = '';
		for (c=0;c<pv.length;c++) {
			valor = '' + valor + pv[c];
		}
		valor += '.' + decimal;
	} else
		valor = pv;
	return parseFloat(valor);
}
function addSlide(mainDIV,lD,rD,imgW,imgs,timed) {
	if (!timed) {
		if (is_ie)
			setTimeout(function() { addSlide(mainDIV,lD,rD,imgW,imgs,true); },1010);
		else
			setTimeout(addSlide,1010,mainDIV,lD,rD,imgW,imgs,true);
	} else {
		$(mainDIV).style.position = 'absolute';
		$(mainDIV).style.width = ((imgW*imgs)+(2*imgs)) + "px";
		$(mainDIV).style.left = "0px";
		$(mainDIV).style.top = "0px";
		$(lD).style.cursor = "pointer";
		$(rD).style.cursor = "pointer";
		$(mainDIV).parentNode.style.overflow = "hidden";
		$(mainDIV).parentNode.style.position = "relative";
		extra = document.createElement('div');
		extra.setAttribute('id',mainDIV + "_2");
		extra.innerHTML = $(mainDIV).innerHTML;
		extra.style.position = 'absolute';
		extra.style.overflow = 'hidden';
		extra.style.width = $(mainDIV).style.width;
		extra.style.height = $(mainDIV).style.height;
		extra.style.left = (-(imgW*imgs))+"px";
		extra.style.top = "0px";
		extra.style.display = 'block';
		$(mainDIV).parentNode.appendChild(extra);
		$(lD).onclick = function(){
			if (parseInt($(mainDIV + "_2").style.left)>-(imgW*imgs)+parseInt($(mainDIV).parentNode.style.width)) {
				 new Effect.Move($(mainDIV),{x:-imgW,y:0});
				 new Effect.Move($(mainDIV + "_2"),{x:-imgW,y:0});
			} else  {
				$(mainDIV).style.left = $(mainDIV + "_2").style.left;
				$(mainDIV + "_2").style.left = (parseInt($(mainDIV).style.left) + (imgW*imgs)) + "px";
				new Effect.Move($(mainDIV),{x:-imgW,y:0});
				new Effect.Move($(mainDIV + "_2"),{x:-imgW,y:0});
			}
		};
		$(rD).onclick = function(){
			if (parseInt($(mainDIV).style.left)<-1) {
				new Effect.Move($(mainDIV),{x:imgW,y:0});
				new Effect.Move($(mainDIV + "_2"),{x:imgW,y:0});
			} else {
				$(mainDIV).style.left = - (imgs*imgW) + "px";
				$(mainDIV + "_2").style.left = "0px";
				new Effect.Move($(mainDIV),{x:imgW,y:0});
				new Effect.Move($(mainDIV + "_2"),{x:imgW,y:0});
			}
		};
	}
}

function addSlideV(mainDIV,uD,dD,imgH,imgs,timed) {
	if (!timed) {
		if (is_ie)
			setTimeout(function() { addSlideV(mainDIV,uD,dD,imgH,imgs,true); },1010);
		else
			setTimeout(addSlideV,1010,mainDIV,uD,dD,imgH,imgs,true);
	} else {

		$(mainDIV).style.position = 'absolute';
		$(mainDIV).style.height = ((imgH*imgs)+(2*imgs)) + "px";
		$(mainDIV).style.top = "0px";
		$(mainDIV).style.left = "0px";
		$(uD).style.cursor = "pointer";
		$(dD).style.cursor = "pointer";
		$(mainDIV).parentNode.style.overflow = "hidden";
		$(mainDIV).parentNode.style.position = "relative";
		$(uD).onclick = function(){if (parseInt($(mainDIV).style.top)>-(imgH*imgs)+parseInt($(mainDIV).parentNode.style.height)) new Effect.Move($(mainDIV),{x:0,y:-imgH})};
		$(dD).onclick = function(){if (parseInt($(mainDIV).style.top)<-1) new Effect.Move($(mainDIV),{x:0,y:imgH})};
	}
}

function setBookmark(title,url) {
	try {
		if (window.sidebar) // some firefox and mozilla
			window.sidebar.addPanel(title, url, "");
		else if(document.all && window.external) // most ie versions
			window.external.AddFavorite(url, title);
		else
			alert("Use CTRL+D");
	} catch (ee) {
		alert("Use CTRL+D");
	}
}

/*
function activateFlash() { // Microsoft IE Eolas patent issue
	E=document.getElementsByTagName('object');
	for(i=0;i<E.length;i++){
		P=E[i].parentNode;
		H=P.innerHTML;
		P.removeChild(E[i]);
		P.innerHTML=H;
	}
}
if (is_ie6) Event.observe(window,'load',function(){activateFlash()});
*/

function debugSystem(){
	
	setTimeout(function(){
		$('debugsystem').addClassName("debug_ativo")
		}, 1000);

	setTimeout(function(){
			$('debugsystem').removeClassName("debug_ativo");
		}, 4000);

}