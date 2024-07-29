<?php
/**
 * Contains Somoscuatro\Theme\Blocks\FAQs\FAQs Class.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme\Blocks\FAQs;

use Somoscuatro\Theme\Blocks\Block;

/**
 * Block Main Functionality.
 */
class FAQs extends Block {

	/**
	 * The Prefix Used for ACF Blocks.
	 *
	 * @var string
	 */
	public static $acf_block_prefix = 'block_faqs';

	/**
	 * Gets the ACF Block Fields.
	 *
	 * @return array The ACF Block Fields.
	 */
	public function get_acf_fields(): array {
		return array(
			'key'      => 'group_' . self::$acf_block_prefix,
			'title'    => __( 'Block: CTA', 'somoscuatro-theme' ),
			'fields'   => array(
				array(
					'key'           => 'field_' . self::$acf_block_prefix . '_bg_color',
					'label'         => __( 'Background Color', 'somoscuatro-theme' ),
					'name'          => self::$acf_block_prefix . '_bg_color',
					'type'          => 'color_picker',
					'required'      => 1,
					'return_format' => 'string',
				),
				array(
					'key'      => 'field_' . self::$acf_block_prefix . '_title',
					'label'    => __( 'Title', 'somoscuatro-theme' ),
					'name'     => self::$acf_block_prefix . '_title',
					'type'     => 'text',
					'required' => true,
				),
				array(
					'key'      => 'field_' . self::$acf_block_prefix . '_text',
					'label'    => __( 'Text', 'somoscuatro-theme' ),
					'name'     => self::$acf_block_prefix . '_text',
					'type'     => 'textarea',
					'required' => true,
				),
				array(
					'key'         => 'field_' . self::$acf_block_prefix . '_faqs',
					'label'       => __( 'FAQs', 'somoscuatro-theme' ),
					'name'        => self::$acf_block_prefix . '_faqs',
					'type'        => 'relationship',
					'required'    => true,
					'post_type'   => array(
						0 => 'faq',
					),
					'post_status' => array(
						0 => 'publish',
					),
					'taxonomy'    => '',
					'filters'     => array(
						0 => 'search',
					),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'block',
						'operator' => '==',
						'value'    => 'acf/faqs',
					),
				),
			),
		);
	}

	/**
	 * Register Block Assets.
	 */
	public function register_assets(): void {
		wp_register_script(
			'alpine',
			'https://unpkg.com/alpinejs@3.14.1/dist/cdn.min.js',
			array( 'alpine-intersect' ),
			'3.14.1',
			array(
				'footer'   => false,
				'strategy' => 'defer',
			)
		);
	}
}
