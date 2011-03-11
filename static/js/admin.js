var __init__ = (function($){
	$.fn.filler = function(){
		var _this = $(this);
		_this.change(function(){
			var selected = _this.children('option:selected');
			var url      = selected.attr('value');
			if (url != 'null'){
				$('#provost_help_url').val(url);
			}
		});
	};
	
	// Allows forms with input fields of type file to upload files
	$('input[type="file"]').parents('form').attr('enctype','multipart/form-data');
	$('input[type="file"]').parents('form').attr('encoding','multipart/form-data');
	
	$('select.filler').filler();
});


(function($){
	__init__($);
})(jQuery);
