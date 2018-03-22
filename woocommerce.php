<?php
/**
 * The woocommerce template file
 */
?>
 
<?php get_header(); ?>
<main id="main" class="site-main">
	<div class="container"><?php
		if ( is_active_sidebar( 'sidebar-1' ) ) { ?>
		<div class="row"><?php
		} ?>
			<div id="primary" class="site-content content-area col-xs-12<?php if( is_active_sidebar( 'sidebar-1' ) ) { echo ' pull-right col-sm-9'; } ?>">
				<div class="wc-content panel box">
					<?php woocommerce_content(); ?>
				</div>
			</div><?php

			if ( is_active_sidebar( 'sidebar-1' ) ) {
				get_sidebar();
			}

		if ( is_active_sidebar( 'sidebar-1' ) ) { ?>
		</div>
		<?php } ?>
	</div>
</main><!-- .site-main -->
<?php
get_footer();
