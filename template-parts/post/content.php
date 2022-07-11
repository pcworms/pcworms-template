<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

?>
<div class = "container-fluid post-container">
	<?php echo get_avatar(get_the_author_meta( 'ID' ), 50);?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'panel box' ); ?>>
		<?php get_template_part( 'template-parts/part/entry-header' ); ?>

		<div class="entry-content panel-body">
		<?php get_template_part( 'template-parts/part/entry-featured' ); ?>
		<?php
			/* translators: %s: Name of current post */
			the_content( '<button class="continue-read btn dark-red"><span class="fa fa-eye"></span> ' . esc_html__( 'Continue reading', 'free-template-pcworms' ) . '</button>');
		
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
