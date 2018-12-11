<?php
/**
 * __secureset functions and definitions
 *
 * @package __secureset
 */

define( 'ASSETS_VERSION', '1.3.20' );
define( 'GLOBAL_LIB_VERSION', '1.3.20' );

if ( ! function_exists( '__theme_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function __theme_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on this, use a find and replace
	 * to change '__secureset' to the name of your theme in all the template files
	 */
	load_theme_textdomain( '__secureset', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Desktop Menu', '__secureset' ),
		'primary-more' => esc_html__( 'Primary Desktop Menu More', '__secureset' ),
		'primary-mobile' => esc_html__( 'Primary Mobile Menu', '__secureset' ),
		'footer-menu-desktop-left' => __( 'Footer Primary Menu Left' ),
		'footer-menu-desktop-center' => __( 'Footer Primary Menu Center' ),
		'footer-menu-desktop-right' => __( 'Footer Primary Menu Right' ),
		'footer-menu-mobile-primary' => __( 'Footer Mobile Menu' ),
		'footer-menu-mobile-more' => __( 'Footer Mobile Menu More' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
	) );


	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( '__theme_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // __secureset_setup
add_action( 'after_setup_theme', '__theme_setup' );

/**
 * Enqueue scripts and styles.
 */
function __theme_enqueue() {

	// Query for the program landing page and pass the permalink to js
	$args = array(
		'post_type'  => 'page',
		'meta_query' => array(
			array(
				'key'   => '_wp_page_template',
				'value' => 'templates/template-program-landing.php'
			)
		)
	);
	$program_landing_page = get_posts( $args );
	$program_landing_page_permalink = get_permalink( current($program_landing_page) );

	// This array is localized for our __secureset-site-scripts
	$script_data = array(
		'stylesheetDirURI' => get_stylesheet_directory_uri(),
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'programLandingPagePath' => parse_url( $program_landing_page_permalink )['path'],
		'gfSfId' => (int)get_field( 'gf_sf_form_id', 'options' )
	);

	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		wp_enqueue_style( '__secureset-style', get_stylesheet_directory_uri() . '/assets/build/styles.css', array(), ASSETS_VERSION );
		wp_register_script( '__secureset-vendor-scripts', get_template_directory_uri() . '/assets/build/vendor.bundle.js', array( 'jquery', 'jquery-ui-widget' ), GLOBAL_LIB_VERSION, true );
		wp_register_script( '__secureset-site-scripts', get_template_directory_uri() . '/assets/build/site.bundle.js', array( 'jquery', '__secureset-vendor-scripts' ), ASSETS_VERSION, true );
	} else {
		wp_enqueue_style( '__secureset-style', get_template_directory_uri() . '/assets/dist/styles.min.css', array(), ASSETS_VERSION );
		wp_register_script( '__secureset-vendor-scripts', get_template_directory_uri() . '/assets/dist/vendor.bundle.min.js', array( 'jquery', 'jquery-ui-widget' ), GLOBAL_LIB_VERSION, true );
		wp_register_script( '__secureset-site-scripts', get_template_directory_uri() . '/assets/dist/site.bundle.min.js', array( 'jquery', '__secureset-vendor-scripts' ), ASSETS_VERSION, true );
	}
	wp_localize_script( '__secureset-site-scripts', 'scriptData', $script_data );
	wp_enqueue_script( '__secureset-site-scripts' );
	wp_enqueue_script( '__secureset-vendor-scripts' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', '__theme_enqueue', 11 );

/**
 * Include Voltage Components Package and ACF
 */
require get_template_directory() . '/inc/components.php';
require get_template_directory() . '/acf/acf-include.php';
require get_template_directory() . '/acf-functions.php' ;


/**
 * Include compiled ACF fields if ACF is installed
 */
function __theme_acf() {
	function get_ID_by_slug( $page_slug ) {
		$page = get_page_by_path( $page_slug );
		if ( $page ) {
			return $page->ID;
		} else {
			return null;
		}
	}
	require get_template_directory() . '/inc/compiled-acf.php';
}
add_action( 'acf/init', '__theme_acf' );

function my_redirector() {
	if(is_front_page() && is_user_logged_in()) {
		wp_redirect(home_url( '/dashboard/' ));
		exit();
	}
}
add_action('template_redirect', 'my_redirector');

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom data
 */
require get_template_directory() . '/inc/custom-data.php';

/**
 * Program data and taxonomies
 */
require get_template_directory() . '/inc/programs.php';

/**
 * Load up custom post types
 */
require get_template_directory() . '/inc/custom-post-types.php';

/**
 * Custom Footer Nav Walker
 */
require get_template_directory() . '/inc/footer-nav-walker.php';

/**
 * Gravity Forms Customizations
 */
require get_template_directory() . '/inc/gravity-forms.php';
require get_template_directory() . '/inc/gravity-forms-salesforce.php';

/**
 * Image Caption Fix
 */
require get_template_directory() . '/inc/image-caption.php';

/**
 * Custom ACF Icon Fonts
 */
require get_template_directory() . '/inc/icon-font-acf.php';

/**
 * Post Settings
 */
require get_template_directory() . '/inc/post-settings.php';

/**
 * Template caching bug fix
 */
require get_template_directory() . '/inc/template-file-caching-fix.php';

/**
 * Include custom user roles
 */
require get_template_directory() . '/inc/custom-user-roles.php';

/**
 * News archive functionality
 */
require get_template_directory() . '/inc/news.php';

/**
 * Security provisions go in here
 */
require get_template_directory() . '/inc/security.php';

/**
 * LearnDash Customizations go in here
 */
require get_template_directory() . '/inc/custom-learndash.php';

