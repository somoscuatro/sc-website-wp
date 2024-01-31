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
}
