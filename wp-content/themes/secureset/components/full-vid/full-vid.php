<?php $video = $fields['full_width_video']; ?>
<?php if ( $video ): ?>
<?php
	preg_match( '/width="(.+?)"/', $video, $matches );
	$width = $matches[1];
	preg_match( '/height="(.+?)"/', $video, $matches );
	$height = $matches[1];
	$ar = ( $height / $width ) * 100;
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
			$poster_image_url = wp_get_attachment_image_src( $fields['poster']['ID'], 'full' )[0];
		} else {
			preg_match( '/embed(.*?)?feature/', $video, $matches );
			$video_id = str_replace( str_split( '?/' ), '', $matches[1] );
			$poster_image_url = 'https://img.youtube.com/vi/' . $video_id . '/maxresdefault.jpg';

			if ( ! file_exists( $poster_image_url ) ) {
				$poster_image_url = 'https://img.youtube.com/vi/' . $video_id . '/sddefault.jpg';
			}

			if ( ! file_exists( $poster_image_url ) ) {
				$poster_image_url = 'https://img.youtube.com/vi/' . $video_id . '/0.jpg';
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
			$poster_image_url = wp_get_attachment_image_src( $fields['poster']['ID'], 'full' )[0];
		} else {
			preg_match( '/video\/(.*?)"/', $video, $matches );
			$video_id = $matches[1];
			$vimeo_xml_file = unserialize( file_get_contents( 'http://vimeo.com/api/v2/video/' . $video_id . '.php' ) );
			$poster_image_url = $vimeo_xml_file[0]['thumbnail_large'];
		}
	}
	preg_match( '/src="(.+?)"/', $video, $matches );
	$src = add_query_arg( $params, $matches[1] );

	if ( $fields['image_mobile'] ) {
		$mobile_poster_image_url = wp_get_attachment_image_src( $fields['image_mobile']['ID'], 'full' )[0];
	}
?>
	<style>
		.full-vid {
			background-image: url( <?php echo $mobile_poster_image_url; ?> );
		}

		@media only screen and (min-width: 540px)  {
			.full-vid {
				background-image: url( <?php echo $poster_image_url; ?> );
			}
		}
	</style>
	<section class="js-full-vid full-vid">
		<div class="full-vid-wrap">
			<div class="full-vid-holder" style="padding-bottom:<?php echo $ar; ?>%;" ><iframe width="100%" height="100%" src="" class="js-full-video-iframe full-video-iframe" allowfullscreen="allowfullscreen" mozallowfullscreen="mozallowfullscreen" msallowfullscreen="msallowfullscreen" oallowfullscreen="oallowfullscreen" webkitallowfullscreen="webkitallowfullscreen" data-aspect-ratio="'<?php echo $ar; ?>" data="<?php echo $src; ?>"></iframe></div>
			<span class="js-full-vid-play-button media-helper__play-button playpause"></span>
		</div>
	</section>
<?php endif; ?>
