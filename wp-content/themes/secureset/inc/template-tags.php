<?php
/**
 * Custom template tags for this theme go here
 *
 * @package __secureset
 */
function get_foundation_menu( $menu_location_slug ) {
	if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_location_slug ] ) ) {
		$menu = wp_get_nav_menu_object( $locations[ $menu_location_slug ] );
		$menu_items = wp_get_nav_menu_items( $menu->term_id );
		$menu_list .= "\t\t\t\t". '<ul>' ."\n";
		foreach ( (array) $menu_items as $key => $menu_item ) {
			if ( $menu_item->men_item_parent ) {

			} else {
				$title = $menu_item->title;
				$url = $menu_item->url;
				$menu_list .= "\t\t\t\t\t". '<li><a href="'. $url .'">'. $title .'</a></li>' ."\n";
			}

		}
		$menu_list .= "\t\t\t\t". '</ul>' ."\n";
	} else {
		$menu_list = '<!-- ' . $menu_location_slug . ' not found -->';
	}
	echo $menu_list;
}

function print_nice( $input ) {
	echo '<pre>';
	print_r( $input );
	echo '</pre>';
}

function tribe_check_current_month( $day_of_month ) {
	if ( $day_of_month === current_time( 'F' ) ) {
		return true;
	} else {
		return false;
	}
}

function tribe_check_current_day_of_week( $day_of_week ) {
	$current_timestamp = strtotime( tribe_get_month_view_date() );
	if ( $day_of_week === current_time( 'l' ) && current_time( 'F', $current_timestamp ) === current_time( 'F' ) ) {
		return true;
	} else {
		return false;
	}
}

// Generates share links for current post
function share_links() {
	return '<ul>' . "\r\n"
		. '<li><a href="http://www.facebook.com/sharer/sharer.php?u=' . get_the_permalink() . '&title=' . urlencode( get_the_title() ) . '" target="_blank" onclick="window.open(this.href, \'mywin\',\'left=20,top=20,width=500,height=500,toolbar=1,resizable=0\'); return false;"><span class="icon icon-facebook"></span></a></li>' . "\r\n"
		. '<li><a href="http://twitter.com/intent/tweet?status=' . urlencode( get_the_title() ) . '+' . get_the_permalink() . '" target="_blank"><span class="icon icon-twitter" target="_blank"></span></a></li>' . "\r\n"
		. '<li><a href="http://www.linkedin.com/shareArticle?mini=true&url=' . get_the_permalink() . '&title=' . urlencode( get_the_title() ) . '&source=' . $_SERVER['HTTP_HOST'] . '" target="_blank" onclick="window.open(this.href, \'mywin\',\'left=20,top=20,width=500,height=500,toolbar=1,resizable=0\'); return false;"><span class="icon icon-linkedin"></span></a></li>' . "\r\n"
		. '</ul>';
}

// Gets the current location ID
function get_current_location_id() {
	if ( isset( $_COOKIE['secureset_location'] ) ) {
		return (int)$_COOKIE['secureset_location'];
	} else {
		return false;
	}
}

function is_program_landing_page() {
	if ( is_page_template( 'templates/template-program-landing.php' ) ) {
		return true;
	} else {
		return false;
	}
}

// This function accepts WYSIWYG content and strips out the p tags that Wordpress likes to add on images
function filter_ptags_on_image( $content ) {
	return preg_replace( '/<p>(\s*)(<img .* \/>)(\s*)<\/p>/iU', '\2', $content );
}

// This function accepts WYSIWYG content and wraps the content of h1 tags in a span tag for proper styling
function add_span_inside_h1( $content ){
	return preg_replace( '/(<h1.*>)(.*)<\/h1>/Us', '$1<span>$2</span></h1>', $content );
}
