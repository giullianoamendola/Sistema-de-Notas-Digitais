function res_selector_ajax() {
	new Ajax.Request('/setres.php?layout=2&res=' + screen.width + "x" + screen.height, {asynchronous:true} );
}
setTimeout("res_selector_ajax();", 2000);