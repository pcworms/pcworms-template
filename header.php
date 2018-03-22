<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<script type="text/javascript">
NProgress.start();
window.onload = function() {
	NProgress.done();
}
</script>
<div id="loading-bar"></div>
<a id="back-to-top" href="#" class="btn btn-default back-to-top" role="button" title="<?php esc_attr_e('Go to top', 'free-template'); ?>" data-toggle="tooltip" data-placement="top" >
	<span class="glyphicon glyphicon-chevron-up"></span>
</a>
<?php get_template_part( 'template-parts/part/popup-login' ); ?>
<?php get_template_part( 'template-parts/part/header-top-nav' ); ?>
<header id="masthead" class="site-header">
	<?php get_template_part( 'template-parts/part/header-carousel' ); ?>
	<?php get_template_part( 'template-parts/part/header-nav' ); ?>
</header><!-- #masthead -->
