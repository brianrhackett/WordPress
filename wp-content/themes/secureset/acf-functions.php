<?php
/**
 * woocommerce custom functions and definitions
 **/

function get_bundles(){
	$args = array(
		'post_type' => 'product',
		'meta_query' => array(
			array(
				'key'		=>	'_related_course',
				'value' 	=>	'',
				'compare'	=>	'!='
			), 
			array(
				'key'		=>	'_related_course',
				'compare'	=>	'EXISTS'
			),
		),
	);
	$posts = get_posts($args);
	$return = array();
	foreach($posts as $post){
		$return[$post->ID] = $post->post_title;
	}
	return $return;
}

function bundle_hero_display($id){
	$course = get_post($id);
	$attributes = get_post_meta( $course->ID , '_product_attributes' );
?>
	<div class="container">
		<div class="hero__content">
			<h1 class="hero__headline"><span><?php echo $course->post_title;?></span></h1>
			<div class="hero__copy"><?php echo ($attributes[0]['hero-copy']) ? $attributes[0]['hero-copy']['value'] : $course->post_content; ?></div>
			<div class="hero__cta-group">
				<a href="/cart?add-to-cart=<?php echo $course->ID;?>">
					<button class="cta btn btn--large btn--<?php echo ($fields['hero_ctas'][0]['clone_cta_color'] == 'white') ? 'light' : 'dark';?>">Enroll Now</button>
				</a>
			</div>
		</div>
	</div>
<?php
}

function bundle_alternator_display($post_id, $mode = 'dark'){
	$data = get_post_meta($post_id);
	$related_courses = unserialize($data['_related_course'][0]);
	if($related_courses){
?>
		<section class="alternator <?php echo $mode;?>">
			<div class="container">
			<?php foreach($related_courses as $i=>$id):
				$course = get_post($id);
				$course_img = wp_get_attachment_url( get_post_thumbnail_id($id) );
			?>
				<div class="alternator__item clearfix">
					<div class="alternator__images">
						<div class="alternator__image-<?php echo $i%2;?> clearfix" data-speed="14" data-additional="30">
							<div class="alternator__image-img">
								<img src="<?php echo $course_img;?>">
								<div class="alternator__image-bg"></div>
							</div>
						</div>
					</div>
					<div class="alternator__text-container">
						<div class="alternator__text">
							<h3 class="alternator__title"><?php echo $course->post_title;?></h3>
							<div><?php echo $course->post_content;?></div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
			</div>
		</section>
<?php 
	}
}

function bundle_grid_display($post_id, $mode = 'dark'){
	$data = get_post_meta($post_id);
	$related_courses = unserialize($data['_related_course'][0]);
	if($related_courses){
?>
		<section class="alternator <?php echo $mode;?>">
			<div class="container">
				<div class="row">
				<?php foreach($related_courses as $i=>$id):
					$course = get_post($id);
					$course_img = wp_get_attachment_url( get_post_thumbnail_id($id) );
				?>
					<div class="col-md-4">
						<h3><?php echo $course->post_title;?></h3>
						<img src="<?php echo $course_img;?>">
					</div>
				<?php endforeach;?>
				</div>
			</div>
		</section>
<?php
	}
}