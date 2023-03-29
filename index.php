<?php
/**
 * The main template file
 */
?>
<?php 
get_header();
	$grid = !is_single() || !is_front_page();
	if(!is_author())
		the_archive_description('<div class="text-justify">', '</div>');
	$sidebar_condition = is_active_sidebar( 'sidebar-1' ) || is_single() || is_author() ; ?>
	<main id="main" class="row site-main <?php (is_single()?'single':'') ?>">
		<div id="primary" class="site-content content-area <?php if ($sidebar_condition) echo 'col-md-9 order-md-last pl-0'?> col-12"><?php
				
			if(is_home() or is_front_page()){
				dynamic_sidebar( 'frontend-content-top' );
			}
			dynamic_sidebar( 'content-top' );
			
			?><div class = "row <?php if ($grid):?> posts-grid<?php endif; ?> mx-auto post-container"><?php
			if ( have_posts() ) {
				/* Start the Loop */
				$post_counter = 0;
				while ( have_posts() ) {
					the_post();
					/*
					* Include the Post-Format-specific template for the content.
					* If you want to override this in a child theme, then include a file
					* called content-___.php (where ___ is the Post Format name) and that will be used instead.
					*/
					get_template_part( 'template-parts/post/content', get_post_format(), array('post_counter' => $post_counter, 'grid'=>$grid));
					$post_counter++;
				}
				?></div><div class="row"><?php
				Free_Template::posts_pagination( array(
					'prev_text' => '<span >' . esc_html__( 'Previous', 'pcworms' ) . '</span>',
					'next_text' => '<span>' . esc_html__( 'Next', 'pcworms' ) . '</span>',
					'type'						=> 'list',
					'end_size'					=> 3,
					'mid_size'					=> 3,
				) );

			}
			?></div><?php
			if(is_home() or is_front_page()){
				dynamic_sidebar( 'frontend-content-bottom' );
			}
			dynamic_sidebar( 'content-bottom' );
			
			?>
		</div>
		<?php
			if ( $sidebar_condition) {
				get_sidebar();
			}
		?>
	</main><!-- .site-main test-->
<?php
get_footer();
?>