<?php if ( is_array( $fields ) && !empty( $fields ) ): ?>
	<section class="short-newsletter-form dark">

		<div class="container short-newsletter-form__title-wrap">
			<?php if ( $fields['title'] ) : ?>
				<h3 class="short-newsletter-form__title"><?php echo $fields['title']; ?></h3>
			<?php endif; ?>

			<?php if ( $fields['sub_title'] ) : ?>
				<p class="short-newsletter-form__subtitle"><?php echo $fields['sub_title']; ?></p>
			<?php endif; ?>
		</div>

		<div class="short-newsletter-form__gf-wrap">
			<?php gravity_form( 'Newsletter', false, false, false, null, true ); ?>
		</div>

	</section>
<?php endif; ?>
