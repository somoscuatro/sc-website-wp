<?php
/**
 * Helpers methods related to Gutenberg blocks.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme\Helpers;

/**
 * Helpers methods related to Gutenberg blocks.
 */
trait Blocks {

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
		foreach ( $fields as $key => $field ) {
			$context[ str_replace( $block_prefix . '_', '', $key ) ] = $field;
		}

		return $context;
	}
}
