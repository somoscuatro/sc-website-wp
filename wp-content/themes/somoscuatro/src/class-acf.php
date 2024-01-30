<?php
/**
 * ACF custom functionality.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme;

use Somoscuatro\Theme\Helpers\Setup;

/**
 * ACF custom functionality.
 */
class ACF {

	use Setup;

	/**
	 * The ACF color palette.
	 *
	 * @var array
	 */
	public static $acf_color_palette = array();

	/**
	 * The allowed colors palette for ACF Block background.
	 *
	 * @var array
	 */
	public static $acf_bg_color_palette = array();

	/**
	 * ACF custom functionality.
	 */
	public static function init(): void {
		// Gets color palette from a JSON file.
		self::$acf_color_palette    = self::get_color_palette();
		self::$acf_bg_color_palette = self::get_bg_safe_color_palette( self::$acf_color_palette, self::get_safe_bg_colors_names()['colors'] );

		// Restricts the ACF color picker palette.
		add_action( 'acf/input/admin_footer', __CLASS__ . '::restrict_color_picker_palette' );
	}

	/**
	 * Gets color palette from a JSON file.
	 *
	 * @return array The color palette file content.
	 */
	public static function get_color_palette(): array {
		$tailwind_colors = wp_json_file_decode(
			self::get_base_path() . '/tailwind.colors.json',
			array( 'associative' => true )
		);

		$colors_palette = array();
		foreach ( $tailwind_colors as $color_name => $color_shades ) {
			foreach ( $color_shades as $color_shade => $hex ) {
				$colors_palette[ $color_name . '-' . $color_shade ] = $hex;
			}
		}

		return $colors_palette;
	}

	/**
	 * Gets the safe background colors name from Tailwind config JSON file.
	 *
	 * @return array The safe background colors name.
	 */
	public static function get_safe_bg_colors_names(): array {
		$safe_bg_colors = wp_json_file_decode(
			self::get_base_path() . '/tailwind.safe-bg-colors.json',
			array( 'associative' => true )
		);

		return $safe_bg_colors;
	}

	/**
	 * Reduces a given color palette to the background safe colors.
	 *
	 * @param array $color_palette The Tailwind color palette.
	 * @param array $safe_bg_colors The safe background colors name.
	 *
	 * @return array The background safe color palette.
	 */
	public static function get_bg_safe_color_palette( array $color_palette, array $safe_bg_colors ): array {
		return array_filter(
			$color_palette,
			function ( $color ) use ( $safe_bg_colors ) {
				return in_array( 'bg-' . $color, $safe_bg_colors, true );
			},
			ARRAY_FILTER_USE_KEY
		);
	}

	/**
	 * Restricts the ACF color picker palette.
	 */
	public static function restrict_color_picker_palette(): void {
		$palette = implode( "','", array_values( self::$acf_bg_color_palette ) );
		?>
		<script type="text/javascript">
			(function() {
				acf.add_filter('color_picker_args', function( args, $field ){
					args.palettes = ['<?php echo $palette; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>']
					return args;
				});
			})(jQuery);
			</script>
		<?php
	}
}
