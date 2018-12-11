<?php 
if ( isset( $fields ) && is_array( $fields ) ) :
	if($fields['display_type'] == 'alternator'){
		bundle_alternator_display($fields['bundle'],$fields['mode']);
	} else {
		bundle_grid_display($fields['bundle'],$fields['mode']);
	}
endif;
