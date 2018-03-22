<?php

if ( has_post_thumbnail() ) { ?>
<div class="featured-image" data-aos="fade"><?php
	$featured_image_array = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
	if ( ! is_single() ) { ?>
	<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php
	} ?>
		<img class="entry-header-image" src="<?php echo esc_url($featured_image_array[0]); ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>" /><?php
	if ( ! is_single() ) { ?>
	</a><?php
	} ?>
</div><?php
}
