<?php
/**
 * Genesis Framework.
 *
 * WARNING: This file is part of the core Genesis Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Genesis\Sidebars
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/genesis/
 */

add_action( 'genesis_sidebar', 'genesis_do_sidebar' );
/**
 * Echo primary sidebar default content.
 *
 * Only shows if sidebar is empty, and current user has the ability to edit theme options (manage widgets).
 *
 * @since 1.2.0
 */
function genesis_do_sidebar() {

	if ( ! dynamic_sidebar( 'sidebar' ) && current_user_can( 'edit_theme_options' )  ) {
		genesis_default_widget_area_content( __( 'Primary Sidebar Widget Area', 'genesis' ) );
	}

}

add_action( 'genesis_sidebar_alt', 'genesis_do_sidebar_alt' );
/**
 * Echo alternate sidebar default content.
 *
 * Only shows if sidebar is empty, and current user has the ability to edit theme options (manage widgets).
 *
 * @since 1.2.0
 */
function genesis_do_sidebar_alt() {

	if ( ! dynamic_sidebar( 'sidebar-alt' ) && current_user_can( 'edit_theme_options' ) ) {
		genesis_default_widget_area_content( __( 'Secondary Sidebar Widget Area', 'genesis' ) );
	}

}

/**
 * Template for default widget area content.
 *
 * @since 2.0.0
 *
 * @param string $name Name of the widget area e.g. `__( 'Secondary Sidebar Widget Area', 'yourtextdomain' )`.
 */
function genesis_default_widget_area_content( $name ) {

	echo genesis_html5() ? '<section class="widget widget_text">' : '<div class="widget widget_text">';
	echo '<div class="widget-wrap">';

		$heading = ( genesis_a11y( 'headings' ) ? 'h3' : 'h4' );

		echo sprintf( '<%1$s class="widgettitle">%2$s</%1$s>', $heading, esc_html( $name ) );
		echo '<div class="textwidget"><p>';

			printf( __( 'This is the %s. You can add content to this area by visiting your <a href="%s">Widgets Panel</a> and adding new widgets to this area.', 'genesis' ), $name, admin_url( 'widgets.php' ) );

		echo '</p></div>';

	echo '</div>';
	echo genesis_html5() ? '</section>' : '</div>';

}
