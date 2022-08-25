<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 */

?>

<?php
// Social media preview
$title = is_front_page() ? get_bloginfo( 'name' ) : get_the_title().'|'.get_bloginfo( 'name' );
$image = "";
$desc = "";
if (is_single()){
	$image = get_the_post_thumbnail_url();
	$desc = wp_strip_all_tags( get_the_excerpt(), true );
}
if ($image==""){
	$custom_logo_id = get_theme_mod( 'custom_logo' );
    $image = wp_get_attachment_image_src( $custom_logo_id , 'full' )[0];
}
if ($desc=="")
	$desc = get_bloginfo('description');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head prefix="og: https://ogp.me/ns#">
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" >
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<meta property="og:title" content="<?php echo $title?>">
    <meta property="og:image" content="<?php echo $image?>">
	<meta property="og:description" content="<?php echo $desc?>">
<?php wp_head(); ?>
</head>
<body <?php body_class('line-numbers'); ?>>
<script type="text/javascript">
NProgress.start();
window.onload = function() {
	NProgress.done();
}
</script>
<div id="loading-bar"></div>
<a id="back-to-top" href="#" class="btn btn-default back-to-top" role="button" title="<?php esc_attr_e('Go to top', 'pcworms'); ?>" data-toggle="tooltip" data-placement="top" >
	<span class="glyphicon glyphicon-chevron-up"></span>
</a>
<?php get_template_part( 'template-parts/part/popup-login' ); ?>
<?php get_template_part( 'template-parts/part/header-top-nav' ); ?>
<?php get_template_part( 'template-parts/part/header-carousel' ); ?>
