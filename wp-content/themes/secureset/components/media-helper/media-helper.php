<!-- Component: Media Helper -->
<?php if ( isset( $fields ) && is_array( $fields ) ): ?>
<div class="media-helper">

	<?php if ( $fields['type'] == 'image' ): ?>

		<div class="media-helper__image">
			<?php if ( ! empty( $fields['image_mobile'] ) ): ?>
				<div class="media-helper__image-mobile">
					<?php echo wp_get_attachment_image( $fields['image_mobile']['ID'], 'full' ); ?>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $fields['image'] ) ): ?>
				<div class="media-helper__image-desktop">
					<?php echo wp_get_attachment_image( $fields['image']['ID'], 'full' ); ?>
				</div>
			<?php endif; ?>
		</div>

	<?php elseif ( $fields['type'] == 'video_link' ): ?>

		<?php $video = $fields['oembed_video']; ?>
		<?php if ( $video ): ?>
			<?php
				preg_match( '/width="(.+?)"/', $video, $matches );
				$width = $matches[1];
				preg_match( '/height="(.+?)"/', $video, $matches );
				$height = $matches[1];
				$ar = ( $height / $width ) * 100;
			?>
			<div class="media-helper__video-wrap">

				<?php
					if ( strpos(  $video, 'youtube' ) !== false ) {
						$video = str_replace( '<iframe', '<iframe id="' . uniqid() . '"', $video );
						$params = array(
							'api' => 1,
							'enablejsapi' => 1,
							'controls' => 1,
							'modestbranding' => 1,
							'rel' => 0,
							'showinfo' => 0,
							'autoplay' => 1
						);

						if ( $fields['poster'] ) {
							$poster_image = wp_get_attachment_image( $fields['poster']['ID'], 'full' );
						} else {
							preg_match( '/embed(.*?)?feature/', $video, $matches );
							$video_id = str_replace( str_split( '?/' ), '', $matches[1] );
							$poster_image = '<img src="https://img.youtube.com/vi/' . $video_id . '/maxresdefault.jpg" alt="poster" />';
							if ( ! file_exists( $poster_image ) ) {
								$poster_image = '<img src="https://img.youtube.com/vi/' . $video_id . '/sddefault.jpg" alt="poster" />';
							}
							if ( ! file_exists( $poster_image ) ) {
								$poster_image = '<img src="https://img.youtube.com/vi/' . $video_id . '/0.jpg" alt="poster" />';
							}
						}
					} elseif ( strpos( $video, 'vimeo' ) !== false ) {
						$video = str_replace( '<iframe', '<iframe id="' . uniqid() . '"', $video );
						$params = array(
							'api' => 1,
							'byline' => false,
							'portrait' => false
						);

						if ( $fields['poster'] ) {
							$poster_image = wp_get_attachment_image( $fields['poster']['ID'], 'full' );
						} else {
							preg_match( '/video\/(.*?)"/', $video, $matches );
							$video_id = $matches[1];
							$vimeo_xml_file = unserialize( file_get_contents( 'http://vimeo.com/api/v2/video/' . $video_id . '.php' ) );
							$poster_image = '<img src="' . $vimeo_xml_file[0]['thumbnail_large'] . '" alt="poster" />';
						}
					}

					preg_match( '/src="(.+?)"/', $video, $matches );
					$src = add_query_arg( $params, $matches[1] );
					echo '<div class="media-helper__video-link-poster aspect-ratio" data-aspect-ratio="' . $ar . '">' .  $poster_image . '</div>';
					echo '<a href="' . $src . '" class="fancybox-media media-helper__video-link" data-fancybox><span class="media-helper__play-button"></span></a>';
				?>
			</div>
		<?php endif; ?>

	<?php elseif ( $fields['type'] == 'video_file' ): ?>

		<div class="media-helper__video-file">
			<?php if ( $fields['mp4_video_file'] || $fields['webm_video_file'] ): ?>

				<video id="js-html5-video" <?php if ( $fields['poster'] ): ?> poster="<?php echo $fields['poster']['url']; ?>"<?php endif; ?> <?php if ( $fields['mp4_video_file'] ) { echo 'width="' . $fields['mp4_video_file']['width'] . '" height="' . $fields['mp4_video_file']['height'] . '"'; } elseif ( $fields['webm_video_file'] ) { echo 'width="' . $fields['webm_video_file']['width'] . '" height="' . $fields['webm_video_file']['height'] . '"'; } ?> >
					<?php if ( $fields['mp4_video_file'] ): ?>
						<source src="<?php echo $fields['mp4_video_file']['url']; ?>" type="video/mp4">
					<?php endif; ?>
					<?php if ( $fields['webm_video_file'] ): ?>
						<source src="<?php echo $fields['webm_video_file']['url']; ?>" type="video/webm">
					<?php endif; ?>
					I'm sorry; your browser doesn't support HTML5 video in WebM with VP8/VP9 or MP4 with H.264.
					<!-- You can embed a Flash player here, to play your mp4 video in older browsers -->
				</video>

			<?php endif; ?>
		</div>

	<?php endif; ?>

</div>
<?php endif; ?>
