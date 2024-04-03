<?php
/**
 * Media management class.
 *
 * @package somoscuatro-theme
 */

namespace Somoscuatro\Theme;

use Somoscuatro\Theme\Attributes\Action;
use Somoscuatro\Theme\Attributes\Filter;

/**
 * Media management class.
 */
class Media {

	/**
	 * Allows SVG images in media uploader.
	 *
	 * @param array $mimes The supported mime types.
	 *
	 * @return array The modified mime types.
	 */
	#[Filter( 'upload_mimes' )]
	public function add_svg_support( array $mimes ): array {
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}

	/**
	 * Sets images compression quality.
	 *
	 * @return int The images compression quality.
	 */
	#[Filter( 'jpeg_quality', accepted_args: 10 )]
	public static function image_compression_quality(): int {
		return 100;
	}

	/**
	 * Disables WordPress default image sizes.
	 *
	 * @param array $sizes The WordPress image sizes.
	 *
	 * @return array The modified sizes.
	 */
	#[Filter( 'intermediate_image_sizes' )]
	public function disable_wp_default_image_sizes( array $sizes ): array {
		$targets = array( 'thumbnail', 'medium', 'medium_large', 'large', '1536x1536', '2048x2048' );

		foreach ( $sizes as $size_index => $size ) {
			if ( in_array( $size, $targets, true ) ) {
				unset( $sizes[ $size_index ] );
			}
		}

		return $sizes;
	}

	/**
	 * Registers custom images sizes.
	 */
	#[Action( 'init' )]
	public function register_image_sizes(): void {
		$sizes = array(
			'xs' => 60,
			'sm' => 240,
			'md' => 420,
			'lg' => 680,
			'xl' => 1024,
		);

		foreach ( $sizes as $key => $value ) {
			add_image_size( $key, $value );
			add_image_size( sprintf( '%s@2x', $key ), $key, $value * 2 );
			add_image_size( sprintf( '%s@3x', $key ), $key, $value * 3 );
		}
	}
}
