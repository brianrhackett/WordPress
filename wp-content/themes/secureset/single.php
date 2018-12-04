<?php
/**
 * The template for displaying all single posts.
 *
 * @package __secureset
 */

get_header(); ?>

<div id="primary" class="content-area custom-page-background" style="background-image:url( '<?php the_field( 'page-background-image' ) ?>' ); background-color:<?php the_field( 'page-background-color' )?>; " >
	<main id="main" class="site-main single-news" role="main">
		<div class="single-news__back">
			<a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>" class="single-news__back-anchor container back-arrow"><?php _e( 'Back To All News Posts', '__secureset' ); ?></a>
		</div>
		<div class="container">
			<?php while ( have_posts() ) : the_post(); ?>
				<h1 class="single-news__title"><span><?php the_title(); ?></span></h1>
				<div class="single-news__social social-links">
					<p><?php _e( 'Follow Us:', '__secureset' ); ?></p>
					<?php $option_fields = get_fields( 'options' ); ?>
					<ul>
						<?php if ( !empty( $option_fields['facebook_link'] ) ) : ?><li><a href="<?php echo esc_attr( $option_fields['facebook_link'] ); ?>"><span class="icon icon-facebook"></span></a></li><?php endif; ?>
						<?php if ( !empty( $option_fields['twitter_link'] ) ) : ?><li><a href="<?php echo esc_attr( $option_fields['twitter_link'] ); ?>"><span class="icon icon-twitter"></span></a></li><?php endif; ?>
						<?php if ( !empty( $option_fields['youtube_link'] ) ) : ?><li><a href="<?php echo esc_attr( $option_fields['youtube_link'] ); ?>"><span class="icon icon-youtube"></span></a></li><?php endif; ?>
						<?php if ( !empty( $option_fields['linkedin_link'] ) ) : ?><li><a href="<?php echo esc_attr( $option_fields['linkedin_link'] ); ?>"><span class="icon icon-linkedin"></span></a></li><?php endif; ?>
					</ul>
				</div>

				<div class="single-news__featured-image">
					<?php the_post_thumbnail( 'full' ); ?>
				</div>

				<div class="single-news__content-wrap">

					<div class="single-news__meta-mobile">
						<div class="single-news__date-byline-wrap">
							<p class="single-news__byline-mobile"><?php echo  __( 'By ', '__secureset' ) . get_the_author(); ?></p>
							<p class="single-news__date-mobile"><?php echo get_the_date(); ?></p>
						</div>
						<div class="single-news__categories-mobile">
							<p><?php echo __( 'in ', '__secureset' ); ?></p> <?php echo get_the_category_list(); ?>
						</div>
					</div>

					<div class="single-news__meta-desktop">
						<p class="single-news__byline-desktop"><?php echo  __( 'By ', '__secureset' ) . get_the_author(); ?></p>

						<div class="single-news__categories-desktop">
							<p><?php echo __( 'in ', '__secureset' ); ?></p> <?php echo get_the_category_list(); ?>
						</div>

						<p class="single-news__date-desktop"><?php echo get_the_date(); ?></p>
					</div>

					<div class="single-news__content">
						<?php the_content(); ?>
					</div>

					<?php
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
					?>

				</div>

			<?php endwhile; // End of the loop. ?>
		</div>
		<div class="single-news__back">
			<a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>" class="single-news__back-anchor container"><?php _e( 'Back To All News Posts', '__secureset' ); ?></a>
		</div>
		<div class="single-news__page-builder">
			<?php get_page_builder( 'main_page_builder' ); ?>
		</div>
	</main><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
