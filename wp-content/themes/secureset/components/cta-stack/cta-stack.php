<?php if ( isset( $fields ) && is_array( $fields ) ) : ?>
	<section class="cta-stack cta-stack--of-<?php echo( count( $fields['item'] ) ) ?>">
		<?php if ( !empty( $fields['item'] ) ) : ?>
				<?php foreach ( $fields['item'] as $item ) : ?>
					<div class="cta-stack__item">
						<div class="cta-stack__blur"></div>
						<div class="cta-stack__image"
						style="background-image: url( <?php echo( $item['image']['url'] ) ?> ); <?php echo( ( $item['greyscale'] == 1 ) ? 'filter: grayscale( 1 );' : '' ) ?>"></div>
						<div class="container cta-stack__content">
							<?php if ( !empty( $item['title'] ) ) : ?>
								<h3 class="cta-stack__title"><?php echo( $item['title'] ); ?></h3>
							<?php endif; ?>
							<?php if ( !empty( $item['text'] ) ) : ?>
								<p class="cta-stack__text big"><?php echo( $item['text'] ); ?></p>
							<?php endif; ?>
							<?php if ( !empty( $item['cta_text'] && $item['cta_link'] ) ) : ?>
								<a href="<?php echo( $item['cta_link'] ); ?>">
									<button class="btn btn--large">
										<?php echo( $item['cta_text'] ); ?>
									</button>
								</a>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
		<?php endif; ?>
	</section>
<?php endif; ?>
