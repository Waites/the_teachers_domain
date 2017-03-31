<?php
/**
 * Genesis Framework.
 *
 * WARNING: This file is part of the core Genesis Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Genesis\Comments
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/genesis/
 */

add_action( 'genesis_after_post', 'genesis_get_comments_template' );
add_action( 'genesis_after_entry', 'genesis_get_comments_template' );
/**
 * Output the comments at the end of entries.
 *
 * Load comments only if we are on a post, page, or CPT that supports comments, and only if comments or trackbacks are enabled.
 *
 * @since 1.1.0
 *
 * @return null Return early if post type does not support `comments`.
 */
function genesis_get_comments_template() {

	if ( ! post_type_supports( get_post_type(), 'comments' ) )
		return;

	if ( is_singular() && ! in_array( get_post_type(), array( 'post', 'page' ) ) ) {
		comments_template( '', true );
	} elseif ( is_singular( 'post' ) && ( genesis_get_option( 'trackbacks_posts' ) || genesis_get_option( 'comments_posts' ) ) ) {
		comments_template( '', true );
	} elseif ( is_singular( 'page' ) && ( genesis_get_option( 'trackbacks_pages' ) || genesis_get_option( 'comments_pages' ) ) ) {
		comments_template( '', true );
	}

}

add_action( 'genesis_comments', 'genesis_do_comments' );
/**
 * Echo Genesis default comment structure.
 *
 * Does the `genesis_list_comments` action.
 *
 * Applies the `genesis_title_comments`, `genesis_prev_comments_link_text`, `genesis_next_comments_link_text`, and
 * `genesis_comments_closed_text` filters.
 *
 * @since 1.1.2
 *
 * @global WP_Query $wp_query Query object.
 *
 * @return null Return early if on a page with Genesis page comments off, or on a post with Genesis post comments off.
 */
function genesis_do_comments() {

	global $wp_query;

	// Bail if comments are off for this post type.
	if ( ( is_page() && ! genesis_get_option( 'comments_pages' ) ) || ( is_single() && ! genesis_get_option( 'comments_posts' ) ) )
		return;

	if ( have_comments() && ! empty( $wp_query->comments_by_type['comment'] ) ) {

		genesis_markup( array(
			'open'   => '<div %s>',
			'context' => 'entry-comments',
		) );

		echo apply_filters( 'genesis_title_comments', __( '<h3>Comments</h3>', 'genesis' ) );
		printf( '<ol %s>', genesis_attr( 'comment-list' ) );
			do_action( 'genesis_list_comments' );
		echo '</ol>';

		// Comment Navigation.
		$prev_link = get_previous_comments_link( apply_filters( 'genesis_prev_comments_link_text', '' ) );
		$next_link = get_next_comments_link( apply_filters( 'genesis_next_comments_link_text', '' ) );

		if ( $prev_link || $next_link ) {

			$pagination = sprintf( '<div class="pagination-previous alignleft">%s</div>', $prev_link );
			$pagination .= sprintf( '<div class="pagination-next alignright">%s</div>', $next_link );

			genesis_markup( array(
				'open'    => '<div %s>',
				'close'   => '</div>',
				'content' => $pagination,
				'context' => 'comments-pagination',
			) );

		}

		genesis_markup( array(
			'close'   => '</div>',
			'context' => 'entry-comments',
		) );

	}
	// No comments so far.
	elseif ( 'open' === get_post()->comment_status && $no_comments_text = apply_filters( 'genesis_no_comments_text', '' ) ) {
		if ( genesis_html5() )
			echo sprintf( '<div %s>', genesis_attr( 'entry-comments' ) ) . $no_comments_text . '</div>';
		else
			echo '<div id="comments">' . $no_comments_text . '</div>';
	}
	elseif ( $comments_closed_text = apply_filters( 'genesis_comments_closed_text', '' ) ) {
		if ( genesis_html5() )
			echo sprintf( '<div %s>', genesis_attr( 'entry-comments' ) ) . $comments_closed_text . '</div>';
		else
			echo '<div id="comments">' . $comments_closed_text . '</div>';
	}

}

add_action( 'genesis_pings', 'genesis_do_pings' );
/**
 * Echo Genesis default trackback structure.
 *
 * Does the `genesis_list_args` action.
 *
 * Applies the `genesis_no_pings_text` filter.
 *
 * @since 1.1.2
 *
 * @global WP_Query $wp_query Query object.
 *
 * @return null Return early if on a page with Genesis page trackbacks off, or on a
 *              post with Genesis post trackbacks off.
 */
function genesis_do_pings() {

	global $wp_query;

	// Bail if trackbacks are off for this post type.
	if ( ( is_page() && ! genesis_get_option( 'trackbacks_pages' ) ) || ( is_single() && ! genesis_get_option( 'trackbacks_posts' ) ) )
		return;

	// If have pings.
	if ( have_comments() && !empty( $wp_query->comments_by_type['pings'] ) ) {

		genesis_markup( array(
			'open'    => '<div %s>',
			'context' => 'entry-pings',
		) );

		echo apply_filters( 'genesis_title_pings', __( '<h3>Trackbacks</h3>', 'genesis' ) );
		echo '<ol class="ping-list">';
			do_action( 'genesis_list_pings' );
		echo '</ol>';

		genesis_markup( array(
			'close'   => '</div>',
			'context' => 'entry-pings',
		) );

	} else {

		echo apply_filters( 'genesis_no_pings_text', '' );

	}

}

add_action( 'genesis_list_comments', 'genesis_default_list_comments' );
/**
 * Output the list of comments.
 *
 * Applies the `genesis_comment_list_args` filter.
 *
 * @since 1.0.0
 *
 * @see genesis_html5_comment_callback() HTML5 callback.
 * @see genesis_comment_callback()       XHTML callback.
 */
function genesis_default_list_comments() {

	$defaults = array(
		'type'        => 'comment',
		'avatar_size' => 48,
		'format'      => 'html5', // Not necessary, but a good example.
		'callback'    => genesis_html5() ? 'genesis_html5_comment_callback' : 'genesis_comment_callback',
	);

	$args = apply_filters( 'genesis_comment_list_args', $defaults );

	wp_list_comments( $args );

}

add_action( 'genesis_list_pings', 'genesis_default_list_pings' );
/**
 * Output the list of trackbacks.
 *
 * Applies the `genesis_ping_list_args` filter.
 *
 * @since 1.0.0
 */
function genesis_default_list_pings() {

	$args = apply_filters( 'genesis_ping_list_args', array(
		'type' => 'pings',
	) );

	wp_list_comments( $args );

}

/**
 * Comment callback for {@link genesis_default_list_comments()} if HTML5 is not active.
 *
 * Does `genesis_before_comment` and `genesis_after_comment` actions.
 *
 * Applies `comment_author_says_text` and `genesis_comment_awaiting_moderation` filters.
 *
 * @since 1.0.0
 *
 * @param stdClass $comment Comment object.
 * @param array    $args    Comment args.
 * @param int      $depth   Depth of current comment.
 */
function genesis_comment_callback( $comment, array $args, $depth ) {

	$GLOBALS['comment'] = $comment; ?>

	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">

		<?php do_action( 'genesis_before_comment' ); ?>

		<div class="comment-header">
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment, $args['avatar_size'] ); ?>
				<?php printf( __( '<cite class="fn">%s</cite> <span class="says">%s:</span>', 'genesis' ), get_comment_author_link(), apply_filters( 'comment_author_says_text', __( 'says', 'genesis' ) ) ); ?>
		 	</div>

			<div class="comment-meta commentmetadata">
				<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><?php printf( __( '%1$s at %2$s', 'genesis' ), get_comment_date(), get_comment_time() ); ?></a>
				<?php edit_comment_link( __( '(Edit)', 'genesis' ), '' ); ?>
			</div>
		</div>

		<div class="comment-content">
			<?php if ( ! $comment->comment_approved ) : ?>
				<p class="alert"><?php echo apply_filters( 'genesis_comment_awaiting_moderation', __( 'Your comment is awaiting moderation.', 'genesis' ) ); ?></p>
			<?php endif; ?>

			<?php comment_text(); ?>
		</div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div>

		<?php do_action( 'genesis_after_comment' );

		// No ending </li> tag because of comment threading.
}

/**
 * Comment callback for {@link genesis_default_list_comments()} if HTML5 is active.
 *
 * Does `genesis_before_comment` and `genesis_after_comment` actions.
 *
 * Applies `comment_author_says_text` and `genesis_comment_awaiting_moderation` filters.
 *
 * @since 2.0.0
 *
 * @param stdClass $comment Comment object.
 * @param array    $args    Comment args.
 * @param int      $depth   Depth of current comment.
 */
function genesis_html5_comment_callback( $comment, array $args, $depth ) {

	$GLOBALS['comment'] = $comment; ?>

	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
	<article <?php echo genesis_attr( 'comment' ); ?>>

		<?php do_action( 'genesis_before_comment' ); ?>

		<header <?php echo genesis_attr( 'comment-header' ); ?>>
			<p <?php echo genesis_attr( 'comment-author' ); ?>>
				<?php
				echo get_avatar( $comment, $args['avatar_size'] );

				$author = get_comment_author();
				$url    = get_comment_author_url();

				if ( ! empty( $url ) && 'http://' !== $url ) {
					$author = sprintf( '<a href="%s" %s>%s</a>', esc_url( $url ), genesis_attr( 'comment-author-link' ), $author );
				}

				/**
				 * Filter the "comment author says" text.
				 *
				 * Allows developer to filter the "comment author says" text so it can say something different, or nothing at all.
				 *
				 * @since unknown
				 *
				 * @param string $text Comment author says text.
				 */
				$comment_author_says_text = apply_filters( 'comment_author_says_text', __( 'says', 'genesis' ) );

				if ( ! empty( $comment_author_says_text ) ) {
					$comment_author_says_text = '<span class="says">' . $comment_author_says_text . '</span>';
				}

				printf( '<span itemprop="name">%s</span> %s', $author, $comment_author_says_text );
				?>
			</p>

			<?php
			/**
			 * Allows developer to control whether to print the comment date.
			 *
			 * @since 2.2.0
			 *
			 * @param bool   $comment_date Whether to print the comment date.
			 * @param string $post_type    The current post type.
			 */
			$comment_date = apply_filters( 'genesis_show_comment_date', true, get_post_type() );

			if ( $comment_date ) {
				printf( '<p %s>', genesis_attr( 'comment-meta' ) );
				printf( '<time %s>', genesis_attr( 'comment-time' ) );
				printf( '<a href="%s" %s>', esc_url( get_comment_link( $comment->comment_ID ) ), genesis_attr( 'comment-time-link' ) );
				echo    esc_html( get_comment_date() ) . ' ' . __( 'at', 'genesis' ) . ' ' . esc_html( get_comment_time() );
				echo    '</a></time></p>';
			}

			edit_comment_link( __( '(Edit)', 'genesis' ), ' ' );
			?>
		</header>

		<div <?php echo genesis_attr( 'comment-content' ); ?>>
			<?php if ( ! $comment->comment_approved ) : ?>
				<?php
				/**
				 * Filter the "comment awaiting moderation" text.
				 *
				 * Allows developer to filter the "comment awaiting moderation" text so it can say something different, or nothing at all.
				 *
				 * @since unknown
				 *
				 * @param string $text Comment awaiting moderation text.
				 */
				$comment_awaiting_moderation_text = apply_filters( 'genesis_comment_awaiting_moderation', __( 'Your comment is awaiting moderation.', 'genesis' ) );
				?>
				<p class="alert"><?php echo $comment_awaiting_moderation_text; ?></p>
			<?php endif; ?>

			<?php comment_text(); ?>
		</div>

		<?php
		comment_reply_link( array_merge( $args, array(
			'depth'  => $depth,
			'before' => sprintf( '<div %s>', genesis_attr( 'comment-reply' ) ),
			'after'  => '</div>',
		) ) );
		?>

		<?php do_action( 'genesis_after_comment' ); ?>

	</article>
	<?php
	// No ending </li> tag because of comment threading.
}

add_action( 'genesis_comment_form', 'genesis_do_comment_form' );
/**
 * Optionally show the comment form.
 *
 * Genesis asks WP for the HTML5 version of the comment form - it uses {@link genesis_comment_form_args()} to revert to
 * XHTML form fields when child theme doesn't support HTML5.
 *
 * @since 1.0.0
 *
 * @return null Return early if comments are closed via Genesis for this page or post.
 */
function genesis_do_comment_form() {

	// Bail if comments are closed for this post type.
	if ( ( is_page() && ! genesis_get_option( 'comments_pages' ) ) || ( is_single() && ! genesis_get_option( 'comments_posts' ) ) )
		return;

	comment_form( array( 'format' => 'html5' ) );

}

add_filter( 'comment_form_defaults', 'genesis_comment_form_args' );
/**
 * Filter the default comment form arguments, used by `comment_form()`.
 *
 * Applies only to XHTML child themes, since Genesis uses default HTML5 comment form where possible.
 *
 * Applies `genesis_comment_form_args` filter.
 *
 * @since 1.8.0
 *
 * @global string $user_identity Display name of the user.
 *
 * @param array $defaults Comment form default arguments.
 * @return array Filtered comment form default arguments.
 */
function genesis_comment_form_args( array $defaults ) {

	// Use WordPress default HTML5 comment form if themes supports HTML5.
	if ( genesis_html5() )
		return $defaults;

	global $user_identity;

	$commenter = wp_get_current_commenter();
	$req       = get_option( 'require_name_email' );
	$aria_req  = ( $req ? ' aria-required="true"' : '' );

	$author = '<p class="comment-form-author">' .
	          '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" tabindex="1"' . $aria_req . ' />' .
	          '<label for="author">' . __( 'Name', 'genesis' ) . '</label> ' .
	          ( $req ? '<span class="required">*</span>' : '' ) .
	          '</p>';

	$email = '<p class="comment-form-email">' .
	         '<input id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" tabindex="2"' . $aria_req . ' />' .
	         '<label for="email">' . __( 'Email', 'genesis' ) . '</label> ' .
	         ( $req ? '<span class="required">*</span>' : '' ) .
	         '</p>';

	$url = '<p class="comment-form-url">' .
	       '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" tabindex="3" />' .
	       '<label for="url">' . __( 'Website', 'genesis' ) . '</label>' .
	       '</p>';

	$comment_field = '<p class="comment-form-comment">' .
	                 '<textarea id="comment" name="comment" cols="45" rows="8" tabindex="4" aria-required="true"></textarea>' .
	                 '</p>';

	$args = array(
		'comment_field'        => $comment_field,
		'title_reply'          => __( 'Speak Your Mind', 'genesis' ),
		'comment_notes_before' => '',
		'comment_notes_after'  => '',
		'fields'               => array(
			'author' => $author,
			'email'  => $email,
			'url'    => $url,
		),
	);

	// Merge $args with $defaults.
	$args = wp_parse_args( $args, $defaults );

	// Return filterable array of $args, along with other optional variables.
	return apply_filters( 'genesis_comment_form_args', $args, $user_identity, get_the_ID(), $commenter, $req, $aria_req );

}

add_filter( 'get_comments_link', 'genesis_comments_link_filter', 10, 2 );
/**
 * Filter the comments link. If post has comments, link to #comments div. If no, link to #respond div.
 *
 * @since 2.0.1
 *
 * @param string      $link    Post comments permalink with '#comments' appended.
 * @param int|WP_Post $post_id Post ID or WP_Post object.
 * @return string URL to comments if they exist, otherwise URL to the comment form.
 */
function genesis_comments_link_filter( $link, $post_id ) {

	if ( 0 == get_comments_number() )
		return get_permalink( $post_id ) . '#respond';

	return $link;

}
