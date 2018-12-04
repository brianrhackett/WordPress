<?php if ( isset( $fields ) && is_array( $fields ) ) :
	$cards_theme = ( !empty( $fields['cards_theme'] ) ) ? esc_attr( $fields['cards_theme'] ) : 'dark'; ?>
	<section class="three-column-stack <?php echo strtolower( esc_attr( $fields['card_type'] ) );?> <?php echo strtolower( $cards_theme );?>">
		<?php if ( !empty( $fields['item'] ) ) : ?>
			<div class="container">
				<?php foreach ( $fields['item'] as $item ) : ?>
					<div class="<?php echo strtolower( $fields['card_type'] ); ?>__item<?php if ( !empty( $item['cta_link'] ) ) : ?> has-link<?php endif; ?>">

						<?php if ( !empty( $item['cta_link'] ) ) : ?>
							<a href="<?php echo $item['cta_link']; ?>" class="<?php echo strtolower( $fields['card_type'] ); ?>__link"></a>
						<?php endif; ?>

						<?php if ( !empty( $item['image'] ) ) : ?>
							<div class="<?php echo strtolower( $fields['card_type'] ); ?>__bg"></div>
							<div class="<?php echo strtolower( $fields['card_type'] ); ?>__image" style="background-image: url( <?php echo $item['image']['url']; ?> )"></div>
						<?php endif; ?>

						<hr class="<?php echo strtolower( $fields['card_type'] ) ?>__spacer" />

						<?php if ( !empty( $item['title'] ) ) : ?>
							<h4 class="<?php echo strtolower( $fields['card_type'] ) ?>__title"><?php echo $item['title']; ?></h4>
						<?php endif; ?>

						<?php if ( !empty( $item['wysiwyg'] ) ) : ?>
							<div class="<?php echo strtolower( $fields['card_type'] ) ?>__paragraph wysiwyg"><?php echo $item['wysiwyg']; ?></div>
						<?php endif; ?>

						<?php if ( !empty( $item['cta_link'] && $item['cta_text'] ) ) : ?>
							<a class="<?php echo strtolower( $fields['card_type'] ); ?>__cta" href="<?php echo $item['cta_link']; ?>">
								<?php echo $item['cta_text'] ?>
							</a>
						<?php endif; ?>
						<span class="card__item-bottom"></span>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</section>
<?php endif; ?>
