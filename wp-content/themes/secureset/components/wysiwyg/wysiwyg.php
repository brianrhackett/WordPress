<?php if ( isset( $fields ) && is_array( $fields ) ): ?>
	<?php
		$mode = esc_attr( $fields['mode'] );
		if ( !$mode ) {
			$mode = 'light';
		}
	?>
	<section class="wysiwyg-component <?php echo $mode; ?>">
		<div class="container">
			<div class="wysiwyg-component__content wysiwyg">
				<?php echo wp_kses_post( filter_ptags_on_image( add_span_inside_h1( $fields['wysiwyg'] ) ) ); ?>
			</div>
		</div>
	</section>
<?php endif; ?>
