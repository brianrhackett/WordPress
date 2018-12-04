<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">

	<input type="search" class="search-form__field"
		placeholder="<?php echo esc_attr_x( 'Enter Keywords', '__secureset' ) ?>"
		value="<?php echo get_search_query() ?>" name="s"
		title="<?php echo esc_attr_x( 'Enter Keywords', '__secureset' ) ?>" />

	<input type="submit" class="search-form__submit" value="" />
	<span class="search-form__icon"></span>
</form>
