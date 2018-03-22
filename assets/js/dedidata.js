jQuery(document).ready(function($){

	$('[data-toggle="tooltip"]').tooltip();

	// scroll to top
	$(window).scroll(function () {
		if ($(this).scrollTop() > 50) {
			$('#back-to-top').fadeIn();
		} else {
			$('#back-to-top').fadeOut();
		}
	});
	// scroll body to 0px on click
	$('#back-to-top').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
		return false;
	});

	function fix_affix(){
		$('.side-column').affix({
			offset: {
				top: ($('#main').offset().top - 50), // where is the top
				bottom: ($('.page-footer').outerHeight(true))  // where is the bottom
				}
			}
		);
		$(document).ready(function(){
			if($('.side-column').height() > $('.content-area').height() ){
				$(window).off('.affix');
				$(".side-column").removeClass("affix affix-top affix-bottom");
				$(".side-column").css('top', 'initial');
			}
		})
	}
	var doit;
	window.onresize = function(){
		clearTimeout(doit);
		doit = setTimeout(fix_affix, 500);
	};
	fix_affix();

	$('.page-footer').css('color',$('.navbar-inverse .navbar-nav>li>a').css('color'));
	$('.page-footer a').css('color',$('.navbar-inverse .navbar-nav>li>a').css('color'));
	$('.dropdown-menu li a').css('font-weight',$('.dropdown-menu>li>a').css('font-weight'));

	// gallery
	$('a[href$=".jpg"], a[href$=".jpeg"], a[href$=".gif"], a[href$=".png"]').attr('data-fancybox', 'separate').attr('data-caption',  $(this).find('img').attr('alt'));
	$('.gallery').each(function() {
	// set the rel for each gallery
		$(this).find('.gallery-icon a[href$=".jpg"], .gallery-icon a[href$=".jpeg"],.gallery-icon a[href$=".gif"], .gallery-icon a[href$=".png"]').attr('data-fancybox', 'group-' + $(this).attr('id')).fancybox({
			infobar : true,
			protect: true
		});
		$('.gallery-icon').each(function() {
			$(this).find('a').attr('data-caption',  $(this).find('a img').attr('alt'));
		})
	
	});

	//add class to woocommerce product categories
	$('.widget_product_categories .cat-item').addClass('panel box');

	$("#widgetModal").modal("show");

});