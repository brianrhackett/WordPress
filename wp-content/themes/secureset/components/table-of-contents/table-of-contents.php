<?php if ( is_array( $fields ) && !empty( $fields ) ) : ?>
	<?php if ( !empty( $fields['course'] ) ) : 
	
		$lessons = get_posts(array(
			'post_type' 	=> 'sfwd-lessons',
			'meta_key'		=> 'course_id',
			'meta_value'	=> $fields['course'],
			'number_posts'	=> -1
		));
	?>
		<section class="lessons <?php echo $fields['mode'] ?>">
			<div class="container">
			<?php foreach( $lessons as $lesson ) : ?>
				<div class="lesson__block" >
					<h5><?php echo $lesson->post_title;?></h5>
					<p><?php echo $lesson->post_excerpt;?></p>
				</div>
			<?php endforeach; ?>
			</div>
		</section>
	<?php endif; ?>
<?php endif; ?>
