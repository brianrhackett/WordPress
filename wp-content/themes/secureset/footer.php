<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package __secureset
 */

$option_fields = get_fields( 'options' );
$lite_footer = get_field( 'lite_footer' );
$hide_cta = get_field( 'hide_footer_cta' );
$newsletter_description = get_field( 'footer_newsletter_description' );
$footer_bottom_links_override = get_field( 'footer_bottom_links_override' );
?>
		</div><!-- #content -->

		<footer id="footer" class="footer" <?php if ( $lite_footer ) { echo 'style="background-color: #000;"'; } ?> >
			<div class="container">
				<div class="footer__top">
					<?php if ( $lite_footer ) : ?>
						<?php
							if ( !empty( $option_fields['site_logo_full'] ) ) :
								echo wp_get_attachment_image( $option_fields['site_logo_full'], 'full', '', 'class=footer__logo' );
							else : ?>
								<img class="footer__logo" src="<?php echo get_stylesheet_directory_uri() . '/assets/img/logo.svg'; ?>" alt="<?php bloginfo( 'name' ); ?>" />
								<?php
							endif;
						?>
					<?php else: ?>
						<a href="<?php echo home_url(); ?>" class="footer__top--left">
							<?php
								if ( !empty( $option_fields['site_logo_full'] ) ) :
									echo wp_get_attachment_image( $option_fields['site_logo_full'], 'full', '', 'class=footer__logo' );
								else : ?>
									<img class="footer__logo" src="<?php echo get_stylesheet_directory_uri() . '/assets/img/logo.svg'; ?>" alt="<?php bloginfo( 'name' ); ?>" />
									<?php
								endif;
							?>
						</a>
					<?php endif; ?>

					<?php
						if (
							! empty( $option_fields['footer_top_ctas'] ) &&
							is_array( $option_fields['footer_top_ctas'] ) &&
							! $hide_cta
						) :
					?>
						<div class="footer__top--right">
							<?php
								$footer_ctas = $option_fields['footer_top_ctas'];
								foreach ( $footer_ctas as $key => $cta ) :
									$link_type = $cta['cta_type'];
									switch ( $link_type ) :
										case 'external' :
											$href = $cta['url'];
											break;
										case 'page' :
											$href = $cta['page_link'];
											break;
										case 'file' :
											$href = $cta['file'];
											break;
										default:
											$href = '#';
											break;
									endswitch;
									?>
									<a class="btn btn--light footer__cta" href="<?php echo esc_url( $href ); ?>"><?php echo esc_attr( $cta['cta_title'] ); ?></a>
									<?php
								endforeach;
							?>
						</div>
						<?php endif; ?>
				</div>

				<?php if ( ! $lite_footer ) : ?>
					<div class="footer__nav-mobile-primary footer__nav">
						<?php
							wp_nav_menu( array(
								'theme_location'	=> 'footer-menu-mobile-primary',
								'container'			=> false,
								'menu_class'		=> 'footer__nav--menu',
							) );
						?>
					</div>
				<?php endif; ?>

				<?php
					if ( ! empty( $option_fields['footer_content'] ) ||
						! empty( $option_fields['footer_form_intro_text'] ) ||
						! empty( $option_fields['footer_form_id'] ) ||
						has_nav_menu( 'footer-menu-mobile' ) ||
						has_nav_menu( 'footer-menu-desktop' ) ||
						! empty( $option_fields['facebook_link'] )||
						! empty( $option_fields['twitter_link'] ) ||
						! empty( $option_fields['youtube_link'] ) ||
						! empty( $option_fields['linkedin_link'] ) ) : ?>
						<?php if ( ! $lite_footer ) : ?>
							<div class="footer__nav footer__nav--mobile js-footer__nav--mobile">
								<?php
									wp_nav_menu( array(
										'theme_location'	=> 'footer-menu-mobile-more',
										'container'			=> false,
										'menu_class'		=> 'footer__nav--menu',
									) ); ?>
								<button class="footer__nav--show-more js-footer__nav--toggle"><span class="show-more">More</span><span class="show-less">Less</span><span class="footer__nav--caret"></span></button>
							</div>
						<?php endif; ?>
						<div class="footer__contact">
							<?php
								if ( $option_fields['footer_content'] ) : ?>
									<div class="footer__copy">
										<?php echo wp_kses_post( $option_fields['footer_content'] ); ?>
									</div>
									<?php
								endif;

								if (
									! empty( $option_fields['footer_form_intro_text'] ) ||
									$newsletter_description
								) :
							?>
									<div class="footer__copy">
										<?php if ( $newsletter_description ) : ?>
											<p><?php echo wp_kses_post( $newsletter_description ); ?></p>
										<?php elseif ( $option_fields['footer_form_intro_text'] ) : ?>
											<?php echo wp_kses_post( $option_fields['footer_form_intro_text'] ); ?>
										<?php endif; ?>
									</div>
									<?php
								endif;

								if ( function_exists( 'gravity_form' ) && !empty( $option_fields['footer_form_id'] ) ) :
									gravity_form( $option_fields['footer_form_id'], true, true, true, '', true, 9999, true );
								endif;
							?>

							<?php if (
								!empty( $option_fields['facebook_link'] )||
								!empty( $option_fields['twitter_link'] ) ||
								!empty( $option_fields['youtube_link'] ) ||
								!empty( $option_fields['linkedin_link'] ) ) : ?>
							<div class="footer__social">
								<ul>
									<?php if ( !empty( $option_fields['facebook_link'] ) ) : ?><li><a target="_blank" href="<?php echo esc_attr( $option_fields['facebook_link'] ); ?>"><span class="icon-facebook"></span></a></li><?php endif; ?>
									<?php if ( !empty( $option_fields['twitter_link'] ) ) : ?><li><a target="_blank"  href="<?php echo esc_attr( $option_fields['twitter_link'] ); ?>"><span class="icon-twitter"></span></a></li><?php endif; ?>
									<?php if ( !empty( $option_fields['youtube_link'] ) ) : ?><li><a target="_blank" href="<?php echo esc_attr( $option_fields['youtube_link'] ); ?>"><span class="icon-youtube"></span></a></li><?php endif; ?>
									<?php if ( !empty( $option_fields['linkedin_link'] ) ) : ?><li><a target="_blank" href="<?php echo esc_attr( $option_fields['linkedin_link'] ); ?>"><span class="icon-linkedin"></span></a></li><?php endif; ?>
								</ul>
							</div>
							<?php endif; ?>

							<div class="footer__badge">
								<?php if ( !empty( $option_fields['badge_logo'] ) ) : ?>
									<?php if ( !empty( $option_fields['badge_url'] ) ) : ?>
										<a href="<? echo $option_fields['badge_url'] ?>" target="_blank">
									<?php endif; ?>
											<?php echo wp_get_attachment_image( $option_fields['badge_logo'], 'full', '', 'class=footer__badge--logo' ); ?>
									<?php if ( !empty( $option_fields['badge_url'] ) ) : ?>
										</a>
									<?php  endif; ?>
								<?php endif; ?>
							</div>
						</div>
						<?php if ( ! $lite_footer ) : ?>
							<div class="footer__nav footer__nav--desktop">
								<div class="footer__nav--desktop-left footer-column">
									<?php
										wp_nav_menu( array(
											'theme_location' 	=> 'footer-menu-desktop-left',
											'container'			=> false,
											'menu_class'		=> 'footer__nav--menu-left',
											'walker'			=> new __secureset_walker_desktop_footer_nav
										) );
									?>
								</div>
								<div class="footer__nav--desktop-center footer-column">
									<?php
										wp_nav_menu( array(
											'theme_location' 	=> 'footer-menu-desktop-center',
											'container'			=> false,
											'menu_class'		=> 'footer__nav--menu-center',
											'walker'			=> new __secureset_walker_desktop_footer_nav
										) );
									?>
								</div>
								<div class="footer__nav--desktop-right-right footer-column">
									<?php
										wp_nav_menu( array(
											'theme_location' 	=> 'footer-menu-desktop-right',
											'container'			=> false,
											'menu_class'		=> 'footer__nav--menu-right',
											'walker'			=> new __secureset_walker_desktop_footer_nav
										) );
									?>
								</div>
							</div>
						<?php
						endif;
					endif;
				?>
			</div>
			<div class="footer__bottom">
				<div class="container">
					<div class="footer__bottom--left">
						<p class="footer__copyright"><?php _e( '&copy; ' . date( 'Y' ) . ' SecureSet. All rights reserved.', '__secureset' ); ?></p>
					</div>
					<div class="footer__bottom--right">
						<?php
							$footer_links = $option_fields['footer_bottom_links'];
							if (
								! empty( $footer_links ) &&
								is_array( $footer_links ) ||
								$footer_bottom_links_override
							) :
						?>
								<ul class="footer__bottom-links">
									<?php
										if ( $footer_bottom_links_override ) {
											$footer_links = $footer_bottom_links_override;
										}
										foreach ( $footer_links as $footer_link ): ?>
										<?php $link_type = $footer_link['link_type'];
										switch ( $link_type ) :
											case 'external' :
												$href = $footer_link['url'];
												break;
											case 'page' :
												$href = $footer_link['page_link'];
												break;
											case 'file' :
												$href = $footer_link['file'];
												break;
											default:
												$href = '#';
												break;
										endswitch; ?>
										<li><a href="<?php echo esc_attr( $href ); ?>"> <span><?php _e( $footer_link['link_title'], '__secureset' ); ?></span></a></li>
											<?php
										endforeach;
									?>
								</ul>
								<?php
							endif;
						?>
					</div>
				</div>
			</div>
		</footer>
	</div><!-- .mobile-menu-push -->
</div><!-- #page -->

<?php wp_footer(); ?>

<?php get_component( 'location-modal' ); ?>

</body>
</html>
