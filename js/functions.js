
jQuery(document).ready(function($){
	$('.edoc-post-nav-color-field').wpColorPicker();
	$('#unlocknow05').click(function(){
		var data = {
			action	: 'unlock05',
			key	: $('#keyunlock05').val()
		};
		$.post(ajaxurl, data, function(response) {			
			window.location.reload();
		});
	});
});
Element.prototype.edocpostnav = function() {
    this.parentElement.removeChild(this);
}
NodeList.prototype.edocpostnav = HTMLCollection.prototype.edocpostnav = function() {
    for(var i = 0, len = this.length; i < len; i++) {
        if(this[i] && this[i].parentElement) {
            this[i].parentElement.removeChild(this[i]);
        }
    }
}
document.getElementsByClassName("post-nav-wrapper").edocpostnav();