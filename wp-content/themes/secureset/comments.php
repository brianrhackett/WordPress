<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package __secureset
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<h2 class="comments-area__title">
		<?php
			printf(
				esc_html( _nx( 'Thoughts on &ldquo;%2$s&rdquo;', 'Thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', '__secureset' ) ),
				number_format_i18n( get_comments_number() ),
				'<span>' . get_the_title() . '</span>'
			);
		?>
	</h2>

	<?php if ( have_comments() ) : ?>
		<ol class="comments-area__list">
			<?php
				wp_list_comments( array(
					'type' => 'comment',
					'callback' => 'format_comment'
				) );
			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<nav id="comment-nav-below" class="comments-area__navigation navigation comment-navigation" role="navigation">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', '__secureset' ); ?></h2>
				<div class="comments-area__navigation--nav-links">
					<div class="comments-area__nav-previous"><?php previous_comments_link( esc_html__( '< Older Comments', '__secureset' ) ); ?></div>
					<div class="comments-area__nav-next"><?php next_comments_link( esc_html__( 'Newer Comments >', '__secureset' ) ); ?></div>
				</div><!-- .nav-links -->
			</nav><!-- #comment-nav-below -->
		<?php endif; // Check for comment navigation. ?>
	<? else : ?>
		<p class="no-comments">There are currently no comments on this article. </p>
	<?php endif; ?>

	<?php
		$comments_args = array(
			'title_reply' => __( 'Share Your Thoughts', '__secureset' ),
			'label_submit' => __( 'Submit Comment', '__secureset' ),
			'class_submit' => 'btn btn--blue btn--submit submit comments-area__submit',
			'class_form' => 'comment-form gform_wrapper gform_fields',
			'comment_field' => '<p class="comment-form-comment"><label for="comment">' .
				_x( 'Your Comment', 'noun' ) .
				'</label>
				<textarea class="comments-area__textarea full-width comment-text-area" id="comment" name="comment" cols="45" rows="8" aria-required="true">' .
				'</textarea></p>' )
	?>
	<?php comment_form( $comments_args ); ?>

</div><!-- #comments -->
