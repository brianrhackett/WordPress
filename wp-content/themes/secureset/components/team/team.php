<?php if ( is_array( $fields ) && !empty( $fields ) ) : ?>
	<?php if ( !empty( $fields['member'] ) ) : ?>
		<section class="team <?php echo $fields['mode'] ?>">
			<?php foreach( $fields['member'] as $member ) : ?>
				<div class="team__member" onclick="window.location = '<?php echo get_permalink( $member->ID ); ?>'" >

					<?php if ( !empty( get_field( 'image' , $member->ID ) ) ) : ?>
						<?php
							$image = get_field( 'image', $member->ID );
							$image_url = wp_get_attachment_image_src( $image, 'full' )[0];
						?>
						<div class="team__member-image" style="background-image: url( <?php echo $image_url; ?> );"></div>
					<?php endif; ?>

					<div class="team__member-content-container">
						<div class="team__member-content">

							<?php if ( !empty( get_field( 'name' , $member->ID ) ) ) : ?>
								<h5 class="team__member-name"><?php echo get_field( 'name' , $member->ID ); ?></h5>
							<?php endif; ?>

							<?php if ( !empty( get_field( 'role' , $member->ID ) ) ) : ?>
								<p class="team__member-role"><?php echo get_field( 'role' , $member->ID ); ?></p>
							<?php endif; ?>

							<div class="team__member-social">
								<a href="<?php echo get_permalink( $member->ID ); ?>">
									<span class="team__member-profile icon-profile"></span>
								</a>

								<?php if ( !empty( get_field( 'linked_in_url' , $member->ID ) ) ) : ?>
									<a target="_blank" href="<?php echo get_field( 'linked_in_url' , $member->ID ) ?>">
										<span class="team__member-linkedin icon-linkedin"></span>
									</a>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</section>
	<?php endif; ?>
<?php endif; ?>
