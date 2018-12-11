<?php
/**
 * The template for displaying all single posts.
 *
 * @package __secureset
 */

get_header(); 
global $post;
?>

<div id="primary" class="content-area custom-page-background" style="background-image:url( '<?php the_field( 'page-background-image' ) ?>' ); background-color:<?php the_field( 'page-background-color' )?>; " >
	<main id="main" class="site-main single-news single-product" role="main">
		<section class="hero hero--hero-regular hero__theme--dark">
			<div class="container">
				<?php while ( have_posts() ) : the_post(); ?>
				<div class="hero__content">
					<h1 class="hero__headline"><span><?php the_title(); ?></span></h1>				
					<div class="hero__copy">
						<?php the_content(); ?>
					</div>
				</div>
				<?php endwhile; // End of the loop. ?>
			</div>

			<div class="single-news__page-builder">
				<?php get_page_builder( 'main_page_builder' ); ?>
			</div>
		</section>
		
		<?php 
			bundle_alternator_display($post->ID);
		
			get_component('course-instructor',array(
				'mode' => 'light',
				'course' => $post->ID,
			));
		?>
		<section class="cta-stack cta-stack--of-1">
			<div class="cta-stack__item">
				<div class="cta-stack__blur"></div>
				<div class="container cta-stack__content">
					<h3 class="cta-stack__title">Get Started</h3>
					<p class="cta-stack__text big">Your first step into the world of cybersecurity starts right here. Whether you’ve dabbled in computers before, or you have zero experience, PREP online is the perfect way to kick-off your cybersecurity education. If you’re ready to get started, click the big button below.</p>
					<a href="/cart/?add-to-cart=<?php echo $post->ID;?>">
						<button class="btn btn--large">Enroll Now</button>
					</a>
				</div>
			</div>		
		</section>
	</main><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
