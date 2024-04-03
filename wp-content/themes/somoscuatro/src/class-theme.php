<?php
/**
 * Theme's main functionality methods.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme;

use Somoscuatro\Theme\Helpers\Filesystem;

use Somoscuatro\Theme\Attributes\Action;
use Somoscuatro\Theme\Attributes\Filter;

use Somoscuatro\Theme\Blocks\Loader as BlocksLoader;
use Somoscuatro\Theme\Dependency_Injection\Container_Interface as Dependencies;

/**
 * Main theme functionality.
 */
class Theme {

	use Filesystem;

	/**
	 * Theme naming prefix.
	 *
	 * @var string
	 */
	private $prefix = 'somoscuatro_theme';

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
	 * Initialization method.
	 */
	#[Action( 'init' )]
	public function init(): void {
		( new BlocksLoader( $this->dependencies ) )->load();
	}

	/**
	 * Registers theme support for additional features.
	 */
	#[Action( 'after_setup_theme' )]
	public function theme_support(): void {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );

		( new CustomPostTypeLoader( $this->dependencies ) )->load();
		( new CustomTaxonomyLoader( $this->dependencies ) )->load();
	}

	/**
	 * Displays missing plugins warning.
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
	 * Adds page slug to body classes.
	 *
	 * @param array $classes The body classes.
	 *
	 * @return array The modified body classes.
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
	 * Returns the theme prefix.
	 *
	 * @return string Theme the prefix.
	 */
	public function get_prefix(): string {
		return $this->prefix;
	}
}
