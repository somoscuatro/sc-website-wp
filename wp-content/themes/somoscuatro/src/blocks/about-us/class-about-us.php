<?php
/**
 * Block's main functionality methods.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme\Blocks\About_Us;

use Somoscuatro\Theme\Blocks\Block;

/**
 * Block main functionality.
 */
class About_Us extends Block {

	/**
	 * The prefix used for ACF blocks.
	 *
	 * @var string
	 */
	protected static $acf_block_prefix = 'block_about_us';

	/**
	 * Gets the ACF Block fields.
	 *
	 * @return array The ACF Block fields.
	 */
	public static function get_acf_fields(): array {
		return array(
			'key'      => 'group_' . self::$acf_block_prefix,
			'title'    => __( 'Block: About Us', 'somoscuatro-theme' ),
			'fields'   => array(
				array(
					'key'      => 'field_' . self::$acf_block_prefix . '_text',
					'label'    => __( 'Text', 'somoscuatro-theme' ),
					'name'     => self::$acf_block_prefix . '_text',
					'type'     => 'textarea',
					'required' => true,
				),
				array(
					'key'          => 'field_' . self::$acf_block_prefix . '_customers_logos',
					'label'        => 'Customers Logos',
					'name'         => self::$acf_block_prefix . '_customers_logos',
					'type'         => 'repeater',
					'layout'       => 'row',
					'min'          => 6,
					'max'          => 6,
					'button_label' => 'Add Customer Logo',
					'sub_fields'   => array(
						array(
							'key'             => 'field_' . self::$acf_block_prefix . '_customer_logo',
							'label'           => 'Customer Logo',
							'name'            => self::$acf_block_prefix . '_customer_logo',
							'type'            => 'image',
							'parent_repeater' => 'field_' . self::$acf_block_prefix . '_customers_logos',
						),
					),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'block',
						'operator' => '==',
						'value'    => 'acf/about-us',
					),
				),
			),
		);
	}
}
