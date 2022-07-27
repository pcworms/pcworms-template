<?php
if ( is_single() ) {
	
	wp_link_pages( array(
		'before'      => '<nav class="link-pages-nav"><ul class="pagination">',
		'after'       => '</ul></nav>',
		'next_or_number'	=> 'next_and_number',
		'nextpagelink'     => esc_html__( 'Next', 'pcworms' ),
		'previouspagelink' => esc_html__( 'Previous', 'pcworms' ),
	) );

}
