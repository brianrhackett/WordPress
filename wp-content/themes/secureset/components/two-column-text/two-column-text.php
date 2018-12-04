<?php if ( isset( $fields ) && is_array( $fields ) ): ?>
	<section class="two-column-text <?php echo( $fields['mode'] ) ?>">
		<div class="container">
			<?php if ( !empty( $fields['header'] ) ): ?>
				<h3 class="two-column-text__header">
					<?php echo( $fields['header'] ) ?>
				</h3>
				<div class="two-column-text__header-underline"></div>
			<?php endif; ?>
			<?php if ( !empty( $fields['left_wysiwyg'] ) ): ?>
				<div class="two-column-text__copy left wysiwyg">
					<?php echo( $fields['left_wysiwyg'] )?>
				</div>
			<?php endif; ?>
			<?php if ( !empty( $fields['right_wysiwyg'] ) ): ?>
				<div class="two-column-text__copy right wysiwyg">
					<?php echo( $fields['right_wysiwyg'] )?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>
