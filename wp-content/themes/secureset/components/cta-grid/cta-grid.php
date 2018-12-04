<?php if ( isset( $fields ) && is_array( $fields ) ) : ?>
	<section class="cta-grid <?php echo( $fields['mode'] ) ?>">
		<div class="container">
			<div class="cta-grid__flex-wrap">
				<?php if ( !empty( $fields['item'] ) ) : ?>
					<?php foreach ( $fields['item'] as $item ) : ?>
						<div class="cta-grid__item">
							<?php if ( !empty( $item['cta_link'] ) ) : ?>
								<a href="<?php echo $item['cta_link']; ?>" class="cta-grid__link"></a>
							<?php endif; ?>
							<?php if ( !empty( $item['image'] ) ) : ?>
								<div class="cta-grid__bg"></div>
								<div class="cta-grid__image" style="background-image: url( <?php echo $item['image']['url']; ?> )"></div>
							<?php endif; ?>
							<?php if ( !empty( $item['title'] ) ) : ?>
								<h4 class="cta-grid__title"><?php echo $item['title']; ?></h4>
							<?php endif; ?>
							<?php if ( !empty( $item['cta_link'] && $item['cta_text'] ) ) : ?>
								<a class="cta-grid__cta" href="<?php echo $item['cta_link']; ?>">
									<?php echo $item['cta_text'] ?>
								</a>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>
