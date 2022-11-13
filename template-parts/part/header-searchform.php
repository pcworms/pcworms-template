<?php
/**
 * Template for displaying search forms
 */

?>

<?php $unique_id = esc_attr( uniqid( 'search-form-' ) ); ?>

<form role="search" method="get" class="form-inline flex-nowrap nav-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo $unique_id; // xss ok ?>">
	</label>
	<input type="search" id="<?php echo $unique_id; // xss ok ?>" class="form-control search-field ml-sm-2 ml-0" placeholder="<?php esc_attr_e( 'Search &hellip;', 'pcworms' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	<button type="submit" class="btn btn-outline-success search-submit"><i class="fa fa-search" aria-hidden="true"></i></button>
</form>
