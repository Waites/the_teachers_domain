<?php
/**
 * Genesis Framework.
 *
 * WARNING: This file is part of the core Genesis Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Genesis\Admin
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/genesis/
 */

/**
 * Term meta defaults.
 *
 * @since 2.2.6
 *
 * @return array Default term meta values.
 */
function genesis_term_meta_defaults() {

	return apply_filters( 'genesis_term_meta_defaults', array(
		'headline'            => '',
		'intro_text'          => '',
		'display_title'       => 0, // Vestigial.
		'display_description' => 0, // Vestigial.
		'doctitle'            => '',
		'description'         => '',
		'keywords'            => '',
		'layout'              => '',
		'noindex'             => 0,
		'nofollow'            => 0,
		'noarchive'           => 0,
	) );

}

add_action( 'admin_init', 'genesis_add_taxonomy_archive_options' );
/**
 * Add the archive options to each custom taxonomy edit screen.
 *
 * @since 1.6.0
 *
 * @see genesis_taxonomy_archive_options() Callback for headline and introduction fields.
 */
function genesis_add_taxonomy_archive_options() {

	foreach ( get_taxonomies( array( 'public' => true ) ) as $tax_name ) {
		add_action( $tax_name . '_edit_form', 'genesis_taxonomy_archive_options', 10, 2 );
	}

}

/**
 * Echo headline and introduction fields on the taxonomy term edit form.
 *
 * If populated, the values saved in these fields may display on taxonomy archives.
 *
 * @since 1.6.0
 *
 * @see genesis_add_taxonomy_archive_options() Callback caller.
 *
 * @param \stdClass $tag      Term object.
 * @param string    $taxonomy Name of the taxonomy.
 */
function genesis_taxonomy_archive_options( $tag, $taxonomy ) {

	$tax = get_taxonomy( $taxonomy );
	?>
	<h3><?php echo esc_html( $tax->labels->singular_name ) . ' ' . __( 'Archive Settings', 'genesis' ); ?></h3>
	<table class="form-table">
		<tbody>
			<tr class="form-field">
				<th scope="row"><label for="genesis-meta[headline]"><?php _e( 'Archive Headline', 'genesis' ); ?></label></th>
				<td>
					<input name="genesis-meta[headline]" id="genesis-meta[headline]" type="text" value="<?php echo esc_attr( get_term_meta( $tag->term_id, 'headline', true ) ); ?>" size="40" />
					<p class="description"><?php _e( 'Leave empty if you do not want to display a headline.', 'genesis' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row"><label for="genesis-meta-intro-text"><?php _e( 'Archive Intro Text', 'genesis' ); ?></label></th>
				<td>
					<?php wp_editor( get_term_meta( $tag->term_id, 'intro_text', true ), "genesis-meta-intro-text", array( 'textarea_name' => 'genesis-meta[intro_text]' ) ); ?>
					<p class="description"><?php _e( 'Leave empty if you do not want to display any intro text.', 'genesis' ); ?></p>
				</td>
			</tr>
		</tbody>
	</table>
	<?php

}

add_action( 'admin_init', 'genesis_add_taxonomy_seo_options' );
/**
 * Add the SEO options to each custom taxonomy edit screen.
 *
 * @since 1.3.0
 *
 * @see genesis_taxonomy_seo_options() Callback for SEO fields.
 */
function genesis_add_taxonomy_seo_options() {

	foreach ( get_taxonomies( array( 'public' => true ) ) as $tax_name )
		add_action( $tax_name . '_edit_form', 'genesis_taxonomy_seo_options', 10, 2 );

}

/**
 * Echo title, description, keywords and robots meta SEO fields on the taxonomy term edit form.
 *
 * If populated, the values saved in these fields may be used on taxonomy archives.
 *
 * @since 1.2.0
 *
 * @see genesis_add-taxonomy_seo_options() Callback caller.
 *
 * @param \stdClass $tag      Term object.
 * @param string    $taxonomy Name of the taxonomy.
 */
function genesis_taxonomy_seo_options( $tag, $taxonomy ) {

	?>
	<h3><?php _e( 'Theme SEO Settings', 'genesis' ); ?></h3>
	<table class="form-table">
		<tbody>
			<tr class="form-field">
				<th scope="row"><label for="genesis-meta[doctitle]"><?php _e( 'Custom Document Title', 'genesis' ); ?></label></th>
				<td>
					<input name="genesis-meta[doctitle]" id="genesis-meta[doctitle]" type="text" value="<?php echo esc_attr( get_term_meta( $tag->term_id, 'doctitle', true ) ); ?>" size="40" />
				</td>
			</tr>

			<tr class="form-field">
				<th scope="row"><label for="genesis-meta[description]"><?php _e( 'Meta Description', 'genesis' ); ?></label></th>
				<td>
					<textarea name="genesis-meta[description]" id="genesis-meta[description]" rows="5" cols="50" class="large-text"><?php echo esc_html( get_term_meta( $tag->term_id, 'description', true ) ); ?></textarea>
				</td>
			</tr>

			<tr class="form-field">
				<th scope="row"><label for="genesis-meta[keywords]"><?php _e( 'Meta Keywords', 'genesis' ); ?></label></th>
				<td>
					<input name="genesis-meta[keywords]" id="genesis-meta[keywords]" type="text" value="<?php echo esc_attr( get_term_meta( $tag->term_id, 'keywords', true ) ); ?>" size="40" />
					<p class="description"><?php _e( 'Comma separated list', 'genesis' ); ?></p>
				</td>
			</tr>

			<tr>
				<th scope="row"><?php _e( 'Robots Meta', 'genesis' ); ?></th>
				<td>
					<label for="genesis-meta[noindex]"><input name="genesis-meta[noindex]" id="genesis-meta[noindex]" type="checkbox" value="1" <?php checked( get_term_meta( $tag->term_id, 'noindex', true ) ); ?> />
					<?php printf( __( 'Apply %s to this archive?', 'genesis' ), genesis_code( 'noindex' ) ); ?></label><br />

					<label for="genesis-meta[nofollow]"><input name="genesis-meta[nofollow]" id="genesis-meta[nofollow]" type="checkbox" value="1" <?php checked( get_term_meta( $tag->term_id, 'nofollow', true ) ); ?> />
					<?php printf( __( 'Apply %s to this archive?', 'genesis' ), genesis_code( 'nofollow' ) ); ?></label><br />

					<label for="genesis-meta[noarchive]"><input name="genesis-meta[noarchive]" id="genesis-meta[noarchive]" type="checkbox" value="1" <?php checked( get_term_meta( $tag->term_id, 'noarchive', true ) ); ?> />
					<?php printf( __( 'Apply %s to this archive?', 'genesis' ), genesis_code( 'noarchive' ) ); ?></label>
				</td>
			</tr>
		</tbody>
	</table>
	<?php

}

add_action( 'admin_init', 'genesis_add_taxonomy_layout_options' );
/**
 * Add the layout options to each custom taxonomy edit screen.
 *
 * @since 1.4.0
 *
 * @see genesis_taxonomy_layout_options() Callback for layout selector.
 */
function genesis_add_taxonomy_layout_options() {

	if ( ! current_theme_supports( 'genesis-archive-layouts' ) ) {
		return;
	}

	if ( ! genesis_has_multiple_layouts() ) {
		return;
	}

	foreach ( get_taxonomies( array( 'public' => true ) ) as $tax_name ) {
		add_action( $tax_name . '_edit_form', 'genesis_taxonomy_layout_options', 10, 2 );
	}

}

/**
 * Echo the layout options on the taxonomy term edit form.
 *
 * @since 1.4.0
 *
 * @see genesis_add_taxonomy_layout_options() Callback caller.
 *
 * @param \stdClass $tag      Term object.
 * @param string    $taxonomy Name of the taxonomy.
 */
function genesis_taxonomy_layout_options( $tag, $taxonomy ) {

	?>
	<h3><?php _e( 'Layout Settings', 'genesis' ); ?></h3>

	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row"><?php _e( 'Choose Layout', 'genesis' ); ?></th>
				<td>
					<fieldset class="genesis-layout-selector">
						<legend class="screen-reader-text"><?php _e( 'Choose Layout', 'genesis' ); ?></legend>

						<p><input type="radio" class="default-layout" name="genesis-meta[layout]" id="default-layout" value="" <?php checked( get_term_meta( $tag->term_id, 'layout', true ), '' ); ?> /> <label for="default-layout" class="default"><?php printf( __( 'Default Layout set in <a href="%s">Theme Settings</a>', 'genesis' ), menu_page_url( 'genesis', 0 ) ); ?></label></p>
						<?php genesis_layout_selector( array( 'name' => 'genesis-meta[layout]', 'selected' => get_term_meta( $tag->term_id, 'layout', true ), 'type' => 'site' ) ); ?>

					</fieldset>
				</td>
			</tr>
		</tbody>
	</table>
	<?php

}

add_filter( 'get_term', 'genesis_get_term_filter', 10, 2 );
/**
 * For backward compatibility only.
 *
 * Sets $term->meta to empty array. All calls to $term->meta->key will be unset unless force set by `genesis_term_meta` filter.
 *
 * @since 1.2.0
 *
 * @param object $term     Database row object.
 * @param string $taxonomy Taxonomy name that $term is part of.
 * @return object Database row object.
 */
function genesis_get_term_filter( $term, $taxonomy ) {

	// Do nothing, if $term is not object.
	if ( ! is_object( $term ) ) {
		return $term;
	}

	// Do nothing, if called in the context of creating a term via an ajax call.
	if ( did_action( 'wp_ajax_add-tag' ) ) {
		return $term;
	}

	// Still set $term->meta and apply filter, for backward compatibility.
	$term->meta = apply_filters( 'genesis_term_meta', array(), $term, $taxonomy );

	return $term;

}

add_filter( 'get_terms', 'genesis_get_terms_filter', 10, 2 );
/**
 * Add Genesis term-meta data to functions that return multiple terms.
 *
 * @since 2.0.0
 *
 * @param array  $terms    Database row objects.
 * @param string $taxonomy Taxonomy name that $terms are part of.
 * @return array Database row objects.
 */
function genesis_get_terms_filter( array $terms, $taxonomy ) {

	foreach( $terms as $term ) {
		$term = genesis_get_term_filter( $term, $taxonomy );
	}

	return $terms;

}

add_filter( 'get_term_metadata', 'genesis_term_meta_filter', 10, 4 );
/**
 * Maintain backward compatibility with the older `genesis_term_meta_{$key}` filter so old filter functions will still work.
 *
 * @since 2.3.0
 *
 * @param string|array $value     The term meta value.
 * @param int          $object_id The term ID.
 * @param string       $meta_key  Meta key.
 * @param bool         $single    Whether to return only the first value of the specified $meta_key.
 * @return mixed Filtered term meta value.
 */
function genesis_term_meta_filter( $value, $object_id, $meta_key, $single ) {

	return apply_filters( "genesis_term_meta_{$meta_key}", $value, get_term_field( 'slug', $object_id ), null );

}

add_action( 'edit_term', 'genesis_term_meta_save', 10, 2 );
/**
 * Save term meta data.
 *
 * Fires when a user edits and saves a term.
 *
 * @since 1.2.0
 *
 * @param int $term_id Term ID.
 * @param int $tt_id   Term Taxonomy ID.
 */
function genesis_term_meta_save( $term_id, $tt_id ) {

	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		return;
	}

	$values = isset( $_POST['genesis-meta'] ) ? (array) $_POST['genesis-meta'] : array();

	$values = wp_parse_args( $values, genesis_term_meta_defaults() );

	if ( ! current_user_can( 'unfiltered_html' ) && isset( $values['archive_description'] ) )
		$values['archive_description'] = genesis_formatting_kses( $values['archive_description'] );

	foreach ( $values as $key => $value ) {
		update_term_meta( $term_id, $key, $value );
	}

}

add_action( 'delete_term', 'genesis_term_meta_delete', 10, 2 );
/**
 * Delete term meta data.
 *
 * Fires when a user deletes a term.
 *
 * @since 1.2.0
 *
 * @param int $term_id Term ID.
 * @param int $tt_id   Taxonomy Term ID.
 */
function genesis_term_meta_delete( $term_id, $tt_id ) {

	foreach ( genesis_term_meta_defaults() as $key => $value ) {
		delete_term_meta( $term_id, $key );
	}

}

add_action( 'split_shared_term', 'genesis_split_shared_term' );
/**
 * Create new term meta record for split terms.
 *
 * When WordPress splits terms, ensure that the term meta gets preserved for the newly created term.
 *
 * @since 2.2.0
 *
 * @param int $old_term_id The ID of the term being split.
 * @param int $new_term_id The ID of the newly created term.
 */
function genesis_split_shared_term( $old_term_id, $new_term_id ) {

	$term_meta = (array) get_option( 'genesis-term-meta' );

	if ( ! isset( $term_meta[ $old_term_id ] ) ) {
		return;
	}

	$term_meta[ $new_term_id ] = $term_meta[ $old_term_id ];

	update_option( 'genesis-term-meta', $term_meta );

}
