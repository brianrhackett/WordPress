<?php

//Custom function for custom comment HTML
function format_comment( $comment, $args ) {

	$GLOBALS['comment'] = $comment; ?>

	<li <?php comment_class( 'comments-area__list-item' ); ?> id="li-comment-<?php comment_ID() ?>">
		<!--approval text-->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<span class="comments-area__approval"><p><?php _e( 'Your comment is awaiting moderation.' ) ?></p></span>
		<?php endif; ?>

		<div class="comments-area__section">
			<div class="comments-area__avatar">
				<?php echo get_avatar( $comment, '75', '', '', array( 'class' => 'comments-area__avatar-image' ) ); ?>
			</div>
			<div class="comments-area__section-content <?php if ( $comment->comment_approved == '0' ) { ?>comments-area__section-content--unapproved <?php } ?>">
				<span class="comments-area__author"><?php printf( __( '%s' ), get_comment_author_link() ) ?></span>
				<span class="comments-area__date"><?php echo get_comment_date() ?></span>
				<div class="comments-area__text <?php if ( $comment->comment_approved == '0' ) { ?>comments-area__text--unapproved <?php } ?>">
					<?php comment_text(); ?>
				</div>
			</div>
		</div>
<?php }

// http://www.wpbeginner.com/wp-tutorials/how-to-move-comment-text-field-to-bottom-in-wordpress-4-4/
function move_comment_field_to_bottom( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;
	return $fields;
}
add_filter( 'comment_form_fields', 'move_comment_field_to_bottom' );

function comments_form_defaults( $default ) {
	$notes = $default['comment_notes_before'];
	$default['comment_notes_before'] = '';
	$default['comment_notes_after'] = $notes;
	return $default;
}
add_filter( 'comment_form_defaults', 'comments_form_defaults' );
