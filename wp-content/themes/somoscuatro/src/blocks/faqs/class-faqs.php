<?php
/**
 * Block's main functionality methods.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme\Blocks\FAQs;

use Somoscuatro\Theme\Blocks\Block;

/**
 * Block main functionality.
 */
class FAQs extends Block {

	/**
	 * The prefix used for ACF blocks.
	 *
	 * @var string
	 */
	protected static $acf_block_prefix = 'block_faqs';

	/**
	 * Gets the ACF Block fields.
	 *
	 * @return array The ACF Block fields.
	 */
	public static function get_acf_fields(): array {
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
}
