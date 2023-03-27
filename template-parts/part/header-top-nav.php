<?php
$attachments = get_uploaded_header_images();
if (has_nav_menu('primary') or get_theme_mod('display_login_link')) {
?>
	<div class="navbar-wrapper container">
		<nav id="top-menu" class="navbar navbar-expand-md navbar-dark">
			<a
			class="navbar-brand"
			href="<?php echo home_url(); // xss ok ?>"
			data-toggle="tooltip" data-placement="bottom"
			title="<?php bloginfo('name'); ?>"><i class="fa fa-lg fa-home" aria-hidden="true"></i></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#top-navbar-collapse" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div id="top-navbar-collapse" class="collapse navbar-collapse" aria-expanded="false">
				<?php
					wp_nav_menu(
						array(
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
			<?php get_template_part( "template-parts/part/header-searchform", ""); ?>
		</nav>
	</div>
<?php
} ?>