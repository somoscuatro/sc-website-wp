<?php
/**
 * Contains Somoscuatro\Theme\Theme Class.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme;

use Somoscuatro\Theme\Attributes\Action;
use Somoscuatro\Theme\Attributes\Filter;
use Somoscuatro\Theme\Blocks\Loader as BlocksLoader;
use Somoscuatro\Theme\Custom_Post_Types\Loader as CustomPostTypesLoader;
use Somoscuatro\Theme\Custom_Taxonomies\Loader as CustomTaxonomiesLoader;
use Somoscuatro\Theme\Helpers\Filesystem;

/**
 * Main Theme Functionality.
 */
class Theme {

	use Filesystem;

	/**
	 * The Custom_Post_Types\Loader Class.
	 *
	 * @var CustomPostTypesLoader
	 */
	private $custom_post_types_loader;

	/**
	 * The Custom_Taxonomies\Loader Class.
	 *
	 * @var CustomTaxonomiesLoader
	 */
	private $custom_taxonomies_loader;

	/**
	 * The Blocks\Loader Class.
	 *
	 * @var BlocksLoader
	 */
	private $blocks_loader;

	/**
	 * Theme Naming Prefix.
	 *
	 * @var string
	 */
	private $prefix = 'somoscuatro_theme';

	/**
	 * Class Constructor.
	 *
	 * @param CustomPostTypesLoader  $custom_post_types_loader The Custom_Post_Types\Loader Class.
	 * @param CustomTaxonomiesLoader $custom_taxonomies_loader The Custom_Taxonomies\Loader Class.
	 * @param BlocksLoader           $blocks_loader The Blocks\Loader Class.
	 */
	public function __construct(
		CustomPostTypesLoader $custom_post_types_loader,
		CustomTaxonomiesLoader $custom_taxonomies_loader,
		BlocksLoader $blocks_loader
	) {
		$this->custom_post_types_loader = $custom_post_types_loader;
		$this->custom_taxonomies_loader = $custom_taxonomies_loader;
		$this->blocks_loader            = $blocks_loader;
	}

	/**
	 * Initialization Method.
	 */
	#[Action( 'init' )]
	public function init(): void {
		$this->blocks_loader->load();
	}

	/**
	 * Registers Theme Support for Additional Features.
	 */
	#[Action( 'after_setup_theme' )]
	public function theme_support(): void {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );

		$this->custom_post_types_loader->load();
		$this->custom_taxonomies_loader->load();
	}

	/**
	 * Displays Missing Plugins Warning.
	 */
	#[Action( 'admin_notices' )]
	public function display_missing_plugins_warning(): void {
		if ( ! is_plugin_active( 'advanced-custom-fields/acf.php' ) && ! is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ) :
			?>
		<div class="error">
			<p>
				<?php
					echo wp_kses_post(
						sprintf(
							/* translators: %s plugin name and link to plugin vendor page. */
							__( '%s plugin is not installed. Please install the plugin to use the Somoscuatro Theme.', 'somoscuatro-theme' ),
							'<a href="https://www.advancedcustomfields.com/" target="_blank">Advanced Custom Fields (ACF)</a>'
						)
					);
				?>
			</p>
		</div>
			<?php
		endif;
	}

	/**
	 * Adds Page Slug to Body Classes.
	 *
	 * @param array $classes The Body Classes.
	 *
	 * @return array The Modified Body Classes.
	 */
	#[Filter( 'body_class' )]
	public function body_class( array $classes ): array {
		if ( is_single() || ( is_page() && ! is_front_page() ) ) {
			if ( ! in_array( basename( get_permalink() ), $classes, true ) ) {
				$classes[] = basename( get_permalink() );
			}
		}
		if ( is_page() && has_post_parent() ) {
			global $post;
			if ( ! in_array( basename( get_permalink( $post->post_parent ) ), $classes, true ) ) {
				$classes[] = basename( get_permalink( $post->post_parent ) );
			}
		}
		if ( is_404() ) {
			$classes[] = '404';
		}

		return $classes;
	}

	/**
	 * Returns the Theme Prefix.
	 *
	 * @return string The Theme Prefix.
	 */
	public function get_prefix(): string {
		return $this->prefix;
	}
}
