<?php
/**
 * Contains Somoscuatro\Theme\Blocks\Glossary_Term_Content\Glossary_Term_Content Class.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme\Blocks\Glossary_Term_Content;

use Somoscuatro\Theme\Blocks\Block;

/**
 * Block Main Functionality.
 */
class Glossary_Term_Content extends Block {

	/**
	 * The Prefix Used for ACF Blocks.
	 *
	 * @var string
	 */
	public static $acf_block_prefix = 'block_glossary_term_content';

	/**
	 * Gets the ACF Block Fields.
	 *
	 * @return array The ACF Block Fields.
	 */
	public function get_acf_fields(): array {
		return array(
			'key'      => 'group_' . self::$acf_block_prefix,
			'title'    => __( 'Block: Glossary Term Content', 'somoscuatro-theme' ),
			'fields'   => array(
				array(
					'key'      => 'field_' . self::$acf_block_prefix . '_content',
					'label'    => __( 'Content', 'somoscuatro-theme' ),
					'name'     => self::$acf_block_prefix . '_content',
					'type'     => 'wysiwyg',
					'required' => true,
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'block',
						'operator' => '==',
						'value'    => 'acf/glossary-term-content',
					),
				),
			),
		);
	}
}
