<?php
/**
 * The main template file
 */
?>
 
<?php get_header();
$sidebar_condition = is_active_sidebar( 'sidebar-1' ); ?>
<main id="main" class="site-main">
	<div class="container"><?php
		if ( $sidebar_condition ) { ?>
		<div class="row"><?php
		} ?>
			<div id="primary" class="site-content content-area col-xs-12<?php if( $sidebar_condition ) { echo ' pull-right col-sm-9'; } ?>"><?php
			
			if(is_home() or is_front_page()){
				dynamic_sidebar( 'frontend-content-top' );
			}
			dynamic_sidebar( 'content-top' );
			
			if ( have_posts() ) {

				/* Start the Loop */
				while ( have_posts() ) {
					the_post();
					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'template-parts/post/content', get_post_format() );
				}

				Free_Template::posts_pagination( array(
					'prev_text' => '<span >' . esc_html__( 'Previous', 'pcworms' ) . '</span>',
					'next_text' => '<span>' . esc_html__( 'Next', 'pcworms' ) . '</span>',
					'type'						=> 'list',
					'end_size'					=> 3,
					'mid_size'					=> 3,
				) );

			}
			
			if(is_home() or is_front_page()){
				dynamic_sidebar( 'frontend-content-bottom' );
			}
			dynamic_sidebar( 'content-bottom' );
			
			?>
			</div><?php

			if ( $sidebar_condition ) {
				get_sidebar();
			}

		if ( $sidebar_condition ) { ?>
		</div>
		<?php } ?>
	</div>
</main><!-- .site-main -->
<?php
get_footer();
