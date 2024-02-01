<?php
/**
 * Abstract class for ACF Gutenberg Blocks.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme\Blocks;

use Timber\Timber;

/**
 * Abstract class for ACF Gutenberg Blocks.
 */
abstract class Block {

	/**
	 * The Timber context.
	 *
	 * @var array
	 */
	protected static $context = array();

	/**
	 * The prefix used for ACF Blocks.
	 *
	 * @var string
	 */
	protected static $acf_block_prefix = '';

	/**
	 * Registers activation hook callback.
	 *
	 * @implements register_activation_hook<Function>
	 */
	public static function init(): void {
		static::register_acf_block();
		static::$context = Timber::context();
	}

	/**
	 * Dummy method to get ACF Block fields.
	 *
	 * This method needs to be overridden by each Gutenberg block class.
	 */
	public static function get_acf_fields(): array {
		return array();
	}

	/**
	 * Registers the ACF Block.
	 */
	public static function register_acf_block(): void {
		register_block_type( __DIR__ . '/' . str_replace( '_', '-', str_replace( 'block_', '', static::$acf_block_prefix ) ) );

		if ( function_exists( 'acf_add_local_field_group' ) ) {
			acf_add_local_field_group( static::get_acf_fields() );
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
		static::$context = static::set_context( static::$context, $block, $is_preview );

		$block_dirname       = strtolower( explode( '\\', $block['render_callback'] )[3] );
		$block_template_path = __DIR__ . '/' . str_replace( '_', '-', $block_dirname ) . '/template.twig';

		Timber::render( $block_template_path, static::$context );
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
		unset( $block['data'] );
		$context['block'] = $block;

		$fields = get_fields();
		if ( $fields ) {
			$context = self::add_acf_fields_to_context( static::$acf_block_prefix, $context, $fields );
		}

		$context['is_preview'] = $is_preview;

		return $context;
	}

	/**
	 * Adds ACF fields to Timber context.
	 *
	 * @param string $block_prefix The ACF block prefix.
	 * @param array  $context The Timber context.
	 * @param array  $fields The ACF fields.
	 *
	 * @return array The Timber context with ACF fields.
	 */
	public static function add_acf_fields_to_context( string $block_prefix, array $context, array $fields ): array {
		$unprefixed_acf_fields = json_decode( str_replace( $block_prefix . '_', '', wp_json_encode( $fields ) ), true );

		return array_merge( $context, $unprefixed_acf_fields );
	}
}
