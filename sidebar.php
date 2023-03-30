<?php
/**
 * The sidebar for our theme
 *
 * This is the template that displays sidebar section
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 */
?>
<aside id="secondary" class="col-md-3 col-12 order-md-first pr-md-0">
	<div class="side-column">
		<?php
		if (is_single()||is_author()){ ?>
			<div class="author-info box">
				<span class="about-author"><?php echo esc_html__("About author","pcworms") ?></span>
				<?php echo get_avatar(get_the_author_meta( 'ID' ), 300);?>
				<span class="name"><?php echo get_the_author_meta('display_name')?></span>
				<div class="desc">
					<?php render_badges(get_the_author_meta('description'))?>
				</div>
			</div>
		<?php }
		if (is_active_sidebar( 'sidebar-1' ))
			dynamic_sidebar( 'sidebar-1' );
		?>
	</div>
</aside>
