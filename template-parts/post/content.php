<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

?>
<div data-aos="fade-left" class = "container-fluid post-container">
	<?php 
	if (!is_single() && !is_author()){
		$ID = get_the_author_meta( 'ID' );
		echo '<a class="author-avatar" title = "'. get_the_author_meta("display_name") . '" href = "' . get_author_posts_url($ID) . '">'. get_avatar($ID, 50) . '</a>'; 
	}?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'panel box' . (is_single()||is_author() ? ' noavatar' : '') ); ?>>
		<?php get_template_part( 'template-parts/part/entry-header' ); ?>

		<div class="entry-content panel-body">
		<?php get_template_part( 'template-parts/part/entry-featured' ); ?>
		<?php
			/* translators: %s: Name of current post */
			the_content( '<button class="continue-read btn dark-red"><span class="fa fa-eye"></span> ' . esc_html__( 'Continue reading', 'pcworms' ) . '</button>');
		
			get_template_part( 'template-parts/part/entry-pagination' ); ?>
		
		</div><!-- .entry-content -->

		<div>
			<?php get_template_part( 'template-parts/part/entry-footer' ); ?>
		</div>
	</article><!-- #post-## -->
</div>
<?php

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
