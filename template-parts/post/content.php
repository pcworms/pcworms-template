<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

?>
<div <?php if (is_home() or is_front_page()) echo "data-aos='fade-left'"; ?> class = "container post-container">
	<div class="row">
		<?php 
		if (!is_single() && !is_author()){
			?>
			<div class="col-2 col-md-1 d-none d-sm-block"><?php
			$ID = get_the_author_meta( 'ID' );
			echo '<a class="author-avatar" title = "'. get_the_author_meta("display_name") . '" href = "' . get_author_posts_url($ID) . '">'. get_avatar($ID, 50) . '</a>'; 
			?>
			</div><div class="col-12 col-sm-10 col-md-11">
			<?php
		}else{?>
			<div class="col-12">
		<?php }?>
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
	</div>
</div>
<?php

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
