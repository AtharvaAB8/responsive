<?php
/**
 * button Customizer Options
 *
 * @package Responsive WordPress theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Responsive_layout_Customizer' ) ) :

	class Responsive_layout_Customizer {

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
		 * @return [type]               [description]
		 */
		public function customizer_options( $wp_customize ) {

			$wp_customize->add_panel( 'responsive-layout-options',
				array(
			 		'title' => __( 'Layout' ),
			 		'description' => 'Layout Options', // Include html tags such as <p>.
			 		'priority' => 21, // Mixed with top-level-section hierarchy.
				)
			);

			/**
			 * Section
			 */
			$wp_customize->add_section(
				'responsive_layout_section',
				array(
					'title'    => esc_html__( 'Container', 'responsive' ),
					'panel'    => 'responsive-layout-options',
					'priority' => 200,
				)
			);
			$wp_customize->add_setting(
				'responsive_layout_styles',
				array(
					'transport' => 'refresh',
					'default'   => 'boxed',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize,
					'responsive_layout_styles',
					array(
						'label'    => __( 'Layout', 'responsive' ),
						'settings' => 'responsive_layout_styles',
						'priority' => 10,
						'section'  => 'responsive_layout_section',
						'type'     => 'select',
						'choices'  => array(
							'boxed'     => 'Boxed',
							'fullwidth' => 'Fullwidth',
						),
					)
				)
			);
			/**
			 * Section
			 */
			$wp_customize->add_section(
				'responsive_single_post_section',
				array(
					'title'    => esc_html__( 'Single Post', 'responsive' ),
					'panel'    => 'responsive-layout-options',
					'priority' => 208,
				)
			);
			$wp_customize->add_setting(
				'responsive_single_post_layout',
				array(
					'transport' => 'postMessage',
					'default'   => 'boxed',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize,
					'responsive_single_post_layout',
					array(
						'label'    => __( 'Layout', 'responsive' ),
						'settings' => 'responsive_single_post_layout',
						'priority' => 10,
						'section'  => 'responsive_single_post_section',
						'type'     => 'select',
						'choices'  => array(
							'boxed'         => 'Boxed',
							'content-boxed' => 'Content Boxed',
						),
					)
				)
			);
			$wp_customize->add_setting( 'responsive_theme_options[single_post_layout_default]',
				array(
					'sanitize_callback' => 'responsive_sanitize_default_layouts',
					'type' => 'option'
				)
			);
			$wp_customize->add_control( 'res_single_post_layout_default',
				array(
					'label'                 => __( 'Sidebar Position', 'responsive' ),
					'section'               => 'responsive_single_post_section',
					'settings'              => 'responsive_theme_options[single_post_layout_default]',
					'type'                  => 'select',
					'choices'               => Responsive_Options::valid_layouts()
				)
			);
			/**
			 * Blog Single Elements Positioning
			 */
			$wp_customize->add_setting(
				'responsive_blog_single_elements_positioning',
				array(
					'default'           => array( 'featured_image', 'title', 'meta', 'content', 'author_box' ),
					'sanitize_callback' => 'responsive_sanitize_multi_choices',
				)
			);

			$wp_customize->add_control(
				new Responsive_Customizer_Sortable_Control(
					$wp_customize,
					'responsive_blog_single_elements_positioning',
					array(
						'label'    => esc_html__( 'Post Elements', 'responsive' ),
						'section'  => 'responsive_single_post_section',
						'settings' => 'responsive_blog_single_elements_positioning',
						'priority' => 10,
						'choices'  => responsive_blog_single_elements(),
					)
				)
			);

			/**
			 * Blog Single Meta
			 */
			$wp_customize->add_setting(
				'responsive_blog_single_meta',
				array(
					'default'           => array( 'author', 'date', 'categories', 'comments' ),
					'sanitize_callback' => 'responsive_sanitize_multi_choices',
				)
			);

			$wp_customize->add_control(
				new Responsive_Customizer_Sortable_Control(
					$wp_customize,
					'responsive_blog_single_meta',
					array(
						'label'    => esc_html__( 'Meta Elements', 'responsive' ),
						'section'  => 'responsive_single_post_section',
						'settings' => 'responsive_blog_single_meta',
						'priority' => 10,
						'choices'  => apply_filters(
							'responsive_blog_meta_choices',
							array(
								'author'     => esc_html__( 'Author', 'responsive' ),
								'date'       => esc_html__( 'Date', 'responsive' ),
								'categories' => esc_html__( 'Categories', 'responsive' ),
								'comments'   => esc_html__( 'Comments', 'responsive' ),
							)
						),
					)
				)
			);
			/**
			 * Section
			 */
			$wp_customize->add_section(
				'responsive_blog_entries_section',
				array(
					'title'    => esc_html__( 'Blog Entries', 'responsive' ),
					'panel'    => 'responsive-layout-options',
					'priority' => 207,
				)
			);
			$wp_customize->add_setting(
				'responsive_blog_entries_layout',
				array(
					'transport' => 'postMessage',
					'default'   => 'boxed',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize,
					'responsive_blog_entries_layout',
					array(
						'label'    => __( 'Layout', 'responsive' ),
						'settings' => 'responsive_blog_entries_layout',
						'priority' => 10,
						'section'  => 'responsive_blog_entries_section',
						'type'     => 'select',
						'choices'  => array(
							'boxed'         => 'Boxed',
							'content-boxed' => 'Content Boxed',
						),
					)
				)
			);
			// $wp_customize->add_setting(
			// 	'responsive_blog_entires_sidebar_position',
			// 	array(
			// 		'transport' => 'postMessage',
			// 		'default'   => 'no-sidebar',
			// 	)
			// );
			// $wp_customize->add_control(
			// 	new WP_Customize_Control(
			// 		$wp_customize,
			// 		'responsive_blog_entires_sidebar_position',
			// 		array(
			// 			'label'    => __( 'Sidebar Position', 'responsive' ),
			// 			'settings' => 'responsive_blog_entires_sidebar_position',
			// 			'priority' => 10,
			// 			'section'  => 'responsive_blog_entries_section',
			// 			'type'     => 'select',
			// 			'choices'  => array(
			// 				'no-sidebar'         => 'No Sidebar',
			// 				'left-sidebar'       => 'Left Sidebar',
			// 				'right-sidebar'      => 'Right Sidebar',
			// 				'left-right-sidebar' => 'Left & Right Sidebar',
			// 			),
			// 		)
			// 	)
			// );
			$wp_customize->add_setting(
				'responsive_theme_options[blog_posts_index_layout_default]',
				array(
					'sanitize_callback' => 'responsive_sanitize_blog_default_layouts',
					'type' => 'option'
				)
			);
			$wp_customize->add_control(
				'res_hblog_posts_index_layout_default',
				array(
					'label'                 => __( 'Default Blog Posts Index Layout', 'responsive' ),
					'section'               => 'responsive_blog_entries_section',
					'settings'              => 'responsive_theme_options[blog_posts_index_layout_default]',
					'type'                  => 'select',
					'choices'               => Responsive_Options::blog_valid_layouts()
				)
			);
			/**
			 * Blog Entries Elements Positioning
			 */
			$wp_customize->add_setting(
				'responsive_blog_entry_elements_positioning',
				array(
					'default'           => array( 'featured_image', 'title', 'meta', 'content' ),
					'sanitize_callback' => 'responsive_sanitize_multi_choices',
				)
			);

			$wp_customize->add_control(
				new Responsive_Customizer_Sortable_Control(
					$wp_customize,
					'responsive_blog_entry_elements_positioning',
					array(
						'label'           => esc_html__( 'Post Elements', 'responsive' ),
						'section'         => 'responsive_blog_entries_section',
						'settings'        => 'responsive_blog_entry_elements_positioning',
						'priority'        => 10,
						'choices'         => responsive_blog_entry_elements(),
					//	'active_callback' => 'responsive_cac_hasnt_thumbnail_blog_style',
					)
				)
			);

			/**
			 * Blog Entries Meta
			 */
			$wp_customize->add_setting(
				'responsive_blog_entry_meta',
				array(
					'default'           => apply_filters( 'responsive_blog_meta_default', array( 'author', 'date', 'categories', 'comments' ) ),
					'sanitize_callback' => 'responsive_sanitize_multi_choices',
				)
			);

			$wp_customize->add_control(
				new Responsive_Customizer_Sortable_Control(
					$wp_customize,
					'responsive_blog_entry_meta',
					array(
						'label'           => esc_html__( 'Post Meta', 'responsive' ),
						'section'         => 'responsive_blog_entries_section',
						'settings'        => 'responsive_blog_entry_meta',
						'priority'        => 10,
						'choices'         => apply_filters(
							'responsive_blog_meta_choices',
							array(
								'author'     => esc_html__( 'Author', 'responsive' ),
								'date'       => esc_html__( 'Date', 'responsive' ),
								'categories' => esc_html__( 'Categories', 'responsive' ),
								'comments'   => esc_html__( 'Comments', 'responsive' ),
							)
						),
				//		'active_callback' => 'responsive_cac_hasnt_thumbnail_blog_style',
					)
				)
			);

			$wp_customize->add_section(
				'responsive_page_section',
				array(
					'title'    => esc_html__( 'Page', 'responsive' ),
					'panel'    => 'responsive-layout-options',
					'priority' => 209,
				)
			);
			$wp_customize->add_setting(
				'responsive_page_layout',
				array(
					'transport' => 'postMessage',
					'default'   => 'boxed',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize,
					'responsive_page_layout',
					array(
						'label'    => __( 'Layout', 'responsive' ),
						'settings' => 'responsive_page_layout',
						'priority' => 10,
						'section'  => 'responsive_page_section',
						'type'     => 'select',
						'choices'  => array(
							'boxed'         => 'Boxed',
							'content-boxed' => 'Content Boxed',
						),
					)
				)
			);
			// $wp_customize->add_setting(
			// 	'responsive_sidebar_position',
			// 	array(
			// 		'transport' => 'postMessage',
			// 		'default'   => 'no-sidebar',
			// 	)
			// );
			// $wp_customize->add_control(
			// 	new WP_Customize_Control(
			// 		$wp_customize,
			// 		'responsive_sidebar_position',
			// 		array(
			// 			'label'    => __( 'Sidebar Position', 'responsive' ),
			// 			'settings' => 'responsive_sidebar_position',
			// 			'priority' => 10,
			// 			'section'  => 'responsive_page_section',
			// 			'type'     => 'select',
			// 			'choices'  => array(
			// 				'no-sidebar'         => 'No Sidebar',
			// 				'left-sidebar'       => 'Left Sidebar',
			// 				'right-sidebar'      => 'Right Sidebar',
			// 				'left-right-sidebar' => 'Left & Right Sidebar',
			// 			),
			// 		)
			// 	)
			// );
			$wp_customize->add_setting(
				'responsive_theme_options[static_page_layout_default]',
				array(
					'sanitize_callback' => 'responsive_sanitize_default_layouts',
					'type'              => 'option'
				)
			);
			$wp_customize->add_control(
				'res_static_page_layout_default',
				array(
					'label'    => __( 'Sidebar Position', 'responsive' ),
					'section'  => 'responsive_page_section',
					'settings' => 'responsive_theme_options[static_page_layout_default]',
					'type'     => 'select',
					'choices'  => Responsive_Options::valid_layouts()
				)
			);
			/**
			 * Blog Single Elements Positioning
			 */
			$wp_customize->add_setting(
				'responsive_page_single_elements_positioning',
				array(
					'default'           => array( 'title', 'featured_image', 'content' ),
					'sanitize_callback' => 'responsive_sanitize_multi_choices',
				)
			);

			$wp_customize->add_control(
				new Responsive_Customizer_Sortable_Control(
					$wp_customize,
					'responsive_page_single_elements_positioning',
					array(
						'label'    => esc_html__( 'Post Elements', 'responsive' ),
						'section'  => 'responsive_page_section',
						'settings' => 'responsive_page_single_elements_positioning',
						'priority' => 10,
						'choices'  => responsive_blog_single_elements(),
					)
				)
			);
		}


	}

endif;

return new Responsive_layout_Customizer();
