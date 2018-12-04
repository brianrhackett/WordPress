<?php if ( isset( $fields ) && is_array( $fields ) ): ?>
	<section class="video-img <?php echo $fields['mode']; ?>">
		<div class="container">
			<div class="video-img-holder">
				<?php if ( !empty( $fields['video-img-row'] ) ): ?>
					<?php foreach( $fields['video-img-row'] as $row ): ?>
					<div class="video-img-row">
						<?php if ( !empty( $row['video-img-cell'] ) ): ?>
							<?php foreach( $row['video-img-cell'] as $cell ): ?>
							<div class="video-img-cell grid-<?php echo count( $row['video-img-cell'] );?>">
								<div class="video-img-cell-media">
									<?php echo get_component( 'media-helper', $cell );?>
								</div>
								<div class="video-text-holder">
									<div class="video-cell-title">
										<?php echo( $cell['video-cell-title'] ); ?>
									</div>
									<div class="video-cell-description">
										<?php echo( $cell['video-cell-description'] ); ?>
									</div>
								</div>
							</div>
						<?php endforeach;?>
					<?php endif; ?>
					</div>
					<?php endforeach;?>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>
