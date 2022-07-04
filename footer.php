<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */
?>
	<footer class="page-footer navbar-inverse text-warning">
		<div class="container">
			<div class="row">            
				<div class="footer-widget col-xs-12 col-sm-3"><?php dynamic_sidebar( 'footer-column-1' ); ?></div>
				<div class="footer-widget col-xs-12 col-sm-3"><?php dynamic_sidebar( 'footer-column-2' ); ?></div>
				<div class="footer-widget col-xs-12 col-sm-3"><?php dynamic_sidebar( 'footer-column-3' ); ?></div>
				<div class="footer-widget col-xs-12 col-sm-3"><?php dynamic_sidebar( 'footer-column-4' ); ?></div>
			</div>
		</div>
		<?php get_template_part( 'template-parts/part/bottom-nav' ); ?>
		<?php /*<div class="footer-bottom">
			<div class="container">
				<?php if(is_front_page()){ ?>
				<div class="pull-left col-xs-12 col-sm-6">
				</div>
				<?php } ?>
				<div class="pull-right col-xs-12 col-sm-6">
					<p><?php echo esc_html( __('Copyright', 'free-template-pcworms') . ' &copy; ' . date('Y ') . get_bloginfo( 'name' ) . '. ' .  __('All right reserved.', 'free-template-pcworms') ); ?></p>
				</div>
			</div>
		</div>*/?>
	</footer>
	<?php wp_footer(); ?>
</body>
</html>