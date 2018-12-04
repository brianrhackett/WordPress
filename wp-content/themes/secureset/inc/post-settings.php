<?php
function custom_excerpt_length( $length ) {
	//20 word excerpt
	return 20;
}

add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
