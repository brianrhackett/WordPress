<?php if ( isset( $fields ) && is_array( $fields ) ): ?>
	<section class="title-component <?php echo( $fields['mode'] ) ?>">
		<div class="container">
			<?php if ( !empty( $fields['title'] ) ): ?>
				<h2 class="title-component__title component-title">
					<?php echo( $fields['title'] ); ?>
				</h2>
			<?php endif; ?>
			<?php if ( !empty( $fields['paragraph'] ) ): ?>
				<p class="title-component__paragraph">
					<?php echo( $fields['paragraph'] ); ?>
				</p>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>
