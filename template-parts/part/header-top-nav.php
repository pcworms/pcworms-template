<?php
$attachments = get_uploaded_header_images();
if (has_nav_menu( 'primary' ) or get_theme_mod('display_login_link')){
?>
<!--nav class="megamenu navbar navbar-default navbar-toggleable-md navbar-fixed-top navbar-inverse bg-inverse  navbar-toggleable-md navbar-light"-->
<div class="navbar-wrapper">
	<div class="container">
		<nav id="top-menu" class="navbar navbar-static-top">
			<div class="container">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
				<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#top-navbar-collapse" aria-expanded="false" aria-controls="top-menu">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo home_url(); // xss ok ?>" data-toggle="tooltip" data-placement="bottom" title="<?php bloginfo('name'); ?>"><i class="fa fa-lg fa-home" aria-hidden="true"></i></a>
				</div>
				<div id="navbar" class="collapse navbar-collapse"><?php
					wp_nav_menu( array(
						'theme_location'		=> 'primary',
						'depth'					=> 3,
						'menu_class'			=> 'nav navbar-nav megamenu',
						'menu_id'				=> '',
						'container'				=> '',
						'container_class'	=> '',
						'container_id'			=> '',
						'fallback_cb'			=> 'WP_Bootstrap_Navwalker::fallback',
						'walker'					=> new WP_Bootstrap_Navwalker(),
						)
					); ?>
				</div>
			</div>
		</nav>
	</div>
</div>
<?php
}
