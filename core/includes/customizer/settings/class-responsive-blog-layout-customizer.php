<?php
/**
 * Theme Options Customizer Options
 *
 * @package Responsive WordPress theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Responsive_Blog_Layout_Customizer' ) ) :
	/**
	 * Theme Options Customizer Options
	 */
	class Responsive_Blog_Layout_Customizer {

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {

			add_action( 'customize_register', array( $this, 'customizer_options' ) );

		}

		/**
		 * Customizer options
		 *
		 * @since 0.2
		 *
		 * @param  object $wp_customize WordPress customization option.
		 */
		public function customizer_options( $wp_customize ) {
			/**
			 * Section
			 */
			$wp_customize->add_section(
				'responsive_blog_layout',
				array(
					'title'    => esc_html__( 'Layout', 'responsive' ),
					'panel'    => 'responsive-blog-options',
					'priority' => 1,
				)
			);

			$blog_content_width_label = esc_html__( 'Main Content Width (%)', 'responsive' );
			responsive_drag_number_control( $wp_customize, 'blog_content_width', $blog_content_width_label, 'responsive_blog_layout', 1, 66, null, 100 );

			$entry_columns_label = esc_html__( 'Entry Columns', 'responsive' );
			responsive_drag_number_control( $wp_customize, 'blog_entry_columns', $entry_columns_label, 'responsive_blog_layout', 2, 1, null, 4 );

			// Display Masonry.
			$display_masonry_label = esc_html__( 'Enable Masonry Layout', 'responsive' );
			responsive_checkbox_control( $wp_customize, 'blog_entry_display_masonry', $display_masonry_label, 'responsive_blog_layout', 3, 0, 'responsive_active_blog_entry_columns_multi_column' );

			// Sidebar.
			$sidebar_label   = esc_html__( 'Sidebar Position', 'responsive' );
			$sidebar_choices = array(
				'right' => esc_html__( 'Right Sidebar', 'responsive' ),
				'left'  => esc_html__( 'Left Sidebar', 'responsive' ),
				'no'    => esc_html__( 'No Sidebar', 'responsive' ),
			);
			responsive_select_control( $wp_customize, 'blog_sidebar_position', $sidebar_label, 'responsive_blog_layout', 3, $sidebar_choices, 'right', null );

		}

	}

endif;

return new Responsive_Blog_Layout_Customizer();
