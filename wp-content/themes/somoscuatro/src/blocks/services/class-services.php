<?php
/**
 * Contains Somoscuatro\Theme\Blocks\Services\Services Class.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme\Blocks\Services;

use Somoscuatro\Theme\Blocks\Block;

/**
 * Block Main Functionality.
 */
class Services extends Block {

	/**
	 * The Prefix Used for ACF Blocks.
	 *
	 * @var string
	 */
	public static $acf_block_prefix = 'block_services';

	/**
	 * Gets the ACF Block Fields.
	 *
	 * @return array The ACF Block Fields.
	 */
	public function get_acf_fields(): array {
		return array(
			'key'      => 'group_' . self::$acf_block_prefix,
			'title'    => __( 'Block: Services', 'somoscuatro-theme' ),
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
					'key'         => 'field_' . self::$acf_block_prefix . '_services',
					'label'       => __( 'Services', 'somoscuatro-theme' ),
					'name'        => self::$acf_block_prefix . '_services',
					'type'        => 'relationship',
					'required'    => true,
					'post_type'   => array(
						0 => 'service',
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
						'value'    => 'acf/services',
					),
				),
			),
		);
	}
}
