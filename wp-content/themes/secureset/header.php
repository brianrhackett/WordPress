<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package __secureset
 */
 
?><!DOCTYPE html>
<!--[if lte IE 8]> <html class="no-js lt-ie10 lt-ie9 oldie" <?php language_attributes() ?>> <![endif]-->
<!--[if IE 9]> <html class="no-js lt-ie10 oldie" <?php language_attributes() ?>> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" <?php language_attributes() ?>> <!--<![endif]-->
<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri().'/bootstrap.css' ; ?>">
	<script src="//use.typekit.net/csp6ape.js"></script>
	<script>try{Typekit.load();}catch(e){}</script>
	<?php wp_head(); ?>

</head>

<?php
	// Hide nav when page-builder "hide nav" hero is present on page
	$page_builder = get_field( 'main_page_builder' );
	$nonav_class = '';
	$show_nav = true;
	if( is_array( $page_builder ) ) :
		foreach ( $page_builder as $key => $component ) :
			if ( isset( $page_builder[ $key ]['hero_type'] ) && $page_builder[ $key ]['hero_type'] === 'hero-nonav' ) :
				$show_nav = false;
				$nonav_class = 'nonav-hero';
			endif;
		endforeach;
	endif;
?>

<body <?php body_class( array( $nonav_class ) ); ?>>

<div id="page" class="hfeed site">
	<?php if ( $show_nav ) : ?>
		<header id="masthead" class="site-header" role="banner">

			<div id="js-header-sticky-wrap" class="site-header__wrap">
				<div class="site-header__wrap-container">
					<div class="site-header__logo">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
							<?php $main_logo = get_field( 'site_logo_full', 'option' ); ?>
							<?php if ( $main_logo ): ?>
								<?php $logo_url = wp_get_attachment_image_src( $main_logo, 'full' )[0]; ?>
								<img src="<?php echo $logo_url; ?>" alt="<?php bloginfo( 'name' ); ?>" />
							<?php else: ?>
								<img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/logo.svg'; ?>" alt="<?php bloginfo( 'name' ); ?>" />
							<?php endif; ?>
						</a>
					</div>

					<nav class="site-header__desktop-nav">
						<?php
							$args = array(
								'theme_location' => 'primary',
								'menu_class'	 => 'dropdown menu',
								'items_wrap'	 => '<ul id="%1$s" class="%2$s" data-dropdown-menu>%3$s</ul>'
							);
							wp_nav_menu( $args );
						?>
					</nav>

					<button id="js-hamburger-mobile" class="hamburger hamburger--squeeze  site-header__hamburger-mobile">
						<span class="hamburger__box">
							<span class="hamburger__inner"></span>
						</span>
					</button>

				</div>
			</div>
		</header>

		<nav class="mobile-nav">
			
			<?php echo wp_nav_menu( array( 'theme_location' => 'primary-mobile' ) ); ?>
			<a class="mobile-nav__student-login btn--light btn" href="<?php the_field( 'student_login', 'option'); ?>" target="_blank">
				<?php _e( 'Student Login', '__secureset' ); ?>
			</a>
			<div class="mobile-nav__social-icons">
				<?php if ( $facebook_link = get_field( 'facebook_link', 'option' ) ): ?>
					<a class="icon-facebook" href="<?php echo $facebook_link; ?>" target="_blank"></a>
				<?php endif; ?>
				<?php if ( $twitter_link = get_field( 'twitter_link', 'option' ) ): ?>
					<a class="icon-twitter" href="<?php echo $twitter_link; ?>" target="_blank"></a>
				<?php endif; ?>
				<?php if ( $youtube_link = get_field( 'youtube_link', 'option' ) ): ?>
					<a class="icon-youtube" href="<?php echo $youtube_link; ?>" target="_blank"></a>
				<?php endif; ?>
				<?php if ( $linkedin_link = get_field( 'linkedin_link', 'option' ) ): ?>
					<a class="icon-linkedin" href="<?php echo $linkedin_link; ?>" target="_blank"></a>
				<?php endif; ?>
			</div>
			<div class="mobile-nav__overlay"></div>
		</nav>

		<div class="mobile-menu-mask"></div>
	<?php endif; ?>
	<div class="mobile-menu-push">

		<div id="content" class="site-content clearfix">
