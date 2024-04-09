<?php
/**
 * Contains Somoscuatro\Theme\Customizer Class.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme;

use Somoscuatro\Theme\Attributes\Action;

/**
 * WordPress Theme Customizer Functionality.
 */
class Customizer {

	/**
	 * Adds Custom Page Controls to the Customizer.
	 *
	 * @param \WP_Customize_Manager $wp_customize WP_Customize_Manager Instance.
	 */
	#[Action( 'customize_register' )]
	public function add_customizer_custom_pages_controls( \WP_Customize_Manager $wp_customize ) {
		$pages = $this->get_pages();

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
	 * Adds Site Footer Controls to the Customizer.
	 *
	 * @param \WP_Customize_Manager $wp_customize WP_Customize_Manager Instance.
	 */
	#[Action( 'customize_register' )]
	public function add_customizer_footer_controls( \WP_Customize_Manager $wp_customize ) {
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
	 * Adds 404 Controls to the Customizer.
	 *
	 * @param \WP_Customize_Manager $wp_customize WP_Customize_Manager Instance.
	 */
	#[Action( 'customize_register' )]
	public function add_customizer_404_controls( \WP_Customize_Manager $wp_customize ) {
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
					'label'     => __( 'Image', 'somoscuatro-theme' ),
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
	 * Adds Google Tag Manager Controls to the Customizer.
	 *
	 * @param \WP_Customize_Manager $wp_customize WP_Customize_Manager Instance.
	 */
	#[Action( 'customize_register' )]
	public function add_customizer_gtm_controls( \WP_Customize_Manager $wp_customize ) {
		// Section.
		$wp_customize->add_section(
			'gtm',
			array(
				'title'      => __( 'Google Tag Manager', 'somoscuatro-theme' ),
				'priority'   => 35,
				'capability' => 'edit_theme_options',
			)
		);
		$wp_customize->add_setting(
			'gtm_id',
			array(
				'default'    => '',
				'type'       => 'theme_mod',
				'capability' => 'edit_theme_options',
			)
		);
		$wp_customize->add_control(
			new \WP_Customize_Control(
				$wp_customize,
				'gtm_id',
				array(
					'label'    => __( 'GTM ID', 'somoscuatro-theme' ),
					'section'  => 'gtm',
					'settings' => 'gtm_id',
					'type'     => 'text',
				),
			),
		);
	}

	/**
	 * Retrieves All Pages in Site.
	 *
	 * @return array List of Pages and Their IDs.
	 */
	private function get_pages(): array {
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
