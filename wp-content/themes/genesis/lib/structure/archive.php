<?php
/**
 * Genesis Framework.
 *
 * WARNING: This file is part of the core Genesis Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Genesis\Archives
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/genesis/
 */

add_filter( 'genesis_term_intro_text_output', 'wpautop' );
add_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );
/**
 * Add custom headline and / or description to category / tag / taxonomy archive pages.
 *
 * If the page is not a category, tag or taxonomy term archive, or there's no term, or
 * no term meta set, then nothing extra is displayed.
 *
 * If there's a title to display, it is marked up as a level 1 heading.
 *
 * If there's a description to display, it runs through `wpautop()` before being added to a div.
 *
 * @since 1.3.0
 *
 * @global WP_Query $wp_query Query object.
 *
 * @return null Return early if not the correct archive page, or no term is found.
 */
function genesis_do_taxonomy_title_description() {

	global $wp_query;

	if ( ! is_category() && ! is_tag() && ! is_tax() )
		return;

	$term = is_tax() ? get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ) : $wp_query->get_queried_object();

	if ( ! $term )
		return;

	$headline = $intro_text = '';

	if ( $headline = get_term_meta( $term->term_id, 'headline', true ) ) {
		$headline = sprintf( '<h1 %s>%s</h1>', genesis_attr( 'archive-title' ), strip_tags( $headline ) );
	} else {
		if ( genesis_a11y( 'headings' ) ) {
			$headline = sprintf( '<h1 %s>%s</h1>', genesis_attr( 'archive-title' ), strip_tags( $term->name ) );
		}
	}

	if ( $intro_text = get_term_meta( $term->term_id, 'intro_text', true ) )
		$intro_text = apply_filters( 'genesis_term_intro_text_output', $intro_text );

	if ( $headline || $intro_text )
		printf( '<div %s>%s</div>', genesis_attr( 'taxonomy-archive-description' ), $headline . $intro_text );

}

add_filter( 'genesis_author_intro_text_output', 'wpautop' );
add_action( 'genesis_before_loop', 'genesis_do_author_title_description', 15 );
/**
 * Add custom headline and description to author archive pages.
 *
 * If we're not on an author archive page, then nothing extra is displayed.
 *
 * If there's a custom headline to display, it is marked up as a level 1 heading.
 *
 * If there's a description (intro text) to display, it is run through `wpautop()` before being added to a div.
 *
 * @since 1.4.0
 *
 * @return null Return early if not author archive.
 */
function genesis_do_author_title_description() {

	if ( ! is_author() )
		return;

	$headline = get_the_author_meta( 'headline', (int) get_query_var( 'author' ) );

	if ( '' == $headline && genesis_a11y( 'headings' ) ) {
		$headline = get_the_author_meta( 'display_name', (int) get_query_var( 'author' ) );
	}

	$intro_text = get_the_author_meta( 'intro_text', (int) get_query_var( 'author' ) );

	$headline   = $headline ? sprintf( '<h1 %s>%s</h1>', genesis_attr( 'archive-title' ), strip_tags( $headline ) ) : '';
	$intro_text = $intro_text ? apply_filters( 'genesis_author_intro_text_output', $intro_text ) : '';

	if ( $headline || $intro_text )
		printf( '<div %s>%s</div>', genesis_attr( 'author-archive-description' ), $headline . $intro_text );

}

add_action( 'genesis_before_loop', 'genesis_do_author_box_archive', 15 );
/**
 * Add author box to the top of author archive.
 *
 * If the headline and description are set to display the author box appears underneath them.
 *
 * @since 1.4.0
 *
 * @see genesis_do_author_title_and_description Author title and description.
 *
 * @return null Return early if not author archive or not page one.
 */
function genesis_do_author_box_archive() {

	if ( ! is_author() || get_query_var( 'paged' ) >= 2 )
		return;

	if ( get_the_author_meta( 'genesis_author_box_archive', get_query_var( 'author' ) ) )
		genesis_author_box( 'archive' );

}

add_filter( 'genesis_cpt_archive_intro_text_output', 'wpautop' );
add_action( 'genesis_before_loop', 'genesis_do_cpt_archive_title_description' );
/**
 * Add custom headline and description to relevant custom post type archive pages.
 *
 * If we're not on a post type archive page, then nothing extra is displayed.
 *
 * If there's a custom headline to display, it is marked up as a level 1 heading.
 *
 * If there's a description (intro text) to display, it is run through wpautop() before being added to a div.
 *
 * @since 2.0.0
 *
 * @return null Return early if not on post type archive or post type does not
 *              have `genesis-cpt-archives-settings` support
 */
function genesis_do_cpt_archive_title_description() {

	if ( ! is_post_type_archive() || ! genesis_has_post_type_archive_support() )
		return;

	$headline = genesis_get_cpt_option( 'headline' );

	if ( empty( $headline ) && genesis_a11y( 'headings' ) ) {
		$headline = post_type_archive_title( '', false );
	}

	$intro_text = genesis_get_cpt_option( 'intro_text' );

	$headline   = $headline ? sprintf( '<h1 %s>%s</h1>', genesis_attr( 'archive-title' ), strip_tags( $headline ) ) : '';
	$intro_text = $intro_text ? apply_filters( 'genesis_cpt_archive_intro_text_output', $intro_text ) : '';

	if ( $headline || $intro_text )
		printf( '<div %s>%s</div>', genesis_attr( 'cpt-archive-description' ), $headline . $intro_text );

}


add_action( 'genesis_before_loop', 'genesis_do_date_archive_title' );
/**
 * Add custom headline and description to date archive pages.
 *
 * If we're not on a date archive page, then nothing extra is displayed.
 *
 * @since 2.2.0
 *
 * @return null Return early if not on date archive.
 */
function genesis_do_date_archive_title() {

	if ( ! is_date() ) {
		return;
	}

	if ( is_day() ) {
		$headline = __( 'Archives for ', 'genesis' ) . get_the_date();
	} elseif ( is_month() ) {
		$headline = __( 'Archives for ', 'genesis' ) . single_month_title( ' ', false );
	} elseif ( is_year() ) {
		$headline = __( 'Archives for ', 'genesis' ) . get_query_var( 'year' );
	}

	if ( $headline ) {
		printf( '<div %s><h1 %s>%s</h1></div>', genesis_attr( 'date-archive-description' ), genesis_attr( 'archive-title' ), strip_tags( $headline ) );
	}

}

add_action( 'genesis_before_loop', 'genesis_do_blog_template_heading' );
/**
 * Add custom headline and description to blog template pages.
 *
 * If we're not on a blog template page, then nothing extra is displayed.
 *
 * @since 2.2.0
 *
 * @return null Return early if not on blog template archive, or `headings` is not
 *              enabled for Genesis accessibility.
 */
function genesis_do_blog_template_heading() {

	if ( ! is_page_template( 'page_blog.php' ) || ! genesis_a11y( 'headings' ) ) {
		return;
	}

	printf( '<div %s>', genesis_attr( 'blog-template-description' ) );
		genesis_do_post_title();
	echo '</div>';

}

add_action( 'genesis_before_loop', 'genesis_do_posts_page_heading' );
/**
 * Add custom headline and description to assigned posts page.
 *
 * If we're not on a posts page, then nothing extra is displayed.
 *
 * @since 2.2.1
 *
 * @return null Return early if `headings` is not enabled for Genesis accessibility, there is no
 *              page for posts assigned, this is not the home (posts) page, or this is not the page found at `/`.
 */
function genesis_do_posts_page_heading() {

	if ( ! genesis_a11y( 'headings' ) ) {
		return;
	}

	$posts_page = get_option( 'page_for_posts' );

	if ( is_null( $posts_page ) ) {
		return;
	}

	if ( ! is_home() || genesis_is_root_page() ) {
		return;
	}

	printf( '<div %s>', genesis_attr( 'posts-page-description' ) );
		printf( '<h1 %s>%s</h1>', genesis_attr( 'archive-title' ), get_the_title( $posts_page ) );
	echo '</div>';

}
