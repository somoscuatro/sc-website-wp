<?php
/**
 * WordPress Theme Customizer functionality.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme;

/**
 * WordPress Theme Customizer functionality.
 */
class Customizer {

	/**
	 * Adds custom page controls to the customizer.
	 *
	 * @param \WP_Customize_Manager $wp_customize WP_Customize_Manager instance.
	 */
	public static function add_customizer_custom_pages_controls( \WP_Customize_Manager $wp_customize ) {
		$pages = self::get_pages();

		// Section.
		$wp_customize->add_section(
			'custom_pages',
			array(
				'title'      => __( 'Custom Pages', 'somoscuatro-theme' ),
				'priority'   => 35,
				'capability' => 'edit_theme_options',
			)
		);
		$wp_customize->add_setting(
			'glossary_page',
			array(
				'default'    => '',
				'type'       => 'theme_mod',
				'capability' => 'edit_theme_options',
			)
		);
		$wp_customize->add_control(
			new \WP_Customize_Control(
				$wp_customize,
				'glossary_page',
				array(
					'label'    => __( 'Glossary Page', 'somoscuatro-theme' ),
					'section'  => 'custom_pages',
					'settings' => 'glossary_page',
					'type'     => 'select',
					'choices'  => $pages,
				),
			),
		);
	}

	/**
	 * Adds site footer controls to the customizer.
	 *
	 * @param \WP_Customize_Manager $wp_customize WP_Customize_Manager instance.
	 */
	public static function add_customizer_footer_controls( \WP_Customize_Manager $wp_customize ) {
		// Section.
		$wp_customize->add_section(
			'sitefooter',
			array(
				'title'      => __( 'Site Footer', 'somoscuatro-theme' ),
				'priority'   => 35,
				'capability' => 'edit_theme_options',
			)
		);

		$wp_customize->add_setting(
			'site_footer_claim',
			array(
				'default'    => '',
				'type'       => 'theme_mod',
				'capability' => 'edit_theme_options',
			)
		);
		$wp_customize->add_control(
			new \WP_Customize_Control(
				$wp_customize,
				'site_footer_claim',
				array(
					'label'    => __( 'Claim', 'somoscuatro-theme' ),
					'section'  => 'sitefooter',
					'settings' => 'site_footer_claim',
					'type'     => 'textarea',
				)
			)
		);

		$wp_customize->add_setting(
			'site_footer_email',
			array(
				'default'    => '',
				'type'       => 'theme_mod',
				'capability' => 'edit_theme_options',
			)
		);
		$wp_customize->add_control(
			new \WP_Customize_Control(
				$wp_customize,
				'site_footer_email',
				array(
					'label'    => __( 'Email', 'somoscuatro-theme' ),
					'section'  => 'sitefooter',
					'settings' => 'site_footer_email',
					'type'     => 'text',
				)
			)
		);
	}

	/**
	 * Adds 404 controls to the customizer.
	 *
	 * @param \WP_Customize_Manager $wp_customize WP_Customize_Manager instance.
	 */
	public static function add_customizer_404_controls( \WP_Customize_Manager $wp_customize ) {
		// Section.
		$wp_customize->add_section(
			'404',
			array(
				'title'      => __( '404', 'somoscuatro-theme' ),
				'priority'   => 45,
				'capability' => 'edit_theme_options',
			)
		);

		$wp_customize->add_setting(
			'404_image',
			array(
				'default'    => '',
				'type'       => 'theme_mod',
				'capability' => 'edit_theme_options',
			)
		);
		$wp_customize->add_control(
			new \WP_Customize_Media_Control(
				$wp_customize,
				'404_image',
				array(
					'label'     => __( 'Image', 'abacum-theme' ),
					'section'   => '404',
					'mime_type' => 'image',
					'settings'  => '404_image',
				),
			),
		);

		$wp_customize->add_setting(
			'404_text',
			array(
				'default'    => '',
				'type'       => 'theme_mod',
				'capability' => 'edit_theme_options',
			)
		);
		$wp_customize->add_control(
			new \WP_Customize_Control(
				$wp_customize,
				'404_text',
				array(
					'label'    => __( 'Text', 'somoscuatro-theme' ),
					'section'  => '404',
					'settings' => '404_text',
					'type'     => 'textarea',
				)
			)
		);
	}

	/**
	 * Retrieves all pages in site.
	 *
	 * @return array List of pages and their IDs.
	 */
	private static function get_pages(): array {
		$pages = get_pages();
		$pages = array_reduce(
			$pages,
			function ( $carry, $page ) {
				$carry[ $page->ID ] = $page->post_title;
				return $carry;
			},
			array()
		);
		return $pages;
	}
}
