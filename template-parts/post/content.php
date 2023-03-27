<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

?>

<?php if (!is_home() && !is_front_page()): ?>
	<div class="row no-gutters">
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
<?php else: 
	
	$ID = get_the_author_meta( 'ID' );?>
	<div class="card" onclick="window.location = '<?php echo esc_url( get_permalink() ); ?>'">
		<div class="card-img-top ">
			<?php if ( has_post_thumbnail() ):?>
				<?php
				$featured_image_array = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
				$alt_tag_value = trim( strip_tags( get_post_meta( get_post_thumbnail_id( $post->ID ), '_wp_attachment_image_alt', true ) ) );?>

				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
					<img class="post-image" src="<?php echo esc_url($featured_image_array[0]); ?>" title="<?php the_title_attribute(); ?>" alt="<?php echo esc_attr($alt_tag_value); ?>" >
				</a>
			<?php else:?>
				<div class="post-summary"></div>
			<?php endif?>
		</div>
		<div class="card-body row no-gutters m-1">
			<div class="col-2">
				<a class="author-avatar" <?php echo ' title = "'. get_the_author_meta("display_name") . '" href = "' . get_author_posts_url($ID) .'"';?> >
					<?php echo get_avatar($ID, 40); ?>
				</a>
			</div>
			<div class="col-10">
				<?php the_title( '<h4 class="card-title">' . $icons . '<a href="' . esc_url( get_permalink() ) . '" title="' . esc_attr(get_the_title()) . '" rel="bookmark">', '</a></h4>' ); ?>
				<p class="card-text"><small class="text-muted"><span class="author-name"><?php echo get_the_author_meta("display_name"); ?></span> &bull; <span class="date"><?php the_date('d-m-Y')?></span></small></p>
			</div>
		</div>
	</div>
<?php endif; ?>
<?php

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
