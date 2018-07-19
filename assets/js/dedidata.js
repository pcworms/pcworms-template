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

	$('.page-footer').css('color',$('.navbar-inverse .navbar-nav>li>a').css('color'));
	$('.page-footer a').css('color',$('.navbar-inverse .navbar-nav>li>a').css('color'));
	$('.dropdown-menu li a').css('font-weight',$('.dropdown-menu>li>a').css('font-weight'));
	$('.page-footer button').css('color',$('body').css('color'));
	$('.page-footer input').css('color',$('body').css('color'));
	$('.page-footer optgroup').css('color',$('body').css('color'));
	$('.page-footer select').css('color',$('body').css('color'));
	$('.page-footer textarea').css('color',$('body').css('color'));

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