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
				<div class="col-xs-12 col-sm-3"><?php dynamic_sidebar( 'footer-column-1' ); ?></div>
				<div class="col-xs-12 col-sm-3"><?php dynamic_sidebar( 'footer-column-2' ); ?></div>
				<div class="col-xs-12 col-sm-3"><?php dynamic_sidebar( 'footer-column-3' ); ?></div>
				<div class="col-xs-12 col-sm-3"><?php dynamic_sidebar( 'footer-column-4' ); ?></div>
			</div>
		</div>
		<?php get_template_part( 'template-parts/part/bottom-nav' ); ?>
		<div class="footer-bottom">
			<div class="container">
				<div class="pull-left col-xs-12 col-sm-6">
					<a href="<?php echo esc_url( __('https://dedidata.com', 'free-template') ); ?>" title="<?php esc_attr_e('Web Design by DediData', 'free-template'); ?>" target="_blank">
						<img width="25" height="25" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/' . ((get_locale()==='fa_IR') ? 'pm' : 'dd') . 'logo.png'; // xss ok ?>" alt="<?php esc_attr_e('Web Design by DediData', 'free-template'); ?>" />
					</a>
				</div>
				<div class="pull-right col-xs-12 col-sm-6">
					<p><?php echo esc_html( __('Copyright', 'free-template') . ' &copy; ' . date('Y ') . get_bloginfo( 'name' ) . '. ' .  __('All right reserved.', 'free-template') ); ?></p>
				</div>
			</div>
		</div>
	</footer>
	<?php wp_footer(); ?>
</body>
</html>