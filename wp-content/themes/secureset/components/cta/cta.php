<?php
if ( is_array( $fields ) && !empty( $fields ) ) :
	$link_type = $fields['cta_link_type'];
	switch ( $link_type ) :
		case 'custom' :
			$href = $fields['cta_custom_url'];
			break;
		case 'internal' :
			$href = $fields['cta_internal_url'];
			break;
		case 'file' :
			$href = $fields['cta_file_url'];
			break;
		default:
			$href = '#';
			break;
	endswitch; ?>
	<a class="cta btn<?php if ( $fields['cta_color'] === 'white' ) { echo ' btn--light'; }; ?>" href="<?php echo esc_attr( $href ); ?>"<?php if( $fields['cta_new_window'] === 'yes' ) : echo ' target="_blank"'; endif;?>><?php echo esc_attr( $fields['cta_text'] ); ?></a>
	<?php
endif;
