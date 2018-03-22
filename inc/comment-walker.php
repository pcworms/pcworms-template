<?php

class BS_Walker_Comment extends Walker {
 
    /**
     * What the class handles.
     *
     * @since 2.7.0
     * @access public
     * @var string
     *
     * @see Walker::$tree_type
     */
    public $tree_type = 'comment';
 
    /**
     * Database fields to use.
     *
     * @since 2.7.0
     * @access public
     * @var array
     *
     * @see Walker::$db_fields
     * @todo Decouple this
     */
    public $db_fields = array ('parent' => 'comment_parent', 'id' => 'comment_ID');
 
    /**
     * Starts the list before the elements are added.
     *
     * @since 2.7.0
     * @access public
     *
     * @see Walker::start_lvl()
     * @global int $comment_depth
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Optional. Depth of the current comment. Default 0.
     * @param array  $args   Optional. Uses 'style' argument for type of HTML list. Default empty array.
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $GLOBALS['comment_depth'] = $depth + 1;
 
        switch ( $args['style'] ) {
            case 'div':
                break;
            case 'ol':
                $output .= '<ol class="children">' . "\n";
                break;
            case 'ul':
            default:
                $output .= '<ul class="children">' . "\n";
                break;
        }
    }
 
    /**
     * Ends the list of items after the elements are added.
     *
     * @since 2.7.0
     * @access public
     *
     * @see Walker::end_lvl()
     * @global int $comment_depth
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Optional. Depth of the current comment. Default 0.
     * @param array  $args   Optional. Will only append content if style argument value is 'ol' or 'ul'.
     *                       Default empty array.
     */
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $GLOBALS['comment_depth'] = $depth + 1;
 
        switch ( $args['style'] ) {
            case 'div':
                break;
            case 'ol':
                $output .= "</ol><!-- .children -->\n";
                break;
            case 'ul':
            default:
                $output .= "</ul><!-- .children -->\n";
                break;
        }
    }
 
    /**
     * Traverses elements to create list from elements.
     *
     * This function is designed to enhance Walker::display_element() to
     * display children of higher nesting levels than selected inline on
     * the highest depth level displayed. This prevents them being orphaned
     * at the end of the comment list.
     *
     * Example: max_depth = 2, with 5 levels of nested content.
     *     1
     *      1.1
     *        1.1.1
     *        1.1.1.1
     *        1.1.1.1.1
     *        1.1.2
     *        1.1.2.1
     *     2
     *      2.2
     *
     * @since 2.7.0
     * @access public
     *
     * @see Walker::display_element()
     * @see wp_list_comments()
     *
     * @param WP_Comment $element           Comment data object.
     * @param array      $children_elements List of elements to continue traversing. Passed by reference.
     * @param int        $max_depth         Max depth to traverse.
     * @param int        $depth             Depth of the current element.
     * @param array      $args              An array of arguments.
     * @param string     $output            Used to append additional content. Passed by reference.
     */
    public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        if ( !$element )
            return;
 
        $id_field = $this->db_fields['id'];
        $id = $element->$id_field;
 
        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
 
        /*
         * If at the max depth, and the current element still has children, loop over those
         * and display them at this level. This is to prevent them being orphaned to the end
         * of the list.
         */
        if ( $max_depth <= $depth + 1 && isset( $children_elements[$id]) ) {
            foreach ( $children_elements[ $id ] as $child )
                $this->display_element( $child, $children_elements, $max_depth, $depth, $args, $output );
 
            unset( $children_elements[ $id ] );
        }
 
    }
 
    /**
     * Starts the element output.
     *
     * @since 2.7.0
     * @access public
     *
     * @see Walker::start_el()
     * @see wp_list_comments()
     * @global int        $comment_depth
     * @global WP_Comment $comment
     *
     * @param string     $output  Used to append additional content. Passed by reference.
     * @param WP_Comment $comment Comment data object.
     * @param int        $depth   Optional. Depth of the current comment in reference to parents. Default 0.
     * @param array      $args    Optional. An array of arguments. Default empty array.
     * @param int        $id      Optional. ID of the current comment. Default 0 (unused).
     */
    public function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
        $depth++;
        $GLOBALS['comment_depth'] = $depth;
        $GLOBALS['comment'] = $comment;
 
        if ( !empty( $args['callback'] ) ) {
            ob_start();
            call_user_func( $args['callback'], $comment, $args, $depth );
            $output .= ob_get_clean();
            return;
        }
 
        if ( ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) && $args['short_ping'] ) {
            ob_start();
            $this->ping( $comment, $depth, $args );
            $output .= ob_get_clean();
        } elseif ( 'html5' === $args['format'] ) {
            ob_start();
            $this->html5_comment( $comment, $depth, $args );
            $output .= ob_get_clean();
        } else {
            ob_start();
            $this->comment( $comment, $depth, $args );
            $output .= ob_get_clean();
        }
    }
 
    /**
     * Ends the element output, if needed.
     *
     * @since 2.7.0
     * @access public
     *
     * @see Walker::end_el()
     * @see wp_list_comments()
     *
     * @param string     $output  Used to append additional content. Passed by reference.
     * @param WP_Comment $comment The current comment object. Default current comment.
     * @param int        $depth   Optional. Depth of the current comment. Default 0.
     * @param array      $args    Optional. An array of arguments. Default empty array.
     */
    public function end_el( &$output, $comment, $depth = 0, $args = array() ) {
        if ( !empty( $args['end-callback'] ) ) {
            ob_start();
            call_user_func( $args['end-callback'], $comment, $args, $depth );
            $output .= ob_get_clean();
            return;
        }
        if ( 'div' == $args['style'] )
            $output .= "</div><!-- #comment-## -->\n";
        else
            $output .= "</li><!-- #comment-## -->\n";
    }
 
    /**
     * Outputs a pingback comment.
     *
     * @since 3.6.0
     * @access protected
     *
     * @see wp_list_comments()
     *
     * @param WP_Comment $comment The comment object.
     * @param int        $depth   Depth of the current comment.
     * @param array      $args    An array of arguments.
     */
    protected function ping( $comment, $depth, $args ) {
        $tag = ( 'div' == $args['style'] ) ? 'div' : 'li';
		?>
        <<?php echo $tag; // xss ok ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( '', $comment ); ?>>
            <div class="comment-body">
                <?php esc_html_e( 'Pingback:', 'free-template' ); ?> <?php comment_author_link( $comment ); ?> <?php edit_comment_link( esc_html__( 'Edit', 'free-template' ), '<span class="edit-link">', '</span>' ); ?>
            </div>
		<?php
    }
 
    /**
     * Outputs a single comment.
     *
     * @since 3.6.0
     * @access protected
     *
     * @see wp_list_comments()
     *
     * @param WP_Comment $comment Comment to display.
     * @param int        $depth   Depth of the current comment.
     * @param array      $args    An array of arguments.
     */
    protected function comment( $comment, $depth, $args ) {
        if ( 'div' == $args['style'] ) {
            $tag = 'div';
            $add_below = 'comment';
        } else {
            $tag = 'li';
            $add_below = 'div-comment';
        }
		?>
        <<?php echo $tag; // xss ok ?> <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?> id="comment-<?php comment_ID(); ?>">
        <?php if ( 'div' != $args['style'] ) : ?>
        <div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
        <?php endif; ?>
        <div class="comment-author vcard">
            <?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
            <?php
                /* translators: %s: comment author link */
                printf( __( '%s <span class="says">says:</span>', 'free-template' ), // xss ok
                    sprintf( '<cite class="fn">%s</cite>', get_comment_author_link( $comment ) )
                );
            ?>
        </div>
        <?php if ( '0' == $comment->comment_approved ) : ?>
        <em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'free-template' ); ?></em>
        <br />
        <?php endif; ?>
 
        <div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
            <?php
                /* translators: 1: comment date, 2: comment time */
                printf( esc_html__( '%1$s at %2$s', 'free-template' ), get_comment_date( '', $comment ),  get_comment_time() ); ?></a><?php edit_comment_link( esc_html__( '(Edit)', 'free-template' ), '&nbsp;&nbsp;', '' );
            ?>
        </div>
 
        <?php comment_text( $comment, array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
 
        <?php
        comment_reply_link( array_merge( $args, array(
            'add_below' => $add_below,
            'depth'     => $depth,
            'max_depth' => $args['max_depth'],
            'before'    => '<div class="reply">',
            'after'     => '</div>'
        ) ) );
        ?>
 
        <?php if ( 'div' != $args['style'] ) : ?>
        </div>
        <?php endif;
    }
 
    /**
     * Outputs a comment in the HTML5 format.
     *
     * @since 3.6.0
     * @access protected
     *
     * @see wp_list_comments()
     *
     * @param WP_Comment $comment Comment to display.
     * @param int        $depth   Depth of the current comment.
     * @param array      $args    An array of arguments.
     */
    protected function html5_comment( $comment, $depth, $args ) {
        $tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
		?>
        <<?php echo $tag; // xss ok ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?>>
            <article id="div-comment-<?php comment_ID(); ?>" class="comment-body" data-aos="zoom-in">

                <div class="comment-author vcard panel box">
                    <?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
                </div><!-- .comment-author -->

                <div class="comment-content panel box">
					<footer class="comment-meta panel-heading has-arrow-right">
						<div class="comment-metadata">
							<?php
								printf( '<i class="fa fa-user" aria-hidden="true"></i> <b class="fn">%s</b>', get_comment_author_link( $comment ) );
							?>
							<div class="pull-right">
								<i class="fa fa-clock-o" aria-hidden="true"></i>
								<a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
									<time datetime="<?php comment_time( 'c' ); ?>">
										<?php
											/* translators: 1: comment date, 2: comment time */
											printf( esc_html__( '%1$s at %2$s', 'free-template' ), get_comment_date( '', $comment ), get_comment_time() );
										?>
									</time>
								</a>
							</div>
						</div><!-- .comment-metadata -->
	 
						<?php if ( '0' == $comment->comment_approved ) : ?>
						<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'free-template' ); ?></p>
						<?php endif; ?>
	                </footer><!-- .comment-meta -->
					<div class="panel-body">
						<?php comment_text(); ?>
					</div>
					<div class="panel-footer">
						<?php
						comment_reply_link( array_merge( $args, array(
							'add_below' => 'div-comment',
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
							'before'    => '<div class="reply btn btn-default btn-xs">',
							'after'     => '</div>'
						) ) );
						?>
						<div class="pull-right">
							<?php edit_comment_link( esc_html__( 'Edit', 'free-template' ), '<div class="btn btn-default comment-edit-btn btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;<span class="edit-link">', '</span></div>' ); ?>
						</div>
					</div>
                </div><!-- .comment-content -->
 
            </article><!-- .comment-body -->
		<?php
    }
}