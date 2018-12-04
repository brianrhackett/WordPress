<?php

function remove_gravityforms_style() {
	wp_deregister_style( 'gforms_formsmain_css' );
	wp_deregister_style( 'gforms_reset_css' );
	wp_deregister_style( 'gforms_ready_class_css' );
	wp_deregister_style( 'gforms_browsers_css' );
}
add_action( 'gform_enqueue_scripts', 'remove_gravityforms_style' );

?>
