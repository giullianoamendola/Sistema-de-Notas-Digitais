/* 

    Document   : functions.js
    Created on : 02/10/2012, 21:35:54
    Author     : @vagnermix ( Criacao, Front-end e SEO ) @antonioiae ( Back-end ) - NacionalVOX - Agencia Digital www.nacionalvox.com.br
    Description: JS - "Deolhonailha | Fique por dentro de Floripa"

*/

IncludeJavaScript("/pages/donin/images/scripts/easing.js");
IncludeJavaScript("/pages/donin/images/scripts/jquery.ui.totop.js");
IncludeJavaScript("/pages/donin/images/scripts/jquery.uniform.min.js");
IncludeJavaScript("/pages/donin/images/scripts/jquery.jcarousel.min.js");
IncludeJavaScript("/pages/donin/images/scripts/jquery.placeholder.min.js");

function printObject(o) {
  var out = '';
  for (var p in o) {
    out += p + ': ' + o[p] + '\n';
  }
  alert(out);
}

jQuery(document).ready(function() {
	
	jQuery().UItoTop({ easingType: 'easeOutQuart' });
	
	// target blank
	jQuery("a[rel*=external]").attr('target','_blank');
	
	// select
	jQuery("select").uniform();

	// jcarousel
	jQuery('#slide_imagens').jcarousel({
		//auto: 5,
		scroll: 1,
		wrap: 'last'
	});

	// resize texto
	jQuery('a.redimen').click(function(){
		var ourText = jQuery('.resize');
		var currFontSize = ourText.css('fontSize');
		var finalNum = parseFloat(currFontSize, 10);
		var stringEnding = currFontSize.slice(-2);
		if(this.id == 'large') {
			finalNum *= 1.2;
		}
		else if (this.id == 'small'){
			finalNum /=1.2;
		}
		ourText.animate({fontSize: finalNum + stringEnding},600);
	});
	
	/*// placeholder IE
	jQuery('input[placeholder]').each(function(){ 
       
		var input = jQuery(this);       
	   
		jQuery(input).val(input.attr('placeholder'));
		jQuery(input).focus(function(){
			 if (input.val() == input.attr('placeholder')) {
				 input.val('');
			 }
		});
		jQuery(input).blur(function(){
			if (input.val() == '' || input.val() == input.attr('placeholder')) {
				input.val(input.attr('placeholder'));
			}
		});
	});*/

	jQuery('input[placeholder], textarea[placeholder]').placeholder();

	
	// assine nossa newsletter
	display = false;
	jQuery("#exibenewsletter").click(function () {
		if (!display)
		{
			jQuery(".newslleter").slideDown("slow");
			display = true;
		} else {
			jQuery(".newslleter").slideUp("slow");
			display = false;			
		}
	});
		
});