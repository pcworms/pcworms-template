<?php
/**
 * The archive template file
 */
 ?>
<?php get_header(); ?>
<main id="main" class="site-main">
	<div class="container"><?php
		if ( is_active_sidebar( 'sidebar-1' ) ) { ?>
		<div class="row"><?php
		} ?>
			<div id="primary" class="site-content content-area col-xs-12<?php if( is_active_sidebar( 'sidebar-1' ) ) { echo ' pull-right col-sm-9'; } ?>"><?php
			
			dynamic_sidebar( 'content-top' );
			if (is_category()) {
				$title = single_cat_title('', false);
			} elseif (is_tag()) {
				$title = single_tag_title('', false);
			} elseif (is_author()) {
				$title = '<span class="vcard">' . get_the_author() . '</span>';
			} elseif (is_tax()) { //for custom post types
				$title = sprintf(__('%1$s'), single_term_title('', false));
			} elseif (is_post_type_archive()) {
				$title = post_type_archive_title('', false);
			}
			?>
			<h1 class="text-center"><?php echo esc_html($title); ?></h1>
			<?php
			the_archive_description('<div class="text-justify">', '</div>');

			if ( have_posts() ) {
			?>
			
				<div class="panel-group" id="accordion">
				<?php

				/* Start the Loop */
				while ( have_posts() ) {
					the_post();
					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'template-parts/post/content', get_post_format() );
				} ?>
				</div>
				<?php
				Free_Template::posts_pagination( array(
					'prev_text' => '<span>' . esc_html__( 'Previous', 'pcworms' ) . '</span>',
					'next_text' => '<span>' . esc_html__( 'Next', 'pcworms' ) . '</span>',
					'type'						=> 'list',
					'end_size'					=> 3,
					'mid_size'					=> 3,
				) );
			}
			?>
			<?php dynamic_sidebar( 'content-bottom' ); ?>
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
