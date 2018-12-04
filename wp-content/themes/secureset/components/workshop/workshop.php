						die('<pre>'.print_r($fields,1));
						?><?php if ( is_array( $fields ) && !empty( $fields ) ) : ?>
<section class="container workshop">
	<div class="programs-landing__program workshop__position-<?php echo $fields['position']; ?>">
		<div class="programs-landing__top">
			<div class="programs-landing__img-section-container">
				<div class="programs-landing__img-section">
					<div class="programs-landing__img-bg workshop__bg-color"></div>
					<div class="programs-landing__img" style="background-image: url('<?php echo wp_get_attachment_image_url( $fields['image']['ID'], 'full' ); ?>')"></div>
				</div>
			</div>
			<div class="programs-landing__info-section-container">
				<div class="programs-landing__info-section">
					<div class="programs-landing__info-bg workshop__bg-color"></div>
					<div class="programs-landing__info">
						<div href="#" class="programs-landing__icon-container workshop__bg-color">
							<div class="programs-landing__icon" style="background-image: url(<?php echo get_stylesheet_directory_uri() . '/assets/img/wolf-icon.png'; ?>)"></div>
						</div>
						<h3 class="programs-landing__title workshop__color"><?php if ( $fields['heading_link'] ) : ?><a class="workshop__title-link" href="<?php echo $fields['heading_link']; ?>"><?php endif; ?><?php _e( $fields['heading'], '__secureset'); ?><?php if ( $fields['heading_link'] ) : ?></a><?php endif; ?></h3>
						<p class="programs-landing__description"><?php _e( $fields['main_content'], '__secureset' ); ?></p>
						<?php

						<?php if ( $fields['links'] ) : ?>
							<?php foreach ( $fields['links'] as $link ) : ?><a class="programs-landing__date" href="<?php echo $link['link_url']; ?>"><?php esc_attr_e( $link['link_text'], '__secureset' ); ?></a><?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<div class="programs-landing__bottom">
			<h4 class="programs-landing__courses-label"><?php _e( 'Workshops', '__secureset' ); ?>:</h4>
			<div class="programs-landing__courses">  
				<?php if ( $fields['workshops'] ) : ?>
					<?php foreach ( $fields['workshops'] as $workshop ) : ?>
						<span class="programs-landing__course-icon icon-<?php echo $workshop['icon']; ?> workshop__color">
							<span class="programs-landing__course-title workshop__bg-color">
								<span class="programs-landing__course-title-caret workshop__caret"></span>
								<p><?php _e( $workshop['tooltip'], '__secureset' ); ?></p>
							</span>
						</span>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
			<div class="programs-landing__included">
				<?php if ( $fields['sub-heading'] ) : ?>
					<h5 class="programs-landing__included-label"><?php _e( $fields['sub-heading'], '__secureset' ); ?></h5>
				<?php endif; ?>
				<ul class="workshop__color">
					<?php if ( $fields['list-items'] ) : ?>
						<?php foreach ( $fields['list-items'] as $list_item ) : ?>
							<li class="programs-landing__included-item"><p><?php _e( $list_item['list-item'], '__secureset' ); ?></p></li>		
						<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>
