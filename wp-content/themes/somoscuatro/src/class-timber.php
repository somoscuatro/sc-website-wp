<?php
/**
 * Timber management class.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme;

use Somoscuatro\Theme\Dependency_Injection\Container_Interface as Dependencies;
use Somoscuatro\Theme\Attributes\Action;
use Somoscuatro\Theme\Attributes\Filter;

use Timber\Timber as TimberLibrary;
use Twig\TwigFunction;
use Twig\Environment as TwigEnvironment;

/**
 * Timber management class.
 */
class Timber {

	/**
	 * Dependencies container.
	 *
	 * @var Dependencies
	 */
	private $dependencies;

	/**
	 * Class constructor.
	 *
	 * @param Dependencies $dependencies Dependencies container.
	 */
	public function __construct( Dependencies $dependencies ) {
		$this->dependencies = $dependencies;
	}

	/**
	 * Timber initialization.
	 *
	 * @throws \Exception If Timber class does not exist.
	 */
	#[Action( 'after_setup_theme', 9 )]
	public function init(): void {
		TimberLibrary::init();

		if ( ! class_exists( 'Timber' ) ) {
			throw new \Exception( 'Timber not found.' );
		}

		TimberLibrary::$dirname = array(
			'templates',
			'templates/components',
			'templates/parts',
		);
	}

	/**
	 * Adds additional variables to global context.
	 *
	 * @param array $context Timber context.
	 *
	 * @return array Global context data.
	 */
	#[Filter( 'timber/context' )]
	public function add_to_global_context( array $context ): array {
		$context['homepage_url'] = get_home_url();

		$context = $this->get_menus( $context );

		$context['logo']       = esc_url( get_stylesheet_directory_uri() ) . '/assets/images/logo.png';
		$context['logo_white'] = esc_url( get_stylesheet_directory_uri() ) . '/assets/images/logo-white.png';

		$context['site_footer_claim'] = get_theme_mod( 'site_footer_claim' );
		$context['site_footer_email'] = get_theme_mod( 'site_footer_email' );

		return $context;
	}

	/**
	 * Returns Timber context.
	 *
	 * @return array
	 */
	public function context(): array {
		return TimberLibrary::context();
	}

	/**
	 * Renders a given template.
	 *
	 * @param string $template Template path.
	 * @param array  $context  Context data.
	 */
	public function render(
		string $template,
		array $context = array(),
	): void {
		TimberLibrary::render( $template, $context );
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
	public function get_menus( array $context ): array {
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
	 * @param TwigEnvironment $twig The Twig Environment.
	 *
	 * @return TwigEnvironment The modified Twig Environment.
	 */
	#[Filter( 'timber/twig' )]
	public function extend_timber_functions( TwigEnvironment $twig ): TwigEnvironment {
		$twig->addFunction(
			new TwigFunction( 'enqueue_script', array( $this, 'enqueue_script' ) )
		);

		$twig->addFunction(
			new TwigFunction( 'get_static_asset', array( $this, 'get_static_asset' ) )
		);

		$twig->addFunction(
			new TwigFunction( 'get_image_srcset', array( $this, 'get_image_srcset' ) )
		);

		$twig->addFunction(
			new TwigFunction( 'get_server_request_uri', array( $this, 'get_server_request_uri' ) )
		);

		$twig->addFunction(
			new TwigFunction( 'get_color_name', array( $this, 'get_color_name' ) )
		);

		$twig->addFunction(
			new TwigFunction( 'get_foreground_color_name', array( $this, 'get_foreground_color_name' ) )
		);

		$twig->addFunction(
			new TwigFunction( 'get_latest_posts', array( $this, 'get_latest_posts' ) )
		);

		return $twig;
	}

	/**
	 * Enqueue block scripts.
	 *
	 * @param string $handle The script handle.
	 */
	public function enqueue_script( string $handle ): void {
		wp_enqueue_script( $handle );
	}

	/**
	 * Get static asset URL.
	 *
	 * @param string $rel_file_path The asset file path relative to the theme dir.
	 *
	 * @return string The asset URL.
	 */
	public function get_static_asset( string $rel_file_path ): string {
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
	public function get_image_srcset( array $sizes, array|string $allowed_sizes = array( 'xs', 'sm', 'md', 'lg', 'xl' ) ): array {
		$srcset = array();

		$min_widths = array(
			'xl' => '1440px',
			'lg' => '1280px',
			'md' => '1024px',
			'sm' => '768px',
			'xs' => '',
		);

		foreach ( $min_widths as $image_size => $min_width ) {
			if ( isset( $sizes[ $image_size ] ) && in_array( $image_size, $allowed_sizes, true ) ) {
				$srcset[] = array(
					'srcset'    => $sizes[ $image_size ],
					'srcset@2x' => $sizes[ $image_size . '@2x' ],
					'srcset@3x' => $sizes[ $image_size . '@3x' ],
					'media'     => '(min-width: ' . $min_width . ')',
					'width'     => $sizes[ $image_size . '-width' ],
					'height'    => $sizes[ $image_size . '-height' ],
				);
			}
		}

		return $srcset;
	}

	/**
	 * Gets the server request URI.
	 *
	 * @return string The server request URI.
	 */
	public function get_server_request_uri(): string {
		return strtok( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ?? '' ) ), '?' );
	}

	/**
	 * Gets a color name given its HEX value.
	 *
	 * @param string $color_hex The color HEX value.
	 *
	 * @return string|int|false The color name if found.
	 */
	public function get_color_name( string $color_hex ): string|int|false {
		$acf = $this->dependencies->get( 'ACF' );

		$color_palette = $acf->get_color_palette();
		return array_search( strtoupper( $color_hex ), $color_palette, true );
	}

	/**
	 * Gets the foreground color name given a background color name.
	 *
	 * @param string $background_color_name The background color name.
	 *
	 * @return string The foreground color name.
	 */
	public function get_foreground_color_name( $background_color_name ): string {
		$acf = $this->dependencies->get( 'ACF' );

		$dark_colors = $acf->get_safe_bg_colors_names()['dark'];
		return in_array( 'bg-' . $background_color_name, $dark_colors, true ) ? 'anti-flash-white-100' : 'anti-flash-white-900';
	}

	/**
	 * Gets the latest posts.
	 *
	 * @param ?int $posts_per_page The number of posts to retrieve.
	 *
	 * @return \Timber\PostCollectionInterface|null The latest posts.
	 */
	public function get_latest_posts( ?int $posts_per_page = 3 ): \Timber\PostCollectionInterface|null {
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
