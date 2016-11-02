(function() {
"use strict";

document.onmousemove = handleMouseMove;
function handleMouseMove(event) {
	var windowWidth, eventDoc, doc, body, pageX, pageY;
	var windowWidth = window.innerWidth
	|| document.documentElement.clientWidth
	|| document.body.clientWidth;
	event = event || window.event; // IE-ism

	if (event.pageX == null && event.clientX != null) {
	eventDoc = (event.target && event.target.ownerDocument) || document;
	doc = eventDoc.documentElement;
	body = eventDoc.body;

	event.pageX = event.clientX +
	  (doc && doc.scrollLeft || body && body.scrollLeft || 0) -
	  (doc && doc.clientLeft || body && body.clientLeft || 0);
	event.pageY = event.clientY +
	  (doc && doc.scrollTop  || body && body.scrollTop  || 0) -
	  (doc && doc.clientTop  || body && body.clientTop  || 0 );
	}
	if(event.pageX < 3*windowWidth/10 ){
		jQuery(".previousPost").addClass('animated fadeInLeft');
	}else if(event.pageX  >  7*windowWidth/10){
		jQuery(".nextPost").addClass('animated fadeInRight');
	}else{
		jQuery(".previousPost").removeClass('animated fadeInLeft');
		jQuery(".nextPost").removeClass('animated fadeInRight');
	}
}
})();