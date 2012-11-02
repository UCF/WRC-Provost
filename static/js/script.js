<<<<<<< HEAD
// Events RSS reader functions
function get_month_from_rss(str){
	var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
	var index  = Number(str.substr(5, 2));
	return months[index - 1];
}

function get_day_from_rss(str){
	return str.substr(8, 2);
}

var eventsCallback = function($, _this){
	var calendar = _this.attr('data-calendar-id');
	var url      = _this.attr('data-url');
	var limit    = _this.attr('data-limit');
	if (!calendar){calendar = 1;}
	if (!url)     {url = 'http://events.ucf.edu';}
	if (!limit)   {limit = 4;}
	
	$.getUCFEvents({
			'calendar_id' : calendar,
			'url'         : PROVOST_MISC_URL + '/events.php',
			'limit'       : limit}, function(data, status, request){
		if (data == null){return;}
		
		for (var i = 0; i < data.length; i++){
			var e     = data[i];
			var event = $('<li />', {'class' : 'event'});
			var date  = $('<div />', {'class' : 'date'});
			var month = $('<span />', {'class' : 'month'});
			var day   = $('<span />', {'class' : 'day'});
			var title = $('<a>', {'class' : 'title', 'href' : url + '?eventdatetime_id='+e.id});
			var end   = $('<div>', {'class' : 'end'});
			
			title.text(e.title);
			day.text(get_day_from_rss(e.starts));
			month.text(get_month_from_rss(e.starts));
			
			date.append(month);
			date.append(day);
			event.append(date);
			event.append(title);
			event.append(end);
			_this.append(event);
		}
	});
};


var handleExternalLinks = function($, _this){
	var url  = _this.attr('href');
	var host = window.location.host;
	
	if (url.search(host) < 0 && url.search('http') > -1){
		_this.attr('target', '_blank');
	}
	return true;
};

var analytics = function(){
	// Google analytics code
	_gaq.push(['_setAccount', GA_ACCOUNT]);
	_gaq.push(['_setDomainName', 'none']);
	_gaq.push(['_setAllowLinker', true]);
	_gaq.push(['_trackPageview']);
	(function(){
		var ga = document.createElement('script');
		ga.type = 'text/javascript';
		ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(ga, s);
	})();
};


var imageRotate = function($){
	$.fn.imageRotate = (function(arguments){
		var defaults = {
			'fade_length'  : 2000,
			'image_length' : 6000
		};
		var options      = $.extend({}, defaults, arguments);
		var container    = $(this);
		
		var active = container.children('div.active');
		if (active.length < 1){
			active = container.children('div:first');
			active.addClass('active');
			setTimeout(function(){container.imageRotate(options);}, options.image_length);
			return;
		}
		
		var next = active.next();
		if (next.length < 1){
			next = container.children('div:first');
		}
		
		active.addClass('last-active');
		active.find('.caption').hide();
		next.css({'opacity' : 0.0});
		next.addClass('active');
		next.animate({'opacity': 1.0}, options.fade_length, function(){
			active.removeClass('active last-active');
			next.find('.caption').show();
		});
		
		setTimeout(function(){container.imageRotate(options);}, options.image_length);
	});
};


var selectLink = function($){
	$.fn.selectLink = (function(arguments){
		var _this = $(this);
		_this.change(function(){
			var selected = _this.children('option:selected');
			var url      = selected.attr('value');
			if (url != 'null'){
				window.location = url;
			}
		});
	});
};


var homeQuoteResizer = function($){
	$.fn.homeQuoteResizer = (function(){
		var decrement_font_size = function(n){
			var value = parseInt(n);
			value--;
			return value + 'px';
		};
		
		var increment_font_size = function(n){
			var value = parseInt(n);
			value++;
			return value + 'px';
		};
		
		var _this  = $(this);
		var image  = $('#home #top .slideshow img').first();
		var parent = _this.parent();
		
		var target_height     = function(){return image.height();};
		var current_height    = function(){return parent.height();};
		var current_diff      = function(){return target_height() - current_height();}
		var current_text_size = function(){return _this.css('font-size');};
		
		// Loop to find ideal text size, stepping through nearby font sizes
		// until desired target height is reached within a reasonable degree
		while (Math.abs(current_diff()) > 1){
			var last_size = current_text_size();
			var last_diff = current_diff();
			if (last_diff < 0){
				_this.css('font-size', decrement_font_size(last_size));
			}else{
				_this.css('font-size', increment_font_size(last_size));
			}
			
			// Break from special case where two of the closest solution values
			// are alternated between
			if (Math.abs(last_diff) <= Math.abs(current_diff())){
				_this.css('font-size', last_size);
				break;
			}
		}
		
		// Small padding adjustments to match exact height
		_this.css('padding-bottom', parseInt(_this.css('padding-bottom')) + current_diff() + 'px');
		
	});
};


var __init__ = (function($){
	analytics();
	$('.slideshow').imageRotate();
	$('.select-links').selectLink();
	$('.events').each(function(){eventsCallback($, $(this));});
	$('#home #quote').homeQuoteResizer();
	$('a').click(function(){handleExternalLinks($, $(this));});
});


(function($){
	homeQuoteResizer($);
	imageRotate($);
	selectLink($);
	__init__($);
})(jQuery);
=======
$().ready(function() {
	
	$('.select-links')
		.change(function() {
			var selected = $(this).children('option:selected');
			if(typeof selected != 'undefined') {
				var url = selected.val();
				if(url != '') {
					window.location = url;
				}
			}
		});
		
	$('#home-images-carousel').carousel('cycle');
	
	// menu nav separators
	$('.menu li:last-child').addClass('last');
	if ($.browser.msie && $.browser.version < 9) {
		$('.menu li').append('<span class="ieseparator">•</span>');
		$('.menu li.last .ieseparator').remove();
	}
	
	// tons of tables? why not javascript? (\/) (°,,,°) (\/)
	$('.page-content table.blue').addClass('table table-striped');
	
	// ie fix for stripey tables
	if ($.browser.msie && $.browser.version < 9) {
		$('.table-striped tbody tr:nth-child(even) td, .table-striped tbody tr:nth-child(even) th').css('background-color','#E5ECF9');
		$('#faculty-excellence-awards .table-striped tbody tr:nth-child(even) td, #faculty-excellence-awards.table-striped tbody tr:nth-child(even) th').css('background-color','#fff');
		$('#faculty-excellence-awards .table-striped tbody tr:nth-child(odd) td, #faculty-excellence-awards.table-striped tbody tr:nth-child(odd) th').css('background-color','#E5ECF9');
	}
});
>>>>>>> upstream/minimal
