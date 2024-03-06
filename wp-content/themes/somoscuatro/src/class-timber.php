<?php
/**
 * Timber main functionality.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme;

use Timber\Timber as TimberLibrary;
use Twig\TwigFunction;

/**
 * Timber configuration.
 */
class Timber {

	/**
	 * Timber initialization.
	 *
	 * @throws \Exception If Timber class does not exist.
	 */
	public static function init(): void {
		TimberLibrary::init();

		if ( ! class_exists( 'Timber' ) ) {
			throw new \Exception( 'Timber not found.' );
		}

		TimberLibrary::$dirname = array(
			'templates',
			'templates/components',
			'templates/partials',
		);

		// Adds additional variables to global context.
		add_filter( 'timber/context', __CLASS__ . '::add_to_global_context' );

		// Adds custom functions to Twig.
		add_filter( 'timber/twig', __CLASS__ . '::extend_timber_functions' );
	}

	/**
	 * Adds additional variables to global context.
	 *
	 * @param array $context Timber context.
	 *
	 * @return array Global context data.
	 */
	public static function add_to_global_context( array $context ): array {
		$context['homepage_url'] = get_home_url();

		$context['logo']       = esc_url( get_stylesheet_directory_uri() ) . '/assets/images/logo.png';
		$context['logo_white'] = esc_url( get_stylesheet_directory_uri() ) . '/assets/images/logo-white.png';

		$context['site_footer_claim'] = get_theme_mod( 'site_footer_claim' );
		$context['site_footer_email'] = get_theme_mod( 'site_footer_email' );

		$context = self::get_menus( $context );

		return $context;
	}

	/**
	 * Adds registered menus to Timber global context.
	 *
	 * As documented in
	 * https://timber.github.io/docs/v2/guides/menus/#set-up-all-menus-globally
	 * Timber allows to add the registered menu to the global context. For unknown
	 * reasons, this is not fully working for us since the current menu item is
	 * not set (always false) and WordPress current item classes (e.g.
	 * current-menu-item) are not added.
	 *
	 * @param array $context The Timber global context.
	 *
	 * @return array The updated Timber global context.
	 */
	public static function get_menus( array $context ): array {
		foreach ( array_keys( get_registered_nav_menus() ) as $location ) {
			if ( ! has_nav_menu( $location ) ) {
				continue;
			}

			$context[ $location ] = TimberLibrary::get_menu( $location );
		}

		return $context;
	}

	/**
	 * Adds custom functions to Twig.
	 *
	 * @param \Twig\Environment $twig The Twig Environment.
	 *
	 * @return \Twig\Environment The modified Twig Environment.
	 *
	 * @phpstan-ignore-next-line
	 */
	public static function extend_timber_functions( \Twig\Environment $twig ): \Twig\Environment {
		// @phpstan-ignore-next-line
		$twig->addFunction(
			// @phpstan-ignore-next-line
			new TwigFunction( 'enqueue_script', __CLASS__ . '::enqueue_script' )
		);

		// @phpstan-ignore-next-line
		$twig->addFunction(
			// @phpstan-ignore-next-line
			new TwigFunction( 'get_static_asset', __CLASS__ . '::get_static_asset' )
		);

		// @phpstan-ignore-next-line
		$twig->addFunction(
			// @phpstan-ignore-next-line
			new TwigFunction( 'get_image_srcset', __CLASS__ . '::get_image_srcset' )
		);

		// @phpstan-ignore-next-line
		$twig->addFunction(
			// @phpstan-ignore-next-line
			new TwigFunction( 'get_server_request_uri', __CLASS__ . '::get_server_request_uri' )
		);

		// @phpstan-ignore-next-line
		$twig->addFunction(
			// @phpstan-ignore-next-line
			new TwigFunction( 'get_color_name', __CLASS__ . '::get_color_name' )
		);

		// @phpstan-ignore-next-line
		$twig->addFunction(
			// @phpstan-ignore-next-line
			new TwigFunction( 'get_foreground_color_name', __CLASS__ . '::get_foreground_color_name' )
		);

		// @phpstan-ignore-next-line
		$twig->addFunction(
			// @phpstan-ignore-next-line
			new TwigFunction( 'get_latest_posts', __CLASS__ . '::get_latest_posts' )
		);

		return $twig;
	}

	/**
	 * Enqueue block scripts.
	 *
	 * @param string $handle The script handle.
	 */
	public static function enqueue_script( string $handle ): void {
		wp_enqueue_script( $handle );
	}

	/**
	 * Get static asset URL.
	 *
	 * @param string $rel_file_path The asset file path relative to the theme dir.
	 *
	 * @return string The asset URL.
	 */
	public static function get_static_asset( string $rel_file_path ): string {
		return esc_url( get_stylesheet_directory_uri() ) . "/$rel_file_path";
	}

	/**
	 * Gets images source sets.
	 *
	 * @param array        $sizes The WordPress image sizes.
	 * @param array|string $allowed_sizes The image sizes to generate for this particular image.
	 *
	 * @return array The image source set.
	 */
	public static function get_image_srcset( array $sizes, array|string $allowed_sizes = array( 'xs', 'sm', 'md', 'lg', 'xl' ) ): array {
		$srcset = array();

		if ( isset( $sizes['xl'] ) && in_array( 'xl', $allowed_sizes, true ) ) {
			$srcset[] = array(
				'srcset'    => $sizes['xl'],
				'srcset@2x' => $sizes['xl@2x'],
				'srcset@3x' => $sizes['xl@3x'],
				'media'     => '(min-width: 1440px)',
				'width'     => $sizes['xl-width'],
				'height'    => $sizes['xl-height'],
			);
		}

		if ( isset( $sizes['lg'] ) && in_array( 'lg', $allowed_sizes, true ) ) {
			$srcset[] = array(
				'srcset'    => $sizes['lg'],
				'srcset@2x' => $sizes['lg@2x'],
				'srcset@3x' => $sizes['lg@3x'],
				'media'     => '(min-width: 1280px)',
				'width'     => $sizes['lg-width'],
				'height'    => $sizes['lg-height'],
			);
		}

		if ( isset( $sizes['md'] ) && in_array( 'md', $allowed_sizes, true ) ) {
			$srcset[] = array(
				'srcset'    => $sizes['md'],
				'srcset@2x' => $sizes['md@2x'],
				'srcset@3x' => $sizes['md@3x'],
				'media'     => '(min-width: 1024px)',
				'width'     => $sizes['md-width'],
				'height'    => $sizes['md-height'],
			);
		}

		if ( isset( $sizes['sm'] ) && in_array( 'sm', $allowed_sizes, true ) ) {
			$srcset[] = array(
				'srcset'    => $sizes['sm'],
				'srcset@2x' => $sizes['sm@2x'],
				'srcset@3x' => $sizes['sm@3x'],
				'media'     => '(min-width: 768px)',
				'width'     => $sizes['sm-width'],
				'height'    => $sizes['sm-height'],
			);
		}

		if ( isset( $sizes['xs'] ) && in_array( 'xs', $allowed_sizes, true ) ) {
			$srcset[] = array(
				'srcset'    => $sizes['xs'],
				'srcset@2x' => $sizes['xs@2x'],
				'srcset@3x' => $sizes['xs@3x'],
				'media'     => '',
				'width'     => $sizes['xs-width'],
				'height'    => $sizes['xs-height'],
			);
		}

		return $srcset;
	}

	/**
	 * Gets the server request URI.
	 *
	 * @return string The server request URI.
	 */
	public static function get_server_request_uri(): string {
		return strtok( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ?? '' ) ), '?' );
	}

	/**
	 * Gets a color name given its HEX value.
	 *
	 * @param string $color_hex The color HEX value.
	 *
	 * @return string|int|false The color name if found.
	 */
	public static function get_color_name( string $color_hex ): string|int|false {
		$color_palette = ACF::get_color_palette();
		return array_search( strtoupper( $color_hex ), $color_palette, true );
	}

	/**
	 * Gets the foreground color name given a background color name.
	 *
	 * @param string $background_color_name The background color name.
	 *
	 * @return string The foreground color name.
	 */
	public static function get_foreground_color_name( $background_color_name ): string {
		$dark_colors = ACF::get_safe_bg_colors_names()['dark'];
		return in_array( 'bg-' . $background_color_name, $dark_colors, true ) ? 'anti-flash-white-100' : 'anti-flash-white-900';
	}

	/**
	 * Gets the latest posts.
	 *
	 * @param ?int $posts_per_page The number of posts to retrieve.
	 *
	 * @return \Timber\PostCollectionInterface|null The latest posts.
	 */
	public static function get_latest_posts( ?int $posts_per_page = 3 ): \Timber\PostCollectionInterface|null {
		return TimberLibrary::get_posts(
			array(
				'post_type'      => 'post',
				'post_status'    => 'publish',
				'posts_per_page' => $posts_per_page,
				'order'          => 'DESC',
				'orderby'        => 'ID',
			)
		);
	}
}
