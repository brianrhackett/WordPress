<?php if ( isset( $fields ) && is_array( $fields ) ): ?>
<section class="testimonial <?php echo( $fields['mode'] ) ?>">
	<div class="container">
		<?php if ( !empty( $fields['testimonial_item'] ) ): ?>
			<?php foreach ( $fields['testimonial_item'] as $item ): ?>
				<div class="testimonial__item grid-<?php echo count($fields['testimonial_item']);?>">
					<?php if( !empty( $item['quote_text'] ) ): ?>
						<div class="testimonial__quote">
							<?php echo( $item['quote_text'] ); ?>
						</div>
					<?php endif; ?>
					<div class="testimonial__subject">
						<?php if( !empty( $item['subject_image'] ) ): ?>
							<?php echo wp_get_attachment_image( $item['subject_image']['ID'], 'full', null, array( 'class' => 'testimonial__subject-image' ) ); ?>
						<?php endif; ?>
						<?php if( !empty( $item['subject_name'] ) ): ?>
							<p class="testimonial__subject-name">— <?php echo $item['subject_name'];?></p>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</section>
<?php endif; ?>
