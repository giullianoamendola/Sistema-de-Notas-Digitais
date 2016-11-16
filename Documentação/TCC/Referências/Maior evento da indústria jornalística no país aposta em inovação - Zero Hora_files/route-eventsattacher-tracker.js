(function(){var API_ENDPOINT='//visualmode.routeapi.com';var Browser=window._rq.browser,Dom=window._rq.dom,Request=window._rq.request,Storage=window._rq.storage,STORE_KEY=window._rq.STORE_KEY,String=window._rq.string,Utils=window._rq.utils,_=window._rq._;var EventsAttacher={};(function(){function isNoActionElement(targetElement){return targetElement.tagName!=='A'&&(targetElement.type&&(targetElement.type.toLowerCase()==='button'||targetElement.type.toLowerCase()==='reset'));}
this.loadAndAttachTracker=function(){loadKnownEvents(function(knownEvents){attachTracker(knownEvents);});};function getMetaTagValue(metaTag){var metaTags=Dom.findByTagName('meta');for(var i=0;i<metaTags.length;i++){var tagProperty=(metaTags[i].getAttribute("property"))?metaTags[i].getAttribute("property"):metaTags[i].getAttribute("name");if(tagProperty==metaTag){return metaTags[i].getAttribute("content")}}
return null;}
function processEvent(event,eventCallback){console.log(String.format('[Route] Event \'{0}\' sent',event.name));var attributes={};for(var i=0;i<event.attributes.length;i++){var attributeToParse=event.attributes[i];if(attributeToParse.type.startsWith('{{og:')){attributes[attributeToParse.name]=getMetaTagValue(attributeToParse.type.replace('{{','').replace('}}',''));}else if(attributeToParse.type==='fixed'){attributes[attributeToParse.name]=attributeToParse.value;}else if(attributeToParse.type==='title'){attributes[attributeToParse.name]=document.title;}else{attributes[attributeToParse.name]=getMetaTagValue(attributeToParse.type);}}
_rq.push(['track',event.name,attributes,eventCallback]);}
function attachTracker(events){_.each(events,function(event){var element=Dom.findBySeletor(event.selector);if(!element)return;console.log(String.format('[Route] Event \'{0}\' attached to element with query {1}.',event.name,event.selector.query));Dom.onClick(element,function(e){var eventCallback;var targetElement=e.target;var linkOpensNewTab=(e.which===2||targetElement.target==="_blank");if(targetElement.parentElement&&targetElement.parentElement.tagName==='A'){targetElement=targetElement.parentElement;}
var noActionElement=isNoActionElement(targetElement);if(!linkOpensNewTab||!noaction_button_click){eventCallback=function(){console.log(String.format('[Route] Event \'{0}\' eventCallback executed',event.name));if(targetElement.tagName==='A'){e.preventDefault();var href=targetElement.href;if(href&&href.length>0){if(href[href.length- 1]=='#')
href=href.substr(0,(href.length- 1));window.location=href;}}else{var form=targetElement.form;var type=targetElement.type.toLowerCase();if(form&&type&&form[type]){if(_.isFunction(form[type]))
form[type]();else
console.warn('[Route] Form submit was overridden');}}};}
processEvent(event);});});}
function loadKnownEvents(callback){new Request({method:'GET',type:'XHR',url:String.format('{0}/?organizationId={1}',API_ENDPOINT,Utils.getOrganizationId()),callback:function(response){if(response.error)throw new Error('[Route] Error getting events to attach.');if(_.isFunction(callback))callback.call(this,response.responseJSON);}});}}).apply(EventsAttacher);EventsAttacher.loadAndAttachTracker();})();