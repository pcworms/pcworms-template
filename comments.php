<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
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

<div id="comments" class="comments-area panel box mt-4 container">

	<?php
	
	// You can start editing here -- including this comment!
	if ( have_comments() ) { ?>
		<div class="row comments-title">
			<h2 class="panel-icon float-right px-3 ml-3"><i class="fa-solid fa-comments"></i></h2>
			<h2 class="panel-heading float-left">
				<?php
				$comments_number = get_comments_number();
				if ( '1' === $comments_number ) {
					/* translators: %s: post title */
					printf( esc_html__( 'One Reply to &ldquo;%s&rdquo;', 'pcworms' ), esc_html( get_the_title() ) );
				} else {
					printf( // xss ok
						esc_html(
							/* translators: 1: number of comments, 2: post title */
							_n(
								'%1$s Reply to &ldquo;%2$s&rdquo;',
								'%1$s Replies to &ldquo;%2$s&rdquo;',
								$comments_number,
								'pcworms'
							)
						),
						number_format_i18n( $comments_number ),
						esc_html(get_the_title())
					);
				}
				?>
			</h2>
		</div>

		<div class="panel-body">
			<?php echo Free_Template::comments_pagination( array( // xss ok
				'prev_text' => '<span>' . esc_html__( 'Previous', 'pcworms' ) . '</span>',
				'next_text' => '<span>' . esc_html__( 'Next', 'pcworms' ) . '</span>',
				'type'		=> 'list',
			) ); ?>

			<ol class="comment-list">
				<?php
					wp_list_comments( array(
						'walker'		=> new BS_Walker_Comment(),
						'avatar_size' => 60,
						'style'       => 'ol',
						'short_ping'  => true,
						'reply_text'  => '<i class="fa fa-reply" aria-hidden="true"></i>&nbsp;' . esc_html__( 'Reply', 'pcworms'),
					) );
				?>
			</ol>
			
			<?php echo Free_Template::comments_pagination( array( // xss ok
				'prev_text' => '<span>' . esc_html__( 'Previous', 'pcworms' ) . '</span>',
				'next_text' => '<span>' . esc_html__( 'Next', 'pcworms' ) . '</span>',
				'type'		=> 'list',
			) );
			?>
		</div>
	<?php
	} // Check for have_comments().

	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) { ?>

		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'pcworms' ); ?></p>
	<?php
	} ?>
	
	<div class="panel-footer">
		<?php Free_Template::validate_comment_form(); ?>
	</div>

</div><!-- #comments -->
