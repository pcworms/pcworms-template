<?php
/**
 * Template for displaying search forms
 */

?>

<?php $unique_id = esc_attr( uniqid( 'search-form-' ) ); ?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo $unique_id; // xss ok ?>">
	</label>
	<input type="search" id="<?php echo $unique_id; // xss ok ?>" class="search-field" placeholder="<?php esc_attr_e( 'Search &hellip;', 'free-template' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	<button type="submit" class="search-submit"><i class="fa fa-search" aria-hidden="true"></i></button>
</form>
