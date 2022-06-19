<?php
$attachments = get_uploaded_header_images();
if (has_nav_menu('primary') or get_theme_mod('display_login_link')) {
?>
	<!--nav class="megamenu navbar navbar-default navbar-toggleable-md navbar-fixed-top navbar-inverse bg-inverse  navbar-toggleable-md navbar-light"-->
	<div class="navbar-wrapper">
		<div class="container">
			<nav id="top-menu" class="navbar navbar-static-top">
				<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#top-navbar-collapse" aria-expanded="false" aria-controls="#top-menu">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="<?php echo home_url(); // xss ok 
														?>" data-toggle="tooltip" data-placement="bottom" title="<?php bloginfo('name'); ?>"><i class="fa fa-lg fa-home" aria-hidden="true"></i></a>
					</div>
					<div id="top-navbar-collapse" class="collapse navbar-collapse" aria-expanded="false"><?php
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
				</div>
			</nav>
		</div>
	</div>
<?php
} ?>
<?php /*
$attachments = get_uploaded_header_images();
if (has_nav_menu('primary') or get_theme_mod('display_login_link')) {
?>
	<!--nav class="megamenu navbar navbar-default navbar-toggleable-md navbar-fixed-top navbar-inverse bg-inverse  navbar-toggleable-md navbar-light"-->
	<nav id="top-menu" class="megamenu navbar navbar-default navbar-fixed-top navbar-inverse bg-inverse">
		<div class="container">
			<div class="row">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#top-navbar-collapse" aria-expanded="false" aria-controls="top-menu">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?php echo home_url(); // xss ok 
													?>" data-toggle="tooltip" data-placement="bottom" title="<?php bloginfo('name'); ?>"><i class="fa fa-lg fa-home" aria-hidden="true"></i></a>
				</div>
				<div id="top-navbar-collapse" class="collapse navbar-collapse"><?php
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
					<ul id="top-menu-side" class="nav navbar-nav navbar-right">
						<?php
						if (get_theme_mod('display_login_link')) {
							$login_link_texts = Free_Template::login_link_texts();
						?>
							<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" class="menu-item pull-right" id="login-menu-item">
								<a data-toggle="modal" title="<?php echo $login_link_texts[get_theme_mod('login_link_text')]; // xss ok 
																?>" id="login-button" data-target="#myModal" aria-haspopup="true" role="button"><i class="fa fa-lg fa-user"></i>&nbsp;<?php echo $login_link_texts[get_theme_mod('login_link_text')]; // xss ok 
																																																																?></a>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
	</nav>
<?php } */?>