<?php if ( isset( $fields ) && is_array( $fields ) ) : ?>
	<section class="alternator <?php echo $fields['mode']; ?>">
		<div class="container">
			<?php if ( !empty( $fields['item'] ) ) : ?>
				<?php foreach ( $fields['item'] as $key => $item ) : ?>
					<?php
						$even = ( $key % 2 == 0 );
						$image_1_url = $item['image_1']['url'];
						$image_2_url = $item['image_2']['url'];
					?>
					<div class="alternator__item clearfix">
						<div class="alternator__images">
							<?php if ( $image_1_url && $even || $image_2_url && !$even ) : ?>
								<div class="alternator__image-1"
									data-speed="<?php echo ( ( $key % 2 == 0 ) ? '14' : '7' ); ?>"
									data-additional="<?php echo ( ( $key % 2 == 0 ) ? '30' : '50' ); ?>" >
									<div
										class="alternator__image-1-img"
										style="background-image: url(  )">
										<img src="<?php if ( $image_1_url && $even ) { echo $image_1_url; } elseif ( $image_2_url && !$even ) { echo $image_2_url; } ?>" />
										<div class="alternator__image-1-bg"></div>
									</div>
								</div>
							<?php endif; ?>
							<?php if ( $image_2_url && $even || $image_1_url && !$even ) : ?>
								<div class="alternator__image-2 alternator__image-2-<?php if ( $even ) { echo 'even'; } else { echo 'odd'; } ?>"
									data-speed="<?php echo( ( $key % 2 == 0 ) ? '7' : '14' ) ?>"
									data-additional="<?php echo( ( $key % 2 == 0 ) ? '-80' : '0' ) ?>">
									<div
										class="alternator__image-2-img"
										style="background-image: url(  )">
										<img src="<?php if ( $image_2_url && $even ) { echo $image_2_url; } elseif ( $image_1_url && !$even ) { echo $image_1_url; } ?>"/>
										<div class="alternator__image-2-bg"></div>
									</div>
								</div>
							<?php endif; ?>
						</div>
						<div class="alternator__text-container">
							<div class="alternator__text">
								<?php if ( !empty( $item['title'] ) ) : ?>
									<h3 class="alternator__title"><?php echo( $item['title'] ); ?></h3>
								<?php endif; ?>
								<?php if ( !empty( $item['paragraph'] ) ) : ?>
									<p class="alternator__paragraph"><?php echo nl2br( $item['paragraph'] ); ?></p>
								<?php endif; ?>
								<?php if ( !empty( $item['cta_cta_text'] ) ) : ?>
									<?php
										$cta_data = array(
											'cta_text' => $item['cta_cta_text'],
											'cta_color' => $item['cta_cta_color'],
											'cta_new_window' => $item[ 'cta_cta_new_window' ],
											'cta_link_type' => $item[ 'cta_cta_link_type' ],
											'cta_custom_url' => $item[ 'cta_cta_custom_url' ],
											'cta_internal_url' => $item[ 'cta_cta_internal_url' ],
											'cta_file_url' => $item[ 'cta_cta_file_url' ]
										);
									?>
									<?php get_component( 'cta', $cta_data ); ?>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>
