<?php if ( is_array( $fields ) && !empty( $fields ) ) : ?>
	<?php if ( !empty( $fields['course'] ) ) : 
		$attributes = get_post_meta( $fields['course'] , '_sfwd-courses' );
		if(empty($attributes)){
			$attributes = get_post_meta( $fields['course'], 'instructor' );
			$instructor = get_post($attributes[0]);
		} else {
			$instructor = get_post($attributes[0]['sfwd-courses_course_instructor']);
		}
		$instructor_video = current(get_post_meta( $instructor->ID , 'instructor_video' ));
	?>
		<section class="instructor <?php echo $fields['mode'] ?>">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<h5><?php echo $instructor->post_title;?></h5>
						<div>
							<p><?php echo implode('</p><p>', explode(PHP_EOL,$instructor->post_content));?></p>
						</div>
					</div>
					<div class="video-container col-md-6">
						<iframe src="<?php echo $instructor_video;?>" width="100%" height="380px"></iframe>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>
<?php endif; ?>
