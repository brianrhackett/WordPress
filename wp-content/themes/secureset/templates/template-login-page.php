<?php
 /**
 * Template Name: Login Page
 *
 * @package __secureset
 */

get_header(); 
?>

<div id="primary" class="content-area custom-page-background" style="background-image:url( '<?php the_field( 'page-background-image' ); ?>' ); background-color:<?php the_field( 'page-background-color' ); ?> " >
	<main id="main" class="site-main" role="main">
		<div class="login-container">
		<?php 
			$args = array(
				'redirect' => site_url(), 
				'form_id' => 'loginform-custom',
				'label_username' => __( 'Email' ),
				'label_password' => __( 'Password' ),
				'label_remember' => __( 'Remember Me' ),
				'label_log_in' => __( 'Log In' ),
				'remember' => true
			);
			wp_login_form($args); 
		?>
		</div>
	</main>
</div>