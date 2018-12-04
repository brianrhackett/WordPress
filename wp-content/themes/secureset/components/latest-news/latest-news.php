<?php if ( is_array( $fields ) && !empty( $fields ) ) : ?>
	<?php
		global $post;
		$type = $fields['latest_news_types'];
		if ( $type === 'latest-news-regular' ) {
			$args = array( 'post_type' => 'post', 'orderby' => 'date', 'order' => 'DESC', 'posts_per_page' => 4 );
		} else {
			$category = $fields['category'];
			$args = array( 'category' => $category, 'posts_per_page' => 1, 'post_type' => 'post', 'orderby' => 'date', 'order' => 'DESC' );
		}
		$latest_posts = get_posts( $args );
		if ( !empty( $latest_posts ) ) :
	?>
	<section class="latest-news <?php echo $fields['mode']; ?> <?php echo $type; ?>">
		<div class="container">
			<h2 class="latest-news__title component-title"><?php echo $fields['title']; ?></h2>
			<div class="latest-news__flex-wrapper">
				<?php foreach ( $latest_posts as $key => $latest_post ) : ?>
					<?php
						$post = $latest_post;
						setup_postdata( $latest_post );
						$is_featured_post = ( $key === 0 ) ? true : false;
						$is_first_reg_post = ( $key === 1 ) ? true : false;
						$is_last_post = ( $key === ( count( $latest_posts ) - 1 ) ) ? true : false;
					?>

					<?php if ( $is_first_reg_post ) : ?>
						<div class="latest-news__flex-right">
					<?php endif; ?>
					<a href="<?php the_permalink(); ?>" class="latest-news__post<?php if ( $is_featured_post ) : echo '--featured latest-news__flex-left'; endif; ?>" style="<?php if ( $key === 0 ) { echo 'background-image: url('; if ( has_post_thumbnail() ) { echo get_the_post_thumbnail_url( get_the_id(), 'larges' ) . ');'; } else {  echo '"' . get_stylesheet_directory_url() .  'assets/img/default-news.jpg");'; } } ?>">
						<div class="latest-news__post-content-wrap">
							<div class="latest-news__post-date"><?php echo get_the_date(); ?></div>
							<h3 class="latest-news__post-title"><?php echo the_title(); ?></h3>
							<div class="latest-news__post-excerpt"><?php echo the_excerpt(); ?></div>
							<?php if ( $is_featured_post ) : ?>
								<span class="btn btn--small btn--light latest-news__post-cta"><?php _e( 'Read More', '__secureset' ); ?></span>
							<?php endif; ?>
							<?php $count = wp_count_comments( get_the_id() )->approved; ?>
							<?php if ( $count > 0 ) : ?>
								<span class="latest-news__post-comment-count news-featured-comments"><?php echo $count; ?></span>
							<?php endif; ?>
						</div>
					</a>
					<?php if ( $is_last_post ) : ?>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
				<?php wp_reset_postdata(); ?>
			</div>
		<div class="container">
	</section>
	<?php endif; ?>
<?php endif; ?>
