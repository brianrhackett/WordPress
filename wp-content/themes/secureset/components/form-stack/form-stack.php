<?php if ( isset( $fields ) && is_array( $fields ) ): ?>
	<section class="form-stack <?php echo strtolower( $fields['mode'] ); ?> <?php echo $fields['custom_class']; ?>">
		<div class="container">
			<?php if ( !empty( $fields['title'] ) ): ?>
				<h2 class="form-stack__title component-title">
					<?php echo $fields['title']; ?>
				</h2>
			<?php endif; ?>
			<div class="custom_gravity_forms_spinner hidden"></div>
			<?php if ( !empty( $fields['form'] ) ):?>
				<?php
					$form = $fields['form'];
					$title = $form['title'];
					gravity_form( $title, true, false, false, '', true );
				?>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>
