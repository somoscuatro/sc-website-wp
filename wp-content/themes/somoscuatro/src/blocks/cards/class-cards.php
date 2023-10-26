<?php
/**
 * Block's main functionality methods.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme\Blocks\Cards;

use Somoscuatro\Theme\Helpers\Blocks;
use Timber\Timber;

/**
 * Block main functionality.
 */
class Cards {

	use Blocks;

	/**
	 * The Timber context.
	 *
	 * @var array
	 */
	private static $context = array();

	/**
	 * The prefix used for ACF blocks.
	 *
	 * @var string
	 */
	private static $acf_block_prefix = 'block_cards';

	/**
	 * Registers activation hook callback.
	 *
	 * @implements register_activation_hook<Function>
	 */
	public static function init() {
		self::register_acf_block();
		self::$context = Timber::context();
	}

	/**
	 * Registers ACF block.
	 */
	public static function register_acf_block() {
		register_block_type( __DIR__ );

		if ( function_exists( 'acf_add_local_field_group' ) ) {
			acf_add_local_field_group(
				array(
					'key'      => 'group_' . self::$acf_block_prefix,
					'title'    => __( 'Block: Cards', 'somoscuatro-theme' ),
					'fields'   => array(
						array(
							'key'   => 'field_ ' . self::$acf_block_prefix . '_heading',
							'label' => 'Heading',
							'name'  => self::$acf_block_prefix . '_heading',
							'type'  => 'text',
						),
						array(
							'key'          => 'field_ ' . self::$acf_block_prefix . '_cards',
							'label'        => __( 'Cards', 'somoscuatro-theme' ),
							'name'         => self::$acf_block_prefix . '_cards',
							'type'         => 'repeater',
							'required'     => true,
							'layout'       => 'row',
							'button_label' => __( 'Add Card', 'somoscuatro-theme' ),
							'sub_fields'   => array(
								array(
									'key'             => 'field_ ' . self::$acf_block_prefix . '_card_image',
									'label'           => __( 'Image', 'somoscuatro-theme' ),
									'name'            => self::$acf_block_prefix . '_card_image',
									'type'            => 'image',
									'parent_repeater' => 'field_ ' . self::$acf_block_prefix . '_cards',
								),
								array(
									'key'             => 'field_ ' . self::$acf_block_prefix . '_card_heading',
									'label'           => __( 'Heading', 'somoscuatro-theme' ),
									'name'            => self::$acf_block_prefix . '_card_heading',
									'type'            => 'text',
									'required'        => true,
									'parent_repeater' => 'field_ ' . self::$acf_block_prefix . '_cards',
								),
								array(
									'key'             => 'field_ ' . self::$acf_block_prefix . '_card_text',
									'label'           => __( 'Text', 'somoscuatro-theme' ),
									'name'            => self::$acf_block_prefix . '_card_text',
									'type'            => 'textarea',
									'required'        => true,
									'parent_repeater' => 'field_ ' . self::$acf_block_prefix . '_cards',
								),
							),
						),
					),
					'location' => array(
						array(
							array(
								'param'    => 'block',
								'operator' => '==',
								'value'    => 'acf/cards',
							),
						),
					),
				)
			);
		}
	}

	/**
	 * Renders block Twig template.
	 *
	 * @param array   $block The Gutenberg block.
	 * @param string  $content The content of the block.
	 * @param boolean $is_preview True if in preview mode.
	 */
	public static function render_callback( array $block, string $content = '', bool $is_preview = false ): void {
		self::$context = self::set_context( self::$context, $block, $is_preview );

		Timber::render( 'template.twig', self::$context );
	}

	/**
	 * Sets block context.
	 *
	 * @param array   $context The Timber context.
	 * @param array   $block The Gutenberg block.
	 * @param boolean $is_preview True if in preview mode.
	 *
	 * @return array The modified Timber context.
	 */
	public static function set_context( array $context, array $block, bool $is_preview ): array {
		$context['block']      = $block;
		$context['is_preview'] = $is_preview;

		$fields = get_fields();
		if ( $fields ) {
			$context = array_merge( $context, self::add_acf_fields_to_context( self::$acf_block_prefix, $context, $fields ) );

			$cards = array();
			foreach ( $fields[ self::$acf_block_prefix . '_cards' ] as $card ) {
				$cards[] = array_combine(
					array_map(
						function( $key ) {
							return str_replace( self::$acf_block_prefix . '_card_', '', $key );
						},
						array_keys( $card )
					),
					$card
				);
			}
			$context['cards'] = $cards;
		}

		return $context;
	}
}
