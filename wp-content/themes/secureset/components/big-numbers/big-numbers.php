<?php if ( isset( $fields ) && is_array( $fields ) ): ?>
	<section class="big-numbers">
		<?php if ( !empty( $fields['big_number_item'] ) ): ?>
			<div class="big-numbers__container container">
				<?php foreach ( $fields['big_number_item'] as $item ): ?>
					<div class="big-numbers__item">
						<?php if( !empty( $item['big_number'] ) ): ?>
							<h3 class="big-numbers__number"><?php echo( $item['big_number'] ); ?></h3>
						<?php endif; ?>
						<?php if( !empty( $item['copy'] ) ): ?>
							<p class="big-numbers__copy"><?php echo( $item['copy'] ); ?></p>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</section>
<?php endif; ?>
